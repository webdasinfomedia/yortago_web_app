@extends('admin.layouts.master')
@section('admin_title')
    Duplicate Exercise Program
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <style>
        /* Custom styles for duplicate program interface */
        .duplicate-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .duplicate-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .duplicate-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .selection-summary {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .selection-summary .summary-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .selection-summary .summary-item:last-child {
            margin-bottom: 0;
        }

        .selection-summary .summary-icon {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        /* Override some styles for better mobile responsiveness */
        @media (max-width: 768px) {
            .week-day-sidebar {
                margin-bottom: 20px;
            }
            
            .duplicate-header {
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.new.exercise.manage') }}">Exercise Programs</a></li>
                <li class="breadcrumb-item active">Duplicate Exercise Program</li>
            </ol>
        </div>
        
        <!-- Livewire Component -->
        @livewire('duplicate-program', ['exerciseId' => $encryptedId])
    </div>
@endsection

@section('script')
    <script src="{{ URL::to('front/dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script>
        // Additional JavaScript for duplicate program functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips if using Bootstrap tooltips
            if (typeof $().tooltip === 'function') {
                $('[data-toggle="tooltip"]').tooltip();
            }
            
            // Auto-expand first week accordion
            const firstWeekAccordion = document.querySelector('[id^="weekDays"]');
            if (firstWeekAccordion) {
                firstWeekAccordion.style.display = 'block';
                const firstArrow = document.querySelector('[id^="arrow"]');
                if (firstArrow) {
                    firstArrow.classList.add('rotated');
                }
            }
        });

        // Handle successful duplication redirect
        window.addEventListener('duplicate-success', function(event) {
            if (event.detail.redirectUrl) {
                setTimeout(() => {
                    window.location.href = event.detail.redirectUrl;
                }, 1500);
            }
        });
    </script>
@endsection