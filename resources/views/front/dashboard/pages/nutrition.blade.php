@extends('front.dashboard.master')
@section('admin_title')
Nutrition
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::to('front/css/lightbox.min.css') }}">

<style>
    .accordion-primary .accordion__header.collapsed {
        background: linear-gradient(to right, #d38d49, #d76e33);
        border-color: #d17b4b;
    color: #211c37;
    box-shadow: none;
}
.accordion-primary .accordion__header {
    background: linear-gradient(to right, #d38d49, #d76e33);
    border-color: #d17b4b;
    color: #fff;
    box-shadow: 0 15px 20px 0 rgb(108 197 29 / 15%);
}
</style>

@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-xxl-4">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card flex-xl-column flex-md-row flex-column">
                        <div class="card-body">
                            <h6 class="fs-20 text-black mb-4 pb-0">Week List</h6>
                            @isset($nutrition)
                            @foreach ($nutrition['nutrition_weeks'] as $key=> $nut )
                            <div class="d-flex mb-4 pb-1 align-items-center">
                                <span class="date-icon-l active show mr-3">{{ $key+1 }}</span>
                                <div class="nav-item">
                                    <h6 class="fs-16"><a href="#week{{ $nut['id'] }}" onclick="changeTab({{ $nut['id'] }})" data-toggle="tab" role="tab" @if($key==0) class="nav-link active show" @else class="nav-link" @endif >{{ $nut['weak_name'] }}</a></h6>

                                </div>
                            </div>
                            @endforeach
                            @endisset



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-xxl-8">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card plan-list">
                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                            <div class="mr-auto pr-3">
                                <h4 class="text-black fs-20">Week Detail</h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                @isset($nutrition)
                                @foreach ($nutrition['nutrition_weeks'] as $key=> $nut )
                                <div id="wk{{ $nut['id'] }}" @if($key==0) class="tab-pane fade show active" @else class="tab-pane fade" @endif role="tabpanel">
                                    <div id="accordion-one" class="accordion accordion-primary">
                                        @foreach ($nut['nutrition_info'] as $key1=> $nutrition_info)
                                        <div class="accordion__item">
                                            <div   @if($key1==0) class="accordion__header rounded-lg" @else class="accordion__header rounded-lg collapsed" @endif data-toggle="collapse" data-target="#default_collapseOne{{ $nutrition_info['id'] }}" aria-expanded="true">
                                                <span class="accordion__header--text">{{ $nutrition_info['heading'] }}</span>
                                                <span class="accordion__header--indicator"></span>
                                            </div>
                                            <div id="default_collapseOne{{ $nutrition_info['id'] }}" @if($key1==0) class="accordion__body collapse show" @else class="accordion__body collapse" @endif data-parent="#accordion-one" style="">
                                                <div class="accordion__body--text">
                                                    <div >
                                                        <a class="example-image-link" href="{{ URL::to($nutrition_info['image']) }}" data-lightbox="example-1"> <img src="{{ URL::to($nutrition_info['image']) }}" class="img-responsive" alt="Cinque Terre" style="width: 100%" alt=""></a>

                                                    </div>
                                                    <p style="    padding-top: 15px;
                                                    padding-left: 18px;
                                                    padding-bottom: 2px;
                                                    margin-bottom: 2px;"><strong>Suggestion:</strong> {!! $nutrition_info['suggestion'] !!} </p>
                                                    {!! $nutrition_info['nutrition_advice'] !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                    </div>
                                </div>
                                @endforeach
                                @endisset

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
<script src="{{ URL::to('front/js/lightbox-plus-jquery.min.js') }}"></script>

<script>
    function changeTab(id){

        $(`.nav-link`).removeClass('active');
        $(`.tab-pane`).removeClass('active');
        $(`.accordion__header`).removeClass('active show');
        $(`#week${id}`).addClass('active show');
        $(`#week${id}`).addClass('active show');
        $(`#wk${id}`).addClass('active show');

    }
</script>


@endsection
