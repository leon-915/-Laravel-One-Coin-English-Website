@if(!empty($icalLink))
    @php $i = 1 @endphp
    @foreach($icalLink as $ical)
        <div class="row calendar_url" id="calendar_url_{{$i}}">
            <div class="form-group col-8">
                <label class="form-control-label" for="google_calender_link_{{$i}}">Import
                    Calendar
                    (iCal)</label>
                <input placeholder="Calendar Link" class="form-control error"
                       id="google_calender_link" name="google_calendar_link[{{ $i }}]" type="text"
                       value="{{$ical->ical_link}}"/>

            </div>
            <div class="form-group col-4 mt-3">
                <button type="button" data-id="{{$i}}"
                        class="delete btn btn-gradient-danger btn-rounded btn-fw deletelink_{{$i}}"
                        onclick="linkOptionAction.removeOption(this);">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                    Delete
                </button>
            </div>
        </div>
        @php $i++; @endphp
    @endforeach
@else
    <div class="row calendar_url" id="calendar_url_1">
        <div class="form-group col-8">
            <label class="form-control-label" for="google_calender_link_1">Import
                Calendar
                (iCal)</label>
            <input placeholder="Calendar Link" class="form-control error"
                   id="google_calender_link" name="google_calendar_link[1]" type="text"
                   value=""/>

        </div>
        <div class="form-group col-4 mt-3">
            <button type="button" data-id="1"
                    class="delete btn btn-gradient-danger btn-rounded btn-fw deletelink_1"
                    onclick="linkOptionAction.removeOption(this);">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
                Delete
            </button>
        </div>
    </div>
@endif