@extends('admin.layouts.master')
@section('admin_title')
    Exercise Management
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .nav-tabs .nav-link {
            color: #495057;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
            color: #0056b3;
        }
        .btn-primary{
            border: none !important;
        }
        
        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 600;
        }
        
        .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 0 0 0.375rem 0.375rem;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .btn-group-custom {
            display: flex;
            gap: 0.5rem;
        }
        .modal-title{
            font-size: 18px;
            color:#333 !important;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .form-control {
            font-size:14px;
        }
        .form-group label {
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 0.5rem;
        }
        .page-titles a{
            text-decoration: none;
        }
        
        .table-responsive {
            border-radius: 0.375rem;
            overflow: hidden;
        }
        
       .add-btn , .remove-btn{
        padding:10px 10px 10px 10px;
        font-size: 20px;
        margin-top: 30px;
       }
       .color-input{
        width: 200px;
       }
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
        /* Container adjustments */
        .container-fluid {
            padding: 0.5rem;
        }
        
        /* Card adjustments */
        .card {
            margin: 0;
            border-radius: 0.5rem;
        }
        
        .card-header {
            padding: 1rem 0.75rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        /* Tab navigation responsive */
        .nav-tabs {
            flex-wrap: wrap;
            border-bottom: 1px solid #dee2e6;
        }
        
        .nav-tabs .nav-item {
            margin-bottom: -1px;
        }
        
        .nav-tabs .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        
        /* Tab content adjustments */
        .tab-content {
            padding: 1rem 0.5rem;
            border-radius: 0;
        }
        
        /* Header section responsive */
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .d-flex.justify-content-between.align-items-center h5 {
            margin-bottom: 0;
            
        }
        
        .d-flex.justify-content-between.align-items-center .btn {
            width: 100%;
            justify-self: stretch;
        }
        
        /* Table responsive wrapper */
        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            margin: 0 -0.5rem;
        }
        
        /* DataTable mobile adjustments */
        .dataTables_wrapper {
            padding: 0;
        }
        
        .dataTables_length,
        .dataTables_filter {
            margin: 0.5rem 0;
        }
        
        .dataTables_length select,
        .dataTables_filter input {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        /* Table styling for mobile */
        table.display {
            width: 100% !important;
            margin: 0;
            font-size: 0.85rem;
        }
        
        table.display thead th {
            padding: 0.5rem 0.25rem;
            font-size: 0.8rem;
            white-space: nowrap;
        }
        
        table.display tbody td {
            padding: 0.5rem 0.25rem;
            font-size: 0.85rem;
            word-break: break-word;
        }
        
        
        /* Modal responsive */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100vw - 1rem);
        }
        
        .modal-dialog.modal-lg {
            max-width: calc(100vw - 1rem);
        }
        
        .modal-header {
            padding: 1rem;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .modal-footer .btn {
            width: 100%;
        }
        
        /* Form adjustments in modals */
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-control {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
        
        /* Parameter rows in metrics modal */
        .parameter-row {
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            align-items: stretch !important;
        }
        
        .parameter-row > div {
            width: 100%;
        }
        
        .parameter-row .color-input {
            width: 100%;
            height: 45px;
        }
        
        .parameter-row .btn {
            width: auto;
            align-self: center;
            padding: 0.5rem 1rem;
        }
        
        /* Button adjustments */
        .add-btn, .remove-btn {
            margin-top: 0.5rem;
            font-size: 18px;
        }
        
        /* Breadcrumb responsive */
        .breadcrumb {
            flex-wrap: wrap;
            padding: 0.5rem 0;
        }
        
        .breadcrumb-item {
            font-size: 0.85rem;
        }
        
        /* Alert adjustments */
        .alert {
            margin-bottom: 1rem;
            font-size: 0.9rem;
            padding: 0.75rem;
        }
        
        /* DataTables pagination */
        .dataTables_paginate {
            margin-top: 1rem;
        }
        
        .dataTables_paginate .pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .dataTables_info {
            text-align: center;
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }
    }

    /* Extra small devices (phones, 576px and down) */
    @media (max-width: 576px) {
        /* Even smaller adjustments */
        .nav-tabs .nav-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.8rem;
        }
        
        table.display {
            font-size: 0.75rem;
        }
        
        table.display thead th {
            padding: 0.375rem 0.125rem;
            font-size: 0.7rem;
        }
        
        table.display tbody td {
            padding: 0.375rem 0.125rem;
            font-size: 0.75rem;
        }
        
        
        /* Make tables horizontally scrollable on very small screens */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Ensure minimum width for table to be scrollable */
        table.display {
            min-width: 500px;
        }
        
        /* Parameter rows even more compact */
        .parameter-row {
            padding: 0.75rem;
        }
        
        .add-btn, .remove-btn {
            font-size: 16px;
            padding: 0.375rem 0.75rem;
        }
    }

    /* Landscape phone orientation */
    @media (max-width: 896px) and (orientation: landscape) {
        .modal-dialog {
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }
    }

    /* Additional utility classes for better mobile experience */
    .mobile-stack {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    @media (min-width: 769px) {
        .mobile-stack {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    /* Ensure DataTable controls are visible on mobile */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        text-align: center;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 100%;
        max-width: 200px;
    }

    /* Fix for CKEditor in mobile */
    @media (max-width: 768px) {
        .ck-editor__editable {
            min-height: 150px !important;
        }
        
        .ck-toolbar {
            flex-wrap: wrap;
        }
    }
      /* .select2-search--dropdown{
            width: 470px;
        } */
        .select2-dropdown--below , .select2-dropdown--above{
            width: 470px !important;
        }
        .select2-container .select2-selection--single{
                border-radius: 0;
                background: #fff;
                border: 1px solid #f0f1f5;
                color: #6e6e6e;
                height: 56px;
        }
         .heading-title{
            color:#333333 !important;
            font-size: 18px !important;
        }
        .btn-rounded{
            border:none !important;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Exercise Management</a></li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Exercise Management </h4>
                    @php
                        $activeTab = request()->get('active_tab') ?? session('active_tab', 'categories-list');// default to categories
                    @endphp
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs pb-2" id="exerciseManagementTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'categories-list' ? 'active' : '' }}" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">
                                Categories
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'bodyparts' ? 'active' : '' }}" id="bodyparts-tab" data-bs-toggle="tab" data-bs-target="#bodyparts" type="button" role="tab">
                                Body Parts
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'exercise-styles' ? 'active' : '' }}" id="exercise-styles-tab" data-bs-toggle="tab" data-bs-target="#exercise-styles" type="button" role="tab">
                                Exercise Styles
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'exercise-list' ? 'active' : '' }}" id="exercise-list-tab" data-bs-toggle="tab" data-bs-target="#exercise-list" type="button" role="tab">
                                Exercise List
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'metrics-list' ? 'active' : '' }}" id="metrics-list-tab" data-bs-toggle="tab" data-bs-target="#metrics-list" type="button" role="tab">
                                Metrics
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="exerciseManagementTabContent">
                        
                        <!-- Categories Tab -->
                        <div class="tab-pane fade {{ $activeTab == 'categories-list' ? 'show active' : '' }}" id="categories" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 heading-title">Manage Categories</h5>
                                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openCategoryModal('create')">
                                    <i class="fa fa-plus"></i> Add Category
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="categoriesTable" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $key => $category)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" onclick="openCategoryModal('edit', {{ $category->id }}, '{{ $category->name }}')" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" onclick="deleteAlert('{{ route('admin.new.exercise.delete_category', ['id' => $category->id]) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Body Parts Tab -->
                        <div class="tab-pane fade {{ $activeTab == 'bodyparts' ? 'show active' : '' }}" id="bodyparts" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 heading-title">Manage Body Parts</h5>
                                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#bodypartModal" onclick="openBodypartModal('create')">
                                    <i class="fa fa-plus"></i> Add Body Part
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="bodypartsTable" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bodyparts as $key => $bodypart)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $bodypart->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" onclick="openBodypartModal('edit', {{ $bodypart->id }}, '{{ $bodypart->name }}')" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" onclick="deleteAlert('{{ route('admin.new.exercise.delete_bodypart', ['id' => $bodypart->id]) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Exercise Styles Tab -->
                        <div class="tab-pane fade {{ $activeTab == 'exercise-styles' ? 'show active' : '' }}" id="exercise-styles" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 heading-title">Manage Exercise Styles</h5>
                                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#exerciseStyleModal" onclick="openExerciseStyleModal('create')">
                                    <i class="fa fa-plus"></i> Add Exercise Style
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="exerciseStylesTable" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exercise_styles as $key => $style)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $style->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" onclick="openExerciseStyleModal('edit', {{ $style->id }}, '{{ $style->name }}')" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" onclick="deleteAlert('{{ route('admin.new.exercise.delete_exercise_style', ['id' => $style->id]) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Exercise List Tab -->
                        <div class="tab-pane fade {{ $activeTab == 'exercise-list' ? 'show active' : '' }}" id="exercise-list" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 heading-title">Manage Exercise List</h5>
                                <!-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exerciseListModal" onclick="openExerciseListModal('create')">
                                    <i class="fa fa-plus"></i> Add Exercise
                                </button> -->
                                <a href="{{ route('admin.new.exercise.create_exercise_list') }}" class="btn btn-primary btn-sm btn-rounded">
                                    <i class="fa fa-plus"></i> Add Exercise
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="exerciseListTable" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Body Part</th>
                                            <th>Exercise Style</th>
                                            <th>Alternate Exercises</th>
                                            <!-- <th>Reps</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exercise_lists as $key => $exercise)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $exercise->name }}</td>
                                                <td>{{ $exercise->body_part->name ?? 'N/A' }}</td>
                                                <td>{{ $exercise->exercise_style->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($exercise->alternateExercises->count() > 0)
                                                        @foreach($exercise->alternateExercises as $alt)
                                                            <span class="">{{ $alt->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Not Added</span>
                                                    @endif
                                                </td>
                                                <!-- <td>{{ $exercise->sets }}</td>
                                                <td>{{ $exercise->reps }}</td> -->
                                                <td>
                                                    <!-- <div class="d-flex">
                                                        <a href="#" onclick="openExerciseListModal('edit', {{ $exercise->id }})" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" onclick="deleteAlert('{{ route('admin.new.exercise.delete_exercise_list', ['id' => $exercise->id]) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div> -->
                                                     <div class="d-flex">
                                                        <!-- Changed: Direct link to edit page -->
                                                        <a href="{{ route('admin.new.exercise.edit_exercise_list', ['id' => $exercise->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                         <a href="{{ route('admin.new.exercise.view_exercise_list', ['id' => $exercise->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="#" onclick="deleteAlert('{{ route('admin.new.exercise.delete_exercise_list', ['id' => $exercise->id]) }}')" class="btn btn-danger shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Metrics Tab -->
                        <div class="tab-pane fade {{ $activeTab == 'metrics-list' ? 'show active' : '' }}" id="metrics-list" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 heading-title">Metrics</h5>
                                <button class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#metricsModal" onclick="openMetricsModal('create')">
                                    <i class="fa fa-plus"></i> Add Metrics
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="metricsTable" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($metricsList as $list)
                                            <tr>
                                                <td>{{ $list['id'] }}</td>
                                                <td>{{ $list['name'] }}</td>
                                                <td>{{ $list['created_at'] }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" onclick="openMetricsModal('edit', {{ $list['id'] }})" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" onclick="deleteAlert('{{ route('admin.metrics.delete',$list['id']) }}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                        <input type="hidden" id="categoryId" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="categorySaveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Body Part Modal -->
<div class="modal fade" id="bodypartModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bodypartModalTitle">Add Body Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bodypartForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bodypartName">Body Part Name</label>
                        <input type="text" class="form-control" id="bodypartName" name="name" required>
                        <input type="hidden" id="bodypartId" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="bodypartSaveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Exercise Style Modal -->
<div class="modal fade" id="exerciseStyleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exerciseStyleModalTitle">Add Exercise Style</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="exerciseStyleForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exerciseStyleName">Exercise Style Name</label>
                        <input type="text" class="form-control" id="exerciseStyleName" name="name" required>
                        <input type="hidden" id="exerciseStyleId" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="exerciseStyleSaveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Metrics Modal -->
<div class="modal fade" id="metricsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="metricsModalTitle">Add Metric</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="metricForm" method="POST">
                @csrf
                <input type="hidden" name="id" id="metricId"> <!-- Needed for edit -->
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="metricName" placeholder="Name" required>
                        <small id="nameError" class="text-danger"></small>
                    </div>

                    <div id="parameters-container">
                        <div class="parameter-row d-flex align-items-center gap-2">
                            <div>
                                <label>Parameter</label>
                                <input type="text" name="parameter[]" class="form-control parameter-input" placeholder="Parameter" required>
                            </div>
                            <div>
                                <label>Color</label>
                                <input type="color" name="color[]" class="form-control color-input">
                            </div>
                            <button type="button" class="btn btn-success add-btn">+</button>
                            <button type="button" class="btn btn-danger remove-btn">x</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="metricSaveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>

    document.getElementById('youtubeLink').addEventListener('blur', function () {
        const youtubeLinkInput = document.getElementById('youtubeLink');
        const errorMessage = document.getElementById('error-message');
        
        // Updated regex to handle query parameters after video ID
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]{11}(\?[^\s]*)?$/;

        if (!youtubeRegex.test(youtubeLinkInput.value) && youtubeLinkInput.value.trim() !== "") {
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';
        }
    });
    const editors = {};

    document.querySelectorAll('.summernote').forEach(element => {
        ClassicEditor
            .create(element, {
                toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'paragraph']
            })
            .then(editor => {
                editors[element.id] = editor;

                editor.ui.view.editable.element.style.height = '250px';

                const form = element.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        element.value = editor.getData(); // sync data on submit
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    });

</script>
<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#categoriesTable, #bodypartsTable, #exerciseStylesTable, #exerciseListTable, #metricsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
    $('.searchable-select').select2({
        placeholder: "--Select--",
        allowClear: true,
        width: 'auto',
        dropdownAutoWidth: true,
        dropdownParent: $('#exerciseListModal')
    });
});

// Category Modal Functions
function openCategoryModal(action, id = null, name = null) {
    if (action === 'create') {
        $('#categoryModalTitle').text('Add Category');
        $('#categoryForm').attr('action', '{{ route("admin.new.exercise.save_category") }}');
        $('#categoryName').val('');
        $('#categoryId').val('');
        $('#categorySaveBtn').text('Save');
    } else if (action === 'edit') {
        $('#categoryModalTitle').text('Edit Category');
        $('#categoryForm').attr('action', '{{ route("admin.new.exercise.update_category") }}');
        $('#categoryName').val(name);
        $('#categoryId').val(id);
        $('#categorySaveBtn').text('Update');
    }
    $('#categoryModal').modal('show');
}

// Body Part Modal Functions
function openBodypartModal(action, id = null, name = null) {
    if (action === 'create') {
        $('#bodypartModalTitle').text('Add Body Part');
        $('#bodypartForm').attr('action', '{{ route("admin.new.exercise.save_bodypart") }}');
        $('#bodypartName').val('');
        $('#bodypartId').val('');
        $('#bodypartSaveBtn').text('Save');
    } else if (action === 'edit') {
        $('#bodypartModalTitle').text('Edit Body Part');
        $('#bodypartForm').attr('action', '{{ route("admin.new.exercise.update_bodypart") }}');
        $('#bodypartName').val(name);
        $('#bodypartId').val(id);
        $('#bodypartSaveBtn').text('Update');
    }
    $('#bodypartModal').modal('show');
}

// Exercise Style Modal Functions
function openExerciseStyleModal(action, id = null, name = null) {
    if (action === 'create') {
        $('#exerciseStyleModalTitle').text('Add Exercise Style');
        $('#exerciseStyleForm').attr('action', '{{ route("admin.new.exercise.save_exercise_style") }}');
        $('#exerciseStyleName').val('');
        $('#exerciseStyleId').val('');
        $('#exerciseStyleSaveBtn').text('Save');
    } else if (action === 'edit') {
        $('#exerciseStyleModalTitle').text('Edit Exercise Style');
        $('#exerciseStyleForm').attr('action', '{{ route("admin.new.exercise.update_exercise_style") }}');
        $('#exerciseStyleName').val(name);
        $('#exerciseStyleId').val(id);
        $('#exerciseStyleSaveBtn').text('Update');
    }
    $('#exerciseStyleModal').modal('show');
}

function toggleWeightValueField(value) {
    if (value === 'Yes') {
        $('#weightValueDiv').show();
    } else {
        $('#weightValueDiv').hide();
        $('#weightValue').val(''); // clear input when hidden
    }
}

// Event listener for Weight select
$('#exerciseWeight').on('change', function() {
    toggleWeightValueField($(this).val());
});

function loadExerciseData(id) {
    // You'll need to create this route in your controller
    $.ajax({
        url: '/admin/new/exercise/exercise-list/'+ id + '/get',
        method: 'GET',
        success: function(data) {
            $('#exerciseName').val(data.name);
            $('#exerciseBodyPart').val(data.body_part_id).change();
            $('#exerciseStyle').val(data.exercise_style_id).change();
            // $('#exerciseSets').val(data.sets);
            // $('#exerciseReps').val(data.reps);
            // $('#exerciseRest').val(data.rest);
            // $('#exerciseTempo').val(data.tempo);
            // $('#exerciseIntensity').val(data.intensity);
            $('#exerciseWeight').val(data.weight);
            $('#youtubeLink').val(data.video_link);
            if (editors['exerciseNotes']) {
                editors['exerciseNotes'].setData(data.notes || '');
            }

            // Weight Value
            toggleWeightValueField(data.weight);
            if(data.weight_value){
                $('#weightValue').val(data.weight_value);
            }
        }
    });
}

function openMetricsModal(action, id = null, name = null, parameters = []) {
    if (action === 'create') {
        $('#metricsModalTitle').text('Add Metric');
        $('#metricForm').attr('action', '{{ route("admin.metrics.store") }}');
        $('#metricName').val('');
        $('#nameError').text('');
        $('#parameters-container').html(`
            <div class="parameter-row d-flex align-items-center gap-2">
                <div>
                    <label>Parameter</label>
                    <input type="text" name="parameter[]" class="form-control parameter-input" placeholder="Parameter" required>
                </div>
                <div>
                    <label>Color</label>
                    <input type="color" name="color[]" class="form-control color-input">
                </div>
                <button type="button" class="btn btn-success add-btn">+</button>
                <button type="button" class="btn btn-danger remove-btn">x</button>
            </div>
        `);
        $('#metricSaveBtn').text('Save');
    
    }else if (action === 'edit' && id) {

        $.get('{{ url("admin/metrics/get") }}/' + id, function (data) {
            $('#metricsModalTitle').text('Edit Metric');
            $('#metricForm').attr('action', '{{ route("admin.metrics.updateMetric") }}');
            $('#metricId').val(data.id);
            $('#metricName').val(data.name);
            $('#nameError').text('');

            let html = '';
            data.parameters.forEach(p => {
                html += `
                <div class="parameter-row d-flex align-items-center gap-2">
                    <div>
                        <label>Parameter</label>
                        <input type="text" name="parameter[]" class="form-control parameter-input" value="${p.parameter}" required>
                    </div>
                    <div>
                        <label>Color</label>
                        <input type="color" name="color[]" class="form-control color-input" value="${p.color}">
                    </div>
                    <button type="button" class="btn btn-success add-btn">+</button>
                    <button type="button" class="btn btn-danger remove-btn">x</button>
                </div>`;
            });
            $('#parameters-container').html(html);
            $('#metricSaveBtn').text('Update');
           // $('#metricsModal').modal('show');
        });
    }

    $('#metricsModal').modal('show');
}

// Add/remove parameter row dynamically
$(document).on('click', '.add-btn', function () {
    let newRow = `
        <div class="parameter-row d-flex align-items-center gap-2">
            <div>
                <label>Parameter</label>
                <input type="text" name="parameter[]" class="form-control parameter-input" placeholder="Parameter" required>
            </div>
            <div>
                <label>Color</label>
                <input type="color" name="color[]" class="form-control color-input">
            </div>
            <button type="button" class="btn btn-success add-btn">+</button>
            <button type="button" class="btn btn-danger remove-btn">x</button>
        </div>`;
    $('#parameters-container').append(newRow);
});

$(document).on('click', '.remove-btn', function () {
    if ($('.parameter-row').length > 1) {
        $(this).closest('.parameter-row').remove();
    }
});


function viewAlternateExercises(exerciseId) {
    // Redirect to edit page instead
    window.location.href = '/admin/new/exercise/exercise-list/' + exerciseId + '/edit';
}

</script>
@endsection