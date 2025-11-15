@extends('admin.layouts.master')
@section('admin_title')
    Create/Update Education Hub
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/summernote/summernote.css') }}">
     <style>
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
    </style>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.education_hub_page_setting') }}">Education Hub</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create/Update Education Hub</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">

            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create/Update Education Hub</h4>
                    </div>
                    <div class="card-body">
                        <div >
                            <form method="POST" action="{{route('admin.cms.save_education_hub')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label> Title</label>
                                            <input type="text" name="title" class="form-control" required
                                                   value="{{ old('title', $blog?->title ?? '') }}">
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden" name="id" value="{{request()->id}}">
                                        </div>

                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control searchable-select" name="category_id" required>
                                                <option value="">--Select--</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{$blog?->category_id == $category->id ? "selected" : ''}}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Youtube Link</label>
                                            <input type="text" required name="link" class="form-control"
                                                   value="{{ old('link', $blog?->link ?? '') }}">
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label> Description</label>
                                            <textarea name="description" class="form-control summernote">{{ old('description', $blog?->description ?? '') }}</textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Image</label>
                                                <input type="file" name="video"
                                                       data-default-file="{{$blog?->image ?  URL::to($blog?->image) : '' }}"
                                                       class="form-control dropify">
                                                @error('video')
                                                <span class="text-danger" style="margin-top: 30px">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{route('admin.cms.education_hub_page_setting')}}" type="submit"
                                   class="btn btn-default">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('script')

    <script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
        <script src="{{ URL::to('front/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>
        <script src="{{ URL::to('front/dashboard/js/plugins-init/summernote-init.js') }}"></script>


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
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        document.querySelectorAll('.summernote').forEach(element => {
            ClassicEditor
                .create(element, {
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'paragraph']
                })
                .then(editor => {
                    editor.ui.view.editable.element.style.height = '250px';
                })
                .catch(error => {
                    console.error(error);
                });
        });

    </script>
@endsection
