<div>
    <div class="container-fluid">
        <style>
                .week-day-sidebar {
                    background: #ffffff;
                    border: 1px solid #dee2e6;
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
                .main-div{
                background-color: #FDF9F6 !important;
                border: 1px solid #D2D2d2 !important;
                border-radius: 10px !important;
                padding: 15px 12px 15px 25px !important;
                
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
                .btn:hover {
                    color: white;
                    text-decoration: underline !important;
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
                    background: #d76e33;
                    border-color: #d76e33;
                    color: white;
                }

                .btn-danger-custom {
                    background: #dc3545;
                    border-color: #dc3545;
                    color: white;
                }

                .form-control-sm {
                    font-size: 0.675rem;
                    height: 30px;
                }
                .form-control{
                    font-size:14px;
                }
                .left-sidebar-title{
                    font-size: 18px;
                    font-weight: 600;
                }
                .form-label {
                    font-size: 14px;
                }
                .form-check{
                    font-size: 16px;
                    font-weight: 500;
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
                .week-arrow{
                    margin-left: 15px;
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
                .copyprogrambtn , .badge-secondary{
                    background-color: #d76e33;
                    color: white;
                    border: 1px solid #d76e33;
                }
                .programname{
                    font-weight: 600;
                    font-size:20px;
                    color: #333333;
                }
                .selection-checkbox {
                    margin-right: 10px;
                    /*width: 18px;*/
                    /*height: 18px;*/
                    cursor: pointer;
                }
                .card-header{
                    background-color: #d76e33;
                }
                .duplicate-warning {
                background-color: #fff3cd;
                border: 1px solid #ffc107;
                padding: 8px 12px;
                border-radius: 4px;
                margin-top: 8px;
                font-size: 0.85rem;
            }
            
            .taken-slot {
                background-color: #f8d7da !important;
                color: #721c24 !important;
            }
             .select2-container--default .select2-selection--single .select2-selection__rendered{
                color:#6e6e6e !important;
                line-height: 30px !important;
                font-size: 14px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__clear{
                height: 30px !important;
                font-size: 14px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow{
                height: 30px !important;
                font-size: 14px !important;
            }
            .select2-container--default .select2-search--dropdown .select2-search__field {
                color: #6e6e6e;
                border: 1px solid #aaa;
                font-size: 14px;
            }
            .text-muted , .text-info{
                font-size: 14px;
            }
            .text-muted{
                color:#6e6e6e !important;
            }
            .copy-modal .form-group{
                font-size: 14px;
            }
            .copy-modal .form-group label{
                font-size: 16px;
            }
            .modal-title{
                color: #7e7e7e !important;
            }
            .form-check-inline{
                font-size:16px;
            }
            .select2-container--default .select2-results>.select2-results__options{
                font-size: 14px !important;
            }
            .program-type{
                font-size: 14px !important;
                font-weight: 400 !important;
            }
             .btn-primary:hover{
                color: white !important;
            }
        </style>
            
        @if($showCopyModal)
        <form wire:submit.prevent="confirmCopy" enctype="multipart/form-data" action="">
            <div class="modal fade show" style="display:block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="programradio" wire:model.live="copyMode" value="new" id="modeNew">
                                <label class="form-check-label" for="modeNew">Add to New Program</label>
                            </div>
                            <div class="form-check form-check-inline ml-3">
                                <input type="radio" class="form-check-input" name="programradio" wire:model.live="copyMode" value="existing" id="modeExisting">
                                <label class="form-check-label" for="modeExisting">Add to Existing Program</label>
                            </div>
                        </div>
                        <button type="button" class="close" wire:click="closeCopyModal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body copy-modal">
                        {{-- NEW PROGRAM --}}
                        @if($copyMode === 'new')
                            <div class="row">
                                <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="programTitle">Program Title <span class="text-danger">*</span></label>
                                    <input type="text" id="programTitle" class="form-control" wire:model.live="title" placeholder="Enter Program Title">
                                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                                 </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="programCategory">Category <span class="text-danger">*</span></label>
                                        <select id="programCategory" class="form-control" wire:model.live="category_id">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtubeLink">YouTube Playlist Link</label>
                                        <input type="url" id="youtubeLink" class="form-control" 
                                            wire:model.live="youtube_link"
                                            placeholder="Enter YouTube Playlist Link...">
                                        @error('youtube_link') 
                                            <small class="text-danger">{{ $message }}</small> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block mb-2">Program Type <span class="text-danger">*</span></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                wire:model.live="program_type" 
                                                name="program_type" 
                                                id="type_generic_new" 
                                                value="generic">
                                            <label class="form-check-label program-type" for="type_generic_new">Generic</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                wire:model.live="program_type" 
                                                name="program_type" 
                                                id="type_premium_new" 
                                                value="premium">
                                            <label class="form-check-label program-type" for="type_premium_new">Premium</label>
                                        </div>
                                        @error('program_type') 
                                            <small class="text-danger d-block">{{ $message }}</small> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="programImage">Program Image</label>
                                        <input type="file" id="programImage" class="form-control" wire:model="image" accept="image/*">
                                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                
                                        @if ($image)
                                            <div class="mt-2">
                                                <small class="text-success">
                                                    <i class="fa fa-check-circle"></i> Image uploaded: {{ $image->getClientOriginalName() }}
                                                </small>
                                            </div>
                                        @endif
                                        
                                        <div wire:loading wire:target="image" class="text-muted small mt-1">
                                            <i class="fa fa-spinner fa-spin"></i> Uploading...
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif

                        {{-- EXISTING PROGRAM --}}
                        @if($copyMode === 'existing')
                            <div class="form-group">
                                <label for="selectedProgram">Select Program: <span class="text-danger">*</span></label>
                                <select class="form-control" wire:model.live="selectedExistingProgram" id="selectedProgram">
                                    <option value="">-- Select Program --</option>
                                    @foreach($existingPrograms as $program)
                                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                                    @endforeach
                                </select>
                                @error('selectedExistingProgram') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        @endif

                        {{-- MAPPINGS --}}
                        <div class="mt-4">
                            <strong>Map your selections to target program:</strong>
                            <small class="text-muted d-block mb-3">Specify where each selected item should be copied</small>

                            @if(!empty($mappings))
                                @foreach($mappings as $key => $mapping)
                                    <div class="card mb-3 border">
                                        
                                        {{-- FULL WEEK --}}
                                        @if($mapping['type'] === 'fullWeek')
                                            <div class="card-header text-white py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                    <span class="font-weight-bold mr-3">
                                                        Week {{ $mapping['sourceWeekNumber'] }} (Full Week - All Days)
                                                    </span>

                                                    <div class="d-flex align-items-center">
                                                        <label class="mr-2 mb-0 text-white">Copy to Week:</label>
                                                        <select class="form-control form-control-sm" 
                                                            wire:model.live="mappings.{{ $key }}.targetWeek"
                                                            style="width: 130px;">
                                                        <option value="">Select</option>
                                                        @for($w = 1; $w <= 12; $w++)
                                                            @php
                                                                $weekAvailable = true;
                                                                $isUsedByOther = false;
                                                                
                                                                // Check if week is used by another full week mapping
                                                                foreach($mappings as $otherKey => $otherMapping) {
                                                                    if($otherKey !== $key && 
                                                                    $otherMapping['type'] === 'fullWeek' && 
                                                                    isset($otherMapping['targetWeek']) && 
                                                                    $otherMapping['targetWeek'] == $w) {
                                                                        $isUsedByOther = true;
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                // Check availability in existing program
                                                                if($copyMode === 'existing' && $selectedExistingProgram && !empty($weekDayAvailability)) {
                                                                    $weekAvailable = $weekDayAvailability[$w]['available'] ?? false;
                                                                }
                                                                
                                                                $isDisabled = !$weekAvailable || $isUsedByOther;
                                                            @endphp
                                                            <option value="{{ $w }}" 
                                                                    {{ $isDisabled ? 'disabled' : '' }}
                                                                    class="{{ $isUsedByOther ? 'taken-slot' : '' }}">
                                                                Week {{ $w }} 
                                                                @if(!$weekAvailable && $copyMode === 'existing')
                                                                    (No Slots)
                                                                @elseif($isUsedByOther)
                                                                    (Already Selected)
                                                                @endif
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                    $currentTarget = $mapping['targetWeek'] ?? null;
                                                    $isDuplicate = false;
                                                    $duplicateSource = null;
                                                    
                                                    if($currentTarget) {
                                                        foreach($mappings as $otherKey => $otherMapping) {
                                                            if($otherKey !== $key && 
                                                            $otherMapping['type'] === 'fullWeek' && 
                                                            isset($otherMapping['targetWeek']) && 
                                                            $otherMapping['targetWeek'] == $currentTarget) {
                                                                $isDuplicate = true;
                                                                $duplicateSource = "Week " . $otherMapping['sourceWeekNumber'];
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            <div class="card-body p-2">
                                                <small class="text-muted">All days with all exercises will be copied</small>
                                                @if($isDuplicate)
                                                    <div class="alert alert-danger alert-sm mt-2 mb-0 py-1 px-2">
                                                        <i class="fa fa-exclamation-triangle"></i> 
                                                        <strong>Conflict:</strong> Week {{ $currentTarget }} is already assigned to {{ $duplicateSource }}
                                                    </div>
                                                @endif
                                            </div>
                            
                                            {{-- FULL DAY --}}
                                            @elseif($mapping['type'] === 'fullDay')
                                                <div class="card-header text-white py-2">
                                                    <span class="font-weight-bold">
                                                        Week {{ $mapping['sourceWeekNumber'] }} → Day {{ $mapping['sourceDayNumber'] }} (Full Day)
                                                    </span>
                                                    <div class="small">{{ $mapping['sourceDayTitle'] }}</div>
                                                </div>
                                                    @php
                                                        $currentTargetWeek = $mapping['targetWeek'] ?? null;
                                                        $currentTargetDay = $mapping['targetDay'] ?? null;
                                                        $isDayDuplicate = false;
                                                        $duplicateSource = null;
                                                        $conflictWithFullWeek = false;
                                                        
                                                        // Check for full week conflict
                                                        if($currentTargetWeek) {
                                                            foreach($mappings as $otherKey => $otherMapping) {
                                                                if($otherMapping['type'] === 'fullWeek' && 
                                                                isset($otherMapping['targetWeek']) && 
                                                                $otherMapping['targetWeek'] == $currentTargetWeek) {
                                                                    $conflictWithFullWeek = true;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        
                                                        // Check for day duplicate
                                                        if($currentTargetWeek && $currentTargetDay) {
                                                            foreach($mappings as $otherKey => $otherMapping) {
                                                                if($otherKey !== $key && 
                                                                $otherMapping['type'] === 'fullDay' && 
                                                                isset($otherMapping['targetWeek']) && 
                                                                isset($otherMapping['targetDay']) &&
                                                                $otherMapping['targetWeek'] == $currentTargetWeek &&
                                                                $otherMapping['targetDay'] == $currentTargetDay) {
                                                                    $isDayDuplicate = true;
                                                                    $duplicateSource = "Week {$otherMapping['sourceWeekNumber']}, Day {$otherMapping['sourceDayNumber']}";
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                   <div class="card-body p-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="small mb-1">Target Week:</label>
                                                            <select class="form-control form-control-sm" 
                                                                    wire:model.live="mappings.{{ $key }}.targetWeek">
                                                                <option value="">Select Week</option>
                                                                @for($w = 1; $w <= 12; $w++)
                                                                    @php
                                                                        $weekAvailable = true;
                                                                        if($copyMode === 'existing' && $selectedExistingProgram && !empty($weekDayAvailability)) {
                                                                            $weekAvailable = $weekDayAvailability[$w]['available'] ?? true;
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $w }}" {{ !$weekAvailable && $copyMode === 'existing' ? 'disabled' : '' }}>
                                                                        Week {{ $w }} {{ (!$weekAvailable && $copyMode === 'existing') ? '(Full)' : '' }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small mb-1">Target Day:</label>
                                                           <select class="form-control form-control-sm" 
                                                                wire:model.live="mappings.{{ $key }}.targetDay"
                                                                {{ !$currentTargetWeek ? 'disabled' : '' }}>
                                                            <option value="">Select Day</option>
                                                            @for($d = 1; $d <= 7; $d++)
                                                                @php
                                                                    $dayAvailable = true;
                                                                    if($copyMode === 'existing' && $selectedExistingProgram && $currentTargetWeek && !empty($weekDayAvailability)) {
                                                                        $dayAvailable = $weekDayAvailability[$currentTargetWeek]['days'][$d] ?? true;
                                                                    }
                                                                @endphp
                                                                <option value="{{ $d }}" {{ !$dayAvailable && $copyMode === 'existing' ? 'disabled' : '' }}>
                                                                    Day {{ $d }} {{ (!$dayAvailable && $copyMode === 'existing') ? '(Taken)' : '' }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block mt-2">All exercises from this day will be copied</small>
                                                    
                                                   @if($conflictWithFullWeek)
                                                        <div class="duplicate-warning">
                                                            <i class="fa fa-exclamation-triangle"></i> 
                                                            <strong>Conflict:</strong> Week {{ $currentTargetWeek }} is being used for a full week copy
                                                        </div>
                                                    @elseif($isDayDuplicate)
                                                        <div class="duplicate-warning">
                                                            <i class="fa fa-exclamation-triangle"></i> 
                                                            <strong>Conflict:</strong> This target is already assigned to {{ $duplicateSource }}
                                                        </div>
                                                    @endif
                                                    </div>

                                        {{-- INDIVIDUAL EXERCISES --}}
                                        @elseif($mapping['type'] === 'exercises')
                                            <div class="card-header text-white py-2">
                                                <span class="font-weight-bold">
                                                    Week {{ $mapping['sourceWeekNumber'] }} → Day {{ $mapping['sourceDayNumber'] }}
                                                </span>
                                                <div class="small">{{ $mapping['sourceDayTitle'] }} ({{ count($mapping['exercises']) }} selected exercises)</div>
                                            </div>
                                            <div class="card-body p-2">
                                                @foreach($mapping['exercises'] as $exIndex => $exercise)
                                                    @php
                                                        $exTargetWeek = $exercise['targetWeek'] ?? null;
                                                        $conflictWithFullWeek = false;
                                                        
                                                        if($exTargetWeek) {
                                                            foreach($mappings as $otherKey => $otherMapping) {
                                                                if($otherMapping['type'] === 'fullWeek' && 
                                                                isset($otherMapping['targetWeek']) && 
                                                                $otherMapping['targetWeek'] == $exTargetWeek) {
                                                                    $conflictWithFullWeek = true;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="d-flex justify-content-between align-items-center border-bottom py-2 {{ $loop->last ? '' : 'mb-2' }}">
                                                        <div class="flex-grow-1">
                                                            <i class="fa fa-dumbbell text-primary mr-2"></i>
                                                            <span class="small font-weight-bold">{{ $exercise['title'] }}</span>
                                                        </div>
                                                        
                                                        <div class="d-flex align-items-center">
                                                            <label class="mr-2 mb-0 small">Week:</label>
                                                            <select class="form-control form-control-sm mr-2" 
                                                                    wire:model.live="mappings.{{ $key }}.exercises.{{ $exIndex }}.targetWeek"
                                                                    style="width: 80px;">
                                                                <option value="">--</option>
                                                                @for($w = 1; $w <= 12; $w++)
                                                                    @php
                                                                        $weekAvailable = true;
                                                                        if($copyMode === 'existing' && $selectedExistingProgram && !empty($weekDayAvailability)) {
                                                                            $weekAvailable = $weekDayAvailability[$w]['available'] ?? true;
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $w }}" {{ !$weekAvailable && $copyMode === 'existing' ? 'disabled' : '' }}>
                                                                        {{ $w }}{{ (!$weekAvailable && $copyMode === 'existing') ? ' (Full)' : '' }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                            
                                                            <label class="mr-2 mb-0 small">Day:</label>
                                                           <select class="form-control form-control-sm" 
                                                                wire:model.live="mappings.{{ $key }}.exercises.{{ $exIndex }}.targetDay"
                                                                style="width: 80px;"
                                                                {{ !$exTargetWeek ? 'disabled' : '' }}>
                                                            <option value="">--</option>
                                                            @for($d = 1; $d <= 7; $d++)
                                                                @php
                                                                    $dayAvailable = true;
                                                                    if($copyMode === 'existing' && $selectedExistingProgram && $exTargetWeek && !empty($weekDayAvailability)) {
                                                                        $dayAvailable = $weekDayAvailability[$exTargetWeek]['days'][$d] ?? true;
                                                                    }
                                                                @endphp
                                                                <option value="{{ $d }}" {{ !$dayAvailable && $copyMode === 'existing' ? 'disabled' : '' }}>
                                                                    {{ $d }}{{ (!$dayAvailable && $copyMode === 'existing') ? ' (Taken)' : '' }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        </div>
                                                    </div>
                                                     @if($conflictWithFullWeek)
                                                        <div class="duplicate-warning mt-2">
                                                            <i class="fa fa-exclamation-triangle"></i> 
                                                            <small>Week {{ $exTargetWeek }} is being used for a full week copy</small>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    No selections to map.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeCopyModal">Cancel</button>
                        <button type="submit" class="btn btn-success copyprogrambtn"
                                wire:click="confirmCopy" {{ !$copyMode ? 'disabled' : '' }}>
                            @if($copyMode === 'new')
                                Create New Program
                            @elseif($copyMode === 'existing')
                                Copy to Existing Program
                            @else
                                Select Option
                            @endif
                        </button>
                    </div>
                </div>
            </div>
            </div>
         <div class="modal-backdrop fade show"></div>
        </form>
        @endif

        {{-- Copy Program Modal --}}
        <div wire:ignore.self class="modal fade" id="copyProgramModal" tabindex="-1" role="dialog" aria-labelledby="copyProgramModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title" id="copyProgramModalLabel">Copy to New Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeCopyModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body copy-modal">
                        <form wire:submit.prevent="copyProgram" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="programTitle">Program Title <span class="text-danger">*</span></label>
                                        <input type="text" id="programTitle" class="form-control" wire:model.defer="title" placeholder="Enter Program Title">
                                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="programCategory">Category <span class="text-danger">*</span></label>
                                            <select id="programCategory" class="form-control" wire:model.defer="category_id">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtubeLink">YouTube Playlist Link</label>
                                        <input type="url" id="youtubeLink" class="form-control"
                                            wire:model.defer="youtube_link"
                                            placeholder="Enter YouTube Playlist Link...">
                                        @error('youtube_link') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block mb-2">Program Type <span class="text-danger">*</span></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                wire:model.defer="program_type" 
                                                name="program_type_copy" 
                                                id="type_generic_copy" 
                                                value="generic">
                                            <label class="form-check-label program-type" for="type_generic_copy">Generic</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                wire:model.defer="program_type" 
                                                name="program_type_copy" 
                                                id="type_premium_copy" 
                                                value="premium">
                                            <label class="form-check-label program-type" for="type_premium_copy">Premium</label>
                                        </div>
                                        @error('program_type') 
                                            <small class="text-danger d-block">{{ $message }}</small> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="programImage">Program Image</label>
                                        <input type="file" id="programImage" class="form-control" wire:model="image" accept="image/*">
                                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror

                                        @if ($image)
                                            <div class="mt-2">
                                                <small class="text-success">
                                                    <i class="fa fa-check-circle"></i> Image uploaded: {{ $image->getClientOriginalName() }}
                                                </small>
                                            </div>
                                        @endif

                                        <div wire:loading wire:target="image" class="text-muted small mt-1">
                                            <i class="fa fa-spinner fa-spin"></i> Uploading...
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeCopyModal" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success copyprogrambtn">
                                    <i class="fa fa-copy"></i> Create New Program
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>                                                                
    </div>

    <script>
        // Store accordion states
let accordionStates = new Map();
let isInitialized = false;

// Debounce helper
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize only once
function initializeApp() {
    if (isInitialized) return;
    isInitialized = true;

    // Toast notifications
    window.addEventListener('show-success', event => {
        if (typeof toastr !== 'undefined') {
            toastr.success(event.detail.message);
        }
    });

    window.addEventListener('show-error', event => {
        if (typeof toastr !== 'undefined') {
            toastr.error(event.detail.message);
        }
    });

    // Button visibility
    updateButtonVisibility();

    // Modal events
    window.addEventListener('showCopyProgramModal', () => {
        $('#copyProgramModal').modal('show');
    });

    window.addEventListener('hideCopyModal', () => {
        $('#copyProgramModal').modal('hide');
    });

    // Scroll modal event
    window.addEventListener('scroll-modal-to-top', debounce(scrollModalToTop, 100));

    // Week arrow rotation
    window.addEventListener('rotate-week-arrow', function(event) {
        setTimeout(() => {
            const weekId = event.detail.weekId;
            const accordion = document.getElementById('weekDays' + weekId);
            const arrow = document.getElementById('arrow' + weekId);
            
            if (accordion && arrow) {
                accordion.style.display = 'block';
                arrow.classList.add('rotated');
                accordionStates.set(weekId.toString(), true);
            }
        }, 100);
    });

    // Selection changed event
    window.addEventListener('selection-changed', debounce(function() {
        const programCheckbox = document.getElementById('programCheckbox');
        if (programCheckbox?.checked) {
            programCheckbox.checked = false;
        }
        updateButtonVisibility();
    }, 150));
}

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    initAccordionStates();

    // Program checkbox handler
    const programCheckbox = document.getElementById('programCheckbox');
    if (programCheckbox) {
        programCheckbox.addEventListener('change', updateButtonVisibility);
    }
});

function initAccordionStates() {
    document.querySelectorAll('[id^="weekDays"]').forEach(accordion => {
        const weekId = accordion.id.replace('weekDays', '');
        const isOpen = accordion.style.display === 'block';
        accordionStates.set(weekId, isOpen);
    });
}

function toggleAccordion(weekId, event) {
    if (event && (event.target.type === 'checkbox' || event.target.closest('button'))) {
        return;
    }

    const accordion = document.getElementById('weekDays' + weekId);
    const arrow = document.getElementById('arrow' + weekId);

    if (!accordion || !arrow) return;

    const isCurrentlyOpen = accordion.style.display === 'block';

    // Close all other accordions
    document.querySelectorAll('[id^="weekDays"]').forEach(acc => {
        const accWeekId = acc.id.replace('weekDays', '');
        const accArrow = document.getElementById('arrow' + accWeekId);
        
        if (accWeekId != weekId) {
            acc.style.display = 'none';
            if (accArrow) accArrow.classList.remove('rotated');
            accordionStates.set(accWeekId.toString(), false);
        }
    });

    // Toggle current accordion
    if (isCurrentlyOpen) {
        accordion.style.display = 'none';
        arrow.classList.remove('rotated');
        accordionStates.set(weekId.toString(), false);
    } else {
        accordion.style.display = 'block';
        arrow.classList.add('rotated');
        accordionStates.set(weekId.toString(), true);
    }
}

function toggleAccordionExercise(exerciseId, event) {
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

function updateButtonVisibility() {
    const programCheckbox = document.getElementById('programCheckbox');
    const copyExerciseBtn = document.querySelector('.copy-exercise-btn');
    const copyProgramBtn = document.querySelector('.copy-program-btn');
    const programText = document.querySelector('.program-selection-text');
    const exerciseText = document.querySelector('.exercise-selection-text');
    
    if (programCheckbox?.checked) {
        copyExerciseBtn?.classList.add('d-none');
        copyProgramBtn?.classList.remove('d-none');
        if (programText) programText.style.display = 'block';
        if (exerciseText) exerciseText.style.display = 'none';
    } else {
        copyExerciseBtn?.classList.remove('d-none');
        copyProgramBtn?.classList.add('d-none');
        if (programText) programText.style.display = 'none';
        if (exerciseText) exerciseText.style.display = 'block';
    }
}

function scrollModalToTop() {
    const modalBody = document.querySelector('.modal-dialog-scrollable .modal-body');
    if (!modalBody) return;

    setTimeout(() => {
        const titleInput = document.getElementById('programTitle');
        const categoryInput = document.getElementById('programCategory');
        
        const titleError = titleInput?.closest('.form-group')?.querySelector('.text-danger');
        const categoryError = categoryInput?.closest('.form-group')?.querySelector('.text-danger');
        
        const titleHasError = titleError?.textContent.trim() !== '';
        const categoryHasError = categoryError?.textContent.trim() !== '';
        
        modalBody.scrollTo({ top: 0, behavior: 'smooth' });
        
        if (titleHasError && titleInput && !titleInput.disabled) {
            setTimeout(() => titleInput.focus(), 300);
        } else if (categoryHasError && categoryInput && !categoryInput.disabled) {
            setTimeout(() => categoryInput.focus(), 300);
        }
    }, 200);
}

function restoreAccordions() {
    const activeWeekId = @this.get('activeWeekAccordion');
    
    if (activeWeekId) {
        const activeAccordion = document.getElementById('weekDays' + activeWeekId);
        const activeArrow = document.getElementById('arrow' + activeWeekId);
        if (activeAccordion && activeArrow) {
            activeAccordion.style.display = 'block';
            activeArrow.classList.add('rotated');
            accordionStates.set(activeWeekId.toString(), true);
        }
    }

    accordionStates.forEach((isOpen, weekId) => {
        const accordion = document.getElementById('weekDays' + weekId);
        const arrow = document.getElementById('arrow' + weekId);
        if (!accordion || !arrow) return;

        if (isOpen) {
            accordion.style.display = 'block';
            arrow.classList.add('rotated');
        } else {
            accordion.style.display = 'none';
            arrow.classList.remove('rotated');
        }
    });
}

// Livewire hooks - optimized
document.addEventListener('livewire:load', function() {
    initAccordionStates();
});

document.addEventListener('livewire:update', debounce(function() {
    restoreAccordions();
    
    document.querySelectorAll('[id^="weekDays"]').forEach(accordion => {
        const weekId = accordion.id.replace('weekDays', '');
        const arrow = document.getElementById('arrow' + weekId);
        
        if (accordion && arrow) {
            if (accordion.style.display === 'block') {
                arrow.classList.add('rotated');
                accordionStates.set(weekId, true);
            } else {
                arrow.classList.remove('rotated');
                accordionStates.set(weekId, false);
            }
        }
    });
}, 100));

document.addEventListener('livewire:updated', debounce(function() {
    setTimeout(() => {
        document.querySelectorAll('[id^="weekDays"]').forEach(accordion => {
            const weekId = accordion.id.replace('weekDays', '');
            const arrow = document.getElementById('arrow' + weekId);
            
            if (accordion && arrow && accordion.style.display === 'block') {
                arrow.classList.add('rotated');
                accordionStates.set(weekId, true);
            }
        });
    }, 50);
}, 100));
                
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
     
    <div class="main-div ">
        <div class="d-flex justify-content-between align-items-center  mb-2">
            <div class="programname"><input type="checkbox" class="program-checkbox p-2" id="programCheckbox"> &nbsp;Program Title : {{ ucfirst($exercise['title']) }}</div>
                <a href="{{ route('admin.new.exercise.manage') }}" class="btn btn-rounded btn-secondary btn-sm">
                    Back to Programs
                </a>
            </div>
            
            <div class="row">
                <!-- Left Sidebar: Weeks & Days -->
                <div class="col-md-4 week-day-sidebar">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-primary mb-0 left-sidebar-title">Weeks & Days</h6>
                    </div>

                    <!-- Weeks List -->
                    <div class="weeks-container">
                        @foreach($weeks as $week)
                            <div class="week-card" wire:key="week-{{ $week['id'] }}">
                                <!-- Week Header -->
                                <div class="week-header {{ $selectedWeekId === $week['id'] ? 'active' : '' }}"
                                    onclick="toggleAccordion({{ $week['id'] }}, event)">
                                    
                                    <div class="week-header-content">
                                        <input type="checkbox" 
                                            class="selection-checkbox week-checkbox " 
                                            wire:click.stop="toggleWeek({{ $week['id'] }})"
                                            @if(in_array($week['id'], $selectedWeeks ?? [])) checked @endif
                                            onclick="event.stopPropagation()">

                                        <i id="arrow{{ $week['id'] }}" 
                                        class="fa fa-chevron-right accordion-arrow week-arrow {{ in_array($week['id'], $openAccordions) ? 'rotated' : '' }}"></i>
                                        
                                        <strong>Week {{ $week['number'] }}</strong>
                                        <small class="text-muted ml-2">({{ count($week['days']) }} days)</small>
                                    </div>
                                    <div class="week-actions" onclick="event.stopPropagation();">
                                        @if(count($weeks) > 1)
                                        <button type="button"
                                                    wire:click="deleteWeek({{ $week['id'] }})"
                                                    wire:confirm="Are you sure you want to delete this week?"
                                                    class="btn btn-danger-custom btn-action"
                                                    title="Delete Week">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Week Days - ADD wire:ignore HERE -->
                                <div id="weekDays{{ $week['id'] }}" 
                                    style="display: none;" 
                                    wire:ignore.self>
                                    @foreach($week['days'] as $day)
                                        <div class="day-item {{ $selectedDayId === $day['id'] ? 'active' : '' }}"
                                                wire:click="selectWeekAndDay({{ $week['id'] }}, {{ $day['id'] }})"
                                                wire:key="day-{{ $day['id'] }}">
                                            
                                            <input type="checkbox" 
                                                class="selection-checkbox day-checkbox"
                                                wire:click.stop="toggleDay({{ $day['id'] }})"
                                                @if(in_array($day['id'], $selectedDays ?? [])) checked @endif
                                                onclick="event.stopPropagation()">

                                            <div class="flex-grow-1" style="flex: 1;">
                                                <strong>Day {{ $day['number'] }}</strong>
                                                <div class="small text-muted mt-1">
                                                    {{ $day['title'] }}
                                                </div>
                                                @if($day['duration'])
                                                    <div class="small text-info">
                                                        {{ $day['duration'] }} min
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="day-actions" onclick="event.stopPropagation();">
                            
                                                @if(count($week['days']) > 1)
                                                <button type="button"
                                                            wire:click="deleteDay({{ $day['id'] }})"
                                                            wire:confirm="Are you sure you want to delete this day?"
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

                    <!-- Copy Controls -->
                    <div class="mt-3 text-center">
                        <button type="button" wire:click="openCopyModal" class="btn btn-success-custom btn-sm copy-exercise-btn">
                            <i class="fa fa-copy"></i> Copy Exercises
                        </button>
                        <button type="button" wire:click="openCopyProgramModal({{ $exercise['id'] }})"
                                class="btn btn-success-custom btn-sm copy-program-btn d-none">
                            <i class="fa fa-copy"></i> Copy Program
                        </button>

                        <small class="text-muted d-block mt-2" id="selectionCountText">
                            @php
                                $selectionCount = $this->getSelectionCount();
                                $programCheckbox = false; // This will be controlled by JavaScript
                            @endphp
                            
                            <span class="program-selection-text" style="display: none;">
                                <strong>1 Program Selected (Full Program)</strong>
                            </span>
                            
                            <span class="exercise-selection-text">
                                Selected: 
                                <span id="weekCount">{{ $selectionCount['selectedWeeksCount'] }}</span> weeks, 
                                <span id="dayCount">{{ $selectionCount['selectedDaysCount'] }}</span> days, 
                                <span id="exerciseCount">{{ $selectionCount['selectedExercisesCount'] }}</span> exercises
                            </span>
                        </small>
                    </div>
                </div>

                <!-- Right Side: Exercises -->
                <div class="col-md-8">
                    <div class="exercise-content" style="padding: 20px; border: 1px solid #dee2e6; background: #ffffff;">
                        @if($selectedDayId)
                            @php
                                $selectedDay = null;
                                $selectedWeek = null;
                                
                                foreach($weeks as $week) {
                                    foreach($week['days'] as $day) {
                                        if($day['id'] == $selectedDayId) {
                                            $selectedDay = $day;
                                            $selectedWeek = $week;
                                            break 2;
                                        }
                                    }
                                }
                            @endphp

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="text-primary mb-1">
                                        Week {{ $selectedWeek['number'] }} - {{ $selectedDay['title'] }}
                                    </h5>
                                    @if($selectedDay['summary'])
                                        <small class="text-muted">{{ $selectedDay['summary'] }}</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Exercises -->
                            @forelse($selectedDayExercises as $exerciseIndex => $exercise)
                                @php
                                    // Skip empty exercises in display
                                    $hasData = !empty($exercise['exercise_list_id']) 
                                        || (!empty($exercise['sets']) && $exercise['sets'] !== '') 
                                        || (!empty($exercise['reps']) && $exercise['reps'] !== '')
                                        || (!empty($exercise['rest']) && $exercise['rest'] !== '');
                                @endphp
                            
                                @if($hasData)
                                    <div class="exercise-card" wire:key="exercise-{{ $exercise['id'] }}">
                                        <div class="exercise-header" 
                                            onclick="toggleAccordionExercise({{ $exercise['id'] }}, event)">
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" 
                                                    class="selection-checkbox exercise-checkbox"
                                                    wire:click.stop="toggleExercise({{ $exercise['id'] }})"
                                                    @if(in_array($exercise['id'], $selectedExercises ?? [])) checked @endif
                                                    onclick="event.stopPropagation()">
                                
                                                <i id="exerciseArrow{{ $exercise['id'] }}" 
                                                class="fa fa-chevron-right accordion-arrow rotated"></i>
                                
                                                <!-- <i class="fa fa-dumbbell mr-2 text-primary"></i> -->
                                                <strong>Exercise {{ $exerciseIndex + 1 }}</strong>
                                                @if($exercise['exercise_list_id'] && $exerciseLists->find($exercise['exercise_list_id']))
                                                    <span class="ml-2 text-muted">- {{ $exerciseLists->find($exercise['exercise_list_id'])->name }}</span>
                                                @endif
                                            </div>
                                            <button type="button"
                                                    wire:click="deleteExercise({{ $exercise['id'] }})"
                                                    wire:confirm="Are you sure you want to delete this exercise?"
                                                    class="btn btn-danger-custom btn-action"
                                                    title="Delete Exercise">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                
                                        <div id="exerciseBody{{ $exercise['id'] }}" class="card-body" style="display: block;">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Exercise List</label>
                                                    <select class="form-control form-control-sm" disabled>
                                                        <option value="">--Select Exercise--</option>
                                                        @foreach($exerciseLists as $list)
                                                            
                                                            <option value="{{ $list->id }}" {{ $exercise['exercise_list_id'] == $list->id ? 'selected' : '' }}>
                                                                {{ $list->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Sets</label>
                                                    <input type="text" class="form-control form-control-sm p-0 text-center"
                                                        value="{{ $exercise['sets'] }}" readonly>
                                                </div>
                                
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Reps</label>
                                                    <input type="text" class="form-control form-control-sm p-0 text-center"
                                                        value="{{ $exercise['reps'] }}" readonly>
                                                </div>
                                
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Rest</label>
                                                    <input type="text" class="form-control form-control-sm p-0 text-center"
                                                        value="{{ $exercise['rest'] }}" readonly>
                                                </div>
                                
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Tempo</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $exercise['tempo'] }}" readonly>
                                                </div>
                                
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Intensity</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $exercise['intensity'] }}" readonly>
                                                </div>
                                
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Weight</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $exercise['weight'] }}" readonly>
                                                </div>
                                                <!-- Weight Value -->
                                                <div class="col-md-2 mb-3" id="weightValueDiv{{ $exercise['id'] }}" style="display: {{ $exercise['weight'] === 'Yes' ? 'block' : 'none' }};">
                                                    <label class="form-label">Weight(kg)</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $exercise['weight_value'] ?? '' }}" readonly>
                                                </div>
                                            </div>
                                
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Instructions/Notes</label>
                                                    <textarea class="form-control" rows="2" readonly>{{ strip_tags(html_entity_decode($exercise['notes'] ?? '')) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-5">
                                    <i class="fa fa-dumbbell fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No exercises found</h5>
                                    <p class="text-muted">This day has no exercises</p>
                                </div>
                            @endforelse
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Select a day to view exercises</h5>
                                <p class="text-muted">Choose a week and day from the sidebar</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>