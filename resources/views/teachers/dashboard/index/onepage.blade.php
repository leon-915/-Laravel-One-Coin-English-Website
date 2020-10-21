
<div class="lesson_record_sec facebook canvas">
    <div class="row">
        <div class="tab-content inner">
            <div class="accordion one_page_canvas" id="one-page-accordion">
                <div class="card" id="one-page-session-container">
                    @include('teachers.dashboard.index.onepage.sessions')
                </div>

                <div class="card" id="one-page-canvas-container">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alert-message-1" role="dialog" aria-labelledby="alert-message-1Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="$('#alert-message-1').modal('hide');"
                    value="×">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>Are you sure about wrapping this session?</h4>
                </div>
                <div class="text-center">
                    <input type="button" id="yes_wrap" onclick="check_keyword_entered()" value="Yes">
                    <input type="button" data-dismiss="modal" id="no_wrap" onclick="$('#alert-message-1').modal('hide');"
                        value="No">
                </div>
            </div>
            <!--//Translated_Text-->
        </div>
        <!--//Modal content-->
    </div>
    <!--//Modal dialog-->
</div>
<div class="modal fade" id="alert-message-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="$('#alert-message-2').modal('hide');" value="×">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>There is more lesson today. You want to wrap this lesson?</h4>
                </div>
                <div class="text-center">
                    <input type="button" id="yes_wrap" onclick="check_keyword_entered()" value="Yes">
                    <input type="button" data-dismiss="modal" id="no_wrap" onclick="save_for_next_lessons();"
                        value="No">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-message-3" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="$('#alert-message-3').modal('hide');"value="×">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center mb-3">
                    <h4>Aren't there any keywords or phrases that you want to share?</h4>
                </div>
                <div class="text-center">
                    <button type="button" id="yes_wrap" onclick="$('#alert-message-3').modal('hide');" class="freetrial_btn">
                        Yes.
                    </button>
                    <button type="button" id="no_wrap" onclick="finaly_wrap_lesson();" class="freetrial_btn">
                        No.
                    </button>
                </div>
            </div>
            <!--//Translated_Text-->
        </div>
        <!--//Modal content-->
    </div>
    <!--//Modal dialog-->
</div>
<div class="modal fade" id="alert-message-4" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="$('#alert-message-4').modal('hide');"
                    value="×">

            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>Your lesson has been wrapped successfully.</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-message-5" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h5 class="mb-2">Enjoy your session! Before you do, check out the tasks for today's session.</h5>
                    <h6 class="mb-2">Use the arrows to move the tasks into today's homework and next lesson tasks.</h6>
                </div>
                <div class="text-center">
                    <button type="button" id="homework_popup" onclick="$('#alert-message-5').modal('hide');" class="freetrial_btn">
                        Will Do.
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="change_rating_popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
					<h5>Time to move on and up. Go to the next level.</h5>
					<h6>Please select below.</h6>
				</div>
				<div class="text-center">
					<input type="button" class="freetrial_btn" data-dismiss="modal" id="changerating_popup" onclick="close_update_rating_popup();" value="Will Do.">
				</div>
			</div>				
		</div>
	</div>
</div>

<div class="modal fade" id="alert-message-6" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width:200px;">
        <div class="modal-content" >
            <div class="modal-body clearfix" id="modal-body"">
                <div class="text-center">
                    <div id="countdown" style="float:left;font-weight:600;"></div>
                    <a href="javascript:void(0);" id="undo_popup" style="float:right; font-weight:bold;">Undo</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-preview-mode" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>You are in review mode</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-no-canvas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Hey cowboy! At least put something on the canvas before wrapping.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alert-no-comment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Please enter any text in lesson comment before wrap lesson.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alert_points_to_improve_comment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Please enter any text in points to improve comment before wrap lesson.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alert_strong_points_comment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Please enter any text in strong points comment before wrap lesson.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alert-strong-points" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Please check atleast one strong points or points to improve must be there before wrap</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-one-strong-points" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Please select at least one chekbox to move item</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-no-topic" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Hey amazing teacher. Not so fast, gotta at least input 1 Topic.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alert-no-arp" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>There must be atleast 1 ARP to successfully wrap this lesson.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alert-update-ratings" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-11">
                            <h4>Please update the ratings before wrapping the session.</h4>
                        </div>
                        <div class="col-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="homework_lesson_task_alert" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center mb-3">
						<h4>Before wrapping have you:</h4>
                        Adjusted or assigned homework and next lesson tasks, if any.<br />                    
                </div>
                <div class="text-center">
                    <button type="button" id="yes_wrap" onclick="wrap_lesson('wrap');" class="freetrial_btn">
                        Yes.
                    </button>
                    <button type="button" id="no_wrap" onclick="$('#homework_lesson_task_alert').modal('hide');" class="freetrial_btn">
                        No.
                    </button>
                </div>
            </div>
            <!--//Translated_Text-->
        </div>
        <!--//Modal content-->
    </div>
    <!--//Modal dialog-->
</div>


<div class="modal fade" id="alert-message-9" role="dialog" style="z-index:99999;opacity: 3.4;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h5 class="mb-2">Use + to enter item into comments box.</h5>
                    <h6 class="mb-2">Use <> to shift items between Points to Improve and Strong Points.</h6>
                </div>
                <div class="text-center">
                    <button type="button" id="homework_popup111" onclick="$('#alert-message-9').hide();" class="freetrial_btn">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>