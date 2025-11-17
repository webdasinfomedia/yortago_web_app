@extends('admin.layouts.master')
@section('admin_title')
Create Nutrition Program
@endsection
@section('css')
{{-- <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/demo.css') }}"> --}}
<link href="{{ URL::to('front/dashboard/css/style-admin.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
<link href="{{ URL::to('front/dashboard//vendor/summernote/summernote.css') }}" rel="stylesheet">

<style>
    .accordion-primary .accordion__header {
    background: #B9732F!important;
    border-color: #B9732F!important;
    color: #fff!important;
    box-shadow: 0 15px 20px 0 rgb(108 197 29 / 15%);
}
#note-editable ol, ul{
    list-style: disc; !important;
    list-style-position: inside;
}
li::marker {
    content: initial;
}
.dropify-wrapper {

    height: 100px;

}
</style>

@endsection

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Nutrition Program</a></li>
        </ol>
    </div>

    <form action="{{ route('admin.nutrition.program.info.save') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="id" value="{{ $item['id'] }}" id="">

    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            {{-- <div class="col-xl-6"> --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Nutrition Program</h4>
                       <div style="float: right">
                        <button type="submit" class="btn btn-rounded btn-primary"  style="margin-right:10px "><span class="btn-icon-left text-info"><i class="fa fa-save color-info"></i>
                        </span>Save</button>
                        <button type="button" class="btn btn-rounded btn-primary" onclick="addWeek()"  style="float: right"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add Week</button>
                       </div>

                    </div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        @if(count($item['nutrition_weeks'])==0)
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item nav-item-1">
                                    <a class="nav-link active" data-toggle="tab" href="#week1"><i class="la la-week mr-2"></i> Week 1</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="week1" role="tabpanel">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}" id="">
                                    <input type="hidden" name="week_0[]" value="Week 1" id="">
                                    <div class="pt-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="w1-day1" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week-day-1" aria-expanded="false">
                                                            <span class="accordion__header--text">Day One</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-1" class="accordion__body collapse show" data-parent="#w1-day1" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control" required name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control" required name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote" required name="description_0[]" placeholder="Suggestion ....." id=""></textarea>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div id="w1-day2" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week-day-2" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Two</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-2" class="accordion__body collapse" data-parent="#w1-day2" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control"  name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  name="description_0[]" placeholder="Suggestion ....." id=""></textarea>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div id="w1-day3" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week-day-3" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Three</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-3" class="accordion__body collapse" data-parent="#w1-day3" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control"  name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  name="description_0[]" placeholder="Suggestion ....." id=""></textarea>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div id="w1-day4" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week-day-4" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Four</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-4" class="accordion__body collapse" data-parent="#w1-day4" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control"  name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  name="description_0[]" placeholder="Suggestion ....." id=""></textarea>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div id="w1-day5" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week-day-5" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Five</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-5" class="accordion__body collapse" data-parent="#w1-day5" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control"  name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  name="description_0[]" placeholder="Suggestion ....." id=""></textarea>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div id="w1-day6" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week-day-6" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Six</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-6" class="accordion__body collapse" data-parent="#w1-day6" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control"  name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  name="description_0[]" placeholder="Suggestion ....." id=""></textarea>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div id="w1-day7" class="accordion accordion-primary">
                                                    <div class="accordion__item">
                                                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week-day-7" aria-expanded="false">
                                                            <span class="accordion__header--text">Day Seven</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week-day-7" class="accordion__body collapse" data-parent="#w1-day7" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control"  name="heading_0[]" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  name="suggestion_0[]" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image_0[]"    class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  name="description_0[]" placeholder="Suggestion ....." id=""></textarea>

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

                            </div>
                        </div>
                        @else
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                @foreach ($item['nutrition_weeks'] as $keey => $nutrition_weeks)
                                <li class="nav-item nav-item-1">
                                    <a @if($keey==0) class="nav-link  active" @else class="nav-link" @endif   data-toggle="tab" href="#week{{ $nutrition_weeks['id'] }}"><i class="la la-week mr-2"></i> {{ Str::ucfirst($nutrition_weeks['weak_name']) }}</a>
                                </li>
                                @endforeach

                            </ul>
                            <div class="tab-content">

                                @foreach ($item['nutrition_weeks'] as $key1=>$nutrition_weeks )
                                {{-- {{ dd($nutrition_weeks['nutrition_infos']) }} --}}

                                <div @if($key1==0) class="tab-pane fade show active" @else class="tab-pane fade" @endif id="week{{ $nutrition_weeks['id'] }}" role="tabpanel">

                                    <input type="hidden" name="week[{{ $nutrition_weeks['weak_name'] }}][]" value="{{ $nutrition_weeks['weak_name'] }}" id="">
                                    <div class="pt-4">
                                        <div class="row">
                                            @foreach ($nutrition_weeks['nutrition_infos'] as $key => $nutrition_infos)
                                            {{-- {{ dd($nutrition_infos) }} --}}

                                            <div class="col-md-12">
                                                <div id="w{{ $nutrition_weeks['id'] }}-day{{ $nutrition_infos['id'] }}" class="accordion accordion-primary" style="display: block!important">
                                                    <div class="accordion__item">
                                                        <div  class="accordion__header rounded-lg collapsed"  data-toggle="collapse" data-target="#week{{$nutrition_weeks['id']  }}-day-{{$nutrition_infos['id']  }}" aria-expanded="false">
                                                            <span class="accordion__header--text">Day @if($key==0) One @elseif($key==1) Two @elseif($key==2) Three @elseif($key==3) Four @elseif($key==4) Five @elseif($key==5) Six @else Seven  @endif</span>
                                                            <span class="accordion__header--indicator"></span>
                                                        </div>
                                                        <div id="week{{$nutrition_weeks['id']  }}-day-{{$nutrition_infos['id']  }}" @if($key==0) class="accordion__body collapse show" @else class="accordion__body collapse" @endif data-parent="#w{{ $nutrition_weeks['id'] }}-day{{ $nutrition_infos['id'] }}" style="">
                                                            <div class="accordion__body--text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="from-group">
                                                                            <label for="">Heading</label>
                                                                            <input type="text" class="form-control" @if($key==0) required @endif name="heading{{ $nutrition_weeks['weak_name'] }}[{{ $key }}][]" value="{{ $nutrition_infos['heading'] }}" placeholder="Heading ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Suggestion</label>
                                                                            <input type="text" class="form-control"  @if($key==0) required @endif name="suggestion{{ $nutrition_weeks['weak_name'] }}[{{ $key }}][]" value="{{ $nutrition_infos['suggestion'] }}" placeholder="Suggestion ....." id="">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="hidden" name="images{{ $nutrition_weeks['weak_name'] }}[{{ $key }}][]" value="{{ $nutrition_infos['image'] }}" id="">
                                                                            <input type="file" name="image{{ $nutrition_weeks['weak_name'] }}[{{ $key }}][]" value="{{ $nutrition_infos['image'] }}"  @isset($nutrition_infos['image']) data-default-file="{{ URL::to($nutrition_infos['image']) }}" @endisset   class="form-control dropify">

                                                                        </div>
                                                                        <div class="from-group">
                                                                            <label for="">Description</label>
                                                                            <textarea type="text" class="summernote"  @if($key==0) required @endif name="description{{ $nutrition_weeks['weak_name'] }}[{{ $key }}][]" placeholder="Suggestion ....." id="">{{ $nutrition_infos['nutrition_advice'] }}</textarea>

                                                                        </div>

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
                                </div>

                                @endforeach

                            </div>
                        </div>


                        @endif
                    </div>
                </div>
            </div>

        {{-- </div> --}}
    </div>
</form>
</div>


@endsection
@section('script')
<script src="{{ URL::to('front/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>
<!-- Summernote init -->
{{-- <script src="{{ URL::to('front/dashboard/js/plugins-init/summernote-init.js') }}"></script> --}}

<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>

<script>

    $('.summernote').summernote({
        placeholder: 'Nutrition Description',
        tabsize: 2,
        height: 100,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],


        ]
      });

