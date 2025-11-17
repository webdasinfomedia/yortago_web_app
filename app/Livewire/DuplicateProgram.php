<?php

namespace App\Livewire;

use App\Models\ExerciseList;
use App\Models\NewExercise;
use App\Models\NewExerciseWeek;
use App\Models\NewExerciseWeekDay;
use App\Models\NewExerciseWeekDayItem;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Traits\ImageUploadTrait;


class DuplicateProgram extends Component
{
    use WithFileUploads, ImageUploadTrait;
    public $exerciseId;
    public $exercise;
    public $exerciseLists = [];
    public $weeks = [];
    public $selectedWeekId = null;
    public $selectedDayId = null;
    public $activeWeekAccordion = null;
    public $title;
    public $category_id;
    public $image;
    public $imageUploaded = false;
    public $imagePath = null;
    public $imageFile = null;
    public $categories = [];
    public $youtube_link;
    public $program_id;
    public $program_type = 'generic'; // Add default value
    public $openAccordions = [];
    public $isProcessing = false;

    // Selection tracking
    public $selectedWeeks = [];
    public $selectedDays = [];

    // Copy modal properties
    public $showCopyModal = false;
    public $copyMode = 'new'; // 'new' or 'existing'
    public $targetWeekStart = 1;
    public $existingPrograms = [];
    public $selectedExistingProgram = null;
    public $weekMappings = []; // Map source week ID to target week number
    public $dayMappings = []; // Map source day ID to target week and day numbers
    public $mappings = [];
    public $selectedExercises = []; // Add this to track selected exercises
    public $weekDayAvailability = [];

    // Livewire listeners
    protected $listeners = ['copyExercises'];

    public function mount($exerciseId)
    {
        $this->exerciseId = decrypt($exerciseId);
        $this->exercise = NewExercise::findOrFail($this->exerciseId);
        $this->exerciseLists = ExerciseList::orderBy('name')->get();
        $this->existingPrograms = NewExercise::where('id', '!=', $this->exerciseId)->orderBy('title')->get();
        $this->categories = \App\Models\Category::orderBy('name')->get();

        // $this->initializeExerciseStructure();
        $this->loadWeeks();
        $this->autoSelectFirstWeekAndDay();
    }

    public function updatedTitle()
    {
        $this->resetErrorBag('title');
    }

    public function updatedCategoryId()
    {
        $this->resetErrorBag('category_id');
    }

    public function updatedYoutubeLink()
    {
        $this->resetErrorBag('youtube_link');
    }

