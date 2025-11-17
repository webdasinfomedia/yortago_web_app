@extends('admin.layouts.master')
@section('admin_title')
    Manage In Person Page
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/summernote/summernote.css') }}">

@endsection

@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">In Person Page Setting</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">

            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Home Page Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="{{route('admin.cms.save_or_update_in_person_page_setting')}}" enctype="multipart/form-data">
                                @csrf
                                <h3>Top Section</h3>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Page Small Heading</label>
                                            <input type="text" name="slider_small_heading" class="form-control" required
                                                   value="{{ old('slider_small_heading', $in_person?->slider_small_heading ?? '') }}">
                                            @error('slider_small_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Page Large Heading</label>
                                            <input type="text" name="slider_large_heading" class="form-control" required
                                                   value="{{ old('slider_large_heading', $in_person?->slider_large_heading ?? '') }}">
                                            @error('slider_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Page Short Description</label>
                                            <textarea name="slider_short_description" class="form-control summernote" required>{{ old('slider_short_description', $in_person?->slider_short_description ?? '') }}</textarea>
                                            @error('slider_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Page Left Image</label>
                                                <input type="file" name="slider_image" class="form-control dropify"
                                                       data-default-file="{{ $in_person?->slider_image ? URL::to($in_person?->slider_image) : '' }}">
                                                @error('slider_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h3>Page Sections</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Form Right Image</label>
                                                <input type="file" name="form_right_image" class="form-control dropify"
                                                       data-default-file="{{ $in_person?->form_right_image ? URL::to($in_person?->form_right_image) : '' }}">
                                                @error('form_right_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Form Image Youtube URL</label>
                                            <input type="text" name="form_image_youtube_url" class="form-control" required
                                                   value="{{ old('form_image_youtube_url', $in_person?->form_image_youtube_url ?? '') }}">
                                            @error('form_image_youtube_url')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h3>Benefits Section</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Benefits Small Heading</label>
                                            <input type="text" name="benefits_small_heading" class="form-control" required
                                                   value="{{ old('benefits_small_heading', $in_person?->benefits_small_heading ?? '') }}">
                                            @error('benefits_small_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits Large Heading</label>
                                            <input type="text" name="benefits_large_heading" class="form-control" required
                                                   value="{{ old('benefits_large_heading', $in_person?->benefits_large_heading ?? '') }}">
                                            @error('benefits_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits Short Description</label>
                                            <textarea name="benefits_short_description" class="form-control" required>{{ old('benefits_short_description', $in_person?->benefits_short_description ?? '') }}</textarea>
                                            @error('benefits_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h3>Benefits</h3>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Benefits 1 Heading</label>
                                            <input type="text" name="benefits_1_heading" class="form-control" required
                                                   value="{{ old('benefits_1_heading', $in_person?->benefits_1_heading ?? '') }}">
                                            @error('benefits_1_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits 1 Large Heading</label>
                                            <input type="text" name="benefits_1_large_heading" class="form-control" required
                                                   value="{{ old('benefits_1_large_heading', $in_person?->benefits_1_large_heading ?? '') }}">
                                            @error('benefits_1_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits 1 Short Description</label>
                                            <textarea name="benefits_1_short_description" class="form-control summernote" required>{{ old('benefits_1_short_description', $in_person?->benefits_1_short_description ?? '') }}</textarea>
                                            @error('benefits_1_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Benefits 1 Image</label>
                                                <input type="file" name="benefits_1_image" class="form-control dropify"
                                                       data-default-file="{{ $in_person?->benefits_1_image ? URL::to($in_person?->benefits_1_image) : '' }}">
                                                @error('benefits_1_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Benefits 2 Heading</label>
                                            <input type="text" name="benefits_2_heading" class="form-control" required
                                                   value="{{ old('benefits_2_heading', $in_person?->benefits_2_heading ?? '') }}">
                                            @error('benefits_2_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits 2 Large Heading</label>
                                            <input type="text" name="benefits_2_large_heading" class="form-control" required
                                                   value="{{ old('benefits_2_large_heading', $in_person?->benefits_2_large_heading ?? '') }}">
                                            @error('benefits_2_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits 2 Short Description</label>
                                            <textarea name="benefits_2_short_description" class="form-control summernote" required>{{ old('benefits_2_short_description', $in_person?->benefits_2_short_description ?? '') }}</textarea>
                                            @error('benefits_2_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Benefits 2 Image</label>
                                                <input type="file" name="benefits_2_image" class="form-control dropify"
                                                       data-default-file="{{ $in_person?->benefits_2_image ? URL::to($in_person?->benefits_2_image) : '' }}">
                                                @error('benefits_2_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Benefits 3 Heading</label>
                                            <input type="text" name="benefits_3_heading" class="form-control" required
                                                   value="{{ old('benefits_3_heading', $in_person?->benefits_3_heading ?? '') }}">
                                            @error('benefits_3_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits 3 Large Heading</label>
                                            <input type="text" name="benefits_3_large_heading" class="form-control" required
                                                   value="{{ old('benefits_3_large_heading', $in_person?->benefits_3_large_heading ?? '') }}">
                                            @error('benefits_3_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Benefits 3 Short Description</label>
                                            <textarea name="benefits_3_short_description" class="form-control summernote" required>{{ old('benefits_3_short_description', $in_person?->benefits_3_short_description ?? '') }}</textarea>
                                            @error('benefits_3_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Benefits 3 Image</label>
                                                <input type="file" name="benefits_3_image" class="form-control dropify"
                                                       data-default-file="{{ $in_person?->benefits_3_image ? URL::to($in_person?->benefits_3_image) : '' }}">
                                                @error('benefits_3_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>


                                <button type="submit" class="btn btn-primary">Update</button>
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
{{--    <script src="{{ URL::to('front/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>--}}
{{--    <script src="{{ URL::to('front/dashboard/js/plugins-init/summernote-init.js') }}"></script>--}}


    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();


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
