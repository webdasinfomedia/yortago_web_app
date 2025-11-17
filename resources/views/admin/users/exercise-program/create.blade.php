@extends('admin.layouts.master')
@section('admin_title')
    Create Exercise Program
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
    <link href="https://releases.transloadit.com/uppy/v2.3.1/uppy.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    <style>
        .toggle{
            max-height: 45px !important;
            max-width: 135px !important;
        }
        .toggle-group{
            top: -4px;
        }
        .accordion-primary .accordion__header {
            background: #B9732F !important;
            border-color: #B9732F !important;
            color: #fff !important;
            box-shadow: 0 15px 20px 0 rgb(108 197 29 / 15%);
        }

        .col-md-12 {
            padding-bottom: 1px;
        }

        .group-inputs {
            position: relative
        }

        .group-inputs label {
            font-size: 13px;
            position: absolute;
            height: 19px;
            padding: 4px 0px;
            top: -14px;
            left: 10px;
            color: #969ba0;
            background-color: white;
            font-weight: 500 !important;
        }

        .group-inputs {
            margin: 1rem 0
        }

        .group-inputs input {
            padding: 8px 0px;
            width: 80px;
            text-align: center;
        }

        @media only screen and (max-width: 1000px) {
            .table-wrapper {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        body {
            font-family: Arial;
            font-size: 10pt;
        }

        table {
            border-spacing: 0px 15px;
            padding: 6px;
            border: none;
            border-collapse: inherit !important;
            background-color: #FBFBFB;
        }

        table tbody {
            display: table;
            width: 100%;
        }

        table th {
            text-align: center;
        }

        table tr {
            cursor: move;
        }

        table th, tr {
            background-color: #ffffff;
            color: #333;
            border: none;
            font-weight: 500;
        }

        table th, table td {
            border: none;
            padding: 5px;
        }

        .selected {
            background-color: #ffffff;
            color: #333;
        }

        .uppy-Dashboard-inner {
            height: 400px !important;
        }

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
            background-color: #d57d3d;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #d57d3d;
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

        .about-pic .play-btn {
            position: absolute;
            left: 61%;
            top: 82%;
            width: 38px;
            -webkit-transform: translate(-30.5px, -30.5px);
            -ms-transform: translate(-30.5px, -30.5px);
            transform: translate(-30.5px, -30.5px);
        }

        .clearBtn {
            position: absolute;
            left: 47px;
            top: 3px;
            transition: left 0.3s;

        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        td select{
            background: white;
            padding-top: 10px;
        }
    </style>

@endsection
@php
    $rand1 = uniqid();

@endphp
@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.exercise.program.list') }}">Exercise Program</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Exercise Program Info</a></li>
            </ol>
        </div>


        <div class="row">
            <div class="col-xl-12 col-xxl-12">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Exercise Program ( <span class="text-muted"> {{ $user->gender ? $user->gender->name. '  - ' : ''}} {{ $user->age ? $user->age->age_range. '  - ' : ''}} {{ $user->experience_level ? $user->experience_level->heading. '  - ' : ''}}   {{ $user->equipment ? $user->equipment->name : ''}}   </span> ) </h4>

                                <div style="float: right">
                                    {{-- <button type="submit" class="btn btn-rounded btn-primary" id="btn-submit"
                                        style="margin-right:10px ">
                                        <span class="btn-icon-left text-info"><i
                                                class="fa fa-save color-info"></i></span>Save
                                    </button> --}}
                                    <button type="button" class="btn btn-rounded btn-primary" onclick="addWeek()"
                                            style="float: right"><span class="btn-icon-left text-info"><i
                                                class="fa fa-plus color-info"></i>
                                        </span>Add Week</button>
                                </div>
                            </div>



                            <div class="card-body">
                                @if (count($item['exercise_weeks']) == 0)
                                    @include('admin.users.exercise-program.partial.add-program')
                            </div>
                            @else
                                @include('admin.users.exercise-program.partial.edit')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('admin.includes.video-modal')

@endsection
@section('script')

    <script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
    <script src="https://releases.transloadit.com/uppy/v2.3.1/uppy.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>


        $(document).ready(function(){
            $('.custom-tab-1 .nav-link').click(function(){
                let week_id=$(this).data('week_id');
                let status=$(this).attr('data-status');
                if(status==1){
                    $('#week_disabled').bootstrapToggle('on');
                }else{
                    $('#week_disabled').bootstrapToggle('off');
                }
                $('#week_disabled').attr('data-week_id', week_id);
                $('#delete-week').attr('data-week_id', week_id);
            });
            $('#delete-week').click(function(){
                let week_id=$(this).attr('data-week_id');
                let url="{{url('/admin/exercise/program/delete/week')}}"+"/"+week_id;
                $.ajax({
                    url:url,
                    success:function(data){
                        location.reload();
                    }
                });

            });
            $('.toggle').click(function(){
                var status=1;
                if($('#week_disabled').is(":checked")){
                    status=0;
                }
                let week_id=$('#week_disabled').attr('data-week_id');
                $('[data-week_id="'+week_id+'"]').attr('data-status', status);
                
                let url="{{route('admin.users.week.status')}}"+"?week_id="+week_id+"&status="+status;
                $.ajax({
                    url:url,
                    success:function(data){

                    }
                });

            });
        });
    </script>
    @include('admin.users.exercise-program.script')
@endsection
