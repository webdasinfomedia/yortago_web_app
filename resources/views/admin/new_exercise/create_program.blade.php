@extends('admin.layouts.master')
@section('admin_title')
    {{$title}}
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <style>
        .progressbar {
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
            margin: 0.5rem 0 3.5rem;
        }

        .progressbar::before,
        .progress {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #dcdcdc;
            z-index: 1
        }

        .progress {
            background-color: rgb(0 128 0);
            width: 0%;
            transition: 0.3s
        }

        .progress-step {
            width: 2.1875rem;
            height: 2.1875rem;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1
        }

        .progress-step::before {
            counter-increment: step;
            content: counter(step)
        }

        .progress-step::after {
            content: attr(data-title);
            position: absolute;
            top: calc(100% + 0.5rem);
            font-size: 0.85rem;
            color: #666
        }

        .progress-step-active {
            /* background-color: var(--primary-color); */
            color: #000000
        }

        .form {
            width: clamp(320px, 30%, 430px);
            margin: 0 auto;
            border: none;
            border-radius: 10px !important;
            overflow: hidden;
            padding: 1.5rem;
            background-color: #fff;
            padding: 20px 0px;
        }

        .step-forms {
            display: none;
            transform-origin: top;
            animation: animate 1s
        }

        .step-forms-active {
            display: block
        }


        @keyframes animate {
            from {
                transform: scale(1, 0);
                opacity: 0
            }

            to {
                transform: scale(1, 1);
                opacity: 1
            }
        }

        .btns-group {
            margin-bottom: -15px;
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8.5rem;
        }

        .modal-link {
            padding: 0.75rem;
            display: block;
            text-decoration: none;
            background-color: var(--primary-color);
            /* color: #000000; */
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: 0.3s
        }

        .progress-step-check {
            position: relative;
            background-color: green !important;
            transition: all 0.8s;
            color: #ffffff;
        }

        .progress-step-check::before {
            position: absolute;
            content: '\2713';
            width: 100%;
            height: 100%;
            top: 8px;
            left: 13px;
            font-size: 12px
        }

        .welcome {
            margin: 0 auto;
            height: 450px;
            width: 350px;
            background-color: #fff;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .welcome .content {
            margin: 0 auto;
            display: flex;
            align-items: center;
            flex-direction: column
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards
        }

        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 10% auto;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none
            }

            50% {
                transform: scale3d(1.1, 1.1, 1)
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142
            }
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #d57d3d;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #d57d3d;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .dropdown.bootstrap-select {
            width: 100% !important;
        }
        .dropdown-menu.show{
            right: 0px !important;
            transform: none !important;
            min-width: auto !important;
        }
        /* .select2-search--dropdown{
            width: 470px;
        } */
        .select2-dropdown--below , .select2-dropdown--above{
            width: 470px !important;
        }
        .select2-container .select2-selection--single{
                border-radius: 0;
                background: #fff;
                border: 1px solid #f0f1f5;
                color: #6e6e6e;
                height: 56px;
        }
         .select2-container--default .select2-selection--single .select2-selection__rendered{
            font-size: 14px;
        }
        .select2-container--default .select2-results>.select2-results__options, .select2-search__field{
                font-size: 14px !important;
        }
          .btn{
            border-radius: 3.875rem;
        }
        .btn:hover{
            color:white;
            text-decoration: underline;
        }
        
    </style>
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
@endsection


@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.new.exercise.manage') }}">Exercise Programs</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}} </h4>
                        @if($errors->any())
                            <small class="alert alert-danger">{{$errors->first()}}</small>
                        @endif
                        <a href="{{route('admin.new.exercise.manage')}}" class="btn btn-rounded btn-secondary btn-sm"
                           style="float: right">Back</a>
                    </div>
                    <div class="card-body">
                        <form method="post"
                              action="{{isset($program) ? route('admin.new.exercise.update_create_program'):route('admin.new.exercise.save_create_program')}}"
                              enctype="multipart/form-data">
                            @csrf
                            @if(isset($program))
                                <input type="hidden" name="id" value="{{$program->id}}">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="ages">Title </label><span class="text-danger">*</span>
                                            <input name="title" class="form-control"
                                                   value="{{isset($program) ? $program->title : ''}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label><span class="text-danger">*</span>
                                        <select class="form-control searchable-select"  name="category_id" required>
                                            <option value="">--Select--</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{isset($program) && $program->category_id  == $category->id? 'selected' : ''}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                              @php
                                    $imagePath = '';
                                
                                    if (isset($program) && $program->image) {
                                        $path = ltrim($program->image, '/'); // remove any starting slash
                                
                                        // CASE 1: file exists in /public/uploads/...
                                        if (file_exists(public_path($path))) {
                                            $imagePath = asset($path);
                                        }
                                        // CASE 2: file exists in /storage/app/public/uploads/...
                                        elseif (file_exists(storage_path('app/public/' . $path))) {
                                            $imagePath = asset('storage/' . $path);
                                            
                                        }
                                        // CASE 3: fallback (just try to display anyway)
                                        else {
                                            $imagePath = asset('storage/' . $path);
                                        }
                                    }
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Image</label>
                                            
                                            <input type="file" name="image"
                                                   data-default-file="{{ $imagePath }}"
                                                   class="form-control dropify">
                                                  
                                            @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtube_link">YouTube Playlist Link</label>
                                        <input type="url" name="youtube_link" id="youtube_link"
                                            class="form-control"
                                            placeholder="Enter YouTube Playlist Link"
                                            value="{{ isset($program) ? $program->youtube_link : '' }}">
                                        @error('youtube_link')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                     <div class="form-group">
                                        <label class="d-block mb-2">Program Type</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="type" id="type_generic" 
                                                value="generic"
                                                {{ isset($program) && $program->type == 'generic' ? 'checked' : (!isset($program) ? 'checked' : '') }}>
                                            <label class="form-check-label" for="type_generic">Generic</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="type" id="type_premium" 
                                                value="premium"
                                                {{ isset($program) && $program->type == 'premium' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="type_premium">Premium</label>
                                        </div>
                                        @error('type')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div>
                                <button class="btn btn-primary">{{isset($program) ? "Update" : 'Create'}} Program</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection


@section('script')
    <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();

           $('.searchable-select').select2({
                placeholder: "Select Category",
                allowClear: true,
                width: 'auto',
                dropdownAutoWidth: true
            });
                    // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>

@endsection
