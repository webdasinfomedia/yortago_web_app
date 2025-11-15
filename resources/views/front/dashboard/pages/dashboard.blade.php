@extends('front.dashboard.master')
@section('header_title')

DashBoard

@endsection
@section('css')
<style>
    .btn-active-1{
    background: #d38d49;
    color: white;
}
#videoModal {
  background: black;
  background: rgba(0,0,0, .95);
  .close { margin: 0 0 .5em; }
}
.btn-success{
    color: white;
    background-color: #5cb85c!important;
    border-color: #5cb85c!important;
}
.btn-success:hover{
    color: white;
    background-color: #5cb85c!important;
    border-color: #5cb85c!important;
}
.btn-success:not(:disabled):not(.disabled):active, .btn-success:not(:disabled):not(.disabled).active, .show > .btn-success.dropdown-toggle {
    color: #fff;
    background-color: #5cb85c!important;
    border-color: #5cb85c!important;
}

</style>

@endsection

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        </ol>
    </div>

    @if(auth()->user()->free_session==0)
    @if(auth()->user()->no_of_session==0 || !auth()->user()->PlanValidate())
    <div class="col-xl-12">
    <div class="card bg-transparent">

        <div class="card-body" style="padding: 1px">

            <div class="alert alert-danger alert-dismissible fade show" style="
                display: flex;
                justify-content: space-between;
                padding-top: 20px;">
                <div>
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Pay Your dues to Continue Your Live Stream Session
                </div>


                <button  type="button" onclick="window.location.href=`{{ route('payout') }}`" class=" h-100 btn btn-success" ><span>Pay Now</span>
                </button>
            </div>

        </div>
    </div>
    </div>
    @endif
    @endif

    <!-- row -->
    <div class="row">


        @if (auth()->user()->user_type=="Stream")



        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-tv"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">Total Paid Session Left</p>
                            <h3 class="text-white">{{ auth()->user()->no_of_session}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->free_session>0)
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-tv"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">Free Session Left</p>
                            <h3 class="text-white">{{auth()->user()->free_session }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="widget-stat card bg-primary">
                <div class="card-body  p-4">
                    <div class="media">
                        <span class="mr-3">
                            <i class="la la-tv"></i>
                        </span>
                        <div class="media-body text-white text-right">
                            <p class="mb-1">Total Session Join</p>
                            <h3 class="text-white">{{ $total_session }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-sm-flex d-block pb-0 border-0">
                    <div class="d-flex align-items-center">
                        <span class="p-3 mr-3 rounded bg-warning">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip1)">
                                <path d="M0.988957 17.0741C0.328275 17.2007 -0.104585 17.8386 0.0219823 18.4993C0.133362 19.0815 0.644694 19.4865 1.21678 19.4865C1.29272 19.4865 1.37119 19.4789 1.44713 19.4637L6.4592 18.5018C6.74524 18.4461 7.00091 18.2917 7.18316 18.0639L9.33481 15.3503L8.61593 14.9832C8.08435 14.7149 7.71475 14.2289 7.58818 13.6391L5.55804 16.1983L0.988957 17.0741Z" fill="white"/>
                                <path d="M18.84 6.49306C20.3135 6.49306 21.508 5.29854 21.508 3.82502C21.508 2.3515 20.3135 1.15698 18.84 1.15698C17.3665 1.15698 16.1719 2.3515 16.1719 3.82502C16.1719 5.29854 17.3665 6.49306 18.84 6.49306Z" fill="white"/>
                                <path d="M13.0179 3.15677C12.7369 2.86819 12.4762 2.75428 12.1902 2.75428C12.0864 2.75428 11.9826 2.76947 11.8712 2.79479L7.29203 3.88073C6.6592 4.03008 6.26937 4.66545 6.41872 5.29576C6.54782 5.83746 7.02877 6.20198 7.56289 6.20198C7.65404 6.20198 7.74514 6.19185 7.8363 6.16907L11.7371 5.24513C11.9902 5.52611 13.2584 6.90063 13.4888 7.14364C11.8763 8.87002 10.2639 10.5939 8.65137 12.3202C8.62605 12.3481 8.60329 12.3759 8.58049 12.4038C8.10966 13.0037 8.25397 13.9454 8.96275 14.3023L13.9064 16.826L11.3397 20.985C10.9878 21.5571 11.165 22.3064 11.7371 22.6608C11.9371 22.7848 12.1573 22.843 12.375 22.843C12.7825 22.843 13.1824 22.638 13.4128 22.2659L16.6732 16.983C16.8529 16.6919 16.901 16.34 16.8074 16.0135C16.7137 15.6844 16.4884 15.411 16.1821 15.2566L12.8331 13.553L16.3543 9.78636L19.0122 12.0393C19.2324 12.2266 19.5032 12.3177 19.7716 12.3177C20.0601 12.3177 20.3487 12.2114 20.574 12.0038L23.6243 9.16112C24.1002 8.71814 24.128 7.97392 23.685 7.49803C23.4521 7.24996 23.1383 7.12339 22.8244 7.12339C22.5383 7.12339 22.2497 7.22717 22.0245 7.43727L19.7412 9.56107C19.7386 9.56361 14.0178 4.18196 13.0179 3.15677Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip1">
                                <rect width="24" height="24" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <div class="mr-auto pr-3">
                            <h4 class="text-black fs-20">Rating Chart</h4>

                        </div>
                    </div>
                    <div class="dropdown mt-sm-0 mt-3">
                        <button type="button" id="weekbtn" class="btn rounded border border-light btn-active-1" onclick="renderChart('Week')">
                            Weekly
                        </button>
                        <button type="button" id="dailybtn" class="btn rounded border border-light" onclick="renderChart('Daily')">
                            Daily
                        </button>

                    </div>
                </div>
                <div class="card-body pb-0" id="weekChart" >
                    <div id="chartBar"></div>
                </div>
                <div class="card-body pb-0" id="monthchart" style="display: none">
                    <div id="chartBarMonth"></div>
                </div>
            </div>
        </div>

        @else

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-sm-flex d-block pb-0 border-0">
                    <div class="d-flex align-items-center">
                        <span class="p-3 mr-3 rounded bg-secondary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip2)">
                                <path d="M11.9997 5.9999C13.6565 5.9999 14.9997 4.65677 14.9997 2.99995C14.9997 1.34312 13.6565 0 11.9997 0C10.3429 0 8.99977 1.34312 8.99977 2.99995C8.99977 4.65677 10.3429 5.9999 11.9997 5.9999Z" fill="white"/>
                                <path d="M17.8305 21.8297L14.136 23.2153L15.9733 23.9042C16.7639 24.1978 17.6171 23.791 17.9046 23.0261C18.0576 22.618 18.0124 22.1905 17.8305 21.8297Z" fill="white"/>
                                <path d="M5.02674 16.5949C4.2526 16.3078 3.38687 16.6974 3.0954 17.473C2.80464 18.2486 3.19796 19.1128 3.97351 19.4043L5.59177 20.0111L9.86409 18.4088L5.02674 16.5949Z" fill="white"/>
                                <path d="M20.9045 17.473C20.613 16.6974 19.7473 16.3078 18.9732 16.5949L6.97342 21.0948C6.19778 21.3863 5.8045 22.2505 6.09527 23.0262C6.38275 23.7908 7.23569 24.198 8.02661 23.9043L20.0264 19.4044C20.802 19.1129 21.1953 18.2487 20.9045 17.473Z" fill="white"/>
                                <path d="M22.4997 11.9998H18.9271L16.3417 6.82899C16.073 6.29213 15.5264 5.98627 14.9631 5.99991L11.9997 5.9999L9.0366 5.99991C8.4734 5.98627 7.92754 6.29217 7.65825 6.82899L5.07286 11.9998H1.50019C0.671868 11.9998 0.000244141 12.6714 0.000244141 13.4997C0.000244141 14.328 0.671868 14.9997 1.50019 14.9997H6.00009C6.56845 14.9997 7.08773 14.6789 7.34184 14.1706L8.99999 10.8543V16.483L11.9998 17.6079L14.9999 16.4827V10.8543L16.658 14.1706C16.9122 14.6789 17.4315 14.9997 17.9998 14.9997H22.4997C23.328 14.9997 23.9996 14.328 23.9996 13.4997C23.9996 12.6714 23.3281 11.9998 22.4997 11.9998Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip2">
                                <rect width="24" height="24" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <div class="mr-auto pr-3">
                            <h4 class="text-black fs-20">Online Training</h4>
                            <p class="fs-15 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                    </div>
                    <a href="food-menu.html" class="btn btn-primary rounded d-none d-md-block">View Full Course</a>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" >
                            <div class="featured-menus owl-carousel">
                                @foreach ($exercise_programs as $exercise_program)
                                <div class="items">
                                    <div class="p-3 border border-light rounded">
                                        <div class="about-pic">
                                            <img src="{{ URL::to($exercise_program['image_path']) }}" class="mr-4 food-image rounded" alt="" width="160" height="200">
                                            <a href="#" onclick="showVideo(`{{ URL::to($exercise_program['video_path']) }}`)" class="play-btn video-popup">
                                                <img src="{{ URL::to('front/dashboard/images/play.png') }}" alt="">
                                            </a>
                                        </div>
                                        <div>
                                            <h6 class="fs-16 mt-3 mb-3"><a href="#" class="text-black">{{ $exercise_program['title'] }}</a></h6>
                                            <ul>
                                                <li class="mb-2"><i class="las la-clock scale5 mr-3"></i><span class="fs-14 text-black">{{ $exercise_program['time'] }} sec </span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif



    </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" tabindex="0">&times;</button>
          </div>
        <div class="modal-body">


          <video width="100%" src="#" id="show-video" controls style="min-height: 100%" height="480" src=""></video>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('script')
<script src="{{ URL::to('front/dashboard/vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ URL::to('front/dashboard/vendor/apexchart/apexchart.js') }}"></script>
<script src="{{ URL::to('front/dashboard//vendor/owl-carousel/owl.carousel.js') }}"></script>
<!-- Dashboard 1 -->
{{-- <script src="{{ URL::to('front/dashboard/js/dashboard/workout-statistic.js') }}"></script> --}}


<script>
    (function($) {
    /* "use strict" */


 var dzChartlist = function(){

	var screenWidth = $(window).width();
	var chartBar = function(){
		var optionsArea = {
          series: [{
            name: "Stream Rating",
            data: @json($dataArray)
          }
        ],
          chart: {
          height: 350,
          type: 'area',
		  group: 'social',
		  toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [4],
		  colors:['#FF9432'],
		  curve: 'straight'
        },
        legend: {
			show:false,
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
          },
		  markers: {
			fillColors:['#C046D3','#1EA7C5','#FF9432'],
			width: 19,
			height: 19,
			strokeWidth: 0,
			radius: 19
		  }
        },
        markers: {
          size: [6],
		  strokeWidth: [4],
		  strokeColors: ['#FF9432'],
		  border:0,
		  colors:['#fff'],
          hover: {
            size: 10,
          }
        },
        xaxis: {
          categories:  @json($labelArray),
		  labels: {
		   style: {
			  colors: '#3E4954',
			  fontSize: '14px',
			   fontFamily: 'Poppins',
			  fontWeight: 100,

			},
		  },
        },
		yaxis: {
			labels: {
			offsetX:-16,
		   style: {
			  colors: '#3E4954',
			  fontSize: '14px',
			   fontFamily: 'Poppins',
			  fontWeight: 100,

			},
		  },
		},
		fill: {
			colors:['#FF9432'],
			type:'solid',
			opacity: 0.2
		},
		colors:['#FF9432'],
        grid: {
          borderColor: '#f1f1f1',
		  xaxis: {
            lines: {
              show: true
            }
          }
        },
		responsive: [{
			breakpoint: 575,
			options: {
				chart: {
					height: 250,
				},
				markers: {
					 size: [4],
					 hover: {
						size: 7,
					  }
				}
			}
		 }]
        };
		var chartArea = new ApexCharts(document.querySelector("#chartBar"), optionsArea);
        chartArea.render();

	}
	var chartBar2 = function(){
		var optionsArea = {
          series: [{
            name: "Stream Rating",
            data: @json($dataMonthArray)
          }
        ],
          chart: {
          height: 350,
          type: 'area',
		  group: 'social',
		  toolbar: {
            show: false
          },
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [4],
		  colors:['#FF9432'],
		  curve: 'straight'
        },
        legend: {
			show:false,
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
          },
		  markers: {
			fillColors:['#C046D3','#1EA7C5','#FF9432'],
			width: 19,
			height: 19,
			strokeWidth: 0,
			radius: 19
		  }
        },
        markers: {
          size: [6],
		  strokeWidth: [4],
		  strokeColors: ['#FF9432'],
		  border:0,
		  colors:['#fff'],
          hover: {
            size: 10,
          }
        },
        xaxis: {
          categories:  @json($labelMonthArray),
		  labels: {
		   style: {
			  colors: '#3E4954',
			  fontSize: '14px',
			   fontFamily: 'Poppins',
			  fontWeight: 100,

			},
		  },
        },
		yaxis: {
			labels: {
			offsetX:-16,
		   style: {
			  colors: '#3E4954',
			  fontSize: '14px',
			   fontFamily: 'Poppins',
			  fontWeight: 100,

			},
		  },
		},
		fill: {
			colors:['#FF9432'],
			type:'solid',
			opacity: 0.2
		},
		colors:['#FF9432'],
        grid: {
          borderColor: '#f1f1f1',
		  xaxis: {
            lines: {
              show: true
            }
          }
        },
		responsive: [{
			breakpoint: 575,
			options: {
				chart: {
					height: 250,
				},
				markers: {
					 size: [4],
					 hover: {
						size: 7,
					  }
				}
			}
		 }]
        };
		var chartArea = new ApexCharts(document.querySelector("#chartBarMonth"), optionsArea);
        chartArea.render();

	}

	/* Function ============ */
		return {
			init:function(){
			},


			load:function(){
				chartBar();
				chartBar2();

			},

			resize:function(){

			}
		}

	}();

	jQuery(document).ready(function(){
	});

	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000);

	});

	jQuery(window).on('resize',function(){


	});

})(jQuery);

