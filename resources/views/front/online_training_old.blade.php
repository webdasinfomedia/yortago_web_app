@extends('front.master')


@section('content')

    <section class="breadcrumb-section set-bg" data-setbg="{{ asset($setting['online_training_page_banner'] ?? '') }}">
        <div id="color-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Online Training</h2>
                        <!-- <div class="breadcrumb-option">
                            <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                            <span>Online Training</span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Membership Section Begin -->
    <section class="membership-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Membership Plans</h2>
                        <p class="mt-3">Access the same Training System as some of the best athletes use, anywhere in the world. YOR Online Training System is the prime performance platform that allows professional, amateur and aspiring athletes to get ahead of the game by becoming faster, stronger, more powerful and agile than your opponents.  </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($plans as $plan)
                    @if($loop->iteration == 1)
                        @continue
                    @endif
                    <div class="col-lg-4">
                        <div class="membership-item">
                            <div class="mi-title">
                                <h4>{{ $plan['name'] }}</h4>
                                <div class="triangle"></div>
                            </div>
                            <h2 class="mi-price">${{ $plan['price'] }}<span>/{{ $plan['duration'] }}</span></h2>
                            <ul>
                                @foreach ($plan['attributes'] as $attribute)
                                    <li>
                                        <p>{{ $attribute['name'] }}</p>
                                        <span>{{ $attribute['value'] }}</span>
                                    </li>
                                @endforeach


                            </ul>
                            <a href="#" onclick="openModal(`{{ $plan['price_id'] }}`)" class="primary-btn membership-btn" data-toggle="modal" data-target="#quesModal">Start Now</a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!-- Membership Section End -->


    <!-- Modal -->
    <div class="modal fade" style="top: 15%" id="quesModal" tabindex="-1" role="dialog" aria-labelledby="quesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quesModalLabel">Questionnaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('online.training.save') }}" method="POST" class="form" id="forms">
                        @csrf
                        <input type="hidden" name="plan_id" value="#" id="plan_id">
                        <div class="progressbar">
                            <div class="progress" id="progress"></div>
                            <div class="progress-step progress-step-active"></div>
                            <div class="progress-step"></div>
                            <div class="progress-step"></div>
                            <div class="progress-step"></div>
                        </div>
                        <div class="step-forms step-forms-active mt-2">
                            <h6 class="mb-3" style="font-weight: 700;">Select your gender:</h6>

                            @foreach ($genders as $g=>$gender)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="gender_id" id="exampleRadios2" @if($g==0) checked @endif value="{{ $gender['id'] }}" style="width: auto">
                                    <label class="form-check-label" for="exampleRadios2">
                                        {{ $gender['name'] }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="btns-group" style="grid-template-columns: repeat(1, 1fr);">
                                {{-- <a href="#" class="btn btn-prev pl-0" style="text-align: left;">Previous</a>   --}}
                                <a href="#" class="primary-btn membership-btn modal-link btn-next  ml-auto" style=" width: 90px;">Next</a> </div>
                        </div>
                        <div class="step-forms">
                            <h6 class="mb-3" style="font-weight: 700;">Focus On:</h6>

                            @foreach ($ages as $ag=>$age)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="age_id" id="exampleRadios2"  @if($ag==0) checked @endif value="{{ $age['id'] }}" style="width: auto">
                                    <label class="form-check-label" for="exampleRadios2">
                                        {{ $age['age_range'] }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="btns-group"><a href="#" class="primary-btn membership-btn btn-prev" style="text-align: left; width: 90px;">Previous</a>  <a href="#" class="primary-btn membership-btn modal-link btn-next  ml-auto" style=" width: 90px;">Next</a> </div>
                        </div>
                        <div class="step-forms">
                            <h6 class="mb-3" style="font-weight: 700;">What equipment do you have access?</h6>

                            @foreach ($equipments as $ag=>$age)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="equipment_id" id="exampleRadios2"  @if($ag==0) checked @endif value="{{ $age['id'] }}" style="width: auto">
                                    <label class="form-check-label" for="exampleRadios2">
                                        {{ $age['name'] }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="btns-group"><a href="#" class="primary-btn membership-btn btn-prev" style="text-align: left; width: 90px;">Previous</a>  <a href="#" class="primary-btn membership-btn modal-link btn-next  ml-auto" style=" width: 90px;">Next</a> </div>
                        </div>
                        <div class="step-forms">
                            <h6 class="mb-3" style="font-weight: 700;">Select your experience level:</h6>

                            @foreach ($experience_levels as $exp=>$experience_level )
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="experience_id" id="exampleRadios2"  @if($exp==0) checked @endif value="{{ $experience_level['id'] }}" style="width: auto">
                                    <label class="form-check-label" for="exampleRadios2">
                                        {{ $experience_level['heading'] }} - {{ $experience_level['sub_heading'] }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="btns-group"> <a href="#" class="primary-btn membership-btn  btn-prev" style="text-align: left; width: 90px;">Previous</a> <input type="submit"  style="width: 90px; height: 40px; line-height: 5px; text-align: center;" value="Submit" id="submit-form" class="primary-btn membership-btn" /> </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        const prevBtns = document.querySelectorAll(".btn-prev");
        const nextBtns = document.querySelectorAll(".btn-next");
        const progress = document.getElementById("progress");
        const formSteps = document.querySelectorAll(".step-forms");
        const progressSteps = document.querySelectorAll(".progress-step");


        let formStepsNum = 0;

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum++;
                updateFormSteps();
                updateProgressbar();

            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressbar();

            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep) => {
                formStep.classList.contains("step-forms-active") &&
                formStep.classList.remove("step-forms-active");
            });

            formSteps[formStepsNum].classList.add("step-forms-active");
        }

        function updateProgressbar() {
            progressSteps.forEach((progressStep, idx) => {
                if (idx < formStepsNum + 1) { progressStep.classList.add("progress-step-active"); } else { progressStep.classList.remove("progress-step-active"); } }); progressSteps.forEach((progressStep, idx)=> {
                if (idx < formStepsNum) { progressStep.classList.add("progress-step-check"); } else { progressStep.classList.remove("progress-step-check"); } }); const progressActive=document.querySelectorAll(".progress-step-active"); progress.style.width=((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%" ; } document.getElementById("submit-form").addEventListener("click", function () { progressSteps.forEach((progressStep, idx)=> {
            if (idx <= formStepsNum) { progressStep.classList.add("progress-step-check"); } else { progressStep.classList.remove("progress-step-check"); } }); var forms=document.getElementById("form"); forms.classList.remove("form"); forms.innerHTML='<div class="welcome"><div class="content"><svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg><h2 class="mb-2" style="font-size:32px">Thanks for submitting!</h2><span> <a href="sign-up.html">Sign Up Now</a></span><div></div>' ; });


        function openModal(plan_id){


            $('#plan_id').val(plan_id);

            $('#quesModal').modal();

        }

    </script>

@endsection