@extends('admin.layouts.master')
@section('admin_title')
Metrics
@endsection

@section('css')

<style>

</style>

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Metrics</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Metrics </h4>
                        <button type="button" class="btn btn-rounded btn-primary" onclick="window.location.href=`{{ route('admin.metrics.create') }}`" style="float: right"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($metricsList as $list)
                                    <tr>
                                        <td>{{ $list['id'] }}</td>
                                        <td>{{ $list['name'] }}</td>
                                        <td>{{ $list['created_at'] }}</td>

                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.metrics.edit',$list['id']) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                <a href="#" onclick="deleteAlert('{{ route('admin.metrics.delete',$list['id']) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
