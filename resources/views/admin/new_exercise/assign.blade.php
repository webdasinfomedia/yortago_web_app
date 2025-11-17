@extends('admin.layouts.master')

@section('admin_title')
    Assign Exercise Program
@endsection

@section('css')
    <!-- Include the Select2 CSS (embedded directly into the current file) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <style>
        .select2-container .select2-selection--single{
                border-radius: 0;
                background: #fff;
                border: 1px solid #f0f1f5;
                color: #6e6e6e;
                height: 56px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
            </ol>
        </div>

        <!-- row -->
        <div class="row">
            <div class="col-lg-6">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Program</h4>
                        <a href="{{route('admin.new.exercise.manage')}}"
                           class="btn btn-rounded btn-primary btn-sm" style="float: right">
                            Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.new.exercise.assign_program')}}" method="post">
                            @csrf
                            <input type="hidden" name="new_exercise_id" value="{{$exercise->id}}">
                            
                            <!-- Form group for Select2 -->
                            <div class="form-group">
                                <label for="focus">Users</label>
                                <select class="form-control" name="user_id" id="userSelect">
                                    <option value="">Select User</option>
                                    @foreach($users as $f)
                                        <option value="{{$f->id}}">{{$f->name}} - {{$f->email}}</option>
                                    @endforeach
                                </select>
                                <span id="userError" class="text-danger" style="display:none;"></span>
                            </div>

                            <button class="btn btn-primary btn-sm btn-fluid">Assign Program</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Program Details Column -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Program Details</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <p><b>{{ $exercise->title }}</b></p>
                            <p><b>Age Range :</b> {{ isset($exercise->age->age_range) ? $exercise->age->age_range : 'N/A' }}</p>
                            <p><b>Gender :</b> {{ isset($exercise->gender->name) ? $exercise->gender->name : 'N/A' }}</p>
                            <p><b>Experience Level :</b>
                                {{ isset($exercise->experience_level->heading, $exercise->experience_level->sub_heading) && 
                                  is_numeric($exercise->experience_level->heading) && 
                                  is_numeric($exercise->experience_level->sub_heading) 
                                  ? $exercise->experience_level->heading - $exercise->experience_level->sub_heading 
                                  : 'N/A' }}
                            </p>
                            <p><b>Equipment Name :</b> {{ isset($exercise->equipment->name) ? $exercise->equipment->name : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Users Table Column -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assigned User</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Users</th>
                                        <th>Started Date</th>
                                        <th>Completion Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assigned_users as $key => $f)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$f->name}} - {{ $f->email }}</td>
                                            <td>{{$f->pivot->start_date}}</td>
                                            <td>{{$f->pivot->completion_date}}</td>
                                            <td>
                                                <a href="{{route('admin.new.exercise.deassign_program',['user_id' => $f->id,'new_exercise_id' => $f->pivot->new_exercise_id])}}"
                                                   class="btn btn-rounded btn-danger btn-sm">De Assign / Delete</a>
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
@endsection

@section('script')
    <!-- Include jQuery before Select2 JS (Make sure jQuery is loaded) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include the Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables JS -->
    <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

    <script>
    $(document).ready(function() {
        // Initialize Select2 on the select element
        $('#userSelect').select2();
    });

    // Event listener to check if the user has already been assigned an exercise
    document.getElementById('userSelect').addEventListener('change', function () {
        const userId = this.value;
        const errorSpan = document.getElementById('userError');

        // Hide previous errors
        errorSpan.style.display = 'none';

        if (userId) {
            fetch(`{{route('admin.new.exercise.check_assigned_program')}}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    errorSpan.textContent = "This user already has an assigned exercise. Assigning again will override the previous exercise.";
                    errorSpan.style.display = 'block';
                } else if (data.error) {
                    errorSpan.textContent = data.error;
                    errorSpan.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorSpan.textContent = "An unexpected error occurred. Please try again.";
                errorSpan.style.display = 'block';
            });
        }
    });
    </script>
@endsection
