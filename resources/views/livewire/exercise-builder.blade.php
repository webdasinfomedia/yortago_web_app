<div>
    <div class="container-fluid">
        <style>
               .week-day-sidebar {
                background: #ffffff;
                border: 1px solid #dee2e6;
                min-height: 80vh;
                padding: 15px;
            }

            .week-card {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 10px;
                overflow: hidden;
            }

            .week-header {
                background: #fff;
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
                cursor: pointer;
                transition: all 0.3s ease;
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .week-header:hover {
                background: #f8f9fa;
            }

            .week-header.active {
                background: linear-gradient(to right, #fff0e2ff, #ffdfccff);
                border-left: 4px solid #ff6600ff;
                font-weight: 600;
            }

            .week-header-content {
                display: flex;
                align-items: center;
                flex: 1;
            }

            .week-actions {
                display: flex;
                gap: 5px;
                flex-shrink: 0;
            }

            .day-item {
                padding: 10px 15px;
                border-bottom: 1px solid #f1f1f1;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .day-item:hover {
                background: #f8f9fa;
            }

            .day-item.active {
                background: #d4edda;
                border-left: 3px solid #28a745;
                font-weight: 600;
            }

            .day-item:last-child {
                border-bottom: none;
            }

            .exercise-card {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 15px;
                overflow: hidden;
            }

            .exercise-header {
                background: #ffffff;
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
            }

            .btn-action {
                font-size: 19px;
                padding: 0px 7px;
                margin-left: 5px;
            }

            .btn-primary-custom {
                background: linear-gradient(to right, #d38d49, #d76e33);
                border-color: #d76e33;
                color: white;
            }

            .btn-warning-custom {
                background: linear-gradient(to right, #d38d49, #d76e33); 
                border-color: #d76e33;
                color: white;
            }
            
            .main-div{
                background-color: #FDF9F6 !important;
                border: 1px solid #D2D2d2 !important;
                border-radius: 10px !important;
                padding: 15px 12px 15px 25px !important;
            }

            .btn-success-custom {
                background: #28a745;
                border-color: #28a745;
                color: white;
            }

            .btn-danger-custom {
                background: #ff4255ee;
                color: white;
                border: none;
            }

            .form-control-sm {
                font-size: 0.675rem;
                height: 30px;
            }
            
            .form-control{
                font-size: 14px !important;
            }
            
            .form-label {
                font-size: 14px;
            }

            .modal-backdrop {
                z-index: 1040;
            }

            .modal {
                z-index: 1050;
            }

            .exercise-content {
                padding: 20px;
                border:1px solid #dee2e6; 
                background: #ffffff;
            }
            
            .programname{
                font-weight: 600;
                font-size: 20px;
                color:#333333;
            }

            .day-actions {
                display: flex;
                gap: 5px;
            }
            
            .add-day-btn{
                font-size: 14px;
                cursor: pointer !important;
            }
            
            .accordion-arrow {
                transition: transform 0.2s ease;
                margin-right: 8px;
            }
            
            .accordion-arrow.rotated {
                transform: rotate(90deg);
            }
            
            .left-sidebar-title{
                font-size: 18px;
                font-weight: 600;
            }

            .week-header, .exercise-header {
                user-select: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
            }
            
            .exercise-errors, .exercise-alert{
                color: red;
                background-color: white;
                border: none;
            }
            
            .exercise-card {
                position: relative;
                overflow: visible !important; /* Allow dropdown to show */
            }

            .exercise-card .card-body {
                position: relative;
                overflow: visible !important;
            }

            .select2-container {
                z-index: 999 !important;
            }

            .select2-dropdown {
                z-index: 1000 !important;
                border: 1px solid #dee2e6 !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
            }

            /* Ensure dropdown stays within exercise card bounds */
            .select2-container--open .select2-dropdown--below {
                border-top: 1px solid #dee2e6 !important;
                max-height: 300px;
            }

            .select2-results__options {
                max-height: 250px !important;
                overflow-y: auto !important;
            }

            /* Fix for dropdown width */
            .select2-dropdown--below, .select2-dropdown--above {
                width: auto !important;
                min-width: 100% !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #333333 !important;
            }
            
            .select2-container .select2-selection--single{
                border-radius: 0;
                background: #fff;
                border: 1px solid #f0f1f5;
                color: #333333;
                font-size: 14px;
                font-family: 'poppins', sans-serif;
            }
            
            .select2-container--default .select2-selection--single .select2-selection__rendered{
                color:#333333 !important;
                line-height: 30px !important;
                font-size: 14px !important;
            }
            .select2-container--open .select2-dropdown--below {
                border-top: none;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            .select2-container--default.select2-container--open.select2-container--above .select2-selection--single {
                border-top-left-radius: 0.25rem;
                border-top-right-radius: 0.25rem;
            }
            
            .select2-container--default .select2-selection--single .select2-selection__clear{
                height: 30px !important;
                font-size: 14px !important;
            }
            
            .select2-container--default .select2-selection--single .select2-selection__arrow{
                height: 30px !important;
                font-size: 14px !important;
            }
            
            .card-body {
                flex: 1 1 auto;
                min-height: 1px;
                padding: 0.75rem !important;
            }

            .exercise-errors {
                min-height: 0;
                transition: min-height 0.2s ease;
            }

            .exercise-errors .exercise-alert {
                display: none;
                margin-bottom: 5px;
            }

            .exercise-errors .exercise-alert.has-errors {
                display: block;
            }

            .exercise-errors-container, .alternate-errors-container{
                min-height: 20px;
            }

            .alternate-alert {
                color: red;
                background-color: white;
                border: none;
                display: none;
                margin-bottom: 5px;
            }

            .alternate-alert.has-errors {
                display: block;
            }

            .alternate-error-list {
                list-style-type: disc;
                padding-left: 20px;
                margin: 0;
            }

            .alternate-error-list li {
                font-size: 14px;
                color: #dc3545;
            }

            .text-muted, .text-info{
                font-size: 14px;
            }
            
            .text-muted{
                color:#333333 !important;
            }
            
            .modal-title{
                font-size: 18px;
                color:#333333 !important;
            }
            
            .btn:hover {
                color: white;
                text-decoration: underline !important;
            }
            
            .select2-container--default .select2-results>.select2-results__options{
                font-size: 14px !important;
            }
            
            .select2-container--default .select2-search--dropdown .select2-search__field {
                color: #333333;
                border: 1px solid #aaa;
                font-size: 14px;
            }
            
            .btn-primary:hover, .btn-primary:focus, .btn-primary.focus{
                color: white !important;
            }
            
            .border-primary{
                box-shadow: none !important;
                border: none !important;
            }
           
        </style>

        <!-- Day Title Modal -->
        @if($showTitleModal)
            <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Day Title</h5>
                            <button type="button" class="close" wire:click="closeTitleModal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveDayTitle">
                                <div class="form-group">
                                    <label for="dayTitle">Day Title *</label>
                                    <input type="text" 
                                        class="form-control @error('dayTitle') is-invalid @enderror" 
                                        id="dayTitle" 
                                        wire:model="dayTitle" 
                                        placeholder="Enter Day Title..."
                                        required>
                                    @error('dayTitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="daySummary">Summary</label>
                                    <textarea class="form-control @error('daySummary') is-invalid @enderror" 
                                            id="daySummary" 
                                            wire:model="daySummary" 
                                            rows="3"
                                            placeholder="Enter Day Summary..."></textarea>
                                    @error('daySummary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="dayDuration">Duration(min)</label>
                                    <input type="text" 
                                        class="form-control @error('dayDuration') is-invalid @enderror" 
                                        id="dayDuration" 
                                        wire:model="dayDuration" 
                                        placeholder="Enter Day Duration...">
                                    @error('dayDuration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeTitleModal">Cancel</button>
                            <button type="button" class="btn btn-primary" wire:click="saveDayTitle">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>

<script>
    // Store accordion states - only track which ONE is open
    let activeAccordionId = null;
    let eventListenersAttached = false;

    // Select2 initialization
    function initializeSelect2() {
        if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
            console.warn('jQuery or Select2 not loaded');
            return;
        }

        // Destroy all existing instances first
        $('.searchable-select').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                try {
                    $(this).select2('destroy');
                } catch (e) {
                    console.warn('Error destroying Select2:', e);
                }
            }
        });

        // Remove existing event listeners
        $('.searchable-select').off('change.select2Custom');

        // Initialize Select2 with proper containment
        try {
            $('.searchable-select').each(function() {
                const $this = $(this);
                const $exerciseCard = $this.closest('.exercise-card');
                
                // Use the exercise card as dropdown parent to keep dropdown inside
                const dropdownParent = $exerciseCard.length > 0 ? $exerciseCard : $this.parent();
                
                $this.select2({
                    placeholder: "-Select Exercise-",
                    allowClear: true,
                    width: '100%',
                    dropdownAutoWidth: true,
                    dropdownParent: dropdownParent,
                    dropdownCssClass: 'select2-dropdown-fixed',
                    dropdownPosition: 'below', // Force dropdown below
                    // FIXED: Add this to prevent dropdown from going outside
                    containerCssClass: 'select2-container-fixed'
                });
            });
        } catch (e) {
            console.error('Error initializing Select2:', e);
            return;
        }

        // Attach change handler with namespace
        $('.searchable-select').on('change.select2Custom', function(e) {
            e.stopPropagation();
            
            const value = $(this).val();
            const $exerciseCard = $(this).closest('.exercise-card');
            
            if ($exerciseCard.length === 0) return;
            
            const $exerciseBody = $exerciseCard.find('[id^="exerciseBody"]');
            if ($exerciseBody.length === 0) return;
            
            const exerciseId = $exerciseBody.attr('id').replace('exerciseBody', '');
            
            try {
                if (typeof Livewire !== 'undefined' && window.Livewire) {
                    @this.call('updateExercise', exerciseId, 'exercise_list_id', value);
                }
            } catch (error) {
                console.error('Error calling Livewire method:', error);
            }
        });
    }

    function initializeApp() {
        if (!eventListenersAttached) {
            // Success message listener
            window.addEventListener('show-success', event => {
                if (typeof toastr !== 'undefined') {
                    toastr.success(event.detail.message);
                } else {
                    alert('Success: ' + event.detail.message);
                }
            });

            // Error message listener
            window.addEventListener('show-error', event => {
                if (typeof toastr !== 'undefined') {
                    toastr.error(event.detail.message);
                } else {
                    alert('Error: ' + event.detail.message);
                }
            });

            // Reinitialize Select2 after Livewire updates
            window.addEventListener('reinit-select2', () => {
                setTimeout(() => initializeSelect2(), 100);
            });

             // Listen for sync-week-accordion event
            window.addEventListener('sync-week-accordion', event => {
                const weekId = event.detail.weekId;
                
                if (weekId) {
                    closeAllAccordions();
                    openAccordion(weekId);
                    activeAccordionId = weekId;
                } else {
                    closeAllAccordions();
                    activeAccordionId = null;
                }
            });

            // Listen for jump-to-week event (for new week)
            window.addEventListener('jump-to-week', event => {
                const weekId = event.detail.weekId;
                
                setTimeout(() => {
                    closeAllAccordions();
                    openAccordion(weekId);
                    activeAccordionId = weekId;
                    
                    // Scroll to the new week
                    const weekElement = document.querySelector(`[onclick*="toggleAccordion(${weekId}"]`);
                    if (weekElement) {
                        weekElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                }, 100);
            });

            // Listen for weight visibility updates from Livewire
            window.addEventListener('update-weight-visibility', event => {
                const { exerciseId, weight } = event.detail;
                const weightDiv = document.getElementById('weightValueDiv' + exerciseId);
                
                if (weightDiv) {
                    weightDiv.style.display = weight === 'Yes' ? 'block' : 'none';
                }
            });

            window.addEventListener('update-weight-select', event => {
                const { exerciseId, weight } = event.detail;
                const weightSelect = document.getElementById('exerciseWeight' + exerciseId);
                
                if (weightSelect) {
                    // Update the select element value
                    weightSelect.value = weight;
                    
                    // Also update the weight value div visibility
                    const weightDiv = document.getElementById('weightValueDiv' + exerciseId);
                    if (weightDiv) {
                        weightDiv.style.display = (weight === 'Yes') ? 'block' : 'none';
                    }
                }
            });

           window.addEventListener('update-alternate-weight-visibility', event => {
                const { alternateId, weight } = event.detail;
                //console.log('Received alternate weight visibility event:', alternateId, weight);
                
                const weightDiv = document.getElementById('altWeightValueDiv' + alternateId);
                const weightSelect = document.getElementById('altWeight' + alternateId);
                
                if (weightDiv) {
                    weightDiv.style.display = weight === 'Yes' ? 'block' : 'none';
                    //console.log('Updated weight div visibility to:', weight === 'Yes' ? 'block' : 'none');
                }
                
                // IMPORTANT: Also update the select value to ensure consistency
                if (weightSelect) {
                    weightSelect.value = weight;
                }
            });

            eventListenersAttached = true;
        }

        // Initialize Select2 with delay
        setTimeout(() => {
            initializeSelect2();
        }, 150);
        
         // Initialize accordion state from backend
        initAccordionState();
        
        // Attach weight handlers
        attachWeightHandlers();
        // Attach validation
        attachValidation();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeApp();
    });

    function initAccordionState() {
        // Get the active accordion from backend via Livewire component
        const activeWeekId = @json($activeWeekAccordion);
        if (activeWeekId) {
            activeAccordionId = activeWeekId;
            openAccordion(activeWeekId);
        }
    }

    // Simple toggle function - ensures only ONE accordion open at a time
    function toggleAccordion(weekId, event) {
        // Prevent if clicking on buttons
        if (event && (event.target.closest('.week-actions') || event.target.closest('button'))) {
            return;
        }

        const accordion = document.getElementById('weekDays' + weekId);
        const arrow = document.getElementById('arrow' + weekId);
        
        if (!accordion || !arrow) return;

        // If clicking on already open accordion, close it
        if (activeAccordionId === weekId) {
            closeAccordion(weekId);
            activeAccordionId = null;
            if (typeof Livewire !== 'undefined' && window.Livewire && typeof @this !== 'undefined') {
                @this.set('activeWeekAccordion', null);
            }
        } else {
            // Close all accordions first
            closeAllAccordions();
            
            // Open the clicked accordion
            openAccordion(weekId);
            activeAccordionId = weekId;
            if (typeof Livewire !== 'undefined' && window.Livewire && typeof @this !== 'undefined') {
                @this.set('activeWeekAccordion', weekId);
            }
        }
    }

    function openAccordion(weekId) {
        const accordion = document.getElementById('weekDays' + weekId);
        const arrow = document.getElementById('arrow' + weekId);
        
        if (accordion && arrow) {
            accordion.style.display = 'block';
            arrow.classList.add('rotated');
        }
    }

    function closeAccordion(weekId) {
        const accordion = document.getElementById('weekDays' + weekId);
        const arrow = document.getElementById('arrow' + weekId);
        
        if (accordion && arrow) {
            accordion.style.display = 'none';
            arrow.classList.remove('rotated');
        }
    }

    function closeAllAccordions() {
        document.querySelectorAll('[id^="weekDays"]').forEach(acc => {
            acc.style.display = 'none';
            const weekId = acc.id.replace('weekDays', '');
            const arrow = document.getElementById('arrow' + weekId);
            if (arrow) arrow.classList.remove('rotated');
        });
    }

    // Custom exercise accordion
    function toggleAccordionExercise(exerciseId, event) {
        if (event && (event.target.closest('button') || event.target.tagName === 'BUTTON')) {
            return;
        }

        const body = document.getElementById('exerciseBody' + exerciseId);
        const arrow = document.getElementById('exerciseArrow' + exerciseId);

        if (!body) return;

        if (body.style.display === 'none' || body.style.display === '') {
            body.style.display = 'block';
            if (arrow) arrow.classList.add('rotated');
        } else {
            body.style.display = 'none';
            if (arrow) arrow.classList.remove('rotated');
        }
    }

    // Restore accordion state after Livewire updates
    function restoreAccordionState() {
        if (activeAccordionId) {
            closeAllAccordions();
            openAccordion(activeAccordionId);
        }
        setTimeout(() => {
            initializeSelect2();
        }, 100);
    }

    // Listen for Livewire updates
    document.addEventListener('livewire:update', function () {
        setTimeout(() => {
            restoreAccordionState();
            attachWeightHandlers();
            attachValidation();
            initializeSelect2();
        }, 50);
    });

    document.addEventListener('livewire:updated', function () {
        setTimeout(() => {
            restoreAccordionState();
            attachWeightHandlers();
            attachValidation();
            initializeSelect2();
        }, 50);
    });

    // Global validation function for main exercises
    function validateField(input) {
        const value = input.value.trim();
        let error = "";

        if (value === "") {
            error = `${capitalize(input.name)} is required.`;
        } else if (isNaN(value) || parseInt(value) <= 0) {
            error = `${capitalize(input.name)} must be a number greater than 0.`;
        } else if (parseInt(value) > 999) {
            error = `${capitalize(input.name)} cannot exceed 3 digits value.`;
        }

        const exerciseCard = input.closest(".exercise-card");
        const errorList = exerciseCard.querySelector(".exercise-error-list");
        const errorContainer = errorList.parentElement;

        if (error) {
            input.classList.add("is-invalid");
            input.value = "";

            let li = errorList.querySelector(`li[data-field="${input.name}"]`);
            if (!li) {
                li = document.createElement("li");
                li.setAttribute("data-field", input.name);
                errorList.appendChild(li);
            }
            li.textContent = error;

            errorContainer.classList.add('has-errors');
            errorContainer.style.display = "block";

            if (input.dataset.timeoutId) {
                clearTimeout(parseInt(input.dataset.timeoutId));
            }

            const timeoutId = setTimeout(() => {
                input.classList.remove("is-invalid");
                let li = errorList.querySelector(`li[data-field="${input.name}"]`);
                if (li) li.remove();

                if (errorList.children.length === 0) {
                    errorContainer.classList.remove('has-errors');
                    errorContainer.style.display = 'none';
                }
                
                delete input.dataset.timeoutId;
            }, 10000);

            input.dataset.timeoutId = timeoutId;
        } else {
            input.classList.remove("is-invalid");

            if (input.dataset.timeoutId) {
                clearTimeout(parseInt(input.dataset.timeoutId));
                delete input.dataset.timeoutId;
            }

            let li = errorList.querySelector(`li[data-field="${input.name}"]`);
            if (li) li.remove();

            if (errorList.children.length === 0) {
                errorContainer.classList.remove('has-errors');
                errorContainer.style.display = 'none';
            }
        }
    }

    // Validation function for alternate exercises
    function validateAlternateField(input) {
        const value = input.value.trim();
        let error = "";

        if (value === "") {
            error = `${capitalize(input.name.replace('alt_', '').replace(/_\d+$/, ''))} is required.`;
        } else if (isNaN(value) || parseInt(value) <= 0) {
            error = `${capitalize(input.name.replace('alt_', '').replace(/_\d+$/, ''))} must be a number greater than 0.`;
        } else if (parseInt(value) > 999) {
            error = `${capitalize(input.name.replace('alt_', '').replace(/_\d+$/, ''))} cannot exceed 3 digits value.`;
        }

        // Find the alternate card (not exercise-card)
        const alternateCard = input.closest(".card.border-primary");
        if (!alternateCard) return;

        const errorList = alternateCard.querySelector(".alternate-error-list");
        const errorContainer = errorList ? errorList.parentElement : null;

        if (!errorContainer) return;

        if (error) {
            input.classList.add("is-invalid");
            input.value = "";

            let li = errorList.querySelector(`li[data-field="${input.name}"]`);
            if (!li) {
                li = document.createElement("li");
                li.setAttribute("data-field", input.name);
                errorList.appendChild(li);
            }
            li.textContent = error;

            errorContainer.classList.add('has-errors');
            errorContainer.style.display = "block";

            if (input.dataset.timeoutId) {
                clearTimeout(parseInt(input.dataset.timeoutId));
            }

            const timeoutId = setTimeout(() => {
                input.classList.remove("is-invalid");
                let li = errorList.querySelector(`li[data-field="${input.name}"]`);
                if (li) li.remove();

                if (errorList.children.length === 0) {
                    errorContainer.classList.remove('has-errors');
                    errorContainer.style.display = 'none';
                }
                
                delete input.dataset.timeoutId;
            }, 10000);

            input.dataset.timeoutId = timeoutId;
        } else {
            input.classList.remove("is-invalid");

            if (input.dataset.timeoutId) {
                clearTimeout(parseInt(input.dataset.timeoutId));
                delete input.dataset.timeoutId;
            }

            let li = errorList.querySelector(`li[data-field="${input.name}"]`);
            if (li) li.remove();

            if (errorList.children.length === 0) {
                errorContainer.classList.remove('has-errors');
                errorContainer.style.display = 'none';
            }
        }
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function attachValidation() {
        // Main exercise fields
        const fields = document.querySelectorAll(".exercise-field");
        fields.forEach(field => {
            if (!field.dataset.validationAttached) {
                field.addEventListener("blur", function () {
                    validateField(this);
                });
                field.dataset.validationAttached = "true";
            }
        });

        // Alternate exercise fields
        const alternateFields = document.querySelectorAll(".alternate-field");
        alternateFields.forEach(field => {
            if (!field.dataset.alternateValidationAttached) {
                field.addEventListener("blur", function () {
                    validateAlternateField(this);
                });
                field.dataset.alternateValidationAttached = "true";
            }
        });
    }

    // Weight field visibility handler
  function attachWeightHandlers() {
    // Regular exercises
    document.querySelectorAll('[id^="exerciseWeight"]').forEach(select => {
        const exerciseId = select.id.replace('exerciseWeight', '');
        const weightDiv = document.getElementById('weightValueDiv' + exerciseId);

        if (!weightDiv) return;

        // FIXED: Set initial visibility based on current value
        const currentValue = select.value;
        weightDiv.style.display = (currentValue === 'Yes') ? 'block' : 'none';

        // Remove old listener
        select.removeEventListener('change', select._weightChangeHandler || (() => {}));

        const handler = function() {
            const selectedValue = this.value;
            weightDiv.style.display = (selectedValue === 'Yes') ? 'block' : 'none';
        };

        select.addEventListener('change', handler);
        select._weightChangeHandler = handler;
    });

    
    document.querySelectorAll('[id^="altWeight"]').forEach(select => {
        // Extract the alternate ID from the select element's ID
        const altId = select.id.replace('altWeight', '');
        const weightDiv = document.getElementById('altWeightValueDiv' + altId);

        if (!weightDiv) {
            console.warn('Weight div not found for alternate:', altId);
            return;
        }

        // CRITICAL: Set initial visibility based on current SELECT value (not data attribute)
        const currentValue = select.value;
        console.log('Alternate', altId, 'current weight value:', currentValue);
        weightDiv.style.display = (currentValue === 'Yes') ? 'block' : 'none';

        // Remove old listener to prevent duplicates
        select.removeEventListener('change', select._altWeightChangeHandler || (() => {}));

        // Create new handler - This handles manual changes
        const handler = function() {
            const selectedValue = this.value;
            const weightValueDiv = document.getElementById('altWeightValueDiv' + altId);
            
            console.log('Alternate weight changed to:', selectedValue, 'for alt:', altId);
            
            if (weightValueDiv) {
                weightValueDiv.style.display = (selectedValue === 'Yes') ? 'block' : 'none';
            }
        };

        select.addEventListener('change', handler);
        select._altWeightChangeHandler = handler;
    });
}

    window.addEventListener('livewire:load', function () {
        initializeApp();
        
        if (typeof Livewire !== 'undefined' && Livewire.hook) {
            Livewire.hook('message.processed', (message, component) => {
                setTimeout(() => {
                    attachValidation();
                    attachWeightHandlers();
                    initializeSelect2();
                }, 100);
            });
        }
    });

    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    attachValidation();
                    attachWeightHandlers();
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1 && (node.classList.contains('exercise-card') || node.querySelector('.searchable-select'))) {
                            setTimeout(() => {
                                initializeSelect2();
                            }, 50);
                        }
                    });
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const targetNode = document.querySelector('.exercise-content');
            if (targetNode) {
                observer.observe(targetNode, {
                    childList: true,
                    subtree: true
                });
            }
        });
    }
