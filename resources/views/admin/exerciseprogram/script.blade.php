<script>
    var iteration_no = `{{ $item['exercise_infos']!=null ? count($item['exercise_infos']) :0 }}`;
    var no = 0;
</script>
<script>
    function updateTitle()
    {
        if($('#program-title').val() == '')
        {
            toastr.error('Enter valid title');
            return false
        }
        $.ajax({
            url: "{{ route('admin.exercise.program.update-title') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                title: $('#program-title').val(),
                id: "{{$item['id']}}"
            },
            success: function(){
                toastr.success('Title updated');
            },
            error: function(){
                toastr.error('Error while updating title');
            }
        })
    }
    $(document).ready(function() {

        var programs = [];
        // Basic
        $('.dropify').dropify();



        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    
    $('#youtube-link').change(function(){
        var url = $(this).val();
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11)
        {
            $(`#video${no}`).val(url);
            $('#youtube-preview').html(`<iframe src='https://www.youtube.com/embed/${match[2]}' width="100%" height="300px"></iframe>`);
        }
        else
        {
            toastr.error('Add a valid Youtube link');
            $('#youtube-preview').html('');
            $(this).val('');
            $(`#video${no}`).val('');
        }
    })

    function openModal(id, value) {
        $('#basicModal').modal();
        no = id;
        
        if(value){
            $('#youtube-link').val(value).change();
        }
    }

    function remove(id) {
        console.log(id);
        $(`#remove${id}`).remove();
        $(`#remove-s${id}`).remove();
    }

    function appendTable(key, d) {
        console.log(key, d);
        if ($(`#remove-s${key}`).length > 0) {
            if ($(`#remove-s${key}`).is(":visible")) {
                $(`#remove-s${key}`).hide();
            } else {
                $(`#remove-s${key}`).show();
            }
        } else {
            let phtml = ` <table class="table-wrapper" id="remove-s${key}"  cellpadding="0"  border="1" style="width:100%;margin-top: -60px" >
                <tr>
                    <td style="width: 100%;"> <div class="step-forms">
                        <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text" required name="description_${d}[${key}][]" style="width: 100%;padding:12px" ></textarea> </div>
                    </div></td>
                </tr>
                </table>`;
            $(`#remove${key}`).after(phtml);
        }
    }

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() *
                charactersLength));
        }
        return result;
    }

    function appendRow(weekId, dayId, week_class) {

        let no=parseInt($(`.${week_class}` ).last().text())+1;
        if(isNaN(no)){
            no=1;
        }


        let rowCount = $('table#tblLocations tr:last').index() + 1;
        console.log(rowCount)
        let randomNo = makeid(10);
        let html = exerciseNewRow(weekId, dayId, no, randomNo,week_class);
        $(".sort-row-d" + dayId).append(html);
        console.log(".sort-row-d" + dayId)
    }

    function exerciseNewRow(id, d, no, randomNo,week_class) {
        return `   <tr class="sort-row-1 unsortable" data-property='new' id="remove${no}">
                                <td style="text-align: left; padding-left: 20px; width: 5.5%" class="${week_class}">${no}</td>
                                <td style="width: 14%;"><button type="button" id="btn${randomNo}" onclick="openModal('${randomNo}',null)" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                </span></button> <input type="hidden" name="info[${no}][video]" id="video${randomNo}"> <input type="hidden" name="info[${no}][image]" id="image${randomNo}">
                                <div class="about-pic">
                                    <img src="#" id="img${randomNo}"   class="d-none" onclick="openModal(${randomNo},null)" alt="img" style="object-fit: cover; width: auto; height: 48px;width:5px"/>
                                    <a onclick="openModal('${randomNo}',null)" class="play-btn video-popup">
                                        <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo}" alt="" style="height: 30px;">
                                </a>
                                    </div>
                                    </td>
                                <td style="width: 19%;"> <div class="step-forms unsortable">
                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text" required name="info[${no}][title]"  style="width: 100%" /> </div>
                                </div></td>
                                <td style="width: 9%;">
                                    <div class="step-forms unsortable">
                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0" required name="info[${no}][sets]" id="sets" /> </div>
                                    </div>
                                </td>
                                <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0" required name="info[${no}][reps]" id="reps" id="reps" /> </div>
                                    </div>
                                </td>

                                <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0" required name="info[${no}][temp]" id="temp" /> </div>
                                    </div>
                                </td>
                                <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0" required name="info[${no}][rest]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                    </div>
                                </td>
                                <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="intensity">Intensity</label> 
                                        <select name="info[${no}][intensity]" required class="no-selectpicker">
                                            <option value="Low">Low</option>
                                            <option value="Moderate">Moderate</option>
                                            <option value="High">High</option>
                                        </select>
                                        
                                        
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable('${randomNo}','${d}')">
                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                <g>
                                    <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                        c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                        h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                        "/>
                                    <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                </g>
                                <g>
                                    </svg>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table${randomNo}"><div class="dropdown ml-auto text-right">
                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="javascript:void(0)"  onclick="remove(${no})">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </td>


                        </tr>
                        <tr id="remove-s${no}">
                            <td style="width: 100%;" colspan="8"> <div class="step-forms">
                                <div class="group-inputs"> <label for="sets">Description</label> <textarea type="text" name="info[${no}][description]" style="width: 100%;padding:12px" ></textarea> </div>
                            </td>
                            <td style="width: 100%;">
                                <div
                                    class="step-forms">
                                    <div
                                        class="group-inputs">
                                        <label
                                            for="weight_required">Weight required</label>
                                        <select name="info[${no}][weight_required]" required class="no-selectpicker" style="min-width: 150px">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
        `;
    }
