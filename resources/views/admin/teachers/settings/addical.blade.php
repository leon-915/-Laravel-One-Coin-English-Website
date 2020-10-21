<div class="row calendar_url" id="calendar_url_{inx}">
    <div class="form-group col-8">
        <label class="form-control-label" for="google_calender_link_{inx}">Import
            Calendar
            (iCal)</label>
        <input placeholder="Calendar Link" class="form-control error"
               id="google_calender_link" name="google_calendar_link[{inx}]" type="text"
               value=""/>

    </div>
    <div class="form-group col-4 mt-3">
        <button type="button" data-id="{inx}"
                class="delete btn btn-gradient-danger btn-rounded btn-fw deletelink_{inx}"
                onclick="linkOptionAction.removeOption(this);">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
            Delete
        </button>
    </div>
</div>