    private function loadWeeks()
    {
        $this->weeks = $this->exercise->weeks()
            ->with(['days.exerciseItems.alternateExercises'])
            ->orderBy('week_number')
            ->get()
            ->map(function ($week, $index) {
                $weekNumber = $week->week_number > 1 ? $week->week_number : ($index + 1);
    
                return [
                    'id' => $week->id,
                    'number' => $weekNumber,
                    'days' => $week->days->sortBy('day_number')->map(function ($day, $dayIndex) {
                        $dayNumber = $day->day_number > 1 ? $day->day_number : ($dayIndex + 1);
    
                        // Filter exercises to only include those with actual data
                        $filledExercises = $day->exerciseItems->filter(function ($ex) {
                            return !empty($ex->exercise_list_id)
                                || (!empty($ex->sets) && $ex->sets !== '')
                                || (!empty($ex->reps) && $ex->reps !== '')
                                || (!empty($ex->rest) && $ex->rest !== '');
                        });
    
                        return [
                            'id' => $day->id,
                            'number' => $dayNumber,
                            'title' => $day->title ?: "Day {$dayNumber}",
                            'summary' => $day->summary ?: '',
                            'duration' => $day->duration ?: '',
                            'exercises' => $filledExercises->map(function ($ex, $exIndex) {
                                $itemId = $ex->item_id > 0 ? $ex->item_id : ($exIndex + 1);
    
                                // Include alternates info
                                $alternatesCount = $ex->alternateExercises ? $ex->alternateExercises->count() : 0;
    
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
                                    'alternates_count' => $alternatesCount
                                ];
                            })->values()->toArray()
                        ];
                    })->values()->toArray()
                ];
            })->toArray();
    }

    private function autoSelectFirstWeekAndDay()
    {
        if (empty($this->selectedWeekId) && !empty($this->weeks)) {
            $this->selectedWeekId = $this->weeks[0]['id'];
            // Remove activeWeekAccordion setting - let user control it
            
            if (!empty($this->weeks[0]['days'])) {
                $this->selectedDayId = $this->weeks[0]['days'][0]['id'];
            }
        }
    }

    public function toggleWeek($weekId)
    {
        
        $weekId = (int)$weekId;
        if (!in_array($weekId, $this->openAccordions)) {
            $this->openAccordions[] = $weekId;
        }

        if (in_array($weekId, $this->selectedWeeks)) {
            $this->selectedWeeks = array_values(array_diff($this->selectedWeeks, [$weekId]));

            // Remove all days and exercises from this week
            $week = collect($this->weeks)->firstWhere('id', $weekId);
            if ($week) {
                foreach ($week['days'] as $day) {
                    $dayId = (int)$day['id'];
                    $this->selectedDays = array_values(array_diff($this->selectedDays, [$dayId]));

                    foreach ($day['exercises'] as $exercise) {
                        $exerciseId = (int)$exercise['id'];
                        $this->selectedExercises = array_values(array_diff($this->selectedExercises, [$exerciseId]));
                    }
                }
            }
        } else {
            $this->selectedWeeks[] = $weekId;

            // Add all days and ONLY FILLED exercises from this week
            $week = collect($this->weeks)->firstWhere('id', $weekId);
            if ($week) {
                foreach ($week['days'] as $day) {
                    $dayId = (int)$day['id'];
                    if (!in_array($dayId, $this->selectedDays)) {
                        $this->selectedDays[] = $dayId;
                    }

                    foreach ($day['exercises'] as $exercise) {
                        // Only add if exercise has actual data
                        if ($this->isExerciseFilled($exercise)) {
                            $exerciseId = (int)$exercise['id'];
                            if (!in_array($exerciseId, $this->selectedExercises)) {
                                $this->selectedExercises[] = $exerciseId;
                            }
                        }
                    }
                }
            }
        }
         $this->dispatch('selection-changed');
    }

    public function toggleDay($dayId)
    {
        $dayId = (int)$dayId;
        $weekId = $this->findDayWeekId($dayId);

        if (!in_array($weekId, $this->openAccordions)) {
            $this->openAccordions[] = $weekId;
        }

        if (in_array($dayId, $this->selectedDays)) {
            $this->selectedDays = array_values(array_diff($this->selectedDays, [$dayId]));

            // Remove all exercises from this day
            $day = $this->findDayById($dayId);
            if ($day) {
                foreach ($day['exercises'] as $exercise) {
                    $exerciseId = (int)$exercise['id'];
                    $this->selectedExercises = array_values(array_diff($this->selectedExercises, [$exerciseId]));
                }
            }

            // Unselect week if it was selected
            $this->selectedWeeks = array_values(array_diff($this->selectedWeeks, [$weekId]));
        
        } else {
            $this->selectedDays[] = $dayId;

            // Add ONLY FILLED exercises from this day
            $day = $this->findDayById($dayId);
            if ($day) {
                foreach ($day['exercises'] as $exercise) {
                    // Only add if exercise has actual data
                    if ($this->isExerciseFilled($exercise)) {
                        $exerciseId = (int)$exercise['id'];
                        if (!in_array($exerciseId, $this->selectedExercises)) {
                            $this->selectedExercises[] = $exerciseId;
                        }
                    }
                }
            }

            // Check if all days in week are now selected
            $week = collect($this->weeks)->firstWhere('id', $weekId);
            if ($week) {
                $allDaysSelected = true;
                foreach ($week['days'] as $d) {
                    if (!in_array((int)$d['id'], $this->selectedDays)) {
                        $allDaysSelected = false;
                        break;
                    }
                }
                if ($allDaysSelected && !in_array($weekId, $this->selectedWeeks)) {
                    $this->selectedWeeks[] = $weekId;
                }
            }
        }
         $this->dispatch('selection-changed');
    }
    
    public function toggleExercise($exerciseId)
    {
        $exerciseId = (int)$exerciseId;

        // Verify this exercise exists and has data
        $exercise = $this->findExerciseById($exerciseId);
        if (!$exercise || !$this->isExerciseFilled($exercise)) {
            return; // Don't toggle empty exercises
        }

        $dayId = $this->findExerciseDayId($exerciseId);
        $weekId = $this->findDayWeekId($dayId);

        if (in_array($exerciseId, $this->selectedExercises)) {
            $this->selectedExercises = array_values(array_diff($this->selectedExercises, [$exerciseId]));

            // Unselect day and week if they were selected
            $this->selectedDays = array_values(array_diff($this->selectedDays, [$dayId]));
            $this->selectedWeeks = array_values(array_diff($this->selectedWeeks, [$weekId]));
        } else {
            $this->selectedExercises[] = $exerciseId;

            // Check if all FILLED exercises in day are now selected
            $day = $this->findDayById($dayId);
            if ($day) {
                $allFilledExercisesSelected = true;
                foreach ($day['exercises'] as $ex) {
                    if ($this->isExerciseFilled($ex) && !in_array((int)$ex['id'], $this->selectedExercises)) {
                        $allFilledExercisesSelected = false;
                        break;
                    }
                }

                if ($allFilledExercisesSelected && !in_array($dayId, $this->selectedDays)) {
                    $this->selectedDays[] = $dayId;

                    // Check if all days in week are now selected
                    $week = collect($this->weeks)->firstWhere('id', $weekId);
                    if ($week) {
                        $allDaysInWeekSelected = true;
                        foreach ($week['days'] as $d) {
                            if (!in_array((int)$d['id'], $this->selectedDays)) {
                                $allDaysInWeekSelected = false;
                                break;
                            }
                        }
                        if ($allDaysInWeekSelected && !in_array($weekId, $this->selectedWeeks)) {
                            $this->selectedWeeks[] = $weekId;
                        }
                    }
                }
            }
        }
         $this->dispatch('selection-changed');
    }

    public function selectWeek($weekId)
    {
        // Only set the selected week for styling, don't auto-select a day
        $this->selectedWeekId = $weekId;
       // $this->activeWeekAccordion = $weekId;
    }

    public function selectDay($dayId)
    {
        $this->selectedDayId = $dayId;
        $this->ensureDayHasExercises($dayId);
    }

    public function selectWeekAndDay($weekId, $dayId)
    {
        $this->selectedWeekId = $weekId;
        $this->selectedDayId = $dayId;
        $this->activeWeekAccordion = $weekId;
        //$this->ensureDayHasExercises($dayId);
        $this->dispatch('rotate-week-arrow', weekId: $weekId);
        if (!in_array($weekId, $this->openAccordions)) {
            $this->openAccordions[] = $weekId;
        }
    }

    public function openCopyModal()
    {
        if (empty($this->selectedWeeks) && empty($this->selectedDays) && empty($this->selectedExercises)) {
            $this->dispatch('show-error', message: 'Please select at least one week, day, or exercise to copy.');
            return;
        }

        $this->buildMappings();
        $this->copyMode = 'new';
        $this->selectedExistingProgram = null;
        $this->weekDayAvailability = [];
        $this->title = '';
        $this->category_id = '';
        // $this->image = null;
        $this->showCopyModal = true;
    }

    public function openCopyProgramModal($programId)
    {
        $this->program_id = $programId;
        $this->dispatch('showCopyProgramModal');
    }

    public function copyProgram()
{
    if (empty($this->title)) {
        $this->addError('title', 'Please enter a program title');
        $this->dispatch('scroll-modal-to-top');
        return;
    }

    if (empty($this->category_id)) {
        $this->addError('category_id', 'Please select a category');
        $this->dispatch('scroll-modal-to-top');
        return;
    }

    try {
        $this->validate([
            'title' => 'required|string|max:255|unique:new_exercises,title',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'youtube_link' => 'nullable|string|max:255',
            'program_type' => 'required|in:generic,premium',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->dispatch('scroll-modal-to-top');
        throw $e;
    }

    $imageURL = null;
    if ($this->image) {
        $filename = time() . '.' . $this->image->getClientOriginalExtension();
        $this->image->storeAs('uploads/exercise', $filename, 'public');
        $imageURL = 'uploads/exercise/' . $filename;
    }

    // Create new program
    $newProgram = NewExercise::create([
        'title' => $this->title,
        'category_id' => $this->category_id,
        'image' => $imageURL,
        'type' => $this->program_type,
        'youtube_link' => $this->youtube_link,
    ]);

    // Copy all weeks, days, exercises AND alternates from existing program
    $sourceProgram = NewExercise::with(['weeks.days.exerciseItems.alternateExercises'])
        ->find($this->program_id);
    
    if ($sourceProgram) {
        foreach ($sourceProgram->weeks as $week) {
            $newWeek = NewExerciseWeek::create([
                'new_exercise_id' => $newProgram->id,
                'week_number' => $week->week_number,
            ]);

            foreach ($week->days as $day) {
                $newDay = NewExerciseWeekDay::create([
                    'new_exercise_week_id' => $newWeek->id,
                    'day_number' => $day->day_number,
                    'day_name' => $day->day_name,
                    'title' => $day->title,
                    'summary' => $day->summary,
                    'duration' => $day->duration,
                ]);

                foreach ($day->exerciseItems as $exercise) {
                    $newExercise = NewExerciseWeekDayItem::create([
                        'new_exercise_week_day_id' => $newDay->id,
                        'item_id' => $exercise->item_id,
                        'exercise_list_id' => $exercise->exercise_list_id,
                        'name' => $exercise->name ?? '',
                        'sets' => $exercise->sets ?? '',
                        'reps' => $exercise->reps ?? '',
                        'rest' => $exercise->rest ?? '',
                        'tempo' => $exercise->tempo ?? '',
                        'intensity' => $exercise->intensity ?? 'Moderate',
                        'weight' => $exercise->weight ?? 'Yes',
                        'weight_value' => $exercise->weight_value ?? '',
                        'notes' => $exercise->notes ?? ''
                    ]);

                    // Copy alternate exercises with pivot data
                    if ($exercise->alternateExercises->count() > 0) {
                        foreach ($exercise->alternateExercises as $alternate) {
                            $newExercise->alternateExercises()->attach($alternate->id, [
                                'sets' => $alternate->pivot->sets ?? null,
                                'reps' => $alternate->pivot->reps ?? null,
                                'rest' => $alternate->pivot->rest ?? null,
                                'tempo' => $alternate->pivot->tempo ?? null,
                                'intensity' => $alternate->pivot->intensity ?? null,
                                'weight' => $alternate->pivot->weight ?? $alternate->weight ?? 'No',
                                'weight_value' => $alternate->pivot->weight_value ?? $alternate->weight_value ?? null,
                                'notes' => $alternate->pivot->notes ?? $alternate->notes ?? null,
                            ]);
                        }
                    }
                }
            }
        }
    }

    $this->closeCopyModal();
    $this->reset(['title', 'category_id', 'image', 'youtube_link', 'program_type']);

    session()->flash('success', 'Program copied successfully...');
    return redirect()->route('admin.new.exercise.manage')
                    ->with('message', 'Program copied successfully...');
}

    public function updatedSelectedExistingProgram($value)
    {
        if ($value) {
            $this->weekDayAvailability = $this->getWeekDayAvailability($value);
            
            // Reset all target selections when program changes
            foreach ($this->mappings as $key => $mapping) {
                if ($mapping['type'] === 'fullWeek') {
                    $this->mappings[$key]['targetWeek'] = null;
                } elseif ($mapping['type'] === 'fullDay') {
                    $this->mappings[$key]['targetWeek'] = null;
                    $this->mappings[$key]['targetDay'] = null;
                } elseif ($mapping['type'] === 'exercises') {
                    foreach ($this->mappings[$key]['exercises'] as $exIndex => $ex) {
                        $this->mappings[$key]['exercises'][$exIndex]['targetWeek'] = null;
                        $this->mappings[$key]['exercises'][$exIndex]['targetDay'] = null;
                    }
                }
            }
        } else {
            $this->weekDayAvailability = [];
        }
    }

    private function buildMappings()
    {
        $this->mappings = [];
        $autoTargetWeek = 1; // Auto-increment counter

        // 1. Process full weeks
        foreach ($this->selectedWeeks as $weekId) {
            $week = collect($this->weeks)->firstWhere('id', $weekId);
            if (!$week) continue;

            // Check if ALL days in this week are selected
            $allDaysSelected = true;
            foreach ($week['days'] as $day) {
                if (!in_array((int)$day['id'], $this->selectedDays)) {
                    $allDaysSelected = false;
                    break;
                }
            }

            if ($allDaysSelected) {
                $this->mappings['week_' . $weekId] = [
                    'type' => 'fullWeek',
                    'sourceWeekId' => $weekId,
                    'sourceWeekNumber' => $week['number'],
                    'targetWeek' =>  $autoTargetWeek++
                ];
            }
        }

        // 2. Process days (only if their week is not fully selected)
        $processedDays = [];
        foreach ($this->selectedDays as $dayId) {
            $weekId = $this->findDayWeekId($dayId);

            // Skip if week is fully mapped
            if (isset($this->mappings['week_' . $weekId])) {
                continue;
            }

            $day = $this->findDayById($dayId);
            if (!$day) continue;

            // Check if ALL exercises in this day are selected
            $allExercisesSelected = true;
            if (!empty($day['exercises'])) {
                foreach ($day['exercises'] as $ex) {
                    if (!in_array((int)$ex['id'], $this->selectedExercises)) {
                        $allExercisesSelected = false;
                        break;
                    }
                }
            }

            if ($allExercisesSelected) {
                $week = collect($this->weeks)->firstWhere('id', $weekId);
                $this->mappings['day_' . $dayId] = [
                    'type' => 'fullDay',
                    'sourceWeekId' => $weekId,
                    'sourceWeekNumber' => $week['number'],
                    'sourceDayId' => $dayId,
                    'sourceDayNumber' => $day['number'],
                    'sourceDayTitle' => $day['title'],
                    'targetWeek' => null,
                    'targetDay' => null
                ];
                $processedDays[] = $dayId;
            }
        }

        // 3. Process individual exercises
        $exercisesByLocation = [];
        foreach ($this->selectedExercises as $exerciseId) {
            $dayId = $this->findExerciseDayId($exerciseId);
            $weekId = $this->findDayWeekId($dayId);

            // Skip if week or day is fully mapped
            if (isset($this->mappings['week_' . $weekId]) || isset($this->mappings['day_' . $dayId])) {
                continue;
            }

            $exercise = $this->findExerciseById($exerciseId);
            $day = $this->findDayById($dayId);
            $week = collect($this->weeks)->firstWhere('id', $weekId);

            if (!$exercise || !$day || !$week) continue;

            $locationKey = $weekId . '_' . $dayId;

            if (!isset($exercisesByLocation[$locationKey])) {
                $exercisesByLocation[$locationKey] = [
                    'sourceWeekId' => $weekId,
                    'sourceWeekNumber' => $week['number'],
                    'sourceDayId' => $dayId,
                    'sourceDayNumber' => $day['number'],
                    'sourceDayTitle' => $day['title'],
                    'exercises' => []
                ];
            }

            $exercisesByLocation[$locationKey]['exercises'][] = [
                'id' => $exerciseId,
                'title' => $exercise['name'] ?: 'Exercise ' . $exercise['item_id'],
                'targetWeek' => null,
                'targetDay' => null
            ];
        }

        foreach ($exercisesByLocation as $key => $data) {
            $this->mappings['exercises_' . $key] = [
                'type' => 'exercises',
                'sourceWeekId' => $data['sourceWeekId'],
                'sourceWeekNumber' => $data['sourceWeekNumber'],
                'sourceDayId' => $data['sourceDayId'],
                'sourceDayNumber' => $data['sourceDayNumber'],
                'sourceDayTitle' => $data['sourceDayTitle'],
                'exercises' => $data['exercises']
            ];
        }
    }

    // Helper method to find which week a day belongs to
    private function findDayWeekId($dayId)
    {
        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                if ($day['id'] == $dayId) {
                    return $week['id'];
                }
            }
        }
        return null;
    }

    private function findExerciseDayId($exerciseId)
    {
        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                foreach ($day['exercises'] as $exercise) {
                    if ($exercise['id'] == $exerciseId) {
                        return $day['id'];
                    }
                }
            }
        }
        return null;
    }

    private function findDayById($dayId)
    {
        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                if ($day['id'] == $dayId) {
                    return $day;
                }
            }
        }
        return null;
    }

    private function findExerciseById($exerciseId)
    {
        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                foreach ($day['exercises'] as $exercise) {
                    if ($exercise['id'] == $exerciseId && $this->isExerciseFilled($exercise)) {
                        return $exercise;
                    }
                }
            }
        }
        return null;
    }

    private function isExerciseFilled($exercise)
    {
        return !empty($exercise['exercise_list_id'])
            || (!empty($exercise['sets']) && $exercise['sets'] !== '')
            || (!empty($exercise['reps']) && $exercise['reps'] !== '')
            || (!empty($exercise['rest']) && $exercise['rest'] !== '');
    }

    // Helper method to find day number within its week
    private function findDayNumber($dayId)
    {
        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $index => $day) {
                if ($day['id'] == $dayId) {
                    return $index + 1;
                }
            }
        }
        return 1;
    }

    // Update week mapping
    public function updateWeekMapping($weekId, $targetWeek)
    {
        $this->weekMappings[$weekId] = $targetWeek;
    }

    // Generate preview structure for the right side
    public function generatePreviewStructure()
    {
        $preview = [];

        // Add mapped weeks
        foreach ($this->weekMappings as $sourceWeekId => $targetWeekNumber) {
            $sourceWeek = collect($this->weeks)->firstWhere('id', $sourceWeekId);
            if ($sourceWeek) {
                $preview[$targetWeekNumber] = [
                    'type' => 'mapped',
                    'source' => "From Week {$sourceWeek['number']} (Full Week)"
                ];
            }
        }

        // Add mapped individual days
        foreach ($this->dayMappings as $sourceDayId => $mapping) {
            $targetWeekNumber = $mapping['week'];
            $targetDayNumber = $mapping['day'];

            // Find source day info
            $sourceDayInfo = null;
            foreach ($this->weeks as $week) {
                foreach ($week['days'] as $day) {
                    if ($day['id'] == $sourceDayId) {
                        $sourceDayInfo = "From Week {$week['number']} - Day {$day['number']}";
                        break 2;
                    }
                }
            }

            if (!isset($preview[$targetWeekNumber])) {
                $preview[$targetWeekNumber] = [
                    'type' => 'partial',
                    'source' => 'Mixed content',
                    'days' => []
                ];
            }

            if (!isset($preview[$targetWeekNumber]['days'])) {
                $preview[$targetWeekNumber]['days'] = [];
            }

            $preview[$targetWeekNumber]['days'][$targetDayNumber] = [
                'source' => $sourceDayInfo
            ];
        }

        // Sort by week number
        ksort($preview);

        return $preview;
    }

    public function closeCopyModal()
    {
        $this->showCopyModal = false;
        $this->reset(['imagePath', 'imageUploaded', 'image','program_type']);
        $this->resetErrorBag();
    }

    // Handle copy from JavaScript
    public function copyExercises($selectedItems, $targetWeek, $programType)
    {
        $this->copyMode = $programType;
        $this->targetWeekStart = (int)$targetWeek;

        // Convert JavaScript selection to component properties
        $this->selectedWeeks = [];
        $this->selectedDays = [];

        foreach ($selectedItems as $item) {
            if ($item['type'] === 'week') {
                $this->selectedWeeks[] = (int)$item['id'];
            } elseif ($item['type'] === 'day') {
                $this->selectedDays[] = (int)$item['id'];
            }
        }

        if ($this->copyMode === 'new') {
            $this->copyToNewProgram();
        } else {
            // For existing program, you'd need to implement selection logic
            $this->dispatch('show-error', message: 'Existing program copy not fully implemented yet.');
        }
    }

    public function confirmCopy()
    {
        // Prevent double submission
        if ($this->isProcessing) {
            return;
        }
        
        $this->isProcessing = true;

        // Quick validation first
        if ($this->copyMode === 'new') {
            if (empty($this->title)) {
                $this->addError('title', 'Please enter a program title');
                $this->dispatch('scroll-modal-to-top');
                $this->isProcessing = false;
                return;
            }

            if (empty($this->category_id)) {
                $this->addError('category_id', 'Please select a category');
                $this->dispatch('scroll-modal-to-top');
                $this->isProcessing = false;
                return;
            }
        }

        // Validate mappings
        if (!$this->validateMappings()) {
            $this->isProcessing = false;
            return;
        }

        try {
            if ($this->copyMode === 'new') {
                $this->copyToNewProgram();
            } elseif ($this->copyMode === 'existing') {
                $this->validate([
                    'selectedExistingProgram' => 'required|exists:new_exercises,id',
                ]);
                $this->copyToExistingProgram();
            }
        } catch (\Exception $e) {
            $this->dispatch('show-error', message: 'Error: ' . $e->getMessage());
            $this->isProcessing = false;
        }
    }

   private function copyToNewProgram()
{
    try {
        $this->validate([
            'title' => 'required|string|max:255|unique:new_exercises,title',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'program_type' => 'required|in:generic,premium',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->dispatch('scroll-modal-to-top');
        $this->isProcessing = false;
        throw $e;
    }

    // Disable real-time updates during processing
    $this->skipRender();

    $imageURL = null;
    if ($this->image) {
        $filename = time() . '.' . $this->image->getClientOriginalExtension();
        $this->image->storeAs('uploads/exercise', $filename, 'public');
        $imageURL = 'uploads/exercise/' . $filename;
    }

    $newProgram = NewExercise::create([
        'title' => $this->title,
        'category_id' => $this->category_id,
        'image' => $imageURL,
        'type' => $this->program_type,
        'youtube_link' => $this->youtube_link,
    ]);

    // Find max target week needed
    $maxWeek = $this->getMaxTargetWeek();

    // Create weeks in batch
    $createdWeeks = $this->createWeeksBatch($newProgram->id, $maxWeek);

    // Process mappings in optimized way
    $this->processMappingsBatch($createdWeeks);

    $this->isProcessing = false;
    $this->closeCopyModal();
    $this->reset(['selectedWeeks', 'selectedDays', 'selectedExercises', 'mappings', 'title', 'category_id', 'image']);

    session()->flash('success', 'Program created successfully!');
    return redirect('/admin/new/exercise/manage')->with('message', 'Program created successfully!');
}

    public function updatedImage()
    {
        $this->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            try {
                $extension = $this->image->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $extension;
                $this->imagePath = $this->image->storeAs('uploads/exercise', $name, 'public');
                $this->imageUploaded = true;

                // Clear image validation errors on successful upload
                $this->resetErrorBag('image');

                // Dispatch success event
                $this->dispatch('show-success', message: 'Image uploaded successfully!');
            } catch (\Exception $e) {
                $this->dispatch('show-error', message: 'Image upload failed: ' . $e->getMessage());
                $this->imagePath = null;
                $this->imageUploaded = false;
            }
        }
    }

    private function copyFullDayContent($sourceDayId, $targetWeekModel, $targetDayNumber)
    {
        $sourceDay = NewExerciseWeekDay::with('exerciseItems.alternateExercises')->findOrFail($sourceDayId);
        $targetDay = $this->ensureTargetDayExists($targetWeekModel, $targetDayNumber);

        $targetDay->update([
            'title' => $sourceDay->title,
            'summary' => $sourceDay->summary,
            'duration' => $sourceDay->duration,
        ]);

        $targetDay->exerciseItems()->delete();

        foreach ($sourceDay->exerciseItems as $exercise) {
            $newExercise = NewExerciseWeekDayItem::create([
                'new_exercise_week_day_id' => $targetDay->id,
                'item_id' => $exercise->item_id,
                'exercise_list_id' => $exercise->exercise_list_id,
                'name' => $exercise->name ?? '',
                'sets' => $exercise->sets ?? '',
                'reps' => $exercise->reps ?? '',
                'rest' => $exercise->rest ?? '',
                'tempo' => $exercise->tempo ?? '',
                'intensity' => $exercise->intensity ?? 'Moderate',
                'weight' => $exercise->weight ?? 'Yes',
                'weight_value' => $exercise->weight_value ?? '',
                'notes' => $exercise->notes ?? ''
            ]);

            // Copy alternate exercises
            $this->copyAlternateExercises($exercise, $newExercise);
        }
    }

    /**
     * Ensure the target week model has at least target_day_number days; return the NewExerciseWeekDay model for that day.
     * $targetWeekModel is instance of NewExerciseWeek (existing or newly created).
     * $targetDayNumber is 1-based index.
     */
    private function ensureTargetDayExists($targetWeekModel, $dayNumber)
    {
        return NewExerciseWeekDay::firstOrCreate([
            'new_exercise_week_id' => $targetWeekModel->id,
            'day_number' => $dayNumber,
        ], [
            'title' => "Day {$dayNumber} Workout",
            'summary' => "Workout plan for day {$dayNumber}",
            'duration' => 30,
        ]);
    }

    /**
     * Copy a single exercise item (sourceExerciseModel or by id) into target week/day (models).
     * $sourceExercise is the NewExerciseWeekDayItem model (source).
     * $targetWeekModel is NewExerciseWeek instance (target program).
     * $targetDayNumber is integer day position within the target week (1-based).
     */
    private function copyExerciseToTargetWeekDay($sourceExercise, $targetWeekModel, $targetDayNumber)
    {
        $targetDay = $this->ensureTargetDayExists($targetWeekModel, $targetDayNumber);

        $newExercise = NewExerciseWeekDayItem::firstOrCreate([
            'new_exercise_week_day_id' => $targetDay->id,
            'item_id' => $sourceExercise->item_id,
        ], [
            'exercise_list_id' => $sourceExercise->exercise_list_id,
            'name' => $sourceExercise->name ?? '',
            'sets' => $sourceExercise->sets ?? '',
            'reps' => $sourceExercise->reps ?? '',
            'rest' => $sourceExercise->rest ?? '',
            'tempo' => $sourceExercise->tempo ?? '',
            'intensity' => $sourceExercise->intensity ?? 'Moderate',
            'weight' => $sourceExercise->weight ?? 'Yes',
            'weight_value' => $sourceExercise->weight_value ?? '',
            'notes' => $sourceExercise->notes ?? ''
        ]);

        // Copy alternate exercises
        $sourceExerciseWithAlternates = NewExerciseWeekDayItem::with('alternateExercises')
            ->find($sourceExercise->id);
        
        if ($sourceExerciseWithAlternates) {
            $this->copyAlternateExercises($sourceExerciseWithAlternates, $newExercise);
        }
    }

    private function copyFullWeekContent($sourceWeekId, $targetWeekModel)
    {
        $sourceWeek = NewExerciseWeek::with('days.exerciseItems.alternateExercises')->findOrFail($sourceWeekId);

        // Delete existing days in target week
        NewExerciseWeekDay::where('new_exercise_week_id', $targetWeekModel->id)->delete();

        foreach ($sourceWeek->days as $day) {
            $newDay = NewExerciseWeekDay::create([
                'new_exercise_week_id' => $targetWeekModel->id,
                'day_number' => $day->day_number,
                'title' => $day->title,
                'summary' => $day->summary,
                'duration' => $day->duration,
            ]);

            foreach ($day->exerciseItems as $exercise) {
                $newExercise = NewExerciseWeekDayItem::create([
                    'new_exercise_week_day_id' => $newDay->id,
                    'item_id' => $exercise->item_id,
                    'exercise_list_id' => $exercise->exercise_list_id,
                    'name' => $exercise->name ?? '',
                    'sets' => $exercise->sets ?? '',
                    'reps' => $exercise->reps ?? '',
                    'rest' => $exercise->rest ?? '',
                    'tempo' => $exercise->tempo ?? '',
                    'intensity' => $exercise->intensity ?? 'Moderate',
                    'weight' => $exercise->weight ?? 'Yes',
                    'weight_value' => $exercise->weight_value ?? '',
                    'notes' => $exercise->notes ?? ''
                ]);

                // Copy alternate exercises
                $this->copyAlternateExercises($exercise, $newExercise);
            }
        }
    }

    private function copyPartialDaysContent($sourceWeekId, $targetWeekModel, $sourceDayIds)
    {
        if (empty($sourceDayIds)) return;

        $sourceWeek = NewExerciseWeek::with('days.exerciseItems')->findOrFail($sourceWeekId);
        $targetDays = $targetWeekModel->days()->orderBy('day_number')->get()->keyBy('day_number');

        foreach ($sourceDayIds as $sourceDayId) {
            $sourceDay = NewExerciseWeekDay::with('exerciseItems')->findOrFail($sourceDayId);
            $sourceDayNumber = $sourceDay->day_number;

            // Ensure target day exists
            $targetDay = NewExerciseWeekDay::firstOrCreate(
                ['new_exercise_week_id' => $targetWeekModel->id, 'day_number' => $sourceDayNumber],
                [
                    'title' => $sourceDay->title,
                    'summary' => $sourceDay->summary,
                    'duration' => $sourceDay->duration
                ]
            );

            // Update day metadata
            $targetDay->update([
                'title' => $sourceDay->title,
                'summary' => $sourceDay->summary,
                'duration' => $sourceDay->duration
            ]);

            // Delete existing exercises
            $targetDay->exerciseItems()->delete();

            // Copy exercises with proper item_id
            foreach ($sourceDay->exerciseItems as $exercise) {
                NewExerciseWeekDayItem::create([
                    'new_exercise_week_day_id' => $targetDay->id,
                    'item_id' => $exercise->item_id,
                    'exercise_list_id' => $exercise->exercise_list_id,
                    'name' => $exercise->name ?? '',
                    'sets' => $exercise->sets ?? '',
                    'reps' => $exercise->reps ?? '',
                    'rest' => $exercise->rest ?? '',
                    'tempo' => $exercise->tempo ?? '',
                    'intensity' => $exercise->intensity ?? 'Moderate',
                    'weight' => $exercise->weight ?? 'Yes',
                    'weight_value' => $exercise->weight_value ?? '',
                    'notes' => $exercise->notes ?? ''
                ]);
            }
        }
    }

    private function createDefaultDays($weekId)
    {

        for ($dayNum = 1; $dayNum <= 7; $dayNum++) {
            NewExerciseWeekDay::create([
                'new_exercise_week_id' => $weekId,
                'day_number' => $dayNum,
                'title' => 'Day' . $dayNum . ' Workout',
                'summary' => "",
                'duration' => 30
            ]);
        }
    }

    // Update copyFullWeek similarly
    private function copyFullWeek($sourceWeekId, $targetWeekId)
    {
        $sourceWeek = NewExerciseWeek::with('days.exerciseItems')->findOrFail($sourceWeekId);

        foreach ($sourceWeek->days()->orderBy('day_number')->get() as $sourceDay) {
            $dayNumber = $sourceDay->day_number ?: 1;

            $newDay = NewExerciseWeekDay::updateOrCreate(
                ['new_exercise_week_id' => $targetWeekId, 'day_number' => $dayNumber],
                ['title' => $sourceDay->title, 'summary' => $sourceDay->summary, 'duration' => $sourceDay->duration]
            );

            $newDay->exerciseItems()->delete();

            // Only copy exercises with actual data
            $filledExercises = $sourceDay->exerciseItems()->orderBy('item_id')->get()->filter(function ($exercise) {
                return !empty($exercise->exercise_list_id)
                    || (!empty($exercise->sets) && $exercise->sets !== '')
                    || (!empty($exercise->reps) && $exercise->reps !== '')
                    || (!empty($exercise->rest) && $exercise->rest !== '');
            });

            foreach ($filledExercises as $exercise) {
                $itemId = $exercise->item_id ?: ($newDay->exerciseItems()->max('item_id') + 1 ?? 1);

                NewExerciseWeekDayItem::create([
                    'new_exercise_week_day_id' => $newDay->id,
                    'item_id' => $itemId,
                    'exercise_list_id' => $exercise->exercise_list_id,
                    'name' => $exercise->name,
                    'sets' => $exercise->sets,
                    'reps' => $exercise->reps,
                    'rest' => $exercise->rest,
                    'tempo' => $exercise->tempo,
                    'intensity' => $exercise->intensity,
                    'weight' => $exercise->weight,
                    'weight_value' => $exercise->weight_value,
                    'notes' => $exercise->notes
                ]);
            }
        }
    }

    private function copyFullDay($sourceDayId, $targetWeekId, $targetDayNumber)
    {
        $sourceDay = NewExerciseWeekDay::with('exerciseItems.alternateExercises')->findOrFail($sourceDayId);
    
        $targetDay = NewExerciseWeekDay::updateOrCreate(
            ['new_exercise_week_id' => $targetWeekId, 'day_number' => $targetDayNumber],
            ['title' => $sourceDay->title ?: "Day {$targetDayNumber} Workout", 'summary' => $sourceDay->summary, 'duration' => $sourceDay->duration]
        );
    
        $targetDay->exerciseItems()->delete();
    
        // Only copy exercises with actual data
        $filledExercises = $sourceDay->exerciseItems()->with('alternateExercises')->orderBy('item_id')->get()->filter(function ($exercise) {
            return !empty($exercise->exercise_list_id)
                || (!empty($exercise->sets) && $exercise->sets !== '')
                || (!empty($exercise->reps) && $exercise->reps !== '')
                || (!empty($exercise->rest) && $exercise->rest !== '');
        });
    
        foreach ($filledExercises as $exercise) {
            $itemId = $exercise->item_id ?: ($targetDay->exerciseItems()->max('item_id') + 1 ?? 1);
    
            $newExercise = NewExerciseWeekDayItem::create([
                'new_exercise_week_day_id' => $targetDay->id,
                'item_id' => $itemId,
                'exercise_list_id' => $exercise->exercise_list_id,
                'name' => $exercise->name,
                'sets' => $exercise->sets,
                'reps' => $exercise->reps,
                'rest' => $exercise->rest,
                'tempo' => $exercise->tempo,
                'intensity' => $exercise->intensity,
                'weight' => $exercise->weight,
                'weight_value' => $exercise->weight_value,
                'notes' => $exercise->notes
            ]);
    
            // Copy alternate exercises
            $this->copyAlternateExercises($exercise, $newExercise);
        }
    }

    private function copySingleExercise($exerciseId, $targetWeekId, $targetDayNumber)
    {
        $sourceExercise = NewExerciseWeekDayItem::with('alternateExercises')->findOrFail($exerciseId);
    
        // Verify exercise has meaningful data before copying
        if (
            empty($sourceExercise->exercise_list_id)
            && empty($sourceExercise->sets)
            && empty($sourceExercise->reps)
            && empty($sourceExercise->rest)
        ) {
            return;
        }
    
        $targetDay = NewExerciseWeekDay::firstOrCreate(
            ['new_exercise_week_id' => $targetWeekId, 'day_number' => $targetDayNumber],
            ['title' => "Day {$targetDayNumber} Workout", 'summary' => '', 'duration' => '']
        );
    
        // Find first empty exercise in the target day
        $emptyExercise = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $targetDay->id)
            ->where(function ($q) {
                $q->whereNull('exercise_list_id')
                    ->where(function ($q2) {
                        $q2->whereNull('sets')->orWhere('sets', '');
                    })
                    ->where(function ($q3) {
                        $q3->whereNull('reps')->orWhere('reps', '');
                    });
            })
            ->orderBy('item_id', 'asc')
            ->first();
    
        if ($emptyExercise) {
            $emptyExercise->update([
                'exercise_list_id' => $sourceExercise->exercise_list_id,
                'name' => $sourceExercise->name,
                'sets' => $sourceExercise->sets,
                'reps' => $sourceExercise->reps,
                'rest' => $sourceExercise->rest,
                'tempo' => $sourceExercise->tempo,
                'intensity' => $sourceExercise->intensity,
                'weight' => $sourceExercise->weight,
                'weight_value' => $sourceExercise->weight_value,
                'notes' => $sourceExercise->notes,
            ]);
    
            // Copy alternate exercises to updated exercise
            $this->copyAlternateExercises($sourceExercise, $emptyExercise);
        } else {
            $maxItemId = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $targetDay->id)->max('item_id') ?? 0;
            $newItemId = $maxItemId + 1;
    
            $newExercise = NewExerciseWeekDayItem::create([
                'new_exercise_week_day_id' => $targetDay->id,
                'item_id' => $newItemId,
                'exercise_list_id' => $sourceExercise->exercise_list_id,
                'name' => $sourceExercise->name,
                'sets' => $sourceExercise->sets,
                'reps' => $sourceExercise->reps,
                'rest' => $sourceExercise->rest,
                'tempo' => $sourceExercise->tempo,
                'intensity' => $sourceExercise->intensity,
                'weight' => $sourceExercise->weight,
                'weight_value' => $sourceExercise->weight_value,
                'notes' => $sourceExercise->notes,
            ]);
    
            // Copy alternate exercises to new exercise
            $this->copyAlternateExercises($sourceExercise, $newExercise);
        }
    }
    
