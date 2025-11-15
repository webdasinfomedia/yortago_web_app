@extends('admin.layouts.master')
@section('admin_title')
    Manage Categories
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <style>
        .progressbar {
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
            margin: 0.5rem 0 3.5rem;
        }

        .progressbar::before,
        .progress {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #dcdcdc;
            z-index: 1
        }

        .progress {
            background-color: rgb(0 128 0);
            width: 0%;
            transition: 0.3s
        }

        .progress-step {
            width: 2.1875rem;
            height: 2.1875rem;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1
        }

        .progress-step::before {
            counter-increment: step;
            content: counter(step)
        }

        .progress-step::after {
            content: attr(data-title);
            position: absolute;
            top: calc(100% + 0.5rem);
            font-size: 0.85rem;
            color: #666
        }

        .progress-step-active {
            /* background-color: var(--primary-color); */
            color: #000000
        }

        .form {
            width: clamp(320px, 30%, 430px);
            margin: 0 auto;
            border: none;
            border-radius: 10px !important;
            overflow: hidden;
            padding: 1.5rem;
            background-color: #fff;
            padding: 20px 0px;
        }

        .step-forms {
            display: none;
            transform-origin: top;
            animation: animate 1s
        }

        .step-forms-active {
            display: block
        }


        @keyframes animate {
            from {
                transform: scale(1, 0);
                opacity: 0
            }

            to {
                transform: scale(1, 1);
                opacity: 1
            }
        }

        .btns-group {
            margin-bottom: -15px;
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8.5rem;
        }

        .modal-link {
            padding: 0.75rem;
            display: block;
            text-decoration: none;
            background-color: var(--primary-color);
            /* color: #000000; */
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: 0.3s
        }

        .progress-step-check {
            position: relative;
            background-color: green !important;
            transition: all 0.8s;
            color: #ffffff;
        }

        .progress-step-check::before {
            position: absolute;
            content: '\2713';
            width: 100%;
            height: 100%;
            top: 8px;
            left: 13px;
            font-size: 12px
        }

        .welcome {
            margin: 0 auto;
            height: 450px;
            width: 350px;
            background-color: #fff;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .welcome .content {
            margin: 0 auto;
            display: flex;
            align-items: center;
            flex-direction: column
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards
        }

        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 10% auto;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none
            }

            50% {
                transform: scale3d(1.1, 1.1, 1)
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142
            }
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

        .dropdown.bootstrap-select {
            width: 100% !important;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}}</h4>
                        <a href="{{route('admin.new.exercise.categories')}}"
                           class="btn btn-rounded btn-secondary btn-sm" style="float: right">
                            Back</a>
                    </div>
                    <div class="card-body">
                        <div>
                            <form method="post" action="{{route('admin.new.exercise.save_category')}}">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" placeholder="Name" name="name" required>
                                    @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-md">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('script')
    <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

@endsection
