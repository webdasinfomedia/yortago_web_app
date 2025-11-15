<div class="step-forms unsortable d-block">
    <div class="form-group"> <label for="name">Name </label> <input type="text"  name="name"  class="form-control" /> </div>
</div>
<div class="step-forms unsortable d-block">
    <div class="form-group"> <label for="email">Email </label> <input type="email"  name="email"  class="form-control" /> </div>
</div>
<div class="form-group">
    <div class="form-group"> <label for="password">Password </label> <input type="password"  name="password"  class="form-control" /> </div>
</div>
<div class="form-group">
    <div class="form-group">
        <label for="e-program">Select existed exercise program</label>
        <select name="exercise_program">
            <option value="" selected disabled>Select program</option>
            @foreach ($lists->where('title', '!=', NULL) as $item)
                <option value="{{$item['id']}}"> {{ $item['title'] }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-group">
                <label for="ages">Gender </label>
                <select name="gender_id" >
                    @if(sizeof($genders))
                    <option value="" selected disabled> select gender </option>
                    @endif
                    @forelse ($genders as $gender)
                        <option value="{{$gender['id']}}"> {{ $gender['name'] }}</option>
                    @empty
                        <small>Please add gender's first</small>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-group">
                <label for="ages">Focus </label>
                <select name="age_id" >
                    @if(sizeof($ages))
                    <option value="" selected disabled> select Focus </option>
                    @endif
                    @forelse ($ages as $age)
                        <option value="{{$age['id']}}"> {{ $age['age_range'] }}</option>
                    @empty
                        <small>Please add age's first</small>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-group">
                <label for="equipment">Equipment </label>
                <select name="equipment_id" >
                    @if(sizeof($equipment))
                    <option value="" selected disabled> select equipment </option>
                    @endif
                    @forelse ($equipment as $equip)
                        <option value="{{$equip['id']}}"> {{ $equip['name'] }}</option>
                    @empty
                        <small>Please add equipment's first</small>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-group">
                <label for="experience">Experience level </label>
                <select name="experience_id" >
                    @if(sizeof($experience_levels))
                    <option value="" selected disabled> select level </option>
                    @endif
                    @forelse ($experience_levels as $level)
                        <option value="{{$level['id']}}"> {{ $level['heading'] }}</option>
                    @empty
                        <small>Please add experiences level first</small>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="type" value="private" />

<div class="d-flex justify-content-center mt-2">
    <button type="submit" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-info"><i
        class="fa fa-plus color-info"></i>
    </span>Submit</button>
</div>