</script>

    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="main-div ">
    <div class="d-flex justify-content-between align-items-center  mb-2">
        <div class="programname">Program Title : {{ ucfirst($this->exercise->title) }}</div>
        <a href="{{ route('admin.new.exercise.manage') }}" class="btn btn-rounded btn-secondary btn-sm">
            Back to Programs
        </a>
    </div>

    <div class="row">
        <!-- Left Sidebar: Weeks & Days -->
        <div class="col-md-4 week-day-sidebar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-primary mb-0 left-sidebar-title">Weeks & Days</h6>
                <div>
                    <!-- <button type="button" wire:click="ensureAllDaysHaveMinimumExercises" class="btn btn-info btn-sm mr-1" title="Ensure all days have 6 exercises">
                        <i class="fa fa-sync"></i> Fix All
                    </button> -->
                    <button type="button" wire:click="addWeek" class="btn btn-warning-custom btn-sm">
                        <i class="fa fa-plus"></i> Add Week
                    </button>
                </div>
            </div>

            <!-- Weeks List -->
            <div class="weeks-container">
                @foreach($weeks as $weekIndex => $week)
                    <div class="week-card" wire:key="week-{{ $week['id'] }}">
                        <!-- Week Header - FIXED VERSION -->
                        <!--<div class="week-header {{ $selectedWeekId === $week['id'] ? 'active' : '' }}"-->
                        <!--     onclick="toggleAccordion({{ $week['id'] }}, event); @this.selectWeek({{ $week['id'] }})">-->
                        
                        <!-- Week Header -->
                        <div class="week-header {{ $selectedWeekId === $week['id'] ? 'active' : '' }}"
                            onclick="event.stopPropagation(); toggleAccordion({{ $week['id'] }}, event);">
                            
                            <div class="week-header-content">
                                <i id="arrow{{ $week['id'] }}" 
                                class="fa fa-chevron-right accordion-arrow {{ $activeWeekAccordion === $week['id'] ? 'rotated' : '' }}"></i>
                                <i class="fa fa-calendar-week mr-2"></i>
                                <strong>Week {{ $week['number'] }}</strong>
                                <small class="text-muted ml-2">({{ count($week['days']) }} days)</small>
                            </div>
                            
                            <div class="week-actions" onclick="event.stopPropagation();">
                                @if(count($week['days']) < 7)
                                <button type="button" 
                                        wire:click.stop="addDay({{ $week['id'] }})" 
                                        class="btn btn-success-custom btn-action add-day-btn"
                                        title="Add Day">
                                    <i class="fa fa-plus"></i>
                                </button>
                                @endif
                                @if(count($weeks) > 1)
                                <button type="button"
                                        wire:click="deleteWeek({{ $week['id'] }})"
                                        wire:confirm="Are you sure you want to delete this week?"
                                        class="btn btn-danger-custom btn-action"
                                        title="Delete Week">
                                    <i class="fa fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        <!-- Week Days -->
                        <div id="weekDays{{ $week['id'] }}" 
                        style="display: {{ $activeWeekAccordion === $week['id'] ? 'block' : 'none' }};"
                        wire:ignore.self>
                        @foreach($week['days'] as $dayIndex => $day)
                        <div class="day-item {{ $selectedDayId === $day['id'] ? 'active' : '' }}"
                                wire:click="selectDay({{ $day['id'] }})"
                                wire:key="day-{{ $day['id'] }}">
                            
                            <div class="flex-grow-1" style="flex: 1;">
                               
                                <strong>Day {{ $day['number'] }}</strong>
                                <div class="small text-muted mt-1">
                                        
                                    {{ $day['title'] ?: 'Title Not Added' }}
                                </div>
                                @if($day['duration'])
                                    <div class="small text-info">
                                       </i>{{ $day['duration'] }} min
                                    </div>
                                @endif
                            </div>
                            
                            <div class="day-actions" onclick="event.stopPropagation();">
                                <button type="button"
                                        wire:click.stop="openTitleModal({{ $day['id'] }})" 
                                        class="btn btn-warning-custom btn-action"
                                        title="Edit Title">
                                    <i class="fa fa-edit"></i>
                                </button>
                                @if(count($week['days']) > 1)
                                <button type="button"
                                        wire:click="deleteDay({{ $day['id'] }})"
                                        wire:confirm="Are you sure you want to delete this day?"
                                        class="btn btn-danger-custom btn-action"
                                        title="Delete Day">
                                    <i class="fa fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Exercises -->
        <div class="col-md-8">
            <div class="exercise-content">
                @if($selectedDayId)
                    @php
                        $selectedDay = null;
                        $selectedWeek = null;
                        $selectedWeekNumber = null;
                        
                        foreach($weeks as $week) {
                            foreach($week['days'] as $day) {
                                if($day['id'] == $selectedDayId) {
                                    $selectedDay = $day;
                                    $selectedWeek = $week;
                                    $selectedWeekNumber = $week['number'];
                                    break 2;
                                }
                            }
                        }
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="text-primary mb-1">
                            Week {{ $selectedWeekNumber }} - {{ $selectedDay['title'] ?? 'Day Exercises' }}</h5>
                            @if($selectedDay['summary'])
                                <small class="text-muted">{{ $selectedDay['summary'] }}</small>
                            @endif
                        </div>
                    </div>

                    <!-- Exercises -->
                    @forelse($selectedDayExercises as $exerciseIndex => $exercise)
                       <div class="exercise-card" wire:key="exercise-{{ $exercise['id'] }}">
                        <div class="exercise-header" 
                            onclick="toggleAccordionExercise({{ $exercise['id'] }}, event)">
                            <div class="d-flex align-items-center">
                                <i id="exerciseArrow{{ $exercise['id'] }}" 
                                class="fa fa-chevron-right mr-2 accordion-arrow {{ $exercise['is_open'] ?? true ? 'rotated' : '' }}">
                                </i>
                                <i class="fa fa-dumbbell mr-2 text-primary"></i>
                                <strong>Exercise {{ $exerciseIndex + 1 }}</strong>
                                @if($exercise['exercise_list_id'] && $exerciseLists->find($exercise['exercise_list_id']))
                                    <span class="ml-2 text-muted">- {{ $exerciseLists->find($exercise['exercise_list_id'])->name }}</span>
                                @endif
                            </div>
                            <button type="button"
                                    wire:click="deleteExercise({{ $exercise['id'] }})"
                                    wire:confirm="Are you sure you want to delete this exercise?"
                                    class="btn btn-danger-custom btn-action"
                                    title="Delete Exercise">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                        <!-- Main Exercise Body -->
                        <div id="exerciseBody{{ $exercise['id'] }}" class="card-body" style="display: block;">
                            <!-- Your existing exercise form fields here (from document 3) -->
                            <div class="row">
                                <!-- Exercise Selection -->
                                <div class="col-md-3 mb-1" wire:ignore>
                                    <label class="form-label">Exercise List</label>
                                    <select class="form-control form-control-sm searchable-select"
                                            id="exerciseSelect{{ $exercise['id'] }}"
                                            data-exercise-id="{{ $exercise['id'] }}">
                                        <option value="">-Select Exercise-</option>
                                        @foreach($exerciseLists as $list)
                                            <option value="{{ $list->id }}" {{ $exercise['exercise_list_id'] == $list->id ? 'selected' : '' }}>
                                                {{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sets -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Sets</label>
                                    <input type="text" name="sets" class="form-control form-control-sm p-0 text-center exercise-field"    
                                        value="{{ $exercise['sets'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'sets', $event.target.value)">
                                </div>

                                <!-- Reps -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Reps</label>
                                    <input type="text" name="reps" class="form-control form-control-sm p-0 text-center exercise-field"
                                        value="{{ $exercise['reps'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'reps', $event.target.value)">
                                </div>

                                <!-- Rest -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Rest</label>
                                    <input type="text" name="rest" class="form-control form-control-sm p-0 text-center exercise-field"
                                        value="{{ $exercise['rest'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'rest', $event.target.value)">
                                </div>

                                <!-- Tempo -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Tempo</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $exercise['tempo'] }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'tempo', $event.target.value)">
                                </div>

                                <!-- Intensity -->
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Intensity</label>
                                    <select class="form-control form-control-sm"
                                            wire:change="updateExercise({{ $exercise['id'] }}, 'intensity', $event.target.value)">
                                        <option value="">-Select Intensity-</option>
                                        <option value="Low" {{ $exercise['intensity'] === 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Moderate" {{ $exercise['intensity'] === 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="High" {{ $exercise['intensity'] === 'High' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>

                                <!-- Weight -->
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Weight</label>
                                    <select class="form-control form-control-sm" id="exerciseWeight{{ $exercise['id'] }}"
                                            wire:change="updateExercise({{ $exercise['id'] }}, 'weight', $event.target.value)">
                                        <option value="">-Select Weight-</option>
                                        <option value="Yes" {{ $exercise['weight'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ $exercise['weight'] === 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <!-- Weight Value -->
                                <div class="col-md-2 mb-1" 
                                    id="weightValueDiv{{ $exercise['id'] }}" 
                                    style="display: {{ ($exercise['weight'] ?? '') === 'Yes' ? 'block' : 'none' }};">
                                    <label class="form-label">Weight(kg)</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $exercise['weight_value'] ?? '' }}"
                                        wire:blur="updateExercise({{ $exercise['id'] }}, 'weight_value', $event.target.value)">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 exercise-errors-container">
                                    <div class="alert alert-danger py-1 px-3 exercise-alert" style="display: none;">
                                        <ul class="mb-0 exercise-error-list"></ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Notes -->
                                <div class="col-12 mb-1">
                                    <label class="form-label">Instructions/Notes</label>
                                    <textarea class="form-control" rows="2"
                                            wire:blur="updateExercise({{ $exercise['id'] }}, 'notes', $event.target.value)">{{ strip_tags(html_entity_decode($exercise['notes'] ?? '')) }}</textarea>
                                </div>
                            </div>

                           

                            <!-- Alternate Exercise Button -->
                        @if($exercise['exercise_list_id'] && $exercise['has_available_alternates'])
                            <div class="row mt-2">
                                <div class="col-12 text-right">
                                    <button type="button" 
                                            wire:click="addAlternateExercise({{ $exercise['id'] }})"
                                            class="btn btn-primary-custom btn-sm"
                                            title="Add Alternate Exercise">
                                        <i class="fa fa-plus"></i> Add Alternate
                                    </button>
                                </div>
                            </div>
                        @endif
                            <!-- Alternate Exercises Section -->
                            @if(isset($exercise['alternates']) && count($exercise['alternates']) > 0)
                            <div class="mt-2 pt-2 border-top">
                                <h6 class="text-primary mb-3">
                                    <i class="fa fa-exchange-alt"></i> Alternate Exercises
                                </h6>

                                @foreach($exercise['alternates'] as $altIndex => $alternate)
                                    <div class="card mb-1 border-primary" wire:key="alternate-{{ $exercise['id'] }}-{{ $alternate['id'] }}">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <strong> {{ $alternate['name'] }}</strong>
                                            <button type="button"
                                                    wire:click.stop="deleteAlternateExercise({{ $alternate['id'] }})"
                                                    wire:confirm="Are you sure you want to remove this alternate exercise?"
                                                    class="btn btn-danger-custom btn-action"
                                                    title="Remove Alternate">
                                                <i class="fa fa-trash"></i> 
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 mb-1">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" 
                                                        name="alt_name_{{ $alternate['id'] }}"
                                                        class="form-control form-control-sm p-0 text-center"
                                                        wire:model.defer="alternates.{{ $alternate['id'] }}.name" 
                                                        value="{{ $alternate['name'] }}" 
                                                        readonly>
                                                </div>
                                                
                                                <!-- Sets - REMOVED exercise-field class -->
                                                <div class="col-md-2 mb-1">
                                                    <label class="form-label">Sets</label>
                                                    <input type="text" 
                                                        name="alt_sets_{{ $alternate['id'] }}"
                                                        class="form-control form-control-sm p-0 text-center alternate-field"
                                                        wire:model.defer="alternates.{{ $alternate['id'] }}.sets">
                                                </div>

                                                <!-- Reps - REMOVED exercise-field class -->
                                                <div class="col-md-2 mb-1">
                                                    <label class="form-label">Reps</label>
                                                    <input type="text" 
                                                        name="alt_reps_{{ $alternate['id'] }}"
                                                        class="form-control form-control-sm p-0 text-center alternate-field"
                                                        wire:model.defer="alternates.{{ $alternate['id'] }}.reps">
                                                </div>

                                                <!-- Rest - REMOVED exercise-field class -->
                                                <div class="col-md-2 mb-1">
                                                    <label class="form-label">Rest</label>
                                                    <input type="text" 
                                                        name="alt_rest_{{ $alternate['id'] }}"
                                                        class="form-control form-control-sm p-0 text-center alternate-field"
                                                        wire:model.defer="alternates.{{ $alternate['id'] }}.rest">
                                                </div>

                                                <!-- Tempo -->
                                                <div class="col-md-2 mb-1">
                                                    <label class="form-label">Tempo</label>
                                                    <input type="text" 
                                                        class="form-control form-control-sm p-0 text-center"
                                                        wire:model.defer="alternates.{{ $alternate['id'] }}.tempo">
                                                </div>

                                                <!-- Intensity -->
                                                <div class="col-md-2 mb-1">
                                                    <label class="form-label">Intensity</label>
                                                    <select class="form-control form-control-sm"
                                                            wire:model.defer="alternates.{{ $alternate['id'] }}.intensity">
                                                        <option value="">-- Select --</option>
                                                        <option value="Low">Low</option>
                                                        <option value="Moderate">Moderate</option>
                                                        <option value="High">High</option>
                                                    </select>
                                                </div>

                                                <!-- Weight -->
                                                <div class="col-md-2 mb-1">
                                                    <label class="form-label">Weight</label>
                                                    <select class="form-control form-control-sm" id="altWeight{{ $alternate['id'] }}" 
                                                            wire:change="updateAlternateWeight({{ $alternate['id'] }}, $event.target.value)">
                                                        <option value="">-Select-</option>
                                                        <option value="Yes" {{ ($alternate['weight'] ?? '') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No" {{ ($alternate['weight'] ?? '') === 'No' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>

                                                <!-- Weight Value -->
                                                <div class="col-md-2 mb-1" 
                                                    id="altWeightValueDiv{{ $alternate['id'] }}"
                                                    style="display: {{ ($alternate['weight'] ?? '') === 'Yes' ? 'block' : 'none' }};">
                                                    <label class="form-label">Weight(kg)</label>
                                                    <input type="text" 
                                                        class="form-control form-control-sm p-0 text-center"
                                                        wire:model.defer="alternates.{{ $alternate['id'] }}.weight_value" 
                                                        value="{{ $alternate['weight_value'] }}">
                                                </div>
                                            </div>

                                            <!-- Error container for alternate exercise -->
                                            <div class="row">
                                                <div class="col-12 alternate-errors-container">
                                                    <div class="alert alert-danger py-1 px-3 alternate-alert" 
                                                        id="alternate-errors-{{ $alternate['id'] }}" 
                                                        style="display: none;">
                                                        <ul class="mb-0 alternate-error-list"></ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Notes - FIXED to strip HTML tags -->
                                                <div class="col-12 mb-1">
                                                    <label class="form-label">Instructions/Notes</label>
                                                    <textarea class="form-control" 
                                                            rows="2"
                                                            wire:model.defer="alternates.{{ $alternate['id'] }}.notes">{{ strip_tags(html_entity_decode($alternate['notes'] ?? '')) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="row mt-1 justify-content-end">
                                                <button wire:click="saveAlternate({{ $alternate['id'] }})" 
                                                        class="btn btn-primary btn-sm mr-3">
                                                    Save Alternate
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        
                    </div>

                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-dumbbell fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No exercises found</h5>
                            <p class="text-muted">Click on "Days" to preload exercises</p>
                            <!-- <button wire:click="addExercise" class="btn btn-primary-custom">
                                <i class="fa fa-plus"></i> Add First Exercise
                            </button> -->
                        </div>
                    @endforelse
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Select a day to view exercises</h5>
                        <p class="text-muted">Choose a week and day from the sidebar to start building your workout</p>
                    </div>
                @endif
                <div class=" d-flex justify-content-end">
                    <button type="button" wire:click="addExercise" class="btn btn-primary-custom btn-sm">
                        <i class="fa fa-plus"></i> Add Exercise
                    </button>
                    <!-- <button type="button" wire:click="refreshDayExercises" class="btn btn-info btn-sm ml-1" title="Ensure 6 exercises">
                    <i class="fa fa-sync"></i> Refresh
                    </button> -->
                    <button type="button" wire:click="saveAllExercises" class="btn btn-success-custom btn-sm ml-2">
                        Save 
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>