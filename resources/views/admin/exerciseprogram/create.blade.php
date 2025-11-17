@extends('admin.layouts.master')
@section('admin_title')
    Exercise Program Info
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

        table th,
        tr {
            background-color: #ffffff;
            color: #333;
            border: none;
            font-weight: 500;
        }

        table th,
        table td {
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

        .btn-add {
            padding: 0.938rem 1.5rem;
            border-radius: 0.875rem;
            font-weight: 500;
            font-size: 1rem;
            padding-top: 15px;
            padding-bottom: 15px;
            margin-left: 10px;
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
                @if(session()->has('warning'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    {{session()->get('warning')}}


                </div>
                @endif
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card h-auto">
                            <div class="card-header">
                                <h4 class="card-title">Title</h4>
                            </div>
                            <div class="card-body py-1">
                                <input type="text" class="form-control mb-2" id="program-title" value="{{ $item->title ?? '' }}" style="border: 2px solid #aaa" />
                                <button class="btn btn-success" onclick="updateTitle()">Update</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Exercise Program ( <span class="text-muted"> {{ $item->gender ? $item->gender->name. '  - ' : ''}} {{ $item->age ? $item->age->age_range. '  - ' : ''}} {{ $item->experience_level ? $item->experience_level->heading. '  - ' : ''}}   {{ $item->equipment ? $item->equipment->name : ''}}   </span> ) </h4>

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


                            <input type="hidden" name="exercise_program_id" value="{{ $item['id'] }}" id="">
                            <div class="card-body">
                                @if (count($item['exercise_weeks']) == 0)
                                    
                                @else
                                    @include('admin.exerciseprogram.exercises')
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
                let status=$(this).data('status');
                if(status==1){


                    $('#week_disabled').bootstrapToggle('on');
                }else{
                    $('#week_disabled').bootstrapToggle('off');
                }
                $('#week_disabled').attr('data-week_id', week_id);
                $('#delete-week').attr('data-week_id', week_id);
            });
            $('#delete-week').click(function(){
                let week_id=$(this).data('week_id');
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
                let week_id=$('#week_disabled').data('week_id');
                let url="{{route('admin.exercise.program.week.status')}}"+"?week_id="+week_id+"&status="+status;
                $.ajax({
                   url:url,
                   success:function(data){

                   }
                });

            });
        });
    </script>
    @include('admin.exerciseprogram.script')
@endsection
