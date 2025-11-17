@extends('admin.layouts.master')
@section('admin_title')
Edit Online Training Plan
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
            <li class="breadcrumb-item"><a href="{{ route('admin.online.training.plan.list') }}"> Online Training Plan</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit  Online Training Plan</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Online Training Plan</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('admin.online.training.plan.update') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $item['id'] }}" id="">

                          <div class="row">

                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Plan Name</label>
                                        <input type="text" class="form-control" min="0" value="{{ $item['name'] }}" required name="name" placeholder="Plan Name">
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                          @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Plan Price</label>
                                        <input type="number" class="form-control" value="{{ $item['price'] }}" name="price" placeholder="Plan Price" required>
                                        @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('price') }}</strong>
                                                    </span>
                                          @endif
                                    </div>




                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Billing Period</label>
                                        <select name="duration" class="form-control" required>
                                            <option value="" disabled>Select Billing Period</option>
                                            <option value="day" @if($item['duration']=="day") selected @endif>Day</option>
                                            <option value="month"  @if($item['duration']=="month") selected @endif>Monthly</option>
                                            <option value="quarter" @if($item['duration']=="quarter") selected @endif>3 Month</option>
                                            <option value="semiannual" @if($item['duration']=="semiannual") selected @endif>6 Month</option>
                                            <option value="year" @if($item['duration']=="year") selected @endif>1 year</option>
                                            <option value="life-time" @if($item['duration']=="life-time") selected @endif>Life Time</option>
                                        </select>
                                        @if ($errors->has('duration'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                        <strong>{{ $errors->first('duration') }}</strong>
                                                    </span>
                                          @endif
                                    </div>





                                </div>

                            </div>


                          </div>
                          <div><button type="button" class="btn btn-rounded btn-primary" onclick="appendRow()" style="float: left"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                          </span>Add Attribute</button></div>

                          <div id="append-row" class="mt-2" style="float: left;width: 100%;">
                            @foreach ($item['attributes'] as $key=> $attribute )
                            <div class="row" id="row{{$key}}">

                                <div class="col-md-5">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Attribute Name</label>
                                            <input type="text" class="form-control" name="attribute_name[]" value="{{ $attribute['name'] }}" required placeholder="Attribute Name">
                                            @if ($errors->has('attribute_name'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>{{ $errors->first('attribute_name') }}</strong>
                                                        </span>
                                              @endif
                                        </div>





                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Attribute Value</label>
                                            <input type="text" class="form-control" name="value[]" value="{{ $attribute['value'] }}" required placeholder="Attribute Value">
                                            @if ($errors->has('value'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>{{ $errors->first('value') }}</strong>
                                                        </span>
                                              @endif
                                        </div>





                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="remove({{ $key }})" class="" style="float: left;margin-top:40px"><span class="btn-icon-left text-info" style="margin-right: -8px;padding:15px;background: red;"><i class="fa fa-trash color-info" style="color: #111;"></i>
                                                          </span></button>
                                </div>


                                </div>
                            @endforeach

                          </div>



                            <button type="submit" class="btn btn-primary" style="float: right">Update</button>
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

    function remove(key){

        $(`#row${key}`).remove();


    }


    function appendRow(){
        let randomNo=Math.floor((Math.random() * 100) + 1);
        let html=` <div class="row" id="row${randomNo}">

<div class="col-md-5">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Attribute Name</label>
            <input type="text" class="form-control" name="attribute_name[]" required placeholder="Attribute Name">
            @if ($errors->has('attribute_name'))
            <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('attribute_name') }}</strong>
                        </span>
              @endif
        </div>





    </div>

</div>
<div class="col-md-5">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Attribute Value</label>
            <input type="text" class="form-control" name="value[]" required placeholder="Attribute Value">
            @if ($errors->has('value'))
            <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('value') }}</strong>
                        </span>
              @endif
        </div>





    </div>

</div>
<div class="col-md-2">
    <button type="button" onclick="remove(${randomNo})" class="" style="float: left;margin-top:40px"><span class="btn-icon-left text-info" style="margin-right: -8px;padding:15px;background: red;"><i class="fa fa-trash color-info" style="color: #111;"></i>
                          </span></button>
</div>


</div>`;

$('#append-row').append(html);
    }
</script>
@endsection
