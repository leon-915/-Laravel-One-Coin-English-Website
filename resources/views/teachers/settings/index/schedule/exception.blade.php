<div class="from_start_date" id="teacher-exception-{inx}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="from-{inx}">From</label>
                <input type="text" name="exception[{inx}][from]" id="from-{inx}" data-id="{inx}" class="form-control timepicker">
            </div>
            <button type="button" data-id="{inx}" class="delete" onclick="exOptionAction.removeOption(this);"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="to-{inx}">To</label>
                <input type="text" name="exception[{inx}][to]" id="to-{inx}" data-id="{inx}" class="form-control timepicker">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group full">
                    <label class="checkcontainer">Mon
                    <input type="checkbox" name="exception[{inx}][times][]" value="mon">
                    <span class="checkmark"></span>
                </label>
                <label class="checkcontainer">Tue
                    <input type="checkbox" name="exception[{inx}][times][]" value="tue">
                    <span class="checkmark"></span>
                </label>
                <label class="checkcontainer">Wed
                    <input type="checkbox" name="exception[{inx}][times][]" value="wed">
                    <span class="checkmark"></span>
                </label>
                <label class="checkcontainer">Thu
                    <input type="checkbox" name="exception[{inx}][times][]" value="thu">
                    <span class="checkmark"></span>
                </label>
                <label class="checkcontainer">Fri
                    <input type="checkbox" name="exception[{inx}][times][]" value="fri">
                    <span class="checkmark"></span>
                </label>
                <label class="checkcontainer">Sat
                    <input type="checkbox" name="exception[{inx}][times][]" value="sat">
                    <span class="checkmark"></span>
                </label>
                <label class="checkcontainer">Sun
                    <input type="checkbox" name="exception[{inx}][times][]" value="sun">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="from_date-{inx}">Start Date</label>
                <input type="text" name="exception[{inx}][from_date]" id="from_date-{inx}" data-id="{inx}" class="form-control">
            </div>
            <span class="option"> (Optional)</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="to_date-{inx}">End Date</label>
                <input type="text" name="exception[{inx}][to_date]" id="to_date-{inx}" data-id="{inx}" class="form-control">
            </div>
            <span class="option"> (Optional)</span>
        </div>
    </div>
</div>
