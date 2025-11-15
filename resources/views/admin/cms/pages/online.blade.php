@extends('admin.layouts.master')
@section('admin_title')
    Manage Online Training  Page
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Online Training Page Setting</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">

            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Online Training Page Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="{{route('admin.cms.save_or_update_online_page_setting')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <h3>Top Section</h3>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Page Small Heading</label>
                                            <input type="text" name="top_section_small_heading" class="form-control"
                                                   required
                                                   value="{{ old('top_section_small_heading', $online?->top_section_small_heading ?? '') }}">
                                            @error('top_section_small_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Page Large Heading</label>
                                            <input type="text" name="top_section_large_heading" class="form-control"
                                                   required
                                                   value="{{ old('top_section_large_heading', $online?->top_section_large_heading ?? '') }}">
                                            @error('top_section_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3>Left Card</h3>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Left Card Heading</label>
                                            <input type="text" name="left_card_heading" class="form-control" required
                                                   value="{{ old('left_card_heading', $online?->left_card_heading ?? '') }}">
                                            @error('left_card_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Left Card Description</label>
                                            <textarea name="left_card_description" class="form-control "
                                                      required>{{ old('left_card_description', $online?->left_card_description ?? '') }}</textarea>
                                            @error('left_card_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Left Card Image</label>
                                                <input type="file" name="left_card_image" class="form-control dropify"
                                                       data-default-file="{{ $online?->left_card_image ? URL::to($online?->left_card_image) : '' }}">
                                                @error('left_card_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3>Right Card</h3>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Right Card Heading</label>
                                            <input type="text" name="right_card_heading" class="form-control" required
                                                   value="{{ old('right_card_heading', $online?->right_card_heading ?? '') }}">
                                            @error('right_card_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Right Card Description</label>
                                            <textarea name="right_card_description" class="form-control "
                                                      required>{{ old('right_card_description', $online?->right_card_description ?? '') }}</textarea>
                                            @error('right_card_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Right Card Image</label>
                                                <input type="file" name="right_card_image" class="form-control dropify"
                                                       data-default-file="{{ $online?->right_card_image ? URL::to($online?->right_card_image) : '' }}">
                                                @error('right_card_image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3>Middle Section / Download Now Section</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Middle Section Small Heading</label>
                                            <input type="text" name="middle_section_small_heading" class="form-control"
                                                   required
                                                   value="{{ old('middle_section_small_heading', $online?->middle_section_small_heading ?? '') }}">
                                            @error('middle_section_small_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Section Large Heading</label>
                                            <input type="text" name="middle_section_large_heading" class="form-control"
                                                   required
                                                   value="{{ old('middle_section_large_heading', $online?->middle_section_large_heading ?? '') }}">
                                            @error('middle_section_large_heading')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Section Description</label>
                                            <textarea name="middle_section_description" class="form-control summernote"
                                                      required>{{ old('middle_section_description', $online?->middle_section_description ?? '') }}</textarea>
                                            @error('middle_section_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Middle Section Left Big Image</label>
                                            <input type="file" name="middle_section_left_big_image"
                                                   class="form-control dropify"
                                                   data-default-file="{{ $online?->middle_section_left_big_image ? URL::to($online?->middle_section_left_big_image) : '' }}">
                                            @error('middle_section_left_big_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Section Left Small Image</label>
                                            <input type="file" name="middle_section_left_small_image"
                                                   class="form-control dropify"
                                                   data-default-file="{{ $online?->middle_section_left_small_image ? URL::to($online?->middle_section_left_small_image) : '' }}">
                                            @error('middle_section_left_small_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Section Left Youtube URL</label>
                                            <input type="text" name="middle_section_left_youtube_url"
                                                   class="form-control" required
                                                   value="{{ old('middle_section_left_youtube_url', $online?->middle_section_left_youtube_url ?? '') }}">
                                            @error('middle_section_left_youtube_url')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Middle Section Right Big Image</label>
                                            <input type="file" name="middle_section_right_big_image"
                                                   class="form-control dropify"
                                                   data-default-file="{{ $online?->middle_section_right_big_image ? URL::to($online?->middle_section_right_big_image) : '' }}">
                                            @error('middle_section_right_big_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Section Right Small Image</label>
                                            <input type="file" name="middle_section_right_small_image"
                                                   class="form-control dropify"
                                                   data-default-file="{{ $online?->middle_section_right_small_image ? URL::to($online?->middle_section_right_small_image) : '' }}">
                                            @error('middle_section_right_small_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Section Right Youtube URL</label>
                                            <input type="text" name="middle_section_right_youtube_url"
                                                   class="form-control" required
                                                   value="{{ old('middle_section_right_youtube_url', $online?->middle_section_right_youtube_url ?? '') }}">
                                            @error('middle_section_right_youtube_url')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div><h4 class="card-title">Online Training Page Slider Setting</h4></div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div style="float: right !important;">
                                <a href="{{route('admin.cms.online_page_slider_setting')}}"
                                   class="btn btn-primary text-white">Create Slider Item</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody>
                                    @foreach($sliders as $slider)
                                        <tr>
                                            <td>
                                                <img src="{{URL::to($slider->image)}}" width="100">
                                            </td>
                                            <td>{{$slider->title}}</td>
                                            <td>
                                                <a href="{{route('admin.cms.delete_online_page_slider',['id' => $slider->id])}}" onclick="return confirm('Are you sure to perform this action?')" class="btn btn-danger btn-sm">Delete</a>
                                                <a href="{{route('admin.cms.online_page_slider_setting',['id' => $slider->id])}}" class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
