<div class="modal fade" id="basicModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>Upload Video From Youtube</b></h3>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Paste youtube link here</label>
                    <input type="text" class="form-control" placeholder="Youtube URL" id="youtube-link" />
                </div>
                <div id="youtube-preview"></div>
                <button class="btn btn-success" data-dismiss="modal">Save</button>
                
                
                <ul class="nav nav-tabs d-none" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                            role="tab" aria-controls="home" aria-selected="true">Video Upload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Thumbnail Upload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab-1" data-toggle="tab" href="#profile-1"
                            role="tab" aria-controls="profile" aria-selected="false">Video</a>
                    </li>

                </ul>
                <div class="tab-content d-none" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div id="drag-drop-area"></div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div id="drag-drop-area-2"></div>
                    </div>
                    <div class="tab-pane fade" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">

                        <video controls src="#" class="w-100" id="video-path"
                            style="border-radius:10%;min-height:100%;margin-top:10px ">
                        </video>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