/**
 * Helper method to copy alternate exercises from source to target exercise
 */
private function copyAlternateExercises($sourceExercise, $targetExercise)
{
    if ($sourceExercise->alternateExercises && $sourceExercise->alternateExercises->count() > 0) {
        foreach ($sourceExercise->alternateExercises as $alternate) {
            // Attach alternate with pivot data
            $targetExercise->alternateExercises()->attach($alternate->id, [
                'sets' => $alternate->pivot->sets ?? null,
                'reps' => $alternate->pivot->reps ?? null,
                'rest' => $alternate->pivot->rest ?? null,
                'tempo' => $alternate->pivot->tempo ?? null,
                'intensity' => $alternate->pivot->intensity ?? null,
                'weight' => $alternate->pivot->weight ?? $alternate->weight ?? 'No',
                'weight_value' => $alternate->pivot->weight_value ?? $alternate->weight_value ?? null,
                'notes' => $alternate->pivot->notes ?? $alternate->notes ?? null,
            ]);
        }
    }
}

    public function updatedMappings($value, $key)
    {
        // This will be triggered whenever any mapping changes
        // Useful for real-time validation
        $this->validateMappings();
    }

    private function validateMappings()
    {
        $usedTargetWeeks = [];
        $usedTargetDays = [];

        foreach ($this->mappings as $key => $mapping) {
            if ($mapping['type'] === 'fullWeek') {
                if (empty($mapping['targetWeek'])) {
                    return false;
                }

                $targetWeek = $mapping['targetWeek'];

                // Check availability in existing program
                if ($this->copyMode === 'existing' && $this->selectedExistingProgram) {
                    if (!empty($this->weekDayAvailability[$targetWeek])) {
                        $weekData = $this->weekDayAvailability[$targetWeek];
                        
                        // Week is NOT available for FULL WEEK copy if it has ANY filled days
                        if (!$weekData['available'] || ($weekData['hasAnyDay'] ?? false)) {
                            $takenCount = $weekData['takenDays'] ?? 0;
                            if ($takenCount >= 7) {
                                $this->dispatch('show-error', message: "Target Week {$targetWeek} is completely full. All 7 days already have exercises.");
                            } else {
                                $this->dispatch('show-error', message: "Target Week {$targetWeek} already has {$takenCount} day(s) with exercises. Full week copy requires a completely empty week.");
                            }
                            return false;
                        }
                    }
                }

                // Check if week is already used by another full week mapping
                if (isset($usedTargetWeeks[$targetWeek])) {
                    $this->dispatch('show-error', message: "Target Week {$targetWeek} is assigned to multiple source weeks. Each target week can only receive content from one source.");
                    return false;
                }

                $usedTargetWeeks[$targetWeek] = $mapping['sourceWeekNumber'];
                
            } elseif ($mapping['type'] === 'fullDay') {
                if (empty($mapping['targetWeek']) || empty($mapping['targetDay'])) {
                    return false;
                }

                $targetWeek = $mapping['targetWeek'];
                $targetDay = $mapping['targetDay'];
                $dayKey = "{$targetWeek}_{$targetDay}";

                // Check availability in existing program
                if ($this->copyMode === 'existing' && $this->selectedExistingProgram) {
                    if (!empty($this->weekDayAvailability[$targetWeek])) {
                        $dayAvailable = $this->weekDayAvailability[$targetWeek]['days'][$targetDay] ?? true;
                        
                        if (!$dayAvailable) {
                            $this->dispatch('show-error', message: "Target Week {$targetWeek}, Day {$targetDay} is already taken. Please select an available day.");
                            return false;
                        }
                    }
                }

                // Check if this week is already used by a full week copy
                if (isset($usedTargetWeeks[$targetWeek])) {
                    $this->dispatch('show-error', message: "Target Week {$targetWeek} is already being used for a full week copy. Cannot add individual days to it.");
                    return false;
                }

                // Check for duplicate day assignments
                if (isset($usedTargetDays[$dayKey])) {
                    $prevSource = $usedTargetDays[$dayKey];
                    $this->dispatch('show-error', message: "Target Week {$targetWeek}, Day {$targetDay} is already assigned to {$prevSource}. Cannot assign it to Week {$mapping['sourceWeekNumber']}, Day {$mapping['sourceDayNumber']} as well.");
                    return false;
                }

                $usedTargetDays[$dayKey] = "Week {$mapping['sourceWeekNumber']}, Day {$mapping['sourceDayNumber']}";
                
            } elseif ($mapping['type'] === 'exercises') {
                foreach ($mapping['exercises'] as $ex) {
                    if (empty($ex['targetWeek']) || empty($ex['targetDay'])) {
                        return false;
                    }

                    $targetWeek = $ex['targetWeek'];
                    $targetDay = $ex['targetDay'];

                    // Check availability in existing program
                    if ($this->copyMode === 'existing' && $this->selectedExistingProgram) {
                        if (!empty($this->weekDayAvailability[$targetWeek])) {
                            $dayAvailable = $this->weekDayAvailability[$targetWeek]['days'][$targetDay] ?? true;
                            
                            // For exercises, we can add to existing days, so this check is optional
                            // You can uncomment if you want strict validation
                            // if (!$dayAvailable) {
                            //     $this->dispatch('show-error', message: "Target Week {$targetWeek}, Day {$targetDay} is already full.");
                            //     return false;
                            // }
                        }
                    }

                    // Check if this week is already used by a full week copy
                    if (isset($usedTargetWeeks[$targetWeek])) {
                        $this->dispatch('show-error', message: "Target Week {$targetWeek} is already being used for a full week copy. Cannot add exercises to it.");
                        return false;
                    }
                }
            }
        }

        return true;
    }
    public function getIsProcessingProperty()
    {
        return $this->isProcessing;
    }

    private function copyToExistingProgram()
    {
        try {
            $this->validate([
                'selectedExistingProgram' => 'required|exists:new_exercises,id',
            ]);

            $targetProgram = NewExercise::findOrFail($this->selectedExistingProgram);

            foreach ($this->mappings as $mapping) {
                if ($mapping['type'] === 'fullWeek') {
                    $targetWeekNum = (int)$mapping['targetWeek'];

                    $targetWeek = NewExerciseWeek::updateOrCreate(
                        ['new_exercise_id' => $targetProgram->id, 'week_number' => $targetWeekNum],
                        []
                    );

                    if ($targetWeek->days()->count() === 0) {
                        $this->createDefaultDays($targetWeek->id);
                    }

                    $this->copyFullWeek($mapping['sourceWeekId'], $targetWeek->id);
                } elseif ($mapping['type'] === 'fullDay') {
                    $targetWeekNum = (int)$mapping['targetWeek'];
                    $targetDayNum = (int)$mapping['targetDay'];

                    $targetWeek = NewExerciseWeek::updateOrCreate(
                        ['new_exercise_id' => $targetProgram->id, 'week_number' => $targetWeekNum],
                        []
                    );

                    if ($targetWeek->days()->count() === 0) {
                        $this->createDefaultDays($targetWeek->id);
                    }

                    $this->copyFullDay($mapping['sourceDayId'], $targetWeek->id, $targetDayNum);
                } elseif ($mapping['type'] === 'exercises') {
                    // Group exercises by their target location
                    $exercisesByTarget = [];
                    foreach ($mapping['exercises'] as $ex) {
                        $targetWeekNum = (int)$ex['targetWeek'];
                        $targetDayNum = (int)$ex['targetDay'];
                        $key = "{$targetWeekNum}_{$targetDayNum}";

                        if (!isset($exercisesByTarget[$key])) {
                            $exercisesByTarget[$key] = [
                                'week' => $targetWeekNum,
                                'day' => $targetDayNum,
                                'exercises' => []
                            ];
                        }
                        $exercisesByTarget[$key]['exercises'][] = $ex;
                    }

                    // Process each target location
                    foreach ($exercisesByTarget as $target) {
                        $targetWeek = NewExerciseWeek::updateOrCreate(
                            ['new_exercise_id' => $targetProgram->id, 'week_number' => $target['week']],
                            []
                        );

                        if ($targetWeek->days()->count() === 0) {
                            $this->createDefaultDays($targetWeek->id);
                        }

                        foreach ($target['exercises'] as $ex) {
                            $this->copySingleExercise($ex['id'], $targetWeek->id, $target['day']);
                        }
                    }
                }
            }

            $this->closeCopyModal();
            $this->reset(['selectedWeeks', 'selectedDays', 'selectedExercises', 'mappings']);

            session()->flash('success', 'Exercises copied successfully!');
            return redirect('/admin/new/exercise/manage')->with('message', 'Program copied successfully!');
        } catch (\Exception $e) {

            $this->dispatch('show-error', message: 'Error: ' . $e->getMessage());
        }
    }

    // New helper method to get max target week
