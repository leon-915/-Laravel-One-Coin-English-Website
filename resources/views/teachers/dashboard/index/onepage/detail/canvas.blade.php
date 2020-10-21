<div id="oldHtmlArea" style="display:none"></div>
<div id="editor_text_with_brases" style="display:none"></div>
<div id="new_editor_html" style="display:none"></div>
<input type="hidden" class="clicked_not_clicked" value="0">
<input type="hidden" id="bind_field" value="0">
<div class="new-teacher-accordian-page teacher-accordian-onePage">
    <div class="acc-box">
        <div class="graph_tab_1_2">
            <div class="graph_tab_2">
                <div class="acc-container lesson_record_id_div" style="display: block;">
                    <div class="editor_div" style="min-height:350px; margin-bottom:20px;">
                        <div class="all_text_areas">
                            <fieldset class="graph-container current-page-graph onepage-graph">
                                <legend class="graph-container-heading" align="center">
                                    {{ isset($currBookingIndx) ? $currBookingIndx : ''}} {{ ucfirst($booking->student->firstname) }} {{ ucfirst($booking->student->lastname) }} | {{ __('labels.stu_accent_onepage') }} {{$booking->onepage_title}}
                                </legend>
                                <div id="editor_textarea" class="editor_textarea" contenteditable="true" data-booking-id="{{$booking->id}}">@if(isset($booking->canvas_html))<?= $booking->canvas_html ?>@endif</div>
                                
                            </fieldset>
                            @if($booking->status=='booked')
                            <div class="clearfix btns-wrapper">
                                <a href="javascript:void(0);" class="bottom-wrap-btn btn-t1"
                                    title="@{{ _ }} Topic Tag" onclick="replaceCopiedToTopicTag('topic_tag')">
                                    <img src="{{ asset('images') }}/onepage/icon-tag.svg" alt="Clear-icon">
                                </a>
                                <a href="javascript:void(0);" class="bottom-wrap-btn btn-t2" title="{ _ } Keyword"
                                    onclick="replaceCopiedToTopicTag('keyword')">
                                    <img src="{{ asset('images') }}/onepage/icon-keyword.svg" alt="preview-icon">
                                </a>
                                <a href="javascript:void(0);" class="bottom-wrap-btn btn-t3" title="Search google"
                                    onclick="replaceCopiedToTopicTag('key_phrase')">
                                    <img src="{{ asset('images') }}/onepage/icon-keyphrase.svg" alt="Preview-icon">
                                </a>

                                <a href="javascript:void(0);" id="undo" class="bottom-wrap-btn" title="Undo" disabled="disabled">
                                    <img src="{{ asset('images') }}/onepage/icon-undo.svg" alt="Undo">
                                </a>

                                <a href="javascript:void(0);" class="bottom-wrap-btn btn-t4" title="Clear Format"
                                    onclick="replaceCopiedText()">
                                    <img src="{{ asset('images') }}/onepage/icon-clear.svg" alt="Clear-icon">
                                </a>
                                <a href="javascript:void(0);" class="bottom-wrap-btn botm-eye-icon-white"
                                    title="Cancel Preview" onclick="revertToOldHtml()" style="display: none;">
                                    <img src="{{ asset('images') }}/onepage/icon-eye-white.svg" alt="preview-icon">
                                </a>
                                <a href="javascript:void(0);" class="bottom-wrap-btn botm-eye-icon" title="Preview"
                                    onclick="preview_lesson()">
                                    <img src="{{ asset('images') }}/onepage/icon-eye.svg" alt="Preview-icon">
                                </a>
                                <a href="javascript:void(0);" class="bottom-wrap-btn" title="Wrap"
                                    onclick="check_homework_task();" data-booking_id="{{ $studentLesson->id }}">
                                    <img src="{{ asset('images') }}/onepage/icon-wrap.svg" alt="Wrap-icon">
                                </a>
                            </div>
                            @endif
                            <div class="lessons-comments" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var wrapUrl   = "<?= route('teachers.dashboard.onepage.wraplesson') ?>";
    var lessonID  = "<?= $studentLesson->id ?>";
    var bookingID = "<?= $booking_id ?>";
    var isAlertRating = <?= $isAlertRating ?>;
</script>
<script src="{{ asset('js/teacher/onepage-canvas.js') }}"></script>
