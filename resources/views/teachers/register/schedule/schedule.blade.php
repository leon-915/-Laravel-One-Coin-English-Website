<div class="row" id="teacher-schedule-0">
    <div class="col-12">
        <div class="form-group half">
            <label>From </label>
            <input type="text" name="schedule[0][from]" data-id="0" id="from-0" class="form-control timepicker">
        </div>
        <div class="form-group half padd">
            <label>To </label>
            <input type="text" name="schedule[0][to]" data-id="0" id="to-0" class="form-control timepicker">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="checkcontainer">Mon
                <input type="checkbox" name="schedule[0][times][]" value="mon">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Tue
                <input type="checkbox" name="schedule[0][times][]" value="tue">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Wed
                <input type="checkbox" name="schedule[0][times][]" value="wed">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Thu
                <input type="checkbox" name="schedule[0][times][]" value="thu">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Fri
                <input type="checkbox" name="schedule[0][times][]" value="fri">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Sat
                <input type="checkbox" name="schedule[0][times][]" value="sat">
                <span class="checkmark"></span>
            </label>
            <label class="checkcontainer">Sun
                <input type="checkbox" name="schedule[0][times][]" value="sun">
                <span class="checkmark"></span>
            </label>
        </div>
		<label id="schedule[0][times][]-error" class="error" style="display: none;" for="schedule[0][times][]"></label>
		<label id="schedule[0][from]-error" class="error" style="display: none;" for="schedule[0][from]"></label>
		<label id="schedule[0][to]-error" class="error" style="display: none;" for="schedule[0][to]"></label>
    </div>
</div>