private function getMaxTargetWeek()
{
    $maxWeek = 0;
    foreach ($this->mappings as $mapping) {
        if (!empty($mapping['targetWeek'])) {
            $maxWeek = max($maxWeek, (int)$mapping['targetWeek']);
        }
        if ($mapping['type'] === 'exercises') {
            foreach ($mapping['exercises'] as $ex) {
                if (!empty($ex['targetWeek'])) {
                    $maxWeek = max($maxWeek, (int)$ex['targetWeek']);
                }
            }
        }
    }
    return $maxWeek;
}

// New helper method to create weeks in batch
private function createWeeksBatch($programId, $maxWeek)
{
    $createdWeeks = [];
    $weeksData = [];
    
    for ($weekNum = 1; $weekNum <= $maxWeek; $weekNum++) {
        $weeksData[] = [
            'new_exercise_id' => $programId,
            'week_number' => $weekNum,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    // Bulk insert
    \DB::table('new_exercise_weeks')->insert($weeksData);
    
    // Retrieve created weeks
    $weeks = NewExerciseWeek::where('new_exercise_id', $programId)
        ->whereIn('week_number', range(1, $maxWeek))
        ->get();
    
    foreach ($weeks as $week) {
        $createdWeeks[$week->week_number] = $week;
    }
    
    return $createdWeeks;
}

// New helper method to process mappings in batch
private function processMappingsBatch($createdWeeks)
{
    // Group operations by type for batch processing
    $fullWeeks = [];
    $fullDays = [];
    $exercises = [];
    
    foreach ($this->mappings as $mapping) {
        if ($mapping['type'] === 'fullWeek') {
            $fullWeeks[] = [
                'source' => $mapping['sourceWeekId'],
                'target' => $createdWeeks[(int)$mapping['targetWeek']]
            ];
        } elseif ($mapping['type'] === 'fullDay') {
            $fullDays[] = [
                'source' => $mapping['sourceDayId'],
                'target' => $createdWeeks[(int)$mapping['targetWeek']],
                'dayNum' => (int)$mapping['targetDay']
            ];
        } elseif ($mapping['type'] === 'exercises') {
            foreach ($mapping['exercises'] as $ex) {
                $exercises[] = [
                    'id' => $ex['id'],
                    'target' => $createdWeeks[(int)$ex['targetWeek']],
                    'dayNum' => (int)$ex['targetDay']
                ];
            }
        }
    }
    
    // Process in batches
    foreach ($fullWeeks as $item) {
        $this->copyFullWeek($item['source'], $item['target']->id);
    }
    
    foreach ($fullDays as $item) {
        $this->copyFullDay($item['source'], $item['target']->id, $item['dayNum']);
    }
    
    // Group exercises by target location
    $exercisesByLocation = [];
    foreach ($exercises as $ex) {
        $key = $ex['target']->id . '_' . $ex['dayNum'];
        if (!isset($exercisesByLocation[$key])) {
            $exercisesByLocation[$key] = [
                'target' => $ex['target'],
                'dayNum' => $ex['dayNum'],
                'exercises' => []
            ];
        }
        $exercisesByLocation[$key]['exercises'][] = $ex['id'];
    }
    
    foreach ($exercisesByLocation as $location) {
        foreach ($location['exercises'] as $exerciseId) {
            $this->copySingleExercise($exerciseId, $location['target']->id, $location['dayNum']);
        }
    }
}

    public function checkTargetAvailability($mappingKey, $type, $week = null, $day = null)
    {
        if ($this->copyMode !== 'existing' || !$this->selectedExistingProgram) {
            return true;
        }

        if (!isset($this->weekDayAvailability[$week])) {
            return true;
        }

        if ($type === 'week') {
            return $this->weekDayAvailability[$week]['available'] ?? true;
        } elseif ($type === 'day' && $day) {
            return $this->weekDayAvailability[$week]['days'][$day] ?? true;
        }

        return true;
    }

    /**  get available days in  a week */
    private function getWeekDayAvailability($programId)
    {
        $availability = [];

        for ($weekNum = 1; $weekNum <= 12; $weekNum++) {
            $week = NewExerciseWeek::where('new_exercise_id', $programId)
                ->where('week_number', $weekNum)
                ->first();

            if (!$week) {
                // Week doesn't exist - all days available
                $availability[$weekNum] = [
                    'available' => true,
                    'days' => array_fill(1, 7, true),
                    'takenDays' => 0,
                    'hasAnyDay' => false // NEW: Track if week has any days at all
                ];
            } else {
                $dayAvailability = [];
                $hasAvailableDay = false;
                $allDaysTaken = 0;
                $hasAnyFilledDay = false; // NEW: Track if any day has exercises

                for ($dayNum = 1; $dayNum <= 7; $dayNum++) {
                    $day = NewExerciseWeekDay::where('new_exercise_week_id', $week->id)
                        ->where('day_number', $dayNum)
                        ->first();

                    if (!$day) {
                        $dayAvailability[$dayNum] = true;
                        $hasAvailableDay = true;
                    } else {
                        // Check if any exercise has meaningful data
                        $hasFilledExercises = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $day->id)
                            ->where(function ($q) {
                                $q->whereNotNull('exercise_list_id')
                                    ->orWhere(function ($q2) {
                                        $q2->where('sets', '!=', '')
                                            ->whereNotNull('sets');
                                    })
                                    ->orWhere(function ($q3) {
                                        $q3->where('reps', '!=', '')
                                            ->whereNotNull('reps');
                                    })
                                    ->orWhere(function ($q4) {
                                        $q4->where('rest', '!=', '')
                                            ->whereNotNull('rest');
                                    });
                            })
                            ->exists();

                        $dayAvailability[$dayNum] = !$hasFilledExercises;
                        
                        if ($hasFilledExercises) {
                            $allDaysTaken++;
                            $hasAnyFilledDay = true; // NEW: Mark that week has at least one filled day
                        } else {
                            $hasAvailableDay = true;
                        }
                    }
                }

                // Week is NOT available for FULL WEEK copy if:
                // 1. Any day has filled exercises (even 1 day) - for full week copy
                // 2. But individual days can still be added to available slots
                $availability[$weekNum] = [
                    'available' => !$hasAnyFilledDay, // Week available for FULL WEEK copy only if NO days have exercises
                    'days' => $dayAvailability,
                    'takenDays' => $allDaysTaken,
                    'hasAnyDay' => $hasAnyFilledDay // NEW: Track if week has any filled days
                ];
            }
        }

        return $availability;
    }

    // Update getSelectionCount to only count filled exercises
    public function getSelectionCount()
    {
        // Count only filled exercises that are actually in the selectedExercises array
        $filledExercisesCount = 0;

        foreach ($this->weeks as $week) {
            foreach ($week['days'] as $day) {
                foreach ($day['exercises'] as $exercise) {
                    if (
                        in_array($exercise['id'], $this->selectedExercises ?? [])
                        && $this->isExerciseFilled($exercise)
                    ) {
                        $filledExercisesCount++;
                    }
                }
            }
        }

        return [
            'selectedWeeksCount' => count($this->selectedWeeks ?? []),
            'selectedDaysCount' => count($this->selectedDays ?? []),
            'selectedExercisesCount' => $filledExercisesCount
        ];
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

    // Rest of the existing methods remain the same...
    private function ensureDayHasExercises($dayId)
    {
        $existingCount = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $dayId)->count();
        $targetCount = 6;

        $exercisesToCreate = $targetCount - $existingCount;
        if ($exercisesToCreate > 0) {
            for ($i = 1; $i <= $exercisesToCreate; $i++) {
                $exerciseNumber = $existingCount + $i;
                NewExerciseWeekDayItem::create([
                    'new_exercise_week_day_id' => $dayId,
                    'exercise_list_id' => $this->exerciseLists->first()->id ?? null,
                    'name' => "Exercise {$exerciseNumber}",
                    'sets' => '',
                    'reps' => '',
                    'rest' => '',
                    'tempo' => '',
                    'intensity' => '',
                    'weight' => '',
                    'weight_value' => '',
                    'notes' => ''
                ]);
            }
        }
    }
    
    public function deleteExercise($exerciseId)
    {
        $exercise = NewExerciseWeekDayItem::findOrFail($exerciseId);
        $exercise->delete();

        $this->loadWeeks();
        $this->dispatch('show-success', message: 'Exercise deleted successfully!');
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

    public function getSelectedStructure()
    {
        $structure = [];

        foreach ($this->weeks as $week) {
            // If full week selected
            if (in_array($week['id'], $this->selectedWeeks)) {
                $structure[$week['number']] = [
                    'week' => $week,
                    'isFullWeek' => true,
                    'days' => []
                ];
                continue;
            }

            // Otherwise check days
            $daysData = [];
            foreach ($week['days'] as $day) {
                if (in_array($day['id'], $this->selectedDays)) {
                    // If full day selected
                    $daysData[] = [
                        'id' => $day['id'],
                        'number' => $day['number'],
                        'title' => $day['title'],
                        'isFullDay' => true,
                        'exercises' => []
                    ];
                } elseif (!empty($this->selectedExercises[$day['id']])) {
                    // If specific exercises selected
                    $exercises = collect($day['exercises'])
                        ->whereIn('id', $this->selectedExercises[$day['id']])
                        ->values()
                        ->all();

                    $daysData[] = [
                        'id' => $day['id'],
                        'number' => $day['number'],
                        'title' => $day['title'],
                        'isFullDay' => false,
                        'exercises' => $exercises
                    ];
                }
            }

            if (!empty($daysData)) {
                $structure[$week['number']] = [
                    'week' => $week,
                    'isFullWeek' => false,
                    'days' => $daysData
                ];
            }
        }

        ksort($structure);
        return $structure;
    }

    public function render()
    {
        return view('livewire.duplicate-program', [
            'selectedDayExercises' => $this->getSelectedDayExercises(),
        ]);
    }
}
