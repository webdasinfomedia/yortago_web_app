<!-- resources/views/parameters/index.blade.php -->
<div class="paramters">
    <div class="trial-container" id="parametersContainer">
        <div class="parameter-form">
           
        </div>
        <!-- Save button inside the dynamic parameters section, but within the container -->
      
    </div>
      
</div>

<script>
    // Use event delegation for dynamic elements
    $(document).on('change', '#metricDropdown', function () {
        const metricId = this.value;
        document.getElementById('metric_id').value = metricId;  // Set metric_id

        // Enable the "Save All" button if a valid metric is selected
        $('#saveAllButton').prop('disabled', !metricId);

        loadParameters(metricId);
    });

    function loadParameters(metricId) {
        if (metricId) {
            $.ajax({
                url: '/admin/get-parameters/' + metricId,
                method: 'GET',
                success: function (data) {
                    $('#all-parameters-form .trial-section').remove();

                    if (data.length > 0) {
                        data.forEach(function (parameter) {
                            const parameterHTML =
                                `<div class="trial-section">
                                    <div class="trial-header">
                                        <span>${parameter.name} <em>*${parameter.description || 'No description'}</em></span>
                                        <select class="trial-select" onchange="showTrials(this, 'trial-inputs-${parameter.id}')">
                                            <option value="3">3</option>
                                            <option value="2">2</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                    <div class="trial-inputs" id="trial-inputs-${parameter.id}">
                                        <div class="trial-input">
                                            <label>Trial 1</label>
                                            <input type="number" id="trial_1_${parameter.id}" name="trial_1_${parameter.id}" placeholder="First Trial">
                                        </div>
                                        <div class="trial-input">
                                            <label>Trial 2</label>
                                            <input type="number" id="trial_2_${parameter.id}" name="trial_2_${parameter.id}" placeholder="Second Trial">
                                        </div>
                                        <div class="trial-input">
                                            <label>Trial 3</label>
                                            <input type="number" id="trial_3_${parameter.id}" name="trial_3_${parameter.id}" placeholder="Third Trial">
                                        </div>
                                    </div>
                                </div>`;
                            $('#all-parameters-form').append(parameterHTML);
                        });

                        document.querySelectorAll('.trial-select').forEach(select => {
                            const containerId = select.closest('.trial-section').querySelector('.trial-inputs').id;
                            showTrials(select, containerId);
                        });
                    } else {
                        $('#parametersContainer').html('No parameters found for this metric.');
                    }
                }
            });
        } else {
            $('#all-parameters-form .trial-section').remove();
        }
    }

    function showTrials(select, containerId) {
        const selectedValue = parseInt(select.value);
        const container = document.getElementById(containerId);
        const trialInputs = container.querySelectorAll('.trial-input');

        trialInputs.forEach((input, index) => {
            input.style.display = index < selectedValue ? 'block' : 'none';
        });
    }

    $(document).on('submit', '#all-parameters-form', function (e) {
    e.preventDefault(); // Prevent form submission

    let valid = true; // Validation flag

    // Remove all previous error messages
    $('.error-message').remove();

    // Validate all visible trial inputs
    $('.trial-input:visible input').each(function () {
        if (!$(this).val()) { // Check if the input is empty
            valid = false;
            $(this).addClass('error'); // Highlight the field with red border

            // Show error message if not already present
            if (!$(this).next('.error-message').length) {
                $(this).after('<span class="error-message">This field is required.</span>');
            }
        } else {
            $(this).removeClass('error'); // Remove highlight if filled
            $(this).next('.error-message').remove(); // Remove the error message if valid
        }
    });

    // Clear validation for hidden fields
    $('.trial-input:hidden input').each(function () {
        $(this).removeClass('error'); // Remove error class
        $(this).next('.error-message').remove(); // Remove any error message
    });

    if (!valid) {
        return; // Stop submission if there are errors
    }

    const allParametersData = [];
    const userId = $('#user_id').val();
    const metricId = $('#metric_id').val();
    const date = $('input[type="date"]').val();

    // Collect data for each parameter
    $('#all-parameters-form .trial-section').each(function () {
        const parameterId = $(this).find('.trial-inputs').attr('id').split('-')[2];
        const trial_1 = $(`#trial_1_${parameterId}`).val() || '';
        const trial_2 = $(`#trial_2_${parameterId}`).val() || '';
        const trial_3 = $(`#trial_3_${parameterId}`).val() || '';

        allParametersData.push({ trial_1, trial_2, trial_3, parameter_id: parameterId });
    });

    const finalData = { user_id: userId, metric_id: metricId, date, parameters: allParametersData };

    // Submit the form via AJAX
    $.ajax({
        url: '/admin/user_evaluation/save',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: JSON.stringify(finalData),
        contentType: 'application/json',
        success: function (response) {
           if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = '/admin/live-stream/users/list';
                });
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});


    // Allow only numbers in trial input fields
    $(document).on('input', '.trial-input input', function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    // $(document).on('submit', '#all-parameters-form', function (e) {
    //     e.preventDefault(); // Prevent form submission

    //     let valid = true; // Validation flag

    //     // Remove all previous error messages
    //     $('.error-message').remove();

    //     // Validate all visible trial inputs
    //     $('.trial-input:visible input').each(function () {
    //         if (!$(this).val()) { // Check if the input is empty
    //             valid = false;
    //             $(this).addClass('error'); // Highlight the field with red border

    //             // Show error message if not already present
    //             if (!$(this).next('.error-message').length) {
    //                 $(this).after('<span class="error-message">This field is required.</span>');
    //             }
    //         } else {
    //             $(this).removeClass('error'); // Remove highlight if filled
    //             $(this).next('.error-message').remove(); // Remove the error message if valid
    //         }
    //     });

    //     // Additional validation: Check specifically for trial_3_ fields
    //     $('#all-parameters-form .trial-section').each(function () {
    //         const parameterId = $(this).find('.trial-inputs').attr('id').split('-')[2];
    //         const trial_3 = $(`#trial_3_${parameterId}`).val(); // Get trial_3 value

    //         if (!trial_3) { // If trial_3 is empty
    //             valid = false;
    //             const trial3Input = $(`#trial_3_${parameterId}`);
    //             trial3Input.addClass('error'); // Highlight trial_3 field

    //             // Show error message if not already present
    //             if (!trial3Input.next('.error-message').length) {
    //                 trial3Input.after('<span class="error-message">Trial 3 is required.</span>');
    //             }
    //         } else {
    //             $(`#trial_3_${parameterId}`).removeClass('error'); // Remove error class
    //             $(`#trial_3_${parameterId}`).next('.error-message').remove(); // Remove the error message if valid
    //         }
    //     });

    //     if (!valid) {
    //         return; // Stop submission if there are errors
    //     }

    //     const allParametersData = [];
    //     const userId = $('#user_id').val();
    //     const metricId = $('#metric_id').val();
    //     const date = $('input[type="date"]').val();

    //     // Collect data for each parameter
    //     $('#all-parameters-form .trial-section').each(function () {
    //         const parameterId = $(this).find('.trial-inputs').attr('id').split('-')[2];
    //         const trial_1 = $(`#trial_1_${parameterId}`).val() || '';
    //         const trial_2 = $(`#trial_2_${parameterId}`).val() || '';
    //         const trial_3 = $(`#trial_3_${parameterId}`).val() || '';

    //         allParametersData.push({ trial_1, trial_2, trial_3, parameter_id: parameterId });
    //     });

    //     const finalData = { user_id: userId, metric_id: metricId, date, parameters: allParametersData };

    //     // Submit the form via AJAX
    //     $.ajax({
    //         url: '/admin/user_evaluation/save',
    //         method: 'POST',
    //         headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    //         data: JSON.stringify(finalData),
    //         contentType: 'application/json',
    //         success: function (response) {
    //             console.log(response);
    //             window.location.href = '/admin/live-stream/users/list';
    //         },
    //         error: function (error) {
    //             console.log(error);
    //         }
    //     });
    // });



    // Validate input fields and submit form
    // $(document).on('submit', '#all-parameters-form', function (e) {
    //     e.preventDefault();

    //     let valid = true;

    //     $('.trial-input:visible input').each(function () {
    //         if (!$(this).val()) {
    //             valid = false;
    //             $(this).addClass('error'); // Highlight the field with red border
    //         } else {
    //             $(this).removeClass('error'); // Remove highlight if filled
    //         }
    //     });

    //     if (!valid) {
    //         return; // Stop submission if there are errors
    //     }

    //     const allParametersData = [];
    //     const userId = $('#user_id').val();
    //     const metricId = $('#metric_id').val();
    //     const date = $('input[type="date"]').val();

    //     $('#all-parameters-form .trial-section').each(function (index) {
    //         const parameterId = $(this).find('.trial-inputs').attr('id').split('-')[2];
    //         const trial_1 = $(`#trial_1_${parameterId}`).val() || '';
    //         const trial_2 = $(`#trial_2_${parameterId}`).val() || '';
    //         const trial_3 = $(`#trial_3_${parameterId}`).val() || '';

    //         allParametersData.push({ trial_1, trial_2, trial_3, parameter_id: parameterId });
    //     });

    //     const finalData = { user_id: userId, metric_id: metricId, date, parameters: allParametersData };

    //     $.ajax({
    //         url: '/admin/user_evaluation/save',
    //         method: 'POST',
    //         headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    //         data: JSON.stringify(finalData),
    //         contentType: 'application/json',
    //         success: function (response) {
    //             console.log(response);
    //             window.location.href = '/admin/live-stream/users/list';
    //         },
    //         error: function (error) {
    //             console.log(error);
    //         }
    //     });
    // });
</script>
<style>
    .error {
        border: 2px solid red;
    }
</style>








