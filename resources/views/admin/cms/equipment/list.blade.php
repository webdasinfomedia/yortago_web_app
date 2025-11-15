@extends('admin.layouts.master')
@section('admin_title')
Equipment
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Equipment</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Equipment </h4>
                        <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal" data-target="#basicModal"  style="float: right"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Name</th>


                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $list['name'] }}</td>


                                        <td>
                                            <div class="d-flex">
                                                <a href="#" onclick="edit(`{{ $list['id'] }}`,`{{ $list['name'] }}`)" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                {{-- <a href="#" onclick="deleteAlert('{{ route('admin.cms.equipment.delete',$list['id']) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> --}}
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
                    <h5 class="modal-title">Create Equipment</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.cms.equipment.save') }}" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body"><div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required placeholder="Equipment ...">
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                          @endif
                    </div>



                </div></div>
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
                    <h5 class="modal-title">Edit Equipment</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.cms.equipment.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="age_id">
                <div class="modal-body"><div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Equipment ...">
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                          @endif
                    </div>



                </div></div>
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
    function edit(id,age_range){

        $('#age_id').val(id);
        $('#name').val(age_range);
        $('#editModal').modal();
    }
</script>
@endsection
