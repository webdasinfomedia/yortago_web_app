<div class="custom-tab-1">
    <ul class="nav nav-tabs nav-tab_s">
        <li class="nav-item nav-item-1">
            <a class="nav-link active week-nav-link" data-toggle="tab" href="#week1"><i
                    class="la la-week mr-2"></i> Week 1</a>
        </li>
    </ul>
    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="week1" role="tabpanel">
            <input type="hidden" name="id" value="{{ $item['id'] }}"
                   id="">
            <input type="hidden" name="weeks[]" value="Week1" id="">
            <div class="pt-4">
                <div class="row">
                    @php
                        $day_names=['','One','Two','Three','Four','Five','Six','Seven'];
                    @endphp
                    @for($i=1;$i<=7;$i++)

                        <div class="col-md-12">
                            <div id="w1-day{{$i}}" class="accordion accordion-primary">
                                <div class="accordion__item">
                                    <div class="accordion__header rounded-lg collapsed "
                                         data-toggle="collapse" data-target="#week1-day-{{$i}}"
                                         aria-expanded="false">
                                                                        <span class="accordion__header--text">Day
                                                                            {{$day_names[$i]}}</span>
                                        <span class="accordion__header--indicator"></span>

                                    </div>
                                    <div id="week1-day-{{$i}}"
                                         class="accordion__body collapse {{$i==1?'show':'hide'}}"
                                         data-parent="#w1-day{{$i}}" style="">
                                        <form action="{{ route('admin.users.info.save') }}"
                                              class="myForm" method="POST">
                                            @csrf
                                            <input type="hidden" name="exercise_program_id"
                                                   value="{{$item['id']}}"/>
                                            <input type="hidden" name="user_id" value="{{$user_id}}"
                                                   id="">
                                            <input type="hidden" name="week_id" value=""
                                                   id="">
                                            <input type="hidden" name="day_id" value=""
                                                   id="">
                                            <input type="hidden" name="day_name" value="{{$i}}"
                                                   id="">
                                            <input type="hidden" name="week_name" value="week1"
                                                   id="">
                                            <input type="hidden" name="days[]" value="Week1_Day One" id="">
                                            <div class="accordion__body--text">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div style="float: right">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-sm"
                                                                    id="btn-submit"
                                                                    style="margin-right:10px "
                                                            >
                                                                                            <span
                                                                                                class="btn-icon-left text-info"><i
                                                                                                    class="fa fa-save color-info"></i></span>Save
                                                            </button>
                                                            <button type="button"
                                                                    class="btn btn-primary btn-sm"
                                                                    style="float: right"
                                                                    onclick="appendRowNewWeek('1',{{$i}},'w1-day{{$i}}')"><span
                                                                    class="btn-icon-left text-info"><i
                                                                        class="fa fa-plus color-info"></i>
                                                                                            </span>Add More</button>
                                                        </div>
                                                    </div>
                                                    <table class="table-wrapper" id="tblLocations" cellpadding="0"  border="1" style="width:100%">
                                                        <tr>
                                                            <th style="text-align: left; padding-left: 20px; width: 5.5%">No</th>
                                                            <th style="width: 14%;">Video</th>
                                                            <th style="width: 18%;">Name</th>
                                                            <th colspan="6">
                                                                Description
                                                            </th>
                                                            <th  style="text-align: right; padding-right: 20px; width: 5.5%;">Action</th>
                                                        </tr>
                                                    </table>
                                                    @php
                                                        $rand1 = uniqid();
                                                    @endphp



                                                    <div style="width: 100%">

                                                        <table cellpadding="0"
                                                               border="1"
                                                               style="width:100%;margin-top: -40px"
                                                               class="table-wrapper sort-row-w1-day{{$i}}"
                                                               id="remove{{ $rand1 }}">
                                                            <tr>
                                                                <td style="text-align: left; padding-left: 20px; width: 5.5%"
                                                                    class="w1-day{{$i}}">1
                                                                </td>
                                                                <td style="width: 14%;">
                                                                    <button type="button"
                                                                            id="btn-w-day-{{ $rand1 }}"
                                                                            onclick="openModal(`{{ $rand1 }}`,null)"
                                                                            class="btn btn-rounded btn-primary"><span
                                                                            class="btn-icon-left text-success"
                                                                            style="margin-left: 4px"><i
                                                                                class="fa fa-upload color-primary"></i>
                                                                                                        </span></button>
                                                                    <input type="hidden"
                                                                           name="info[{{$i}}][video]"
                                                                           id="video{{ $rand1 }}">
                                                                    <input type="hidden"
                                                                           name="info[{{$i}}][image]"
                                                                           id="image{{ $rand1 }}">
                                                                    <div class="about-pic">
                                                                        <img src="#"
                                                                             id="img{{ $rand1 }}"
                                                                             class="d-none"
                                                                             onclick="openModal(`{{ $rand1 }}`,null)"
                                                                             alt="img"
                                                                             style="object-fit: cover; width: auto; height: 40px; width:5px" />
                                                                        <a onclick="openModal(`{{ $rand1 }}`,null)"
                                                                           class="play-btn video-popup">
                                                                            <img src="{{ URL::to('front/img/play.png') }}"
                                                                                 class="d-none "
                                                                                 id="play-img{{ $rand1 }}"
                                                                                 alt=""
                                                                                 style="height: 30px;">
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 19%;">
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
                                                                                required
                                                                                name="info[{{$i}}][title]"
                                                                                style="width: 100%" />
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 9%;">
                                                                    <div
                                                                        class="step-forms">
                                                                        <div
                                                                            class="group-inputs">
                                                                            <label
                                                                                for="sets">Sets</label>
                                                                            <input
                                                                                type="number"
                                                                                min="0"
                                                                                required
                                                                                name="info[{{$i}}][sets]"
                                                                                id="sets" />
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 9%;">
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
                                                                                name="info[{{$i}}][reps]"

                                                                                id="reps" />
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td style="width: 9%;">
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
                                                                                name="info[{{$i}}][temp]"
                                                                                id="temp" />
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 9%;">
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
                                                                                name="info[{{$i}}][rest]"
                                                                                id="rest"
                                                                                style="padding-left: 10px!important;text-align: left;" />
                                                                            <span
                                                                                id="clearBtn1"
                                                                                class="clearBtn">secs</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 9%;">
                                                                    <div
                                                                        class="step-forms">
                                                                        <div
                                                                            class="group-inputs">
                                                                            <label
                                                                                for="intensity">Intensity</label>
                                                                            <select name="info[{{$i}}][intensity]" required class="no-selectpicker">
                                                                                <option value="Low">Low</option>
                                                                                <option value="Moderate">Moderate</option>
                                                                                <option value="High">High</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 2.5%;">
                                                                    <div class=""
                                                                         style="margin-left: 20px"
                                                                         onclick="appendTable(`{{ $rand1 }}`,`Week1_D-ONE`)">
                                                                        <svg version="1.1"
                                                                             width="20px"
                                                                             id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px"
                                                                             y="0px"
                                                                             viewBox="0 0 318.293 318.293"
                                                                             style="enable-background:new 0 0 318.293 318.293;"
                                                                             xml:space="preserve">
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                                                                    c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                                                                    h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                                                                    " />
                                                                                                                <rect
                                                                                                                    x="134.475"
                                                                                                                    y="277.996"
                                                                                                                    width="49.968"
                                                                                                                    height="40.297" />
                                                                                                            </g>


                                                                                                        </svg>
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
                                                                        <div class="dropdown-menu dropdown-menu-right"
                                                                             x-placement="bottom-end"
                                                                             style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                            <a class="dropdown-item"
                                                                               href="javascript:void(0)"
                                                                               onclick="remove(`{{ $rand1 }}`)">Remove</a>
                                                                        </div>
                                                                    </div>

                                                                </td>


                                                            </tr>
                                                        </table>
                                                        <table class="table-wrapper"
                                                               id="remove-s{{ $rand1 }}"
                                                               cellpadding="0" border="1"
                                                               style="width:100%;margin-top: -60px;display:none">


                                                            <tr>

                                                                <td style="width: 100%;">
                                                                    <div
                                                                        class="step-forms">
                                                                        <div
                                                                            class="group-inputs">
                                                                            <label
                                                                                for="sets">Description</label>
                                                                            <blade
                                                                                ___html_tags_0___ />
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        </table>
                                                        {{-- </form> --}}
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @endfor

                {{-- Day 2 --}}



                {{-- Day 3 --}}



                {{-- Day 4 --}}



                {{-- Day 5 --}}



                {{-- Day 6 --}}



                {{-- Day 7 --}}


            </div>
        </div>
    </div>

</div>
