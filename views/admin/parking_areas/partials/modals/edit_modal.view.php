<div id="edit-parking-modal" class="modal">
    <div class="modal-header">
        Edit parking area
    </div>
    <div class="modal-body">
        <form id="updating-parking-area-form">
            <div class="form-group">
                <label class="form-label" for="edit-name">Name</label>
                <input id="edit-name" class="form-input" type="text" name="name"
                       placeholder="Enter parking area name..." required
                >
                <span id="edit-parking-error-name" class="error"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit-weekdays-hourly-rate">Weekdays hourly rate</label>
                <input id="edit-weekdays-hourly-rate" class="form-input" type="number" name="weekdays_hourly_rate"
                       placeholder="0.00" min="0.00" step="0.01" required
                >
                <span id="edit-parking-error-weekdays_hourly_rate" class="error"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit-weekend-hourly-rate">Weekend hourly rate</label>
                <input id="edit-weekend-hourly-rate" class="form-input" type="number" name="weekend_hourly_rate"
                       placeholder="0.00" min="0.00" step="0.01" required
                >
                <span id="edit-parking-error-weekend_hourly_rate" class="error"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit-discount-percentage">Discount percentage</label>
                <input id="edit-discount-percentage" class="form-input" type="number" name="name" placeholder="0"
                       min="0" step="1" required
                >
                <span id="edit-parking-error-discount_percentage" class="error"></span>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger close-modal-btn" data-modal-id="#edit-parking-modal">Cancel</button>
        <button id="update-parking-area-btn" class="btn btn-success" type="button" data-parking-id="" style="margin-left: 1em;">
            Save
        </button>
    </div>
</div>