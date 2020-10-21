<div class="from_start_date" id="teacher-exception-{inx}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="from-{inx}">From</label>
                <input type="text" name="exception[{inx}][from]" id="from-{inx}" data-id="{inx}" class="form-control timepicker">
            </div>
          
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
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="mon">Mon<i class="input-helper"></i>
                    </label>
               </div> 
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="tue">Tue<i class="input-helper"></i>
                    </label>
               </div> 
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="wed">Wed<i class="input-helper"></i>
                    </label>
               </div> 
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="thu">Thu<i class="input-helper"></i>
                    </label>
               </div> 
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="fri">Fri<i class="input-helper"></i>
                    </label>
               </div> 
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="sat">Sat<i class="input-helper"></i>
                    </label>
               </div> 
               <div class="form-check form-check-info">
                    <label class="form-check-label ">
                        <input class="available-size " name="exception[{inx}][times][]" type="checkbox" value="sun">Sun<i class="input-helper"></i>
                    </label>
               </div> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="from_date-{inx}">Start Date (Optional)</label>
                <input type="text" name="exception[{inx}][from_date]" id="from_date-{inx}" data-id="{inx}" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group half">
                <label for="to_date-{inx}">End Date (Optional)</label>
                <input type="text" name="exception[{inx}][to_date]" id="to_date-{inx}" data-id="{inx}" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" data-id="{inx}" class="delete btn btn-gradient-danger btn-rounded btn-fw" onclick="exOptionAction.removeOption(this);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
        </div>
    </div>
</div>
