@extends('admin.layouts.master')
@section('admin_title')
    Manage Exercise Program
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
       @media only screen and (max-width: 1400px){
            .btn-rounded{
            padding: 0.625rem 1rem;
            font-size: 0.813rem
        }
        }
        .btn-icon-left {
            margin: -0.3rem 0.75rem -0.5rem -1.188rem;
            padding: 0.4rem 0.80rem 0.7rem;
        }
        .table-responsive {
            overflow: visible !important;
        }

        /* OR make the dropdown position absolute and adjust z-index */
        .action_dropdown {
            position: absolute !important;
            z-index: 1050 !important;
        }
    </style>
@endsection

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Exercise Program </h4>
                        @if($errors->any())
                            <small class="alert alert-danger">{{$errors->first()}}</small>
                        @endif
                        <a href="{{route('admin.new.exercise.create.program')}}"
                           class="btn btn-rounded btn-primary btn-sm " style="float: right">
                            <span class="btn-icon-left text-info"> 
                                <i class="fa fa-plus color-info"></i>
                            </span>Add</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Title</th>
                                    <!--<th>Focus</th>-->
                                    <!--<th>Gender</th>-->
                                    <!--<th>Experience Level</th>-->
                                    <th>Type</th>
                                    <th>Users</th>
                                    <th>Youtube Link</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $list->title }}
                                        </td>
                                        <td>
                                       {{ ucfirst($list->type) }}
                                            <!-- <div class="d-flex">
                                                <div>
                                                    <a href="{{ route('admin.new.exercise.assign_exercise', ['id' => encrypt($list->id)]) }}" class="btn btn-warning btn-xs text-white">Assign</a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.new.exercise.assign_exercise', ['id' => encrypt($list->id)]) }}" class="btn btn-secondary btn-xs text-white">{{$list->users->count()}}</a>
                                                    
                                                </div>
                                            </div> -->
                                        </td>   
                                        <td>
                                            @php
                                                $users = $list->users;
                                                $count = $users->count();
                                                $maxShown = 2;
                                            @endphp

                                            @if($count > 0)
                                                <div id="usersList{{ $list->id }}">
                                                    @foreach($users->take($maxShown) as $user)
                                                        <span class="badge badge-info m-1">{{ $user->name }}</span>
                                                    @endforeach
                                                    
                                                    <span class="hidden-users" style="display: none;">
                                                        @foreach($users->skip($maxShown) as $user)
                                                            <span class="badge badge-info m-1">{{ $user->name }}</span>
                                                        @endforeach
                                                    </span>

                                                    @if($count > $maxShown)
                                                        <span 
                                                            class="badge badge-info  m-1 toggle-users" 
                                                            style="cursor: pointer;"
                                                            onclick="toggleUsers({{ $list->id }}, {{ $count - $maxShown }})">
                                                            +{{ $count - $maxShown }} more
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">No users assigned</span>
                                            @endif
                                        </td>
                                        <td>{{$list->youtube_link ?? 'Not Added'}}</td>

                                        <!--<td>-->
                                        <!--    <a href="{{ route('admin.new.exercise.create.program', ['id' => encrypt($list->id)]) }}"-->
                                        <!--       class="btn btn-success btn-xs mb-1">Edit Detail</a>-->
                                        <!--    <a href="{{ route('admin.new.exercise.create_exercise', ['id' => encrypt($list->id)]) }}"-->
                                        <!--       class="btn btn-warning btn-xs mb-1">Edit Program</a>-->
                                               
                                        <!--    <a title="Duplicate" onclick="duplicateAlert('{{ route('admin.new.exercise.duplicate.program', ['id' => $list->id]) }}')" href="javascript:;"-->
                                        <!--       class="btn btn-info btn-xs">Duplicate Program</a>-->
                                        <!--    <a title="Delete" onclick="deleteAlert('{{ route('admin.new.exercise.delete_exercise', ['id' => $list->id]) }}')" href="javascript:;"-->
                                        <!--       class="btn btn-danger btn-xs">Delete Program</a>-->
                                        <!--</td>-->
                                         <td>
                                            <div class="dropdown_toggle">
                                               <button class="btn border-0" type="button" id="dropdownMenuButton{{ $list->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                                </button>

                                                <ul class="dropdown-menu heder-dropdown-menu action_dropdown shadow py-2" aria-labelledby="dropdownMenuButton{{ $list->id }}">
                                                    
                                                   

                                                    {{-- Edit Detail --}}
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.new.exercise.create.program', ['id' => encrypt($list->id)]) }}">
                                                           <i class="bi bi-pencil-square me-2"></i> Edit Detail
                                                        </a>
                                                    </li>

                                                    {{-- Divider --}}
                                                    <div class="dropdown-divider m-0"></div>

                                                    {{-- Edit Program --}}
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.new.exercise.create_exercise', ['id' => encrypt($list->id), 'from' => 'edit']) }}">
                                                            <i class="bi bi-card-list me-2"></i> Edit Program
                                                        </a>
                                                    </li>
                                                     {{-- Assign program --}}
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.new.exercise.assign_exercise', ['id' => encrypt($list->id)]) }}">
                                                           <i class="bi bi-person-check me-2"></i> Assign Program
                                                        </a>
                                                    </li>

                                                    {{-- Divider --}}
                                                    <div class="dropdown-divider m-0"></div>

                                                    {{-- Duplicate --}}
                                                     <li>
                                                        <a class="dropdown-item" href="{{ route('admin.new.exercise.duplicate.program', ['id' => $list->id]) }}">
                                                             <i class="bi bi-files me-2"></i> Duplicate Program
                                                        </a>
                                                    </li> 
                                                    <!--<li>-->
                                                    <!--    <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#duplicateWeekModal" data-id="{{ $list->id }}">-->
                                                    <!--        <i class="bi bi-files me-2"></i> Duplicate Program-->
                                                    <!--    </a>-->
                                                    <!--</li>-->


                                                    {{-- Divider --}}
                                                    <div class="dropdown-divider m-0"></div>

                                                    {{-- Delete --}}
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="javascript:;" onclick="deleteAlert('{{ route('admin.new.exercise.delete_exercise', ['id' => $list->id]) }}')">
                                                           <i class="bi bi-trash3 me-2"></i> Delete Program
                                                        </a>
                                                    </li>
                                                </ul>
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
    </div>

@endsection


@section('script')
    <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>
    <script>

        function toggleUsers(listId, hiddenCount) {
            const container = document.getElementById('usersList' + listId);
            const hiddenUsers = container.querySelector('.hidden-users');
            const toggleBtn = container.querySelector('.toggle-users');
            
            if (hiddenUsers.style.display === 'none') {
                hiddenUsers.style.display = 'inline';
                toggleBtn.textContent = 'Show less';
            } else {
                hiddenUsers.style.display = 'none';
                toggleBtn.textContent = '+' + hiddenCount + ' more';
            }
        }
        function duplicateAlert(url) {
            $url=url;
            swal({
                title: "Are you sure to duplicate ?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, duplicate it!",
                closeOnConfirm: !1
            })
            .then((confirm) => {
                if (confirm.value) {
                    window.location.href = $url;
                }
            });
        }
        function deleteAlert(url) {
            $url=url;
            swal({
                title: "Are you sure you want to delete?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: !1
            })
            .then((confirm) => {
                if (confirm.value) {
                    window.location.href = $url;
                }
            });
        }
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@endsection
