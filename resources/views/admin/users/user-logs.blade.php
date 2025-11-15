@extends('admin.layouts.master')

@section('admin_title', 'User Exercise Logs')

@section('css')
<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@endsection
<style>

.modal-content{
 width:70% !important;
}
.note-data{
    font-size:14px;
    font-weight:400;
    padding-left:1rem;
     padding-right:1rem;
}
.note-date{
    color: #B9732F;
    font-size: 14px;
    font-weight: 400;
    padding-right:1rem;
}
.modal-footer{
    border-top: solid #fcfdff !important;
}
#logsTable td{
    font-size:14px !important;
}
.modal-title, .modal-footer{
    font-size: 16px;
}

</style>
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.live-stream.users.list') }}">Users</a></li>
            <li class="breadcrumb-item active"><a href="#">Exercise Logs - {{ $user->name }}</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Exercise Logs for {{ $user->name }}</h4>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    <a href="{{ route('admin.live-stream.users.list') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Back to Users
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="logsTable" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Log Date</th>
                                    <th>Exercise Name</th>
                                    <th>Exercise Item</th>
                                    <th>Alternate</th>
                                    <th>Replaced Item</th>
                                    <th>Body Part</th>
                                    <th>Sets</th>
                                    <th>Reps</th>
                                    <th>Weight</th>
                                    <th>Intensity</th>
                                    <th>Time Taken</th>
                                    <th>Program Start</th>
                                    <th>Completion Date</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                           <tbody>
                                @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}</td>
                                    <td>{{ $log->newUserExercise->newExercise->title ?? 'N/A' }}</td>
                                        {{-- Exercise Item: from ExerciseList --}}
                                    <td>{{ $log->exerciseItem->exercise_list->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($log->alternate == 1)
                                             Yes 
                                        @else
                                            No
                                        @endif
                                    </td>
                                    {{-- Replaced Item: from ExerciseList --}}
                                    <td>{{ $log->replacedExerciseItem->exercise_list->name ?? '-' }}</td>
                                    <td><span>{{ $log->bodyPart->name ?? 'N/A' }}</span></td>
                                    <td>
                                        @if($log->sets)
                                            {{ implode(', ', json_decode($log->sets)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->reps)
                                            {{ implode(', ', json_decode($log->reps)) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $weights = json_decode($log->weight, true);
                                        @endphp
                                        
                                        @if(!empty($weights))
                                            {{ collect($weights)->map(fn($w) => ($w ?? 0) . ' ' . ($log->weight_unit ?? 'kg'))->implode(', ') }}
                                        @else
                                            0 {{ $log->weight_unit ?? 'kg' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->intensity)
                                            <span>
                                                {{ $log->intensity }}
                                            </span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $log->time_taken ?? 'N/A' }}</td>
                                    {{-- Program Start: from NewUserExercise --}}
                                    <td>
                                        @if($log->newUserExercise && $log->newUserExercise->start_date)
                                            {{ \Carbon\Carbon::parse($log->newUserExercise->start_date)->format('d M Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    
                                    {{-- Completion Date: from NewUserExercise --}}
                                    <td>
                                        @if($log->newUserExercise && $log->newUserExercise->completion_date)
                                            <span >{{ \Carbon\Carbon::parse($log->newUserExercise->completion_date)->format('d M Y') }}</span>
                                        @else
                                            <span>Ongoing</span>
                                        @endif
                                    </td>
                                   <td>
                                        @php
                                            $itemNotes = $exerciseNotes->get($log->new_item_id, collect());
                                        @endphp
                                        
                                        @if($itemNotes->isNotEmpty())
                                            <button type="button" class="btn btn-sm btn-secondary w-100"  style="background-color:#d76e33; font-weight: 400; font-size: 14px; text-wrap:nowrap;" 
                                                    onclick='showNotesPopup(@json($itemNotes->map(function($note) {
                                                        return [
                                                            "notes" => $note->notes,
                                                            "created_at" => \Carbon\Carbon::parse($note->created_at)->format("d-m-Y")
                                                        ];
                                                    })->values()->toArray()), "{{ addslashes($log->exerciseItem->exercise_list->name ?? 'Exercise') }}")'>
                                               View Notes
                                            </button>
                                        @else
                                            -
                                        @endif
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
<!-- Notes Modal -->

<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notesModalLabel">
                    Notes - Exercise Name
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalNotesContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#logsTable').DataTable({
        pageLength: 10,
        order: [[1, 'desc']], // Sort by date descending
        language: {
            search: "Search Logs:",
            lengthMenu: "Show _MENU_ logs per page",
            info: "Showing _START_ to _END_ of _TOTAL_ logs",
            infoEmpty: "No logs available",
            infoFiltered: "(filtered from _MAX_ total logs)"
        },
        columnDefs: [
            { orderable: false, targets: [13] } // Disable sorting on Notes column
        ]
    });
    
});
// function showNotesPopup(notes, exercise) {
//         // Set modal content
//        // document.getElementById('modalExerciseName').textContent = exercise;
//         document.getElementById('modalNotesContent').textContent = notes;

//         // Show the modal using Bootstrap 5 JS
//         var notesModal = new bootstrap.Modal(document.getElementById('notesModal'));
//         notesModal.show();
//     }
function showNotesPopup(notesArray, exerciseName) {
    let notesHtml = '';

    if (notesArray && notesArray.length > 0) {
        notesHtml = '<div class="notes-list">';
        
        notesArray.forEach((noteObj, index) => {
            const noteNumber = String(index + 1).padStart(2, '0');
            notesHtml += `
                <div class="note-item rounded">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="d-flex align-items-start note-data">
                        <span class="note-number">${noteNumber}.</span>
                        <span class="note-content ml-2">
                            ${noteObj.notes ? noteObj.notes.replace(/\n/g, '<br>') : 'No content'}
                        </span>
                    </div>
                    <span class="note-date">${noteObj.created_at}</span>
                </div>
            </div>

                <hr/>
            `;
        });
        
        notesHtml += '</div>';
    } else {
        notesHtml = '<p class="text-muted text-center">No notes available</p>';
    }

    // Update modal title with exercise name
    document.getElementById('notesModalLabel').innerHTML = 
        `Notes - ${exerciseName}`;
    
    // Update modal content
    document.getElementById('modalNotesContent').innerHTML = notesHtml;

    // Show modal
    var notesModal = new bootstrap.Modal(document.getElementById('notesModal'));
    notesModal.show();
}
</script>
@endsection