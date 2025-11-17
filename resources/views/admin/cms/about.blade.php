@extends('admin.layouts.master')
@section('admin_title')
About Page
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">About Page</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">About Page</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.cms.about.submit') }}" enctype="multipart/form-data">
                            @csrf

                          <div class="row">

                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>About Us Title</label>
                                        <input type="text" class="form-control" name="about_title" value="{{ $setting['about_title']  }}" placeholder="About Us Title">
                                        @if ($errors->has('about_title'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('about_title') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>About Url (Youtube)</label>
                                        <input type="text" class="form-control" name="about_url" value="{{ $setting['about_url'] }}" placeholder="About Us Url">
                                        @if ($errors->has('about_url'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('about_url') }}</strong>
                                                    </span>
                                          @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>About Us Description</label>
                                        <textarea class="form-control summernote" name="about_description" rows="4" placeholder="About Us Description ...">{{$setting['about_description']  }}</textarea>
                                        @if ($errors->has('about_description'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('about_description') }}</strong>
                                                    </span>
                                          @endif
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Image</label>
                                        <input type="file" name="about_image" data-default-file="{{ URL::to($setting['about_image']) }}" class="form-control dropify">
                                    </div>

                                </div>

                            </div>

                          </div>


                            <button type="submit" class="btn btn-primary">@if($setting['about_title']==null)Save @else Update @endif</button>
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
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();



        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element){
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e){
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