function renderChart(label){

    if(label==="Week"){
        $('#weekChart').css("display","revert");
        $('#monthchart').css("display","none");
        $("#weekbtn").addClass("btn-active-1");
        $("#dailybtn").removeClass("btn-active-1");
    }
    else{
        $('#weekChart').css("display","none");
        $('#monthchart').css("display","revert");
        $("#dailybtn").addClass("btn-active-1");
        $("#weekbtn").removeClass("btn-active-1");
    }

}
</script>

<script>
    function featuredmenus()
    {

        /*  testimonial one function by = owl.carousel.js */
        jQuery('.featured-menus').owlCarousel({
            loop:false,
            margin:30,
            nav:true,
            autoplaySpeed: 3000,
            navSpeed: 3000,
            paginationSpeed: 3000,
            slideSpeed: 3000,
            smartSpeed: 3000,
            autoplay: false,
            dots: false,
            navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                576:{
                    items:1
                },
                767:{
                    items:1
                },
                991:{
                    items:2
                },
                1200:{
                    items:2
                },
                1600:{
                    items:3
                }
            }
        })
    }

    jQuery(window).on('load',function(){
        setTimeout(function(){
            featuredmenus();
        }, 1000);
    });

</script>

<script>

    function showVideo(path){
        $('#videoModal').modal();

     $('#show-video').attr("src",path);
    }



</script>

@endsection
