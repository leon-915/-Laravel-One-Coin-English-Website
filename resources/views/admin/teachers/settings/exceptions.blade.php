@foreach ($teacherExc as $inx => $item)
    <div class="from_start_date" id="teacher-exception-{{ $inx }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group half">
                    <label for="from-{{ $inx }}">From</label>
                <input type="text" name="exception[{{ $inx }}][from]" id="from-{{ $inx }}" data-id="{{ $inx }}" class="form-control timepicker" value="{{ $item->from_time }}">
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group half">
                    <label for="to-{{ $inx }}">To</label>
                    <input type="text" name="exception[{{ $inx }}][to]" id="to-{{ $inx }}" data-id="{{ $inx }}" class="form-control timepicker" value="{{ $item->to_time }}">
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-md-12">
                <div class="form-group full">
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input class="available-size " name="exception[{{ $inx }}][times][]" type="checkbox"{{ ($item->monday) ? 'checked' : ''  }} value="mon">Mon<i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input class="available-size" type="checkbox" name="exception[{{ $inx }}][times][]" {{ ($item->tuesday) ? 'checked' : ''  }} value="tue">Tue<i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input class="available-size" type="checkbox" name="exception[{{ $inx }}][times][]" {{ ($item->wednesday) ? 'checked' : ''  }} value="wed">Wed<i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input type="checkbox" class="available-size" name="exception[{{ $inx }}][times][]" {{ ($item->thursday) ? 'checked' : ''  }} value="thu">Thu<i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input type="checkbox"  class="available-size" name="exception[{{ $inx }}][times][]" {{ ($item->friday) ? 'checked' : ''  }} value="fri">Fri<i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input type="checkbox" class="available-size" name="exception[{{ $inx }}][times][]" {{ ($item->saturday) ? 'checked' : ''  }} value="sat">Sat<i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info">
                        <label class="form-check-label ">
                            <input type="checkbox" class="available-size" name="exception[{{ $inx }}][times][]" {{ ($item->sunday) ? 'checked' : ''  }} value="sun">Sun<i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group half">
                    <label class="form-control-label" for="from_date-{{ $inx }}">Start Date(Optional)</label>
                    <input type="text" name="exception[{{ $inx }}][from_date]" id="from_date-{{ $inx }}" data-id="{{ $inx }}" class="form-control" value="{{ $item->from_date }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group half">
                    <label class="form-control-label" for="to_date-{{ $inx }}">End Date(Optional)</label>
                    <input type="text" name="exception[{{ $inx }}][to_date]" id="to_date-{{ $inx }}" data-id="{{ $inx }}" class="form-control" value="{{ $item->to_date }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
               <button type="button" data-id="{{ $inx }}" class="delete btn btn-gradient-danger btn-rounded btn-fw" onclick="exOptionAction.removeOption(this);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.onload = function(e){
            $('#from-{{ $inx }}').timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                dynamic: false,
                dropdown: true,
                change : function(e){
                    let inx = $(this).data('id');

                    var time = $(this).val();
                    var getTime = time.split(":"); //split time by colon
                    var hours = parseInt(getTime[0])+1; //add two hours
                    //var newTime = hours+":"+getTime[1];
                    var newTime = hours;

                    $('#to-'+inx).timepicker( 'option','minHour', newTime );
                }
            });

            $('#to-{{ $inx }}').timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                dynamic: false,
                dropdown: true,
                change : function(e){
                    let inx = $(this).data('id');

                    var time = $(this).val();
                    var getTime = time.split(":"); //split time by colon
                    var hours = parseInt(getTime[0])-1; //add two hours
                    //var newTime = hours+":"+getTime[1];
                    var newTime = hours;

                    $('#from-'+inx).timepicker( 'option','maxHour', newTime );
                }
                //scrollbar: true
            });

            $('#from_date-{{ $inx }}').datepicker({
                dateFormat: "yy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
                minDate : '0d',
                changeMonth: true,
                changeYear: true,
                onClose: function (selectedDate) {
                    $("#to_date-{{ $inx }}").datepicker("option", "minDate", selectedDate);
                    var date2 = $('#from_date-{{ $inx }}').datepicker('getDate', '+1d');
                    date2.setDate(date2.getDate()+1);
                    $('#to_date-{{ $inx }}').datepicker('setDate', date2);
                }
            });

            $('#to_date-{{ $inx }}').datepicker({
                dateFormat: "yy-mm-dd",
                enableOnReadonly: true,
                todayHighlight: true,
                minDate : '0d',
                changeMonth: true,
                changeYear: true,
                onClose: function (selectedDate) {
                    $("#from_date-{{ $inx }}").datepicker("option", "maxDate", selectedDate);
                }
            });
        }
    </script>

@endforeach