</script>


<script>
    var lastWeek = @json(count($item['exercise_weeks']));
    if (lastWeek == 0) {
        lastWeek += 1;
    }

    function addWeek() {
        let randomNo = makeid(10);

        const days = [
            {
                'key': 1,
                'value': 'Day One',
                'uid': makeid(10)
            },
            {
                'key': 2,
                'value': 'Day Two',
                'uid': makeid(10)
            },
            {
                'key': 3,
                'value': 'Day Three',
                'uid': makeid(10)
            },
            {
                'key': 4,
                'value': 'Day Four',
                'uid': makeid(10)
            },
            {
                'key': 5,
                'value': 'Day Five',
                'uid': makeid(10)
            },
            {
                'key': 6,
                'value': 'Day Six',
                'uid': makeid(10)
            },
            {
                'key': 7,
                'value': 'Day Seven',
                'uid': makeid(10)
            },
        ];
        var new_week_id;
        $.ajax({
            url: "{{route('admin.exercise.program.info.save')}}",
            method: 'POST',
            data: {
                '_token': "{{csrf_token()}}",
                'exercise_program_id': "{{$item['id']}}",
                'week_name': 'week ' + (lastWeek + 1)
            },
            success: function (data) {
                new_week_id=data.week_id;
                $('#week_disabled').attr('data-week_id', new_week_id);
                $('#delete-week').attr('data-week_id', new_week_id);
                let phtml = ` <div class="tab-pane fade" id="week${lastWeek+1}" role="tabpanel">
                                <div class="pt-4">
                                    <div class="row">`;
                                    
                for (let i = 0; i < days.length; i++) {
                    let randomNoDay=Math.floor((Math.random() * 100) + 1);
                    phtml += `
            <div class="col-md-12">
                <div id="w${lastWeek+1}-day${days[i].key}" class="accordion accordion-primary">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed " data-toggle="collapse" data-target="#week${lastWeek+1}-day-${days[i].key}" aria-expanded="false">
                            <span class="accordion__header--text">${days[i].value}</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="week${lastWeek+1}-day-${days[i].key}" class="accordion__body collapse ${i===0 ? 'show' : 'hide'}" data-parent="#w${lastWeek+1}-day${days[i].key}" style="">
                           <form action="{{ route('admin.exercise.program.info.save') }}"
                              class="myForm" method="POST">
                            @csrf
                                <input type="hidden" name="exercise_program_id" value="{{$item['id']}}"/>
                                <input type="hidden" name="week_id" value="${new_week_id}">
                                <input type="hidden" name="day_id" value="" >
                                <input type="hidden" name="day_name" value="${days[i].key}" >
                                <input type="hidden" name="week_name" value="week${lastWeek+1}" id="">
                                <input type="hidden" name="days[]" value="Week${lastWeek+1}_${days[i].value.toUpperCase()}" id="">
                                <div class="accordion__body--text">
                                    <div class="row">
                                        <div class="col-md-12" >
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
                                                    onclick="appendRow(${lastWeek+1},'${days[i].uid}','w${lastWeek+1}-day${days[i].key}')"><span
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
                                                class="sort-row-d${days[i].uid}">
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>`;
                }

                phtml += `</div>
                </div>
            </div>`;

                let html = ` <li class="nav-item nav-item-${lastWeek+1}">
                <a class="nav-link" data-toggle="tab" href="#week${lastWeek+1}"><i class="la la-week mr-2"></i> Week ${lastWeek+1}</a>
            </li> `;
                $('.nav-tab_s').append(html);
                $('#tab-content').append(phtml);

                var parent_week_div=$(`#week${lastWeek+1}`);
                lastWeek += 1;
                let increament=1;
                parent_week_div.find('input[name=day_id]').each(function (index,value){

                    if($(this).val().length==0){
                        console.log( increament);
                        $(this).val(data.day_id[increament]);
                        increament++;
                    }
                });
            }
        });


    }
    function appendRowNewWeek(id,d,week){
        let no=parseInt($(`.${week}` ).last().text())+1;
        if(isNaN(no)){
            no=1;
        }

        let randomNo=Math.floor((Math.random() * 100) + 1);

        let html=`   <div class="sort-row-1 unsortable">  <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo}"><tr >
                            <td style="text-align: left; padding-left: 20px; width: 5.5%" class="${week}">${no}</td>
                           <td style="width: 14%;"><button type="button" id="btn${randomNo}" onclick="openModal('${randomNo}',null)" class="btn btn-rounded btn-primary" ><span class="btn-icon-left text-success" style="margin-left: 4px"><i class="fa fa-upload color-primary"></i>
                                </span></button> <input type="hidden" name="info[${no}][video]" id="video${randomNo}"> <input type="hidden" name="info[${no}][image]" id="image${randomNo}">
                                <div class="about-pic">
                                    <img src="#" id="img${randomNo}"   class="d-none" onclick="openModal(${randomNo},null)" alt="img" style="object-fit: cover; width: auto; height: 48px;width:5px"/>
                                    <a onclick="openModal('${randomNo}',null)" class="play-btn video-popup">
                                        <img src="{{ URL::to('front/img/play.png') }}" class="d-none " id="play-img${randomNo}" alt="" style="height: 30px;">
                                </a>
                                    </div>
                                    </td>
                            <td style="width: 19%;"> <div class="step-forms unsortable">
                                    <div class="group-inputs"> <label for="sets">Exercise Name </label> <input type="text" required name="info[${no}][title]"  style="width: 100%" /> </div>
                                </div></td>
                            <td style="width: 9%;">
                                    <div class="step-forms unsortable">
                                        <div class="group-inputs"> <label for="sets">Sets</label> <input type="number" min="0" required name="info[${no}][sets]" id="sets" /> </div>
                                    </div>
                                </td>
                            <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="reps">Reps</label> <input type="number" min="0" required name="info[${no}][reps]" id="reps" id="reps" /> </div>
                                    </div>
                                </td>

                             <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="tempo">Tempo</label> <input type="text" min="0" required name="info[${no}][temp]" id="temp" /> </div>
                                    </div>
                                </td>
                            <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="rest">Rest</label> <input type="number" min="0" required name="info[${no}][rest]" id="rest" style="padding-left: 10px!important;text-align: left;" /> <span id="clearBtn1" class="clearBtn">secs</span> </div>
                                    </div>
                                </td>
                             <td style="width: 9%;">
                                    <div class="step-forms">
                                        <div class="group-inputs"> <label for="intensity">Intensity</label> 
                                        <select name="info[${no}][intensity]" required class="no-selectpicker">
                                            <option value="Low">Low</option>
                                            <option value="Moderate">Moderate</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                </td>
                             <td style="width: 2.5%;"><div class="" style="margin-left: 20px" onclick="appendTable('${randomNo}','${no}')">
                                    <svg version="1.1" width="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 318.293 318.293" style="enable-background:new 0 0 318.293 318.293;" xml:space="preserve">
                                <g>
                                    <path d="M159.148,0c-52.696,0-95.544,39.326-95.544,87.662h47.736c0-22.007,21.438-39.927,47.808-39.927
                                        c26.367,0,47.804,17.92,47.804,39.927v6.929c0,23.39-10.292,34.31-25.915,50.813c-20.371,21.531-45.744,48.365-45.744,105.899
                                        h47.745c0-38.524,15.144-54.568,32.692-73.12c17.368-18.347,38.96-41.192,38.96-83.592v-6.929C254.689,39.326,211.845,0,159.148,0z
                                        "/>
                                    <rect x="134.475" y="277.996" width="49.968" height="40.297"/>
                                </g>
                                <g>
                                    </svg>
                                        </div>
                                    </div>
                                </td>
                             <td style="text-align: right; padding-right: 30px; width: 2%;" id="append-table${randomNo}"><div class="dropdown ml-auto text-right">
                                    <div class="btn-link" data-toggle="dropdown" aria-expanded="false">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-114px, 24px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="javascript:void(0)"  onclick="remove(${no})">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </td>


                    </tr>
                </table>
            </div>`;

        console.log(html);

        $(".sort-row-"+week).append(html);


    }
</script>

<script>
    $(document).on('submit','.myForm',function(e) {
        e.preventDefault();
        // Get all the forms elements and their values in one step
        var values = $(this).serialize();
        var parent_week_div=$(this).closest('.tab-content');


        let html =
            ` <span class="btn-icon-left text-info"><i class="fa fa-spinner fa-spin color-info"></i></span>Saving ....`;
        $('#btn-submit').html(html);

        $.ajax({
            type: "POST",
            url: `{{ route('admin.exercise.program.info.save') }}`,
            data: values, // serializes the form's elements.
            success: function(data) {
                if (data.success === true) {
                    parent_week_div.find('input[name=week_id]').each(function (index,value){
                        if($(this).val().length==0){
                            $(this).val(data.week_id);
                        }
                    });
                    let increament=1;
                    parent_week_div.find('input[name=day_id]').each(function (index,value){

                        if($(this).val().length==0){
                            console.log( increament);
                            $(this).val(data.day_id[increament]);
                            increament++;
                        }
                    });
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
                let html2 =
                    `  <span class="btn-icon-left text-info"><i class="fa fa-save color-info"></i></span>Save`;

                $('#btn-submit').html(html2);
            }
        });

    });
</script>
