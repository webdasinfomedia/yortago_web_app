@extends('front.dashboard.master')
@section('admin_title')
    Live Streaming
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="row" id="app">
                    @if($todayList!=="" && $todayList->show_counter==TRUE)
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header d-sm-flex d-block pb-0 border-0">
                                    <div class="d-flex align-items-center">
                                <span class="p-3 mr-3 rounded bg-warning">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip1)">
                                        <path
                                            d="M0.988957 17.0741C0.328275 17.2007 -0.104585 17.8386 0.0219823 18.4993C0.133362 19.0815 0.644694 19.4865 1.21678 19.4865C1.29272 19.4865 1.37119 19.4789 1.44713 19.4637L6.4592 18.5018C6.74524 18.4461 7.00091 18.2917 7.18316 18.0639L9.33481 15.3503L8.61593 14.9832C8.08435 14.7149 7.71475 14.2289 7.58818 13.6391L5.55804 16.1983L0.988957 17.0741Z"
                                            fill="white"/>
                                        <path
                                            d="M18.84 6.49306C20.3135 6.49306 21.508 5.29854 21.508 3.82502C21.508 2.3515 20.3135 1.15698 18.84 1.15698C17.3665 1.15698 16.1719 2.3515 16.1719 3.82502C16.1719 5.29854 17.3665 6.49306 18.84 6.49306Z"
                                            fill="white"/>
                                        <path
                                            d="M13.0179 3.15677C12.7369 2.86819 12.4762 2.75428 12.1902 2.75428C12.0864 2.75428 11.9826 2.76947 11.8712 2.79479L7.29203 3.88073C6.6592 4.03008 6.26937 4.66545 6.41872 5.29576C6.54782 5.83746 7.02877 6.20198 7.56289 6.20198C7.65404 6.20198 7.74514 6.19185 7.8363 6.16907L11.7371 5.24513C11.9902 5.52611 13.2584 6.90063 13.4888 7.14364C11.8763 8.87002 10.2639 10.5939 8.65137 12.3202C8.62605 12.3481 8.60329 12.3759 8.58049 12.4038C8.10966 13.0037 8.25397 13.9454 8.96275 14.3023L13.9064 16.826L11.3397 20.985C10.9878 21.5571 11.165 22.3064 11.7371 22.6608C11.9371 22.7848 12.1573 22.843 12.375 22.843C12.7825 22.843 13.1824 22.638 13.4128 22.2659L16.6732 16.983C16.8529 16.6919 16.901 16.34 16.8074 16.0135C16.7137 15.6844 16.4884 15.411 16.1821 15.2566L12.8331 13.553L16.3543 9.78636L19.0122 12.0393C19.2324 12.2266 19.5032 12.3177 19.7716 12.3177C20.0601 12.3177 20.3487 12.2114 20.574 12.0038L23.6243 9.16112C24.1002 8.71814 24.128 7.97392 23.685 7.49803C23.4521 7.24996 23.1383 7.12339 22.8244 7.12339C22.5383 7.12339 22.2497 7.22717 22.0245 7.43727L19.7412 9.56107C19.7386 9.56361 14.0178 4.18196 13.0179 3.15677Z"
                                            fill="white"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip1">
                                        <rect width="24" height="24" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                        <div class="mr-auto pr-3">
                                            <h4 class="text-black fs-20">Live Streaming</h4>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <!-- <div id="chartBar"></div> -->
                                    <!-- <div class="simpleslide100">
                                        <div class="simpleslide100-item bg-img1" style="background-image: url('images/card/3.png');"></div>
                                        <div class="simpleslide100-item bg-img1" style="background-image: url('images/bg02.jpg');"></div>
                                        <div class="simpleslide100-item bg-img1" style="background-image: url('images/big/img5.jpg');"></div>
                                    </div> -->
                                    <div class="size1 overlay1">
                                        <!--  -->
                                        <div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
                                            <h3 class="l1-txt1 txt-center p-b-25">
                                                Coming Soon
                                            </h3>

                                            <p class="m2-txt1 txt-center ">
                                                Our live stream will begin shortly!
                                            </p>
                                            @php
                                                if(Auth::user()->time_zone){
                                                    $timezone=Auth::user()->time_zone;
                                                }
                                                    else{
                                                        $timezone='UTC';
                                                    }

                                            @endphp
                                            <span class="p-b-48">Meeting Time: <strong> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $todayList->streaming_date)->setTimezone($timezone)->format('M d , Y g:i A')}} </strong> </span>


                                            <div class="flex-w flex-c-m cd100 p-b-33">
                                                <div class="flex-col-c-m size2 bor1 m-b-20">
                                                    <span class="l2-txt1 p-b-9 days" id="days"></span>
                                                    <span class="s2-txt1">Days</span>
                                                </div>

                                                <div class="flex-col-c-m size2 bor1 m-l-15 m-b-20">
                                                    <span class="l2-txt1 p-b-9 hours" id="hours">17</span>
                                                    <span class="s2-txt1">Hours</span>
                                                </div>

                                                <div class="flex-col-c-m size2 bor1 m-l-15 m-b-20">
                                                    <span class="l2-txt1 p-b-9 minutes" id="minutes">50</span>
                                                    <span class="s2-txt1">Minutes</span>
                                                </div>

                                                <div class="flex-col-c-m size2 bor1 m-l-15 m-b-20">
                                                    <span class="l2-txt1 p-b-9 seconds" id="seconds">39</span>
                                                    <span class="s2-txt1">Seconds</span>
                                                </div>
                                            </div>
                                            <a href="javascript:void 0" onclick="joinMeeting()" id="join-stream-btn" class="flex-c-m btn-primary rounded size3 s2-txt3  trans-04 where1" style="display: none">
                                                Join Stream
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        @if(count($streamRatings)==0)


                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                                        <div class="d-flex align-items-center">
                                <span class="p-3 mr-3 rounded bg-info">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.8586 5.22599L5.87121 10.5543C5.50758 11.0846 5.64394 11.8068 6.17172 12.1679L11.1945 15.6098V18.9558C11.1945 19.5921 11.6995 20.125 12.3359 20.1376C12.9874 20.1477 13.5177 19.625 13.5177 18.976V15.0013C13.5177 14.6174 13.3283 14.2588 13.0126 14.0442L9.79041 11.8346L12.5025 8.95836L13.8914 12.1225C14.0758 12.5442 14.4949 12.817 14.9546 12.817H19.1844C19.8207 12.817 20.3536 12.3119 20.3662 11.6755C20.3763 11.024 19.8536 10.4937 19.2046 10.4937H15.7172C15.2576 9.44824 14.7677 8.41288 14.3409 7.35228C14.1237 6.81693 14.0025 6.5846 13.6036 6.21592C13.5227 6.14016 12.9596 5.62501 12.4571 5.16541C11.995 4.74619 11.2828 4.77397 10.8586 5.22599Z"
                                            fill="white"/>
                                        <path
                                            d="M15.6162 5.80681C17.0861 5.80681 18.2778 4.61517 18.2778 3.1452C18.2778 1.67523 17.0861 0.483582 15.6162 0.483582C14.1462 0.483582 12.9545 1.67523 12.9545 3.1452C12.9545 4.61517 14.1462 5.80681 15.6162 5.80681Z"
                                            fill="white"/>
                                        <path
                                            d="M4.89899 23.5164C7.60463 23.5164 9.79798 21.3231 9.79798 18.6174C9.79798 15.9118 7.60463 13.7184 4.89899 13.7184C2.19335 13.7184 0 15.9118 0 18.6174C0 21.3231 2.19335 23.5164 4.89899 23.5164Z"
                                            fill="white"/>
                                        <path
                                            d="M19.101 23.5164C21.8066 23.5164 24 21.3231 24 18.6174C24 15.9118 21.8066 13.7184 19.101 13.7184C16.3954 13.7184 14.202 15.9118 14.202 18.6174C14.202 21.3231 16.3954 23.5164 19.101 23.5164Z"
                                            fill="white"/>
                                    </svg>
                                </span>
                                            <div class="mr-auto pr-3">
                                                <h4 class="text-black fs-20">Live Meeting</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0 mb-4">
                                        <div class="bg-video-wrap" style="height:80vh">

                                            <div class="overlay" id="overlay-remove" style="height:80vh">
                                            </div>
                                            <p class="p2 visible-false">start your live stream</p>

                                            <button onclick="joinMeeting()"
                                                    class="flex-c-m btn-primary rounded size3 s2-txt3 trans-04 where1"
                                                    id="start-streaming" v-if="joinStreaming"
                                                    style="text-align: center;position: absolute; top: 30px; bottom: 0; left: 0; right: 0; margin: auto; z-index: 2; max-width: 400px; height: 50px;display: block">
                                                Join Meeting
                                            </button>
                                            @if($sessionCount>0)
                                            <a href="{{route('stream.rating')}}">
                                                <button
                                                    class="flex-c-m btn-primary rounded size3 s2-txt3 trans-04 where1"
                                                    id="end-streaming" v-if="joinStreaming"
                                                    style="text-align: center;position: absolute; top: 200px; bottom: 0; left: 0; right: 0; margin: auto; z-index: 2; max-width: 400px; height: 50px;display: block">
                                                    Leave Meeting
                                                </button>
                                                @endif
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        @else
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                                        <div class="d-flex align-items-center">
                                <span class="p-3 mr-3 rounded bg-warning">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip1)">
                                        <path
                                            d="M0.988957 17.0741C0.328275 17.2007 -0.104585 17.8386 0.0219823 18.4993C0.133362 19.0815 0.644694 19.4865 1.21678 19.4865C1.29272 19.4865 1.37119 19.4789 1.44713 19.4637L6.4592 18.5018C6.74524 18.4461 7.00091 18.2917 7.18316 18.0639L9.33481 15.3503L8.61593 14.9832C8.08435 14.7149 7.71475 14.2289 7.58818 13.6391L5.55804 16.1983L0.988957 17.0741Z"
                                            fill="white"/>
                                        <path
                                            d="M18.84 6.49306C20.3135 6.49306 21.508 5.29854 21.508 3.82502C21.508 2.3515 20.3135 1.15698 18.84 1.15698C17.3665 1.15698 16.1719 2.3515 16.1719 3.82502C16.1719 5.29854 17.3665 6.49306 18.84 6.49306Z"
                                            fill="white"/>
                                        <path
                                            d="M13.0179 3.15677C12.7369 2.86819 12.4762 2.75428 12.1902 2.75428C12.0864 2.75428 11.9826 2.76947 11.8712 2.79479L7.29203 3.88073C6.6592 4.03008 6.26937 4.66545 6.41872 5.29576C6.54782 5.83746 7.02877 6.20198 7.56289 6.20198C7.65404 6.20198 7.74514 6.19185 7.8363 6.16907L11.7371 5.24513C11.9902 5.52611 13.2584 6.90063 13.4888 7.14364C11.8763 8.87002 10.2639 10.5939 8.65137 12.3202C8.62605 12.3481 8.60329 12.3759 8.58049 12.4038C8.10966 13.0037 8.25397 13.9454 8.96275 14.3023L13.9064 16.826L11.3397 20.985C10.9878 21.5571 11.165 22.3064 11.7371 22.6608C11.9371 22.7848 12.1573 22.843 12.375 22.843C12.7825 22.843 13.1824 22.638 13.4128 22.2659L16.6732 16.983C16.8529 16.6919 16.901 16.34 16.8074 16.0135C16.7137 15.6844 16.4884 15.411 16.1821 15.2566L12.8331 13.553L16.3543 9.78636L19.0122 12.0393C19.2324 12.2266 19.5032 12.3177 19.7716 12.3177C20.0601 12.3177 20.3487 12.2114 20.574 12.0038L23.6243 9.16112C24.1002 8.71814 24.128 7.97392 23.685 7.49803C23.4521 7.24996 23.1383 7.12339 22.8244 7.12339C22.5383 7.12339 22.2497 7.22717 22.0245 7.43727L19.7412 9.56107C19.7386 9.56361 14.0178 4.18196 13.0179 3.15677Z"
                                            fill="white"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip1">
                                        <rect width="24" height="24" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                            <div class="mr-auto pr-3">
                                                <h4 class="text-black fs-20">Live Meeting</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <!-- <div id="chartBar"></div> -->
                                        <!-- <div class="simpleslide100">
                                            <div class="simpleslide100-item bg-img1" style="background-image: url('images/card/3.png');"></div>
                                            <div class="simpleslide100-item bg-img1" style="background-image: url('images/bg02.jpg');"></div>
                                            <div class="simpleslide100-item bg-img1" style="background-image: url('images/big/img5.jpg');"></div>
                                        </div> -->

                                        <div class="size1 overlay1">
                                            <!--  -->
                                            <div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
                                                <h3 class="l1-txt1 txt-center p-b-25">
                                                    Coming Soon
                                                </h3>

                                                <p class="m2-txt1 txt-center p-b-48">
                                                    Our live stream will being shortly!
                                                </p>

                                                <div class="flex-w flex-c-m cd100 p-b-33">
                                                    <div class="flex-col-c-m size2 bor1 m-b-20">
                                                        <span class="l2-txt1 p-b-9 days" id="days"></span>
                                                        <span class="s2-txt1">Days</span>
                                                    </div>

                                                    <div class="flex-col-c-m size2 bor1 m-l-15 m-b-20">
                                                        <span class="l2-txt1 p-b-9 hours" id="hours">17</span>
                                                        <span class="s2-txt1">Hours</span>
                                                    </div>

                                                    <div class="flex-col-c-m size2 bor1 m-l-15 m-b-20">
                                                        <span class="l2-txt1 p-b-9 minutes" id="minutes">50</span>
                                                        <span class="s2-txt1">Minutes</span>
                                                    </div>

                                                    <div class="flex-col-c-m size2 bor1 m-l-15 m-b-20">
                                                        <span class="l2-txt1 p-b-9 seconds" id="seconds">39</span>
                                                        <span class="s2-txt1">Seconds</span>
                                                    </div>
                                                </div>
                                                <button
                                                    class="flex-c-m btn-primary rounded size3 s2-txt3  trans-04 where1">
                                                    Join Stream
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>

        </div>
    </div>


