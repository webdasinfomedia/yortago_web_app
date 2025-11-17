@extends('front.dashboard.master')


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                            <div class="d-flex align-items-center">

                                <div class="mr-auto pr-3">
                                    <h1 class="text-black fs-20 text-center">Rate the efforts of the session (e.g. 10 = Max effort)</h1>

                                </div>
                            </div>
                        </div>

                        <div class="card-body mt-2 pb-5">
                            <div class="size1 overlay1">
                                <div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
                                    <div class="flex-w flex-c-m pb-1">
                                        <button class="flex-col-c-m track-size bor1 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>1,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">1</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>2,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">2</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>3,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">3</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>4,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">4</span>
                                        </button>
                                        <button class="flex-col-c-m track-size m-l-15 bor1 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>5,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">5</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>6,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">6</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>7,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">7</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>8,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">8</span>
                                        </button>
                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>9,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">9</span>
                                        </button>

                                        <button class="flex-col-c-m track-size bor1 m-l-15 m-b-20" onclick="window.location.href='{{ route('stream.rating.submit',['id'=>10,'stream_id'=> $stream_id]) }}'" style="background-color: skyblue">
                                            <span class="track-txt">10</span>
                                        </button>
                                    </div>
                                    <div class="table-responsive-sm table-responsive-xs">
                                        <table class="table rpe-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">RPE SCALE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #63be7b">1</td>
                                                    <td class="t-center">Nothing</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #85c77d">2</td>
                                                    <td class="t-center">Very Easy</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #a8d280">3</td>
                                                    <td class="t-center">Easy</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #cbdd7f">4</td>
                                                    <td class="t-center">Comfortable</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #eee683">5</td>
                                                    <td class="t-center">Somewhat Difficult</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #ffdd83">6</td>
                                                    <td class="t-center">Difficult</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #fcbf7c">7</td>
                                                    <td class="t-center">Hard</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #fca377">8</td>
                                                    <td class="t-center">Very Hard</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color: #fa8571">9</td>
                                                    <td class="t-center">Extremely Hard</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-70 t-center" style="background-color:#f8696b">10</td>
                                                    <td class="t-center">Maximal / Exhaustion</td>
                                                </tr>
                                            </tbody>
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

@endsection
