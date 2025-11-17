@extends('front.dashboard.master')
@section('admin_title')
Online Training
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
<style>

.accordion-primary .accordion__header {
    background: #B9732F!important;
    border-color: #B9732F!important;
    color: #fff!important;
    box-shadow: 0 15px 20px 0 rgb(108 197 29 / 15%);
}
    .col-md-12{
        padding-bottom: 1px;
    }
    .group-inputs {
  position: relative
}
.group-inputs label {
  font-size: 13px;
  position: absolute;
  height: 19px;
  padding: 4px 0px;
  top: -14px;
  left: 10px;
  color: #969ba0;
  background-color: white;
  font-weight: 500 !important;
}
.group-inputs {
  margin: 1rem 0
}
.group-inputs input{
  padding: 8px 0px;
  width: 80px;
  text-align: center;
}
.weight-input{
    height: 33px;
    border-color: #37D1BF;
    font-size: 12px;
}
@media only screen and (max-width: 1000px) {
  .table-wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
}
body
        {
            font-family: Arial;
            font-size: 10pt;
        }

        table
        {
			border-spacing: 0px 15px;
			padding: 6px;
            border: none;
			border-collapse: inherit !important;
			background-color: #FBFBFB;
        }
		table tbody {
			display: table;
			width: 100%;
		}
		table th
        {
			text-align: center;
		}
		table tr
        {
			cursor: move;
		}
        table th, tr
        {
			background-color: #ffffff;
            color: #333;
			border: none;
            font-weight: 500;
        }

        table th, table td
        {
			border: none;
            padding: 5px;
        }
        .selected
        {
            background-color: #ffffff;
            color: #333;
        }
        .uppy-Dashboard-inner{
            height: 400px!important;
        }
        .about-pic .play-btn {
            position: absolute;
            left: 61%;
            top: 82%;
            width: 38px;
            -webkit-transform: translate(-30.5px, -30.5px);
            -ms-transform: translate(-30.5px, -30.5px);
            transform: translate(-30.5px, -30.5px);
        }
        .b2px{
            border: 1px solid #d76e33;
        }
        .bt2px{
            border-top: 2px solid #d76e33 !important;
        }
        .list-group-item{
            border: 1px solid #d76e33;
        }
        /*.training-heading-area{*/
        /*    height: 90px !important;*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    flex-direction: column;*/
        /*}*/
        .play-btn{
            background: white;
            font-size: 15px !important;
            padding: 0px 15px;
            border-radius: 0;
            margin-top: 5px;
        }
</style>

