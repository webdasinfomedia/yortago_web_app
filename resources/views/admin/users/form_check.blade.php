@extends('admin.layouts.master')
@section('admin_title')
    {{$title}}
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('front/dashboard/dist/css/dropify.min.css') }}">
    <style>
        .thumbnail-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #ddd;
            height: 150px; /* Fixed height for thumbnails */
            width: 100%; /* Full width */
            background-color: #f9f9f9;
            margin-bottom: 15px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }

        .thumbnail-wrapper canvas {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            display: block;
        }

        .no-video-message {
            font-size: 14px;
            color: #999;
            position: absolute;
            text-align: center;
        }

        /* Modal Styling */
        .modal-dialog {
            max-width: 600px; /* Set max width for modal */
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-body {
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #modalVideo {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            max-height: 300px; /* Strict maximum height */
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.live-stream.users.list') }}">Users</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
            </ol>
        </div>

        <div class="row">
            @foreach($form_check as $form)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{$form->created_at}}</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('admin.save_form_check')}}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Video</label>
                                        <input 
                                            type="file" 
                                            name="video" 
                                            class="form-control dropify video-input" 
                                            accept="video/*" 
                                            data-id="{{$form->id}}" 
                                            data-default-file="{{ $form?->file ? URL::to($form?->file) : '' }}" 
                                            style="display: none;"
                                        >
                                        <div class="thumbnail-wrapper" data-id="{{$form->id}}" data-video-url="{{ $form?->file ? URL::to($form?->file) : '' }}">
                                            <p class="no-video-message" data-id="{{$form->id}}">No video available</p>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="{{$form->id}}">
                                <input type="hidden" name="user_id" value="{{request()->id}}">
                                <div class="form-group">
                                    <label>Reply</label>
                                    <textarea class="form-control" rows="4" required name="reply">{{$form->reply}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                <a href="{{route('admin.live-stream.users.list')}}" class="btn btn-sm btn-secondary">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="modalVideo" controls>
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::to('front/dashboard/dist/js/dropify.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.video-input').each(function () {
                const input = $(this);
                const id = input.data('id');
                const thumbnailWrapper = $(`.thumbnail-wrapper[data-id="${id}"]`);
                const noVideoMessage = $(`.no-video-message[data-id="${id}"]`);
                const defaultFilePath = input.attr('data-default-file');

                function generateThumbnail(videoSrc) {
                    const video = document.createElement('video');
                    video.src = videoSrc;
                    video.muted = true;
                    video.playsInline = true;
                    video.currentTime = 1;

                    video.addEventListener('loadeddata', function () {
                        const canvas = document.createElement('canvas');
                        canvas.width = thumbnailWrapper.width();
                        canvas.height = thumbnailWrapper.height();
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        noVideoMessage.hide();
                        thumbnailWrapper.empty().append(canvas);
                    });

                    video.addEventListener('error', function () {
                        noVideoMessage.show();
                        console.error(`Error loading video for ID: ${id}`);
                    });
                }

                if (defaultFilePath) {
                    generateThumbnail(defaultFilePath);
                } else {
                    noVideoMessage.show();
                }

                input.on('change', function (event) {
                    const file = event.target.files[0];
                    if (file && file.type.startsWith('video/')) {
                        generateThumbnail(URL.createObjectURL(file));
                        thumbnailWrapper.attr('data-video-url', URL.createObjectURL(file));
                    }
                });
            });

            // Handle thumbnail click to open video modal
            $('.thumbnail-wrapper').on('click', function () {
                const videoUrl = $(this).attr('data-video-url');
                if (videoUrl) {
                    $('#modalVideo source').attr('src', videoUrl);
                    $('#modalVideo')[0].load();
                    $('#videoModal').modal('show');
                }
            });

            // Stop video when modal is closed
            $('#videoModal').on('hidden.bs.modal', function () {
                $('#modalVideo')[0].pause();
            });
        });
    </script>
@endsection
