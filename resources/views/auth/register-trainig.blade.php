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
</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->

    @include('front.layouts.header')
    <!-- Header End -->

    <div class="page-wrapper p-t-60 p-b-100 font-poppins" style="background-color: #f5f5f5;	margin-top: 78px;">
        <div class="">
            <div class="row" style="margin-right: 0px;">
        <div class="wrapper wrapper--w400">
            <div class="card mt-5" style="border: none; background-color: #f5f5f5;">
                <img src="{{ URL::to('front/img/blog/blog-8.jpg') }}" alt="" width="280"
                height="250" style="margin: 0 auto">
                <h3 class="mt-4 mb-2" style="text-align: center;">Real Life. Real Results. Really Fun.</h3>
                <ul style="margin-left: 37px; margin-right: 20px;margin-bottom: 20px;
                margin-top: 10px; font-size: 18px;">
                    <li class="mb-2">
                        Up to 20 daily LIVE classes & more than 6,000 on-demand classes
                    </li>
                    <li class="mb-2">
                        Choose from a huge variety of workouts like Sculpt, Dance HIIT, Strength, Pilates, and Yoga
                    </li>
                    <li class="mb-2">
                        Our instructors will TRULY get you results—and make it fun!
                    </li>
                </ul>
            </div>
            </div>
            <div class="wrapper wrapper--w680">
            <div class="card card-4 ">
                <div class="card-body">
                    <h2 class="title">Lets Get Started!</h2>
                   <div id="focus_point">
                    <span class="invalid-feedback" role="alert" style="display: revert">
                        <strong id="from-error"></strong>
                    </span>
                    <br>
                   </div>
                    <form method="POST" action="{{ route('register') }}" id="form">
                        @csrf
                        <input type="hidden" name="stream_id" @if(count($streamPlans)>0) value="{{$streamPlans[0]['id']  }}" @endif id="stream_id">
                        <input type="hidden" name="stripe_token" value="" id="stripe_token">
                        <div class="row row-space">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label for="">Name</label>
                                    <input class="input--style-4" type="text" required placeholder="Name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label for="">Phone No</label>
                                    <input class="input--style-4" min="0" type="number" required placeholder="Phone No" name="phone_no">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <label for="">Email</label>
                                    <input class="input--style-4" type="email" required placeholder="Email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <label for="">Password</label>
                                    <input class="input--style-4" type="password" required placeholder="Password" name="password">
                                    <span>Password must contain at least 6 characters.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <label for="">Confirm Password</label>
                                    <input class="input--style-4" type="password" required placeholder="Confirm Password" name="password_confirmation">
                                    <span>Password Confirm must contain at least 6 characters.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <label for="">Purpose of joining</label>
                                    <input class="input--style-4" type="text" required placeholder="Purpose of joining" name="joining_purpose">
                                </div>
                            </div>
                        </div>
                        <div class="row-space">
                            <label for="">Where You Find Us</label><br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <p>
                                        <input type="radio" id="internet" name="find_us" checked>
                                        <label for="internet">Internet</label>
                                      </p>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        <input type="radio" id="Facebook" name="find_us" >
                                        <label for="Facebook">Facebook</label>
                                      </p>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        <input type="radio" id="Instagram" name="find_us" >
                                        <label for="Instagram">Instagram</label>
                                      </p>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        <input type="radio" id="Locally" name="find_us" >
                                        <label for="Locally">Locally</label>
                                      </p>
                                </div>
                                <div class="col-md-4">
                                    <p>
                                        <input type="radio" id="Friends" name="find_us" >
                                        <label for="Friends">Friends</label>
                                      </p>
                                </div>
                            </div>
                        </div>
                        <h4 class="title mt-3 mb-3">Choose Your Subscription Plan</h4>

                        @foreach ($streamPlans as $key=>$streamPlan)
                        <div class="row row-space mb-3" onclick="streamplan(`{{ $streamPlan['id'] }}`)">
                            <div class="col-md-12">
                                <div class="subb{{ $key!==0?$key:"" }} sub-row{{ $key==0?"-focus":"" }}" tabindex="0">
                                    <h5>{{ $streamPlan['name'] }}</h5>
                                    <span>${{ number_format($streamPlan['price'],2) }} billed after {{ $streamPlan['total_session'] }} Session Completion</span>
                                </div>
                            </div>
                        </div>
                        @endforeach


                        @if(count($streamPlans)>0)
                        <h4 class="title plan-title mt-3 mb-3">{{ $streamPlans[0]['name'] }}</h4>
                        <p class="plan-desc" style="text-align: center;" class="sub-p">{{$streamPlans[0]['plan_description']  }}</p>


                        @endif


                            <div class="error"></div>
                            <div class="success"></div>
                            <div class="row row-space mt-4 pt-2">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input--style-4" id="card-number-element" class="field"  style="line-height: 50px;padding: 20px;width: 100%;"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input--style-4" id="card-expiry-element" class="field" style="line-height: 50px;padding: 20px;width: 100%;"></div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input--style-4" id="card-cvc-element" class="field" style="line-height: 50px;padding: 20px;width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="input--style-4" id="postal-code"  type="number" placeholder="Billing Zip" name="billing-zip">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="input--style-4" type="number" placeholder="Gift or promo code" name="promo-code">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-md-12">
                                    <div class="input-group" style="display: block;">
                                       <input  type="checkbox" id="checkbox" name="checkbox" value="checkbox" style="width: 3%; margin-top: 6px;">
                                        <label for="checkbox" style="display: contents;">By checking this box, you acknowledge that you understand our <a href="#" class=" mr-1">Terms & Conditions</a> and <a href="#" class="ml-1 mr-1">Privacy Policy</a> and agree to *these terms.</label>
                                    </div>
                                </div>
                            </div>



                        <div>
                            <button type="submit" class="register-btnn"> <img  class="show-loader"  style="width: 40px;height: 30px;display:none" src="{{ URL::to('front/img/loader.svg') }}" >Register @if(count($streamPlans)>0) ${{ $streamPlans[0]['price'] }} @endif</button>
                        </div>
                    </form>
                </div>
            </div>
        </div></div></div>
    </div>

    <!-- Footer Section Begin -->
  @include('front.layouts.footer')
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    @include('front.layouts.script')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var streamID= @if (count($streamPlans)>0)`{{ $streamPlans[0]['id'] }}` @else 0 @endif;
        var streamPrice=@if (count($streamPlans)>0) `{{ $streamPlans[0]['price'] }}` @else 0 @endif;;
        var stripe = Stripe('pk_test_9jgjsQVQTSPOOcDiQwv2mc34');
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



                    submitForm(result.token.id);


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
                    address_zip: document.getElementById('postal-code').value,
                };
                console.log(options);
                stripe.createToken(cardNumberElement, options).then(setOutcome);

                });

                function submitForm(token){

                    let record=$('#form').serialize();
                    $('.show-loader').css("display", "revert");
                    $.ajax({
                    type: 'POST',
                    url: '{{ route('register') }}',
                    data: record,
                    success: function (response) {

                       if(response.success){
                        window.location.href = "/";
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


    <script>

        function streamplan(id){
            let streamPlans=@json($streamPlans);

            let filterObj=streamPlans.filter((item)=>item.id==id);
            console.log(filterObj);

            if(filterObj.length>0){

                $('.plan-title').text(filterObj[0].name);
                $('.plan-desc').text(filterObj[0].plan_description);
                $('.register-btnn').html(`<img  class="show-loader"  style="width: 40px;height: 30px;display:none" src="{{ URL::to('front/img/loader.svg') }}" > Register $ ${filterObj[0].price}`);

                 streamID=filterObj[0].id;
                 streamPrice=filterObj[0].price;

                 $('#stream_id').val(filterObj[0].id);

            }




        }
    </script>
</body>

</html>
