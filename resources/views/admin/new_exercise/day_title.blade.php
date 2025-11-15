@extends('admin.layouts.master')
@section('admin_title')
    Assign Exercise Program
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

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
            <div class="col-lg-6">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Program</h4>

                        <a href="{{route('admin.new.exercise.manage')}}"
                           class="btn btn-rounded btn-primary btn-sm" style="float: right">
                            Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.new.exercise.update_title')}}" method="post">
                            @csrf
                            <input type="hidden" name="day_id" value="{{$day->id}}">
                            <lable>Title</lable>
                            <input type="text" name="title" class="form-control" placeholder="Work out title"
                                   value="{{$day->title}}">

                            <lable>Duration</lable>
                            <input type="text" name="duration" class="form-control" placeholder="Duration"
                                   value="{{$day->duration}}">

                            <lable>Summary</lable>
                            <textarea class="form-control" name="summary">{{$day->summary}}</textarea>

                            <button class="btn btn-primary btn-sm btn-fluid mt-3">Submit</button>
                            <a href="{{route('admin.new.exercise.create_exercise',['id' => request()->id,'day' => request()->day_id,'week' => request()->week_id])}}" class="btn btn-secondary btn-sm btn-fluid mt-3">Back</a>
                        </form>

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
