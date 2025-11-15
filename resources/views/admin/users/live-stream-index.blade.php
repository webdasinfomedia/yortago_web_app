@extends('admin.layouts.master')



@section('admin_title', 'Users')



@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- fontawesome CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
.breadcrumb-item a{
    text-decoration: none;
}
</style>
@endsection



@section('content')

<div class="container-fluid">

    <div class="page-titles">

        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>

            <li class="breadcrumb-item active"><a>Users</a></li>

        </ol>

    </div>



    @if(session('success'))

    <div class="alert alert-success">{{ session('success') }}</div>

    @endif

    @if(session('error'))

    <div class="alert alert-danger">{{ session('error') }}</div>

    @endif



    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title">Users</h4>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example3" class="display min-w850">

                            <thead>

                                <tr>

                                    <th>Sr No</th>

                                    <th>User Name</th>

                                    <th>User Email</th>

                                    <th>Subscription</th>

                                    <th>Exercise Logs</th>

                                    <th>Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($lists as $list)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $list->name }}</td>

                                    <td>{{ $list->email }}</td>

                                    <td>

                                        @if($list->stripe_status == 'active')

                                            <span class="badge badge-success">Active</span>

                                        @elseif($list->stripe_status == 'paused')

                                            <span class="badge badge-warning">Paused</span>

                                        @elseif($list->stripe_status == 'canceled')

                                            <span class="badge badge-danger">Canceled</span>

                                        @endif



                                        @if($list->subscription_link)

                                            <br>

                                            <button class="btn btn-primary btn-sm mt-1"

                                                onclick="copySubscriptionLink('{{ $list->subscription_link }}')">

                                                <i class="fa fa-copy"></i> Copy Link

                                            </button>

                                        @endif

                                    </td>

                                    <td>

                                        <span class="badge badge-info">{{ $list->exerciseLogs->count() }} Logs</span>

                                        <!--<button class="btn btn-sm btn-primary view-logs" -->

                                        <!--        data-user-id="{{ $list->id }}"-->

                                        <!--        data-toggle="modal" -->

                                        <!--        data-target="#logsModal">-->

                                        <!--    <i class="fa fa-eye"></i> View-->

                                        <!--</button>-->
                                         <a href="{{ route('admin.users.logs.show', $list->id) }}" 
                                        class="btn btn-sm btn-primary">
                                            <i class="fa fa-eye"></i> View Logs
                                        </a>


                                        

                                    </td>

                                    <!-- <td> -->

                                        <!-- <div class="d-flex">

                                            @if($list->stripe_status === 'active') -->

                                                <!-- Show Pause and Cancel buttons -->

                                                <!-- <form action="{{ route('admin.subscriptions.pause', $list->id) }}" method="POST" class="mr-2">

                                                    @csrf

                                                    <button type="submit" class="btn btn-warning btn-sm">

                                                        <i class="fa fa-pause"></i> Pause

                                                    </button>

                                                </form>

                                                <form action="{{ route('admin.subscriptions.cancel', $list->id) }}" method="POST">

                                                    @csrf

                                                    <button type="submit" class="btn btn-danger btn-sm">

                                                        <i class="fa fa-times"></i> Cancel

                                                    </button>

                                                </form>

                                            @elseif($list->stripe_status === 'paused') -->

                                                <!-- Show Resume and Cancel buttons -->

                                                <!-- <form action="{{ route('admin.subscriptions.resume', $list->id) }}" method="POST" class="mr-2">

                                                    @csrf

                                                    <button type="submit" class="btn btn-success btn-sm">

                                                        <i class="fa fa-play"></i> Resume

                                                    </button>

                                                </form>

                                                <form action="{{ route('admin.subscriptions.cancel', $list->id) }}" method="POST">

                                                    @csrf

                                                    <button type="submit" class="btn btn-danger btn-sm">

                                                        <i class="fa fa-times"></i> Cancel

                                                    </button>

                                                </form>

                                            @else -->

                                                <!-- Show Add Subscription button -->

                                                <!-- <button class="btn btn-success btn-sm mr-2" data-toggle="modal"

                                                    data-target="#addSubscriptionModal" data-user-id="{{ $list->id }}"

                                                    data-user-name="{{ $list->name }}">

                                                    <i class="fa fa-plus-circle"></i> Add Subscription

                                                </button>

                                            @endif

                                        </div>

                                        <a href="{{route('admin.monitoring',['id' => $list->id])}}"

                                               class="btn btn-xs btn-primary">Monitoring</a>

                                        <a href="{{route('admin.form_check',['id' => $list->id])}}"

                                               class="btn btn-xs btn-danger">Form Check</a>

                                        <a href="{{ route('admin.user_evaluation.index', ['userId' => $list->id]) }}"

                                                   class="btn btn-xs btn-warning">Evaluation</a>

                                    </td> -->

                                    <td>
                                        <div class="dropdown_toggle">
                                            <button class="btn border-0" type="button" id="dropdownMenuButton{{ $list->id }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical fs-5"></i>
                                            </button>

                                            <ul class="dropdown-menu heder-dropdown-menu action_dropdown shadow py-2"
                                                aria-labelledby="dropdownMenuButton{{ $list->id }}">

                                                {{-- Subscription Actions --}}
                                                @if($list->stripe_status === 'active')
                                                    <li>
                                                        <form action="{{ route('admin.subscriptions.pause', $list->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-warning">
                                                                <i class="fa fa-pause me-2"></i> Pause
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.subscriptions.cancel', $list->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fa fa-times me-2"></i> Cancel
                                                            </button>
                                                        </form>
                                                    </li>
                                                @elseif($list->stripe_status === 'paused')
                                                    <li>
                                                        <form action="{{ route('admin.subscriptions.resume', $list->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fa fa-play me-2"></i> Resume
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.subscriptions.cancel', $list->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fa fa-times me-2"></i> Cancel
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                        href="javascript:;" data-bs-toggle="modal"
                                                        data-bs-target="#addSubscriptionModal"
                                                        data-user-id="{{ $list->id }}"
                                                        data-user-name="{{ $list->name }}">
                                                            <i class="fa fa-plus-circle me-2"></i> Add Subscription
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Divider --}}
                                                <div class="dropdown-divider m-0"></div>

                                                {{-- Monitoring --}}
                                                <li>
                                                    <a class="dropdown-item text-primary"
                                                    href="{{ route('admin.monitoring',['id' => $list->id]) }}">
                                                        <i class="fa fa-tv me-2"></i> Goal Traking       {{--Monitoring--}} 
                                                    </a>
                                                </li>

                                                {{-- Form Check --}}
                                                <li>
                                                    <a class="dropdown-item text-danger"
                                                    href="{{ route('admin.form_check',['id' => $list->id]) }}">
                                                        <i class="fa fa-check me-2"></i> Form Check
                                                    </a>
                                                </li>

                                                {{-- Evaluation --}}
                                                <li>
                                                    <a class="dropdown-item text-warning"
                                                    href="{{ route('admin.user_evaluation.index', ['userId' => $list->id]) }}">
                                                        <i class="fa fa-star me-2"></i> Evaluation
                                                    </a>
                                                </li>
                                            </ul>
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

