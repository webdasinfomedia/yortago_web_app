@extends('admin.layouts.master')
@section('admin_title')
    Manage Blogs
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Blogs Setting</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">


            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div><h4 class="card-title">Blogs Setting</h4></div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div style="float: right !important;">
                                <a href="{{route('admin.cms.create_blog')}}"
                                   class="btn btn-primary text-white mb-2">Create Blog</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody>
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td>
                                                <img src="{{URL::to($blog->image)}}" width="100">
                                            </td>
                                            <td>{{$blog->title}}</td>
                                            <td>
                                                <a href="{{route('admin.cms.delete_blog',['id' => $blog->id])}}" onclick="return confirm('Are you sure to perform this action?')" class="btn btn-danger btn-sm">Delete</a>
                                                <a href="{{route('admin.cms.create_blog',['id' => $blog->id])}}" class="btn btn-primary btn-sm">Edit</a>
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
    <script src="{{ URL::to('front/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/plugins-init/summernote-init.js') }}"></script>


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
@endsection
