@extends('admin.layouts.master')
@section('admin_title')
Edit Streaming Plan
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Streaming Plan</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Streaming Plan</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.streaming.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $list['id'] }}" id="">

                          <div class="row">

                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Plan Name</label>
                                        <input type="text"  class="form-control" value="{{ $list['name'] }}" name="name" placeholder="Plan Name">
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Plan Price</label>
                                        <input type="number" min="0" class="form-control" value="{{ $list['price'] }}"  name="price" placeholder="Plan Price">
                                        @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('price') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Days <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control" name="days" value="{{$list['days']}}" placeholder="Total days" required>
                                        @if ($errors->has('days'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('days') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>No of Session</label>
                                        <input type="number" min="0" class="form-control" value="{{ $list['total_session'] }}" name="total_session" placeholder="Plan Session">
                                        @if ($errors->has('total_session'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('total_session') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Free Session</label>
                                        <input type="number" min="0" class="form-control" value="{{ $list['free_session'] }}" name="free_session" placeholder="Free Session">
                                        @if ($errors->has('free_session'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('free_session') }}</strong>
                                                    </span>
                                          @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Plan Description</label>
                                        <textarea class="form-control" name="plan_description" rows="4" placeholder="Plan Description ...">{{ $list['plan_description'] }}</textarea>
                                        @if ($errors->has('plan_description'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('plan_description') }}</strong>
                                                    </span>
                                          @endif
                                    </div>

                                </div>

                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control dropify">
                                    </div>

                                </div>

                            </div> --}}

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
