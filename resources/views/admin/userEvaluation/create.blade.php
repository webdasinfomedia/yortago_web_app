<style>
    .metric-fields {
        padding: 10px;
        border: 1px solid #00000057;
        border-radius: 6px;
    }

    .metrics {
    margin: 10px;
    display: flex;
    justify-content: space-between;
    align-items: start;
    gap: 10px;
}

    /* Added CSS for the new design */
    .trial-container {
        margin: 0 auto;
        padding: 5px;
    }

    .trial-section {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background-color: #f5f5f5;
    }

    .trial-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #d47637;
        color: white;
        padding: 10px;
        border-radius: 8px 8px 0 0;
    }

    .trial-header span {
        font-weight: bold;
    }

    .trial-header em {
        font-style: italic;
    }

    .trial-select {
        font-size: 16px;
        padding: 5px;
        border: none;
        border-radius: 4px;
        background-color: white;
        color: #333;
    }

    .trial-inputs {
        padding: 10px;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .trial-input {
        display: none;
        margin-top: 10px;
    }

    .trial-input label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .trial-input input {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .error {
        border: 2px solid red;
    }
    .error-message {
    color: red;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

</style>

<div>
    <div class="metrics">
        <div>
            <form id="all-parameters-form">
                <!-- Parameters will be dynamically added here -->
                <select id="metricDropdown" class="form-select form-select-lg mb-3 metric-fields" aria-label=".form-select-lg example">
                <option selected>Open this select menu</option>
                @foreach($metrics as $item)
                    <option value="{{$item->id}}">{{ $item->name }}</option>
                @endforeach
            </select>
                <input class="metric-fields" type="date">
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" id="metric_id" name="metric_id">

            </form>
            
       
        </div>
        <div>
        <button type="submit"  id="saveAllButton" class="btn btn-primary btn-md save-btn" form="all-parameters-form" disabled>Save All</button>
            
        </div>
        </div>
        
       

        
    </div>
    @include('admin.userEvaluation.parameters')

</div>

<script>

    // let id;
    $(document).ready(function() {
        var url = window.location.pathname;
        var parts = url.split('/'); // Split the URL by '/'
        var id = parts[parts.length - 1]; // Get the last part (the ID)
    $('#user_id').val(id)
    console.log(id); // Output the ID
});

    document.getElementById('metricDropdown').addEventListener('change', function() {
        const selectedMetricId = this.value;
        console.log(selectedMetricId);
        $('#metric_id').val(selectedMetricId);
        loadParameters(selectedMetricId);
    });

    document.addEventListener("DOMContentLoaded", function() {
        const firstMetricId = document.getElementById('metricDropdown').value;
        if (firstMetricId) {
            loadParameters(firstMetricId);
        }
    });
</script>

<!-- <script>
    function showTrials(select, containerId) {
        const selectedValue = parseInt(select.value); // Get selected value (integer)
        const container = document.getElementById(containerId); // Get the input container
        const trialInputs = container.querySelectorAll('.trial-input'); // Get all the trial input fields
        
        // Show or hide input fields based on selected value
        trialInputs.forEach((input, index) => {
            if (index < selectedValue) {
                input.style.display = 'block'; // Show trial input
            } else {
                input.style.display = 'none'; // Hide trial input
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Find all the trial select dropdowns
        document.querySelectorAll('.trial-select').forEach(select => {
            select.value = 3; // Set the dropdown value to 3

            // Call the showTrials function immediately after setting the value to 3
            const containerId = select.closest('.trial-section').querySelector('.trial-inputs').id; // Find the associated input container
            showTrials(select, containerId); // Show the correct number of trial inputs
        });
    });
</script> -->


