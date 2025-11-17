@extends('front.dashboard.master')
@section('admin_title')
Online Training
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/css/style.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
<style>
    .nav-link{
        padding: 0.5rem 1rem !important;
    border-radius: 0.875rem 0.875rem 0 0 !important;
    border: 1px solid transparent !important;
    border-color: #dee2e6 #dee2e6 #F5F9F1 !important;
    }
</style>


@endsection
@section('content')
<div class="container-fluid">
{{--    <div class="row">--}}
{{--        <div class="col-lg-12">--}}
{{--            <div class="profile card card-body px-3 pt-3 pb-0">--}}
{{--                <div class="profile-head">--}}
{{--                    <div class="photo-content">--}}
{{--                        <div class="cover-photo"></div>--}}
{{--                    </div>--}}
{{--                    <div class="profile-info">--}}
{{--                        <div class="profile-photo">--}}
{{--                            <img src="{{ URL::to($user->profile_pic) }}" class="img-fluid rounded-circle" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="profile-details">--}}
{{--                            <div class="profile-name px-3 pt-2">--}}
{{--                                <h4 class="text-primary mb-0">{{ $user->name }}</h4>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
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
                                <a class="nav-link active" data-toggle="tab" href="#profile" style="margin-right: 4px;"><i class="la la-user mr-2"></i> Profile Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#password" style="margin-right: 4px;"><i class="la la-key mr-2"></i> Change Password</a>
                            </li>

                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="profile">
                                <div class="pt-4">
                                    <form class="mt-2" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
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
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ $user['email'] }}" required placeholder="Email">
                                                        @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('email') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-10">
                                                        <label>Phone No</label>
                                                        <input type="number" class="form-control" name="phone_no" min="0" value="{{ $user['phone_no'] }}" required placeholder="Phone No">
                                                        @if ($errors->has('phone_no'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('phone_no') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>
                                                    <div class="form-group col-md-10 d-none">
                                                        <label>time Zone</label>
                                                        <select name="timezone" id="timezone" class="form-control " >
                                                            <option  disabled>Select TimeZone</option>
                                                            @if(Auth::user()->time_zone)
                                                            <option selected value="{{Auth::user()->time_zone}}">{{Auth::user()->time_zone}}</option>
                                                                @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-10">
                                                        <label>Joining Purpose</label>
                                                        <input type="text" class="form-control" name="joining_purpose" value="{{ $user['joining_purpose'] }}" required placeholder="Email">
                                                        @if ($errors->has('joining_purpose'))
                                                        <span class="invalid-feedback" role="alert" style="display: block">
                                                                        <strong>{{ $errors->first('joining_purpose') }}</strong>
                                                                    </span>
                                                          @endif
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-4 ">
                                                <div class="form-row mt-4">
                                                    <div class="form-group col-md-12">
                                                        {{-- <label>Profile Pic</label> --}}
                                                <input type="file" name="profile_pic" accept="image/*" class="form-control dropify" data-default-file="{{ asset($user->profile_pic ? $user->profile_pic : '') }}">


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
                                    <form class="mt-2" method="POST" action="{{ route('user.password.update') }}" enctype="multipart/form-data">
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
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection
