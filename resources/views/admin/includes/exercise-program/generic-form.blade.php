<div class="progressbar">
    <div class="progress" id="progress"></div>
    <div class="progress-step progress-step-active"></div>
    <div class="progress-step"></div>
    <div class="progress-step"></div>
    <div class="progress-step"></div>
    <div class="progress-step"></div>
</div>
<div class="step-forms step-forms-active mt-2">
    <h6 class="mb-3" style="font-weight: 700;">Enter title:</h6>
    <div class="form-group mt-2">
        <input class="form-control" type="text" name="title" style="border: 2px solid #aaa" />
    </div>
    <div class="btns-group"> <a href="#"
            class="btn btn-rounded btn-primary modal-link btn-next"
            style="padding: 5px;">Next</a> </div>
</div>
<div class="step-forms mt-2">
    <h6 class="mb-3" style="font-weight: 700;">Select your gender:</h6>

    @foreach ($genders as $g => $gender)
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="gender_id"
                id="exampleRadios2" @if ($g == 0) checked @endif
                value="{{ $gender['id'] }}" style="width: auto">
            <label class="form-check-label" for="exampleRadios2">
                {{ $gender['name'] }}
            </label>
        </div>
    @endforeach


    <div class="btns-group"> 
    <a href="#"
            class="btn btn-rounded btn-primary btn-prev "
            style="padding: 5px;">Previous</a>
    <a href="#"
            class="btn btn-rounded btn-primary modal-link btn-next"
            style="padding: 5px;">Next</a> </div>
</div>
<div class="step-forms">
    <h6 class="mb-3" style="font-weight: 700;">Focus On:</h6>

    @foreach ($ages as $ag => $age)
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="age_id"
                id="exampleRadios2" @if ($ag == 0) checked @endif
                value="{{ $age['id'] }}" style="width: auto">
            <label class="form-check-label" for="exampleRadios2">
                {{ $age['age_range'] }}
            </label>
        </div>
    @endforeach



    <div class="btns-group"><a href="#"
            class="btn btn-rounded btn-primary btn-prev "
            style="padding: 5px;">Previous</a> <a href="#"
            class="btn btn-rounded btn-primary modal-link btn-next"
            style="padding: 5px;">Next</a> </div>
</div>
<div class="step-forms">
    <h6 class="mb-3" style="font-weight: 700;">What equipment do you have access?:</h6>

    @foreach ($equipment as $exp => $experience_level)
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="equipment_id"
                id="exampleRadios2" @if ($exp == 0) checked @endif
                value="{{ $experience_level['id'] }}" style="width: auto">
            <label class="form-check-label" for="exampleRadios2">
                {{ $experience_level['name'] }}
            </label>
        </div>
    @endforeach


    <div class="btns-group"><a href="#"
            class="btn btn-rounded btn-primary btn-prev "
            style="padding: 5px;">Previous</a> <a href="#"
            class="btn btn-rounded btn-primary modal-link btn-next"
            style="padding: 5px;">Next</a> </div>
</div>
<div class="step-forms">
    <h6 class="mb-3" style="font-weight: 700;">Select your experience level:</h6>

    @foreach ($experience_levels as $exp => $experience_level)
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="experience_id"
                id="exampleRadios2" @if ($exp == 0) checked @endif
                value="{{ $experience_level['id'] }}" style="width: auto">
            <label class="form-check-label" for="exampleRadios2">
                {{ $experience_level['heading'] }} -
                {{ $experience_level['sub_heading'] }}
            </label>
        </div>
    @endforeach


    <div class="btns-group"> <a href="#"
            class="btn btn-rounded btn-primary btn-prev"
            style="padding: 5px;">Previous</a>
        <input type="submit"
            style=" padding: 5px;width: 90px; height: 40px; line-height: 5px; text-align: center;"
            value="Submit" class="btn btn-rounded btn-primary primary-btn membership-btn">
    </div>
</div>
