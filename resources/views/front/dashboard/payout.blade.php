@extends('front.dashboard.master')
@section('admin_title')
Pay Out
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/css/style.css') }}">
<link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
<style>
    .btn-primary:focus, .btn-primary.focus , .btn-primary:hover {
    color: white;
    background-color: rgb(211, 139, 71);
    border-color: rgb(211, 139, 71);
    box-shadow: 0px 3px 5px 0px rgb(0 0 0 / 8%);
}
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
    .nav-link{
        padding: 0.5rem 1rem !important;
    border-radius: 0.875rem 0.875rem 0 0 !important;
    border: 1px solid transparent !important;
    border-color: #dee2e6 #dee2e6 #F5F9F1 !important;
    }
</style>


@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        @if(auth()->user()->user_type=='Stream')
        @if(auth()->user()->no_of_session+auth()->user()->free_session==0)
        <div class="col-xl-12">
        <div class="card bg-transparent">

            <div class="card-body" style="padding: 1px">

                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                     Pay Your dues to Continue Your Live Stream Session

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
                    <h4 class="title mt-3 mb-3">Choose Your Subscription Plan</h4>
                    <div class="row" >
                    @foreach ($streamPlans as $key=>$streamPlan)

                            <div class="col-sm-12 col-md-4 mb-4">
                                <div class="stream-plans subb{{ $key!==0?$key:"" }} sub-row {{ $key==0?"sub-row-focus":"" }}" tabindex="0" data-id="{{$streamPlan['id']}}" data-price="${{ number_format($streamPlan['price'],2) }}" >
                                    <h5>{{ $streamPlan['name'] }}</h5>
                                    <span>${{ number_format($streamPlan['price'],2) }} billed after {{ $streamPlan['total_session'] }} Session Completion</span>
                                </div>
                            </div>

                    @endforeach
                    </div>
                    <div class="basic-form">
                        @if( auth()->user()->user_type=='Stream')
                        <form method="POST" action="{{ route('payout.submit') }}" enctype="multipart/form-data" id="form">
                            @csrf

                            <input type="hidden" name="stripe_token" id="stripe_token" value="">
                            <input type="hidden" name="stream_id" id="stream_id" value="{{$streamPlans[0]->id}}">
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
                                        <button type="submit" class="btn btn-block btn-primary payout-btn"> <img  class="show-loader"  style="width: 40px;height: 30px;display:none" src="{{ URL::to('front/img/loader.svg') }}" > Pay $ {{ $streamPlans[0]['price'] }}</button>
                                    </div>
                                </div>
                            </div>
                           </div>
                        </form>
                        @else
                            <form method="POST" action="{{ route('payout.submit') }}" enctype="multipart/form-data" id="form">
                                @csrf
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
                                                <button type="submit" class="btn btn-block btn-primary payout-btn"> <img  class="show-loader"  style="width: 40px;height: 30px;display:none" src="{{ URL::to('front/img/loader.svg') }}" > Pay $ {{ $streamPlans[0]['price'] }}</button>
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

        @elseif(auth()->user()->user_type=='OnlineTraining')
            @include('components.online-traning-payout')
        @endif

    </div>

</div>
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>

<script>
    $(document).ready(function(){
        $('.stream-plans').click(function(){
            let id=$(this).data('id');
            $('.stream-plans').removeClass('sub-row-focus');
            $(this).addClass('sub-row-focus');
            $('input[name=stream_id]').val(id);
            let price = $(this).data('price');
            $('.payout-btn').html(`<img  class="show-loader"  style="width: 40px;height: 30px;display:none" src="{{ URL::to('front/img/loader.svg') }}" > Pay  ${price}`);
        });
    });

    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var elements = stripe.elements();
    var cardNumberElement = elements.create('cardNumber', {

    placeholder: 'Credit Card / Debit Card Number',
    });
    cardNumberElement.mount('#card-number-element');

    var cardExpiryElement = elements.create('cardExpiry', {

    });
    cardExpiryElement.mount('#card-expiry-element');

    var cardCvcElement = elements.create('cardCvc', {

     });
        cardCvcElement.mount('#card-cvc-element');



        function setOutcome(result) {
            var successElement = document.querySelector('.success');
            var errorElement = document.querySelector('.error');
            successElement.classList.remove('visible');
            errorElement.classList.remove('visible');

            if (result.token) {


                $('#stripe_token').val(result.token.id);
                console.log(result);



                submitForm(result.token.id);


            } else if (result.error) {
                errorElement.textContent = result.error.message;
                errorElement.classList.add('visible');
                console.log(result.error);
                $('.show-loader').css("display", "none");
            }

        }
        function setOutcome2(result) {
            console.log(result.paymentMethod);
            var successElement = document.querySelector('.success');
            var errorElement = document.querySelector('.error');
            successElement.classList.remove('visible');
            errorElement.classList.remove('visible');

            if (result.paymentMethod) {


                $('#stripe_token').val(result.paymentMethod.id);



                submitForm(result.paymentMethod.id);


            } else if (result.error) {
                errorElement.textContent = result.error.message;
                errorElement.classList.add('visible');
                console.log(result.error);
                $('.show-loader').css("display", "none");
            }

        }


                cardNumberElement.on('change', function(event) {
                setOutcome(event);
                if (event.brand) {

            }
                });

        // Form

        $(document).on('submit','#form',function (e) {
            e.preventDefault();
            $('.show-loader').css("display", "revert");



            var options = {
                address: document.getElementById('postal-code').value,

            };

            stripe.createToken(cardNumberElement, options).then(setOutcome);
           stripe.createPaymentMethod({ type: 'card',card: cardNumberElement,  billing_details: {
               },}).then(setOutcome2);



            });

            function submitForm(token){

                let record=$('#form').serialize();
                $('.show-loader').css("display", "revert");







                $.ajax({
                type: 'POST',
                url: '{{ route('payout.submit') }}',
                data: record,
                success: function (response) {

                   if(response){
                    toastr.success("Payment Captured Successfully",{
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
                    setTimeout(window.location.href = "/dashboard", 1000);

                   }


                },
                error: function (error) {
                    $('.show-loader').css("display", "none");
                    console.log(error.responseJSON.errors);

                    $('#from-error').text(`- ${error.responseJSON.errors}`);
                    $("#focus_point").attr("tabindex",-1).focus();


            }
            });



            }

</script>


@endsection
