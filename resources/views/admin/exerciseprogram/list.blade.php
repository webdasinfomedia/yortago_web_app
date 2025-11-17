@extends('admin.layouts.master')
@section('admin_title')
    Exercise Program
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
            width: 50px;
            height: 25px;
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
            height: 19px;
            width: 19px;
            left: 2px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #d57d3d;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #d57d3d;
        }

        input:checked+.slider:before {
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
        
        .dropdown.bootstrap-select{
            width: 100% !important;
        }
        
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Exercise Program</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Exercise Program </h4>
                        @if($errors->any())
                            <small class="alert alert-danger">{{$errors->first()}}</small>
                        @endif
                        <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal"
                            data-target="#basicModal" style="float: right"><span class="btn-icon-left text-info"><i
                                    class="fa fa-plus color-info"></i>
                            </span>Add</button>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Focus</th>
                                        <th>Gender</th>
                                        <th>Experience Level</th>
                                        <th>Equipment</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @isset($list['age'])
                                                    {{ $list['age']['age_range'] }}
                                                @else
                                                    N.A
                                                @endisset
                                            </td>
                                            <td>{{ $list['gender']['name'] }}</td>

                                            <td>
                                                @isset($list['experience_level'])
                                                    {{ $list['experience_level']['heading'] }} -
                                                    {{ $list['experience_level']['sub_heading'] }}
                                                @else
                                                    N.A
                                                @endisset
                                            </td>
                                            <td>
                                                @isset($list['equipment'])
                                                    {{ $list['equipment']['name'] }}
                                                @else
                                                    N.A
                                                @endisset
                                            </td>

                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" id="status_{{ $list['id'] }}" name="status"
                                                        onchange={statusChange(`{{ $list['id'] }}`)}
                                                        @if ($list->status == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.exercise.program.edit', $list['uniqid']) }}"
                                                        class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                            class="fa fa-pencil"></i></a>
                                                    <a href="#"
                                                        onclick="deleteAlert('{{ route('admin.exercise.program.delete', $list['id']) }}')"
                                                        class="btn btn-danger shadow btn-xs sharp"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade show" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="quesModalLabel"
            aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quesModalLabel">Questionnaire</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form" id="forms" method="POST"
                              action="{{ route('admin.exercise.program.save') }}">
                            @csrf
                        <div class="programs d-flex justify-content-center">
                            <label class="d-flex align-items-center mr-2" for="program"> Program </label>
                            <select onchange="selectProgram(event)" name="program_type" id="program">
                                <option value="0" selected>Generic</option>
                                <option value="1">Private</option>
                            </select>
                        </div>


                            <div id="generic">
                                @include('admin.includes.exercise-program.generic-form')
                            </div>
                            <div class="d-none" id="private">
                                @include('admin.includes.exercise-program.private-form')
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endsection


    @section('script')
        <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

        <script>
            const prevBtns = document.querySelectorAll(".btn-prev");
            const nextBtns = document.querySelectorAll(".btn-next");
            const progress = document.getElementById("progress");
            const formSteps = document.querySelectorAll(".step-forms");
            const progressSteps = document.querySelectorAll(".progress-step");


            let formStepsNum = 0;

            nextBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    formStepsNum++;
                    updateFormSteps();
                    updateProgressbar();

                });
            });

            prevBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    formStepsNum--;
                    updateFormSteps();
                    updateProgressbar();

                });
            });

            function updateFormSteps() {
                formSteps.forEach((formStep) => {
                    formStep.classList.contains("step-forms-active") &&
                        formStep.classList.remove("step-forms-active");
                });

                formSteps[formStepsNum].classList.add("step-forms-active");
            }

            function updateProgressbar() {
                progressSteps.forEach((progressStep, idx) => {
                    if (idx < formStepsNum + 1) {
                        progressStep.classList.add("progress-step-active");
                    } else {
                        progressStep.classList.remove("progress-step-active");
                    }
                });
                progressSteps.forEach((progressStep, idx) => {
                    if (idx < formStepsNum) {
                        progressStep.classList.add("progress-step-check");
                    } else {
                        progressStep.classList.remove("progress-step-check");
                    }
                });
                const progressActive = document.querySelectorAll(".progress-step-active");
                progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
            }
            document.getElementById("submit-form").addEventListener("click", function() {
                progressSteps.forEach((progressStep, idx) => {
                    if (idx <= formStepsNum) {
                        progressStep.classList.add("progress-step-check");
                    } else {
                        progressStep.classList.remove("progress-step-check");
                    }
                });
                var forms = document.getElementById("forms");
                forms.classList.remove("form");
                forms.innerHTML =
                    '<div class="welcome"><div class="content"><svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg><h2 class="mb-2" style="font-size:32px">Thanks for submitting!</h2><span> <a href="sign-up.html">Sign Up Now</a></span><div></div>';
            });
        </script>

        <script>
            function statusChange(id) {

                if ($('#status_' + id).is(":checked")) {

                    $.ajax({
                        url: "{{ route('admin.exercise.program.status.change') }}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id,
                            status: 1
                        },
                        dataType: 'JSON',
                        success: function(data) {

                            toastr.success("Exercise Program Active Successfully");


                            // swal("Success!", data['status'], "success");
                            // location.reload();
                        }
                    });


                } else {
                    $.ajax({
                        url: "{{ route('admin.exercise.program.status.change') }}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id,
                            status: 0
                        },
                        dataType: 'JSON',
                        success: function(data) {

                            toastr.success("Exercise Program InActive Successfully");
                            // swal("Success!", data['status'], "success");
                            // location.reload();
                        }
                    });


                }

            }

            function selectProgram(e) {
                e.preventDefault();
                let form = document.getElementById("forms");
                let generic = document.getElementById('generic');
                let private = document.getElementById('private');
                let program = parseInt(e.target.value);
                if (program === 1) {
                    generic.classList.add("d-none");
                    private.classList.remove("d-none");
                    form.style.margin = "0px";
                    form.style.width = "100%";
                } else {
                    generic.classList.remove("d-none");
                    private.classList.add("d-none");
                    form.style.width = "clamp(320px, 30%, 430px)";
                    form.style.margin = "0 auto";
                }
            }

            $('#forms').submit(function(e) {
                e.preventDefault();

                var values = $(this).serializeArray().filter(function (i) {
                    if(!i.value) {
                        $("input[name="+i.name+"]").remove();
                    }
                    return i.value;
                });

                let payload = values.map(function (item, index, array) {
                    return {[item.name]: item.value};
                });

                payload = payload.reduce(((r, c) => Object.assign(r, c)), {});

                document.getElementById('forms').submit();

            });
        </script>
    @endsection
