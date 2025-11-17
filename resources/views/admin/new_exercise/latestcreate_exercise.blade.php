@extends('admin.layouts.master')
@section('admin_title')
    Create Exercise
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    .select2-selection{
        display: block !important;
        width: 100% !important;
        /*height: calc(1.5em + 0.75rem + 2px) !important;*/
        padding: 0.375rem 0.75rem !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
        line-height: 1.5 !important;
        color: #495057 !important;
        background-color: #fff !important;
        background-clip: padding-box !important;
        border: 1px solid #f0f1f5 !important;
        border-radius: 0 !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
        height: 57px !important;
    }
    .select2-selection__rendered{
        margin-top: 8px !important;
    }
    .select2-selection__arrow{
        margin-top: 15px !important;
    }
    </style>
@endsection


@section('content')
    <div class="container-fluid">

        <!-- row -->


        <div class="row">

            <div class="col-lg-2 col-md-3">
                <div class="card">

                    <div class="card-body">
                        <div class="d-flex justify-content-between p-2">
                            <div>
                                <p><b>Weeks</b></p>
                            </div>
                            <div>
                                <a href="{{route('admin.new.exercise.add_days_or_weeks',['type' => "week",'id' => request()->id])}}"
                                   class="btn btn-warning btn-xs"><i class="fa fa-plus text-white"></i></a>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            @foreach($exercise?->weeks as $weeks)
                                <div class="d-flex justify-content-between mb-1">
                                    <div class="text-center">
                                        <a href="{{route('admin.new.exercise.create_exercise',['id' => request()->id,'week' =>$weeks->id,'day' => '0' ])}}"
                                           @if(request()->week && request()->week > 0)
                                               @if($weeks->id == request()->week)
                                                   class="text-warning"
                                                @endif
                                                @endif
                                        >
                                            Week {{$loop->index + 1}}
                                        </a>
                                    </div>
                                    <div>
                                        <a onclick="return confirm('Are you sure to perform this action?')"
                                           href="{{route('admin.new.exercise.delete_days_or_weeks',['type' => "week",'id' => $weeks->id])}}"
                                           class="btn btn-danger btn-xs">X</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="card">

                    <div class="card-body">
                        <div class="d-flex justify-content-between p-2">
                            <div>
                                <p><b>Days</b></p>
                            </div>
                            <div>
                                @if(request()->week && request()->week > 0)
                                    <a
{{--                                            data-toggle="modal"--}}
{{--                                       data-target="#exampleModal"--}}
                                                                              href="{{route('admin.new.exercise.add_days_or_weeks',['type' => "day",'id' => request()->week])}}"
                                       class="btn btn-warning btn-xs"><i class="fa fa-plus text-white"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            @if(request()->week && request()->week > 0 && $exercise?->weeks?->where('id',request()->week)->first())
                                @foreach($exercise?->weeks?->where('id',request()->week)->first()?->days as $days)
                                    <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <div class="text-center">
                                            <a href="{{route('admin.new.exercise.create_exercise',['id' => request()->id,'week' =>request()->week,'day' => $days->id ])}}"
                                               @if(request()->day && request()->day > 0)
                                                   @if($days->id == request()->day)
                                                       class="text-warning"
                                                    @endif
                                                    @endif
                                            >
                                                Day {{$loop->index + 1}}

                                            </a>

                                        </div>
                                        <div>
                                            <a href="{{route('admin.new.exercise.add_title',['day_id' => $days->id,'week_id' => request()->week,'id' => request()->id])}}"
                                               class="btn btn-primary btn-xs">Add Title</a>
                                            <a onclick="return confirm('Are you sure to perform this action?')"
                                               href="{{route('admin.new.exercise.delete_days_or_weeks',['type' => "day",'id' => $days->id])}}"
                                               class="btn btn-danger btn-xs">X</a>
                                        </div>
                                    </div>
                                        <small>{{$days->title ?? "Title Not Added"}}</small>
                                    </div>
                                @endforeach
                            @else

                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="card">

                    <div class="card-body">
                        <div class="d-flex justify-content-center p-2">
                            <div>
                                <p><b>Exercises</b></p>
                            </div>
                        </div>
                        @include('partials.alert')
                        <form id="exerciseForm" method="POST"
                              action="{{route('admin.new.exercise.save_day_exercise_item')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div id="exercises">
                                @if(request()->week && request()->week > 0 && request()->day && request()->day > 0)

                                    @if($exercise?->weeks?->where('id',request()->week)->first()?->days?->where('id',request()->day)->first()?->exerciseItems->count() > 0)
                                        @foreach($exercise?->weeks?->where('id',request()->week)->first()?->days?->where('id',request()->day)->first()?->exerciseItems as $item)
                                            <div class="exercise-item">
                                                <!-- Hidden fields for Exercise ID (empty for new exercises) and Day ID (persistent) -->
                                                <input type="hidden" name="exercise_id[]" value="{{$item->id}}">
                                                <input type="hidden" name="day_id[]"
                                                       value="{{$item->new_exercise_week_day_id}}">

                                                <div class="d-flex">
                                                    {{--                                                    <div class="mr-2">--}}
                                                    {{--                                                        <label>Exercise name</label>--}}
                                                    {{--                                                        <input type="text" class="form-control" name="name[]"--}}
                                                    {{--                                                               value="{{$item->name}}" required>--}}
                                                    {{--                                                    </div>--}}
                                                    <div class="mr-2">
                                                        <label>Exercise List</label>
                                                        <select class="form-control" name="exercise_list_id[]" required>
                                                            <option value="">--Select--</option>
                                                            @foreach($exercise_lists as $exercise_list)
                                                                <option value="{{$exercise_list->id}}" {{$exercise_list->id == $item?->exercise_list_id ? 'selected' : ''}}>{{$exercise_list->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="mr-2">
                                                        <label>Sets</label>
                                                        <input type="text" class="form-control" name="sets[]"
                                                               value="{{$item->sets}}" required>
                                                    </div>
                                                    <div class="mr-2">
                                                        <label>Reps</label>
                                                        <input type="text" class="form-control" name="reps[]"
                                                               value="{{$item->reps}}" required>
                                                    </div>

                                                </div>
                                                <div class="d-flex mt-2 justify-content-between">
                                                    <div class="mr-2">
                                                        <label>Rest</label>
                                                        <input type="text" class="form-control" name="rest[]"
                                                               value="{{$item->rest}}" required>
                                                    </div>
                                                    <div class="mr-2">
                                                        <label>Tempo</label>
                                                        <input type="text" class="form-control" name="tempo[]"
                                                               value="{{$item->tempo}}" required>
                                                    </div>
                                                    <div class="mr-2">
                                                        <label>Intensity</label>
                                                        <select class="form-control" name="intensity[]" required>
                                                            <option @if($item->intensity == 'Low') selected @endif>
                                                                Low
                                                            </option>
                                                            <option @if($item->intensity == 'Moderate') selected @endif>
                                                                Moderate
                                                            </option>
                                                            <option @if($item->intensity == 'High') selected @endif>
                                                                High
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="mr-2">
                                                        <label>Weight</label>
                                                        <select class="form-control" name="weight[]" required>
                                                            <option @if($item->weight == 'Yes') selected @endif>
                                                                Yes
                                                            </option>
                                                            <option @if($item->weight == 'No') selected @endif>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="mt-2">
                                                    <label>Instructions</label>
                                                    <textarea class="form-control summernote"
                                                              id="{{$item->id}}"
                                                              name="notes[]">{!! $item->notes !!}</textarea>
                                                </div>
                                                <div class="mt-2">
                                                    <a onclick="return confirm('Are you sure you want to delete this?')"
                                                       class="btn btn-danger btn-sm deleteExercise">
                                                        Delete
                                                    </a>
                                                </div>
                                                <hr>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="exercise-item">
                                            <!-- Hidden fields for Exercise ID (empty for new exercises) and Day ID (persistent) -->
                                            <input type="hidden" name="exercise_id[]" value="">
                                            <input type="hidden" name="day_id[]"
                                                   value="{{$exercise?->weeks?->where('id',request()->week)->first()?->days?->where('id',request()->day)->first()->id}}">
                                            <!-- Example day_id, this will remain unchanged -->

                                            <div class="d-flex">
                                                <div class="mr-2">
                                                    <label>Exercise List</label>
                                                    <select class="form-control" name="exercise_list_id[]" required>
                                                        <option value="">--Select--</option>
                                                        @foreach($exercise_lists as $exercise_list)
                                                            <option value="{{$exercise_list->id}}">{{$exercise_list->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="mr-2">
                                                    <label>Sets</label>
                                                    <input type="text" class="form-control" name="sets[]" required>
                                                </div>
                                                <div class="mr-2">
                                                    <label>Reps</label>
                                                    <input type="text" class="form-control" name="reps[]" required>
                                                </div>

                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="mr-2">
                                                    <label>Rest</label>
                                                    <input type="text" class="form-control" name="rest[]" required>
                                                </div>
                                                <div class="mr-2">
                                                    <label>Tempo</label>
                                                    <input type="text" class="form-control" name="tempo[]"
                                                           value="" required>
                                                </div>
                                                <div class="mr-2">
                                                    <label>Intensity</label>
                                                    <select class="form-control" name="intensity[]" required>
                                                        <option>Low</option>
                                                        <option>Moderate</option>
                                                        <option>High</option>
                                                    </select>
                                                </div>
                                                <div class="mr-2">
                                                    <label>Weight</label>
                                                    <select class="form-control" name="weight[]" required>
                                                        <option>Yes</option>
                                                        <option>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <label>Instructions</label>
                                                <textarea class="form-control summernote" name="notes[]" ></textarea>
                                            </div>

                                            <!-- Delete Button -->
                                            <div class="mt-2">
                                                <a onclick="return confirm('Are you sure you want to delete this?')"
                                                   class="btn btn-danger btn-sm deleteExercise">
                                                    Delete
                                                </a>
                                            </div>

                                            <hr>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            @if(request()->week && request()->week > 0 && request()->day && request()->day > 0)
                                <!-- Button to Add More Exercises -->
                                <button type="button" id="addExercise" class="btn btn-primary mt-2 btn-sm">Add More
                                    Exercise
                                </button>
                                <button type="submit" class="btn btn-success mt-2 btn-sm">Submit Exercises</button>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="get"
                  action="{{route('admin.new.exercise.add_days_or_weeks',['type' => "day",'id' => request()->week])}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter Title</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="day">
                        <input type="hidden" name="id" value="{{request()->week}}">
                        <input type="text" name="title" class="form-control" required placeholder="Work out title">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Day</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>

        let editors = {};
        // Delete Exercise (Attach event listener for delete button)
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('deleteExercise')) {
                var exerciseDiv = event.target.closest('.exercise-item');
                var exerciseIdInput = exerciseDiv.querySelector('input[name="exercise_id[]"]');

                // Check if the exercise has an ID (i.e., it's an existing exercise)
                if (exerciseIdInput.value) {
                    // Redirect to delete route with the exercise ID
                    var deleteUrl = "{{route('admin.new.exercise.delete_item')}}" + `?id=${exerciseIdInput.value}`;

                    window.location.href = deleteUrl;
                } else {
                    // Remove the new exercise block if it doesn't have an ID
                    exerciseDiv.remove();
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const addExerciseButton = document.getElementById('addExercise');
            const exerciseItemTemplate = document.querySelector('.exercise-item');

            addExerciseButton.addEventListener('click', function () {
                const originalTextarea = exerciseItemTemplate.querySelector('textarea');
                const originalTextareaId = originalTextarea.id;

                // Destroy CKEditor instance for the original textarea if it exists
                if (editors[originalTextareaId]) {
                    console.log('Destroying original CKEditor instance for:', originalTextareaId);
                    editors[originalTextareaId].destroy();  // Destroy the original editor instance
                    delete editors[originalTextareaId];  // Remove it from the editors object
                }

                const newExerciseItem = exerciseItemTemplate.cloneNode(true);
                resetExerciseItem(newExerciseItem);
                updateSelectClasses(newExerciseItem);

                //do same for originalTextarea
                const originalId = 'notes1_' + Date.now();
                originalTextarea.id = originalId;
                initializeEditor(originalTextarea);

                const newTextarea = newExerciseItem.querySelector('textarea');
                const newId = 'notes_' + Date.now();
                newTextarea.id = newId;




                // Append to #exercises
                document.getElementById('exercises').appendChild(newExerciseItem);

                // Remove any existing Select2 elements from the cloned item
                $(newExerciseItem).find('.select2').remove();

                // Initialize Select2 and CKEditor for the new item
                initializeSelects(newExerciseItem);
                initializeEditor(newTextarea);

            });

            const exerciseList = @json($exercise_lists); // Pass PHP variable to JS

            console.log('exerciseList:', exerciseList); // Debug to check if the list is correctly passed
            function initializeEditor(element) {
                ClassicEditor
                    .create(element, {
                        toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'paragraph']
                    })
                    .then(editor => {
                        editor.ui.view.editable.element.style.height = '250px';
                        editors[element.id] = editor;  // Store editor reference using the element ID
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
            function initializeSelects() {
                const selects = document.querySelectorAll('select');
                selects.forEach(select => {
                    $(select).select2(); // Initialize Select2

                    // Set up the select2:select event listener for this specific select
                    $(select).on('select2:select', function (e) {
                        console.log('lssss')
                        const selectedExerciseId = e.params.data.id; // Get the selected ID
                        const exerciseList = @json($exercise_lists); // Pass PHP variable to JS
                        const selectedExercise = exerciseList.find(ex => ex.id == selectedExerciseId);

                        if (selectedExercise) {
                            const exerciseItem = select.closest('.exercise-item');
                            populateExerciseItem(exerciseItem, selectedExercise);
                        }
                    });
                });
            }
            initializeSelects();
            function populateExerciseItem(item, exercise) {
                console.log('exercise',exercise);
                item.querySelector('input[name="sets[]"]').value = exercise.sets || '';
                item.querySelector('input[name="reps[]"]').value = exercise.reps || '';
                item.querySelector('input[name="rest[]"]').value = exercise.rest || '';
                item.querySelector('input[name="tempo[]"]').value = exercise.tempo || '';
                item.querySelector('select[name="intensity[]"]').value = exercise.intensity || '';
                item.querySelector('select[name="weight[]"]').value = exercise.weight || '';
                item.querySelector('textarea[name="notes[]"]').value = exercise.notes || '';
                const textarea = item.querySelector('textarea[name="notes[]"]');
                setEditorContent(textarea.id, exercise.notes || '');
            }

            function setEditorContent(textareaId, content) {
                if (editors[textareaId]) {
                    editors[textareaId].setData(content);  // Set new content
                } else {
                    console.error("Editor instance not found for ID: " + textareaId);
                }
            }

            function resetExerciseItem(item) {
                var inputs = item.querySelectorAll('input, textarea');
                inputs.forEach(function (input) {
                    if (input.name !== 'day_id[]') {
                        input.value = ''; // Reset text inputs and textareas
                    }
                });

                const selects = item.querySelectorAll('select');
                selects.forEach(select => {
                    select.selectedIndex = 0;
                });
            }



            function updateSelectClasses(item) {
                const selects = item.querySelectorAll('.form-control');
                selects.forEach(select => {
                    select.classList.remove('bootstrap-select', 'show', 'dropdown'); // Remove unwanted classes
                    select.classList.add('form-control'); // Ensure form-control is present
                });
            }

        });



    </script>

    <script>

        document.querySelectorAll('.summernote').forEach((element, index) => {
            ClassicEditor
                .create(element, {
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'paragraph']
                })
                .then(editor => {
                    editor.ui.view.editable.element.style.height = '250px';
                    editors[element.id] = editor;  // Store editor reference using the element ID
                })
                .catch(error => {
                    console.error(error);
                });
        });

    </script>
   <script>
        $(document).ready(function() {
            function initializeSelects() {
                const selects = document.querySelectorAll('select');
                selects.forEach(select => {
                    $(select).select2(); // Initialize Select2

                    // Set up the select2:select event listener for this specific select
                    $(select).on('select2:select', function (e) {
                        console.log('lssss')
                        const selectedExerciseId = e.params.data.id; // Get the selected ID
                        const exerciseList = @json($exercise_lists); // Pass PHP variable to JS
                        const selectedExercise = exerciseList.find(ex => ex.id == selectedExerciseId);

                        if (selectedExercise) {
                            const exerciseItem = select.closest('.exercise-item');
                            populateExerciseItem(exerciseItem, selectedExercise);
                        }
                    });
                });
            }
            initializeSelects();
            function populateExerciseItem(item, exercise) {
                console.log('exercise',exercise.notes);
                item.querySelector('input[name="sets[]"]').value = exercise.sets || '';
                item.querySelector('input[name="reps[]"]').value = exercise.reps || '';
                item.querySelector('input[name="rest[]"]').value = exercise.rest || '';
                item.querySelector('input[name="tempo[]"]').value = exercise.tempo || '';
                item.querySelector('select[name="intensity[]"]').value = exercise.intensity || '';
                item.querySelector('select[name="weight[]"]').value = exercise.weight || '';
                item.querySelector('textarea[name="notes[]"]').value = exercise.notes.replace(/<[^>]*>/g, '') || '';
                const textarea = item.querySelector('textarea[name="notes[]"]');
                // // console.log('id',CKEDITOR.instances)
                 setEditorContent(textarea.id, exercise.notes || '');
            }
            function setEditorContent(textareaId, content) {
                if (editors[textareaId]) {
                    editors[textareaId].setData(content);  // Set new content
                } else {
                    console.error("Editor instance not found for ID: " + textareaId);
                }
            }
        });
    </script>


@endsection
@section('scripts')

@endsection
