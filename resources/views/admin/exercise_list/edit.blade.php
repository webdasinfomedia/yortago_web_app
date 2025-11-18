@extends('admin.layouts.master')
@section('admin_title')
    Edit Exercise List
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .exercise-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card-header-custom {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            border-bottom: 1px solid #ced4da;
            margin: -20px -20px 20px -20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* .card-header-custom.alternative {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        } */
        .card-header-custom h4{
            font-size: 1rem;
            color:#333;
        }
        
        .badge-custom {
            background: rgba(255,255,255,0.3);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
        }
        .form-control{
            font-size:14px !important;
            color: #6e6e6e !important;
        }
        
        .form-label {
            font-weight: 400;
            color: #6e6e6e !important;
            margin-bottom: 8px;
            font-size: 16px;
        }
        
         .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 7px 25px;
            color: white;
            font-weight: 600;
            border-radius: 3.875rem;
        }
        .btn-danger{
            border-radius: 3.875rem;
        }
        
        .alternate-list {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .alternate-item {
            background: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #f5576c;
        }
        
        .alternate-item:last-child {
            margin-bottom: 0;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .exercise-card {
                padding: 15px;
                margin-bottom: 20px;
            }
            
            .card-header-custom {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .row {
                margin: 0;
            }
            
            .col-md-6 {
                padding: 0 5px;
            }
            
            .alternate-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
         .select2-container .select2-selection--single{
                border-radius: 0;
                background: #fff;
                border: 1px solid #ced4da;
                color: #333333;
                height: 56px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            font-size: 14px;
           
            border-radius: 3px;
        }
        .select2-container--default .select2-results>.select2-results__options, .select2-search__field{
                font-size: 14px !important;
                
        }
        .btn-secondary{
            color: #fff;
            background-color: #C046D3;
            border-color: #C046D3;
        }
        .select2-container--default .select2-results>.select2-results__options{
                font-size: 14px !important;
        }
        .text-muted{
            color:#6e6e6e;
        }
        .ck.ck-editor__main>.ck-editor__editable
        {
            font-size: 14px !important;
            height: 200px !important;
        }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused){
            height: 200px !important;
        }
         .btn-secondary:hover{
            background-color: #C046D3 !important;
        }
        /* Select2 Error Styling */
        .select2-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .select2-container--default .select2-selection--single.select2-error {
            border-color: #dc3545 !important;
        }

        /* Validation error message styling */
        .validation-error {
            display: block !important;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            font-weight: 400;
        }

        /* Invalid input styling */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.new.exercise.unified_exercise_management', ['active_tab' => 'exercise-list']) }}">Exercise Management</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Exercise List</a></li>
        </ol>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Exercise Form -->
        <div class="col-lg-6 col-md-6 mb-3">
            <div class="exercise-card">
                <div class="card-header-custom">
                    <h4 class="mb-0">Edit Exercise List</h4>
                    <a href="{{ route('admin.new.exercise.unified_exercise_management', ['active_tab' => 'exercise-list']) }}" class="btn btn-rounded btn-secondary btn-sm"
                           style="float: right">Back</a>
                </div>

                <form method="post" action="{{route('admin.new.exercise.update_exercise_list')}}" enctype="multipart/form-data" id="mainExerciseForm" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{$exercise_list->id}}">
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Enter Name" name="name" value="{{$exercise_list->name}}" required>
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Body Parts <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="body_part_id" required>
                            <option value="">--Select--</option>
                            @foreach($body_parts as $body_part)
                                <option value="{{$body_part->id}}" {{$exercise_list->body_part_id == $body_part->id ? 'selected' : ''}}>{{$body_part->name}}</option>
                            @endforeach
                        </select>
                        @error('body_part_id')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Exercise Style <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="exercise_style_id" required>
                            <option value="">--Select--</option>
                            @foreach($exercise_styles as $exercise_style)
                                <option value="{{$exercise_style->id}}" {{$exercise_list->exercise_style_id == $exercise_style->id ? 'selected' : ''}}>{{$exercise_style->name}}</option>
                            @endforeach
                        </select>
                        @error('exercise_style_id')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Weight Required <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="weight" id="exerciseWeight" required>
                            <option value="Yes" {{$exercise_list->weight == 'Yes' ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{$exercise_list->weight == 'No' ? 'selected' : ''}}>No</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="weightValueDiv" style="display: {{$exercise_list->weight == 'Yes' ? 'block' : 'none'}};">
                        <label class="form-label">Weight (kg)</label>
                        <input type="text" class="form-control" name="weight_value" id="weightValue" value="{{$exercise_list->weight_value}}" placeholder="Enter Weight Value">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">YouTube Link <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="video_link" id="youtubeLink" value="{{$exercise_list->video_link}}" required>
                        <small id="error-message" style="color: red; display: none;">Please enter a valid YouTube link.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control summernote" name="notes" id="exerciseNotes">{!! $exercise_list->notes !!}</textarea>
                    </div>

                  <div class="d-flex justify-content-end mt-4">
                        <!-- <a href="{{route('admin.new.exercise.unified_exercise_management')}}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a> -->
                        <button type="submit" class="btn btn-save btn-primary">
                            <!-- <i class="fa fa-save"></i> Save  -->
                            Update 
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alternative Exercise Form -->
        <div class="col-lg-6 col-md-6 mb-3">
             <div class="exercise-card">
                <div class="card-header-custom alternative">
                    <h4 class="mb-0">Alternative Exercise</h4>
                    <!-- @php
                        $hasAlternate = $alternate_exercises->count() > 0;
                        $alternate = $hasAlternate ? $alternate_exercises->first() : null;
                    @endphp
                    <span class="btn btn-rounded btn-secondary btn-sm">{{ $hasAlternate ? 'Added' : 'Not Added' }}</span> -->
                    <a href="{{ route('admin.new.exercise.unified_exercise_management', ['active_tab' => 'exercise-list']) }}" class="btn btn-rounded btn-secondary btn-sm"
                        style="float: right">Back</a>
                </div>

                @if(!$hasAlternate)
                <div class="alert-info-custom">
                    <i class="fa fa-info-circle"></i> 
                    <strong>Note:</strong> No alternative exercise added yet. You can add one below.
                </div>
                @endif

                <form method="post" action="{{ $hasAlternate ? route('admin.new.exercise.update_alternate_exercise') : route('admin.new.exercise.save_alternate_exercise') }}" enctype="multipart/form-data" id="alternateExerciseForm" novalidate>
                    @csrf
                    <input type="hidden" name="exercise_list_id" value="{{$exercise_list->id}}">
                    @if($hasAlternate)
                        <input type="hidden" name="id" value="{{$alternate->id}}">
                    @endif

                    <div class="form-group mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" id="alternateName" placeholder="Enter Name" name="name" value="{{ $hasAlternate ? $alternate->name : '' }}" required>
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Body Parts <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select-alt" id="alternateBodyPart" name="body_part_id" required>
                            <option value="">--Select--</option>
                            @foreach($body_parts as $body_part)
                                <option value="{{$body_part->id}}" {{ $hasAlternate && $alternate->body_part_id == $body_part->id ? 'selected' : '' }}>{{$body_part->name}}</option>
                            @endforeach
                        </select>
                        @error('body_part_id')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Exercise Style <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select-alt" id="alternateStyle" name="exercise_style_id" required>
                            <option value="">--Select--</option>
                            @foreach($exercise_styles as $exercise_style)
                                <option value="{{$exercise_style->id}}" {{ $hasAlternate && $alternate->exercise_style_id == $exercise_style->id ? 'selected' : '' }}>{{$exercise_style->name}}</option>
                            @endforeach
                        </select>
                        @error('exercise_style_id')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Weight Required <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="weight" id="alternateWeight" required>
                            <option value="">--Select--</option>
                            <option value="Yes" {{ $hasAlternate && $alternate->weight == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $hasAlternate && $alternate->weight == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('weight')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3" id="alternateWeightValueDiv" style="display: {{ $hasAlternate && $alternate->weight == 'Yes' ? 'block' : 'none' }};">
                        <label class="form-label">Weight (kg)</label>
                        <input type="text" class="form-control" name="weight_value" id="alternateWeightValue" value="{{ $hasAlternate ? $alternate->weight_value : '' }}" placeholder="Enter Weight Value">
                        @error('weight_value')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">YouTube Link <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="video_link" id="alternateYoutubeLink" value="{{ $hasAlternate ? $alternate->video_link : '' }}" placeholder="Enter YouTube Link" required>
                        <small id="alternate-error-message" style="color: red; display: none;">Please enter a valid YouTube link.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control summernote" name="notes" id="alternateNotes">{!! $hasAlternate ? $alternate->notes : '' !!}</textarea>
                        @error('notes')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        @if($hasAlternate)
                        <button type="button" class="btn btn-danger" onclick="deleteAlternate({{$alternate->id}})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        @endif
                        <button type="submit" class="btn btn-save btn-primary">
                             {{ $hasAlternate ? 'Update' : 'Save' }} 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

<script>
const editors = {};

// Initialize CKEditor
document.querySelectorAll('.summernote').forEach(element => {
    ClassicEditor
        .create(element, {
            toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'paragraph']
        })
        .then(editor => {
            editors[element.id] = editor;
            editor.ui.view.editable.element.style.height = '200px';

            const form = element.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    element.value = editor.getData();
                });
            }
        })
        .catch(error => {
            console.error(error);
        });
});

