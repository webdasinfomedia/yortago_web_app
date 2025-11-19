@extends('admin.layouts.master')
@section('admin_title')
User
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
    .footer{
        padding: 10px !important;
    }
</style>

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Subscription Plan</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Focus</th>
                                        <th>Gender</th>
                                        <th>Experience Level</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <b>{{ $list->online_training_plan->name ?? 'NaN' }}</b>
                                        </td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->email }}</td>
                                        <td>@isset($list['age']){{ $list['age']['age_range'] }} @else N.A @endisset</td>
                                        <td>@isset($list['gender']){{ $list['gender']['name'] }} @else N.A @endisset</td>
                                        <td>@isset($list['experience_level']){{ $list['experience_level']['heading'] }} - {{ $list['experience_level']['sub_heading'] }} @else N.A @endisset</td>

                                        

                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.users.edit',$list['id']) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
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

@endsection


@section('script')

<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

@endsection