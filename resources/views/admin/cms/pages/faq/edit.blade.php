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

            <div class="col-lg-12">
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-body">
{{--                            @include('components.alert')--}}
                            <h3 class="card-title"><b>Create FAQ</b></h3>
                            <form method="post" action="{{route('admin.cms.update_faq')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="mt-1 mb-1" for="name">FAQ Title</label>
                                    <input type="text" name="faq_title" class="form-control" id="name" required
                                           value="{{$faq->faq_title}}">
                                    <input type="hidden" name="id" value="{{$faq->id}}">
                                   @error('faq_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label class="mb-2 mt-2">About you:</label>
                                    <textarea class="form-control" id="ckeditor" name="faq_description"
                                              placeholder="Faq Description" rows="5">{!! $faq->faq_description !!}</textarea>
                                    @error('faq_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">Update</button>
                                <a href="{{route('admin.cms.faqs')}}" class="btn btn-secondary mt-2">Back</a>
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