@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        @if(auth()->user()->is_approve_exercise_info==0)
        <div class="col-xl-12">
        <div class="card bg-transparent">

            <div class="card-body">

                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Your Exercise Program is Generic
                    {{-- <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                    </button> --}}
                </div>

            </div>
        </div>
        </div>
        @endif
        <div class="col-xl-12 col-xxl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exercise Program ( <span class="text-muted"> {{ auth()->user()->gender ? auth()->user()->gender->name. '  - ' : ''}} {{ auth()->user()->age ? auth()->user()->age->age_range. '  - ' : ''}} {{ auth()->user()->experience_level ? auth()->user()->experience_level->heading. '  - ' : ''}}   {{ auth()->user()->equipment ? auth()->user()->equipment->name : ''}}   </span> ) </h4>

                        </div>

                        <div class="card-body mt-2 pb-5" id="sortable" >

                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    @foreach ($item['exercise_weeks'] as $pkey=> $week)
                                    @if(!$week->status) @continue @endif

                                    <li class="nav-item nav-item-1">
                                        <a
                                            @if($currentWeek==(int)str_replace("Week","",$week['week_name']))
                                                class="nav-link active"
                                            @else
                                                class="nav-link {{$pkey==0?'active':''}}"
                                            @endif
                                            data-toggle="tab" href="#week{{$week['id']}}">
                                            <i class="la la-week mr-2"></i>
                                            {{'Week '. $loop->iteration }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($item['exercise_weeks'] as $rkey=> $week)
                                    @if(!$week->status) @continue @endif
                                    <div @if($currentWeek==(int)str_replace("Week","",$week['week_name']))
                                             class="tab-pane fade show active"
                                         @else class="tab-pane fade {{$rkey==0?'show active':''}}"
                                         @endif id="week{{ $week['id'] }}" role="tabpanel">

                                        <div class="pt-4">

                                            @foreach ($week['exercise_days'] as $key=> $day)
                                            <div class="col-md-12">
                                                <div id="w{{ $week['id'] }}-day{{ $day['id']+100 }}" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed "  @if($day['is_completed']==1) style="background: #5cb85c!important" @endif data-toggle="collapse" data-target="#week{{ $week['id'] }}-day-{{ $day['id']+100 }}" aria-expanded="false">
                                                            <span class="accordion__header--text">


                                                                  @if($day['day_name']=="Day One")
                                                                Monday
                                                                @elseif($day['day_name']=="Day Two")
                                                                Tuesday
                                                                @elseif($day['day_name']=="Day Three")
                                                                Wednesday
                                                                @elseif($day['day_name']=="Day Four")
                                                                Thursday
                                                                @elseif($day['day_name']=="Day Five")
                                                                Friday
                                                                @elseif($day['day_name']=="Day Six")
                                                                Saturday

                                                                @elseif($day['day_name']=="Day Seven")
                                                                Sunday
                                                                @endif
                                                            </span>
                                                            {{-- {{ $day['day_name'] }} --}}

                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week{{ $week['id'] }}-day-{{ $day['id']+100 }}" @if($dayName==$day['day_name']) class="accordion__body collapse show " @else class="accordion__body collapse " @endif data-parent="#w{{ $week['id'] }}-day{{ $day['id']+100 }}" style="">
                                                             <div class="accordion__body--text">
                                                                <div class="row">
                                                                   <div class="col-md-12 mb-2" style="float: right">
                                                                        @if($day['is_completed']==0 || $day['is_completed']==NULL)
                                                                        <button class="btn btn-success btn-sm" onclick="window.location.href=`{{ route('online.complete.week',$day['id']) }}`" style="float: right; background:#5cb85c;color:white"> Complete</button>
                                                                        @endif
                                                                    </div>
                                                                    <div class="row sort-row-w{{ $week['id'] }}-day{{ $day['id']+100 }} m-0" style="width: 100%">
                                                                        @foreach ($day['exercise_infos'] as $key1=>$exercise_info)
                                                                        <div class="col-md-4">
                                                                            <div class="card b2px overflow-hidden">
                                                    							<div class="text-center p-3 bg-primary">
                                                    								<h5 class="mt-1 mb-1 text-white">{{ $exercise_info['title'] }}</h5>
                                                    								@if($exercise_info['image_path']!=null || $exercise_info['video_path']!=null)
                                                    								<div class="profile-photo">
                                                    									<a
                                                                                             @if($exercise_info['image_path']!=null)
                                                                                             onclick="showImage(`{{ asset($exercise_info['image_path']) }}`)"
                                                                                             @elseif($exercise_info['video_path']!=null)
                                                                                             onclick="showVideo(`{{ asset($exercise_info['video_path']) }}`)"
                                                                                             @endif
                                                                                             class="play-btn video-popup btn text-primary btn-sm">
                                                    									    <i class="fa fa-play"></i>
                                                                                        </a>
                                                    								</div>
                                                    								@endif
                                                    							</div>
                                                    							<ul class="list-group list-group-flush">
                                                    								<li class="list-group-item d-flex justify-content-between py-2 px-3"><span class="mb-0">Sets</span> <strong class="text-muted">{{ (int)$exercise_info['sets'] }}</strong></li>
                                                    								<li class="list-group-item d-flex justify-content-between py-1 px-3"><span class="mb-0">Reps</span> <strong class="text-muted">{{ (int)$exercise_info['reps'] }}</strong></li>
                                                    								<li class="list-group-item d-flex justify-content-between py-2 px-3"><span class="mb-0">Tempo</span> <strong class="text-muted">{{ $exercise_info['temps'] }}</strong></li>
                                                    								<li class="list-group-item d-flex justify-content-between py-2 px-3"><span class="mb-0">Rest</span> <strong class="text-muted">{{ (int)$exercise_info['rest'] }} secs</strong></li>
                                                    								<li class="list-group-item d-flex justify-content-between py-2 px-3"><span class="mb-0">Intensity</span> <strong class="text-muted">{{ $exercise_info['intensity'] }}</strong></li>
                                                    								@if($exercise_info['description'])
                                                    								<li class="list-group-item d-flex justify-content-between py-2 px-3 bt2px"><strong class="mb-0">{{ $exercise_info['description'] ?? 'Nan' }}</strong></li>
                                                    								@endif
                                                    								
                                                    								@if($exercise_info['applied_weight'] == null && $exercise_info['weight_required'] == 1)
                                                    								<li class="list-group-item d-flex justify-content-center py-2 px-3"> 
                                                								        <div class="input-group">
                                                                                          <input type="number" class="form-control weight-input" min="1" placeholder="Enter applied weight">
                                                                                          <div class="input-group-append">
                                                                                            <button class="btn btn-sm btn-success save-weight" data-id="{{ $exercise_info['id'] }}" type="button">Save</button>
                                                                                          </div>
                                                                                        </div>
                                                    								</li>
                                                    								@endif
                                                    							</ul>
                                                                            </div>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            @endforeach





                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>



                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" tabindex="0">&times;</button>
          </div>
        <div class="modal-body" id="show-video">
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" tabindex="0">&times;</button>
            </div>
            <div class="modal-body">
                <img id="show-image"  src="{{asset('uploads/exercise/images/about.png')}}" style="height: auto;width: 100%" height="480" />


            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    function showVideo(path){
        $('#videoModal').modal();
        $('#show-video').html(`<iframe src='${path.replace("watch?v=", "embed/")}' width="100%" height="400px"></iframe>`);
    }
    function showImage(path){
        $('#show-image').attr("src",path);
        $('#ImageModal').modal('show');
    }
    function appendTable(key){



            if($(`#remove-s${key}`).length>0){
                if($(`#remove-s${key}`).is(":visible")){
                    $(`#remove-s${key}`).hide();
                        } else{
                            $(`#remove-s${key}`).show();
                        }



            }
            else{
                let phtml=` <table class="table-wrapper" id="remove-s${key}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px" >


            <tr>

                <td style="width: 100%;"> <div class="step-forms">
                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text" required name="description[${key}][]" style="width: 100%;padding:12px" ></textarea> </div>
                </div></td>

            </tr>









            </table>`;

            $(`#remove${key}`).after(phtml);
            }


            }
    if(!$('.nav-link.active').length)
    {
        $('.nav-tabs li:eq(0) a').addClass('active');
        $('.tab-content .tab-pane:eq(0)').addClass('fade show active');
    }
    
    $('.save-weight').click(function(){
        var weight = $(this).closest('li').find('input').val();
        var id = $(this).data('id');
        $(this).prop('disabled', true);
        if(weight)
        {
            $.ajax({
                type: 'POST',
                url: "{{ route('online.save.weight') }}",
                data:{
                    _token: "{{ csrf_token() }}",
                    weight: weight,
                    id: id
                },
                success: function(){
                    toastr.success('Thank you');
                    $(this).text('Saved');
                }
            })
        }
    })
</script>
@endsection
