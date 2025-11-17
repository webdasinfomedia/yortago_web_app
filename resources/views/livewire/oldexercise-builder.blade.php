<div>
    <div class="container-fluid">
        <style>
            .week-day-sidebar {
                background: #ffffff;
                border-right: 1px solid #dee2e6;
                min-height: 80vh;
                padding: 15px;
            }

            .week-card {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 10px;
                overflow: hidden;
            }

            .week-header {
                background: #fff;
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
                cursor: pointer;
                transition: all 0.3s ease;
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .week-header:hover {
                background: #f8f9fa;
            }

            .week-header.active {
                background: linear-gradient(to right, #fff0e2ff, #ffdfccff);
                border-left: 4px solid #ff6600ff;
                font-weight: 600;
            }

            .week-header-content {
                display: flex;
                align-items: center;
                flex: 1;
            }

            .week-actions {
                display: flex;
                gap: 5px;
                flex-shrink: 0;
            }

            .day-item {
                padding: 10px 15px;
                border-bottom: 1px solid #f1f1f1;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .day-item:hover {
                background: #f8f9fa;
            }

            .day-item.active {
                background: #d4edda;
                border-left: 3px solid #28a745;
                font-weight: 600;
            }

            .day-item:last-child {
                border-bottom: none;
            }

            .exercise-card {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 15px;
                overflow: hidden;
            }

            .exercise-header {
                background: #ffffff;
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
            }

            .btn-action {
                font-size: 19px;
                padding: 0px 7px;
                margin-left: 5px;
            }

            .btn-primary-custom {
                background: linear-gradient(to right, #d38d49, #d76e33);
                border-color: #d76e33;
                color: white;
            }

            .btn-warning-custom {
                background: linear-gradient(to right, #d38d49, #d76e33); 
                border-color: #d76e33;
                color: white;
            }

            .btn-success-custom {
                background: #28a745;
                border-color: #28a745;
                color: white;
            }

            .btn-danger-custom {
                background: #ff4255ee;
                color: white;
                border: none;
            }

            .form-control-sm {
                font-size: 0.675rem;
                height: 30px;
            }
            .form-control{
                font-size: 12px !important;
            }
            .form-label {
                font-size: 0.775rem;
            }

            .modal-backdrop {
                z-index: 1040;
            }

            .modal {
                z-index: 1050;
            }

            .exercise-content {
                padding: 20px;
                border:1px solid #dee2e6; 
                background: #ffffff;
            }
            .programname{
                font-weight: bold;
            }

            .day-actions {
                display: flex;
                gap: 5px;
            }
            .add-day-btn{
                font-size: 14px;
                cursor: pointer !important;
            }
            
            /* Custom accordion styles */
            .accordion-arrow {
                transition: transform 0.2s ease;
                margin-right: 8px;
            }
            
            .accordion-arrow.rotated {
                transform: rotate(90deg);
            }

            /* Prevent text selection on accordion headers */
            .week-header, .exercise-header {
                user-select: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
            }
            .exercise-errors, .exercise-alert{
                color: red;
                background-color: white;
                border: none;
            }
            .select2-dropdown--below , .select2-dropdown--above{
             width: 470px !important;
            }
            .select2-container .select2-selection--single{
                    border-radius: 0;
                    background: #fff;
                    border: 1px solid #f0f1f5;
                    color: #7e7e7e;
                    font-size: 12px;
                    font-family: 'poppins', sans-serif;

                    /* height: 56px; */
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered{
                color:#6e6e6e !important;
                line-height: 30px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__clear{
                height: 30px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow{
                height: 30px !important;
            }
            .card-body {
                flex: 1 1 auto;
                min-height: 1px;
                padding: 0.75rem !important;
            }
        </style>

        <!-- Day Title Modal -->
        @if($showTitleModal)
            <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Day Title</h5>
                            <button type="button" class="close" wire:click="closeTitleModal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveDayTitle">
                                <div class="form-group">
                                    <label for="dayTitle">Day Title *</label>
                                    <input type="text" 
                                        class="form-control @error('dayTitle') is-invalid @enderror" 
                                        id="dayTitle" 
                                        wire:model="dayTitle" 
                                        placeholder="Enter day title..."
                                        required>
                                    @error('dayTitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="daySummary">Summary</label>
                                    <textarea class="form-control @error('daySummary') is-invalid @enderror" 
                                            id="daySummary" 
                                            wire:model="daySummary" 
                                            rows="3"
                                            placeholder="Enter day summary..."></textarea>
                                    @error('daySummary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="dayDuration">Duration(min)</label>
                                    <input type="text" 
                                        class="form-control @error('dayDuration') is-invalid @enderror" 
                                        id="dayDuration" 
                                        wire:model="dayDuration" 
                                        placeholder="Enter day duration...">
                                    @error('dayDuration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeTitleModal">Cancel</button>
                            <button type="button" class="btn btn-primary" wire:click="saveDayTitle">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>

    <script>
        // Livewire event listeners for success/error messages
        document.addEventListener('DOMContentLoaded', function() {
            $('.searchable-select').select2({
                placeholder: "--Select--",
                allowClear: true,
                width: 'auto',
                dropdownAutoWidth: true
            });
            window.addEventListener('show-success', event => {
                // You can integrate with your existing alert system
                if (typeof toastr !== 'undefined') {
                    toastr.success(event.detail.message);
                } else {
                    alert('Success: ' + event.detail.message);
                }
            });

            window.addEventListener('show-error', event => {
                // You can integrate with your existing alert system
                if (typeof toastr !== 'undefined') {
                    toastr.error(event.detail.message);
                } else {
                    alert('Error: ' + event.detail.message);
                }
            });
        });

        // Custom accordion toggle function - FIXED VERSION
        function toggleAccordion(weekId, event) {
            // Prevent propagation if clicked on buttons
            if (event && (event.target.closest('.week-actions') || event.target.closest('button'))) {
                return;
            }

            const accordion = document.getElementById('weekDays' + weekId);
            const arrow = document.getElementById('arrow' + weekId);
            
            if (accordion) {
                if (accordion.style.display === 'none' || accordion.style.display === '') {
                    accordion.style.display = 'block';
                    if (arrow) arrow.classList.add('rotated');
                } else {
                    accordion.style.display = 'none';
                    if (arrow) arrow.classList.remove('rotated');
                }
            }
        }

        // Custom exercise accordion
        function toggleAccordionExercise(exerciseId, event) {
            // Prevent propagation if clicked on buttons
            if (event && (event.target.closest('button') || event.target.tagName === 'BUTTON')) {
                return;
            }

            const body = document.getElementById('exerciseBody' + exerciseId);
            const arrow = document.getElementById('exerciseArrow' + exerciseId);

            if (!body) return;

            if (body.style.display === 'none' || body.style.display === '') {
                body.style.display = 'block';
                if (arrow) arrow.classList.add('rotated');
            } else {
                body.style.display = 'none';
                if (arrow) arrow.classList.remove('rotated');
            }
        }

        // Initialize accordion state after Livewire updates
        document.addEventListener('livewire:load', function () {
            // Set initial accordion states
            @foreach($weeks as $week)
                const accordion{{ $week['id'] }} = document.getElementById('weekDays{{ $week['id'] }}');
                const arrow{{ $week['id'] }} = document.getElementById('arrow{{ $week['id'] }}');
                
                @if($activeWeekAccordion === $week['id'])
                    if (accordion{{ $week['id'] }}) accordion{{ $week['id'] }}.style.display = 'block';
                    if (arrow{{ $week['id'] }}) arrow{{ $week['id'] }}.classList.add('rotated');
                @else
                    if (accordion{{ $week['id'] }}) accordion{{ $week['id'] }}.style.display = 'none';
                    if (arrow{{ $week['id'] }}) arrow{{ $week['id'] }}.classList.remove('rotated');
                @endif
            @endforeach

            @foreach($exerciseLists as $exercise)
                let weightSelect{{ $exercise['id'] }} = document.querySelector('#exerciseWeight{{ $exercise['id'] }}');
                let weightDiv{{ $exercise['id'] }} = document.querySelector('#weightValueDiv{{ $exercise['id'] }}');

                if(weightSelect{{ $exercise['id'] }}) {
                    weightSelect{{ $exercise['id'] }}.addEventListener('change', function() {
                        if(this.value === 'Yes') {
                            weightDiv{{ $exercise['id'] }}.style.display = 'block';
                        } else {
                            weightDiv{{ $exercise['id'] }}.style.display = 'none';
                        }
                    });
                }
            @endforeach
        });

        // Reinitialize after Livewire updates
        // document.addEventListener('livewire:update', function () {
        //     // Set accordion states after updates
        //     @foreach($weeks as $week)
        //         const accordion{{ $week['id'] }} = document.getElementById('weekDays{{ $week['id'] }}');
        //         const arrow{{ $week['id'] }} = document.getElementById('arrow{{ $week['id'] }}');
                
        //         @if($activeWeekAccordion === $week['id'])
        //             if (accordion{{ $week['id'] }}) accordion{{ $week['id'] }}.style.display = 'block';
        //             if (arrow{{ $week['id'] }}) arrow{{ $week['id'] }}.classList.add('rotated');
        //         @else
        //             if (accordion{{ $week['id'] }}) accordion{{ $week['id'] }}.style.display = 'none';
        //             if (arrow{{ $week['id'] }}) arrow{{ $week['id'] }}.classList.remove('rotated');
        //         @endif
        //     @endforeach
        // });
        document.addEventListener('livewire:update', function () {
            document.querySelectorAll('.accordion-arrow').forEach(arrow => {
                if (arrow.closest('.week-card').querySelector('.week-header').classList.contains('active')) {
                    arrow.classList.add('rotated');
                } else {
                    arrow.classList.remove('rotated');
                }
            });
        });



    // Global validation function
function validateField(input) {
    const value = input.value.trim();
    let error = "";

    if (value === "") {
        error = `${capitalize(input.name)} is required.`;
    } else if (isNaN(value) || parseInt(value) <= 0) {
        error = `${capitalize(input.name)} must be a number greater than 0.`;
    }
    else if (parseInt(value) > 999) {  // 👈 max 3 digits
        error = `${capitalize(input.name)} cannot exceed 3 digits value.`;
    }

    const exerciseCard = input.closest(".exercise-card");
    const errorList = exerciseCard.querySelector(".exercise-error-list");
    const errorContainer = errorList.parentElement;

    if (error) {
        input.classList.add("is-invalid");

        // Clear the input value
        input.value = "";

        // Add/update error in the list
        let li = errorList.querySelector(`li[data-field="${input.name}"]`);
        if (!li) {
            li = document.createElement("li");
            li.setAttribute("data-field", input.name);
            errorList.appendChild(li);
        }
        li.textContent = error;

        // Show error container
        errorContainer.style.display = "block";

        // Clear any existing timeout for this field
        if (input.dataset.timeoutId) {
            clearTimeout(parseInt(input.dataset.timeoutId));
        }

        // Auto-hide after 5 seconds
        const timeoutId = setTimeout(() => {
            input.classList.remove("is-invalid");
            let li = errorList.querySelector(`li[data-field="${input.name}"]`);
            if (li) li.remove();

            // Hide container if no more errors
            errorContainer.style.display =
                errorList.children.length > 0 ? "block" : "none";
            
            delete input.dataset.timeoutId;
        }, 10000);

        // Store timeout ID on the input element
        input.dataset.timeoutId = timeoutId;
    } else {
        input.classList.remove("is-invalid");

        // Clear any pending timeout
        if (input.dataset.timeoutId) {
            clearTimeout(parseInt(input.dataset.timeoutId));
            delete input.dataset.timeoutId;
        }

        // Remove error if exists
        let li = errorList.querySelector(`li[data-field="${input.name}"]`);
        if (li) li.remove();

        // Toggle visibility
        errorContainer.style.display =
            errorList.children.length > 0 ? "block" : "none";
    }
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Attach validation to all exercise fields
function attachValidation() {
    const fields = document.querySelectorAll(".exercise-field");
    
    fields.forEach(field => {
        // Check if already has listener to avoid duplicates
        if (!field.dataset.validationAttached) {
            field.addEventListener("blur", function () {
                validateField(this);
            });
            field.dataset.validationAttached = "true";
        }
    });
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
    attachValidation();
});

// Re-attach after Livewire updates
window.addEventListener('livewire:load', function () {
    attachValidation();
    
    // Listen for Livewire updates
    Livewire.hook('message.processed', (message, component) => {
        setTimeout(() => {
            attachValidation();
        }, 100);
    });

     // Add event delegation for alternate exercise weight selects
    document.addEventListener('change', function(e) {
        if (e.target.id && e.target.id.startsWith('altWeight')) {
            const alternateId = e.target.id.replace('altWeight', '');
            const weightDiv = document.getElementById('altWeightValueDiv' + alternateId);
            
            if (weightDiv) {
                weightDiv.style.display = e.target.value === 'Yes' ? 'block' : 'none';
            }
        }
    });
});

// Fallback: Use MutationObserver to detect DOM changes
if (typeof MutationObserver !== 'undefined') {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                attachValidation();
            }
        });
    });

    // Start observing when DOM is ready
    document.addEventListener("DOMContentLoaded", function() {
        const targetNode = document.querySelector('.exercise-content');
        if (targetNode) {
            observer.observe(targetNode, {
                childList: true,
                subtree: true
            });
        }
    });
}


    </script> 
    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="d-flex justify-content-between align-items-center  mb-2">
        <div class="programname">Program Title : {{ $this->exercise->title }}</div>
        <a href="{{ route('admin.new.exercise.manage') }}" class="btn btn-rounded btn-secondary btn-sm">
            Back to Programs
        </a>
    </div>

    <div class="row">
        <!-- Left Sidebar: Weeks & Days -->
        <div class="col-md-4 week-day-sidebar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-primary mb-0">Weeks & Days</h6>
                <div>
                    <!-- <button type="button" wire:click="ensureAllDaysHaveMinimumExercises" class="btn btn-info btn-sm mr-1" title="Ensure all days have 6 exercises">
                        <i class="fa fa-sync"></i> Fix All
                    </button> -->
                    <button type="button" wire:click="addWeek" class="btn btn-warning-custom btn-sm">
                        <i class="fa fa-plus"></i> Add Week
                    </button>
                </div>
            </div>

            <!-- Weeks List -->
            <div class="weeks-container">
                @foreach($weeks as $weekIndex => $week)
                    <div class="week-card" wire:key="week-{{ $week['id'] }}">
                        <!-- Week Header - FIXED VERSION -->
                        <!--<div class="week-header {{ $selectedWeekId === $week['id'] ? 'active' : '' }}"-->
                        <!--     onclick="toggleAccordion({{ $week['id'] }}, event); @this.selectWeek({{ $week['id'] }})">-->
                        <div class="week-header {{ $selectedWeekId === $week['id'] ? 'active' : '' }}"
                            wire:click="toggleWeek({{ $week['id'] }})">
                            
                            <!--<div class="week-header-content">-->
                            <!--    <i id="arrow{{ $week['id'] }}" class="fa fa-chevron-right accordion-arrow {{ $activeWeekAccordion === $week['id'] ? 'rotated' : '' }}"></i>-->
                            <!--    <i class="fa fa-calendar-week mr-2"></i>-->
                            <!--    <strong>Week {{ $week['number'] }}</strong>-->
                            <!--    <small class="text-muted ml-2">({{ count($week['days']) }} days)</small>-->
                            <!--</div>-->
                            <div class="week-header-content">
                                <i id="arrow{{ $week['id'] }}" 
                                   class="fa fa-chevron-right accordion-arrow {{ $activeWeekAccordion === $week['id'] ? 'rotated' : '' }}"></i>
                                <i class="fa fa-calendar-week mr-2"></i>
                                <strong>Week {{ $week['number'] }}</strong>
                                <small class="text-muted ml-2">({{ count($week['days']) }} days)</small>
                            </div>
                            
                            <div class="week-actions" onclick="event.stopPropagation();">
                                @if(count($week['days']) < 7)
                                <button type="button" 
                                        wire:click.stop="addDay({{ $week['id'] }})" 
                                        class="btn btn-success-custom btn-action add-day-btn"
                                        title="Add Day">
                                    Add Day
                                </button>
                                @endif
                                @if(count($weeks) > 1)
                                    <button type="button"
                                            onclick="if(confirm('Are you sure you want to delete this week?')) { @this.deleteWeek({{ $week['id'] }}) }"
                                            class="btn btn-danger-custom btn-action"
                                            title="Delete Week">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Week Days -->
                        <!--<div id="weekDays{{ $week['id'] }}" -->
                        <!--     style="display: {{ $activeWeekAccordion === $week['id'] ? 'block' : 'none' }};">-->
                        <div id="weekDays{{ $week['id'] }}" 
                             style="display: {{ $activeWeekAccordion === $week['id'] ? 'block' : 'none' }};">

                            @foreach($week['days'] as $dayIndex => $day)
                                <div class="day-item {{ $selectedDayId === $day['id'] ? 'active' : '' }}"
                                     wire:click="selectDay({{ $day['id'] }})"
                                     wire:key="day-{{ $day['id'] }}">
                                  
                                    <div class="flex-grow-1" style="flex: 1;">
                                        <i class="fa fa-calendar-day mr-2"></i>
                                        <strong>Day {{ $day['number'] }}</strong>
                                        <div class="small text-muted mt-1">
                                             <i class="fa fa-clock mr-2"></i>
                                            {{ $day['title'] ?: 'Title Not Added' }}
                                        </div>
                                        @if($day['duration'])
                                            <div class="small text-info">
                                                <i class="fa fa-clock mr-2"></i>{{ $day['duration'] }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="day-actions" onclick="event.stopPropagation();">
                                        <button type="button"
                                                wire:click.stop="openTitleModal({{ $day['id'] }})" 
                                                class="btn btn-warning-custom btn-action"
                                                title="Edit Title">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                       @if(count($week['days']) > 1)
                                            <button type="button"
                                                    onclick="if(confirm('Are you sure you want to delete this day?')) { @this.deleteDay({{ $day['id'] }}) }"
                                                    class="btn btn-danger-custom btn-action"
                                                    title="Delete Day">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Exercises -->
        <div class="col-md-8">
            <div class="exercise-content">
                @if($selectedDayId)
                    @php
                        $selectedDay = null;
                        $selectedWeek = null;
                        $selectedWeekNumber = null;
                        
                        foreach($weeks as $week) {
                            foreach($week['days'] as $day) {
                                if($day['id'] == $selectedDayId) {
                                    $selectedDay = $day;
                                    $selectedWeek = $week;
                                    $selectedWeekNumber = $week['number'];
                                    break 2;
                                }
                            }
                        }
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="text-primary mb-1">
                            Week {{ $selectedWeekNumber }} - {{ $selectedDay['title'] ?? 'Day Exercises' }}</h5>
                            @if($selectedDay['summary'])
                                <small class="text-muted">{{ $selectedDay['summary'] }}</small>
                            @endif
                        </div>
                    </div>

                    <!-- Exercises -->
                    @forelse($selectedDayExercises as $exerciseIndex => $exercise)
                       <div class="exercise-card" wire:key="exercise-{{ $exercise['id'] }}">
                        <div class="exercise-header" 
                            onclick="toggleAccordionExercise({{ $exercise['id'] }}, event)">
                            <div class="d-flex align-items-center">
                                <i id="exerciseArrow{{ $exercise['id'] }}" 
                                class="fa fa-chevron-right mr-2 accordion-arrow {{ $exercise['is_open'] ?? true ? 'rotated' : '' }}">
                                </i>
                                <i class="fa fa-dumbbell mr-2 text-primary"></i>
                                <strong>Exercise {{ $exerciseIndex + 1 }}</strong>
                                @if($exercise['exercise_list_id'] && $exerciseLists->find($exercise['exercise_list_id']))
                                    <span class="ml-2 text-muted">- {{ $exerciseLists->find($exercise['exercise_list_id'])->name }}</span>
                                @endif
                            </div>
                           <button type="button"
                                    onclick="if(confirm('Are you sure you want to delete this exercise?')) { @this.deleteExercise({{ $exercise['id'] }}) }"
                                    class="btn btn-danger-custom btn-action"
                                    title="Delete Exercise">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                        <!-- Main Exercise Body -->
                        <div id="exerciseBody{{ $exercise['id'] }}" class="card-body" style="display: block;">
                            <!-- Your existing exercise form fields here (from document 3) -->
                            <div class="row">
                                <!-- Exercise Selection -->
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Exercise List</label>
                                    <select class="form-control form-control-sm searchable-select"
                                            wire:change="updateExercise({{ $exercise['id'] }}, 'exercise_list_id', $event.target.value)">
                                        <option value="">--Select Exercise--</option>
                                        @foreach($exerciseLists as $list)
                                            <option value="{{ $list->id }}" {{ $exercise['exercise_list_id'] == $list->id ? 'selected' : '' }}>
                                                {{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sets -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Sets</label>
                                    <input type="text" name="sets" class="form-control form-control-sm p-0 text-center exercise-field"    
                                        value="{{ $exercise['sets'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'sets', $event.target.value)">
                                </div>

                                <!-- Reps -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Reps</label>
                                    <input type="text" name="reps" class="form-control form-control-sm p-0 text-center exercise-field"
                                        value="{{ $exercise['reps'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'reps', $event.target.value)">
                                </div>

                                <!-- Rest -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Rest</label>
                                    <input type="text" name="rest" class="form-control form-control-sm p-0 text-center exercise-field"
                                        value="{{ $exercise['rest'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'rest', $event.target.value)">
                                </div>

                                <!-- Tempo -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Tempo</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $exercise['tempo'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'tempo', $event.target.value)">
                                </div>

                                <!-- Intensity -->
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Intensity</label>
                                    <select class="form-control form-control-sm"
                                            wire:change="updateExercise({{ $exercise['id'] }}, 'intensity', $event.target.value)">
                                        <option value="">--Select Intensity--</option>
                                        <option value="Low" {{ $exercise['intensity'] === 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Moderate" {{ $exercise['intensity'] === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="High" {{ $exercise['intensity'] === 'High' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>

                                <!-- Weight -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Weight</label>
                                    <select class="form-control form-control-sm" id="exerciseWeight{{ $exercise['id'] }}"
                                            wire:change="updateExercise({{ $exercise['id'] }}, 'weight', $event.target.value)">
                                        <option value="Yes" {{ $exercise['weight'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ $exercise['weight'] === 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <!-- Weight Value -->
                                <div class="col-md-2 mb-1" id="weightValueDiv{{ $exercise['id'] }}" style="display: {{ $exercise['weight'] === 'Yes' ? 'block' : 'none' }};">
                                    <label class="form-label">Weight(kg)</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $exercise['weight_value'] ?? '' }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'weight_value', $event.target.value)">
                                </div>
                            </div>

                            <div class="row  exercise-errors">
                                <div class="col-12">
                                    <div class="alert alert-danger py-2 px-3 exercise-alert">
                                        <ul class="mb-0 exercise-error-list"></ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Notes -->
                                <div class="col-12 mb-1">
                                    <label class="form-label">Instructions/Notes</label>
                                    <textarea class="form-control" rows="2"
                                            wire:blur="updateExercise({{ $exercise['id'] }}, 'notes', $event.target.value)">{{ strip_tags(html_entity_decode($exercise['notes'] ?? '')) }}</textarea>
                                </div>
                            </div>

                            <!-- Alternate Exercise Button -->
                           
                            @if($exercise['exercise_list_id'])
                                @php
                                    // Check if there are ANY alternates for this exercise (linked or not)
                                    $hasAlternates = \App\Models\AlternateExerciseList::where('exercise_list_id', $exercise['exercise_list_id'])
                                        ->exists();
                                    
                                    // Check if there are available (unlinked) alternates
                                    $hasAvailableAlternates = \App\Models\AlternateExerciseList::where('exercise_list_id', $exercise['exercise_list_id'])
                                        ->whereNull('new_exercise_week_day_item_id')
                                        ->exists();
                                    
                                    // Or check if there are alternates not linked to THIS specific exercise item
                                    $hasUnlinkedAlternates = \App\Models\AlternateExerciseList::where('exercise_list_id', $exercise['exercise_list_id'])
                                        ->where(function($query) use ($exercise) {
                                            $query->whereNull('new_exercise_week_day_item_id')
                                                ->orWhere('new_exercise_week_day_item_id', '!=', $exercise['id']);
                                        })
                                        ->exists();
                                @endphp
                                
                                @if($hasUnlinkedAlternates)
                                    <div class="row mt-2">
                                        <div class="col-12 text-right">
                                            <button type="button" 
                                                    wire:click="addAlternateExercise({{ $exercise['id'] }})"
                                                    class="btn btn-primary-custom btn-sm"
                                                    title="Add Alternate Exercise">
                                                <i class="fa fa-plus"></i> Add Alternate
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <!-- Alternate Exercises Section -->
                    
                       @if(isset($exercise['alternates']) && count($exercise['alternates']) > 0)
                        <div class="mt-2 pt-2 border-top">
                            <h6 class="text-primary mb-3">
                                <i class="fa fa-exchange-alt"></i> Alternate Exercises
                            </h6>

                            @foreach($exercise['alternates'] as $altIndex => $alternate)
                                <div class="card mb-1 border-primary" wire:key="alternate-{{ $exercise['id'] }}-{{ $alternate['id'] }}">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <strong>Alternate {{ $altIndex + 1 }}: {{ $alternate['name'] }}</strong>
                                        <button type="button"
                                                onclick="event.stopPropagation(); if(confirm('Are you sure you want to remove this alternate exercise?')) { @this.deleteAlternateExercise({{ $alternate['id'] }}) }"
                                                class="btn btn-danger-custom btn-sm"
                                                title="Remove Alternate">
                                            <i class="fa fa-trash"></i> Remove
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Sets -->
                                            <div class="col-md-2 mb-1">
                                                <label class="form-label">Sets</label>
                                                <input type="text" 
                                                    name="alt_sets_{{ $alternate['id'] }}"
                                                    class="form-control form-control-sm p-0 text-center exercise-field"
                                                    value="{{ $alternate['sets'] }}"
                                                    wire:blur="updateAlternateExercise({{ $alternate['id'] }}, 'sets', $event.target.value)">
                                            </div>

                                            <!-- Reps -->
                                            <div class="col-md-2 mb-1">
                                                <label class="form-label">Reps</label>
                                                <input type="text" 
                                                    name="alt_reps_{{ $alternate['id'] }}"
                                                    class="form-control form-control-sm p-0 text-center exercise-field"
                                                    value="{{ $alternate['reps'] }}"
                                                    wire:blur="updateAlternateExercise({{ $alternate['id'] }}, 'reps', $event.target.value)">
                                            </div>

                                            <!-- Rest -->
                                            <div class="col-md-2 mb-1">
                                                <label class="form-label">Rest</label>
                                                <input type="text" 
                                                    name="alt_rest_{{ $alternate['id'] }}"
                                                    class="form-control form-control-sm p-0 text-center exercise-field"
                                                    value="{{ $alternate['rest'] }}"
                                                    wire:blur="updateAlternateExercise({{ $alternate['id'] }}, 'rest', $event.target.value)">
                                            </div>

                                            <!-- Tempo -->
                                            <div class="col-md-2 mb-1">
                                                <label class="form-label">Tempo</label>
                                                <input type="text" 
                                                    class="form-control form-control-sm p-0 text-center"
                                                    value="{{ $alternate['tempo'] }}"
                                                    wire:blur="updateAlternateExercise({{ $alternate['id'] }}, 'tempo', $event.target.value)">
                                            </div>

                                            <!-- Intensity -->
                                            <div class="col-md-2 mb-1">
                                                <label class="form-label">Intensity</label>
                                                <select class="form-control form-control-sm"
                                                        wire:change="updateAlternateExercise({{ $alternate['id'] }}, 'intensity', $event.target.value)">
                                                    <option value="">-- Select --</option>
                                                    <option value="Low" {{ $alternate['intensity'] === 'Low' ? 'selected' : '' }}>Low</option>
                                                    <option value="Moderate" {{ $alternate['intensity'] === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="High" {{ $alternate['intensity'] === 'High' ? 'selected' : '' }}>High</option>
                                                </select>
                                            </div>

                                            <!-- Weight -->
                                            <div class="col-md-2 mb-1">
                                                <label class="form-label">Weight</label>
                                                <select class="form-control form-control-sm" 
                                                        id="altWeight{{ $alternate['id'] }}"
                                                        wire:change="updateAlternateExercise({{ $alternate['id'] }}, 'weight', $event.target.value)">
                                                    <option value="Yes" {{ $alternate['weight'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $alternate['weight'] === 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <!-- Weight Value -->
                                            <div class="col-md-2 mb-1" 
                                                id="altWeightValueDiv{{ $alternate['id'] }}" 
                                                style="display: {{ $alternate['weight'] === 'Yes' ? 'block' : 'none' }};">
                                                <label class="form-label">Weight(kg)</label>
                                                <input type="text" 
                                                    class="form-control form-control-sm p-0 text-center"
                                                    value="{{ $alternate['weight_value'] ?? '' }}"
                                                    wire:blur="updateAlternateExercise({{ $alternate['id'] }}, 'weight_value', $event.target.value)">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Notes -->
                                            <div class="col-12 mb-1">
                                                <label class="form-label">Instructions/Notes</label>
                                                <textarea class="form-control" 
                                                        rows="2"
                                                        wire:blur="updateAlternateExercise({{ $alternate['id'] }}, 'notes', $event.target.value)">{{ strip_tags(html_entity_decode($alternate['notes'] ?? '')) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                        </div>

                        
                    </div>

                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-dumbbell fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No exercises found</h5>
                            <p class="text-muted">Click on "Days" to preload exercises</p>
                            <!-- <button wire:click="addExercise" class="btn btn-primary-custom">
                                <i class="fa fa-plus"></i> Add First Exercise
                            </button> -->
                        </div>
                    @endforelse
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Select a day to view exercises</h5>
                        <p class="text-muted">Choose a week and day from the sidebar to start building your workout</p>
                    </div>
                @endif
                <div class=" d-flex justify-content-end">
                    <button type="button" wire:click="addExercise" class="btn btn-primary-custom btn-sm">
                        <i class="fa fa-plus"></i> Add Exercise
                    </button>
                    <!-- <button type="button" wire:click="refreshDayExercises" class="btn btn-info btn-sm ml-1" title="Ensure 6 exercises">
                    <i class="fa fa-sync"></i> Refresh
                    </button> -->
                    <button type="button" wire:click="saveAllExercises" class="btn btn-success-custom btn-sm ml-2">
                        <i class="fa fa-save"></i> Save All Exercises
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>