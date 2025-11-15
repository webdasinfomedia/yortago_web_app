@extends('admin.layouts.master')
@section('admin_title')
Site Configuration
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
<link href="{{ URL::to('front/dashboard//vendor/summernote/summernote.css') }}" rel="stylesheet">


<style>
    .col-md-12 .col-lg-12{
        padding-bottom: 2px!important;
    }
    .card-header {
    padding: 0.75rem 1.25rem !important;

}
.col-md-6{
    padding-bottom: 2px;
}
.col-md-4{
    padding-bottom: 2px;
}
.nav-tabs {
    border-bottom: 1px solid #dee2e6;
}
.nav {
    display: flex;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}
menu, ol, ul {
    padding: 0 0 0 40px;
}
.default-tab .nav-link:focus, .default-tab .nav-link:hover, .default-tab .nav-link.active {
    color: #495057!important;
    background-color: #fff!important;
    border-color: #dee2e6 #dee2e6 #fff #ebeef6!important;
    border-radius: 0.875rem 0.875rem 0 0!important;
    color: #B9732F!important;
    margin-right: 1px!important;
}
.default-tab .nav-link {
    background: transparent!important;
    border-radius: 0px!important;
    font-weight: 500!important;
    margin-right: 1px!important;
}

.nav-tabs .nav-link {
    border: 1px solid transparent!important;
    border-top-left-radius: 0.75rem!important;
    border-top-right-radius: 0.75rem!important;
}
.nav-link {
    display: block!important;
    padding: 0.5rem 1rem!important;
}

</style>