// YouTube validation
document.getElementById('youtubeLink').addEventListener('blur', function () {
    validateYoutubeLink(this, 'error-message');
});

document.getElementById('alternateYoutubeLink').addEventListener('blur', function () {
    validateYoutubeLink(this, 'alternate-error-message');
});

function validateYoutubeLink(input, errorId) {
    const errorMessage = document.getElementById(errorId);
    const youtubeRegex = /^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/;

    if (!youtubeRegex.test(input.value) && input.value.trim() !== "") {
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }
}

// Weight toggle
function toggleWeightValueField(value) {
    if (value === 'Yes') {
        $('#weightValueDiv').show();
    } else {
        $('#weightValueDiv').hide();
        $('#weightValue').val('');
    }
}

function toggleAlternateWeightValueField(value) {
    if (value === 'Yes') {
        $('#alternateWeightValueDiv').show();
    } else {
        $('#alternateWeightValueDiv').hide();
        $('#alternateWeightValue').val('');
    }
}

$('#exerciseWeight').on('change', function() {
    toggleWeightValueField($(this).val());
});

$('#alternateWeight').on('change', function() {
    toggleAlternateWeightValueField($(this).val());
});

// Initialize Select2
$(document).ready(function() {
    $('.searchable-select, .searchable-select-alt').select2({
        placeholder: "--Select--",
        allowClear: true,
        width: '100%'
    });

    // Handle validation on change for Select2 - IMPROVED
    $('.searchable-select, .searchable-select-alt').on('change', function() {
        // Remove is-invalid class from select element
        $(this).removeClass('is-invalid');
        
        // Remove error message
        const select2Container = $(this).next('.select2-container');
        if (select2Container.length) {
            // Remove validation error that comes after select2 container
            select2Container.next('.validation-error').remove();
            // Remove is-invalid class from select2 selection
            select2Container.find('.select2-selection').removeClass('is-invalid');
        }
        
        // Also check parent for validation errors
        const errorElement = $(this).closest('.form-group').find('.validation-error');
        if (errorElement.length) {
            errorElement.remove();
        }
    });
});

