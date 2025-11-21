<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Yortago- Login Page</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::to($setting['favIcon'])}}">
    <link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
    <style>
        .btn-primary:hover, .btn-primary:focus, .btn-primary.focus{
            color: white !important;
            background-color: #B9732F;
        }
    </style>
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div style="align-items: center; text-align: center"> <img src="{{ URL::to('front/img/logo.PNG')}}" alt="Logo" class="img-fluid wow animated fadeInDown" /></div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form action="{{ route('admin.attempt.login') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" required value="{{ old('email') }}" class="form-control" >
                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                              @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" required class="form-control" value="">
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                            <strong>Invalid Credential</strong>
                                                        </span>
                                               @endif
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Remember me</label>
												</div>
                                            </div>

                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ URL::to('front/dashboard/vendor/global/global.min.js') }}"></script>
	<script src="{{ URL::to('front/dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/custom.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/deznav-init.js') }}"></script>

</body>

</html>
