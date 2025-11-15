@extends('admin.layouts.master')
@section('admin_title')
Create Streaming Plan
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">


<style>
    .col-md-12{
        padding-bottom: 1px;
    }
</style>

@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.streaming.list') }}"> Streaming Plan</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Create  Streaming Plan</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Streaming Plan</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.streaming.save') }}" enctype="multipart/form-data">
                            @csrf

                          <div class="row">

                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Plan Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Plan Name" required>
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Plan Price <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control" name="price" placeholder="Plan Price" required>
                                        @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('price') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Days <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control" name="days" value="{{old('days')}}" placeholder="Total days" required>
                                        @if ($errors->has('days'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('days') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>No of Session <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control" name="total_session" placeholder="Plan Session" required>
                                        @if ($errors->has('total_session'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('total_session') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Free Session</label>
                                        <input type="number" min="0" class="form-control" name="free_session" placeholder="Free Session">
                                        @if ($errors->has('free_session'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('free_session') }}</strong>
                                                    </span>
                                          @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Plan Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="plan_description" rows="4" placeholder="Plan Description ..." required>{{old('plan_description')}}</textarea>
                                        @if ($errors->has('plan_description'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('plan_description') }}</strong>
                                                    </span>
                                          @endif
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
