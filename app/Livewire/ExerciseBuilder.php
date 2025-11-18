<?php

namespace App\Livewire;

use App\Models\ExerciseList;
use App\Models\AlternateExerciseList;
use App\Models\NewExercise;
use App\Models\NewExerciseWeek;
use App\Models\NewExerciseWeekDay;
use App\Models\NewExerciseWeekDayItem;
use Livewire\Component;

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

    public function mount($exerciseId)
    {
        $this->exerciseId = decrypt($exerciseId);
        $this->exercise = NewExercise::findOrFail($this->exerciseId);
        $this->exerciseLists = ExerciseList::orderBy('name')->get();
        $this->alternates = AlternateExerciseList::all()->keyBy('id')->toArray();
        
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
                    // Populate with pivot data, not the alternate's base data
                    $this->alternates[$alt['id']] = [
                        'id' => $alt['id'],
                        'pivot_id' => $alt['pivot_id'],
                        'name' => $alt['name'],
                        'exercise_list_id' => $alt['exercise_list_id'],
                        'sets' => $alt['sets'] ?? null, // From pivot
                        'reps' => $alt['reps'] ?? null, // From pivot
                        'rest' => $alt['rest'] ?? null, // From pivot
                        'tempo' => $alt['tempo'] ?? null, // From pivot
                        'intensity' => $alt['intensity'] ?? null, // From pivot
                        'weight' => $alt['weight'] ?? 'No', // From pivot
                        'weight_value' => $alt['weight_value'] ?? null, // From pivot
                        'notes' => strip_tags(html_entity_decode($alt['notes'] ?? null)),
                    ];
                }
            }
        }
    }
}
    // private function initializeAlternates()
    // {
    //     // Get all linked alternates and initialize them in the alternates array
    //     $linkedAlternates = AlternateExerciseList::whereNotNull('new_exercise_week_day_item_id')->get();
    //     $this->alternates = [];
    //     foreach ($linkedAlternates as $alternate) {
    //         $this->alternates[$alternate->id] = [
    //             'id' => $alternate->id,
    //             'name' => $alternate->name,
    //             'exercise_list_id' => $alternate->exercise_list_id,
    //             'sets' => $alternate->sets,
    //             'reps' => $alternate->reps,
    //             'rest' => $alternate->rest,
    //             'tempo' => $alternate->tempo,
    //             'intensity' => $alternate->intensity,
    //             'weight' => $alternate->weight,
    //             'weight_value' => $alternate->weight_value,
    //             'notes' => $alternate->notes,
    //         ];
    //     }
    // }

    private function ensureWeeksHaveProperDayStructure()
    {
        $weeks = $this->exercise->weeks()->get();

        foreach ($weeks as $weekIndex => $week) {
            // Fix week_number if it's 0 or null
        
            if ($week->week_number <= 0) {
                $week->update(['week_number' => $weekIndex + 1]);
            }
            
            $existingDays = $week->days()->orderBy('id')->get();
        
            $dayCount = $existingDays->count();


            // Fix day_number for existing days if they're 0 or null
            foreach ($existingDays as $dayIndex => $day) {
                if ($day->day_number <= 0) {
                    $day->update(['day_number' => $dayIndex + 1]);
                }
                
                // Fix item_id for exercises in this day
                $exercises = $day->exerciseItems()->orderBy('id')->get();
                foreach ($exercises as $exIndex => $exercise) {
                    if ($exercise->item_id <= 0) {
                        $exercise->update(['item_id' => $exIndex + 1]);
                    }
                }
            }

            // Only create days if there are 2 or fewer days (completely empty week)
            if ($dayCount <= 2) {
                for ($dayNumber = $dayCount + 1; $dayNumber <= 7; $dayNumber++) {
                    NewExerciseWeekDay::create([
                        'new_exercise_week_id' => $week->id,
                        'day_number' => $dayNumber,
                        'title' => 'Day ' . $dayNumber.' Workout',
                        'summary' => "",
                        'duration' => 30
                    ]);
                
                }
            }
        }
    }

    // Create first week with default 7 days
    private function createDefaultWeekStructure()
    {
        $existingWeeks = NewExerciseWeek::where('new_exercise_id', $this->exerciseId)->count();
        if ($existingWeeks > 0) return; // Prevent duplicates

        $week = NewExerciseWeek::create([
            'new_exercise_id' => $this->exerciseId,
            'week_number' => 1,
        ]);

        $this->ensureWeekHasDays($week);
    }