</script>

<script>
    var lastWeek=@json(count($item['nutrition_weeks']));
    if(lastWeek==0){
        lastWeek+=1;
    }
    function addWeek(){
        let randomNo=Math.floor((Math.random() * 100) + 1);





        let html=` <li class="nav-item nav-item-1">
                    <a class="nav-link" data-toggle="tab" href="#week${lastWeek+1}"><i class="la la-week mr-2"></i> Week ${lastWeek+1}</a>
                </li> `;

                $('.nav-tabs').append(html);


        let phtml=` <div class="tab-pane fade" id="week${lastWeek+1}" role="tabpanel">

            <input type="hidden" name="week[${lastWeek+1}][]" value="week ${lastWeek+1}" id="">
            <div class="pt-4">
                <div class="row">
                    <div class="col-md-12">
                        <div id="w${lastWeek+1}-day1" class="accordion accordion-primary">
                            <div class="accordion__item">
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-1" aria-expanded="false">
                                    <span class="accordion__header--text">Day One</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-1" class="accordion__body collapse show" data-parent="#w${lastWeek+1}-day1" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" required name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" required name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" required name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

                                                </div>

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
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-2" aria-expanded="false">
                                    <span class="accordion__header--text">Day Two</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-2" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day2" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="w${lastWeek+1}-day3" class="accordion accordion-primary">
                            <div class="accordion__item">
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-3" aria-expanded="false">
                                    <span class="accordion__header--text">Day Three</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-3" class="accordion__body collapse" data-parent="#w1-day3" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="w${lastWeek+1}-day4" class="accordion accordion-primary">
                            <div class="accordion__item">
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-4" aria-expanded="false">
                                    <span class="accordion__header--text">Day Four</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-4" class="accordion__body collapse" data-parent="#w1-day4" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="w${lastWeek+1}-day5" class="accordion accordion-primary">
                            <div class="accordion__item">
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-5" aria-expanded="false">
                                    <span class="accordion__header--text">Day Five</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-5" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day5" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="w${lastWeek+1}-day6" class="accordion accordion-primary">
                            <div class="accordion__item">
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-6" aria-expanded="false">
                                    <span class="accordion__header--text">Day Six</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-6" class="accordion__body collapse" data-parent="#w${lastWeek+1}-day6" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="w${lastWeek+1}-day7" class="accordion accordion-primary">
                            <div class="accordion__item">
                                <div class="accordion__header rounded-lg collapsed" data-toggle="collapse" data-target="#week${lastWeek+1}-day-7" aria-expanded="false">
                                    <span class="accordion__header--text">Day Seven</span>
                                    <span class="accordion__header--indicator"></span>
                                </div>
                                <div id="week${lastWeek+1}-day-7" class="accordion__body collapse" data-parent="#w1-day7" style="">
                                    <div class="accordion__body--text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="from-group">
                                                    <label for="">Heading</label>
                                                    <input type="text" class="form-control" name="headings${lastWeek+1}[]" placeholder="Heading ....." id="">

                                                </div>
                                                <div class="from-group">
                                                    <label for="">Suggestion</label>
                                                    <input type="text" class="form-control" name="suggestions${lastWeek+1}[]" placeholder="Suggestion ....." id="">

                                                </div>
                                                <div class="from-group">
                                                                            <label for="">Image</label>
                                                                            <input type="file" name="image${lastWeek+1}[]"    class="form-control dropify">

                                                                        </div>
                                                <div class="from-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="summernote" name="descriptions${lastWeek+1}[]" placeholder="Suggestion ....." id=""></textarea>

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
        `;


        $('.tab-content').append(phtml);

        lastWeek+=1;


         $('.summernote').summernote({
            placeholder: 'Nutrition Description',
            tabsize: 2,
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
        ]
      });
      $('.dropify').dropify();

    }
</script>

<script>
      $('.dropify').dropify();
</script>

@endsection