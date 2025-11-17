@extends('admin.layouts.master')

@section('admin_title', 'Notifications')

@section('css')
<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
.notification-table td {
    vertical-align: middle;
}
.action-btn {
    background-color: #ff6b35;
    color: white;
    border: none;
    padding: 6px 16px;
    border-radius: 4px;
    font-size: 13px;
    text-decoration: none;
    display: inline-block;
}
.action-btn:hover {
    background-color: #ff5722;
    color: white;
}
.notification {
    font-size: 20px;
    color: #B9732F;
    font-weight: 600;
    margin-right: 0px;
    position: relative;
    display: inline-block;
    top: 3px;
}

.notification i {
    font-size: 24px;
}

.notification span {
    position: absolute;
    top: -4px;
    right: -7px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    min-width: 15px;
    height: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 4px;
}
.header-right > li:not(:first-child) {
     padding-left: 0rem !important; 
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a>Notifications</a></li>
        </ol>
    </div>


    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Notifications</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="notificationsTable" class="display min-w850 notification-table">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>DateTime</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $key => $notification)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $notification->user?->name ?? 'N/A' }}</td>
                                    <td>{{ $notification->user?->email ?? 'N/A' }}</td>
                                    <td>{{ $notification->description }}</td>
                                    <td>
                                        <a href="{{ route('admin.notifications.show', $notification->id) }}" 
                                           class="btn btn-primary action-btn btn-sm">
                                            View
                                        </a>
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
$(document).ready(function() {
    $('#notificationsTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "searching": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
    });
});
</script>
@endsection