@extends('admin.layouts.master')
@section('admin_title')
Create Testimonial
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">


@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.testimonial.list') }}">Testimonial</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Testimonial</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Testimonial</h4>
                    <button type="button" class="btn btn-rounded btn-primary" onclick="window.location.href=`{{ route('admin.testimonial.list') }}`" style="float: right">
                    Back</button>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.testimonial.save') }}" enctype="multipart/form-data">
                            @csrf

                          <div class="row">

                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Author Name</label>
                                        <input type="text" class="form-control" name="author_name" placeholder="Author Name">
                                        @if ($errors->has('author_name'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('author_name') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Author Designation</label>
                                        <input type="text" class="form-control" name="author_designation" placeholder="Author Designation">
                                        @if ($errors->has('author_designation'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('author_designation') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Testimonial Description</label>
                                        <textarea class="form-control" name="description" rows="4" placeholder="Testimonial Description ..."></textarea>
                                        @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('description') }}</strong>
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
