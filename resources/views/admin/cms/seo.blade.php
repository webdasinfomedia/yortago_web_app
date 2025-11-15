@extends('admin.layouts.master')
@section('admin_title')
SEO
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">SEO</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <form method="POST" action="{{ route('admin.cms.site.config.submit') }}" enctype="multipart/form-data">
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="card-title">Home Page</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                                @csrf
                              <div class="row">
    
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Meta title</label>
                                            <input type="text" class="form-control" name="home_meta_title" value="{{ $setting['home_meta_title'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta keywords</label>
                                            <input type="text" class="form-control" name="home_meta_keywords" value="{{ $setting['home_meta_keywords'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta description</label>
                                            <textarea class="form-control" rows="3" name="home_meta_description">{{ $setting['home_meta_description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="card-title">About Page</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                                @csrf
                              <div class="row">
    
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Meta title</label>
                                            <input type="text" class="form-control" name="about_meta_title" value="{{ $setting['about_meta_title'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta keywords</label>
                                            <input type="text" class="form-control" name="about_meta_keywords" value="{{ $setting['about_meta_keywords'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta description</label>
                                            <textarea class="form-control" rows="3" name="about_meta_description">{{ $setting['about_meta_description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="card-title">Online training Page</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                                @csrf
                              <div class="row">
    
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Meta title</label>
                                            <input type="text" class="form-control" name="online_training_meta_title" value="{{ $setting['online_training_meta_title'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta keywords</label>
                                            <input type="text" class="form-control" name="online_training_meta_keywords" value="{{ $setting['online_training_meta_keywords'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta description</label>
                                            <textarea class="form-control" rows="3" name="online_training_meta_description">{{ $setting['online_training_meta_description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="card-title">In-person Page</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                                @csrf
                            <div class="row">
    
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Meta title</label>
                                            <input type="text" class="form-control" name="inperson_meta_title" value="{{ $setting['inperson_meta_title'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta keywords</label>
                                            <input type="text" class="form-control" name="inperson_meta_keywords" value="{{ $setting['inperson_meta_keywords'] ?? ''  }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Meta description</label>
                                            <textarea class="form-control" rows="3" name="inperson_meta_description">{{ $setting['inperson_meta_description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection