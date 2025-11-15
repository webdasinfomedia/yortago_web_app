@extends('admin.layouts.master')
@section('admin_title')
Create Slider
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">

<style>
    .col-md-12{
        padding-bottom: 2px
    }
</style>

@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.cms.slider') }}">Slider</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Slider</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Slider</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.cms.slider.save') }}" enctype="multipart/form-data">
                            @csrf

                          <div class="row">

                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Heading</label>
                                        <input type="text" class="form-control" name="heading" placeholder="Heading ...">
                                        @if ($errors->has('heading'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('heading') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Sub Heading</label>
                                        <input type="text" class="form-control" name="sub_heading" placeholder="Sub Heading ...">
                                        @if ($errors->has('sub_heading'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('sub_heading') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>URL</label>
                                        <input type="text" class="form-control" name="url" placeholder="URL ...">
                                        @if ($errors->has('url'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('url') }}</strong>
                                                    </span>
                                          @endif
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control dropify">
                                    </div>

                                </div>

                            </div>

                          </div>


                            <button type="submit" class="btn btn-primary">Save</button>
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