<!--<div class="modal fade" id="logsModal" tabindex="-1" role="dialog" aria-hidden="true">-->

<!--    <div class="modal-dialog modal-lg" role="document">-->

<!--        <div class="modal-content">-->

<!--            <div class="modal-header">-->

<!--                <h5 class="modal-title">Exercise Logs for <span id="userName"></span></h5>-->

<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->

<!--                    <span aria-hidden="true">&times;</span>-->

<!--                </button>-->

<!--            </div>-->

<!--            <div class="modal-body">-->

<!--                <div class="table-responsive">-->

<!--                    <table class="table table-bordered">-->

                      

<!--                                <thead>-->

<!--                                    <tr>-->

<!--                                        <th>Log Date</th>-->

<!--                                        <th>Exercise Name</th>-->

<!--                                        <th>Exercise Item</th>-->

<!--                                        <th>Replaced Item</th>-->

<!--                                        <th>Body Part</th>-->

<!--                                        <th>Sets</th>-->

<!--                                        <th>Reps</th>-->

<!--                                        <th>Weight</th>-->

<!--                                        <th>Intensity</th>-->

<!--                                        <th>Time Taken</th>-->

<!--                                        <th>Notes</th>-->

<!--                                        <th>Program Start</th>-->

<!--                                        <th>Completion Date</th>-->