// Main Exercise Form Validation
document.getElementById('mainExerciseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let isValid = true;
    let firstError = null;
    
    // Clear all previous validation errors - IMPROVED
    document.querySelectorAll('#mainExerciseForm .validation-error').forEach(el => el.remove());
    document.querySelectorAll('#mainExerciseForm .is-invalid').forEach(el => el.classList.remove('is-invalid'));
    $('#mainExerciseForm .select2-selection').removeClass('is-invalid');
    
    // 1. Validate Name
    const name = document.querySelector('#mainExerciseForm input[name="name"]');
    if (!name.value.trim()) {
        isValid = false;
        showValidationError(name, 'The name field is required.');
        if (!firstError) firstError = name;
    }
    
    // 2. Validate Body Part (Select2)
    const bodyPart = document.querySelector('#mainExerciseForm select[name="body_part_id"]');
    if (!bodyPart.value) {
        isValid = false;
        showSelect2ValidationError(bodyPart, 'Please select a body part.');
        if (!firstError) firstError = bodyPart;
    }
    
    // 3. Validate Exercise Style (Select2)
    const exerciseStyle = document.querySelector('#mainExerciseForm select[name="exercise_style_id"]');
    if (!exerciseStyle.value) {
        isValid = false;
        showSelect2ValidationError(exerciseStyle, 'Please select an exercise style.');
        if (!firstError) firstError = exerciseStyle;
    }
    
    // 4. Validate Weight Required (Select2)
    const weight = document.querySelector('#mainExerciseForm select[name="weight"]');
    if (!weight.value) {
        isValid = false;
        showSelect2ValidationError(weight, 'Please select weight requirement.');
        if (!firstError) firstError = weight;
    }
    
    // 5. Validate YouTube Link
    const youtubeLink = document.getElementById('youtubeLink');
    if (!youtubeLink.value.trim()) {
        isValid = false;
        showValidationError(youtubeLink, 'The YouTube link field is required.');
        if (!firstError) firstError = youtubeLink;
    } else {
       const youtubeRegex = /^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/;

        if (!youtubeRegex.test(youtubeLink.value)) {
            isValid = false;
            showValidationError(youtubeLink, 'Please enter a valid YouTube link.');
            if (!firstError) firstError = youtubeLink;
        }
    }
    
    if (!isValid) {
        if (firstError) {
            const offset = firstError.getBoundingClientRect().top + window.pageYOffset - 100;
            window.scrollTo({ top: offset, behavior: 'smooth' });
            
            setTimeout(() => {
                if ($(firstError).hasClass('searchable-select') || $(firstError).hasClass('searchable-select-alt')) {
                    $(firstError).select2('open');
                } else {
                    firstError.focus();
                }
            }, 500);
        }
        return false;
    }
    
    this.submit();
});

