@extends('admin.layouts.master')
@section('admin_title')
In Person Contact
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<link href="{{ URL::to('front/dashboard//vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">In Person Contact</a></li>
            </ol>
        </div>
        <!-- row -->


        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">In Person Contact </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Mobile</th>
                                        <th>User Message</th>
                                        <th>DateTime</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->mobile_no }}</td>
                                        <td>{{ $list->message }}</td>
                                        <td>{{ date('Y-m-d (H:i)', strtotime($list->created_at)) }}</td>
                                        <td> <a href="#" onclick="edit(`{{ $list['id'] }}`,`{{ $list['email'] }}`)" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-envelope"></i></a></td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reply Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('admin.in.person.reply') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="email" id="email">
        <input type="hidden" name="id" id="id">

        <div class="modal-body">
          <div class="form-group mb-3">
            <label>Subject</label>
            <input type="text" class="form-control" name="subject" required placeholder="Subject ...">
            @error('subject')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="form-group">
            <label>Content</label>
            <textarea id="replyContent" class="form-control" name="content" placeholder="Mail Content"></textarea>
            @error('content')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send Mail</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('script')

<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>

<script>
    function edit(id,email){
        $('#id').val(id);
        $('#email').val(email);

        $('#editModal').modal();
    }
    $('.summernote').summernote({
        placeholder: 'Mail Content',
        tabsize: 2,
        height: 150,

    });
      
</script>

@endsection


