@extends('admin.layouts.master')
@section('admin_title')
Live Streaming
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<link href="{{ URL::to('front/dashboard/vendor/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<!-- Clockpicker -->
<link href="{{ URL::to('front/dashboard/vendor/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
<!-- asColorpicker -->
<link href="{{ URL::to('front/dashboard/vendor/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">
<!-- Material color picker -->
<link href="{{ URL::to('front/dashboard/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<!-- Pick date -->
<link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/pickadate/themes/default.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/vendor/pickadate/themes/default.date.css') }}">
<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #d57d3d;;
}

input:focus + .slider {
  box-shadow: 0 0 1px #d57d3d;;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Live Streaming</a></li>
            </ol>
        </div>
        <!-- row -->


        <form action="{{ route('admin.live.streaming.save') }}" method="post">
            @csrf
        <div class="row">



            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Live Streaming </h4>
                        @if(!empty($setting['meeting_link']))
                        <a href="{{ $setting['meeting_link'] }}" target="_blank" class="btn btn-rounded btn-primary"   style="float: right">Start Streaming</a>
                        @endif
{{--                        <button type="button" class="btn btn-rounded btn-primary" onclick="window.location.href='{{ route('admin.live.streaming.stream') }}'"  style="float: right">Start Streaming</button>--}}

                    </div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Meeting Link</label>
                                    <input type="text" name="meeting_link" value="{{ $setting['meeting_link']??"" }}" class="form-control" id="">

                                </div>

                            </div>

                        </div>
                        <hr>
                        @foreach ($lists as $list)


                        <div class="row">
                            <div class="col-xl-3 mb-3">
                                <div class="example">
                                    <p class="mb-1" style="padding-bottom: 15px!important">Day</p>
                                     <strong>{{ $list['streaming_day'] }}</strong>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3">
                                <div class="example">
                                    <p class="mb-1">Start Time</p>
                                    <div class="input-group clockpicker">
                                        <input type="text" class="form-control" name="times[{{ $list['id'] }}]" value="{{ $list['streaming_time'] }}"> <span class="input-group-append"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3">
                                <div class="example">
                                    <p class="mb-1">End Time</p>
                                    <div class="input-group clockpicker">
                                        <input type="text" class="form-control" name="end_streaming_time[{{ $list['id'] }}]" value="{{ $list['end_streaming_time'] }}"> <span class="input-group-append"><span class="input-group-text"><i
                                                    class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="example">
                                    <p class="mb-1">Active / InActive</p>
                                    <label class="switch" style="margin-top: 10px;margin-left: 20px">
                                        <input type="checkbox" name="is_active[{{ $list['id'] }}]" value="1" @if($list['is_active']=='1')checked @endif>
                                        <span class="slider round"></span>
                                      </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @endforeach



                        <button type="submit" class="btn btn-rounded btn-primary"  style="float: right"><span class="btn-icon-left text-info"><i class="fa fa-save color-info"></i>
                        </span>Update</button>
                    </div>
                </div>
            </div>

        </div>
    </form>


@endsection


@section('script')
 <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="{{ URL::to('front/dashboard/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- clockpicker -->
    <script src="{{ URL::to('front/dashboard/vendor/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
    <!-- asColorPicker -->
    <script src="{{ URL::to('front/dashboard/vendor/jquery-asColor/jquery-asColor.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/vendor/jquery-asGradient/jquery-asGradient.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js') }}"></script>
    <!-- Material color picker -->
    <script src="{{ URL::to('front/dashboard/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- pickdate -->
    <script src="{{ URL::to('front/dashboard/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/vendor/pickadate/picker.date.js') }}"></script>



    <!-- Daterangepicker -->
    <script src="{{ URL::to('front/dashboard/js/plugins-init/bs-daterange-picker-init.js') }}"></script>
    <!-- Clockpicker init -->
    <script src="{{ URL::to('front/dashboard/js/plugins-init/clock-picker-init.js') }}"></script>
    <!-- asColorPicker init -->
    <script src="{{ URL::to('front/dashboard/js/plugins-init/jquery-asColorPicker.init.js') }}"></script>
    <!-- Material color picker init -->
    <script src="{{ URL::to('front/dashboard/js/plugins-init/material-date-picker-init.js') }}"></script>
    <!-- Pickdate -->
    <script src="{{ URL::to('front/dashboard/js/plugins-init/pickadate-init.js') }}"></script>
@endsection
