<script>
    function appendRowNewWeek(id,d){
        let no=parseInt($(`.${id}` ).last().text())+1;
        if(isNaN(no)){
            no=1;
        }

        let randomNo=Math.floor((Math.random() * 100) + 1);

        let html=`   <div class="sort-row-1 unsortable">  <table class="table-wrapper" cellpadding="0"  border="1" style="width:100%;margin-top: -40px" id="remove${randomNo}"><tr >
                            <td style="text-align: left; padding-left: 20px; width: 5.5%" class="${id}">${no}</td>
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
                                        <div class="group-inputs"> <label for="intensity">Intensity</label> <input type="text" required name="info[${no}][intensity]" id="intensity"/> </div>
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


                    </tr></table></div>`;

        console.log(html);

        $(".sort-row-"+id).append(html);


    }
</script>