<!--                                    </tr>-->

<!--                                </thead>-->

                        

<!--                        <tbody id="logsTableBody">-->

                            <!-- Logs will be loaded here via AJAX -->

<!--                        </tbody>-->

<!--                    </table>-->

<!--                </div>-->

<!--            </div>-->

<!--            <div class="modal-footer">-->

<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->

<!--            </div>-->

<!--        </div>-->

<!--    </div>-->

<!--</div>-->



<!-- Add Subscription Modal -->

<div class="modal fade" id="addSubscriptionModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Add Subscription</h5>

                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <form id="subscriptionForm" action="{{ route('admin.subscriptions.create') }}" method="POST">

                @csrf

                <input type="hidden" name="user_id" id="modal_user_id">

                <div class="modal-body">

                    <div class="form-group">

                        <label for="subscription_name">Subscription Name</label>

                        <input type="text" class="form-control" id="subscription_name" name="name" required>

                        <small class="form-text text-muted">e.g. Monthly Training, Premium Access, etc.</small>

                    </div>

                    <div class="form-group">

                        <label for="amount">Amount (USD)</label>

                        <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01" required>

                    </div>

                    <div class="form-group">

                        <label for="interval">Billing Interval</label>

                        <select class="form-control" id="interval" name="interval" required>

                            <option value="month">Monthly</option>

                            <option value="year">Yearly</option>

                            <option value="week">Weekly</option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary">

                        <i class="fa fa-credit-card"></i> Generate Payment Link

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- Payment Link Modal -->

<div class="modal fade" id="paymentLinkModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Payment Link Generated</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="alert alert-info">

                    <p>Share this payment link with the user. The subscription will be activated automatically after successful payment.</p>

                </div>

                <div class="form-group">

                    <label>Payment Link</label>

                    <div class="input-group">

                        <input type="text" class="form-control" id="generated_payment_link" readonly>

                        <div class="input-group-append">

                            <button class="btn btn-outline-secondary" type="button" id="copy_payment_link">

                                <i class="fa fa-copy"></i> Copy

                            </button>

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label>User Email</label>

                    <input type="text" class="form-control" id="user_email" readonly>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <a href="#" id="send_email_btn" class="btn btn-primary">

                    <i class="fa fa-envelope"></i> Send Email

                </a>

            </div>

        </div>

    </div>

</div>

@endsection



@section('script')

<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// $(document).ready(function() {

//     $('.view-logs').click(function() {

//     const userId = $(this).data('user-id');

//     const userName = $(this).closest('tr').find('td:nth-child(2)').text();

    

//     $('#userName').text(userName);

//     $('#logsTableBody').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

    

//     const url = "{{ route('admin.user.logs', ['user' => ':userId']) }}".replace(':userId', userId);

//         $.get(url, function(data) {

//             console.log(data); // Debug the response

            

//             if(data.length > 0) {

//                 let html = '';

//               data.forEach(log => {

//     html += `

//         <tr>

//             <td>${new Date(log.created_at).toLocaleString()}</td>

//             <td>${log.exercise_name}</td>

//             <td>${log.exercise_item}</td>