private function loadWeeks()
{
    $this->weeks = $this->exercise->weeks()
        ->with(['days.exerciseItems.exercise_list'])
        ->orderBy('week_number')
        ->get()
        ->map(function ($week, $index) {
            $weekNumber = $week->week_number > 1 ? $week->week_number : ($index + 1);
            
            return [
                'id' => $week->id,
                'number' => $weekNumber,
                'days' => $week->days->sortBy('day_number')->map(function ($day, $dayIndex) {
                    $dayNumber = $day->day_number > 1 ? $day->day_number : ($dayIndex + 1);
                    
                    return [
                        'id' => $day->id,
                        'number' => $dayNumber,
                        'title' => $day->title ?: "Day {$dayNumber}",
                        'summary' => $day->summary ?: '',
                        'duration' => $day->duration ?: '',
                       'exercises' => $day->exerciseItems->map(function ($ex, $exIndex) {
                        $itemId = $ex->item_id > 0 ? $ex->item_id : ($exIndex + 1);
                        
                        // Get linked alternates with their pivot data
                        $linkedAlternates = $ex->alternateExercises()
                            ->get()
                            ->map(function($alt) {
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
                            })
                            ->toArray();
                        
                        // Check if there are alternates NOT yet linked to this item
                        $hasAvailableAlternates = false;
                        if ($ex->exercise_list_id) {
                            $linkedAlternateIds = $ex->alternateExercises()->pluck('alternate_exercise_lists.id')->toArray();
                            
                            $hasAvailableAlternates = AlternateExerciseList::where('exercise_list_id', $ex->exercise_list_id)
                                ->whereNotIn('id', $linkedAlternateIds)
                                ->exists();
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
                
                // Ensure exercises exist for the first day
                $this->ensureDayHasExercises($this->selectedDayId);
                
                // Reload weeks to get the updated data with exercises
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

        for ($i = 1; $i <= $toCreate; $i++) {
            $exerciseNumber = $existingCount + $i;
            NewExerciseWeekDayItem::create([
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
                'weight_value'=>'',
                'notes' => ''
            ]);
        }
    }

    private function ensureWeekHasDays($week)
    {
        $existingDays = $week->days()->count();
        if ($existingDays >= 7) return;

        for ($dayNumber = 1; $dayNumber <= 7; $dayNumber++) {
            $day = NewExerciseWeekDay::firstOrCreate(
                ['new_exercise_week_id' => $week->id, 'day_number' => $dayNumber],
                [
                    'title' => 'Day ' . $dayNumber.' Workout',
                    'summary' => "",
                    'duration' => 30
                ]
            );

            $this->ensureDayHasExercises($day->id);
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
        $week->days()->each(function ($day) {
            $day->exerciseItems()->delete();
        });
        $week->days()->delete();
        $week->delete();

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
            'weight_value'=>'',
            'notes' => ''
        ]);

        $this->loadWeeks();
        $this->dispatch('show-success', message: 'Exercise added successfully!');
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

    public function updateExercise($exerciseId, $field, $value)
    {
        $exercise = NewExerciseWeekDayItem::findOrFail($exerciseId);

        // If updating exercise_list_id, preload weight and notes from ExerciseList
        if ($field === 'exercise_list_id' && !empty($value)) {
            $exerciseList = ExerciseList::find($value);
            
            if ($exerciseList) {
                $exercise->update([
                    'exercise_list_id' => $value,
                    'name' => $exerciseList->name,
                    'weight' => $exerciseList->weight ?? 'No',
                    'weight_value' => $exerciseList->weight_value ?? null,
                    'notes' => $exerciseList->notes ?? '',
                ]);
                
                // Dispatch event to update weight field visibility
                $this->dispatch('update-weight-visibility', [
                    'exerciseId' => $exerciseId,
                    'weight' => $exerciseList->weight ?? 'No'
                ]);
            } else {
                $exercise->update(['exercise_list_id' => $value]);
            }
        } else {
            $exercise->update([$field => $value]);
            
            // If weight field is updated, dispatch visibility event
            if ($field === 'weight') {
                $this->dispatch('update-weight-visibility', [
                    'exerciseId' => $exerciseId,
                    'weight' => $value
                ]);
            }
        }
        
        // Always reload after update to recalculate has_available_alternates
        $this->loadWeeks();
        $this->populateAlternates();
        $this->populateAlternatePivotIds();
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

//  public function addAlternateExercise($mainExerciseId)
// {
//     $mainExercise = NewExerciseWeekDayItem::findOrFail($mainExerciseId);
    
//     if (!$mainExercise->exercise_list_id) {
//         $this->dispatch('show-error', message: 'Please select a main exercise first!');
//         return;
//     }
    
//     // Get already linked alternate IDs for this item
//     $linkedAlternateIds = $mainExercise->alternateExercises()->pluck('alternate_exercise_lists.id')->toArray();
    
//     // Find an alternate NOT yet linked to this item
//     $availableAlternate = AlternateExerciseList::where('exercise_list_id', $mainExercise->exercise_list_id)
//         ->whereNotIn('id', $linkedAlternateIds)
//         ->first();
    
//     if (!$availableAlternate) {
//         $this->dispatch('show-error', message: 'No available alternate exercises for this exercise!');
//         return;
//     }
    
//     // Create the pivot relationship with default values from alternate
//     $mainExercise->alternateExercises()->attach($availableAlternate->id, [
//         'sets' => null,
//         'reps' => null,
//         'rest' => null,
//         'tempo' => null,
//         'intensity' => null,
//         'weight' => $availableAlternate->weight ?? 'No',
//         'weight_value' => $availableAlternate->weight_value,
//         'notes' => $availableAlternate->notes,
//     ]);
    
//     $this->loadWeeks();
//     $this->dispatch('show-success', message: 'Alternate exercise added successfully!');
// }
public function addAlternateExercise($mainExerciseId)
{
    $mainExercise = NewExerciseWeekDayItem::findOrFail($mainExerciseId);
    
    if (!$mainExercise->exercise_list_id) {
        $this->dispatch('show-error', message: 'Please select a main exercise first!');
        return;
    }
    
    // Get already linked alternate IDs for this item
    $linkedAlternateIds = $mainExercise->alternateExercises()->pluck('alternate_exercise_lists.id')->toArray();
    
    // Find an alternate NOT yet linked to this item
    $availableAlternate = AlternateExerciseList::where('exercise_list_id', $mainExercise->exercise_list_id)
        ->whereNotIn('id', $linkedAlternateIds)
        ->first();
    
    if (!$availableAlternate) {
        $this->dispatch('show-error', message: 'No available alternate exercises for this exercise!');
        return;
    }
    
    // Create the pivot relationship with default values from alternate
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
    
    $this->loadWeeks();
    $this->populateAlternates();
    $this->populateAlternatePivotIds();
    $this->dispatch('show-success', message: 'Alternate exercise added successfully!');
}

    // public function updateAlternateExercise($alternateId, $field, $value)
    // {
    //     $alternate = AlternateExerciseList::findOrFail($alternateId);
    //     $alternate->update([$field => $value]);
        
    //     $this->loadWeeks();
    // }

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
    
    \DB::table('alternate_exercise_item_pivot')
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
    // If exerciseItemId is provided, find it from the current selection
    if (!$exerciseItemId) {
        // Find from alternates array or selected day
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
    
    // Detach (remove the pivot relationship)
    $mainExercise->alternateExercises()->detach($alternateId);
    
    $this->loadWeeks();
    $this->dispatch('show-success', message: 'Alternate exercise removed from this exercise!');
}
/**
 * Check if there are available unlinked alternates for a specific exercise list
 */
public function checkAvailableAlternates($exerciseItemId, $exerciseListId)
{
    if (empty($exerciseListId)) {
        return false;
    }
    
    // Check if there are UNLINKED alternates for this exercise_list_id
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