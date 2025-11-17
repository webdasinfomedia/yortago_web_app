@extends('admin.layouts.master')
@section('admin_title')
Create Exercise Program
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
<link href="https://releases.transloadit.com/uppy/v2.3.1/uppy.min.css" rel="stylesheet">

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
        .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #d57d3d;
}

input:focus + .slider {
  box-shadow: 0 0 1px #d57d3d;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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
    .clearBtn {
        position: absolute;
        left: 47px;
        top: 3px;
        transition: left 0.3s;

}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Exercise Program</a></li>
        </ol>
    </div>
    <form action="{{ route('admin.users.info.save') }}" method="POST">
        <input type="hidden" name="id" value="{{ $item['id'] }}">
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exercise Program </h4>
                            <div style="float: right">
                                <button type="submit" class="btn btn-rounded btn-primary"  style="margin-right:10px "><span class="btn-icon-left text-info"><i class="fa fa-save color-info"></i>
                                </span>Save</button>
                                <button type="button" class="btn btn-rounded btn-primary"  onclick="addWeek()" style="float: right"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                </span>Add Week</button>
                                </div>
                        </div>

                        {{-- <div class="form-group">


                        </div> --}}

                            @csrf
                        <div class="" style="margin-top: 20px;margin-left: 50px;margin-bottom: 0px;">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="val-username" style="padding-bottom: 1px; max-width: 8.666667%;">Status
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6" style="padding-bottom: 1px;">
                                    <label class="switch">
                                        <input type="checkbox" name="is_approve_exercise_info" @if($user->is_approve_exercise_info==1) checked @endif >
                                        <span class="slider round"></span>
                                      </label>
                                </div>
                            </div>

                        </div>

                         <div class="card-body">
                            @if(count($item['exercise_weeks'])==0)
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item nav-item-1">
                                        <a class="nav-link active" data-toggle="tab" href="#week1"><i class="la la-week mr-2"></i> Week 1</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="week1" role="tabpanel">
                                        <input type="hidden" name="id" value="{{ $item['id'] }}" id="">
                                        <input type="hidden" name="weeks[]" value="Week1" id="">
                                        <div class="pt-4">
                                            <div class="col-md-12">
                                                <div id="w1-day1" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-1" aria-expanded="false">
                                                            <span class="accordion__header--text">Day One</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-1" class="accordion__body collapse show" data-parent="#w1-day1" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-ONE" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day1','Week1_D-ONE')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day1" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day1">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-ONE[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-ONE[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text" required name="title_Week1_D-ONE[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0" required name="sets_Week1_D-ONE[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0" required name="reps_Week1_D-ONE[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0" required name="temp_Week1_D-ONE[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0" required name="rest_Week1_D-ONE[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text" required name="intensity_Week1_D-ONE[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},`Week1_D-ONE`)">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-ONE[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
                                                                    </div>







                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            {{-- Day 2 --}}

                                            <div class="col-md-12">
                                                <div id="w1-day2" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-2" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Two</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-2" class="accordion__body collapse" data-parent="#w1-day2" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-Two" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day2','Week1_D-Two')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day2">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day2" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-Two[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-Two[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week1_D-Two[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week1_D-Two[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week1_D-Two[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week1_D-Two[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week1_D-Two[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week1_D-Two[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},'Week1_D-Two')">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-Two[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
                                                                    </div>







                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                              {{-- Day 3 --}}

                                              <div class="col-md-12">
                                                <div id="w1-day3" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-3" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Three</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-3" class="accordion__body collapse" data-parent="#w1-day3" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-THREE" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day3','Week1_D-THREE')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day3">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day3" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-THREE[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-THREE[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week1_D-THREE[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week1_D-THREE[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week1_D-THREE[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week1_D-THREE[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week1_D-THREE[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week1_D-THREE[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},'Week1_D-THREE')">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-THREE[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
                                                                    </div>







                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                              {{-- Day 4 --}}

                                              <div class="col-md-12">
                                                <div id="w1-day4" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-4" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Four</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-4" class="accordion__body collapse" data-parent="#w1-day4" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-FOUR" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day4','Week1_D-FOUR')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day4">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day4" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-FOUR[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-FOUR[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week1_D-FOUR[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week1_D-FOUR[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week1_D-FOUR[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week1_D-FOUR[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week1_D-FOUR[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week1_D-FOUR[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},'Week1_D-FOUR')">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-FOUR[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
                                                                    </div>







                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                              {{-- Day 5 --}}

                                              <div class="col-md-12">
                                                <div id="w1-day5" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-5" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Five</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-5" class="accordion__body collapse" data-parent="#w1-day5" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-Five" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day5','Week1_D-Five')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day5">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day5" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-Five[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-Five[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week1_D-Five[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week1_D-Five[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week1_D-Five[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week1_D-Five[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week1_D-Five[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week1_D-Five[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},'Week1_D-Five')">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-Five[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
                                                                    </div>







                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                              {{-- Day 6 --}}

                                              <div class="col-md-12">
                                                <div id="w1-day6" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-6" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Six</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-6" class="accordion__body collapse" data-parent="#w1-day6" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-Six" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day6','Week1_D-Six')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day6">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day6" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-Six[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-Six[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week1_D-Six[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week1_D-Six[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week1_D-Six[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week1_D-Six[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week1_D-Six[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week1_D-Six[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},'Week1_D-Six')">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-Six[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
                                                                    </div>







                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                              {{-- Day 7 --}}

                                              <div class="col-md-12">
                                                <div id="w1-day7" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-7" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Seven</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week-day-7" class="accordion__body collapse" data-parent="#w1-day7" style="">
                                                            <input type="hidden" name="days[]" value="Week1_D-Seven" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w1-day7','Week1_D-Seven')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%" class="w1-day7">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>
                                                                    @php
                                                                    $rand1= uniqid();
                                                                    @endphp


                                                                    <div class="sort-row-w1-day7" style="width: 100%">
                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%">1</td>
                                                                            <td style="width: 14%;">
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                            </span></button> <input type="hidden" name="video_Week1_D-Seven[{{ $rand1 }}][]" id="video{{ $rand1 }}"> <input type="hidden" name="image_Week1_D-Seven[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                <img src="#" id="img{{ $rand1 }}"   class="d-none" onclick="openModal({{ $rand1 }},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week1_D-Seven[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week1_D-Seven[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week1_D-Seven[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week1_D-Seven[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week1_D-Seven[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week1_D-Seven[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},'Week1_D-Seven')">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week1_D-Seven[{{ $rand1 }}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
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
                            @else

                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    @foreach ($item['exercise_weeks'] as $pkey=> $week)


                                    <li class="nav-item nav-item-1">
                                        <a @if($pkey==0) class="nav-link active" @else class="nav-link" @endif data-toggle="tab" href="#week{{$week['id']}}"><i class="la la-week mr-2"></i> {{ $week['week_name'] }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($item['exercise_weeks'] as $rkey=> $week)
                                    <div @if($rkey==0) class="tab-pane fade show active" @else class="tab-pane fade" @endif id="week{{ $week['id'] }}" role="tabpanel">
                                        <input type="hidden" name="id" value="{{ $item['id'] }}" id="">
                                        <input type="hidden" name="weeks[]" value="{{ $week['week_name'] }}" id="">
                                        <div class="pt-4">

                                            @foreach ($week['exercise_days'] as $key=> $day)
                                            <div class="col-md-12">
                                                <div id="w{{ $week['id'] }}-day{{ $day['id']+100 }}" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week{{ $week['id'] }}-day-{{ $day['id']+100 }}" aria-expanded="false">
                                                            <span class="accordion__header--text">{{ ucwords(strtolower($day['day_name']))   }}</span>
                                                            <span class="accordion__header--indicator"></span>

                                                        </div>
                                                        <div id="week{{ $week['id'] }}-day-{{ $day['id']+100 }}" class="accordion__body collapse " data-parent="#w{{ $week['id'] }}-day{{ $day['id']+100 }}" style="">
                                                            <input type="hidden" name="days[]" value="{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}" id="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                  <div class="col-md-12" >
                                                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w{{ $week['id'] }}-day{{ $day['id']+100 }}','{{ $week['week_name'] }}_{{str_replace('Day ','D-',$day['day_name'])}}')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                    </span>Add More</button>
                                                                  </div>
                                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                        <tr>
                                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                            <th style="width: 14%;">Image</th>
                                                                            <th style="width: 18%;">Name</th>
                                                                            <th colspan="6">
                                                                                 Description
                                                                            </th>
                                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                        </tr>
                                                                    </table>



                                                                    <div class="sort-row-w{{ $week['id'] }}-day{{ $day['id']+100 }}" style="width: 100%">
                                                                        @foreach ($day['exercise_infos'] as $key1=>$exercise_info)
                                                                        @php
                                                                        $rand1= uniqid();
                                                                        @endphp


                                                                        <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove{{ $rand1 }}"><tr >
                                                                            <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w{{ $week['id'] }}-day{{ $day['id']+100 }}">{{ $key1+1 }}</td>
                                                                            <td style="width: 14%;">
                                                                                @if($exercise_info['image_path']==null)
                                                                                <button type="button" id="btn-w-day-{{ $rand1 }}" onclick="openModal({{ $rand1 }}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>

                                                                                </span></button>
                                                                                @endif
                                                                             <input type="hidden" value="{{$exercise_info['video_path']}}" name="video_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="video{{ $rand1 }}">
                                                                              <input type="hidden" value="{{$exercise_info['image_path']}}" name="image_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="image{{ $rand1 }}">
                                                                             <div class="about-pic">
                                                                                @if($exercise_info['image_path']!=null)
                                                                                <img src="{{ URL::to($exercise_info['image_path']) }}" id="img{{ $rand1 }}"    onclick="openModal({{ $rand1 }},{{ $exercise_info['video_path'] }})" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                     <img src="{{ URL::to('front/img/play.png') }}"  id="play-img{{ $rand1 }}" alt="" style="height: 30px;">
                                                                               </a>
                                                                               @else
                                                                               <img src="{{ URL::to($exercise_info['image_path']) }}" id="img{{ $rand1 }}" class="d-none"   onclick="openModal({{ $rand1 }},{{ $exercise_info['video_path'] }})" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                               <a  onclick="openModal({{ $rand1 }},null)" class="play-btn video-popup">
                                                                                    <img src="{{ URL::to('front/img/play.png') }}"  id="play-img{{ $rand1 }}" class="d-none"  alt="" style="height: 30px;">
                                                                              </a>

                                                                               @endif
                                                                             </div>
                                                                         </td>
                                                                            <td style="width: 19%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text" value="{{$exercise_info['title']}}" required name="title_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]"  style="width: 100%" /> </div>
                                                                            </div></td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0" value="{{$exercise_info['sets']}}" required name="sets_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="sets" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0" required value="{{$exercise_info['reps']}}" name="reps_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="reps" id="reps" /> </div>
                                                                                </div>
                                                                            </td>

                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0" required value="{{$exercise_info['temps']}}" name="temp_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="temp" /> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0" required value="{{$exercise_info['rest']}}" name="rest_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 9%;">
                                                                                <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text" required value="{{$exercise_info['intensity']}}" name="intensity_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]" id="intensity"/> </div>
                                                                                </div>
                                                                            </td>
                                                                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable({{ $rand1 }},`{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}`)">
                                                                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                           <g>
                                                                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                   "/>
                                                                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                           </g>
                                                                           <g>

                                                                                </svg>
                                                                                    </div>

                                                                            </td>
                                                                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                </div>
                                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                                </div>
                                                                            </div>

                                                                    </td>


                                                                    </tr>
                                                                </table>
                                                                    <table class="table-wrapper" id="remove-s{{ $rand1 }}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                        <tr>

                                                                            <td style="width: 100%;"> <div class="step-forms">
                                                                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_{{$week['week_name']}}_{{str_replace('Day ','D-',$day['day_name'])}}[{{ $rand1 }}][]"  style="width: 100%;padding:12px" >{{$exercise_info['description']}}</textarea> </div>
                                                                            </div></td>

                                                                        </tr>









                                                                        </table>
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



                            @endif

                         </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal fade" id="basicModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Video</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Video Upload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Thumbnail Upload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab-1" data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile" aria-selected="false">Video</a>
                    </li>

                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"> <div id="drag-drop-area"></div></div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"> <div id="drag-drop-area-2"></div></div>
                    <div class="tab-pane fade" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">

                        <video controls src="#"  class="w-100" id="video-path" style="border-radius:10%;min-height:100%;margin-top:10px " >
                        </video>
                    </div>

                  </div>

            </div>

        </div>
    </div>
</div>

@endsection
@section('script')

<script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
<script src="https://releases.transloadit.com/uppy/v2.3.1/uppy.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
    var iteration_no=`{{ count($item['exercise_weeks']) }}`;
</script>
    <script>
         var no=0;
      var uppy = new Uppy.Core({
        restrictions : {
            maxNumberOfFiles: 1,  // nombre max de fichier
            allowedFileTypes: ['video/*'] //type fichier
        },

        meta: {
            exercise_id: `{{ $user_id }}`,
            type:"video"
             // post parametre
        },
      })
        .use(Uppy.Dashboard, {
          inline: true,

          target: '#drag-drop-area'
        })
        .use(
            Uppy.XHRUpload, {
            endpoint: "{{ route('admin.users.video.upload') }}",
            timeout: 0,
            fieldName: 'file',
            headers: {
            'X-CSRF-TOKEN': document.getElementById('csrf').getAttribute('content')
        },})

      uppy.on('complete', (result) => {

          let response=result['successful'][0]['response']['body'];
          console.log(response.success);

          if(response.success===true){
              $(`#video${no}`).val(response.video.path);
          }


      })

      var uppy2 = new Uppy.Core({
        restrictions : {
            maxNumberOfFiles: 1,  // nombre max de fichier
            allowedFileTypes: ['image/*'] //type fichier
        },

        meta: {
            exercise_id: `{{ $user_id }}`,
            type:"images"
             // post parametre
        },
      })
        .use(Uppy.Dashboard, {
          inline: true,

          target: '#drag-drop-area-2'
        })
        .use(
            Uppy.XHRUpload, {
            endpoint: "{{ route('admin.users.video.upload') }}",
            timeout: 0,
            fieldName: 'file',
            headers: {
            'X-CSRF-TOKEN': document.getElementById('csrf').getAttribute('content')
        },})

        uppy2.on('complete', (result) => {

          let response=result['successful'][0]['response']['body'];
          console.log(response.success);

          if(response.success===true){
              $(`#image${no}`).val(response.video.path);
              $(`#btn${no}`).addClass('d-none');
              $(`#img${no}`).removeClass('d-none');
              $(`#img${no}`).attr("src","/"+response.video.path);
              $(`#play-img${no}`).removeClass('d-none');
          }


      })



    </script>
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

    function openModal(id,value){
        console.log(id,value);
        uppy.reset();
        $('#basicModal').modal();
        if(value!=null && value!=="http://localhost:8000"){
            $('#video-path').show();
        $('#video-path').attr("src",value);
        }else{
            $('#video-path').hide();
        }
        no=id;
    }
    function remove(id){
       $(`#remove${id}`).remove();
       $(`#remove-s${id}`).remove();
    }
    function appendTable(key,d){



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
        <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text" required name="description_${d}[${key}][]" style="width: 100%;padding:12px" ></textarea> </div>
    </div></td>

</tr>









</table>`;

$(`#remove${key}`).after(phtml);
}


}

function appendRow(id,d){
    let no=parseInt($(`.${id}` ).last().text())+1;
        if(isNaN(no)){
            no=1;
        }

let randomNo=Math.floor((Math.random() * 100) + 1);

let html=`   <div class="sort-row-1 unsortable">  <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo}"><tr >
                            <td style="text-align: left; padding-left: 20px; width: 5.5%" class="${id}">${no}</td>
                            <td style="width: 14%;"><button type="button" id="btn${randomNo}" onclick="openModal(${randomNo}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                            </span></button> <input type="hidden" name="video_${d}[${randomNo}][]" id="video${randomNo}"> <input type="hidden" name="image_${d}[${randomNo}][]" id="image${randomNo}">
                            <div class="about-pic">
                             <img src="#" id="img${randomNo}"   class="d-none" onclick="openModal(${randomNo},null)" alt="img" style="object-fit: cover; width: auto; height: 48px;width:5px"/>
                             <a onclick="openModal(${randomNo},null)" class="play-btn video-popup">
                                 <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo}" alt="" style="height: 30px;">
                           </a>
                             </div>
                              </td>
                            <td style="width: 19%;"> <div class="step-forms unsortable">
                                <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text" required name="title_${d}[${randomNo}][]"  style="width: 100%" /> </div>
                            </div></td>
                            <td style="width: 9%;">
                                <div class="step-forms unsortable">
                                    <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0" required name="sets_${d}[${randomNo}][]" id="sets" /> </div>
                                </div>
                            </td>
                            <td style="width: 9%;">
                                <div class="step-forms">
                                    <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0" required name="reps_${d}[${randomNo}][]" id="reps" id="reps" /> </div>
                                </div>
                            </td>

                            <td style="width: 9%;">
                                <div class="step-forms">
                                    <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0" required name="temp_${d}[${randomNo}][]" id="temp" /> </div>
                                </div>
                            </td>
                            <td style="width: 9%;">
                                <div class="step-forms">
                                    <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0" required name="rest_${d}[${randomNo}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                </div>
                            </td>
                            <td style="width: 9%;">
                                <div class="step-forms">
                                    <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text" required name="intensity_${d}[${randomNo}][]" id="intensity"/> </div>
                                </div>
                            </td>
                            <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo},'${d}')">
                                <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                           <g>
                               <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                   c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                   h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                   "/>
                               <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                           </g>
                           <g>

                                </svg>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table${randomNo}"><div class="dropdown ml-auto text-right">
                                <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0)"  onclick="remove(${randomNo})">Remove</a>
                                </div>
                            </div>
                        </div>
                    </td>


                    </tr></table></div>`;

                    console.log(html);

                    $(".sort-row-"+id).append(html);


}
</script>
<script>
    var lastWeek=@json(count($item['exercise_weeks']));
    if(lastWeek==0){
        lastWeek+=1;
    }
     function addWeek(){
        let randomNo=Math.floor((Math.random() * 100) + 1);
        let randomNo_day1=Math.floor((Math.random() * 100) + 1);
        let randomNo_day2=Math.floor((Math.random() * 100) + 1);
        let randomNo_day3=Math.floor((Math.random() * 100) + 1);
        let randomNo_day4=Math.floor((Math.random() * 100) + 1);
        let randomNo_day5=Math.floor((Math.random() * 100) + 1);
        let randomNo_day6=Math.floor((Math.random() * 100) + 1);
        let randomNo_day7=Math.floor((Math.random() * 100) + 1);





        let html=` <li class="nav-item nav-item-1">
                    <a class="nav-link" data-toggle="tab" href="#week${lastWeek+100}"><i class="la la-week mr-2"></i> Week ${lastWeek+1}</a>
                </li> `;

                $('.nav-tabs').append(html);


        let phtml=` <div class="tab-pane fade" id="week${lastWeek+100}" role="tabpanel">

            <input type="hidden" name="weeks[]" value="Week${lastWeek+1}" id="">
            <div class="pt-4">
                <div class="row">
                    <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day1" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-1" aria-expanded="false">
                                                                <span class="accordion__header--text">Day One</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-1" class="accordion__body collapse show" data-parent="#w${lastWeek+1}-day1" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-ONE" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day1','Week${lastWeek+1}_D-ONE')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>
                                                                        @php
                                                                        $rand1= uniqid();
                                                                        @endphp


                                                                        <div class="sort-row-w${lastWeek+1}-day1" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day1}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day1'">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day1}" onclick="openModal(${randomNo_day1}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="video${randomNo_day1}"> <input type="hidden" name="image_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="image${randomNo_day1}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day1}"   class="d-none" onclick="openModal(${randomNo_day1},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day1},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day1}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text" required name="title_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0" required name="sets_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0" required name="reps_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0" required name="temp_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0" required name="rest_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text" required name="intensity_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day1},'Week${lastWeek+1}_D-ONE')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day1})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day1}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-ONE[${randomNo_day1}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
                                                                        </div>







                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                    </div>
                    <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day2" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-2" aria-expanded="false">
                                                                <span class="accordion__header--text">Day Two</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-2" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day2" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-Two" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day2','Week${lastWeek+1}_D-Two')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>



                                                                        <div class="sort-row-w${lastWeek+1}-day2" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day2}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day2">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day2}" onclick="openModal(${randomNo_day2}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="video${randomNo_day2}"> <input type="hidden" name="image_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="image${randomNo_day2}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day2}"   class="d-none" onclick="openModal(${randomNo_day2},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day2},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day2}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week${lastWeek+1}_D-Two[${randomNo_day2}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week${lastWeek+1}_D-Two[${randomNo_day2}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day2},'Week${lastWeek+1}_D-Two')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day2})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day2}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-Two[${randomNo_day2}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
                                                                        </div>







                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                  {{-- Day 3 --}}

                                                  <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day3" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-3" aria-expanded="false">
                                                                <span class="accordion__header--text">Day Three</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-3" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day3" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-THREE" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day3','Week${lastWeek+1}_D-THREE')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>
                                                                        @php
                                                                        $rand1= uniqid();
                                                                        @endphp


                                                                        <div class="sort-row-w${lastWeek+1}-day3" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day3}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day3">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day3}" onclick="openModal(${randomNo_day3}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="video${randomNo_day3}"> <input type="hidden" name="image_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="image${randomNo_day3}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day3}"   class="d-none" onclick="openModal(${randomNo_day3},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day3},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day3}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day3},"Week${lastWeek+1}_D-THREE')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day3})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day3}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-THREE[${randomNo_day3}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
                                                                        </div>







                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                  {{-- Day 4 --}}

                                                  <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day4" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-4" aria-expanded="false">
                                                                <span class="accordion__header--text">Day Four</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-4" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day4" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-FOUR" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day4','Week${lastWeek+1}_D-FOUR')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>
                                                                        @php
                                                                        $rand1= uniqid();
                                                                        @endphp


                                                                        <div class="sort-row-w${lastWeek+1}-day4" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day4}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day4">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day4}" onclick="openModal(${randomNo_day4}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="video${randomNo_day4}"> <input type="hidden" name="image_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="image${randomNo_day4}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day4}"   class="d-none" onclick="openModal(${randomNo_day4},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day4},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day4}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day4},'Week${lastWeek+1}_D-FOUR')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day4})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day4}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-FOUR[${randomNo_day4}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
                                                                        </div>







                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                  {{-- Day 5 --}}

                                                  <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day5" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-5" aria-expanded="false">
                                                                <span class="accordion__header--text">Day Five</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-5" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day5" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-Five" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day5','Week${lastWeek+1}_D-Five')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>
                                                                        @php
                                                                        $rand1= uniqid();
                                                                        @endphp


                                                                        <div class="sort-row-w${lastWeek+1}-day5" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day5}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day5">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day5}" onclick="openModal(${randomNo_day5}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-Five[${randomNo_day5}][]" id="video${randomNo_day5}"> <input type="hidden" name="image_Week1_D-Five[${randomNo_day5}][]" id="image${randomNo_day5}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day5}"   class="d-none" onclick="openModal(${randomNo_day5},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day5},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day5}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week${lastWeek+1}_D-Five[${randomNo_day5}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week${lastWeek+1}_D-Five[${randomNo_day5}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week${lastWeek+1}_D-Five[${randomNo_day5}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week${lastWeek+1}_D-Five[${randomNo_day5}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week${lastWeek+1}_D-Five[${randomNo_day5}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week${lastWeek+1}_D-Five[${randomNo_day5}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day5},'Week${lastWeek+1}_D-Five')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day5})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day5}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-Five[${randomNo_day5}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
                                                                        </div>







                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                  {{-- Day 6 --}}

                                                  <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day6" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-6" aria-expanded="false">
                                                                <span class="accordion__header--text">Day Six</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-6" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day6" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-Six" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day6','Week${lastWeek+1}_D-Six')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>



                                                                        <div class="sort-row-w${lastWeek+1}-day6" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day6}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day6">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day6}" onclick="openModal(${randomNo_day6}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="video${randomNo_day6}"> <input type="hidden" name="image_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="image${randomNo_day6}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day6}"   class="d-none" onclick="openModal(${randomNo_day6},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day6},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day6}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week${lastWeek+1}_D-Six[${randomNo_day6}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week${lastWeek+1}_D-Six[${randomNo_day6}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day6},'Week${lastWeek+1}_D-Six')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day6})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day6}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-Six[${randomNo_day6}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
                                                                        </div>







                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                  {{-- Day 7 --}}

                                                  <div class="col-md-12">
                                                    <div id="w${lastWeek+1}-day7" class="accordion accordion-primary">
                                                        <div class="accordion__item">
                                                            <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-7" aria-expanded="false">
                                                                <span class="accordion__header--text">Day Seven</span>
                                                                <span class="accordion__header--indicator"></span>

                                                            </div>
                                                            <div id="week${lastWeek+1}-day-7" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day7" style="">
                                                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_D-Seven" id="">
                                                                <div class="accordion__body--text">
                                                                    <div class="row">
                                                                      <div class="col-md-12" >
                                                                        <button type="button" class="btn btn-primary btn-sm" style="float: right" onclick="appendRow('w${lastWeek+1}-day7','Week${lastWeek+1}_D-Seven')"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                                                        </span>Add More</button>
                                                                      </div>
                                                                        <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                                            <tr>
                                                                                <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                                                <th style="width: 14%;">Image</th>
                                                                                <th style="width: 18%;">Name</th>
                                                                                <th colspan="6">
                                                                                     Description
                                                                                </th>
                                                                                <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                                            </tr>
                                                                        </table>
                                                                        @php
                                                                        $rand1= uniqid();
                                                                        @endphp


                                                                        <div class="sort-row-w${lastWeek+1}-day7" style="width: 100%">
                                                                            <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo_day7}"><tr >
                                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="w${lastWeek+1}-day7">1</td>
                                                                                <td style="width: 14%;">
                                                                                    <button type="button" id="btn-w-day-${randomNo_day7}" onclick="openModal(${randomNo_day7}),null" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                                                                </span></button> <input type="hidden" name="video_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="video${randomNo_day7}"> <input type="hidden" name="image_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="image${randomNo_day7}">
                                                                                 <div class="about-pic">
                                                                                    <img src="#" id="img${randomNo_day7}"   class="d-none" onclick="openModal(${randomNo_day7},null)" alt="img" style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                    <a  onclick="openModal(${randomNo_day7},null)" class="play-btn video-popup">
                                                                                         <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo_day7}" alt="" style="height: 30px;">
                                                                                   </a>
                                                                                 </div>
                                                                             </td>
                                                                                <td style="width: 19%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text"  name="title_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]"  style="width: 100%" /> </div>
                                                                                </div></td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0"  name="sets_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="sets" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0"  name="reps_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="reps" id="reps" /> </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0"  name="temp_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="temp" /> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0"  name="rest_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 9%;">
                                                                                    <div class="step-forms">
                                                                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text"  name="intensity_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]" id="intensity"/> </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable(${randomNo_day7},'Week${lastWeek+1}_D-Seven')">
                                                                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                                                               <g>
                                                                                   <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                       c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                       h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                       "/>
                                                                                   <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                                                               </g>
                                                                               <g>

                                                                                    </svg>
                                                                                        </div>

                                                                                </td>
                                                                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table0"><div class="dropdown ml-auto text-right">
                                                                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                                    </div>
                                                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                        <a class="dropdown-item" hrjavascript:void(0)f="#"  onclick="remove(${randomNo_day7})">Remove</a>
                                                                                    </div>
                                                                                </div>

                                                                        </td>


                                                                        </tr>
                                                                    </table>
                                                                        <table class="table-wrapper" id="remove-s${randomNo_day7}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px;display:none" >


                                                                            <tr>

                                                                                <td style="width: 100%;"> <div class="step-forms">
                                                                                    <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text"  name="description_Week${lastWeek+1}_D-Seven[${randomNo_day7}][]"  style="width: 100%;padding:12px" ></textarea> </div>
                                                                                </div></td>

                                                                            </tr>









                                                                            </table>
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
        `;



        $('.tab-content').append(phtml);

        lastWeek+=1;




    }
</script>
@endsection