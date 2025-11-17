@extends('admin.layouts.master')
@section('admin_title')
    {{$title}}
@endsection

@section('css')

    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}} </h4>

                    </div>
                    <div class="card-body">
                        <form method="get" action="#">
                            @csrf
                            <input type="hidden" name="user_id" value="{{request()->id}}">
                            <div class="form-group">
                                <label>Select Body Type</label>
                                <select class="form-control" name="type" required id="body-part">
                                    <option value="0">--Select Option--</option>
                                    @foreach($items as $item)
                                        <option data-url="{{ route('admin.monitoring.data', [request()->id, $item->id]) }}" value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Results</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Results</th>
                                    </tr>
                                </thead>
                                <tbody id="m-result">
                                    <tr>
                                        <td colspan="2" class="text-center">SELECT BODY PART!</td>
                                    </tr>
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
            <script>
                $('#body-part').change(function(){
                    $.get($(this).find('option:selected').data('url'), function(response){
                        $('#m-result').html('');
                        response = JSON.parse(response);
                        console.log(response.length)
                        for(var i=0;i<response.length;i++)
                        {
                            $('#m-result').append(`
                            <tr>
                                <td>${response[i].created_at}</td>
                                <td>${response[i].set_reps}</td>
                            </tr>
                            `);
                        }
                    })
                })
            </script>

        @endsection
