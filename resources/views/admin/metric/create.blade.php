@extends('admin.layouts.master')
@section('admin_title')
    Manage Metrics
@endsection

@section('css')
    <link href="{{ URL::to('front/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <style>
        .progressbar {
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
            margin: 0.5rem 0 3.5rem;
        }

        .progressbar::before,
        .progress {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #dcdcdc;
            z-index: 1
        }

        .progress {
            background-color: rgb(0 128 0);
            width: 0%;
            transition: 0.3s
        }

        .progress-step {
            width: 2.1875rem;
            height: 2.1875rem;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1
        }

        .progress-step::before {
            counter-increment: step;
            content: counter(step)
        }

        .progress-step::after {
            content: attr(data-title);
            position: absolute;
            top: calc(100% + 0.5rem);
            font-size: 0.85rem;
            color: #666
        }

        .progress-step-active {
            /* background-color: var(--primary-color); */
            color: #000000
        }

        .form {
            width: clamp(320px, 30%, 430px);
            margin: 0 auto;
            border: none;
            border-radius: 10px !important;
            overflow: hidden;
            padding: 1.5rem;
            background-color: #fff;
            padding: 20px 0px;
        }

        .step-forms {
            display: none;
            transform-origin: top;
            animation: animate 1s
        }

        .step-forms-active {
            display: block
        }


        @keyframes animate {
            from {
                transform: scale(1, 0);
                opacity: 0
            }

            to {
                transform: scale(1, 1);
                opacity: 1
            }
        }

        .btns-group {
            margin-bottom: -15px;
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8.5rem;
        }

        .modal-link {
            padding: 0.75rem;
            display: block;
            text-decoration: none;
            background-color: var(--primary-color);
            /* color: #000000; */
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: 0.3s
        }

        .progress-step-check {
            position: relative;
            background-color: green !important;
            transition: all 0.8s;
            color: #ffffff;
        }

        .progress-step-check::before {
            position: absolute;
            content: '\2713';
            width: 100%;
            height: 100%;
            top: 8px;
            left: 13px;
            font-size: 12px
        }

        .welcome {
            margin: 0 auto;
            height: 450px;
            width: 350px;
            background-color: #fff;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .welcome .content {
            margin: 0 auto;
            display: flex;
            align-items: center;
            flex-direction: column
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards
        }

        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 10% auto;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none
            }

            50% {
                transform: scale3d(1.1, 1.1, 1)
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142
            }
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #d57d3d;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #d57d3d;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .dropdown.bootstrap-select {
            width: 100% !important;
        }

        .container {
    max-width: 400px;
    margin: 0 auto;
}

.card {
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
}

.btn-rounded {
    border-radius: 20px;
    padding: 5px 15px;
    font-size: 14px;
}

.form-group label {
    font-weight: bold;
    color: #666;
}

.form-control {
    width: 100%;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 10px;
    font-size: 14px;
}

#parameters-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.parameter-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.parameter-input {
    flex: 2;
}

.color-input {
    width: 50px;
    height: 38px;
}

.add-btn, .remove-btn {
    width: 38px;
    height: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    border: none;
    border-radius: 5px;
}

.add-btn {
    background-color: #28a745;
    color: white;
}

.remove-btn {
    background-color: #dc3545;
    color: white;
}

.save-btn {
    width: 25%;
    padding: 10px;
    font-size: 16px;
    border: none;
    background-color: #d57d3d;
    color: white;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

    .save-btn-div{
        display: flex;
        justify-content: flex-end;
        padding-top: 10px;
    }

.save-btn:hover {
    background-color: #bf6a33;
}



    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $title }}</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-10 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                    <a href="{{ route('admin.metrics.list') }}" class="btn btn-rounded btn-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form id="metricForm">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            <small id="nameError" class="text-danger"></small> <!-- For displaying name validation error -->
                        </div>

                        <div id="parameters-container">
                            <div class="parameter-row">
                                <label>Parameter</label>
                                <input type="text" name="parameter[]" class="form-control parameter-input" placeholder="Parameter">
                                <label>Color</label>
                                <input type="color" name="color[]" class="form-control color-input">
                                <button type="button" class="btn btn-success add-btn">+</button>
                                <button type="button" class="btn btn-danger remove-btn">x</button>
                            </div>
                        </div>

                        <div class="save-btn-div">
                            <button type="submit" class="btn save-btn">Save</button>
                        </div>
                    </form>
                    <div id="successMessage" class="alert alert-success d-none">Metric saved successfully!</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('metricForm');
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            const parametersContainer = document.getElementById('parameters-container');

            // Add new row for parameters
            const addRow = () => {
                const newRow = document.createElement('div');
                newRow.classList.add('parameter-row');
                newRow.innerHTML = `
                    <label>Parameter</label>
                    <input type="text" name="parameter[]" class="form-control parameter-input" placeholder="Parameter" required>
                    <label>Color</label>
                    <input type="color" name="color[]" class="form-control color-input">
                    <button type="button" class="btn btn-success add-btn">+</button>
                    <button type="button" class="btn btn-danger remove-btn">x</button>
                `;
                parametersContainer.appendChild(newRow);
            };

            // Handle add/remove parameter rows
            parametersContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('add-btn')) {
                    addRow();
                } else if (e.target.classList.contains('remove-btn')) {
                    const row = e.target.closest('.parameter-row');
                    if (parametersContainer.children.length > 1) {
                        row.remove();
                    }
                }
            });

            // Validate form before AJAX submission
            const validateForm = () => {
                let valid = true;

                // Check the 'name' field
                if (nameInput.value.trim() === '') {
                    nameError.textContent = 'The name field is required.';
                    nameInput.classList.add('is-invalid'); // Add red border
                    valid = false;
                } else {
                    nameError.textContent = '';
                    nameInput.classList.remove('is-invalid'); // Remove red border if valid
                }

                // Check parameter rows
                const parameterRows = parametersContainer.querySelectorAll('.parameter-row');
                parameterRows.forEach(row => {
                    const parameterInput = row.querySelector('.parameter-input');

                    // Remove empty parameter rows or show red border if only one row is present
                    if (parameterInput.value.trim() === '') {
                        if (parametersContainer.children.length > 1) {
                            row.remove();
                        } else {
                            parameterInput.classList.add('is-invalid'); // Add red border for single empty row
                            valid = false;
                        }
                    } else {
                        parameterInput.classList.remove('is-invalid'); // Remove red border if valid
                    }
                });

                return valid;
            };

            // Handle form submission via AJAX
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Validate form
                if (!validateForm()) {
                    return;
                }

                // Clear previous error messages
                nameError.textContent = '';

                const formData = new FormData(form);

                fetch("{{ route('admin.metrics.save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (response.status === 422) {
                        // Validation error handling
                        return response.json().then(data => {
                            if (data.errors && data.errors.name) {
                                nameError.textContent = data.errors.name[0];
                                nameInput.classList.add('is-invalid'); // Show red border for server-side error
                            }
                        });
                    } else if (response.ok) {
                        // Successful response
                        return response.json();
                    }
                    throw new Error('Unexpected response');
                })
                .then(data => {
                    if (data && data.status === 200) {
                        // Redirect to the provided URL only, no success message
                        window.location.href = data.redirect_url;
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection









