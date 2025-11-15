<!DOCTYPE html>
<html lang="zxx">

@include('front.layouts.head')
<style>
    .success,
.error {
  display: none;
  font-size: 13px;
}

.success.visible,
.error.visible {
  display: inline;
}

.error {
  color: #E4584C;
}

.success {
  color: #666EE8;
}
[type="radio"]:checked,
[type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}
[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
    content: '';
    width: 12px;
    height: 12px;
    background: #B9732F;
    position: absolute;
    top: 4px;
    left: 4px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
[type="radio"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
[type="radio"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}
.sevices-wapper{
    background-size: cover;
    background-position: center;
}
</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->

    @include('front.layouts.header')
    <!-- Header End -->

    <div class="page-wrapper p-t-60 p-b-100 font-poppins" style="background-color: #f5f5f5;	margin-top: 78px;min-height: auto;">

        <section class="feature-section">
            <div class="container-fluid">
                <div class="row m-3">
                    <div class="col-md-1"></div>

                    <div class="col-md-4" >
                        <div class="sevices-wapper" style="background-image: url('{{ URL::to($setting['live_stream_image']) }}')">
                            <div class="layer"></div>
                            <div class="services-content" >
                                <div class="intro-img">
                                    <img src="{{ URL::to('front/img/icon/chose-icon-4.png') }}" alt="" style="margin-top: 30px;">
                                </div>
                                <h3>Live Streaming</h3>
                                <hr class="border-title-1">
                                <div class="actions">
                                    <p>20 minutes, no excuses, full body work out, 20TAGO is your only solution. Sign Up.</p>
                                    <a href="{{ route('live.stream.register') }}">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2" ></div>
                    <div class="col-md-4">
                        <div class="sevices-wapper" style="background-image: url('{{ URL::to($setting['online_training_image']) }}')">
                            <div class="layer"></div>
                            <div class="services-content" >
                                <div class="intro-img">
                                    <img src="{{ URL::to('front/img/icon/chose-icon-5.png') }}" alt="" style="margin-top: 30px;">
                                </div>
                                <h3>Online Training</h3>
                                <hr class="border-title-1">
                                <div class="actions">
                                    <p>Access the YORTAGO training system from anywhere in the world. Sign Up.</p>
                                    <a href="{{ route('online.training.register') }}">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Footer Section Begin -->
  @include('front.layouts.footer')
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    @include('front.layouts.script')

</body>

</html>
