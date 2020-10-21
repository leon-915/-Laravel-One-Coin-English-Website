<div class="modal fade scan_model" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLongTitle">{{__('labels.scan_QR')}}</h5>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-4 mb-3">
                        <img src="{{asset('images/rgx3871c.png')}}">
                    </div>
                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="scan_describe">
                            <p>{{__('labels.QR_popup_p1')}}</p>
                            <p>{{__('labels.QR_popup_p2')}}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="checkcontainer"> {{__('labels.QR_popup_p3')}}
                            <input type="checkbox" name="lineNotification" id="lineNotification" value="{{Auth::id()}}">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
