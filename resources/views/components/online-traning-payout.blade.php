@if(auth()->user() && ! auth()->user()->isSubscribed('Subscription'))
    <div class="col-xl-12">
        <div class="card bg-transparent">

            <div class="card-body" style="padding: 1px">

                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Pay Your dues to Continue Your Live Training Session

                    {{-- <button style="float: right;
                    position: absolute;
                    top: 0;
                    right: 0;" type="button" onclick="window.location.href=`{{ route('payout') }}`" class="close h-100 btn btn-success" ><span>Pay Now</span>
                    </button> --}}
                </div>

            </div>
        </div>
    </div>
@endif

<div class="col-xl-12 col-lg-12">

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Payment Details</h4>
        </div>

        <div class="card-body">
            <div class="basic-form">
                @if( auth()->user()->user_type=='OnlineTraining')
                    <form method="POST" action="{{ route('payout.submit') }}" enctype="multipart/form-data" id="form">
                        @csrf
                        <input type="hidden" name="plan_id" id="" value="{{$onlineTraningPlans->price_id}}">
                        <input type="hidden" name="price" id="" value="{{$onlineTraningPlans->price}}">
                        <input type="hidden" name="stripe_token" id="stripe_token" value="">
                        <div class="error"></div>
                        <div class="success"></div>



                        <div id="payment_form " >
                            <div class="row  mt-2 pt-2" style="width: 100%">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="form-control" id="card-number-element" class="field"  style="line-height: 50px;padding: 20px;width: 100%;"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="input-group">
                                        <div class="form-control" id="card-expiry-element" class="field" style="line-height: 50px;padding: 20px;width: 100%;"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="input-group">
                                        <div class="form-control" id="card-cvc-element" class="field" style="line-height: 50px;padding: 20px;width: 100%;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="input-group">
                                        <input class="form-control" id="postal-code" required  type="number" placeholder="Billing Zip" name="billing-zip">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2"></div>
                                <div class="col-md-4 mt-4">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-block btn-primary"> <img  class="show-loader"  style="width: 40px;height: 30px;display:none" src="{{ URL::to('front/img/loader.svg') }}" > Pay ${{$onlineTraningPlans->price}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                @endif
            </div>
        </div>
    </div>
</div>
