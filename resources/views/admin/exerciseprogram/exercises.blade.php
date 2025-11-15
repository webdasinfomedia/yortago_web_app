<div class="custom-tab-1">
    <div class="float-md-right">
        <a href="javascript:void 0" data-week_id="{{$item['exercise_weeks'][0]->id}}" id="delete-week" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i>  </a>
        <input type="checkbox" id="week_disabled" data-week_id="{{$item['exercise_weeks'][0]->id}}" data-toggle="toggle" data-on="Enabled" data-off="Disabled" {{isset($item['exercise_weeks']) && $item['exercise_weeks'][0]->status==1 ?'checked':'' }}>
    </div>
    <ul class="nav nav-tabs nav-tab_s">
        @foreach ($item['exercise_weeks'] as $pkey => $week)
            <li class="nav-item nav-item-1">
                <a @if ($pkey == 0) class="nav-link week-nav-link active" @else class="nav-link week-nav-link" @endif
                data-toggle="tab" data-week_id="{{$week->id}}" data-status="{{$week->status}}" href="#week{{ $loop->iteration }}"><i
                        class="la la-week mr-2"></i>
                    {{'Week '. $loop->iteration }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="tab-content">
        @foreach ($item['exercise_weeks'] as $rkey => $week)
            <div @if ($rkey == 0) class="tab-pane fade show active" @else class="tab-pane fade" @endif
            id="week{{ $loop->iteration }}" role="tabpanel">
                <input type="hidden" name="id" value="{{ $item['id'] }}"
                       id="">
                <input type="hidden" name="weeks[]"
                       value="{{ $week['week_name'] }}" id="">
                <div class="pt-4">
                    <div class="row">
                        @foreach ($week['exercise_days'] as $key => $day)
                            <div class="col-md-12">
                                <div id="w{{ $week['id'] }}-day{{ $day['id'] + 100 }}"
                                     class="accordion accordion-primary">
                                    <div class="accordion__item">
                                        <div class="accordion__header rounded-lg collapsed "
                                             data-toggle="collapse"
                                             data-target="#week{{ $week['id'] }}-day-{{ $day['id'] + 100 }}"
                                             aria-expanded="false">
                                            <span
                                                class="accordion__header--text">{{ ucwords(strtolower($day['day_name'])) }}</span>
                                            <span class="accordion__header--indicator"></span>
                                        </div>
                                        <div id="week{{ $week['id'] }}-day-{{ $day['id'] + 100 }}"
                                             class="accordion__body collapse "
                                             data-parent="#w{{ $week['id'] }}-day{{ $day['id'] + 100 }}"
                                             style="">
                                            <form action="{{ route('admin.exercise.program.info.save') }}"
                                                  class="myForm" method="POST">
                                                @csrf
                                                <input type="hidden" name="exercise_program_id"
                                                       value="{{$item['id']}}"/>
                                                <input type="hidden" name="week_id" value="{{ $week['id'] }}"
                                                       id="{{ $week['id'] }}">
                                                <input type="hidden" name="week_name" value="{{ 'Week '. $loop->iteration }}"
                                                       id="{{ $week['name'] }}">
                                                <input type="hidden" name="day_id" value="{{ $day['id'] }}"
                                                       id="{{ $day['id'] }}">
                                                <input type="hidden" name="day_name" value="{{ $day['day_name'] }}"
                                                       id="{{ $day['day_name'] }}">
                                                <div class="accordion__body--text">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div style="float: right">
                                                                <button type="submit"
                                                                        class="btn btn-primary btn-sm"
                                                                        id="btn-submit"
                                                                        style="margin-right:10px"
                                                                >
                                                                <span
                                                                    class="btn-icon-left text-info"><i
                                                                        class="fa fa-save color-info"></i></span>Save
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-primary btn-sm"
                                                                        style="float: right"
                                                                        onclick="appendRow('{{ $week['id'] }}','{{ $day['id'] }}','w{{ $week['id'] }}-day{{ $day['id']  }}')"><span
                                                                        class="btn-icon-left text-info"><i
                                                                            class="fa fa-plus color-info"></i>
                                                                </span>Add More
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <table class="table-wrapper"
                                                               id="tblLocations"
                                                               cellpadding="0"
                                                               border="1"
                                                               style="width:100%">
                                                            <tbody
                                                                class="sort-row-d{{ $day['id'] }}">

                                                            <tr>
                                                                <th
                                                                    style="text-align: left; padding-left: 20px; width: 5.5%">
                                                                    No
                                                                </th>
                                                                <th
                                                                    style="width: 14%;">
                                                                    Video
                                                                </th>
                                                                <th
                                                                    style="width: 18%;">
                                                                    Name
                                                                </th>
                                                                <th colspan="6">
                                                                    Description
                                                                </th>
                                                                <th
                                                                    style="text-align: right; padding-right: 20px; width: 5.5%;">
                                                                    Action
                                                                </th>
                                                            </tr>

                                                            @forelse ($day['exercise_infos'] as $key1 => $exercise_info)
                                                                <input type="hidden" name="info[][id]"
                                                                       value="{{$exercise_info['id']}}"/>
                                                                @php
                                                                    $rand1 = uniqid();
                                                                @endphp

                                                                <tr class="sort-row-{{$key1+1}} unsortable"
                                                                    id="remove{{ $exercise_info['id'] }}">

                                                                    <td style="text-align: left; padding-left: 20px; width: 5.5%"
                                                                        class="w{{ $week['id'] }}-day{{ $day['id']  }}">
                                                                        {{ $key1 + 1 }}
                                                                    </td>
                                                                    <td style="width: 14%;">
                                                                        @if ($exercise_info['image_path'] == null && $exercise_info['video_path'] == null)
                                                                            <button
                                                                                type="button"
                                                                                id="btn-w-day-{{ $rand1 }}"
                                                                                onclick="openModal(`{{ $rand1 }}`,null)"
                                                                                class="btn btn-rounded btn-primary"><span
                                                                                    class="btn-icon-left text-success"
                                                                                    style="margin-left: 4px"><i
                                                                                        class="fa fa-upload color-primary"></i>
                                                                                    </span>
                                                                            </button>
                                                                        @endif
                                                                        <input
                                                                            type="hidden"
                                                                            value="{{ $exercise_info['video_path'] }}"
                                                                            name="info[{{$key1}}][video]"
                                                                            id="video{{ $rand1 }}">
                                                                        <input
                                                                            type="hidden"
                                                                            value="{{ $exercise_info['image_path'] }}"
                                                                            name="info[{{$key1}}][image]"
                                                                            id="image{{ $rand1 }}">
                                                                        <div
                                                                            class="about-pic">
                                                                            @if ($exercise_info['image_path'] != null)
                                                                                <img
                                                                                    src="{{ URL::to($exercise_info['image_path']) }}"
                                                                                    id="img{{ $rand1 }}"
                                                                                    onclick="openModal(`{{ $rand1 }}`,{{ $exercise_info['image_path'] }})"
                                                                                    alt="img"
                                                                                    style="object-fit: cover; width: auto; height: 40px; width:5px"/>
                                                                                <a onclick="openModal(`{{ $rand1 }}`,null)"
                                                                                   class="play-btn video-popup">
                                                                                    <img
                                                                                        src="{{ URL::to('front/img/play.png') }}"
                                                                                        id="play-img{{ $rand1 }}"
                                                                                        alt=""
                                                                                        style="height: 30px;">
                                                                                </a>
                                                                            @elseif($exercise_info['video_path'] != null)
                                                                                <a onclick="openModal(`{{ $rand1 }}`,`{{ $exercise_info['video_path'] }}`)"
                                                                                   class="play-btn video-popup">
                                                                                    <img
                                                                                        src="{{ URL::to('front/img/play.png') }}"
                                                                                        id="play-img{{ $rand1 }}"
                                                                                        class=""
                                                                                        alt=""
                                                                                        style="height: 30px;object-fit: contain;width: 30px;cursor: pointer">
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        style="width: 19%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="sets">Exercise
                                                                                    Name
                                                                                </label>
                                                                                <input
                                                                                    type="text"
                                                                                    value="{{ $exercise_info['title'] }}"
                                                                                    required
                                                                                    name="info[{{$key1}}][title]"
                                                                                    style="width: 100%"/>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        style="width: 9%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="sets">Sets</label>
                                                                                <input
                                                                                    type="number"
                                                                                    min="0"
                                                                                    value="{{ $exercise_info['sets'] }}"
                                                                                    required
                                                                                    name="info[{{$key1}}][sets]"
                                                                                    id="sets"/>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        style="width: 9%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="reps">Reps</label>
                                                                                <input
                                                                                    type="number"
                                                                                    min="0"
                                                                                    required
                                                                                    value="{{ $exercise_info['reps'] }}"
                                                                                    name="info[{{$key1}}][reps]"
                                                                                    id="reps"
                                                                                    id="reps"/>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td
                                                                        style="width: 9%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="tempo">Tempo</label>
                                                                                <input
                                                                                    type="text"
                                                                                    min="0"
                                                                                    required
                                                                                    value="{{ $exercise_info['temps'] }}"
                                                                                    name="info[{{$key1}}][temp]"
                                                                                    id="temp"/>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        style="width: 9%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="rest">Rest</label>
                                                                                <input
                                                                                    type="number"
                                                                                    min="0"
                                                                                    required
                                                                                    value="{{ $exercise_info['rest'] }}"
                                                                                    name="info[{{$key1}}][rest]"
                                                                                    id="rest"
                                                                                    style="padding-left: 10px!important;text-align: left;"/>
                                                                                <span
                                                                                    id="clearBtn1"
                                                                                    class="clearBtn">secs</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        style="width: 9%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="intensity">Intensity</label>
                                                                                <select name="info[{{$key1}}][intensity]" required class="no-selectpicker">
                                                                                    <option {{ $exercise_info['intensity'] == 'Low' ? 'selected' : '' }} value="Low">Low</option>
                                                                                    <option {{ $exercise_info['intensity'] == 'Moderate' ? 'selected' : '' }} value="Moderate">Moderate</option>
                                                                                    <option {{ $exercise_info['intensity'] == 'High' ? 'selected' : '' }} value="High">High</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="text-align: right; padding-right: 30px; width: 2%;"
                                                                        id="append-table0">
                                                                        <div
                                                                            class="dropdown ml-auto text-right">
                                                                            <div class="btn-link"
                                                                                 data-toggle="dropdown"
                                                                                 aria-expanded="false">
                                                                                <svg width="24px"
                                                                                     height="24px"
                                                                                     viewBox="0 0 24 24"
                                                                                     version="1.1">
                                                                                    <g stroke="none"
                                                                                       stroke-width="1"
                                                                                       fill="none"
                                                                                       fill-rule="evenodd">
                                                                                        <rect
                                                                                            x="0"
                                                                                            y="0"
                                                                                            width="24"
                                                                                            height="24">
                                                                                        </rect>
                                                                                        <circle
                                                                                            fill="#000000"
                                                                                            cx="5"
                                                                                            cy="12"
                                                                                            r="2">
                                                                                        </circle>
                                                                                        <circle
                                                                                            fill="#000000"
                                                                                            cx="12"
                                                                                            cy="12"
                                                                                            r="2">
                                                                                        </circle>
                                                                                        <circle
                                                                                            fill="#000000"
                                                                                            cx="19"
                                                                                            cy="12"
                                                                                            r="2">
                                                                                        </circle>
                                                                                    </g>
                                                                                </svg>
                                                                            </div>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right"
                                                                                x-placement="bottom-end"
                                                                                style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                <a class="dropdown-item"
                                                                                   href="javascript:void(0)"
                                                                                   onclick="remove(`{{ $exercise_info['id'] }}`)">Remove</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr id="remove-s{{ $exercise_info['id'] }}">
                                                                    <td style="width: 100%;" colspan="7"> <div class="step-forms">
                                                                        <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text" name="info[{{ $key1 }}][description]" style="width: 100%;padding:12px" >{{ $exercise_info['description'] }}</textarea> </div>
                                                                    </td>
                                                                    <td style="width: 100%;">
                                                                        <div
                                                                            class="step-forms">
                                                                            <div
                                                                                class="group-inputs">
                                                                                <label
                                                                                    for="weight_required">Weight required</label>
                                                                                <select name="info[{{$key1}}][weight_required]" required class="no-selectpicker" style="min-width: 150px">
                                                                                    <option {{ $exercise_info['weight_required'] == 0 ? 'selected' : '' }} value="0">No</option>
                                                                                    <option {{ $exercise_info['weight_required'] == 1 ? 'selected' : '' }} value="1">Yes</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty

                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
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
