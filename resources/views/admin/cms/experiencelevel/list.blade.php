@extends('admin.layouts.master')
@section('admin_title')
Experience Level
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Experience Level</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Experience Level </h4>
                        <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal" data-target="#basicModal"  style="float: right"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Experience Level</th>


                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $list['heading'] }}</td>


                                        <td>
                                            <div class="d-flex">
                                                <a href="#" onclick="edit(`{{ $list['id'] }}`,`{{ $list['heading'] }}`,`{{ $list['sub_heading'] }}`)" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                <a href="#" onclick="deleteAlert('{{ route('admin.cms.experience.level.delete',$list['id']) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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

    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Age</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.cms.experience.level.save') }}" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Experience Level</label>
                            <input type="text" class="form-control" id="" name="heading" required placeholder="Experience Level ...">
                            @if ($errors->has('heading'))
                            <span class="invalid-feedback" role="alert" style="display: block">
                                            <strong>Experience Level Field Required</strong>
                                        </span>
                              @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label>Experience Level Description</label>
                            <input type="text" class="form-control" id="" name="sub_heading" required placeholder="Experience Level ...">
                            @if ($errors->has('sub_heading'))
                            <span class="invalid-feedback" role="alert" style="display: block">
                                <strong>Experience Level Description Field Required</strong>
                                        </span>
                              @endif
                        </div>



                    </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Experience Level</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.cms.experience.level.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="age_id">
                <div class="modal-body">
                    <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Experience Level</label>
                        <input type="text" class="form-control" id="heading" name="heading" required placeholder="Experience Level ...">
                        @if ($errors->has('heading'))
                        <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>Experience Level Field Required</strong>
                                    </span>
                          @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Experience Level Description</label>
                        <input type="text" class="form-control" id="sub_heading" name="sub_heading" required placeholder="Experience Level ...">
                        @if ($errors->has('sub_heading'))
                        <span class="invalid-feedback" role="alert" style="display: block">
                            <strong>Experience Level Description Field Required</strong>
                                    </span>
                          @endif
                    </div>



                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>


@endsection


@section('script')

<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

<script>
    function edit(id,heading,sub_heading){
        console.log(id,heading,sub_heading);

        $('#age_id').val(id);
        $('#heading').val(heading);
        $('#sub_heading').val(sub_heading);
        $('#editModal').modal();
    }
</script>
@endsection
