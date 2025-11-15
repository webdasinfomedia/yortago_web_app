@extends('admin.layouts.master')
@section('admin_title')
    Create Exercise List
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
        
        .exercise-card.disabled {
            opacity: 0.6;
            pointer-events: none;
            background: #fff;
        }
        
        .card-header-custom {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 20px -20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* .card-header-custom.alternative {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        } */
       .card-header-custom h4{
            font-size: 18px;
            color:#333;
            
        }
        
        .alert-info-custom {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-control{
            font-size: 14px !important;
            color: #6e6e6e !important;
        }
        .form-label {
            font-weight: 400;
            color: #6e6e6e !important;
            margin-bottom: 8px;
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
        }
        .select2-container .select2-selection--single{
                border-radius: 0;
                background: #fff;
                border: 1px solid #f0f1f5;
                color: #333333;
                height: 56px;
            
        }
        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #fff;
            cursor: default;
        }
        .footer{
            margin-top:8% !important;
        }
        .btn-secondary{
            color: #fff;
            background-color: #C046D3;
            border-color: #C046D3;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #ffffffff;
            opacity: 1;
            font-size: 14px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            font-size: 14px;
        }
        .select2-container--default .select2-results>.select2-results__options , .select2-search__field{
                font-size: 14px !important;
        }
        .text-muted{
            color:#6e6e6e;
        }
        .ck.ck-editor__main>.ck-editor__editable
        {
            font-size: 14px !important;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.new.exercise.unified_exercise_management', ['active_tab' => 'exercise-list']) }}">Exercise Management</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Exercise List</a></li>
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
        <div class="col-lg-6 col-md-6">
            <div class="exercise-card">
                <div class="card-header-custom">
                    <h4 class="mb-0">Create Exercise List</h4>
                    <a href="{{ route('admin.new.exercise.unified_exercise_management', ['active_tab' => 'exercise-list']) }}" class="btn btn-rounded btn-secondary btn-sm"
                           style="float: right">Back</a>
                </div>

                <form method="post" action="{{route('admin.new.exercise.save_exercise_list')}}" enctype="multipart/form-data" id="mainExerciseForm">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Enter Name" name="name" required>
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Body Parts <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="body_part_id" required>
                            <option value="">--Select--</option>
                            @foreach($bodyparts as $body_part)
                                <option value="{{$body_part->id}}">{{$body_part->name}}</option>
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
                                <option value="{{$exercise_style->id}}">{{$exercise_style->name}}</option>
                            @endforeach
                        </select>
                        @error('exercise_style_id')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Weight Required <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="weight"  id="exerciseWeight" required>
                            <option value="">--Select--</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="weightValueDiv" style="display: none;">
                        <label class="form-label">Weight (kg)</label>
                        <input type="text" class="form-control" name="weight_value" id="weightValue" placeholder="Enter Weight Value">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">YouTube Link <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="video_link" id="youtubeLink" placeholder="Enter YouTube Link" required>
                        <small id="error-message" style="color: red; display: none;">Please enter a valid YouTube link.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control summernote" name="notes" id="exerciseNotes"></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <!-- <a href="{{route('admin.new.exercise.unified_exercise_management')}}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a> -->
                        <button type="submit" class="btn btn-save btn-primary">
                            <!-- <i class="fa fa-save"></i> Save  -->
                            Save 
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alternative Exercise Form -->
        <div class="col-lg-6 col-md-6">
            <div class="exercise-card disabled" id="alternativeExerciseCard">
                <div class="card-header-custom alternative">
                    <h4 class="mb-0">Alternative Exercise</h4>
                    <span class="btn btn-rounded btn-secondary btn-sm">Optional</span>
                </div>

                <div class="alert-info-custom">
                    <i class="fa fa-info-circle"></i> 
                    <strong>Note:</strong> Please save the main exercise first before adding alternative exercises.
                </div>

                <form method="post" action="{{route('admin.new.exercise.save_alternate_exercise')}}" enctype="multipart/form-data" id="alternateExerciseForm">
                    @csrf
                    <input type="hidden" name="exercise_list_id" id="mainExerciseId">

                    <div class="form-group mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Enter Name" name="name" disabled>
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Body Parts <span class="text-danger">*</span></label>
                        <select class="form-control" name="body_part_id" disabled>
                            <option value="">--Select--</option>
                            @foreach($bodyparts as $body_part)
                                <option value="{{$body_part->id}}">{{$body_part->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Exercise Style <span class="text-danger">*</span></label>
                        <select class="form-control searchable-select" name="exercise_style_id" disabled>
                            <option value="">--Select--</option>
                            @foreach($exercise_styles as $exercise_style)
                                <option value="{{$exercise_style->id}}">{{$exercise_style->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Weight Required <span class="text-danger">*</span></label>
                        <select class="form-control" name="weight" id="alternateWeight" disabled>
                            <option value="">--Select--</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="alternateWeightValueDiv" style="display: none;">
                        <label class="form-label">Weight (kg)</label>
                        <input type="text" class="form-control" name="weight_value" id="alternateWeightValue" placeholder="Enter Weight Value" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">YouTube Link <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="video_link" id="alternateYoutubeLink" placeholder="Enter YouTube Link" disabled>
                        <small id="alternate-error-message" style="color: red; display: none;">Please enter a valid YouTube link.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control summernote" name="notes" id="alternateNotes" disabled></textarea>
                    </div>
                     <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-save btn-primary mb-3" disabled>
                        <!-- <i class="fa fa-save"></i> Save  -->
                         Save
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

// Initialize CKEditor for all textareas with summernote class
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
    const youtubeLinkInput = document.getElementById('youtubeLink');
    const errorMessage = document.getElementById('error-message');
    
    // Updated regex to handle query parameters after video ID
    const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]{11}(\?[^\s]*)?$/;

    if (!youtubeRegex.test(youtubeLinkInput.value) && youtubeLinkInput.value.trim() !== "") {
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }
});
document.getElementById('alternateYoutubeLink').addEventListener('blur', function () {
    const youtubeLinkInput = document.getElementById('alternateYoutubeLink');
    const errorMessage = document.getElementById('alternate-error-message');
    const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]{11}(\?[^\s]*)?$/;

    if (!youtubeRegex.test(youtubeLinkInput.value) && youtubeLinkInput.value.trim() !== "") {
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }
});


// Weight toggle for main exercise
function toggleWeightValueField(value) {
    if (value === 'Yes') {
        $('#weightValueDiv').show();
    } else {
        $('#weightValueDiv').hide();
        $('#weightValue').val('');
    }
}

$('#exerciseWeight').on('change', function() {
    toggleWeightValueField($(this).val());
});

// Weight toggle for alternate exercise
function toggleAlternateWeightValueField(value) {
    if (value === 'Yes') {
        $('#alternateWeightValueDiv').show();
    } else {
        $('#alternateWeightValueDiv').hide();
        $('#alternateWeightValue').val('');
    }
}

$('#alternateWeight').on('change', function() {
    toggleAlternateWeightValueField($(this).val());
});

// Initialize Select2
$(document).ready(function() {
    $('.searchable-select').select2({
        placeholder: "--Select--",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection