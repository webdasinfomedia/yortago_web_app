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
        $this->autoSelectFirstWeekAndDay();
        $this->initializeAlternates();
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
    private function initializeAlternates()
    {
        // Get all linked alternates and initialize them in the alternates array
        $linkedAlternates = AlternateExerciseList::whereNotNull('new_exercise_week_day_item_id')->get();
        $this->alternates = [];
        foreach ($linkedAlternates as $alternate) {
            $this->alternates[$alternate->id] = [
                'id' => $alternate->id,
                'name' => $alternate->name,
                'exercise_list_id' => $alternate->exercise_list_id,
                'sets' => $alternate->sets,
                'reps' => $alternate->reps,
                'rest' => $alternate->rest,
                'tempo' => $alternate->tempo,
                'intensity' => $alternate->intensity,
                'weight' => $alternate->weight,
                'weight_value' => $alternate->weight_value,
                'notes' => $alternate->notes,
            ];
        }
    }

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
                            
                            // Get linked alternate exercises for THIS specific item
                            $alternates = AlternateExerciseList::where('exercise_list_id', $ex->exercise_list_id)
                                ->get()
                                ->map(function($alt) {
                                    return [
                                        'id' => $alt->id,
                                        'name' => $alt->name,
                                        'exercise_list_id' => $alt->exercise_list_id,
                                        'sets' => $alt->sets,
                                        'reps' => $alt->reps,
                                        'rest' => $alt->rest,
                                        'tempo' => $alt->tempo,
                                        'intensity' => $alt->intensity,
                                        'weight' => $alt->weight,
                                        'weight_value' => $alt->weight_value,
                                        'notes' => $alt->notes,
                                        'image' => $alt->image,
                                    ];
                                })
                                ->toArray();
                            
                            // Check if there are available alternates for this exercise
                            $hasAvailableAlternates = false;
                            if ($ex->exercise_list_id) {
                                // First, check if there are unlinked alternates OR alternates linked to other exercises
                                $availableAlternatesExist = AlternateExerciseList::where('exercise_list_id', $ex->exercise_list_id)
                                    ->where(function($query) use ($ex) {
                                        $query->whereNull('new_exercise_week_day_item_id')
                                            ->orWhere('new_exercise_week_day_item_id', '!=', $ex->id);
                                    })
                                    ->exists();
                                
                                if ($availableAlternatesExist) {
                                    // Now check if ANY alternate for this exercise_list_id has data filled
                                    // Check across ALL alternates with this exercise_list_id, not just this item
                                    $hasFilledAlternate = AlternateExerciseList::where('exercise_list_id', $ex->exercise_list_id)
                                        ->where(function($query) {
                                            $query->whereNotNull('sets')
                                                ->orWhereNotNull('reps')
                                                ->orWhereNotNull('rest')
                                                ->orWhereNotNull('tempo')
                                                ->orWhereNotNull('intensity');
                                        })
                                        ->exists();
                                    
                                    // Only show "Add Alternate" button if no alternate has data
                                    $hasAvailableAlternates = !$hasFilledAlternate;
                                }
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
                                'weight' => $ex->weight,
                                'weight_value' => $ex->weight_value,
                                'notes' => $ex->notes,
                                'alternates' => $alternates,
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
        
        // Remove this auto-selection
        // $week = collect($this->weeks)->firstWhere('id', $weekId);
        // if ($week && !empty($week['days'])) {
        //     $this->selectedDayId = $week['days'][0]['id'];
        // }
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
                    
                    // Dispatch event to JavaScript to sync accordion state
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
            // Open clicked week without auto-selecting day
            $this->activeWeekAccordion = $weekId;
            $this->selectedWeekId = $weekId;
            // Don't auto-select first day - let user click on it
        }
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
        $this->selectedWeekId = $week->id;
        $this->activeWeekAccordion = $week->id;
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
            // First, unlink any existing alternate exercises from this item
            AlternateExerciseList::where('new_exercise_week_day_item_id', $exerciseId)
                ->update(['new_exercise_week_day_item_id' => null]);
            
            $exerciseList = ExerciseList::find($value);
            
            if ($exerciseList) {
                $exercise->update([
                    'exercise_list_id' => $value,
                    'name' => $exerciseList->name,
                    'weight' => $exerciseList->weight ?? $exercise->weight,
                    'weight_value'=> $exerciseList->weight_value ?? $exercise->weight_value,
                    'notes' => $exerciseList->notes ?? $exercise->notes,
                ]);
            } else {
                $exercise->update(['exercise_list_id' => $value]);
            }
            
            // Force a complete reload to update the view
            $this->loadWeeks();
            
            // Force Livewire to re-render this specific exercise card
            $this->dispatch('$refresh');
            
        } else {
            $exercise->update([$field => $value]);
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
    
    // Get available alternate exercises - only check exercise_list_id
    $availableAlternates = AlternateExerciseList::where('exercise_list_id', $mainExercise->exercise_list_id)
        ->get();
    
    if ($availableAlternates->isEmpty()) {
        $this->dispatch('show-error', message: 'No alternate exercises available for this exercise!');
        return;
    }
    
    // Get the first available alternate
    $alternate = $availableAlternates->first();
    
    // Get the exercise list data to pre-fill notes, weight, and weight_value
    $exerciseList = ExerciseList::find($alternate->exercise_list_id);
    
    // Link it to the main exercise and pre-fill data from exercise list
    $alternate->update([
        'new_exercise_week_day_item_id' => $mainExercise->id,
        'sets' => null,
        'reps' => null,
        'rest' => null,
        'tempo' => null,
        'intensity' => null,
        'weight' => $exerciseList->weight ?? 'Yes',
        'weight_value' => $exerciseList->weight_value ?? null,
        'notes' => $exerciseList->notes ?? null,
    ]);
    
    // Initialize this alternate in the alternates array with pre-filled data
    $this->alternates[$alternate->id] = [
        'id' => $alternate->id,
        'name' => $alternate->name,
        'exercise_list_id' => $alternate->exercise_list_id,
        'sets' => null,
        'reps' => null,
        'rest' => null,
        'tempo' => null,
        'intensity' => null,
        'weight' => $exerciseList->weight ?? 'Yes',
        'weight_value' => $exerciseList->weight_value ?? null,
        'notes' => $exerciseList->notes ?? null,
    ];
    
    $this->loadWeeks();
    $this->dispatch('show-success', message: 'Alternate exercise added with pre-filled data! Please complete the remaining fields and click Save Alternate.');
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

        $data = $this->alternates[$alternateId];

        $alternate = AlternateExerciseList::find($alternateId);
        if (!$alternate) {
            $this->dispatch('show-error', message: 'Alternate exercise missing in database!');
            return;
        }

        $alternate->update([
            'sets' => $data['sets'] ?? null,
            'reps' => $data['reps'] ?? null,
            'rest' => $data['rest'] ?? null,
            'tempo' => $data['tempo'] ?? null,
            'intensity' => $data['intensity'] ?? null,
            'weight' => $data['weight'] ?? null,
            'weight_value' => $data['weight_value'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        $this->dispatch('show-success', message: 'Alternate exercise saved successfully!');
        $this->loadWeeks();
    }

    public function deleteAlternateExercise($alternateId)
    {
        $alternate = AlternateExerciseList::findOrFail($alternateId);
        $alternate->update(['new_exercise_week_day_item_id' => null]);
        
        $this->loadWeeks();
        $this->dispatch('show-success', message: 'Alternate exercise removed successfully!');
    }

    public function render()
    {
        return view('livewire.exercise-builder', [
            'selectedDayExercises' => $this->getSelectedDayExercises(),
        ]);
    }
}