//             <td>${log.replaced_exercise_item}</td>

//             <td>${log.body_part}</td>

//             <td>${log.sets ? JSON.parse(log.sets).join(', ') : 'N/A'}</td>

//             <td>${log.reps ? JSON.parse(log.reps).join(', ') : 'N/A'}</td>

//             <td>${log.weight ? JSON.parse(log.weight).join(', ') : 'N/A'} ${log.weight_unit || ''}</td>

//             <td>${log.intensity || 'N/A'}</td>

//             <td>${log.time_taken || 'N/A'}</td>

//             <td>${log.notes || ''}</td>

//             <td>${log.program_start_date ? new Date(log.program_start_date).toLocaleDateString() : 'N/A'}</td>

//             <td>${log.program_completion_date ? new Date(log.program_completion_date).toLocaleDateString() : 'Ongoing'}</td>

//         </tr>

//     `;

// });

//                 $('#logsTableBody').html(html);

//             } else {

//                 $('#logsTableBody').html('<tr><td colspan="6" class="text-center">No logs found</td></tr>');

//             }

//         }).fail(function(xhr) {

//             console.error(xhr);

//             $('#logsTableBody').html('<tr><td colspan="6" class="text-center text-danger">Error loading logs</td></tr>');

//         });

//     });

// });

</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    $('#addSubscriptionModal').on('show.bs.modal', function (event) {

        const button = $(event.relatedTarget);

        const userId = button.data('user-id');

        const userName = button.data('user-name');

        $('#modal_user_id').val(userId);

        $('#subscription_name').val(userName + ' Subscription');

    });



    $('#subscriptionForm').on('submit', function (e) {

        e.preventDefault();

        const form = $(this);

        const formData = form.serialize();



        $.ajax({

            url: form.attr('action'),

            type: 'POST',

            data: formData,

            success: function (response) {

                $('#addSubscriptionModal').modal('hide');

                $('#generated_payment_link').val(response.link);

                $('#paymentLinkModal').modal('show');

            },

            error: function (xhr) {

                alert('Failed to create subscription: ' + xhr.responseJSON.message);

            }

        });

    });



    $('#copy_payment_link').on('click', function () {

        const input = document.getElementById('generated_payment_link');

        input.select();

        input.setSelectionRange(0, 99999);

        document.execCommand('copy');

        alert('Copied payment link to clipboard');

    });

});



function copySubscriptionLink(link) {

    navigator.clipboard.writeText(link).then(() => {

        alert('Link copied to clipboard!');

    }).catch(() => {

        alert('Failed to copy!');

    });

}

</script>



<script>

$(document).ready(function() {

    // Suppose aap blade me user data ko JSON format me output karen

    var users = @json($users); // ya jo variable aapke pass users hain wo



    users.forEach(function(user) {

        // IDs to target buttons/forms

        var addSubBtn = $('#btnAddSubscription-' + user.id);

        var copyLinkBtn = $('#btnCopyLink-' + user.id);

        var pauseForm = $('#frmPause-' + user.id);

        var cancelForm = $('#frmCancel-' + user.id);



        if (user.subscription_link) {

            // Agar subscription_link exist karta hai toh copy link button show karo

            copyLinkBtn.show();

            addSubBtn.hide();

            pauseForm.hide();

            cancelForm.hide();



            // Copy link button pe click handler

            copyLinkBtn.off('click').on('click', function() {

                navigator.clipboard.writeText(user.subscription_link).then(function() {

                    copyLinkBtn.html('<i class="fa fa-check"></i> Copied!');

                    setTimeout(function() {

                        copyLinkBtn.html(

                        '<i class="fa fa-copy"></i> Copy Link');

                    }, 2000);

                });

            });



        } else if (user.is_subscribed == 1 && user.stripe_status == 'active') {

            // Agar subscribed aur active ho to pause aur cancel buttons dikhao

            pauseForm.show();

            cancelForm.show();

            addSubBtn.hide();

            copyLinkBtn.hide();



        } else {

            // Default: Add subscription button show karo

            addSubBtn.show();

            copyLinkBtn.hide();

            pauseForm.hide();

            cancelForm.hide();

        }

    });

});

