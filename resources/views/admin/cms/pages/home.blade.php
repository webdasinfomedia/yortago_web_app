@extends('admin.layouts.master')
@section('admin_title')
    Manage Home Page
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home Page Setting</a></li>
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
                            <form method="POST" action="{{route('admin.cms.save_or_update_home_page_setting')}}" enctype="multipart/form-data">
                                @csrf
                                <h3>Slider Section</h3>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Slider Small Heading</label>
                                            <input type="text" name="slider_small_heading" class="form-control" required
                                                   value="{{ old('slider_small_heading', $home_page?->slider_small_heading) }}">
                                            @error('slider_small_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Slider Large Heading</label>
                                            <input type="text" name="slider_large_heading" class="form-control" required
                                                   value="{{ old('slider_large_heading', $home_page?->slider_large_heading) }}">
                                            @error('slider_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Slider Short Description</label>
                                            <textarea name="slider_short_description" class="form-control" required>{{ old('slider_short_description', $home_page?->slider_short_description) }}</textarea>
                                            @error('slider_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Image</label>
                                                <input type="file" name="slider_image" data-default-file="{{$home_page?->slider_image ?  URL::to($home_page?->slider_image) : '' }}" class="form-control dropify">
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
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Page Heading Small</label>
                                            <input type="text" name="page_heading_small" class="form-control" required
                                                   value="{{ old('page_heading_small', $home_page?->page_heading_small) }}">
                                            @error('page_heading_small')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Page Heading Large</label>
                                            <input type="text" name="page_heading_large" class="form-control" required
                                                   value="{{ old('page_heading_large', $home_page?->page_heading_large) }}">
                                            @error('page_heading_large')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Page Heading Short Description</label>
                                            <textarea name="page_heading_short_description" class="form-control" required>{{ old('page_heading_short_description', $home_page?->page_heading_short_description) }}</textarea>
                                            @error('page_heading_short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Section 1 Heading</label>
                                            <input type="text" name="section_1_heading" class="form-control" required
                                                   value="{{ old('section_1_heading', $home_page?->section_1_heading) }}">
                                            @error('section_1_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Section 1 Text</label>
                                            <textarea class="form-control summernote" name="section_1_text" rows="3">{{ old('section_1_text', $home_page?->section_1_text) }}</textarea>
                                            @error('section_1_text')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <div class="form-group">
                                                <label>Section 1 Image</label>
                                                <input type="file" name="section_1_image" data-default-file="{{$home_page?->section_1_image ?  URL::to($home_page?->section_1_image) : '' }}" class="form-control dropify">
                                                @error('section_1_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Section 1 Youtube URL</label>
                                                <input type="text" name="section_1_youtube_url" class="form-control" required
                                                       value="{{ old('section_1_youtube_url', $home_page?->section_1_youtube_url) }}">
                                                @error('section_1_youtube_url')
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
                                            <label>Section 2 Heading</label>
                                            <input type="text" name="section_2_heading" class="form-control" required
                                                   value="{{ old('section_2_heading', $home_page?->section_2_heading) }}">
                                            @error('section_2_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Section 2 Text</label>
                                            <textarea class="form-control summernote" name="section_2_text" rows="3">{{ old('section_2_text', $home_page?->section_2_text) }}</textarea>
                                            @error('section_2_text')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <div class="form-group">
                                                <label>Section 2 Image</label>
                                                <input type="file" name="section_2_image" data-default-file="{{$home_page?->section_2_image ?  URL::to($home_page?->section_2_image) : '' }}" class="form-control dropify">
                                                @error('section_2_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Section 2 Left Image</label>
                                                <input type="file" name="section_2_left_image" data-default-file="{{$home_page?->section_2_left_image ?  URL::to($home_page?->section_2_left_image) : '' }}" class="form-control dropify">
                                                @error('section_2_left_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Section 2 Youtube URL</label>
                                                <input type="text" name="section_2_youtube_url" class="form-control" required
                                                       value="{{ old('section_2_youtube_url', $home_page?->section_2_youtube_url) }}">
                                                @error('section_2_youtube_url')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>



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
