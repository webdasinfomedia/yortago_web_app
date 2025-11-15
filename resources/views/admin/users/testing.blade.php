@extends('admin.layouts.master')
@section('admin_title')
    {{$title}}
@endsection

@section('css')

    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.live-stream.users.list') }}">Users</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}} </h4>

                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('admin.save_testing')}}">
                            @csrf
                            <input type="hidden" name="type" value="{{request()->type}}">
                            <input type="hidden" name="user_id" value="{{request()->id}}">
                            @foreach($testing_fields as $field)
                                <div class="form-group">
                                    <label>{{ucfirst(str_replace('_',' ',$field))}}</label>
                                    <input name="{{$field}}" type="text" class="form-control"
                                           {{$loop->index == 0 ? 'required' : ''}} {{$loop->index == 3 ? 'required' : ''}}  placeholder="Enter value for {{ucfirst(str_replace('_',' ',$field))}}">
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <a href="{{route('admin.live-stream.users.list')}}" class="btn btn-sm btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ucfirst(str_replace('_',' ',request()->type))}} </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                <tr>
                                    <th>Trial 1</th>
                                    <th>Trial 2</th>
                                    <th>Trial 3</th>
                                    <th>Calories Burn</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($check as $list)
                                    <tr>
                                        <td>{{$list->trail1}}</td>
                                        <td>{{$list->trail2}}</td>
                                        <td>{{$list->trail3}}</td>
                                        <td>{{$list->calories_burn}}</td>
                                        <td>
                                            <a href="{{route('admin.delete_testing',['id' => $list->id,'type' => request()->type])}}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete it?')">Delete</a>
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