</script>

<script>

function copySubscriptionLink(link) {

    navigator.clipboard.writeText(link).then(() => {

        alert('Subscription link copied to clipboard!');

    }).catch(() => {

        alert('Failed to copy link.');

    });

}

$(document).ready(function() {

    // Check localStorage for paused or canceled subscriptions on page load

    let pausedIds = JSON.parse(localStorage.getItem('pausedSubscriptions')) || [];

    let canceledIds = JSON.parse(localStorage.getItem('canceledSubscriptions')) || [];



    // Iterate over all pause and cancel forms and adjust visibility based on localStorage

    $('.pause-form, .cancel-form').each(function() {

        let userId = $(this).data('user-id');



        if (canceledIds.includes(userId)) {

            // If canceled, hide pause and cancel buttons, show maybe some "Canceled" label or disable buttons

            $(this).hide();

            $(`.pause-form[data-user-id="${userId}"]`).hide();

            $(`.cancel-form[data-user-id="${userId}"]`).hide();

            // Optional: show some badge or text that user canceled

            $(`tr:has(form[data-user-id="${userId}"])`).find('.badge').removeClass().addClass(

                'badge badge-danger').text('Canceled (local)');

        } else if (pausedIds.includes(userId)) {

            // If paused, hide pause button, maybe disable cancel, or show "Paused" badge

            $(`.pause-form[data-user-id="${userId}"]`).hide();

            $(`.cancel-form[data-user-id="${userId}"]`).show();

            $(`tr:has(form[data-user-id="${userId}"])`).find('.badge').removeClass().addClass(

                'badge badge-warning').text('Paused (local)');

        } else {

            // If not paused or canceled, show pause and cancel normally

            $(`.pause-form[data-user-id="${userId}"]`).show();

            $(`.cancel-form[data-user-id="${userId}"]`).show();

        }

    });



    // When Pause button is clicked

    $('.pause-form').on('submit', function(e) {

        e.preventDefault();

        let userId = $(this).data('user-id');



        // Add userId to pausedSubscriptions in localStorage

        let paused = JSON.parse(localStorage.getItem('pausedSubscriptions')) || [];

        if (!paused.includes(userId)) paused.push(userId);

        localStorage.setItem('pausedSubscriptions', JSON.stringify(paused));



        // Remove userId from canceledSubscriptions if exists

        let canceled = JSON.parse(localStorage.getItem('canceledSubscriptions')) || [];

        canceled = canceled.filter(id => id !== userId);

        localStorage.setItem('canceledSubscriptions', JSON.stringify(canceled));



        // Optionally disable buttons or update UI immediately

        Swal.fire('Paused', 'Subscription paused locally. Server will be updated.', 'success');



        // You can now submit the form normally, or send AJAX here

        this.submit();

    });



    // When Cancel button is clicked

    $('.cancel-form').on('submit', function(e) {

        e.preventDefault();

        let userId = $(this).data('user-id');



        // Add userId to canceledSubscriptions in localStorage

        let canceled = JSON.parse(localStorage.getItem('canceledSubscriptions')) || [];

        if (!canceled.includes(userId)) canceled.push(userId);

        localStorage.setItem('canceledSubscriptions', JSON.stringify(canceled));



        // Remove userId from pausedSubscriptions if exists

        let paused = JSON.parse(localStorage.getItem('pausedSubscriptions')) || [];

        paused = paused.filter(id => id !== userId);

        localStorage.setItem('pausedSubscriptions', JSON.stringify(paused));



        Swal.fire('Canceled', 'Subscription canceled locally. Server will be updated.', 'success');



        this.submit();

    });

});

</script>

@endsection