@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Site Configuration</a></li>
        </ol>
    </div>
    <!-- row -->
    <form method="POST" action="{{ route('admin.cms.site.config.submit') }}" enctype="multipart/form-data">
        @csrf
    <div class="row">

        <div class="col-xl-12 col-lg-12" style=" padding-bottom: 2px!important;">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Site Logo</h4>
                </div>
                <div class="card-body">


                          <div class="row">


                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>FavIcon</label>
                                        <input type="file" name="favIcon" @isset($setting['favIcon']) data-default-file="{{ URL::to($setting['favIcon']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Header Logo</label>
                                        <input type="file" name="header_logo" @isset($setting['header_logo']) data-default-file="{{ URL::to($setting['header_logo']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Footer Logo</label>
                                        <input type="file" name="footer_logo" @isset($setting['footer_logo']) data-default-file="{{ URL::to($setting['footer_logo']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Banner 1</label>
                                        <input type="file" name="banner_one" @isset($setting['banner_one']) data-default-file="{{ URL::to($setting['banner_one']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Banner 2</label>
                                        <input type="file" name="banner_two" @isset($setting['banner_two']) data-default-file="{{ URL::to($setting['banner_two']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Banner 3</label>
                                        <input type="file" name="banner_three" @isset($setting['banner_three']) data-default-file="{{ URL::to($setting['banner_three']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Live Stream Service Image</label>
                                        <input type="file" name="live_stream_image" @isset($setting['live_stream_image']) data-default-file="{{ URL::to($setting['live_stream_image']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Online Training Service Image</label>
                                        <input type="file" name="online_training_image" @isset($setting['online_training_image']) data-default-file="{{ URL::to($setting['online_training_image']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>InPerson Service Image</label>
                                        <input type="file" name="in_person_image" @isset($setting['in_person_image']) data-default-file="{{ URL::to($setting['in_person_image']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Testimonial Image</label>
                                        <input type="file" name="testimonial_image" @isset($setting['testimonial_image'])  data-default-file="{{ URL::to($setting['testimonial_image']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Contact form (Person image)</label>
                                        <input type="file" name="contact_form_person_image" @isset($setting['contact_form_person_image'])  data-default-file="{{ URL::to($setting['contact_form_person_image']) }}" @endisset class="form-control dropify">
                                    </div>

                                </div>

                            </div>

                          </div>
                          <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <div class="form-group">
                                        <label>In-Person page banner</label>
                                        <input type="file" name="in_person_page_banner" @isset($setting['in_person_page_banner'])  data-default-file="{{ URL::to($setting['in_person_page_banner']) }}" @endisset class="form-control dropify">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <div class="form-group">
                                        <label>Online Training page banner</label>
                                        <input type="file" name="online_training_page_banner" @isset($setting['online_training_page_banner'])  data-default-file="{{ URL::to($setting['online_training_page_banner']) }}" @endisset class="form-control dropify">
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Register Info</h4>
                    </div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#profile">Live Stream</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#password"> Online Training</a>
                                </li>

                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="profile">
                                    <div class="pt-4">

                                        <div class="row">



                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Heading</label>
                                                        <input type="text" name="heading_live_stream_register" @isset($setting['heading_live_stream_register']) value="{{ ($setting['heading_live_stream_register']) }}" @endisset class="form-control ">
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Content</label>
                                                        <textarea type="text" name="content_live_stream_register"  class="form-control summernote ">@isset($setting['content_live_stream_register']) {{ ($setting['content_live_stream_register']) }} @endisset</textarea>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Image</label>
                                                        <input type="file" name="live_stream_register_img" @isset($setting['live_stream_register_img']) data-default-file="{{ URL::to($setting['live_stream_register_img']) }}" @endisset class="form-control dropify">
                                                    </div>

                                                </div>

                                            </div>


                                          </div>



                                    </div>
                                </div>
                                <div class="tab-pane fade" id="password">
                                    <div class="pt-4">


                                        <div class="row">



                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Heading</label>
                                                        <input type="text" name="heading_online_training_register" @isset($setting['heading_online_training_register']) value="{{ ($setting['heading_online_training_register']) }}" @endisset class="form-control ">
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Content</label>
                                                        <textarea type="text" name="content_online_training_register"  class="form-control summernote ">@isset($setting['content_online_training_register']) {{ ($setting['content_online_training_register']) }} @endisset</textarea>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Image</label>
                                                        <input type="file" name="online_training_register_img" @isset($setting['online_training_register_img']) data-default-file="{{ URL::to($setting['online_training_register_img']) }}" @endisset class="form-control dropify">
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
            </div>

            <div class="col-xl-12 col-lg-12" style=" padding-bottom: 2px!important;">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Footer Info</h4>
                    </div>
                    <div class="card-body">


                              <div class="row">


                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Address</label>
                                            <input type="text" class="form-control" @isset($setting['address'])  value="{{ $setting['address'] }}" @endisset name="address" id="">

                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Email</label>
                                            <input type="email" class="form-control" @isset($setting['email']) value="{{ $setting['email'] }}" @endisset name="email" id="">
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Phone No</label>
                                            <input type="text" name="phone_no" @isset($setting['phone_no']) value="{{ $setting['phone_no'] }}" @endisset class="form-control">
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Facebook</label>
                                            <input type="text" class="form-control" @isset($setting['facebook']) value="{{ $setting['facebook'] }}" @endisset name="facebook" id="">

                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Tiktok</label>
                                            <input type="text" class="form-control" @isset($setting['tiktok']) value="{{ $setting['tiktok'] }}" @endisset name="tiktok" id="">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Twitter</label>
                                            <input type="text" class="form-control" @isset($setting['twitter']) value="{{ $setting['twitter'] }}" @endisset name="twitter" id="">

                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Google Plus</label>
                                            <input type="text" class="form-control" @isset($setting['google']) value="{{ $setting['google'] }}" @endisset name="google" id="">

                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Linkdin</label>
                                            <input type="text" class="form-control" @isset($setting['linkdin']) value="{{ $setting['linkdin'] }}" @endisset name="linkdin" id="">

                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Instagram</label>
                                            <input type="text" class="form-control" @isset($setting['instagram']) value="{{ $setting['instagram'] }}" @endisset name="instagram" id="">

                                        </div>

                                    </div>


                                </div>

                              </div>
                              <button type="submit" class="btn  btn-primary" style="">Save</button>
                        </div>
                    </div>

                </div>






            </div>




        </div>

    <div class="row ml-4">
        <div class="col-md-8"></div>
        <div class="col-md-3">


        </div>

    </div>

</form>
</div>

@endsection
@section('script')

<script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>

<script>
     $('.summernote').summernote({
        placeholder: 'Content',
        tabsize: 2,
        height: 100,

      });
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
