<div id="create-parking-modal" class="modal">
    <div class="modal-header">
        Creating new parking area
    </div>
    <div class="modal-body">
        <form id="creating-parking-area-form">
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input id="name" class="form-input" type="text" name="name"
                       placeholder="Enter parking area name..." required
                >
                <span id="create-parking-error-name" class="error"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="weekdays-hourly-rate">Weekdays hourly rate</label>
                <input id="weekdays-hourly-rate" class="form-input" type="number" name="weekdays_hourly_rate"
                       placeholder="0.00" min="0.00" step="0.01" required
                >
                <span id="create-parking-error-weekdays_hourly_rate" class="error"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="weekend-hourly-rate">Weekend hourly rate</label>
                <input id="weekend-hourly-rate" class="form-input" type="number" name="weekend_hourly_rate"
                       placeholder="0.00" min="0.00" step="0.01" required
                >
                <span id="create-parking-error-weekend_hourly_rate" class="error"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="discount-percentage">Discount percentage</label>
                <input id="discount-percentage" class="form-input" type="number" name="name" placeholder="0"
                       min="0" step="1" required
                >
                <span id="create-parking-error-discount_percentage" class="error"></span>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger close-modal-btn" data-modal-id="#create-parking-modal">Cancel</button>
        <button class="btn btn-success submit-form-btn" data-form-id="#creating-parking-area-form" style="margin-left: 1em;">
            Create
        </button>
    </div>
</div>