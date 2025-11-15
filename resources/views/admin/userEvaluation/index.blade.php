@extends('admin.layouts.master')
@section('admin_title')
Evaluation
@endsection

@section('css')

<link href="{{ URL::to('front/dashboard/vendor/datatables/cssf/jquery.dataTables.min.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">DashBoard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">User Evaluation</a></li>
            </ol>
        </div>
        <!-- row -->

        <div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>
            
            <button class="nav-link" id="nav-evaluation-tab" data-bs-toggle="tab" data-bs-target="#nav-evaluation" type="button" role="tab" aria-controls="nav-evaluation" aria-selected="false">Evaluation</button>
            <button class="nav-link" id="nav-previous-evaluation-tab" data-bs-toggle="tab" data-bs-target="#nav-previous-evaluation" type="button" role="tab" aria-controls="nav-previous-evaluation" aria-selected="false">Previous Evaluation</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active nav-profile" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Loading Profile...</div>
        <div class="tab-pane fade" id="nav-previous-evaluation" role="tabpanel" aria-labelledby="nav-previous-evaluation-tab">Loading Previous Evaluation...</div>
        <div class="tab-pane fade" id="nav-evaluation" role="tabpanel" aria-labelledby="nav-evaluation-tab">Loading Evaluation...</div>
    </div>
</div>


@endsection


@section('script')



<script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('front/dashboard/js/plugins-init/datatables.init.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll('.nav-link');
    
    // Ensure the Profile tab is active by default
    document.getElementById("nav-profile-tab").classList.add("active");
    document.getElementById("nav-profile").classList.add("show", "active");

    // Event listener for tab change
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all tabs and tab panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
            
            // Add active class to the selected tab and the corresponding tab pane
            button.classList.add('active');
            const targetTab = document.querySelector(button.getAttribute('data-bs-target'));
            targetTab.classList.add('show', 'active');
            
            // Load content into the target tab if not already loaded
            loadTabContent(button.getAttribute('data-bs-target'));
        });
    });

    // Ensure the content for the active tab is loaded when the page is ready
    loadTabContent("#nav-profile");
});

// Function to load content into a specific tab
function loadTabContent(tabId) {
    const userId = {{ $user->id }}; // Dynamically pass the user ID from Blade to JavaScript

    console.log(tabId);
    let url = '';
    if (tabId === '#nav-profile') {
        url = '/admin/user_evaluation/profile/' + userId;   
    } else if (tabId === '#nav-previous-evaluation') {
        url = '/admin/user_evaluation/history_view/' + userId;
    } else if (tabId === '#nav-evaluation') {
        url = '/admin/user_evaluation/create/'  + userId;
    }

    // Load content for the tab using AJAX
    $.get(url, function(data) {
        // Insert the fetched content into the corresponding tab body

        console.log(tabId);
        $(tabId).html(data);
    }).fail(function() {
        // Handle any errors (e.g., network issues, server errors)
        $(tabId).html("<p>Error loading content. Please try again.</p>");
    });
}


</script>
@endsection
