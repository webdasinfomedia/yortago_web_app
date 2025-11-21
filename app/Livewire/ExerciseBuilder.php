<?php

namespace App\Livewire;

use App\Models\ExerciseList;
use App\Models\AlternateExerciseList;
use App\Models\NewExercise;
use App\Models\NewExerciseWeek;
use App\Models\NewExerciseWeekDay;
use App\Models\NewExerciseWeekDayItem;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ExerciseBuilder extends Component
{
    public $exerciseId;
    public $exercise;
    public $exerciseLists = [];
    public $weeks = [];
    public $selectedWeekId = null;
    public $selectedDayId = null;
    public $activeWeekAccordion = null;
    public $alternates = [];
    public $alternatePivotIds = [];

    // Day title modal properties
    public $showTitleModal = false;
    public $editingDayId = null;
    public $dayTitle = '';
    public $daySummary = '';
    public $dayDuration = '';
    protected $listeners = [
        'select2-updated' => 'updateExerciseSelect'
    ];

    public function mount($exerciseId)
    {
        $this->exerciseId = decrypt($exerciseId);
        
        // Cache exercise lists for 1 hour to reduce queries
        $this->exerciseLists = Cache::remember('exercise_lists_all', 3600, function () {
            return ExerciseList::orderBy('name')->get();
        });
        
        $this->exercise = NewExercise::findOrFail($this->exerciseId);
        
        $this->initializeExerciseStructure();
        $this->loadWeeks();
        $this->populateAlternates();
        $this->populateAlternatePivotIds();
        $this->autoSelectFirstWeekAndDay();
    }
    private function initializeExerciseStructure()
    {
        // Always check and create structure - even if weeks exist, they might not have complete structure
        $weekCount = $this->exercise->weeks()->count();
       
        
        if ($weekCount === 0) {
            
            $this->createDefaultWeekStructure();
        } else {
            // Check if existing weeks have proper day structure
            $this->ensureWeeksHaveProperDayStructure();
        }
    }
    private function populateAlternatePivotIds()
{
    foreach ($this->weeks as $week) {
        foreach ($week['days'] as $day) {
            foreach ($day['exercises'] as $exercise) {
                foreach ($exercise['alternates'] as $alt) {
                    $this->alternatePivotIds[$alt['id']] = $alt['pivot_id'];
                }
            }
        }
    }
}
    
private function populateAlternates()
    {
        $this->alternates = [];

        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                foreach ($day['exercises'] as $exercise) {
                    foreach ($exercise['alternates'] as $alt) {
                        $this->alternates[$alt['id']] = [
                            'id' => $alt['id'],
                            'pivot_id' => $alt['pivot_id'],
                            'name' => $alt['name'],
                            'exercise_list_id' => $alt['exercise_list_id'],
                            'sets' => $alt['sets'] ?? null,
                            'reps' => $alt['reps'] ?? null,
                            'rest' => $alt['rest'] ?? null,
                            'tempo' => $alt['tempo'] ?? null,
                            'intensity' => $alt['intensity'] ?? null,
                            'weight' => $alt['weight'] ?? 'No',
                            'weight_value' => $alt['weight_value'] ?? null,
                            'notes' => strip_tags(html_entity_decode($alt['notes'] ?? null)),
                        ];
                    }
                }
            }
        }
    }
    
   private function ensureWeeksHaveProperDayStructure()
    {
        $weeks = $this->exercise->weeks()->get();

        foreach ($weeks as $weekIndex => $week) {
            if ($week->week_number <= 0) {
                $week->update(['week_number' => $weekIndex + 1]);
            }
            
            $existingDays = $week->days()->orderBy('id')->get();
            $dayCount = $existingDays->count();

            foreach ($existingDays as $dayIndex => $day) {
                if ($day->day_number <= 0) {
                    $day->update(['day_number' => $dayIndex + 1]);
                }
                
                $exercises = $day->exerciseItems()->orderBy('id')->get();
                foreach ($exercises as $exIndex => $exercise) {
                    if ($exercise->item_id <= 0) {
                        $exercise->update(['item_id' => $exIndex + 1]);
                    }
                }
            }

            if ($dayCount <= 2) {
                $daysToCreate = [];
                for ($dayNumber = $dayCount + 1; $dayNumber <= 7; $dayNumber++) {
                    $daysToCreate[] = [
                        'new_exercise_week_id' => $week->id,
                        'day_number' => $dayNumber,
                        'title' => 'Day ' . $dayNumber . ' Workout',
                        'summary' => "",
                        'duration' => 30,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                
                if (!empty($daysToCreate)) {
                    NewExerciseWeekDay::insert($daysToCreate);
                }
            }
        }
    }

    // Create first week with default 7 days
     private function createDefaultWeekStructure()
    {
        $existingWeeks = NewExerciseWeek::where('new_exercise_id', $this->exerciseId)->count();
        if ($existingWeeks > 0) return;

        $week = NewExerciseWeek::create([
            'new_exercise_id' => $this->exerciseId,
            'week_number' => 1,
        ]);

        $this->ensureWeekHasDays($week);
    }

    // OPTIMIZED loadWeeks method - CRITICAL FIX for N+1 queries
    private function loadWeeks()
    {
        // Single query with all necessary relationships eager loaded
        $this->weeks = $this->exercise->weeks()
            ->with([
                'days' => function($query) {
                    $query->orderBy('day_number');
                },
                'days.exerciseItems' => function($query) {
                    $query->orderBy('item_id');
                },
                'days.exerciseItems.exercise_list',
                'days.exerciseItems.alternateExercises' => function($query) {
                    $query->select('alternate_exercise_lists.*');
                }
            ])
            ->orderBy('week_number')
            ->get()
            ->map(function ($week, $index) {
                $weekNumber = $week->week_number > 1 ? $week->week_number : ($index + 1);
                
                return [
                    'id' => $week->id,
                    'number' => $weekNumber,
                    'days' => $week->days->map(function ($day, $dayIndex) {
                        $dayNumber = $day->day_number > 1 ? $day->day_number : ($dayIndex + 1);
                        
                        return [
                            'id' => $day->id,
                            'number' => $dayNumber,
                            'title' => $day->title ?: "Day {$dayNumber}",
                            'summary' => $day->summary ?: '',
                            'duration' => $day->duration ?: '',
                            'exercises' => $day->exerciseItems->map(function ($ex, $exIndex) {
                                $itemId = $ex->item_id > 0 ? $ex->item_id : ($exIndex + 1);
                                
                                // Get linked alternate IDs in single query (already eager loaded)
                                $linkedAlternateIds = $ex->alternateExercises->pluck('id')->toArray();
                                
                                // Map linked alternates with their pivot data
                                $linkedAlternates = $ex->alternateExercises->map(function($alt) {
                                    return [
                                        'id' => $alt->id,
                                        'pivot_id' => $alt->pivot->id,
                                        'name' => $alt->name,
                                        'exercise_list_id' => $alt->exercise_list_id,
                                        'sets' => $alt->pivot->sets,
                                        'reps' => $alt->pivot->reps,
                                        'rest' => $alt->pivot->rest,
                                        'tempo' => $alt->pivot->tempo,
                                        'intensity' => $alt->pivot->intensity,
                                        'weight' => $alt->pivot->weight ?? $alt->weight ?? 'No',
                                        'weight_value' => $alt->pivot->weight_value ?? $alt->weight_value,
                                        'notes' => strip_tags(html_entity_decode($alt->pivot->notes ?? $alt->notes ?? '')), 
                                        'image' => $alt->image,
                                    ];
                                })->toArray();
                                
                                // Check for available alternates (cached for performance)
                                $hasAvailableAlternates = false;
                                if ($ex->exercise_list_id) {
                                    $cacheKey = "available_alternates_{$ex->exercise_list_id}_" . md5(implode(',', $linkedAlternateIds));
                                    
                                    $hasAvailableAlternates = Cache::remember($cacheKey, 300, function() use ($ex, $linkedAlternateIds) {
                                        return AlternateExerciseList::where('exercise_list_id', $ex->exercise_list_id)
                                            ->whereNotIn('id', $linkedAlternateIds)
                                            ->exists();
                                    });
                                }
                                
                                return [
                                    'id' => $ex->id,
                                    'item_id' => $itemId,
                                    'exercise_list_id' => $ex->exercise_list_id,
                                    'name' => $ex->name,
                                    'sets' => $ex->sets,
                                    'reps' => $ex->reps,
                                    'rest' => $ex->rest,
                                    'tempo' => $ex->tempo,
                                    'intensity' => $ex->intensity,
                                    'weight' => $ex->weight ?? 'No',
                                    'weight_value' => $ex->weight_value,
                                    'notes' => strip_tags(html_entity_decode($ex->notes ?? '')),
                                    'alternates' => $linkedAlternates,
                                    'has_available_alternates' => $hasAvailableAlternates,
                                ];
                            })->toArray()
                        ];
                    })->values()->toArray()
                ];
            })->toArray();
    }

    private function autoSelectFirstWeekAndDay()
    {
        if (!empty($this->weeks)) {
            $this->selectedWeekId = $this->weeks[0]['id'];
            $this->activeWeekAccordion = $this->weeks[0]['id'];
            
            if (!empty($this->weeks[0]['days'])) {
                $this->selectedDayId = $this->weeks[0]['days'][0]['id'];
                $this->ensureDayHasExercises($this->selectedDayId);
                $this->loadWeeks();
            }
        }
    }

    public function selectWeek($weekId)
    {
        $this->selectedWeekId = $weekId;
        $this->activeWeekAccordion = $weekId;
        $this->dispatch('close-other-accordions', weekId: $weekId);
    }
    
    public function selectDay($dayId)
    {
        $this->selectedDayId = $dayId;

        // Find which week this day belongs to
        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                if ($day['id'] == $dayId) {
                    $this->selectedWeekId = $week['id'];
                    $this->activeWeekAccordion = $week['id'];
                    
                    // Dispatch event to sync accordion state
                    $this->dispatch('sync-week-accordion', weekId: $week['id']);
                    break 2;
                }
            }
        }

        // Ensure exercises exist for this day
        $this->ensureDayHasExercises($dayId);

        // Reload but keep active accordion state
        $this->loadWeeks();
    }
    public function toggleWeek($weekId)
    {
        if ($this->activeWeekAccordion === $weekId) {
            // Collapse if same week clicked
            $this->activeWeekAccordion = null;
        } else {
            // Open clicked week and close all others
            $this->activeWeekAccordion = $weekId;
            $this->selectedWeekId = $weekId;
        }
        
        // Dispatch to sync accordion state
        $this->dispatch('sync-week-accordion', weekId: $this->activeWeekAccordion);
    }

    /**
     * Force refresh exercises for the selected day to ensure minimum count
     */
    public function refreshDayExercises()
    {
        if ($this->selectedDayId) {
            $this->ensureDayHasExercises($this->selectedDayId);
            $this->loadWeeks();
            $this->dispatch('show-success', message: 'Day exercises refreshed successfully!');
        }
    }

   private function ensureDayHasExercises($dayId)
    {
        $existingCount = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $dayId)->count();
        $targetCount = 6;
        $toCreate = $targetCount - $existingCount;

        if ($toCreate <= 0) return;

        $exercisesToInsert = [];
        for ($i = 1; $i <= $toCreate; $i++) {
            $exerciseNumber = $existingCount + $i;
            $exercisesToInsert[] = [
                'new_exercise_week_day_id' => $dayId,
                'exercise_list_id' => null,
                'item_id' => $exerciseNumber,
                'name' => "Exercise {$exerciseNumber}",
                'sets' => '',
                'reps' => '',
                'rest' => '',
                'tempo' => '',
                'intensity' => '',
                'weight' => '',
                'weight_value' => '',
                'notes' => '',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        if (!empty($exercisesToInsert)) {
            NewExerciseWeekDayItem::insert($exercisesToInsert);
        }
    }

    private function ensureWeekHasDays($week)
    {
        $existingDays = $week->days()->count();
        if ($existingDays >= 7) return;

        $daysToCreate = [];
        for ($dayNumber = 1; $dayNumber <= 7; $dayNumber++) {
            $exists = NewExerciseWeekDay::where('new_exercise_week_id', $week->id)
                ->where('day_number', $dayNumber)
                ->exists();
                
            if (!$exists) {
                $daysToCreate[] = [
                    'new_exercise_week_id' => $week->id,
                    'day_number' => $dayNumber,
                    'title' => 'Day ' . $dayNumber . ' Workout',
                    'summary' => "",
                    'duration' => 30,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        if (!empty($daysToCreate)) {
            NewExerciseWeekDay::insert($daysToCreate);
            
            // Batch create exercises for all new days
            $newDayIds = NewExerciseWeekDay::where('new_exercise_week_id', $week->id)
                ->whereIn('day_number', array_column($daysToCreate, 'day_number'))
                ->pluck('id');
                
            foreach ($newDayIds as $dayId) {
                $this->ensureDayHasExercises($dayId);
            }
        }
    }

    public function addWeek()
    {
        $weekCount = NewExerciseWeek::where('new_exercise_id', $this->exerciseId)->count();
        $weekNumber = $weekCount + 1;

        $week = NewExerciseWeek::create([
            'new_exercise_id' => $this->exerciseId,
            'week_number' => $weekNumber,
        ]);

        $this->ensureWeekHasDays($week);
        $this->loadWeeks();
        
        // Set the new week as active and open its accordion
        $this->selectedWeekId = $week->id;
        $this->activeWeekAccordion = $week->id;
        
        // Dispatch to open only this accordion
        $this->dispatch('jump-to-week', weekId: $week->id);
        $this->dispatch('show-success', message: 'New week added successfully!');
    }

    public function deleteWeek($weekId)
    {
        if (count($this->weeks) <= 1) {
            $this->dispatch('show-error', message: 'Cannot delete the last week!');
            return;
        }

        $week = NewExerciseWeek::findOrFail($weekId);
        
        // Use transaction for data consistency
        DB::transaction(function () use ($week) {
            $week->days()->each(function ($day) {
                $day->exerciseItems()->delete();
            });
            $week->days()->delete();
            $week->delete();
        });

        // Clear cache
        Cache::forget("available_alternates_*");

        $this->loadWeeks();
        if ($this->selectedWeekId == $weekId) $this->autoSelectFirstWeekAndDay();
        $this->dispatch('show-success', message: 'Week deleted successfully!');
    }

    public function addDay($weekId)
    {
        $daysCount = NewExerciseWeekDay::where('new_exercise_week_id', $weekId)->count();
        if ($daysCount >= 7) {
            $this->dispatch('show-error', message: 'A week cannot have more than 7 days!');
            return;
        }

        $dayNumber = $daysCount + 1;

        $day = NewExerciseWeekDay::create([
            'new_exercise_week_id' => $weekId,
            'day_number' => $dayNumber,
            'title' =>  "Day {$dayNumber} Workout",
            'summary' => 'Complete workout session',
            'duration' => '30'
        ]);

        $this->ensureDayHasExercises($day->id);
        $this->loadWeeks();
        $this->dispatch('show-success', message: 'New day added successfully!');
    }

   public function deleteDay($dayId)
    {
        $day = NewExerciseWeekDay::findOrFail($dayId);
        $daysCount = NewExerciseWeekDay::where('new_exercise_week_id', $day->new_exercise_week_id)->count();
        if ($daysCount <= 1) {
            $this->dispatch('show-error', message: 'Cannot delete the last day in a week!');
            return;
        }

        $day->exerciseItems()->delete();
        $day->delete();

        $this->loadWeeks();
        if ($this->selectedDayId == $dayId) {
            $week = collect($this->weeks)->firstWhere('id', $this->selectedWeekId);
            if ($week && !empty($week['days'])) $this->selectedDayId = $week['days'][0]['id'];
        }
        $this->dispatch('show-success', message: 'Day deleted successfully!');
    }

    public function addExercise()
    {
        if (!$this->selectedDayId) {
            $this->dispatch('show-error', message: 'Please select a day first!');
            return;
        }

        $existingCount = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $this->selectedDayId)->count();
        $exerciseNumber = $existingCount + 1;

        NewExerciseWeekDayItem::create([
            'new_exercise_week_day_id' => $this->selectedDayId,
            'item_id' => $exerciseNumber,
            'exercise_list_id' => null,
            'name' => "Exercise {$exerciseNumber}",
            'sets' => '',
            'reps' => '',
            'rest' => '',
            'tempo' => '',
            'intensity' => 'Moderate',
            'weight' => 'Yes',
            'weight_value' => '',
            'notes' => ''
        ]);

        $this->loadWeeks();
        $this->dispatch('show-success', message: 'Exercise added successfully!');
        $this->dispatch('reinit-select2'); // NEW: Force select2 reinit
    }

    public function deleteExercise($exerciseId)
    {
        $exercise = NewExerciseWeekDayItem::findOrFail($exerciseId);
        $exercise->delete();

        $this->loadWeeks();
        $this->dispatch('show-success', message: 'Exercise deleted successfully!');
    }

    public function openTitleModal($dayId)
    {
        $day = NewExerciseWeekDay::findOrFail($dayId);
        
        $this->editingDayId = $dayId;
        $this->dayTitle = $day->title;
        $this->daySummary = $day->summary;
        $this->dayDuration = $day->duration;
        $this->showTitleModal = true;
    }

    public function saveDayTitle()
    {
        $this->validate([
            'dayTitle' => 'required|string|max:255',
            'dayDuration' => 'nullable|int',
            'daySummary' => 'nullable|string|max:500',
        ]);

        $day = NewExerciseWeekDay::findOrFail($this->editingDayId);
        $day->update([
            'title' => $this->dayTitle,
            'summary' => $this->daySummary,
            'duration' => $this->dayDuration,
        ]);

        $this->loadWeeks();
        $this->closeTitleModal();
        
        $this->dispatch('show-success', message: 'Day title updated successfully!');
    }

    public function closeTitleModal()
    {
        $this->showTitleModal = false;
        $this->editingDayId = null;
        $this->dayTitle = '';
        $this->daySummary = '';
        $this->dayDuration = '';
    }

    
    public function updateExerciseSelect($id, $value)
    {
        //\Log::info("Select2 Updated: ID = $id, VALUE = $value");
        $this->updateExercise($id, 'exercise_list_id', $value);
    }


    public function updateExercise($exerciseId, $field, $value)
    {
        // \Log::info("update method called");
        $exercise = NewExerciseWeekDayItem::findOrFail($exerciseId);

        if ($field === 'exercise_list_id' && !empty($value)) {
            $exerciseList = $this->exerciseLists->find($value);
            
            if ($exerciseList) {
                $weightValue = $exerciseList->weight;
                if (strtolower($weightValue) === 'yes') {
                    $weightValue = 'Yes';
                } else {
                    $weightValue = 'No';
                }
                
                $exercise->update([
                    'exercise_list_id' => $value,
                    'name' => $exerciseList->name,
                    'weight' => $weightValue,
                    'weight_value' => ($weightValue === 'Yes') ? ($exerciseList->weight_value ?? null) : null,
                    'notes' => $exerciseList->notes ?? '',
                ]);
                
                // Clear cache for this exercise's alternates
                Cache::forget("available_alternates_{$value}_*");
                
                // CRITICAL FIX: Refresh data BEFORE dispatching event
                $this->loadWeeks();
                $this->populateAlternates();
                $this->populateAlternatePivotIds();
                
                // Get the fresh weight value
                $freshWeight = $exerciseList->weight ?? 'No';
                
                // Dispatch reinit-select2 first, then weight updates with delay
                $this->dispatch('reinit-select2');
                
                // Use dispatch with a slight delay handled in JS
                $this->dispatch('update-weight-after-load', [
                    'exerciseId' => $exerciseId,
                    'weight' => $freshWeight
                ]);
            } else {
                $exercise->update(['exercise_list_id' => $value]);
            }
        } else {
            $exercise->update([$field => $value]);
            
            // For weight field changes
            if ($field === 'weight') {
                $this->loadWeeks();
                $this->populateAlternates();
                $this->populateAlternatePivotIds();
                
                $this->dispatch('update-weight-visibility', [
                    'exerciseId' => $exerciseId,
                    'weight' => $value
                ]);
            }
        }
    }

     public function saveAllExercises()
    {
        if (!$this->selectedWeekId) {
            $this->dispatch('show-error', message: 'No week selected to save exercises!');
            return;
        }

        $currentWeek = collect($this->weeks)->firstWhere('id', $this->selectedWeekId);

        if (!$currentWeek || empty($currentWeek['days'])) {
            $this->dispatch('show-error', message: 'No exercises found for the selected week.');
            return;
        }

        $savedCount = 0;
        $totalCount = 0;

        foreach ($currentWeek['days'] as $day) {
            if (empty($day['exercises'])) continue;

            foreach ($day['exercises'] as $exercise) {
                $totalCount++;

                if (
                    !empty($exercise['exercise_list_id']) ||
                    !empty($exercise['sets']) ||
                    !empty($exercise['reps']) ||
                    !empty($exercise['rest']) ||
                    !empty($exercise['tempo']) ||
                    !empty($exercise['intensity']) ||
                    !empty($exercise['weight']) ||
                    !empty($exercise['notes'])
                ) {
                    $savedCount++;
                }
            }
        }

        if ($savedCount === $totalCount && $totalCount > 0) {
            $this->dispatch('show-success', message: "All exercises for this week saved successfully!");
        } elseif ($savedCount > 0) {
            $this->dispatch('show-success', message: "Exercises saved successfully!");
        } else {
            $this->dispatch('show-success', message: 'Exercises saved successfully!');
        }
    }

    public function getSelectedDayExercises()
    {
        if (!$this->selectedDayId) {
            return [];
        }

        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                if ($day['id'] == $this->selectedDayId) {
                    return $day['exercises'];
                }
            }
        }

        return [];
    }

  public function addAlternateExercise($mainExerciseId)
    {
        $mainExercise = NewExerciseWeekDayItem::findOrFail($mainExerciseId);
        
        if (!$mainExercise->exercise_list_id) {
            $this->dispatch('show-error', message: 'Please select a main exercise first!');
            return;
        }
        
        $linkedAlternateIds = $mainExercise->alternateExercises()->pluck('alternate_exercise_lists.id')->toArray();
        
        $availableAlternate = AlternateExerciseList::where('exercise_list_id', $mainExercise->exercise_list_id)
            ->whereNotIn('id', $linkedAlternateIds)
            ->first();
        
        if (!$availableAlternate) {
            $this->dispatch('show-error', message: 'No available alternate exercises for this exercise!');
            return;
        }
        
        $mainExercise->alternateExercises()->attach($availableAlternate->id, [
            'sets' => $availableAlternate->sets ?? null,
            'reps' => $availableAlternate->reps ?? null,
            'rest' => $availableAlternate->rest ?? null,
            'tempo' => $availableAlternate->tempo ?? null,
            'intensity' => $availableAlternate->intensity ?? null,
            'weight' => $availableAlternate->weight ?? 'No',
            'weight_value' => $availableAlternate->weight_value ?? null,
            'notes' => $availableAlternate->notes ?? null,
        ]);
        
        // Clear cache
        Cache::forget("available_alternates_{$mainExercise->exercise_list_id}_*");
        
        $this->loadWeeks();
        $this->populateAlternates();
        $this->populateAlternatePivotIds();
        $this->dispatch('show-success', message: 'Alternate exercise added successfully!');
    }

    public function updateAlternateWeight($alternateId, $weight)
    {
        if (!isset($this->alternates[$alternateId])) {
            $this->dispatch('show-error', message: 'Alternate exercise not found!');
            return;
        }

        // Update the alternates array
        $this->alternates[$alternateId]['weight'] = $weight;
        
        // If weight is No, clear the weight_value
        if ($weight === 'No') {
            $this->alternates[$alternateId]['weight_value'] = null;
        }
        
        $pivotId = $this->alternatePivotIds[$alternateId];
        
        // Update the database immediately
        DB::table('alternate_exercise_item_pivot')
            ->where('id', $pivotId)
            ->update([
                'weight' => $weight,
                'weight_value' => $weight === 'No' ? null : $this->alternates[$alternateId]['weight_value'],
                'updated_at' => now()
            ]);
        
        // Reload weeks to update the data
        $this->loadWeeks();
        $this->populateAlternates();
        $this->populateAlternatePivotIds();
        
        // Dispatch event to update visibility in JavaScript
        $this->dispatch('update-alternate-weight-visibility', [
            'alternateId' => $alternateId,
            'weight' => $weight
        ]);
    }

    public function saveAlternate($alternateId)
    {
        if (!isset($this->alternates[$alternateId])) {
            $this->dispatch('show-error', message: 'Alternate exercise not found!');
            return;
        }

        if (!isset($this->alternatePivotIds[$alternateId])) {
            $this->dispatch('show-error', message: 'Pivot ID not found!');
            return;
        }

        $data = $this->alternates[$alternateId];
        $pivotId = $this->alternatePivotIds[$alternateId];
        
        DB::table('alternate_exercise_item_pivot')
            ->where('id', $pivotId)
            ->update([
                'sets' => $data['sets'] ?? null,
                'reps' => $data['reps'] ?? null,
                'rest' => $data['rest'] ?? null,
                'tempo' => $data['tempo'] ?? null,
                'intensity' => $data['intensity'] ?? null,
                'weight' => $data['weight'] ?? null,
                'weight_value' => $data['weight_value'] ?? null,
                'notes' => $data['notes'] ?? null,
                'updated_at' => now(),
            ]);

        $this->dispatch('show-success', message: 'Alternate exercise saved successfully!');
        $this->loadWeeks();
        $this->populateAlternatePivotIds();
    }
    
    public function deleteAlternateExercise($alternateId, $exerciseItemId = null)
    {
        if (!$exerciseItemId) {
            foreach ($this->getSelectedDayExercises() as $ex) {
                foreach ($ex['alternates'] ?? [] as $alt) {
                    if ($alt['id'] == $alternateId) {
                        $exerciseItemId = $ex['id'];
                        break 2;
                    }
                }
            }
        }
        
        if (!$exerciseItemId) {
            $this->dispatch('show-error', message: 'Cannot determine exercise item!');
            return;
        }
        
        $mainExercise = NewExerciseWeekDayItem::findOrFail($exerciseItemId);
        $mainExercise->alternateExercises()->detach($alternateId);
        
        // Clear cache
        if ($mainExercise->exercise_list_id) {
            Cache::forget("available_alternates_{$mainExercise->exercise_list_id}_*");
        }
        
        $this->loadWeeks();
        $this->dispatch('show-success', message: 'Alternate exercise removed from this exercise!');
    }

    public function checkAvailableAlternates($exerciseItemId, $exerciseListId)
    {
        if (empty($exerciseListId)) {
            return false;
        }
        
        $hasAvailable = AlternateExerciseList::where('exercise_list_id', $exerciseListId)
            ->whereNull('new_exercise_week_day_item_id')
            ->exists();
        
        return $hasAvailable;
    }

    public function render()
    {
        return view('livewire.exercise-builder', [
            'selectedDayExercises' => $this->getSelectedDayExercises(),
        ]);
    }
}