@if (session('message_alert'))
    @php
        // Map 'error' → 'danger' for Bootstrap
        $alertClass = session('message_alert')['class'] === 'error'
            ? 'danger'
            : session('message_alert')['class'];
    @endphp
    <!-- Make sure you have Bootstrap 5 -->

    <div class="alert alert-{{ $alertClass }} alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ ucfirst($alertClass) }}:</strong> {{ session('message_alert')['result'] }}
    </div>
@endif
