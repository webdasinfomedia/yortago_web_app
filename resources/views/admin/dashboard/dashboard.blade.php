@extends('admin.layouts.master')

@section('admin_title')
Admin Dashboard
@endsection


@section('content')
<style>
    .dashboard{
        margin-bottom:57px;
    }
</style>
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row dashboard">

        <div class="col-xl-12 col-lg-12 col-sm-12 mb-2">
            <h4>Live Streaming</h4>

        </div>


        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-users">

                            </i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">User</p>
                            <h3 class="text-white">{{ $users }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-tv"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">Total Session</p>
                            <h3 class="text-white">{{ $total_session }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-dollar"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">Earning</p>
                            <h3 class="text-white">{{ $total_earning }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-xl-12 col-lg-12 col-sm-12 mb-2">
            <h4>Online Training</h4>

        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-users"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">User</p>
                            <h3 class="text-white">{{ $users_online }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-dollar"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1"> Earning</p>
                            <h3 class="text-white">{{ $total_earning_online }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>


@endsection