// Alternate Exercise Form Validation
document.getElementById('alternateExerciseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let isValid = true;
    let firstError = null;
    
    // Clear all previous validation errors - IMPROVED
    this.querySelectorAll('.validation-error').forEach(el => el.remove());
    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    $(this).find('.select2-selection').removeClass('is-invalid');
    
    // 1. Validate Name
    const name = this.querySelector('input[name="name"]');
    if (!name.disabled && !name.value.trim()) {
        isValid = false;
        showValidationError(name, 'The name field is required.');
        if (!firstError) firstError = name;
    }
    
    // 2. Validate Body Part
    const bodyPart = this.querySelector('select[name="body_part_id"]');
    if (!bodyPart.disabled && !bodyPart.value) {
        isValid = false;
        showSelect2ValidationError(bodyPart, 'Please select a body part.');
        if (!firstError) firstError = bodyPart;
    }
    
    // 3. Validate Exercise Style
    const exerciseStyle = this.querySelector('select[name="exercise_style_id"]');
    if (!exerciseStyle.disabled && !exerciseStyle.value) {
        isValid = false;
        showSelect2ValidationError(exerciseStyle, 'Please select an exercise style.');
        if (!firstError) firstError = exerciseStyle;
    }
    
    // 4. Validate Weight Required
    const weight = this.querySelector('select[name="weight"]');
    if (!weight.disabled && !weight.value) {
        isValid = false;
        showSelect2ValidationError(weight, 'Please select weight requirement.');
        if (!firstError) firstError = weight;
    }
    
    // 5. Validate YouTube Link
    const youtubeLink = document.getElementById('alternateYoutubeLink');
    if (!youtubeLink.disabled) {
        if (!youtubeLink.value.trim()) {
            isValid = false;
            showValidationError(youtubeLink, 'The YouTube link field is required.');
            if (!firstError) firstError = youtubeLink;
        } else {
           const youtubeRegex = /^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/;

            if (!youtubeRegex.test(youtubeLink.value)) {
                isValid = false;
                showValidationError(youtubeLink, 'Please enter a valid YouTube link.');
                if (!firstError) firstError = youtubeLink;
            }
        }
    }
    
    if (!isValid) {
        if (firstError) {
            const offset = firstError.getBoundingClientRect().top + window.pageYOffset - 100;
            window.scrollTo({ top: offset, behavior: 'smooth' });
            
            setTimeout(() => {
                if ($(firstError).hasClass('searchable-select') || $(firstError).hasClass('searchable-select-alt')) {
                    $(firstError).select2('open');
                } else {
                    firstError.focus();
                }
            }, 500);
        }
        return false;
    }
    
    this.submit();
});

// Validation helper functions
function showValidationError(element, message) {
    const errorDiv = document.createElement('small');
    errorDiv.className = 'text-danger validation-error d-block mt-1';
    errorDiv.textContent = message;
    element.parentElement.appendChild(errorDiv);
    element.classList.add('is-invalid');
}

// IMPROVED Select2 Validation Error Function
function showSelect2ValidationError(selectElement, message) {
    // Create error message
    const errorDiv = document.createElement('small');
    errorDiv.className = 'text-danger validation-error d-block mt-1';
    errorDiv.textContent = message;
    
    // Add error message after the Select2 container
    const select2Container = $(selectElement).next('.select2-container');
    if (select2Container.length) {
        select2Container.after(errorDiv);
        // Add error class to the actual select2 selection element
        select2Container.find('.select2-selection').addClass('is-invalid');
    } else {
        selectElement.parentElement.appendChild(errorDiv);
    }
    
    selectElement.classList.add('is-invalid');
}

// Remove validation errors on input
document.querySelectorAll('input, textarea').forEach(element => {
    element.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const validationError = this.parentElement.querySelector('.validation-error');
        if (validationError) {
            validationError.remove();
        }
    });
});

// Delete alternate exercise (Add this for edit.blade.php only)
function deleteAlternate(id) {
    if (confirm('Are you sure you want to delete this alternate exercise?')) {
        $.ajax({
            url: '/admin/new/exercise/alternate-exercise/' + id + '/delete',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Alternate exercise deleted successfully!');
                location.reload();
            },
            error: function() {
                alert('Error deleting alternate exercise');
            }
        });
    }
}
</script>
@endsection