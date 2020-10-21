<div class="row" id="teacher-schedule-{inx}">
    <div class="col-12">
        <div class="form-group half">
            <label>From </label>
            <input type="text" name="schedule[{inx}][from]" id="from-{inx}" data-id="{inx}" class="form-control timepicker">
        </div>
        <div class="form-group half padd">
            <label>To </label>
            <input type="text" name="schedule[{inx}][to]" id="to-{inx}" data-id="{inx}" class="form-control timepicker">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="checkcontainer">Mon
                <input type="checkbox" name="schedule[{inx}][times][]" value="mon">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Tue
                <input type="checkbox" name="schedule[{inx}][times][]" value="tue">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Wed
                <input type="checkbox" name="schedule[{inx}][times][]" value="wed">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Thu
                <input type="checkbox" name="schedule[{inx}][times][]" value="thu">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Fri
                <input type="checkbox" name="schedule[{inx}][times][]" value="fri">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Sat
                <input type="checkbox" name="schedule[{inx}][times][]" value="sat">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Sun
                <input type="checkbox" name="schedule[{inx}][times][]" value="sun">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
    <div class="col-12">
        <button type="button" data-id="{inx}" class="add_btn" onclick="optionAction.removeOption(this)"><i class="fa fa-trash-o" aria-hidden="true"></i> Remove</button>
    </div>
</div>
