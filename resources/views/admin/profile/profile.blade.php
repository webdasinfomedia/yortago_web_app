@extends('admin.layouts.master')

@section('admin_title','Profile Page')

@section('css')
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/css/style.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">

<style>
    .dropify-wrapper .dropify-preview .dropify-render img {
    border-radius: 50%!important;
    width: 199px!important;
    height: 200px!important;
}
.dropify-wrapper {
    border-radius: 50%!important;
    width: 200px!important;
    height: 200px!important;
    -webkit-border-radius: 50%!important;
    -moz-border-radius: 50%!important;
    -ms-border-radius: 50%!important;
    -o-border-radius: 50%!important;
}
.nav-link{
    outline: none !important;
    cursor: pointer !important;
}
</style>

@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile Page</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profile Info</h4>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <div class="default-tab">
                        <ul class="nav nav-tabs" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#profile"><i class="la la-user mr-2"></i> Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#password"><i class="la la-key mr-2"></i> Change Password</a>
                            </li>

                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="profile">
                                <div class="pt-4">
                                    <form class="mt-2" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-row">
                                                    <div class="form-group col-md-10">
                                                        <label> Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ $user['name'] }}" required placeholder="Enter Your Name ">
                                                        @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-10">
                                                        <label>User Name</label>
                                                        <input type="text" class="form-control" name="username" value="{{ $user['username'] }}" required placeholder="Enter Your User Name">
                                                        @if ($errors->has('username'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('username') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-10">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ $user['email'] }}" required placeholder="Email">
                                                        @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('email') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-10">
                                                        <label>TimeZone</label>
                                                        <select class="form-control" id="sel1" name="time_zone" tabindex="-98">
                                                            @foreach ($timezones as $key=> $timezone)
                                                            <option value="{{ $key }}" @if($key==$user->time_zone) selected @endif>{{ $timezone }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-4 ">
                                                <div class="form-row mt-4">
                                                    <div class="form-group col-md-12">
                                                        {{-- <label>Profile Pic</label> --}}
                                                <input type="file" name="profile_pic" class="form-control dropify" accept="image/*" data-default-file="{{ URL::to($user['profile_pic']) }}">


                                            </div>
                                            </div>
                                            </div>

                                        </div>



                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="password">
                                <div class="pt-4">
                                    <form class="mt-2" method="POST" action="{{ route('admin.password.update') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-8">
                                                        <label> Current Password</label>
                                                        <input type="password" class="form-control" name="current_password" required placeholder="Enter Your Current Password ">
                                                        @if ($errors->has('current_password'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>InCorrect Password</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label>New Password</label>
                                                        <input type="password" class="form-control" name="new_password"  required placeholder="Enter Your New Password">
                                                        @if ($errors->has('new_password'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('new_password') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label>Confirm New Password</label>
                                                        <input type="password" class="form-control" name="new_confirm_password"  required placeholder="Enter Your Confirm Password">
                                                        @if ($errors->has('new_confirm_password'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>Confirm Password Not Match</strong>
                                                                    </span>
                                                          @endif
                                                    </div>

                                                </div>

                                            </div>



                                        </div>



                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


@endsection


@section('script')

<script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();



        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element){
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e){
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>
@endsection
