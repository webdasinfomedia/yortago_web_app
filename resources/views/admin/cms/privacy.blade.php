@extends('admin.layouts.master')
@section('admin_title')
Privacy Policy
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Privacy Policy Page</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Privacy Policy Page</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.cms.privacy.submit') }}" enctype="multipart/form-data">
                            @csrf

                          <div class="row">

                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Privacy Policy Heading</label>
                                        <input type="text" class="form-control" name="privacy_title" value="{{ $setting['privacy_title']??""  }}" placeholder="Privacy Policy Title">
                                        @if ($errors->has('privacy_title'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('privacy_title') }}</strong>
                                                    </span>
                                          @endif
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label>Privacy Policy Description</label>
                                        <textarea class="form-control summernote" name="privacy_description" rows="4" placeholder="Privacy Policy Description ...">{{$setting['privacy_description']??""  }}</textarea>
                                        @if ($errors->has('privacy_description'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('privacy_description') }}</strong>
                                                    </span>
                                          @endif
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Image</label>
                                        <input type="file" name="privacy_image" data-default-file="{{ URL::to($setting['privacy_image']??"") }}" class="form-control dropify">
                                    </div>

                                </div>

                            </div>

                          </div>


                            <button type="submit" class="btn btn-primary">@isset($setting['privacy_title']) Update @else Save @endif</button>
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