@endsection

@section('script')



    <script>


        let obj =@json($todayList);
        Date.prototype.addHours = function (h) {
            this.setHours(this.getHours() + h);
            return this;
        }


        function makeTimer() {


            $.ajax({
                method: "POST",
                url: '{{ route('time.left') }}',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    record: obj,
                },
                dataType: 'JSON',
                success: function (data) {

                    if(data.day==0 && data.hour==0 && data.mint==0 && data.sec==0){
                       $('#join-stream-btn').show();
                    }


                    var days = data.day;
                    var hours = data.hour;
                    var minutes = data.mint;
                    var seconds = data.sec;

                    if (hours < "10") {
                        hours = "0" + hours;
                    }
                    if (minutes < "10") {
                        minutes = "0" + minutes;
                    }
                    if (seconds < "10") {
                        seconds = "0" + seconds;
                    }

                    if (days < 0) {
                        hours = 0;
                        minutes = 0;
                        seconds = 0;
                        days = 0;
                    }

                    $("#days").html(days);
                    $("#hours").html(hours);
                    $("#minutes").html(minutes);
                    $("#seconds").html(seconds);
                }
            });

        }

        @if($todayList!="" && $todayList->show_counter==true)

        setInterval(function () {
            makeTimer();
        }, 1000);
        @else

        @endif

    </script>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <script>
        function joinMeeting() {


            $.ajax({
                type: "POST",
                url: `{{ route('live.stream.answer') }}`,
                headers: {
                    'X-CSRF-TOKEN': document.getElementById('csrf').getAttribute('content')
                },

                success: function (data) {
                    if (data.status === false) {

                        toastr.error(data.message, {
                            timeOut: 500000000,
                            closeButton: !0,
                            debug: !1,
                            newestOnTop: !0,
                            progressBar: !0,
                            positionClass: "toast-top-right",
                            preventDuplicates: !0,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                            tapToDismiss: !1
                        });

                        return;
                    }
                    $('#start-streaming').hide();

                    $('#end-streaming').show();
                    window.open('{{ $setting['meeting_link'] }}','_self').focus();


                }
            });
        }
    </script>

@endsection

