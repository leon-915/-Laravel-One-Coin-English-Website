<?php
// session_start();
// if (!defined('ABSPATH'))
//     die('No direct access allowed');
?>
<?php
/*
  Template Name: Teacher One Page
 */
// date_default_timezone_set(get_option('timezone_string', 'Asia/Tokyo'));
// if (!is_user_logged_in()) {

//     wp_redirect(site_url() . '/en/teacher-login/');
//     exit;
// }
// global $wpdb, $current_user;
// $teacher = $current_user->user_email;
// $user_ID = get_current_user_id();
// $birs_staff_id = get_user_meta($user_ID, 'birs_staff_id', true);

// $user_data = get_userdata($user_ID);
// $user_role = $user_data->roles[0];

// get_header();
?>
<script type="text/javascript">
    jQuery(document).ready(function () {

        /*jQuery('#editor_textarea').keydown(function(e) {
         
         if (e.keyCode == 13) {
         
         document.execCommand('insertHTML', false, '<br><br>');
         return false;
         }
         });*/

        jQuery('#editor_textarea').on('focus', function () {

            if (jQuery('#student_level').val() == '') {
                alert('Hold your horses! Before you are able to write in cavvas, in the Profile section, please select the student\'s proficiency level.');
            }
        });
        jQuery('#bind_field').val(0);
        if (jQuery(window).width() <= 670) {
            var tab_content = jQuery('.graph_tab_1_2').html();

            jQuery('li.active .mobile_display').html(tab_content);
            jQuery('.graph_tab_1_2').html('');
        }
        jQuery(document).on('click', '.arp_cancel_btn', function () {

            jQuery('#arp_cancel_btn_' + jQuery(this).data('atr')).toggle();
            jQuery('#arp_save_btn_' + jQuery(this).data('atr')).toggle();
            jQuery('.input_' + jQuery(this).data('atr')).toggle();
            jQuery('.text_' + jQuery(this).data('atr')).toggle();
            jQuery('.edit_arp_' + jQuery(this).data('atr')).toggle();
        });
        jQuery(document).on('click', '.keyword_cancel_btn', function () {
            jQuery('#keyword_cancel_btn_' + jQuery(this).data('atr')).toggle();
            jQuery('#keyword_save_btn_' + jQuery(this).data('atr')).toggle();
            jQuery('.input_' + jQuery(this).data('atr')).toggle();
            jQuery('.text_' + jQuery(this).data('atr')).toggle();
            jQuery('.edit_keyword_' + jQuery(this).data('atr')).toggle();
        });
        jQuery(document).on('click', '.incorrect_cancel_button', function () {
            jQuery('#incorrect_cancel_button_' + jQuery(this).data('atr')).toggle();
            jQuery('#incorrect_save_button_' + jQuery(this).data('atr')).toggle();
            jQuery('.incor_input_' + jQuery(this).data('atr')).toggle();
            jQuery('.incor_text_' + jQuery(this).data('atr')).toggle();
            jQuery('.edit_incorrect_' + jQuery(this).data('atr')).toggle();
        });
        jQuery(document).on('click', '.correct_cancel_button', function () {
            jQuery('#correct_cancel_button_' + jQuery(this).data('atr')).toggle();
            jQuery('#correct_save_button_' + jQuery(this).data('atr')).toggle();
            jQuery('.cor_input_' + jQuery(this).data('atr')).toggle();
            jQuery('.cor_text_' + jQuery(this).data('atr')).toggle();
            jQuery('.edit_correct_' + jQuery(this).data('atr')).toggle();
        });
        jQuery(document).on('click', '.topic_cancel_button', function () {
            jQuery('#topic_cancel_button_' + jQuery(this).data('atr')).toggle();
            jQuery('#topic_save_button_' + jQuery(this).data('atr')).toggle();
            jQuery('.prev_topic_input_' + jQuery(this).data('atr')).toggle();
            jQuery('.prev_topic_text_' + jQuery(this).data('atr')).toggle();
            jQuery('.edit_prev_topic_' + jQuery(this).data('atr')).toggle();
        });
        var divList = jQuery(".strong_points_class");
        divList.sort(function (a, b) {
            return jQuery(a).data("srt") - jQuery(b).data("srt");
        });
        jQuery("#response_div_strong_points").html(divList);
        var divList1 = jQuery(".points_to_improve_class");
        divList1.sort(function (a, b) {
            return jQuery(a).data("srt") - jQuery(b).data("srt");
        });
        jQuery("#response_div_points_to_improve").html(divList1);
<?php //if ($_REQUEST['lesson_record_id']) { ?>
            var top = parseInt(jQuery('.lesson_record_id_span').offset().top) - 200;
            jQuery(window).scrollTop(top);
            jQuery('.acc-trigger').removeClass('active');
            jQuery('.lesson_record_id_span').addClass('active');
            jQuery('.review_block_span').addClass('active');
            jQuery('.lesson_record_id_div').css('display', 'block');
            jQuery('.review_block_div').css('display', 'block');
<?php //} ?>
        jQuery('.dropdown-toggle').click(function () {
            var flag = 0;
            if (jQuery(this).hasClass("active")) {
                flag = 1;
            }
            jQuery('.editable-dropdown .dropdown-toggle').removeClass('active');
            if (flag == 0) {
                jQuery(this).toggleClass("active");
            }
        });

    });
</script>
<style>
    .text-center{text-align: center;  }
    .status-options-wrapper{height: 60px;}
    .status-options-wrapper img {min-width: 10px;}
    .status-options-wrapper .status-options a, .status-options a{padding:6px 14px;overflow:hidden}
    .status-options-wrapper .status-options a.square-class{padding:6px 14px !important; border-color:#0080c3 !important}
    .status-options-wrapper .status-options a.reverse-btn{padding: 6px 10px !important;}
    .status-options-wrapper .status-options a.reverse-btn img{width: 14px;position: relative;top: 2px;}
    .status-options-wrapper .status-options a:hover { background-color: #eeeeee;}
</style>
<div class="modal" id="alert-message-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="jQuery('#alert-message-1').hide();" value="&times;">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>Are you sure about wrapping this session?</h4>
                </div>
                <div class="text-center">
                    <input type="button" id="yes_wrap" onclick="check_keyword_entered()" value="Yes">
                    <input type="button" data-dismiss="modal" id="no_wrap" onclick="jQuery('#alert-message-1').hide();" value="No">
                </div>
            </div>
            <!--//Translated_Text-->
        </div>
        <!--//Modal content-->
    </div>
    <!--//Modal dialog-->
</div>
<div class="modal" id="alert-message-2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="jQuery('#alert-message-2').hide();" value="&times;">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>There is more lesson today. You want to wrap this lesson?</h4>
                </div>
                <div class="text-center">
                    <input type="button" id="yes_wrap" onclick="check_keyword_entered()" value="Yes">
                    <input type="button" data-dismiss="modal" id="no_wrap" onclick="save_for_next_lessons();" value="No">
                </div>
            </div>
            <!--//Translated_Text-->
        </div>
        <!--//Modal content-->
    </div>
    <!--//Modal dialog-->
</div>
<div class="modal" id="alert-message-3" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="jQuery('#alert-message-3').hide();" value="&times;">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>Aren't there any keywords or phrases that you want to share?</h4>
                </div>
                <div class="text-center">
                    <input type="button" id="yes_wrap" onclick="jQuery('#alert-message-3').hide();" value="Yes">
                    <input type="button" data-dismiss="modal" id="no_wrap" onclick="finaly_wrap_lesson();" value="No">
                </div>
            </div>
            <!--//Translated_Text-->
        </div>
        <!--//Modal content-->
    </div>
    <!--//Modal dialog-->
</div>
<div class="modal" id="alert-message-4" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="jQuery('#alert-message-4').hide();" value="&times;">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h4>Your lesson has been wrapped successfully.</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="alert-message-5" role="dialog" style="z-index:99999; margin-top:150px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <input type="button" class="close" data-dismiss="modal" onclick="jQuery('#alert-message-5').hide();" value="&times;">
            </div>
            <div class="modal-body clearfix" id="modal-body">
                <div class="text-center">
                    <h5>Enjoy your session! Before you do, check out the tasks for today's session.</h5>
                    <h6>Use the arrows to move the tasks into today's homework and next lesson tasks.</h6>
                </div>
                <div class="text-center">
                    <input type="button" id="homework_popup" onclick="jQuery('#alert-message-5').hide();" value="Done">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="oldHtmlArea" style="display:none"></div>
<div id="editor_text_with_brases" style="display:none"></div>
<div id="new_editor_html" style="display:none"></div>
<input type="hidden" class="clicked_not_clicked" value="0">
<input type="hidden" id="bind_field" value="0">
<?php
// $cur_canvas_stu_id = '';
// if (isset($_REQUEST['lesson_record_id']) && $_REQUEST['lesson_record_id'] != '') {
//     $select_student = 'select student_id from ' . $wpdb->prefix . 'lesson_record where id = ' . $_REQUEST['lesson_record_id'];
//     $temp_data_results = $wpdb->get_row($select_student, ARRAY_A);
//     $cur_canvas_stu_id = $temp_data_results['student_id'];
//     $_SESSION['student_session_start'] = $temp_data_results['student_id'];
// } else {
//     $_SESSION['student_session_start'] = '';
//     unset($_SESSION['student_session_start']);
// }

// echo search_text_and_translation_form_teacher($cur_canvas_stu_id);
?>
<div class="new-teacher-accordian-page teacher-accordian-onePage">
    <div class="acc-box">
        <?php
        //echo accent_tabs_link();
        ?>
        <div class="graph_tab_1_2">
            <div class="graph_tab_2">
                <?php
                // $canvas_html = '';
                // $next_lesson_task_temp = array();
                // $homework_lesson_material_task_temp = array();
                // $lesson_task_temp = array();
                // $lesson_material_task_temp = array();
                // $strong_points_temp = '';
                // $points_to_improve_temp = '';
                // $lesson_comments_temp = '';
                // $temp_topic_tag = array();
                // if (isset($_REQUEST['lesson_record_id']) && $_REQUEST['lesson_record_id'] != '') {

                //     $lessonRecordId = $_REQUEST['lesson_record_id'];
                //     $select_temp_data = 'select * from ' . $wpdb->prefix . 'onepage_temp_data where lesson_record_id = ' . $lessonRecordId;
                //     $temp_data_results = $wpdb->get_results($select_temp_data, ARRAY_A);
                //     foreach ($temp_data_results as $temp_data_result) {

                //         if ($temp_data_result['type'] == 'canvas_html') {

                //             $canvas_html_temp = $temp_data_result['desc_text'];
                //         }
                //         if ($temp_data_result['type'] == 'next_lesson_task') {

                //             $text = explode('~~!', $temp_data_result['desc_text']);
                //             $cnt = 1;
                //             foreach ($text as $txt) {
                //                 if ($txt != '') {
                //                     $next_lesson_task_temp[] = $txt;
                //                 }
                //                 $cnt++;
                //             }
                //         }
                //         if ($temp_data_result['type'] == 'homework_lesson_material_task') {

                //             $text = explode('~~!', $temp_data_result['desc_text']);
                //             $cnt = 1;
                //             foreach ($text as $txt) {
                //                 if ($txt != '') {
                //                     $homework_lesson_material_task_temp[] = $txt;
                //                 }
                //                 $cnt++;
                //             }
                //         }
                //         if ($temp_data_result['type'] == 'lesson_task') {

                //             $text = explode('~~!', $temp_data_result['desc_text']);
                //             $cnt = 1;
                //             foreach ($text as $txt) {
                //                 if ($txt != '') {
                //                     $lesson_task_temp[] = $txt;
                //                 }
                //                 $cnt++;
                //             }
                //         }
                //         if ($temp_data_result['type'] == 'topic_tag') {

                //             $text = explode('*$', $temp_data_result['desc_text']);
                //             $cnt = 1;
                //             foreach ($text as $txt) {
                //                 if ($txt != '') {
                //                     $temp_topic_tag[] = $txt;
                //                 }
                //                 $cnt++;
                //             }
                //         }
                //         if ($temp_data_result['type'] == 'lesson_material_task') {

                //             $text = explode('~~!', $temp_data_result['desc_text']);
                //             $cnt = 1;
                //             foreach ($text as $txt) {
                //                 if ($txt != '') {
                //                     $lesson_material_task_temp[] = $txt;
                //                 }
                //                 $cnt++;
                //             }
                //         }
                //         if ($temp_data_result['type'] == 'strong_points') {

                //             $strong_points_temp = $temp_data_result['desc_text'];
                //         }
                //         if ($temp_data_result['type'] == 'points_to_improve') {

                //             $points_to_improve_temp = $temp_data_result['desc_text'];
                //         }
                //         if ($temp_data_result['type'] == 'lesson_comments') {

                //             $lesson_comments_temp = $temp_data_result['desc_text'];
                //         }
                //     }
                // }
                // $date = date('Y-m-d');
                // if ($_SERVER['REMOTE_ADDR'] == '103.36.77.45' || $_SERVER['REMOTE_ADDR'] == '122.176.112.152') {

                //     $date = '2018-09-10';
                //     //echo "SELECT * FROM ".$wpdb->prefix."lesson_record  where teacher_id =  ".$user_ID." and status ='Scheduled' and taught_on <= '".$date."' order by taught_on DESC, taught_at DESC";
                // }

                // $time = date('H:i');
                // $query = "SELECT * FROM " . $wpdb->prefix . "lesson_record  where teacher_id =  " . $user_ID . " and status ='Scheduled' and taught_on <= '" . $date . "' order by taught_on DESC, taught_at DESC";
                // $lessons_data = $wpdb->get_results($query, ARRAY_A);
                // $tr = '';
                // $tr2 = '';
                // if (count($lessons_data) > 0) {

                //     $count = 1;
                //     $date_count = 1;
                //     $cnt = 1;

                //     foreach ($lessons_data as $lesson_data) {

                //         $fname = get_user_meta($lesson_data['student_id'], 'first_name', true);
                //         $lname = get_user_meta($lesson_data['student_id'], 'last_name', true);
                //         $student_name = $fname . ' ' . $lname;
                //         if (ICL_LANGUAGE_CODE == "en") {

                //             $link = site_url('en/teacher-onepage');
                //         } else {

                //             $link = site_url('teacher-onepage-ja');
                //         }
                //         $class = '';
                //         $lesson_date_time = strtotime($lesson_data['taught_on']);
                //         $current_date = strtotime(date('Y-m-d'));
                //         $cutten_time = strtotime(date('H:i:s'));
                //         $taught_on_time = strtotime($lesson_data['taught_at']);
                //         $duration = $lesson_data['duration'] == 30 ? 25 : $lesson_data['duration'] == 60 ? 50 : $lesson_data['duration'];
                //         $lessonEndTime = $taught_on_time + ($duration * 60);
                //         if ($lesson_date_time == $current_date) {

                //             if ($current_date == $lesson_date_time && ($taught_on_time <= $cutten_time && $lessonEndTime >= $cutten_time)) {
				// 			//if ($current_date == $lesson_date_time) {	
                //                 $class = 'current-lesson';

                //                 $tr2 = '<tr class="type-post status-publish format-standard hentry category-video ' . $class . '" style="color:#000; ">
				// 					<td align="center" class="manage-column num">1</td>
				// 					<td class="categories ">' . $student_name . '</td>
				// 					<td class="categories ">' . $lesson_data['package'] . '</td>
				// 					<td class="categories">' . $lesson_data['location'] . '</td>
				// 					<td class="capitalize">' . $lesson_data['duration'] . '</td>
				// 					<td class="capitalize">' . $lesson_data['taught_on'] . '</td>
				// 					<td class="capitalize">' . $lesson_data['taught_at'] . '</td>
				// 					<td class="capitalize"><a href="' . $link . '?lesson_record_id=' . $lesson_data['id'] . '&taught_date=' . $lesson_data['taught_on'] . '&taught_time=' . $lesson_data['taught_at'] . '">Start Session</a></td>
				// 					</tr>';
                //             } else {

                //                 $class = 'today-lesson';
                //             }
                //         } else {

                //             $class = 'previous_lesson';
                //         }
                //         $tr .= '<tr class="type-post status-publish format-standard hentry category-video ' . $class . '" style="color:#000; ">
				// 					<td align="center" class="manage-column num">' . $count . '</td>
				// 					<td class="categories ">' . $student_name . '</td>
				// 					<td class="categories ">' . $lesson_data['package'] . '</td>
				// 					<td class="categories">' . $lesson_data['location'] . '</td>
				// 					<td class="capitalize">' . $lesson_data['duration'] . '</td>
				// 					<td class="capitalize">' . $lesson_data['taught_on'] . '</td>
				// 					<td class="capitalize">' . $lesson_data['taught_at'] . '</td>
				// 					<td class="capitalize"><a href="' . $link . '?lesson_record_id=' . $lesson_data['id'] . '&taught_date=' . $lesson_data['taught_on'] . '&taught_time=' . $lesson_data['taught_at'] . '">Start Session</a></td>
				// 				</tr>';
                //         $i++;
                //         $count++;
                //     }
                // } else {

                //     $tr = '';
                // }
                ?>
                <span data-mode="toggle" id="student_span" class="acc-trigger <?php // if (!isset($lessonRecordId)) { ?> active <?php // } ?>"><a href="#"><?php //echo __('Student Sessions', 'accio'); ?></a></span>
                <div class="acc-container" id="student_div" <?php // if (!isset($lessonRecordId) && $lessonRecordId == '') { ?> style="display:block" <?php // } ?>>
                    <?php // if ($tr2 != '') { ?>
                        <div class="clearfix">
                            <a href="javascript:void(0);" id="show_all_bookings" class="show_all_bookings glow pull-right button">Show All</a>
                        </div>
                    <?php // } ?>
                    <table width="100%" class="one-page-table-block" cellpadding="0" cellspacing="0" id="current_booking" style="<?php
                    // if ($tr2 == '') {
                    //     echo 'display:none;';
                    // }
                    ?>">
                        <thead>
                            <tr>
                                <th align="center"><?php //echo __('SNo.', 'accio'); ?></th>
                                <th><?php //echo __('Student', 'accio'); ?></th>
                                <th><?php //echo __('Package', 'accio'); ?></th>
                                <th><?php //echo __('Location', 'accio'); ?></th>
                                <th><?php //echo __('Duration', 'accio'); ?></th>
                                <th><?php //echo __('Date', 'accio'); ?></th>
                                <th><?php //echo __('Time', 'accio'); ?></th>
                                <th><?php //echo __('Action', 'accio'); ?></th>
                            </tr>
                        </thead>
                        <?php //echo $tr2; ?>
                    </table>

                    <table width="100%" class="one-page-table-block" cellpadding="0" cellspacing="0" style="<?php
                    // if ($tr2 != '') {
                    //     echo 'display:none;';
                    // }
                    ?>" id="all_bookings">
                        <thead>
                            <tr>
                                <th align="center"><?php //echo __('SNo.', 'accio'); ?></th>
                                <th><?php //echo __('Student', 'accio'); ?></th>
                                <th><?php //echo __('Package', 'accio'); ?></th>
                                <th><?php //echo __('Location', 'accio'); ?></th>
                                <th><?php //echo __('Duration', 'accio'); ?></th>
                                <th><?php //echo __('Date', 'accio'); ?></th>
                                <th><?php //echo __('Time', 'accio'); ?></th>
                                <th><?php //echo __('Action', 'accio'); ?></th>
                            </tr>
                        </thead>
                        <?php  // echo $tr; ?>
                    </table>
                </div>
                <?php // if (isset($lessonRecordId) && $lessonRecordId != '') { ?>
                    <span data-mode="toggle" class="acc-trigger lesson_record_id_span"><a href="#"><?php //echo __('OnePage', 'accio'); ?></a></span>
                    <div class="acc-container lesson_record_id_div" style="display:block">
                        <div class="editor_div" style="min-height:350px; margin-bottom:20px;">
                            <img style="display:none" id="loading_image" src="<?php //bloginfo('template_directory'); ?>/images/loading.gif"/>
                            <div class="all_text_areas">
                                <fieldset class="graph-container current-page-graph onepage-graph">
                                    <legend class="graph-container-heading" align="center">
                                        <?php
                                        // $select_date_for_title = 'select * from ' . $wpdb->prefix . 'lesson_record where id = ' . $lessonRecordId;
                                        // $select_date_for_title_result = $wpdb->get_row($select_date_for_title);
                                        // $_SESSION['found_student'] = $select_date_for_title_result->student_id;
                                        // $_SESSION['this_page_session_id'] = '';
                                        // unset($_SESSION['this_page_session_id']);
                                        // $fname = get_user_meta($select_date_for_title_result->student_id, 'first_name', true);
                                        // $lname = get_user_meta($select_date_for_title_result->student_id, 'last_name', true);
                                        // $folder_name = $fname . '_' . $lname;
                                        // $lesson_no = getNextLessonNo($select_date_for_title_result->order_id);
                                        // $order_id = $select_date_for_title_result->order_id;
                                        // if ($select_date_for_title_result->taught_on) {

                                        //     echo $lesson_no . ' ' . $fname . ' ' . $lname . ' | Accent OnePage ' . date('ymd', strtotime($select_date_for_title_result->taught_on));
                                        // } else {

                                        //     echo $lesson_no . ' ' . $fname . ' ' . $lname . ' | Accent OnePage ' . date('ymd', strtotime($unique_keys->taught_on));
                                        // }
                                        // $lastUniqueId = getLastWrappedLessonId($select_date_for_title_result->student_id);
                                        // $last_to_last_UniqueId = getLasttoLastWrappedLessonId($select_date_for_title_result->student_id);
                                        ?>
                                    </legend>
                                    <div id="editor_textarea" contentEditable="true" class="editor_textarea"><?php
                                        // if ($canvas_html_temp) {
                                        //     echo $canvas_html_temp;
                                        // }
                                        ?></div>
                                </fieldset>
                                <?php //echo $lastUniqueId; echo '<br>'.$last_to_last_UniqueId;   ?>
                                <div class="clearfix btns-wrapper"> 
                                    <a href="javascript:void(0);" class="bottom-wrap-btn btn-t1" title="{{ _ }} Topic Tag" onclick="replaceCopiedToTopicTag('topic_tag')"><img src="<?php bloginfo('template_directory'); ?>/images/icon-tag.svg" alt="Clear-icon"/></a>
                                    <a href="javascript:void(0);" class="bottom-wrap-btn btn-t2" title="{ _ } Keyword" onclick="replaceCopiedToTopicTag('keyword')"> <img src="<?php //bloginfo('template_directory'); ?>/images/icon-keyword.svg" alt="preview-icon"/></a>	
                                    <a href="javascript:void(0);" class="bottom-wrap-btn btn-t3" title="Search google" onclick="replaceCopiedToTopicTag('key_phrase')"> <img src="<?php //bloginfo('template_directory'); ?>/images/icon-keyphrase.svg" alt="Preview-icon"/></a>

                                    <a href="javascript:void(0);" id="undo" class="bottom-wrap-btn" title="Undo"><img src="<?php //bloginfo('template_directory'); ?>/images/icon-undo.svg" alt="Undo"/></a>	

                                    <a href="javascript:void(0);" class="bottom-wrap-btn btn-t4" title="Clear Format" onclick="replaceCopiedText()"><img src="<?php //bloginfo('template_directory'); ?>/images/icon-clear.svg" alt="Clear-icon"/></a>
                                    <a href="javascript:void(0);" class="bottom-wrap-btn botm-eye-icon-white" title="Cancel Preview" onclick="revertToOldHtml()" style="display: none;"><img src="<?php //bloginfo('template_directory'); ?>/images/icon-eye-white.svg" alt="preview-icon"/></a>	
                                    <a href="javascript:void(0);" class="bottom-wrap-btn botm-eye-icon" title="Preview" onclick="preview_lesson()"><img src="<?php //bloginfo('template_directory'); ?>/images/icon-eye.svg" alt="Preview-icon"/></a>	
                                    <a href="javascript:void(0);" class="bottom-wrap-btn" title="Wrap" onclick="wrap_lesson('wrap')"><img src="<?php //bloginfo('template_directory'); ?>/images/icon-wrap.svg" alt="Wrap-icon"/></a>




                                    <?php //if($_SERVER['REMOTE_ADDR'] == '103.36.77.44' ) {   ?>
                                    <!--button  class="bottom-wrap-btn">Undo</button-->
                                    <!--button id="redo" class="bottom-wrap-btn">Redo</button-->
                                    <?php //} ?>
                                </div>
                                <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Upload ・ アップロード </a></span>
                                <div class="acc-container clearfix" style="display: none;">
                                    <?php
                                    // $student_google_drive_folder_id = get_user_meta($select_date_for_title_result->student_id, 'wp_use_your_drive_linkedto', true);
                                    // if (is_array($student_google_drive_folder_id) && count($student_google_drive_folder_id) > 0) {

                                    //     echo do_shortcode('[useyourdrive dir="' . $student_google_drive_folder_id['folderid'] . '" mode="files" viewrole="administrator|author|contributor|editor|birs_staff_member|subscriber|teacher|guest" downloadrole="administrator|author|contributor|editor|birs_staff_member|subscriber|teacher|guest" upload="1" uploadrole="administrator|author|contributor|editor|birs_staff_member|subscriber" userfolders="auto" viewuserfoldersrole="administrator|birs_staff_member|teacher"]');
                                    // }
                                    ?>
                                </div>
                                <?php // if ($lastUniqueId != '') { ?>
                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Previous Lesson PDF ・ 前回のレッスンのPDF</a></span>
                                    <div class="acc-container clearfix" style="display: none;">
                                        <?php
                                        // $pdf_link = createPdfFileUrl($folder_name, $lastUniqueId);
                                        // if ($pdf_link != false) {
                                        //     echo '<a target="blank" class="glow" href="' . $pdf_link . '">Click here</a> to view previous lesson pdf.';
                                        // }
                                        ?>
                                    </div>
                                <?php // }
                                ?>
                                <div class="lessons-comments" style="width: 100%;">
                                    <!--Table 4 Start--->
                                    <span data-mode="toggle" class="acc-trigger review_block_span"><a href="javascript:void(0);">Review ・ 復習</a></span>
                                    <div class="acc-container ac1 review_block_div" style="display:block">
                                        <div>
                                            <?php
                                            // $rating_row_data = '';
                                            // $last_rating_row_data = '';

                                            // $row_query = 'select * from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $lastUniqueId . '"';
                                            // $last_row_query = 'select * from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $last_to_last_UniqueId . '"';

                                            // $rating_row_data = $wpdb->get_row($row_query);
                                            // $last_rating_row_data = $wpdb->get_row($last_row_query);
                                            //pr($last_rating_row_data);
                                            ?>
                                            <div class="lesson-topic-wrapper">
                                                <table cellspacing="0" cellpadding="0" class="lesson-topic-table">
                                                    <thead>
                                                        <tr style="color:#000;">
                                                            <th class="pos" colspan="2">Lesson Topics・レッスンの話題</th>
                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <td class=""><?php //echo __('Previous・前回', 'accio'); ?></td>
                                                        <td class="">
                                                            <?php
                                                            // $parts = explode(",", stripslashes($rating_row_data->topic));
                                                            // $result = implode(', ', $parts);

                                                            // if ($result) {
                                                                ?>

                                                                <div>
                                                                    <a class="glow prev_topic_text_<?php //echo $rating_row_data->id; ?>" target="_blank" href="https://translate.google.com/#en/ja/<?php //echo $result; ?>"><?php //echo $result; ?></a>
                                                                    <input type="text" class="editable_input_box prev_topic_text_box prev_topic_input_<?php //echo $rating_row_data->id; ?>" value="<?php //echo $result; ?>" style="display:none" data-idval="<?php //echo $rating_row_data->id; ?>" >
                                                                    <div class="pull-right edit-actions">
                                                                        <a href="javascript:void(0)" style="display:none" data-atr="<?php //echo $rating_row_data->id; ?>"  class="topic_save_button" id="topic_save_button_<?php //echo $rating_row_data->id; ?>"><i class="fa fa-check"></i></a>

                                                                        <a href="javascript:void(0)" style="display:none" class="topic_cancel_button" id="topic_cancel_button_<?php //echo $rating_row_data->id; ?>" data-atr="<?php //echo $rating_row_data->id; ?>"><i class="fa fa-times"></i></a>

                                                                        <i class="fa fa-pencil-square-o edit_prev_topic_<?php //echo $rating_row_data->id; ?>" aria-hidden="true" onclick="edit_prev_topic('<?php //echo $rating_row_data->id; ?>')"></i>
                                                                    </div>

                                                                </div>
                                                            <?php // }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class=""><?php //echo __('Current・今回', 'accio'); ?></td>
                                                        <td class="current_lesson_topic">
                                                            <?php
                                                            // if (is_array($temp_topic_tag)) {
                                                            //     echo implode(', ', $temp_topic_tag);
                                                            // }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="status-options-wrapper">
                                            <span class="status-options" style="display: inline-block;">
                                                <a href="javascript:void(0)" onclick="change_status_of_arp('2')" class="arp_status x-class"><img src="<?php //bloginfo('template_directory'); ?>/images/cross-1.png" alt="Cross"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_arp('1')" class="arp_status o-class"><img src="<?php //bloginfo('template_directory'); ?>/images/oval.png" alt="oval"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_arp('4')" class="arp_status triangle-class"><img src="<?php //bloginfo('template_directory'); ?>/images/triangle.png" alt="triangle"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_arp('5')" class="arp_status square-class"><img src="<?php //bloginfo('template_directory'); ?>/images/square.png" alt="square"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_arp('6')" class="arp_status reverse-btn"><img src="<?php //bloginfo('template_directory'); ?>/images/reverse.png" alt="reverse"/></a>

                                            </span>
                                        </div>
                                        <div class="review-table-wrapper">
                                            <table class="recall-table review-table review_table_checkbox" cellspacing="0" cellpadding="0" border="1">
                                                <thead>
                                                    <tr style="color:#000;">
                                                        <!--th class="type">Type・事項</th>
                                                        <th class="pos"><?php //echo __('POS', 'accio'); ?></th-->
                                                        <th class="type-desc">Active Recall Pair・アクティブリコールペアの復習</th>
                                                        <th class="type-status">Status</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                // $get_one_key = 'select unique_key from ' . $wpdb->prefix . 'onepage_rating where student_id = ' . $select_date_for_title_result->student_id . ' group by unique_key order by id DESC limit 1';
                                                // $first_key_data = $wpdb->get_row($get_one_key, ARRAY_A);
                                                // $last_inserted_unique_key = $first_key_data['unique_key'];
                                                // $select_old_arp = "select * from " . $wpdb->prefix . "onepage_active_recall_pair where unique_key = '" . $last_inserted_unique_key . "' and status != '1' and status != '3' and status != '5'";
                                                // $old_arp_results = $wpdb->get_results($select_old_arp, ARRAY_A);
                                                // $check_arp_exist = "select * from " . $wpdb->prefix . "onepage_temp_arp where unique_key = '" . $last_inserted_unique_key . "'";
                                                // $check_arp_exist_results = $wpdb->get_results($check_arp_exist, ARRAY_A);
                                                // if (empty($check_arp_exist_results)) {
                                                //     foreach ($old_arp_results as $old_arp_result) {

                                                //         $insert = 'insert into ' . $wpdb->prefix . 'onepage_temp_arp set ';
                                                //         $insert .= 'student_id = "' . $old_arp_result['student_id'] . '", ';
                                                //         $insert .= 'student_email = "' . $old_arp_result['student_email'] . '", ';
                                                //         $insert .= 'taught_on = "' . $old_arp_result['taught_on'] . '", ';
                                                //         $insert .= 'taught_at = "' . $old_arp_result['taught_at'] . '", ';
                                                //         $insert .= 'lesson_record_id = ' . $old_arp_result['lesson_record_id'] . ', ';
                                                //         $insert .= 'p_id = ' . $old_arp_result['p_id'] . ', ';
                                                //         $insert .= 'type = "' . $old_arp_result['type'] . '", ';
                                                //         $insert .= 'pos = "' . $old_arp_result['pos'] . '", ';
                                                //         $insert .= 'arp = "' . addslashes($old_arp_result['arp']) . '", ';
                                                //         $insert .= 'arp_id = ' . $old_arp_result['arp_id'] . ', ';
                                                //         $insert .= 'is_new = "' . $old_arp_result['is_new'] . '", ';
                                                //         $insert .= 'status = "' . $old_arp_result['status'] . '", ';
                                                //         $insert .= 'order_id = "' . $old_arp_result['order_id'] . '", ';
                                                //         $insert .= 'arp_table_id = "' . $old_arp_result['id'] . '", ';
                                                //         $insert .= 'unique_key = "' . $old_arp_result['unique_key'] . '"';
                                                //         $wpdb->query($insert);
                                                //         $insert_id = $wpdb->insert_id;
                                                //     }
                                                // }
                                                // if ($lastUniqueId != '') {

                                                //     $row_query = 'select * from ' . $wpdb->prefix . 'onepage_temp_arp where unique_key = "' . $lastUniqueId . '"';
                                                //     $row_data = $wpdb->get_results($row_query);

                                                //     $i = 0;
                                                //     foreach ($row_data as $unique_key) {
                                                        ?>

                                                        <tr>
                                                            <td class="type-desc" <?php //if ($i % 2 == 0) { ?>style="border-bottom:1px solid #fff;" <?php //} ?>>
                                                                <a class="glow text_<?php //echo $unique_key->arp_table_id;
                                            //echo ' ' . $unique_key->arp_id . '_' . $i; ?>" target="_blank" href="https://translate.google.com/#en/ja/<?php //echo $unique_key->arp; ?>"><?php //echo $unique_key->arp; ?></a>
                                                                <input type="text" id="arp_id_<?php//echo $unique_key->arp_table_id; ?>" class="editable_input_box arp_text_box input_<?php// echo $unique_key->arp_table_id; ?>" value="<?php //echo htmlspecialchars($unique_key->arp); ?>" style="display:none" data-idval="<?php //echo $unique_key->arp_table_id; ?>">
                                                                <div class="pull-right edit-actions">
                                                                    <a style="display:none" value="Save" id="arp_save_btn_<?php //echo $unique_key->arp_table_id; ?>" class="arp_save_btn" data-atr="<?php //echo $unique_key->arp_table_id; ?>"><i class="fa fa-check"></i></a>

                                                                    <a href="javascript:void(0)" style="display:none" value="Cancel" id="arp_cancel_btn_<?php //echo $unique_key->arp_table_id; ?>" class="arp_cancel_btn" data-atr="<?php //echo $unique_key->arp_table_id; ?>"><i class="fa fa-times"></i></a>
                                                                    <i class="fa fa-pencil-square-o edit_arp_<?php //echo $unique_key->arp_table_id; ?>" aria-hidden="true" onclick="edit_arp('<?php //echo $unique_key->arp_table_id; ?>')"></i>
                                                                </div>
                                                            </td>
            <?php if ($i == 0) { ?>													

                                                                <td class="type-status" rowspan="2" align="center" valign="middle" style="position: relative;">
                                                                    <input type="checkbox" class="check_box_id_<?php // echo $unique_key->arp_id; ?>" value="<?php // echo $unique_key->arp_id; ?>">
                                                                    <span class="status-link status-link<?php  // echo $unique_key->arp_id; ?>">

                                                                        <?php
                                                                        // if ($unique_key->status == '1') {

                                                                        //     echo '<a href="javascript:void(0)" class="o-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/oval.png" alt="Cross"/></a>';
                                                                        // } else if ($unique_key->status == '2') {

                                                                        //     echo '<a href="javascript:void(0)" class="x-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/cross-1.png" alt="Cross"/></a>';
                                                                        // } else if ($unique_key->status == '3') {

                                                                        //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                        // } else if ($unique_key->status == '5') {

                                                                        //     echo '<a href="javascript:void(0)" class="square-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/square.png" alt="Cross"/></a>';
                                                                        // } else if ($unique_key->status == '6') {

                                                                        //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                        // } else {

                                                                        //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                        // }
                                                                        ?>

                                                                    </span>
                                                                </td>
                                                                <?php
                                                            // }
                                                            // $i++;
                                                            // if ($i == 2) {
                                                            //     $i = 0;
                                                            // }
                                                            ?>
                                                        </tr>
                                                        <?php
                                                //     }
                                                // } else {
                                                    ?>

                                                    <tr><td colspan="4">A session has not been wrapped for this student.</td></tr>
                                                <?php  // }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="status-options-wrapper">
                                            <span class="status-options" style="display: inline-block;">
                                                <a href="javascript:void(0)" onclick="change_status_of_keyword('2')" class="arp_status x-class"><img src="<?php //bloginfo('template_directory'); ?>/images/cross-1.png" alt="Cross"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_keyword('1')" class="arp_status o-class"><img src="<?php //bloginfo('template_directory'); ?>/images/oval.png" alt="oval"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_keyword('4')" class="arp_status triangle-class"><img src="<?php //bloginfo('template_directory'); ?>/images/triangle.png" alt="triangle"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_keyword('5')" class="arp_status square-class"><img src="<?php //bloginfo('template_directory'); ?>/images/square.png" alt="square"/></a>
                                            </span>
                                        </div>
                                        <div class="review-table-wrapper keyword-review-table-wrapper">
                                            <table class="review-table review_keyphrase_table_checkbox" cellspacing="0" cellpadding="0" border="1">
                                                <thead>
                                                    <tr style="color:#000;">

                                                        <th class="type-desc">Key words and phrases・キーワードとフレーズの復習</th>
                                                        <th class="type-status">Status</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                // $select_old_kwyword = "select * from " . $wpdb->prefix . "onepage_keywords_phrases where unique_key = '" . $last_inserted_unique_key . "' and status != '1' and status != '5'";
                                                // $old_keyword_results = $wpdb->get_results($select_old_kwyword, ARRAY_A);
                                                // $check_keyword_exist = "select * from " . $wpdb->prefix . "onepage_temp_keyword where unique_key = '" . $last_inserted_unique_key . "'";
                                                // $check_keyword_exist_results = $wpdb->get_results($check_keyword_exist, ARRAY_A);
                                                // if (empty($check_keyword_exist_results)) {

                                                //     foreach ($old_keyword_results as $old_keyword_result) {

                                                //         $insert = 'insert into ' . $wpdb->prefix . 'onepage_temp_keyword set ';
                                                //         $insert .= 'student_id = "' . $old_keyword_result['student_id'] . '", ';
                                                //         $insert .= 'student_email = "' . $old_keyword_result['student_email'] . '", ';
                                                //         $insert .= 'taught_on = "' . $old_keyword_result['taught_on'] . '", ';
                                                //         $insert .= 'taught_at = "' . $old_keyword_result['taught_at'] . '", ';
                                                //         $insert .= 'type = "' . $old_keyword_result['type'] . '", ';
                                                //         $insert .= 'pos = "' . $old_keyword_result['pos'] . '", ';
                                                //         $insert .= 'description = "' . $old_keyword_result['description'] . '", ';
                                                //         $insert .= 'arp_id = ' . $old_keyword_result['arp_id'] . ', ';
                                                //         $insert .= 'status = "' . $old_keyword_result['status'] . '", ';
                                                //         $insert .= 'is_new = "' . $old_keyword_result['is_new'] . '", ';
                                                //         $insert .= 'order_id = "' . $old_keyword_result['order_id'] . '", ';
                                                //         $insert .= 'lesson_record_id = ' . $old_keyword_result['lesson_record_id'] . ', ';
                                                //         $insert .= 'keyword_table_id = ' . $old_keyword_result['id'] . ', ';
                                                //         $insert .= 'unique_key = "' . $old_keyword_result['unique_key'] . '"';
                                                //         $wpdb->query($insert);
                                                //     }
                                                // }
                                                // if ($lastUniqueId != '') {

                                                //     $last_clicked_item_query = 'select last_clicked_item from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $lastUniqueId . '"';
                                                //     $last_clicked_item_result = $wpdb->get_row($last_clicked_item_query, ARRAY_A);
                                                //     $clicked_item = $last_clicked_item_result['last_clicked_item'];
                                                //     $row_query = 'select * from ' . $wpdb->prefix . 'onepage_temp_keyword where unique_key = "' . $lastUniqueId . '"';
                                                //     $row_data = $wpdb->get_results($row_query);
                                                //     $i = 0;
                                                //     foreach ($row_data as $unique_key) {
                                                        ?>

                                                        <tr>
                                                            <td class="type-desc">
                                                                <a class="glow text_<?php //echo $unique_key->keyword_table_id; 
                                                                ?>" target="_blank" href="https://translate.google.com/#en/ja/<?php 
                                                               // echo $unique_key->description; ?>"><?php //echo $unique_key->description; ?></a>

                                                                <input type="text" id="keyword_id_<?php //echo $unique_key->keyword_table_id; ?>" class="editable_input_box keyword_text_box input_<?php //echo $unique_key->keyword_table_id; ?>" value="<?php //echo htmlspecialchars($unique_key->description); ?>" style="display:none" data-idval="<?php //echo $unique_key->keyword_table_id; ?>" >
                                                                <div class="pull-right edit-actions">
                                                                    <a href="javascript:void(0)"  style="display:none"  id="keyword_save_btn_<?php //echo $unique_key->keyword_table_id; ?>" class="keyword_save_btn" value="Save" data-atr="<?php //echo $unique_key->keyword_table_id; ?>"><i class="fa fa-check"></i></a>

                                                                    <a href="javascript:void(0)" style="display:none" id="keyword_cancel_btn_<?php //echo $unique_key->keyword_table_id; ?>" class="keyword_cancel_btn" value="Cancel" data-atr="<?php //echo $unique_key->keyword_table_id; ?>"><i class="fa fa-times"></i></a>

                                                                    <i class="fa fa-pencil-square-o edit_keyword_<?php //echo $unique_key->keyword_table_id; ?>" aria-hidden="true" onclick="edit_keyword('<?php //echo $unique_key->keyword_table_id; ?>')"></i>
                                                                </div>

                                                            </td>
                                                            <td class="type-status"  align="center" valign="middle" style="position: relative;">
                                                                <input type="checkbox" class="keyphrase_checkbox_id_<?php //echo $unique_key->id; ?>" value="<?php //echo $unique_key->id; ?>">
                                                                <span class="status-link keyphrase_status_<?php //echo $unique_key->id; ?> key_phrase_arp_status_<?php //echo $unique_key->arp_id ?>" >
                                                                    <?php
                                                                    // if ($unique_key->status == '1') {

                                                                    //     echo '<a href="javascript:void(0)" class="o-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/oval.png" alt="Cross"/></a>';
                                                                    // } else if ($unique_key->status == '2') {

                                                                    //     echo '<a href="javascript:void(0)" class="x-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/cross-1.png" alt="Cross"/></a>';
                                                                    // } else if ($unique_key->status == '3') {

                                                                    //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                    // } else if ($unique_key->status == '5') {

                                                                    //     echo '<a href="javascript:void(0)" class="square-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/square.png" alt="Cross"/></a>';
                                                                    // } else {
                                                                    //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                    // }
                                                                    ?>
                                                                </span>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                //     }
                                                // } else {
                                                    ?>

                                                    <tr><td colspan="4">You have not wrapped any lesson for this student yet.</td></tr>
                                                    <?php
                                                // }
                                                // if ($clicked_item == '') {

                                                //     $last_clicked_item_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type = "last_clicked_item" and lesson_record_id = "' . $lessonRecordId . '"';
                                                //     $last_clicked_item_result = $wpdb->get_row($last_clicked_item_query, ARRAY_A);
                                                //     if (is_array($last_clicked_item_result) && count($last_clicked_item_result) > 0) {
                                                //         $clicked_item = $last_clicked_item_result['desc_text'];
                                                //     }
                                                // }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="status-options-wrapper">
                                            <span class="status-options" style="display: inline-block;">
                                                <a href="javascript:void(0)" onclick="change_status_of_cor_inc('2')" class="arp_status x-class"><img src="<?php //bloginfo('template_directory'); ?>/images/cross-1.png" alt="Cross"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_cor_inc('1')" class="arp_status o-class"><img src="<?php //bloginfo('template_directory'); ?>/images/oval.png" alt="oval"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_cor_inc('4')" class="arp_status triangle-class"><img src="<?php //bloginfo('template_directory'); ?>/images/triangle.png" alt="triangle"/></a>
                                                <a href="javascript:void(0)" onclick="change_status_of_cor_inc('5')" class="arp_status square-class"><img src="<?php //bloginfo('template_directory'); ?>/images/square.png" alt="square"/></a>
                                            </span>
                                        </div>
                                        <div class="review-table-wrapper">
                                            <table class="correct-incorrect-table review-table">
                                                <thead>
                                                    <tr>
                                                        <th class="incorrect-th">Incorrect Phrases・間違えたフレーズ</th>
                                                        <th class="correct-th">Corrected Phrases・正しいフレーズ</th>
                                                        <th class="status-th"> Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // $select_old_cor_inc = "select * from " . $wpdb->prefix . "onepage_correct_incorrect_phrases where unique_key = '" . $last_inserted_unique_key . "' and status != '1' and status != '5'";
                                                    // $old_cor_inc_results = $wpdb->get_results($select_old_cor_inc, ARRAY_A);
                                                    // $check_cor_inc_exist = "select * from " . $wpdb->prefix . "onepage_temp_cor_in where unique_key = '" . $last_inserted_unique_key . "'";
                                                    // $check_cor_inc_results = $wpdb->get_results($check_cor_inc_exist, ARRAY_A);
                                                    // if (empty($check_cor_inc_results)) {

                                                    //     foreach ($old_cor_inc_results as $old_cor_inc_result) {

                                                    //         $insert = 'insert into ' . $wpdb->prefix . 'onepage_temp_cor_in set ';
                                                    //         $insert .= 'student_id = "' . $old_cor_inc_result['student_id'] . '", ';
                                                    //         $insert .= 'incorrect_phrase = "' . $old_cor_inc_result['incorrect_phrase'] . '", ';
                                                    //         $insert .= 'incorrect_phrase_ja = "' . $old_cor_inc_result['incorrect_phrase_ja'] . '", ';
                                                    //         $insert .= 'correct_phrase = "' . $old_cor_inc_result['correct_phrase'] . '", ';
                                                    //         $insert .= 'correct_phrase_ja = "' . $old_cor_inc_result['correct_phrase_ja'] . '", ';
                                                    //         $insert .= 'status = "' . $old_cor_inc_result['status'] . '", ';
                                                    //         $insert .= 'is_new = "' . $old_cor_inc_result['is_new'] . '", ';
                                                    //         $insert .= 'translated = ' . $old_cor_inc_result['translated'] . ', ';
                                                    //         $insert .= 'order_id = ' . $old_cor_inc_result['order_id'] . ', ';
                                                    //         $insert .= 'lesson_record_id = ' . $old_cor_inc_result['lesson_record_id'] . ', ';
                                                    //         $insert .= 'cor_incor_table_id = ' . $old_cor_inc_result['id'] . ', ';
                                                    //         $insert .= 'unique_key = "' . $old_cor_inc_result['unique_key'] . '"';
                                                    //         $wpdb->query($insert);
                                                    //         $insert_id = $wpdb->insert_id;
                                                    //     }
                                                    // }
                                                    // if ($lastUniqueId != '') {

                                                    //     $row_query = 'select * from ' . $wpdb->prefix . 'onepage_temp_cor_in where unique_key = "' . $lastUniqueId . '"';
                                                    //     $row_data = $wpdb->get_results($row_query);
                                                    //     $i = 0;
                                                    //     foreach ($row_data as $unique_key) {
                                                            ?>

                                                            <tr>
                                                                <td>
                                                                    <div class="clearfix most_inner_div">
                                                                        <a class="inner-text incor_text_<?php // echo $unique_key->cor_incor_table_id; ?>" style="display:inline-block; text-decoration:none; color:#002e58"  target="_blank" href="https://translate.google.com/#en/ja/<?php // echo ltrim($unique_key->incorrect_phrase); ?>"><?php // echo ltrim($unique_key->incorrect_phrase); ?></a>

                                                                        <input type="text" class="editable_input_box incorrect_text_box incor_input_<?php // echo $unique_key->cor_incor_table_id; ?>" value="<?php // echo htmlspecialchars($unique_key->incorrect_phrase); ?>" style="display:none" data-idval="<?php // echo $unique_key->cor_incor_table_id; ?>" >

                                                                        <div class="pull-right edit-actions">
                                                                            <a href="javascript:void(0)" style="display:none" data-atr="<?php // echo $unique_key->cor_incor_table_id; ?>"  class="incorrect_save_button" id="incorrect_save_button_<?php //echo //$unique_key->cor_incor_table_id; ?>" ><i class="fa fa-check"></i> </a>
                                                                            <a href="javascript:void(0)"  style="display:none"  class="incorrect_cancel_button" id="incorrect_cancel_button_<?php //echo $unique_key->cor_incor_table_id; ?>"   data-atr="<?php //echo $unique_key->cor_incor_table_id; ?>"><i class="fa fa-times"></i> </a>

                                                                            <i class="fa fa-pencil-square-o edit_incorrect_<?php //echo $unique_key->cor_incor_table_id; ?>" aria-hidden="true" onclick="edit_incorrect('<?php //echo $unique_key->cor_incor_table_id; ?>')"></i>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="clearfix most_inner_div">
                                                                        <a class="inner-text cor_text_<?php // echo $unique_key->cor_incor_table_id; ?>" style="display:inline-block; text-decoration:none; color:#002e58"  target="_blank" href="https://translate.google.com/#en/ja/<?php  // ltrim($unique_key->correct_phrase); ?>">
                                                                            <?php  // echo ltrim($unique_key->correct_phrase); ?>
                                                                        </a>
                                                                        <input type="text" class="editable_input_box correct_text_box cor_input_<?php // echo $unique_key->cor_incor_table_id; ?>" value="<?php // echo htmlspecialchars($unique_key->correct_phrase); ?>" style="display:none" data-idval="<?php // echo $unique_key->cor_incor_table_id; ?>">
                                                                        <div class="pull-right edit-actions">
                                                                            <a href="javascript:void(0)" style="display:none" data-atr="<?php // echo $unique_key->cor_incor_table_id; ?>"  class="correct_save_button" id="correct_save_button_<?php  // echo $unique_key->cor_incor_table_id; ?>"><i class="fa fa-check"></i> </a>
                                                                            <a href="javascript:void(0)" style="display:none"  class="correct_cancel_button" id="correct_cancel_button_<?php // echo $unique_key->cor_incor_table_id; ?>"  data-atr="<?php // echo $unique_key->cor_incor_table_id; ?>"><i class="fa fa-times"></i> </a>
                                                                            <i class="fa fa-pencil-square-o edit_correct_<?php // echo $unique_key->cor_incor_table_id; ?>" aria-hidden="true" onclick="edit_correct('<?php // echo $unique_key->cor_incor_table_id; ?>')"></i>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="clearfix most_inner_div" style="text-align:center">
                                                                        <input type="checkbox" class="check_box_id_<?php // echo $unique_key->id; ?>" value="<?php // echo $unique_key->id; ?>">
                                                                        <span class="status-link cor_incor_status_<?php // echo $unique_key->id; ?>">
                                                                            <?php
                                                                            // if ($unique_key->status == '1') {

                                                                            //     echo '<a href="javascript:void(0)" class="o-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/oval.png" alt="Cross"/></a>';
                                                                            // } else if ($unique_key->status == '2') {

                                                                            //     echo '<a href="javascript:void(0)" class="x-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/cross-1.png" alt="Cross"/></a>';
                                                                            // } else if ($unique_key->status == '3') {

                                                                            //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                            // } else if ($unique_key->status == '5') {

                                                                            //     echo '<a href="javascript:void(0)" class="square-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/square.png" alt="Cross"/></a>';
                                                                            // } else {
                                                                            //     echo '<a href="javascript:void(0)" class="triangle-class" style="cursor:text"><img src="' . get_template_directory_uri() . '/images/triangle.png" alt="Cross"/></a>';
                                                                            // }
                                                                            ?>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        // }
                                                    // } else {
                                                        ?>

                                                        <tr><td colspan="4">A session has not been wrapped for this student.</td></tr>
                                                    <?php  // }
                                                    ?>
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                    <?php
                                    // $stu_level = get_user_meta($select_date_for_title_result->student_id, 'student_level', true);
                                    // if ($stu_level != 0 || $stu_level != '') {
                                    //     $ca_count_query = 'select count(id) as cnt from ' . $wpdb->prefix . 'onepage_points where rating_name = "CA" and level_id = ' . $stu_level . '';
                                    //     $ca_count_result = $wpdb->get_row($ca_count_query, ARRAY_A);
                                    //     $ca_count = $ca_count_result['cnt'];
                                    //     $fp_count_query = 'select count(id) as cnt from ' . $wpdb->prefix . 'onepage_points where rating_name = "FP" and level_id = ' . $stu_level . '';
                                    //     $fp_count_result = $wpdb->get_row($fp_count_query, ARRAY_A);
                                    //     $fp_count = $fp_count_result['cnt'];
                                    //     $lc_count_query = 'select count(id) as cnt from ' . $wpdb->prefix . 'onepage_points where rating_name = "LC" and level_id = ' . $stu_level . '';
                                    //     $lc_count_result = $wpdb->get_row($lc_count_query, ARRAY_A);
                                    //     $lc_count = $lc_count_result['cnt'];
                                    //     $ga_count_query = 'select count(id) as cnt from ' . $wpdb->prefix . 'onepage_points where rating_name = "GA" and level_id = ' . $stu_level . '';
                                    //     $ga_count_result = $wpdb->get_row($ga_count_query, ARRAY_A);
                                    //     $ga_count = $ga_count_result['cnt'];
                                    //     $v_count_query = 'select count(id) as cnt from ' . $wpdb->prefix . 'onepage_points where rating_name = "V" and level_id = ' . $stu_level . '';
                                    //     $v_count_result = $wpdb->get_row($v_count_query, ARRAY_A);
                                    //     $v_count = $v_count_result['cnt'];
                                        ?>
                                        <input type="hidden" value="<?php //echo $ca_count; ?>" id="ca_count"/>
                                        <input type="hidden" value="<?php //echo $fp_count; ?>" id="fp_count"/>
                                        <input type="hidden" value="<?php //echo $lc_count; ?>" id="lc_count"/>
                                        <input type="hidden" value="<?php //echo $ga_count; ?>" id="ga_count"/>
                                        <input type="hidden" value="<?php //echo $v_count; ?>" id="v_count"/>
                                    <?php }
                                    ?>
                                    <input type="hidden" value="<?php //echo $stu_level; ?>" id="student_level"/>
                                    <input type="hidden" value="0" id="check_wrap_click"/>
                                    <script type="text/javascript">
                                        function edit_prev_topic(id) {

                                            jQuery('.edit_prev_topic_' + id).toggle();
                                            jQuery('.prev_topic_text_' + id).toggle();
                                            jQuery('.prev_topic_input_' + id).toggle();
                                            jQuery('#topic_save_button_' + id).toggle();
                                            jQuery('#topic_cancel_button_' + id).toggle();
                                        }
                                        function edit_arp(id) {

                                            jQuery('.edit_arp_' + id).toggle();
                                            jQuery('.text_' + id).toggle();
                                            jQuery('.input_' + id).toggle();

                                            jQuery('#arp_save_btn_' + id).toggle();
                                            jQuery('#arp_cancel_btn_' + id).toggle();

                                        }
                                        function edit_keyword(id) {

                                            jQuery('.edit_keyword_' + id).toggle();
                                            jQuery('.text_' + id).toggle();
                                            jQuery('.input_' + id).toggle();
                                            jQuery('#keyword_save_btn_' + id).toggle();
                                            jQuery('#keyword_cancel_btn_' + id).toggle();
                                        }
                                        function edit_correct(id) {

                                            jQuery('.edit_correct_' + id).toggle();
                                            jQuery('.cor_text_' + id).toggle();
                                            jQuery('.cor_input_' + id).toggle();
                                            jQuery('#correct_save_button_' + id).toggle();
                                            jQuery('#correct_cancel_button_' + id).toggle();

                                        }
                                        function edit_incorrect(id) {

                                            jQuery('.edit_incorrect_' + id).toggle();
                                            jQuery('.incor_text_' + id).toggle();
                                            jQuery('.incor_input_' + id).toggle();
                                            jQuery('#incorrect_save_button_' + id).toggle();
                                            jQuery('#incorrect_cancel_button_' + id).toggle();
                                        }
                                        function replaceCopiedToTopicTag(action) {
                                            if (jQuery('#bind_field').val() == 0) {
                                                var sel = window.getSelection();
                                                var relaced_with = '';
                                                if (sel != '' && sel != 'undefined') {

                                                    /*if (action == 'topic_tag') {
                                                        relaced_with = '{{{' + sel + '}}}';
                                                    }
                                                    if (action == 'keyword') {

                                                        relaced_with = '{{' + sel + '}}';
                                                    }
                                                    if (action == 'key_phrase') {

                                                        relaced_with = '{' + sel + '}';
                                                    }*/
													
													if (action == 'topic_tag') {
                                                        relaced_with = '{{' + sel + '}}';
                                                    } else if (action == 'key_phrase') {
                                                        relaced_with = sel;																											
														var t = sel;
														t = t.toString();
														//	t = t.replace('{', '');
														t = t.replace(/[^\w\s]/gi, '');
														search_google = true;
														window.open('https://www.google.com/search?&q="'+t+'"');
														return;
                                                    } else {
														var t = sel.toString();
														if(t.split(" ").length > 1){
															relaced_with = '{' + sel + '}';
														} else {
															relaced_with = '{' + sel + '}';
														}
													}

                                                    replaceSelectedText(relaced_with, sel);
                                                }
                                            } else {
                                                alert('You are in review mode');
                                            }

                                        }
                                        function replaceSelectedText(replacementText) {
                                            var sel, range;
                                            if (window.getSelection) {
                                                sel = window.getSelection();
                                                if (sel.rangeCount) {
                                                    range = sel.getRangeAt(0);
                                                    range.deleteContents();
                                                    range.insertNode(document.createTextNode(replacementText));
                                                }
                                            } else if (document.selection && document.selection.createRange) {
                                                range = document.selection.createRange();
                                                range.text = replacementText;
                                            }
                                        }

                                        /*function replaceSelectedText(replacementText) {
                                         
                                         var sel, range;
                                         if (window.getSelection) {
                                         sel = window.getSelection();
                                         if (sel.rangeCount) {
                                         range = sel.getRangeAt(0);
                                         range.deleteContents();
                                         var ks = replacementText.split(/\n/);
                                         for (i = ks.length - 1; i >= 0; --i) {
                                         range.insertNode(document.createTextNode(ks[i]));
                                         if (i > 0) {
                                         range.insertNode(document.createElement("BR"));
                                         }
                                         }
                                         }
                                         } else if (document.selection && document.selection.createRange) {
                                         range = document.selection.createRange();
                                         range.text = replacementText;
                                         }
                                         }*/
                                        function show_japanes_text(span_id) {

                                            jQuery('#' + span_id).toggle();
                                            if (jQuery('.' + span_id).text() == 'Read More') {

                                                jQuery('.' + span_id).text('Read Less');
                                            } else {

                                                jQuery('.' + span_id).text('Read More');
                                            }
                                        }
                                        function change_status_of_arp(change_status_to) {
                                            jQuery('.comman_loading_image').show()
                                            var arp_checked_checkboxes = [];
                                            jQuery('.review_table_checkbox :checked').each(function (i, e) {

                                                arp_checked_checkboxes.push(jQuery(this).val());
                                            });
                                            if (arp_checked_checkboxes == '') {
                                                alert('Please check atleast one checkbox before change status');
                                                jQuery('.comman_loading_image').hide();
                                                return false;
                                            }
                                            jQuery.post(
                                                    '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                    {
                                                        action: 'updateArpStatus',
                                                        arpId: arp_checked_checkboxes,
                                                        arpStatus: change_status_to
                                                    }, function (response) {

                                                jQuery('.comman_loading_image').hide()
                                                jQuery('.review_table_checkbox :checked').each(function (i, e) {

                                                    var id_of_checkbox = jQuery(this).val();

                                                    if (change_status_to == 1) {

                                                        jQuery('.status-link' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/oval.png" alt="oval"/>');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').addClass('o-class');


                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').html('O');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').addClass('o-class');

                                                    } else if (change_status_to == 2) {

                                                        jQuery('.status-link' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/cross-1.png" alt="Cross"/>')
                                                        jQuery('.status-link' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').addClass('x-class');


                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/cross-1.png" alt="Cross"/>')
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').addClass('x-class');

                                                    } else if (change_status_to == 5) {

                                                        jQuery('.status-link' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/square.png" alt="square"/>')
                                                        jQuery('.status-link' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').addClass('square-class');

                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/square.png" alt="square"/>')
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').addClass('square-class');
                                                    } else if (change_status_to == 6) {

                                                        var t1 = jQuery('.' + id_of_checkbox + '_0').html()
                                                        var t1_href = jQuery('.' + id_of_checkbox + '_0').attr('href');
                                                        var t2 = jQuery('.' + id_of_checkbox + '_1').html()
                                                        var t2_href = jQuery('.' + id_of_checkbox + '_1').attr('href');

                                                        jQuery('.' + id_of_checkbox + '_0').html(t2);
                                                        jQuery('.' + id_of_checkbox + '_0').attr('href', t2_href);
                                                        jQuery('.' + id_of_checkbox + '_1').html(t1);
                                                        jQuery('.' + id_of_checkbox + '_1').attr('href', t1_href);

                                                        jQuery('.status-link' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/triangle.png" alt="triangle"/>');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').addClass('triangle-class');

                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/triangle.png" alt="triangle"/>');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').addClass('triangle-class');
                                                    } else {

                                                        jQuery('.status-link' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/triangle.png" alt="triangle"/>');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.status-link' + id_of_checkbox + ' a').addClass('triangle-class');

                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/triangle.png" alt="triangle"/>');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.key_phrase_arp_status_' + id_of_checkbox + ' a').addClass('triangle-class');
                                                    }
                                                    jQuery(this).attr('checked', false);
                                                });
                                            });
                                        }
                                        function change_status_of_keyword(change_status_to) {
                                            jQuery('.comman_loading_image').show()
                                            var keyphrase_checked_checkboxes = [];
                                            jQuery('.review_keyphrase_table_checkbox :checked').each(function (i, e) {

                                                keyphrase_checked_checkboxes.push(jQuery(this).val());
                                            });
                                            if (keyphrase_checked_checkboxes == '') {
                                                alert('Please check atleast one checkbox before change status');
                                                jQuery('.comman_loading_image').hide()
                                                return false;
                                            }
                                            jQuery.post(
                                                    '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                    {
                                                        action: 'updateKeyphraseStatus',
                                                        keywordId: keyphrase_checked_checkboxes,
                                                        keywordStatus: change_status_to
                                                    }, function (response) {
                                                jQuery('.comman_loading_image').hide()
                                                jQuery('.review_keyphrase_table_checkbox :checked').each(function (i, e) {

                                                    var id_of_checkbox = jQuery(this).val();

                                                    if (change_status_to == 1) {

                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/oval.png" alt="oval"/>');
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').addClass('o-class');

                                                    } else if (change_status_to == 2) {

                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/cross-1.png" alt="Cross"/>')
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').addClass('x-class');
                                                    } else if (change_status_to == 5) {

                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/square.png" alt="square"/>')
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').addClass('square-class');
                                                    } else {

                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/triangle.png" alt="triangle"/>');
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.keyphrase_status_' + id_of_checkbox + ' a').addClass('triangle-class');
                                                    }
                                                    jQuery(this).attr('checked', false);
                                                });
                                            });
                                        }
                                        function change_status_of_cor_inc(change_status_to) {
                                            jQuery('.comman_loading_image').show()
                                            var cor_incor_checked_checkboxes = [];
                                            jQuery('.correct-incorrect-table :checked').each(function (i, e) {

                                                cor_incor_checked_checkboxes.push(jQuery(this).val());
                                            });
                                            if (cor_incor_checked_checkboxes == '') {
                                                alert('Please check atleast one checkbox before change status');
                                                jQuery('.comman_loading_image').hide()
                                                return false;
                                            }
                                            jQuery.post(
                                                    '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                    {
                                                        action: 'updateCorIncorStatus',
                                                        corIncorId: cor_incor_checked_checkboxes,
                                                        corIncorStatus: change_status_to
                                                    }, function (response) {
                                                jQuery('.comman_loading_image').hide()
                                                jQuery('.correct-incorrect-table :checked').each(function (i, e) {

                                                    var id_of_checkbox = jQuery(this).val();

                                                    if (change_status_to == 1) {

                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/oval.png" alt="oval"/>');
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').addClass('o-class');

                                                    } else if (change_status_to == 2) {

                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/cross-1.png" alt="Cross"/>')
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').addClass('x-class');
                                                    } else if (change_status_to == 5) {

                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/square.png" alt="square"/>')
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').addClass('square-class');
                                                    } else {

                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').html('<img src="<?php //echo get_template_directory_uri(); ?>/images/triangle.png" alt="triangle"/>');
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').removeAttr('class');
                                                        jQuery('.cor_incor_status_' + id_of_checkbox + ' a').addClass('triangle-class');
                                                    }
                                                    jQuery(this).attr('checked', false);
                                                });
                                            });
                                        }

                                        function replaceCopiedText() {
                                            if (jQuery('#bind_field').val() == 0) {
                                                var str = jQuery('#editor_textarea').html();

                                                var regex = new RegExp('<div>', 'g');
                                                str = str.replace(regex, 'BOFDIV');

                                                var regex2 = new RegExp('</div>', 'g');
                                                str = str.replace(regex2, 'EOFDIV');
                                                //alert(str);
                                                var regex2 = new RegExp('<br>', 'g');
                                                str = str.replace(regex2, 'BOFBR');

                                                var regex2 = new RegExp('</p>', 'g');
                                                str = str.replace(regex2, 'EOFP');

                                                var regex2 = new RegExp('</th>', 'g');
                                                str = str.replace(regex2, 'EOFTH');

                                                var regex2 = new RegExp('</td>', 'g');
                                                str = str.replace(regex2, 'EOFTD');

                                                var regex3 = /(<([^>]+)>)/ig
                                                str = str.replace(regex3, "");
                                                //alert(str);

                                                var regex4 = new RegExp('BOFDIV', 'g');
                                                str = str.replace(regex4, '<div>');

                                                var regex5 = new RegExp('EOFDIV', 'g');
                                                str = str.replace(regex5, '</div>');

                                                var regex2 = new RegExp('BOFBR', 'g');
                                                str = str.replace(regex2, '<br>');

                                                var regex2 = new RegExp('EOFP', 'g');
                                                str = str.replace(regex2, '</p>');

                                                var regex2 = new RegExp('EOFTD', 'g');
                                                str = str.replace(regex2, ' ');

                                                var regex2 = new RegExp('EOFTH', 'g');
                                                str = str.replace(regex2, ' ');

                                                jQuery('#editor_textarea').html(str)
                                            } else {
                                                alert('You are in review mode');
                                                return false;
                                            }
                                        }

                                        jQuery(document).ready(function () {

                                            jQuery('.arp_save_btn').click(function () {

                                                var arp_id = jQuery(this).data('atr');
                                                var arp_text = jQuery('#arp_id_' + arp_id).val();

                                                if (arp_text == '') {
                                                    alert('Please enter value ARP cant save blank value');
                                                    return false;
                                                }

                                                jQuery('.comman_loading_image').show();
                                                jQuery.post(
                                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                        {
                                                            action: 'updateArpText',
                                                            arpId: arp_id,
                                                            arpText: arp_text
                                                        }, function (response) {

                                                    jQuery('.text_' + arp_id).show();
                                                    jQuery('.input_' + arp_id).hide();
                                                    jQuery('.text_' + arp_id).text(arp_text);
                                                    jQuery('#arp_id_'.arp_id).val(arp_text);
                                                    jQuery('#arp_save_btn_' + arp_id).hide();
                                                    jQuery('#arp_cancel_btn_' + arp_id).hide();
                                                    jQuery('.edit_arp_' + arp_id).show();
                                                    jQuery('.comman_loading_image').hide();
                                                    generate_pdf_again('<?php echo $lastUniqueId; ?>');

                                                });
                                            });
                                            jQuery('.keyword_save_btn').click(function () {

                                                var keyword_id = jQuery(this).data('atr');
                                                var keyword_text = jQuery('#keyword_id_' + keyword_id).val();
                                                if (keyword_text == '') {
                                                    alert('Please enter value Keyword cant save blank value');
                                                    return false;
                                                }
                                                jQuery('.comman_loading_image').show();
                                                jQuery.post(
                                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                        {
                                                            action: 'updatekeywordText',
                                                            keywordId: keyword_id,
                                                            keywordText: keyword_text
                                                        }, function (response) {

                                                    jQuery('.text_' + keyword_id).show();
                                                    jQuery('.input_' + keyword_id).hide();
                                                    jQuery('.text_' + keyword_id).text(keyword_text);
                                                    jQuery('#keyword_id_' + keyword_id).val(keyword_text);
                                                    jQuery('#keyword_save_btn_' + keyword_id).hide();
                                                    jQuery('#keyword_cancel_btn_' + keyword_id).hide();
                                                    jQuery('.edit_keyword_' + keyword_id).show();
                                                    jQuery('.comman_loading_image').hide();
                                                    generate_pdf_again('<?php //echo $lastUniqueId; ?>');

                                                });
                                            });
                                            jQuery('.correct_save_button').click(function () {

                                                var correct_id = jQuery(this).data('atr');
                                                var correct_text = jQuery('.cor_input_' + correct_id).val();
                                                if (correct_text == '') {
                                                    alert('Please enter value Correct text cant save blank value');
                                                    return false;
                                                }
                                                jQuery('.comman_loading_image').show();
                                                jQuery.post(
                                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                        {
                                                            action: 'updateCorrect',
                                                            correctId: correct_id,
                                                            correctText: correct_text
                                                        }, function (response) {

                                                    jQuery('.cor_text_' + correct_id).show();
                                                    jQuery('.cor_input_' + correct_id).hide();
                                                    jQuery('.cor_text_' + correct_id).text(correct_text);
                                                    jQuery('#correct_save_button_' + correct_id).hide();
                                                    jQuery('#correct_cancel_button_' + correct_id).hide();
                                                    jQuery('.edit_correct_' + correct_id).show();
                                                    jQuery('.comman_loading_image').hide();

                                                    generate_pdf_again('<?php //echo $lastUniqueId; ?>');

                                                });
                                            });
                                            jQuery('.incorrect_save_button').click(function () {

                                                var incorrect_id = jQuery(this).data('atr');
                                                var incorrect_text = jQuery('.incor_input_' + incorrect_id).val();
                                                if (incorrect_text == '') {
                                                    alert('Please enter value Incorrect text cant save blank value');
                                                    return false;
                                                }

                                                jQuery('.comman_loading_image').show();
                                                jQuery.post(
                                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                        {
                                                            action: 'updateInCorrect',
                                                            incorrectId: incorrect_id,
                                                            incorrectText: incorrect_text
                                                        }, function (response) {


                                                    jQuery('.incor_text_' + incorrect_id).show();
                                                    jQuery('.incor_input_' + incorrect_id).hide();
                                                    jQuery('.incor_text_' + incorrect_id).text(incorrect_text);
                                                    jQuery('#incorrect_save_button_' + incorrect_id).hide();
                                                    jQuery('#incorrect_cancel_button_' + incorrect_id).hide();
                                                    jQuery('.edit_incorrect_' + incorrect_id).show();
                                                    jQuery('.comman_loading_image').hide();
                                                    generate_pdf_again('<?php //echo $lastUniqueId; ?>');

                                                });
                                            });

                                            jQuery('.topic_save_button').click(function () {

                                                var prev_topic_id = jQuery(this).data('atr');
                                                var prev_topic_text = jQuery('.prev_topic_input_' + prev_topic_id).val();

                                                if (prev_topic_text == '') {
                                                    alert('Please enter value Topic text cant save blank value');
                                                    return false;
                                                }
                                                jQuery('.comman_loading_image').show();
                                                jQuery.post(
                                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                        {
                                                            action: 'updatePrevTopic',
                                                            prevTopicId: prev_topic_id,
                                                            prevTopicText: prev_topic_text
                                                        }, function (response) {


                                                    jQuery('.prev_topic_text_' + prev_topic_id).show();
                                                    jQuery('.prev_topic_input_' + prev_topic_id).hide();
                                                    jQuery('.prev_topic_text_' + prev_topic_id).text(prev_topic_text);
                                                    jQuery('.prev_topic_input_' + prev_topic_id).val(prev_topic_text);
                                                    jQuery('#topic_save_button_' + prev_topic_id).hide();
                                                    jQuery('#topic_cancel_button_' + prev_topic_id).hide();
                                                    jQuery('.edit_prev_topic_' + prev_topic_id).show();
                                                    jQuery('.comman_loading_image').hide();
                                                    generate_pdf_again('<?php //echo $lastUniqueId; ?>');

                                                });
                                            });

                                            function generate_pdf_again(unique_key) {

                                                if (unique_key) {

                                                    jQuery.post('<?php //echo site_url(); ?>/TCPDF-master/examples/generate_pdf.php',
                                                            {
                                                                unique_key: unique_key
                                                            }, function (res) {
                                                        jQuery('.comman_loading_image').hide();
                                                    }
                                                    );
                                                }
                                            }

                                            jQuery(document).on('keyup', '#editor_textarea', function () {
                                                jQuery('#editor_text_with_brases').html(jQuery('#editor_textarea').html());
                                            });
                                            var student_level = '<?php //echo $stu_level; ?>';
                                            if (student_level == '') {

                                                alert('Hold your horses! Before you are able to wrap, in the Profile section, please select the student\'s proficiency level.');
                                            }
                                            setInterval(autoSaveData, 20000);
                                            jQuery('.strong_points_prev_lesson').hide();
                                            jQuery('.points_to_improve_prev_lesson').hide();
                                            if (jQuery('#student_level').val() != '') {

                                                jQuery('.<?php //echo $clicked_item; ?>_' + jQuery('#student_level').val() + '_container').show();
                                                jQuery('.<?php //echo $clicked_item; ?>_' + (parseInt(jQuery('#student_level').val()) + 1) + '_container').show();
                                                jQuery('.<?php //echo $clicked_item; ?>_' + (parseInt(jQuery('#student_level').val()) - 1) + '_container').show();
                                            }
                                            jQuery(document).on('click', '.loadlevelanchor', function () {

                                                val = jQuery(this).data('atr');
                                                jQuery('#dropdown-toggle-1').toggle();
                                                jQuery('.points_to_improve_prev_lesson').hide();
                                                jQuery('.strong_points_prev_lesson').hide();
                                                jQuery('.comman_loading_image').show();
                                                jQuery('#last_clicked_item').val(val);
                                                var stu_cnt = jQuery('#student_level').val();
                                                if (stu_cnt) {

                                                    if (jQuery('#response_div_points_to_improve').find('.' + val + '_' + '<?php //echo $stu_level; ?>' + '_container').length > 0 || jQuery('#response_div_strong_points').find('.' + val + '_' + '<?php //echo $stu_level; ?>' + '_container').length > 0) {
                                                        jQuery('.' + val + '_' + '<?php //echo $stu_level; ?>' + '_container').show();
                                                        jQuery('.' + val + '_' + '<?php //echo $stu_level; ?>' + '_container').show();
                                                        jQuery('.comman_loading_image').hide();
                                                    } else {
                                                        jQuery.post(
                                                                '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                                {
                                                                    action: 'getNextLevelsAndPoints',
                                                                    level_type: val,
                                                                    student_level: '<?php echo $stu_level; ?>',
                                                                    student_id: <?php //cho $select_date_for_title_result->student_id; ?>,
                                                                    point_type: 'strong_points'
                                                                }, function (response) {

                                                            jQuery('.comman_loading_image').hide();
                                                            jQuery('#response_div_points_to_improve').prepend(response);
    <?php if ($stu_level != '') { ?>
                                                                jQuery('.' + val + '_' +<?php //echo $stu_level; ?> + '_container').show();
    <?php } ?>
                                                            jQuery('.editable-dropdown .' + val).attr('onclick', 'showhiddenlevels("' + val + '")');
                                                        }
                                                        );
                                                    }
                                                    if (jQuery('#response_div_points_to_improve').find('.' + val + '_' + '<?php //echo $stu_level + 1; ?>' + '_container').length > 0 || jQuery('#response_div_strong_points').find('.' + val + '_' + '<?php //echo $stu_level + 1; ?>' + '_container').length > 0) {
                                                        jQuery('.' + val + '_' + '<?php //echo $stu_level + 1; ?>' + '_container').show();
                                                        jQuery('.' + val + '_' + '<?php //echo $stu_level + 1; ?>' + '_container').show();
                                                        jQuery('.comman_loading_image').hide();
                                                    } else {
                                                        jQuery('.comman_loading_image').show();
                                                        jQuery.post(
                                                                '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                                {
                                                                    action: 'getNextLevelsAndPoints',
                                                                    level_type: val,
                                                                    student_level: '<?php echo $stu_level + 1; ?>',
                                                                    student_id: <?php //echo $select_date_for_title_result->student_id; ?>,
                                                                    point_type: 'strong_points'
                                                                }, function (response) {

                                                            jQuery('.comman_loading_image').hide();
                                                            jQuery('#response_div_strong_points').append(response);
    <?php if ($stu_level != '') { ?>
                                                                jQuery('.' + val + '_' +<?php //echo $stu_level + 1; ?> + '_container').show();
    <?php } ?>
                                                            jQuery('.editable-dropdown .' + val).attr('onclick', 'showhiddenlevels("' + val + '")');
                                                        }
                                                        );
                                                    }
                                                    if (jQuery('#response_div_points_to_improve').find('.' + val + '_' + '<?php //echo $stu_level - 1; ?>' + '_container').length > 0 || jQuery('#response_div_strong_points').find('.' + val + '_' + '<?php //echo $stu_level - 1; ?>' + '_container').length > 0) {

                                                        jQuery('.' + val + '_' + '<?php //echo $stu_level - 1; ?>' + '_container').show();
                                                        jQuery('.' + val + '_' + '<?php //echo $stu_level - 1; ?>' + '_container').show();
                                                        jQuery('.comman_loading_image').hide();
                                                    } else {
                                                        jQuery('.comman_loading_image').show();
                                                        jQuery.post(
                                                                '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                                                {
                                                                    action: 'getNextLevelsAndPoints',
                                                                    level_type: val,
                                                                    student_level: '<?php echo $stu_level - 1; ?>',
                                                                    student_id: <?php //echo $select_date_for_title_result->student_id; ?>,
                                                                    point_type: 'strong_points'
                                                                }, function (response) {

                                                            jQuery('.comman_loading_image').hide();
                                                            jQuery('#response_div_points_to_improve').append(response);
    <?php if ($stu_level != '') { ?>
                                                                jQuery('.' + val + '_' +<?php //echo $stu_level - 1; ?> + '_container').show();
    <?php } ?>
                                                            jQuery('.editable-dropdown .' + val).attr('onclick', 'showhiddenlevels("' + val + '")');
                                                        }
                                                        );
                                                    }
                                                }
                                            });


                                            var mul_by = 100;
                                            jQuery(document).on('click', '.points_to_improve_arrow', function (e) {

                                                var stu_cnt = jQuery('#student_level').val();
                                                if (jQuery('#response_div_points_to_improve div :checked').length == 0) {
                                                    alert('Please select at least one chekbox to move right');
                                                    return false;
                                                }
                                                jQuery('#response_div_points_to_improve div :checked').removeClass('points_to_improve');
                                                jQuery('#response_div_points_to_improve div :checked').addClass('strong_points');
                                                jQuery('#response_div_points_to_improve div :checked').removeAttr('name');
                                                jQuery('#response_div_points_to_improve div :checked').attr('name', 'strong_points[]');
                                                jQuery('#response_div_points_to_improve div :checked').closest('div').appendTo('#response_div_strong_points');
                                                jQuery('#response_div_strong_points div :checked').prop('checked', false);


                                                if (jQuery('#last_clicked_item').val() == 'CA') {

                                                    var ca_cnt = jQuery('#ca_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.CA_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(ca_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_1').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_1').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'FP') {

                                                    var fp_cnt = jQuery('#fp_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.FP_' + stu_cnt + '_container').length;

                                                    var p_to_i_count = parseInt(get_count) / parseInt(fp_cnt) * parseInt(mul_by);
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_2').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_2').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'LC') {

                                                    var lc_cnt = jQuery('#lc_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.LC_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(lc_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_3').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_3').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'GA') {

                                                    var ga_cnt = jQuery('#ga_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.GA_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(ga_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_5').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_5').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'V') {

                                                    var v_cnt = jQuery('#v_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.V_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(v_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_4').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_4').html(new_rating);
                                                }
                                                var val1 = jQuery.trim(jQuery('#rating_point_1').text());
                                                var val2 = jQuery.trim(jQuery('#rating_point_2').text());
                                                var val3 = jQuery.trim(jQuery('#rating_point_3').text());
                                                var val4 = jQuery.trim(jQuery('#rating_point_4').text());
                                                var val5 = jQuery.trim(jQuery('#rating_point_5').text());
                                                var result = get_avearge(val1, val2, val3, val4, val5);
                                                jQuery('#rating_point_result').html(result);

                                            });
                                            function get_avearge(val1, val2, val3, val4, val5) {

                                                if (isNaN(val1) || val1 == '') {
                                                    val1 = 0;
                                                }
                                                if (isNaN(val2) || val2 == '') {

                                                    val2 = 0;
                                                }
                                                if (isNaN(val3) || val3 == '') {

                                                    val3 = 0;
                                                }
                                                if (isNaN(val4) || val4 == '') {

                                                    val4 = 0;
                                                }
                                                if (isNaN(val5) || val5 == '') {

                                                    val5 = 0;
                                                }
                                                var addition = parseInt(val1) + parseInt(val2) + parseInt(val3) + parseInt(val4) + parseInt(val5);
                                                new_value = addition / 5;
                                                return new_value;
                                            }
                                            jQuery(document).on('click', '.strong_points_arrow', function (e) {

                                                var stu_cnt = jQuery('#student_level').val();
                                                if (jQuery('#response_div_strong_points div :checked').length == 0) {
                                                    alert('Please select at least one chekbox to move left');
                                                    return false;
                                                }
                                                jQuery('#response_div_strong_points div :checked').removeClass('points_to_improve');
                                                jQuery('#response_div_strong_points div :checked').addClass('strong_points');
                                                jQuery('#response_div_strong_points div :checked').removeAttr('name');
                                                jQuery('#response_div_strong_points div :checked').attr('name', 'strong_points[]');
                                                jQuery('#response_div_strong_points div :checked').closest('div').appendTo('#response_div_points_to_improve');
                                                jQuery('#response_div_points_to_improve div :checked').prop('checked', false);
                                                if (jQuery('#last_clicked_item').val() == 'CA') {

                                                    var ca_cnt = jQuery('#ca_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.CA_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(ca_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_1').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_1').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'FP') {

                                                    var fp_cnt = jQuery('#fp_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.FP_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(fp_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_2').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_2').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'LC') {

                                                    var lc_cnt = jQuery('#lc_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.LC_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(lc_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_3').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_3').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'GA') {

                                                    var ga_cnt = jQuery('#ga_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.GA_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(ga_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_5').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_5').html(new_rating);
                                                }
                                                if (jQuery('#last_clicked_item').val() == 'V') {

                                                    var v_cnt = jQuery('#v_count').val();
                                                    var get_count = jQuery('#response_div_points_to_improve').find('.V_' + stu_cnt + '_container').length;
                                                    var p_to_i_count = parseInt(get_count) / parseInt(v_cnt) * mul_by;
                                                    var point_rating = check_rating_lie_between(p_to_i_count);
                                                    var existing_rating = jQuery('#rating_point_4').text();
                                                    var new_rating = '';
                                                    if (isNaN(existing_rating) && existing_rating != '') {

                                                        new_rating = parseInt(point_rating) + parseInt(existing_rating);
                                                    } else {

                                                        new_rating = point_rating;
                                                    }
                                                    if (new_rating > 5) {

                                                        new_rating = 5;
                                                    }
                                                    jQuery('#rating_point_4').html(new_rating);
                                                }
                                                var val1 = jQuery.trim(jQuery('#rating_point_1').html());
                                                var val2 = jQuery.trim(jQuery('#rating_point_2').html());
                                                var val3 = jQuery.trim(jQuery('#rating_point_3').html());
                                                var val4 = jQuery.trim(jQuery('#rating_point_4').html());
                                                var val5 = jQuery.trim(jQuery('#rating_point_5').html());
                                                var result = get_avearge(val1, val2, val3, val4, val5);
                                                jQuery('#rating_point_result').html(result);
                                            });
                                            jQuery(".status-link").click(function () {

                                                jQuery('#' + this.id).siblings('span:first').slideToggle();
                                            });
                                        });
                                    </script>
                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Lesson Materials and Tasks ・教材</a></span>
                                    <div class="acc-container homwork_popup_parent" style="display: block !important">
                                    	<div class="homwork_popup">

                                            <div class="pop-up-holder">
                                            	<a href="javascript:void(0);" class="close-popup">X</a>
                                                <div class="clearfix bdr-center flex-view pb-10">
                                                <div class="comment-pt bg-grey ">
                                                    <h2 class="bg-light-blue">Lesson Materials and Tasks ・教材</h2>
                                                    <div class="editable_checkbox teacher-onepage" id="lesson_material_textarea">
                                                        <!--div class="editable_div" id="lesson_material_textarea" contentEditable="true"></div-->
                                                        <?php
              //                                           $task1 = '';
              //                                           $task2 = '';
              //                                           $task3 = '';
              //                                           if ($lastUniqueId != '') {
    
              //                                               $previous_lesson_task = 'select * from ' . $wpdb->prefix . 'onepage_homework where unique_key = "' . $lastUniqueId . '"';
              //                                               $prev_lesson_results = $wpdb->get_results($previous_lesson_task, ARRAY_A);
              //                                               //$task1 = $prev_lesson_results[0]['homework_task'];
              //                                               $task2 = $prev_lesson_results[1]['homework_task'];
              //                                               $task3 = $prev_lesson_results[2]['homework_task'];
              //                                           }
														
														// if ($lesson_material_task_temp[1]) {
														// 	$lmt2 =  $lesson_material_task_temp[1];
														// } else {
														// 	$lmt2 = $task2;
														// }
															
														// if ($lesson_material_task_temp[2]) {
              //                                               $lmt3 = $lesson_material_task_temp[2];
														// } else {
														// 	$lmt3 = $task3;
														// }	
                                                        ?>
                                                        <textarea class="lesson_material_task" name="lesson_material_task[]" id="abc1">① Use what we have learnt frequently to remember easily through habit.  
                ② Avoid translating from English to Japanese. Practice English input and English output. 
                ③ Without reading, practice saying and acting out your sentences aloud several times for fluency.  
                The basic principle for any learning is to create a good habit.
                [Please do not delete. Default.] </textarea> 
                											<div class="lmdiv" data-attr="1"><i class="fa fa-arrow-circle-down"></i></div>
                                                        <textarea class="lesson_material_task" name="lesson_material_task[]" id="abc2"><?php //echo $lmt2; ?></textarea>
                                                        	<?php 
                                                            // if(trim($lmt2) != '' && trim($homework_lesson_material_task_temp[1]) == '' && (trim($lmt2) !=  trim($homework_lesson_material_task_temp[1]))){
                                                             ?>
																	<div class="lmdiv" data-attr="2"><i class="fa fa-arrow-circle-down"></i></div>	
															<?php //}	?>
                                                        <textarea class="lesson_material_task" name="lesson_material_task[]" id="abc3"><?php //echo $lmt3; ?></textarea>
                                                        	<?php 
                                                            // if(trim($lmt3) != '' && trim($homework_lesson_material_task_temp[2]) == '' && (trim($lmt3) !=  trim($homework_lesson_material_task_temp[2]))){ 
                                                                ?>
																	<div class="lmdiv" data-attr="3"><i class="fa fa-arrow-circle-down"></i></div>
															<?php //}	?>
	                                                        
                                                    </div>
                                                </div>
                                                <div class="comment-pt bg-grey right">
                                                    <h2 class="bg-light-blue">
                                                        Lesson Tasks ・ 課題
                                                    </h2>
                                                    <div class="editable_checkbox teacher-onepage" id="lesson_tasks_textarea">
                                                        <!--div class="editable_div" id="lesson_tasks_textarea" contentEditable="true"></div-->
                                                        <?php
              //                                           $task1 = '';
              //                                           $task2 = '';
              //                                           $task3 = '';
              //                                           if ($lastUniqueId != '') {
    
              //                                               $next_lesson_task = 'select next_lesson_data from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $lastUniqueId . '"';
              //                                               $next_lesson_results = $wpdb->get_row($next_lesson_task, ARRAY_A);
              //                                               $next_lesson_task_data = explode('~~!', $next_lesson_results['next_lesson_data']);
              //                                               $nxt_task2 = $next_lesson_task_data[1];
              //                                               $nxt_task3 = $next_lesson_task_data[2];
              //                                           }
														// if ($lesson_task_temp[1]) {
														// 	$lt2 = $lesson_task_temp[1];
														// } else {
														// 	$lt2 = $nxt_task2;
														// }
														
														// if ($lesson_task_temp[2]) {
														// 	$lt3 = $lesson_task_temp[2];
														// } else {
														// 	$lt3 = $nxt_task3;
														// }
                                                        ?>
                                                        <textarea class="lesson_task" name="lesson_task[]" id="lt1">① 英語は、何度も使うことで身についていきます。今回学んだ内容を積極的に使うよう意識してみてください。
                ② 英語から日本語に翻訳するのではなく、英語のままインプットし、英語でアウトプットする練習をしましょう。
                ③ テキストを見ずに、センテンスを声に出して言ってみましょう。すらすら言えるようになるまで繰り返し練習してください。  
                何かを習得する最大のコツは、良い習慣を身につけることです。
                [Please do not delete. Default.] </textarea>
                											<div class="ltdiv" data-attr="1"><i class="fa fa-arrow-circle-down"></i></div>
                                                        <textarea class="lesson_task" name="lesson_task[]" id="lt2"><?php //echo $lt2; ?></textarea>
                                                        	<?php 
                                                            // if(trim($lt2) != '' && trim($next_lesson_task_temp[1]) == ''){ 
                                                                ?>
																	<div class="ltdiv" data-attr="2"><i class="fa fa-arrow-circle-down"></i></div>
															<?php //}	?>                                                            
                                                        <textarea class="lesson_task" name="lesson_task[]" id="lt3"><?php echo $lt3; ?></textarea>
                                                        	<?php
                                                             // if(trim($lt3) != '' && trim($next_lesson_task_temp[2]) == ''){ 
                                                                ?>
																	<div class="ltdiv" data-attr="3"><i class="fa fa-arrow-circle-down"></i></div>
															<?php //}	?>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="clearfix bdr-center flex-view">
                                                    <div class="comment-pt bg-grey">
                                                        <h2 class="bg-pink">
                                                            Homework Lesson Materials and Tasks ・ 自習課題
                                                        </h2>
                                                        <div class="editable_checkbox" id="homework_lesson_material_textarea">
                                                            <textarea class="homeWork_task" id="hlm1" name="homeWork_task[]" id="abc11">① Use what we have learnt frequently to remember easily through habit.  
                    ② Avoid translating from English to Japanese. Practice English input and English output. 
                    ③ Without reading, practice saying and acting out your sentences aloud several times for fluency.  
                    The basic principle for any learning is to create a good habit.
                    [Please do not delete. Default.]
                                                               </textarea>
                                                            <textarea class="homeWork_task" id="hlm2" name="homeWork_task[]" id="abc22"><?php
															// if ($homework_lesson_material_task_temp[1]) {
															// 	echo $homework_lesson_material_task_temp[1];
															// 	}
																?></textarea>
                                                            <textarea class="homeWork_task" id="hlm3" name="homeWork_task[]" id="abc33"><?php
                                                                // if ($homework_lesson_material_task_temp[2]) {
                                                                //     echo $homework_lesson_material_task_temp[2];
                                                                // }
                                                                ?></textarea>
                                                        </div>
                                                    </div>
        
                                                    <div class="comment-pt bg-grey mar-xs-0 right">
                                                        <h2 class="bg-pink">
                                                            Next Lesson Tasks ・ 次回のレッスン課題
                                                        </h2>
                                                        <div class="editable_checkbox" id="next_lesson_task_textarea">
                                                            <!--div class="editable_div" id="next_lesson_task_textarea" contentEditable="true"></div-->
                                                            <textarea class="next_lesson_task" id="nlt1" name="next_lesson_task[]">① 英語は、何度も使うことで身についていきます。今回学んだ内容を積極的に使うよう意識してみてください。
                    ② 英語から日本語に翻訳するのではなく、英語のままインプットし、英語でアウトプットする練習をしましょう。
                    ③ テキストを見ずに、センテンスを声に出して言ってみましょう。すらすら言えるようになるまで繰り返し練習してください。  
                    何かを習得する最大のコツは、良い習慣を身につけることです。
                    [Please do not delete. Default.]
                                                                <?php //if($lesson_task_temp[0]) { echo $lesson_task_temp[0]; }  ?></textarea>
                                                            <textarea class="next_lesson_task" id="nlt2" name="next_lesson_task[]"><?php
															// if ($next_lesson_task_temp[1]) {
               //                                                      echo $next_lesson_task_temp[1];
               //                                                  }
                                                                ?></textarea>
                                                            <textarea class="next_lesson_task" id="nlt3" name="next_lesson_task[]"><?php
                                                                // if ($next_lesson_task_temp[2]) {
                                                                //     echo $next_lesson_task_temp[2];
                                                                // }
                                                                ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Points to Improve ・ のばせるポイント</a></span>
                                    <div class="acc-container" style="display: none;">
                                        <div>
                                            <?php
                                            // $stu_lev = '';
                                            // if ($stu_level) {

                                            //     $get_lev_query = "select * from " . $wpdb->prefix . "onepage_levels where id = " . $stu_level;
                                            //     $get_lev_result = $wpdb->get_row($get_lev_query, ARRAY_A);
                                                //echo 'Current Level :- '.$get_lev_result['name'];
                                                ?>
                                                <style>
                                                    .alert-close{display:none;}
                                                    .success::before{ display:none; }
                                                </style>
                                                <?php //if ($get_lev_result['name']) { ?>
                                                    <div class="success-alert">
                                                        <p class="success"><span><b>Student level :-</b></span><span><?php echo $get_lev_result['name']; ?></span></p>
                                                        <p class="success"><span><b>Level description :-</b></span><span><?php //echo $get_lev_result['description_en']; ?><br><?php //echo $get_lev_result['description_ja']; ?></span></p>
                                                    </div>
                                                    <?php
                                                //}
                                            //}
                                            ?>
                                        </div>
                                        <div>
                                            <div class="clearfix bdr-center flex-view">
                                                <div class="comment-pt bg-grey">
                                                    <h2 class="bg-mehron">
                                                        Points to Improve ・ のばせるポイント
                                                    </h2>
                                                    <div class="editable_checkbox" id="points_to_improve_textarea">
                                                        <ul class="editable-dropdown">
                                                            <li>
                                                                <a href="javascript:void(0);"  onclick="toggle_menu('dropdown-toggle-1');" class="dropdown-toggle"><i class="fa fa-lg fa-toggle-down"></i></a>
                                                                <ul class="dropdown-menu" id="dropdown-toggle-1">

                                                                    <?php
                                                                    // if ($stu_level) {
                                                                    //     $select = 'select student_id from ' . $wpdb->prefix . 'lesson_record where id = ' . $lessonRecordId;
                                                                    //     $lessons_record_data = $wpdb->get_row($select, ARRAY_A);

                                                                    //     $select2 = 'select * from ' . $wpdb->prefix . 'onepage_teacher_clicked_items where student_id = ' . $lessons_record_data['student_id'] . ' and student_level = ' . $stu_level . ' group by selected_item';
                                                                    //     $lessons_record_data2 = $wpdb->get_results($select2, ARRAY_A);

                                                                    //     $clicked_string = '';
                                                                    //     foreach ($lessons_record_data2 as $lessons_record2) {

                                                                    //         $clicked_string .= $lessons_record2['selected_item'] . ', ';
                                                                    //     }

                                                                    //     $rat_array = array('CA', 'FP', 'LC', 'V', 'GA');
                                                                    //     $fount_count = 0;
                                                                    //     foreach ($rat_array as $rat) {

                                                                    //         $search_found = arraySearch2($lessons_record_data2, 'selected_item', $rat);
                                                                    //         if ($search_found != 1) {
                                                                    //             $fount_count++;
                                                                    //             ?>
                                                                    //             <li><a class="loadlevelanchor <?php echo $rat; ?>" href="javascript:void(0)" data-atr="<?php //echo $rat; ?>">

                                                                    //                     <?php
                                                                    //                     if ($rat == 'FP') {

                                                                    //                         echo 'F&P';
                                                                    //                     } else if ($rat == 'GA') {

                                                                    //                         echo 'G&A';
                                                                    //                     } else {

                                                                    //                         echo $rat;
                                                                    //                     }
                                                                    //                     ?>

                                                                    //                 </a></li>
                                                                    //             <?php
                                                                    //         } else {
                                                                    //             ?>
                                                                    //             <li>
                                                                    //                 <a class="loadlevelanchor <?php //echo $rat; ?>" href="javascript:void(0)" data-atr="<?php //echo $rat; ?>" onclick="showhiddenlevels('<?php //echo $rat; ?>')">

                                                                    //                     <?php
                                                                    //                     if ($rat == 'FP') {

                                                                    //                         echo 'F&P';
                                                                    //                     } else if ($rat == 'GA') {

                                                                    //                         echo 'G&A';
                                                                    //                     } else {

                                                                    //                         echo $rat;
                                                                    //                     }
                                                                    //                     ?>

                                                                    //                 </a>
                                                                    //             </li>
                                                                    //             <?php
                                                                    //         }
                                                                    //     }
                                                                    // }
                                                                    // if ($fount_count == 0) {
                                                                    //     /* ?>
                                                                    //       <li style="width:100%"><a  href="javascript:void(0)">All points are selected already</a></li>
                                                                   <?php //*/
                                                                    // }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                        <?php //pr($lessons_record_data2); ?>
                                                        <input type="hidden" value="<?php //echo $clicked_string; ?>" id="rating_type_clicked">
                                                        <input type="hidden" value="<?php //echo $clicked_item; ?>" id="last_clicked_item">
                                                        <div id="response_div_points_to_improve" class="response_div_points_to_improve_class">
                                                            <?php
                                                            $points_to_improve_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type= "points_to_improve" and lesson_record_id = ' . $lessonRecordId . '';
                                                            $points_to_improve_result = $wpdb->get_row($points_to_improve_query, ARRAY_A);
                                                            //pr($points_to_improve_results);
                                                            // $i = 1;
                                                            // if (!empty($points_to_improve_result)) {

                                                            //     if (is_array($points_to_improve_result) && count($points_to_improve_result) > 0) {

                                                            //         $points_to_imps = explode('~~!', $points_to_improve_result['desc_text']);

                                                            //         foreach ($points_to_imps as $points_to_imp) {

                                                            //             if ($points_to_imp != '') {

                                                            //                 $points_to_imp = str_replace('?', '・', $points_to_imp);
                                                            //                 $exploded = explode(']', $points_to_imp);
                                                            //                 $lev_val = substr($exploded[0], -1);
                                                            //                 $new_exploded = explode('.', $exploded[1]);
                                                            //                 $select_rating_name_query = 'select rating_name, level_id, description_ja from ' . $wpdb->prefix . 'onepage_points where level_id = ' . $lev_val . ' and descrption  Like "%' . $new_exploded[0] . '%"';
                                                            //                 $select_rating_name_results = $wpdb->get_results($select_rating_name_query, ARRAY_A);
                                                            //                 $type_class = '';
                                                            //                 $level_id = '';
                                                            //                 $description_ja = '';
                                                            //                 foreach ($select_rating_name_results as $select_rating_name_result) {

                                                            //                     $description_ja = $select_rating_name_result['description_ja'];

                                                            //                     if ($select_rating_name_result['rating_name'] == 'GA') {

                                                            //                         $type_class = 'GA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'CA') {

                                                            //                         $type_class = 'CA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'FP') {

                                                            //                         $type_class = 'FP';
                                                            //                     } else {

                                                            //                         $type_class = $select_rating_name_result['rating_name'];
                                                            //                     }
                                                            //                     $level_id = $select_rating_name_result['level_id'];
                                                            //                 }
                                                            //                 if ($level_id == $stu_level) {
                                                            //                     $stu_lev = 1;
                                                            //                 } else {
                                                            //                     $stu_lev = 2;
                                                            //                 }
                                                            //                 echo '<div data-srt="' . $stu_lev . '"  class= "points_to_improve_class points_to_improve_prev_lesson ' . $type_class . '_' . $level_id . '_container" id="points_to_improve_prev_lesson_' . $i . '"><input type="checkbox" class="' . $type_class . ' points_to_improve points_to_improve_prev_lesson_' . $i . '" name="points_to_improve[]" value="' . $points_to_imp . '"><label>' . $points_to_imp . ' <span id="p_to_i_' . $i . '" style="display:none">' . $description_ja . '</span><a href="javascript:void(0);" class="read-more-btn txt-green p_to_i_' . $i . '" onclick="show_japanes_text(\'p_to_i_' . $i . '\')">Read More</a></label></div>';
                                                            //             }
                                                            //             $i++;
                                                            //         }
                                                            //     }
                                                            // } else {

                                                            //     $points_to_improve_query = 'select points_to_improve from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $lastUniqueId . '"';
                                                            //     $points_to_improve_results = $wpdb->get_results($points_to_improve_query, ARRAY_A);
                                                            //     //pr($points_to_improve_results);
                                                            //     $i = 1;
                                                            //     foreach ($points_to_improve_results as $points_to_improve_result) {

                                                            //         $points_to_imps = explode('<br>', $points_to_improve_result['points_to_improve']);

                                                            //         foreach ($points_to_imps as $points_to_imp) {

                                                            //             if ($points_to_imp != '') {

                                                            //                 $points_to_imp = str_replace('?', '・', $points_to_imp);
                                                            //                 $exploded = explode(']', $points_to_imp);
                                                            //                 $lev_val = substr($exploded[0], -1);
                                                            //                 $new_exploded = explode('.', $exploded[1]);
                                                            //                 $select_rating_name_query = 'select rating_name, level_id, description_ja from ' . $wpdb->prefix . 'onepage_points where level_id = ' . $lev_val . ' and descrption  Like "%' . $new_exploded[0] . '%"';
                                                            //                 $select_rating_name_results = $wpdb->get_results($select_rating_name_query, ARRAY_A);
                                                            //                 $type_class = '';
                                                            //                 $level_id = '';
                                                            //                 $description_ja = '';
                                                            //                 foreach ($select_rating_name_results as $select_rating_name_result) {

                                                            //                     $description_ja = $select_rating_name_result['description_ja'];

                                                            //                     if ($select_rating_name_result['rating_name'] == 'GA') {

                                                            //                         $type_class = 'GA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'CA') {

                                                            //                         $type_class = 'CA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'FP') {

                                                            //                         $type_class = 'FP';
                                                            //                     } else {

                                                            //                         $type_class = $select_rating_name_result['rating_name'];
                                                            //                     }
                                                            //                     $level_id = $select_rating_name_result['level_id'];
                                                            //                 }
                                                            //                 if ($level_id == $stu_level) {
                                                            //                     $stu_lev = 1;
                                                            //                 } else {
                                                            //                     $stu_lev = 2;
                                                            //                 }
                                                            //                 echo '<div data-srt="' . $stu_lev . '"  class= "points_to_improve_class points_to_improve_prev_lesson ' . $type_class . '_' . $level_id . '_container" id="points_to_improve_prev_lesson_' . $i . '"><input type="checkbox" class="' . $type_class . ' points_to_improve points_to_improve_prev_lesson_' . $i . '" name="points_to_improve[]" value="' . $points_to_imp . '"><label>' . $points_to_imp . ' <span id="p_to_i_' . $i . '" style="display:none">' . $description_ja . '</span><a href="javascript:void(0);" class="read-more-btn txt-green p_to_i_' . $i . '" onclick="show_japanes_text(\'p_to_i_' . $i . '\')">Read More</a></label></div>';
                                                            //             }
                                                            //             $i++;
                                                            //         }
                                                            //     }
                                                            // }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="arrows-left-right">
                                                    <div class="arrows-control desktop">
                                                        <a href="javascript:void(0);" class="points_to_improve_arrow"><i class="fa fa-angle-double-right"></i></a>
                                                        <a href="javascript:void(0);" class="strong_points_arrow"><i class="fa fa-angle-double-left"></i></a>
                                                    </div>
                                                    <div class="arrows-control mobile" style="display:none">
                                                        <a href="javascript:void(0);" class="points_to_improve points_to_improve_arrow"><i class="fa fa-angle-double-down"></i></a>
                                                        <a href="javascript:void(0);" class="strong_points_arrow"><i class="fa fa-angle-double-up"></i></a>
                                                    </div>
                                                </div>
                                                <div class="comment-pt bg-grey">
                                                    <h2 class="bg-green">
                                                        Strong Points ・ 良いポイント
                                                    </h2>
                                                    <div class="editable_checkbox" id="strong_points_textarea">
                                                        <div id="response_div_strong_points" class="response_div_strong_points_class">
                                                            <?php
                                                            // $strong_points_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="strong_points" and lesson_record_id = ' . $lessonRecordId . '';
                                                            // $stront_points_result = $wpdb->get_row($strong_points_query, ARRAY_A);
                                                            // $i = 1;

                                                            // if (!empty($stront_points_result)) {

                                                            //     $strong_points = explode('~~!', $stront_points_result['desc_text']);
                                                            //     if (is_array($strong_points) && count($strong_points) > 0) {

                                                            //         foreach ($strong_points as $strong_point) {

                                                            //             if ($strong_point != '') {

                                                            //                 $strong_point = str_replace('?', '・', $strong_point);
                                                            //                 $exploded = explode(']', $strong_point);
                                                            //                 $lev_val = substr($exploded[0], -1);
                                                            //                 $new_exploded = explode('.', $exploded[1]);
                                                            //                 $select_rating_name_query = 'select rating_name, level_id, description_ja from ' . $wpdb->prefix . 'onepage_points where level_id = ' . $lev_val . ' and descrption Like "%' . $new_exploded[0] . '%"';
                                                            //                 $select_rating_name_results = $wpdb->get_results($select_rating_name_query, ARRAY_A);
                                                            //                 $type_class = '';
                                                            //                 $level_id = '';
                                                            //                 $description_ja = '';
                                                            //                 foreach ($select_rating_name_results as $select_rating_name_result) {

                                                            //                     $description_ja = $select_rating_name_result['description_ja'];
                                                            //                     if ($select_rating_name_result['rating_name'] == 'GA') {

                                                            //                         $type_class = 'GA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'CA') {

                                                            //                         $type_class = 'CA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'FP') {

                                                            //                         $type_class = 'FP';
                                                            //                     } else {
                                                            //                         $type_class = $select_rating_name_result['rating_name'];
                                                            //                     }
                                                            //                     $level_id = $select_rating_name_result['level_id'];
                                                            //                 }
                                                            //                 if ($level_id == $stu_level) {
                                                            //                     $stu_lev = 1;
                                                            //                 } else {
                                                            //                     $stu_lev = 2;
                                                            //                 }
                                                            //                 echo '<div class= "strong_points_class strong_points_prev_lesson ' . $type_class . '_' . $level_id . '_container" id="strong_points_prev_lesson_' . $i . '" data-srt="' . $stu_lev . '" ><input type="checkbox" class="' . $type_class . ' strong_points points_to_improve_prev_lesson_' . $i . '" name="strong_points[]" value="' . $strong_point . '"><label>' . $strong_point . ' <span id="str_points_' . $i . '" style="display:none">' . $description_ja . '</span><a href="javascript:void(0);" class="read-more-btn txt-green str_points_' . $i . '" onclick="show_japanes_text(\'str_points_' . $i . '\')">Read More</a></label></div>';
                                                            //             }
                                                            //             $i++;
                                                            //         }
                                                            //     }
                                                            // } else {

                                                            //     $strong_points_query = 'select strong_points from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $lastUniqueId . '"';
                                                            //     $strong_points_results = $wpdb->get_results($strong_points_query, ARRAY_A);
                                                            //     $i = 1;

                                                            //     foreach ($strong_points_results as $stront_points_result) {

                                                            //         $strong_points = explode('~~!', $stront_points_result['strong_points']);

                                                            //         foreach ($strong_points as $strong_point) {

                                                            //             if ($strong_point != '') {

                                                            //                 $strong_point = str_replace('?', '・', $strong_point);
                                                            //                 $exploded = explode(']', $strong_point);
                                                            //                 $lev_val = substr($exploded[0], -1);
                                                            //                 $new_exploded = explode('.', $exploded[1]);
                                                            //                 $select_rating_name_query = 'select rating_name, level_id, description_ja from ' . $wpdb->prefix . 'onepage_points where level_id = ' . $lev_val . ' and descrption Like "%' . $new_exploded[0] . '%"';
                                                            //                 $select_rating_name_results = $wpdb->get_results($select_rating_name_query, ARRAY_A);
                                                            //                 $type_class = '';
                                                            //                 $level_id = '';
                                                            //                 $description_ja = '';
                                                            //                 foreach ($select_rating_name_results as $select_rating_name_result) {

                                                            //                     $description_ja = $select_rating_name_result['description_ja'];
                                                            //                     if ($select_rating_name_result['rating_name'] == 'GA') {

                                                            //                         $type_class = 'GA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'CA') {

                                                            //                         $type_class = 'CA';
                                                            //                     } else if ($select_rating_name_result['rating_name'] == 'FP') {

                                                            //                         $type_class = 'FP';
                                                            //                     } else {
                                                            //                         $type_class = $select_rating_name_result['rating_name'];
                                                            //                     }
                                                            //                     $level_id = $select_rating_name_result['level_id'];
                                                            //                 }
                                                            //                 if ($level_id == $stu_level) {
                                                            //                     $stu_lev = 1;
                                                            //                 } else {
                                                            //                     $stu_lev = 2;
                                                            //                 }
                                                            //                 echo '<div class= "strong_points_class strong_points_prev_lesson ' . $type_class . '_' . $level_id . '_container" id="strong_points_prev_lesson_' . $i . '" data-srt="' . $stu_lev . '" ><input type="checkbox" class="' . $type_class . ' strong_points points_to_improve_prev_lesson_' . $i . '" name="strong_points[]" value="' . $strong_point . '"><label>' . $strong_point . ' <span id="str_points_' . $i . '" style="display:none">' . $description_ja . '</span><a href="javascript:void(0);" class="read-more-btn txt-green str_points_' . $i . '" onclick="show_japanes_text(\'str_points_' . $i . '\')">Read More</a></label></div>';
                                                            //             }
                                                            //             $i++;
                                                            //         }
                                                            //     }
                                                            // }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Rating Boxes-->
                                            <div class="rating_boxes_div">
                                                <div class="rating-points-wrapper clearfix">
                                                    <?php
                                                    // if ($stu_level) {

                                                    //     $overall_rating = '';
                                                    //     $ca_rat = '';
                                                    //     $fp_rat = '';
                                                    //     $lc_rat = '';
                                                    //     $v_rat = '';
                                                    //     $ga_rat = '';
                                                    //     $get_ca_query = 'select ca, fp, lc, v, ga, overall_rating from ' . $wpdb->prefix . 'onepage_rating where unique_key = "' . $lastUniqueId . '" and student_level_id = ' . $stu_level . '';
                                                    //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        // if (empty($get_ca_result)) {

                                                        //     $get_ca_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="overall_rating" and lesson_record_id = ' . $lessonRecordId . '';
                                                        //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        //     $overall_rating = $get_ca_result['desc_text'];

                                                        //     $get_ca_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="ca_rating" and lesson_record_id = ' . $lessonRecordId . '';
                                                        //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        //     $ca_rat = $get_ca_result['desc_text'];

                                                        //     $get_ca_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="fp_rating" and lesson_record_id = ' . $lessonRecordId . '';
                                                        //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        //     $fp_rat = $get_ca_result['desc_text'];

                                                        //     $get_ca_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="lc_rating" and lesson_record_id = ' . $lessonRecordId . '';
                                                        //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        //     $lc_rat = $get_ca_result['desc_text'];

                                                        //     $get_ca_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="v_rating" and lesson_record_id = ' . $lessonRecordId . '';
                                                        //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        //     $v_rat = $get_ca_result['desc_text'];

                                                        //     $get_ca_query = 'select desc_text from ' . $wpdb->prefix . 'onepage_temp_data where type="ga_rating" and lesson_record_id = ' . $lessonRecordId . '';
                                                        //     $get_ca_result = $wpdb->get_row($get_ca_query, ARRAY_A);
                                                        //     $ga_rat = $get_ca_result['desc_text'];
                                                        // }
                                                        ?>
                                                        <div class="rating-points">
                                                            <span class="rating-title">Average</span>
                                                            <span class="points" id="rating_point_result"><?php
                                                                //echo ($get_ca_result['ca']+$get_ca_result['fp']+$get_ca_result['lc']+$get_ca_result['v']+$get_ca_result['ga'])/5;
                                                                // if ($get_ca_result['overall_rating']) {
                                                                //     echo $get_ca_result['overall_rating'];
                                                                // } else if ($overall_rating) {
                                                                //     echo $overall_rating;
                                                                // } else {
                                                                //     echo '5';
                                                                // }
                                                                ?></span>
                                                        </div>
                                                        <div class="rating-points">
                                                            <span class="rating-title">CA </span>
                                                            <span class="points" id="rating_point_1"><?php
                                                                // if ($get_ca_result['ca']) {
                                                                //     echo $get_ca_result['ca'];
                                                                // } else if ($ca_rat) {
                                                                //     echo $ca_rat;
                                                                // } else {
                                                                //     echo '5';
                                                                // }
                                                                ?></span>
                                                        </div>
                                                        <div class="rating-points">
                                                            <span class="rating-title">F&P </span>
                                                            <span class="points" id="rating_point_2"><?php
                                                                // if ($get_ca_result['fp']) {
                                                                //     echo $get_ca_result['fp'];
                                                                // } else if ($fp_rat) {
                                                                //     echo $fp_rat;
                                                                // } else {
                                                                //     echo '5';
                                                                // }
                                                                ?></span>
                                                        </div>
                                                        <div class="rating-points">
                                                            <span class="rating-title">LC</span>
                                                            <span class="points" id="rating_point_3"><?php
                                                                // if ($get_ca_result['lc']) {
                                                                //     echo $get_ca_result['lc'];
                                                                // } else if ($lc_rat) {
                                                                //     echo $lc_rat;
                                                                // } else {
                                                                //     echo '5';
                                                                // }
                                                                ?></span>
                                                        </div>
                                                        <div class="rating-points">
                                                            <span class="rating-title">V</span>
                                                            <span class="points" id="rating_point_4"><?php
                                                                // if ($get_ca_result['v']) {
                                                                //     echo $get_ca_result['v'];
                                                                // } else if ($v_rat) {
                                                                //     echo $v_rat;
                                                                // } else {
                                                                //     echo '5';
                                                                // }
                                                                ?></span>
                                                        </div>
                                                        <div class="rating-points">
                                                            <span class="rating-title">G&A </span>
                                                            <span class="points"  id="rating_point_5"><?php
                                                                // if ($get_ca_result['ga']) {
                                                                //     echo $get_ca_result['ga'];
                                                                // } else if ($ga_rat) {
                                                                //     echo $ga_rat;
                                                                // } else {
                                                                //     echo '5';
                                                                // }
                                                                ?></span>
                                                        </div>
                                                    <?php //} ?>
                                                </div>
                                            </div>
                                            <!--//Rating Boxes-->
                                        </div>
                                    </div>
                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Lesson Comment ・ レッスンについてのコメント</a></span>
                                    <div class="acc-container" style="display: none;">
                                        <div>
                                            <div class="clearfix bg-grey" style="border-radius: 10px 10px 0 0;">
                                                <div>
                                                    <div>
                                                        <h2 class="bg-blue">Lesson Comment ・ レッスンについてのコメント</h2>
                                                        <div class="lesson_comments_inner_div">
                                                            <span class="lesson_comment_checkbox"><input type="checkbox" id="stuNoShow"><label>Student No Show</label></span>
                                                            <div class="editable_div" id="lesson_comment_textarea" contentEditable="true"><?php
                                                                // if ($lesson_comments_temp) {
                                                                //     echo $lesson_comments_temp;
                                                                // }
                                                                ?></div>	
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>											
                                        </div>
                                    </div>
                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Accent Progress Level and Rating Description ・ レベルと評価の説明</a></span>
                                    <div class="acc-container" style="display: none;">
                                        <div class="clearfix" style="border-radius: 10px 10px 0 0;">
                                            <?php
                                            // $select_level_query = 'select * from ' . $wpdb->prefix . 'onepage_levels';
                                            // $select_level_results = $wpdb->get_results($select_level_query, ARRAY_A);
                                            // $lev_cnt = 1;
                                            // foreach ($select_level_results as $select_level_result) {
                                                ?>

                                                <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);"><?php //echo $select_level_result['name']; ?></a></span>
                                                <div class="acc-container" style="display: none;">
                                                    <?php
                                                    // $select_level_points_query = 'select * from ' . $wpdb->prefix . 'onepage_points where level_id = ' . $select_level_result['id'];
                                                    // $select_level_points_results = $wpdb->get_results($select_level_points_query, ARRAY_A);
                                                    // $ca_html = '';
                                                    // $fp_html = '';
                                                    // $lc_html = '';
                                                    // $v_html = '';
                                                    // $ga_html = '';
                                                    // $lev_cnt_in = 1;
                                                    // foreach ($select_level_points_results as $select_level_points_result) {
                                                        ?>


                                                        <?php
                //                                         if ($select_level_points_result['rating_name'] == 'CA') {

                //                                             $ca_html .= $select_level_points_result['descrption'] . '<br><span id="progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" style="display:none">	
																// ' . $select_level_points_result['description_ja'] . '</span><a href="javascript:void(0);" class="read-more-btn txt-green progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" onclick="show_japanes_text(\'progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '\')">Read More</a>
																// ';
                //                                         }
                //                                         if ($select_level_points_result['rating_name'] == 'FP') {

                //                                             $fp_html .= $select_level_points_result['descrption'] . '<br><span id="progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" style="display:none">	
																// ' . $select_level_points_result['description_ja'] . '</span><a href="javascript:void(0);" class="read-more-btn txt-green progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" onclick="show_japanes_text(\'progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '\')">Read More</a>
																// ';
                //                                         }
                //                                         if ($select_level_points_result['rating_name'] == 'LC') {

                //                                             $lc_html .= $select_level_points_result['descrption'] . '<br><span id="progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" style="display:none">	
																// ' . $select_level_points_result['description_ja'] . '</span><a href="javascript:void(0);" class="read-more-btn txt-green progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" onclick="show_japanes_text(\'progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '\')">Read More</a>
																// ';
                //                                         }
                //                                         if ($select_level_points_result['rating_name'] == 'V') {

                //                                             $v_html .= $select_level_points_result['descrption'] . '<br><span id="progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" style="display:none">	
																// ' . $select_level_points_result['description_ja'] . '</span><a href="javascript:void(0);" class="read-more-btn txt-green progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" onclick="show_japanes_text(\'progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '\')">Read More</a>
																// ';
                //                                         }
                //                                         if ($select_level_points_result['rating_name'] == 'GA') {

                //                                             $ga_html .= $select_level_points_result['descrption'] . '<br><span id="progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" style="display:none">	
																// ' . $select_level_points_result['description_ja'] . '</span><a href="javascript:void(0);" class="read-more-btn txt-green progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '" onclick="show_japanes_text(\'progress_level_' . $select_level_points_result['rating_name'] . '_' . $lev_cnt_in . '_' . $lev_cnt . '\')">Read More</a>
																// ';
                //                                         }
                                                        ?>

                                                        <?php
                                                        //$lev_cnt_in++;
                                                   // }
                                                    ?>
                                                    <p class="success">
                                                        <?php //echo $select_level_result['description_en']; ?>
                                                        <span id="progress_level_<?php //echo $lev_cnt; ?>" style="display:none">	
                                                            <?php //echo $select_level_result['description_ja']; ?>
                                                        </span>
                                                        <a href="javascript:void(0);" class="read-more-btn txt-green progress_level_<?php //echo $lev_cnt; ?>" onclick="show_japanes_text('progress_level_<?php //echo $lev_cnt; ?>')">Read More</a>
                                                    </p>
                                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">CA</a></span>
                                                    <div class="acc-container" style="display: none;">
                                                        <?php //echo $ca_html; ?>
                                                    </div>
                                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">FP</a></span>
                                                    <div class="acc-container" style="display: none;">
                                                        <?php //echo $fp_html; ?>
                                                    </div>
                                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">LC</a></span>
                                                    <div class="acc-container" style="display: none;">
                                                        <?php //echo $lc_html; ?>
                                                    </div>
                                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">V</a></span>
                                                    <div class="acc-container" style="display: none;">
                                                        <?php //echo $v_html; ?>
                                                    </div>
                                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">GA</a></span>
                                                    <div class="acc-container" style="display: none;">
                                                        <?php //echo $ga_html; ?>
                                                    </div>
                                                </div>
                                                <?php
                                                //$lev_cnt++;
                                            //}
                                            ?>
                                        </div>											
                                    </div>
                                    <span data-mode="toggle" class="acc-trigger"><a href="javascript:void(0);">Profile ・ プロフィール</a></span>
                                    <div class="acc-container" style="display: none;">
                                        <div>
                                            <div class="clearfix" style="border-radius: 10px 10px 0 0;">
                                                <div>
                                                    <div>
                                                        <?php
                                                        $select_levels = "select * from " . $wpdb->prefix . "onepage_levels";
                                                        $levels_results = $wpdb->get_results($select_levels, ARRAY_A);
                                                        ?>
                                                        <select id="student_level_select" onchange="change_level_of_student()">
                                                            <option value="">Change Student Level</option>
                                                            <?php
                                                            // $student_level = get_user_meta($select_date_for_title_result->student_id, 'student_level', true);

                                                            // foreach ($levels_results as $levels_result) {
                                                            //     $sel = $levels_result['id'] == $student_level ? 'selected="selected"' : '';
                                                            //     ?>																
                                                            //     <option style="color:#333; padding:5px; " <?php //echo $sel; ?> value="<?php //echo $levels_result['id']; ?>">
                                                            //         <?php //echo $levels_result['name']; ?>
                                                            //     </option>

                                                            //     <option disabled style="font-style:italic">&nbsp;&nbsp;&nbsp;<?php //echo $levels_result['description_en']; ?></option>
                                                            //     <?php
                                                            // }
                                                            ?> 
                                                        </select>
                                                        <?php 
                                                        // if ($get_lev_result['name']) { ?>
                                                            <div class="success-alert">
                                                                <p class="success"><span><b>Student level :-</b></span><span><?php //echo $get_lev_result['name']; ?></span></p>
                                                                <p class="success"><span><b>Level description :-</b></span><span><?php //echo $get_lev_result['description_en']; ?><br><?php //echo $get_lev_result['description_ja']; ?></span></p>
                                                            </div>
                                                        <?php //} ?>
                                                    </div>
                                                </div>
                                            </div>											
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<input style="float:right; margin-top:20px;" type="button" value="Wrap" onclick="wrap_lesson('wrap')">-->
                            <div class="clearfix bottom btns-wrapper"> 
                                <a href="javascript:void(0);" class="bottom-wrap-btn"onclick="wrap_lesson('wrap')" ><img src="<?php// bloginfo('template_directory'); ?>/images/icon-wrap.svg" alt="Wrap-icon"/></a>	
                            </div>
                        </div>
                    </div>
                    <?php
                    // $current_lesson_time = '';
                    // $today_lesson_with_gap_30_cnt = '';
                    // $get_prev_lessons_id = 'select student_id, teacher, taught_on, service_id, taught_at, duration from ' . $wpdb->prefix . 'lesson_record where id = ' . $lessonRecordId . ' order by id ASC';

                    // $get_prev_lessons_id_result = $wpdb->get_row($get_prev_lessons_id, ARRAY_A);

                    // if (is_array($get_prev_lessons_id_result) && count($get_prev_lessons_id_result) > 0) {

                    //     $current_lesson_time = date('H:i:s', strtotime($get_prev_lessons_id_result['taught_at'] . ' + ' . $get_prev_lessons_id_result['duration'] . ' minutes'));


                    //     $select_other_lessons = 'select * from ' . $wpdb->prefix . 'lesson_record where student_id = ' . $get_prev_lessons_id_result['student_id'] . ' and teacher = "' . $get_prev_lessons_id_result['teacher'] . '" and service_id = ' . $get_prev_lessons_id_result['service_id'] . ' and taught_on = "' . $get_prev_lessons_id_result['taught_on'] . '" and status = "scheduled" order by id ASC';
                    //     $select_other_lessons_results = $wpdb->get_results($select_other_lessons, ARRAY_A);
                    // }

                    // $current_open_lesson_date = strtotime($get_prev_lessons_id_result['taught_on'] . ' ' . $get_prev_lessons_id_result['taught_at']);
                    // $i = 1;
                    // if (is_array($select_other_lessons_results) && count($select_other_lessons_results) > 0) {

                    //     foreach ($select_other_lessons_results as $select_other_lessons_result) {

                    //         $next_lesson_time = date('H:i:s', strtotime($select_other_lessons_result['taught_at']));
                    //         $cur_time = strtotime($current_lesson_time);
                    //         $next_time = strtotime($next_lesson_time);
                    //         $diff = ($next_time - $cur_time);
                    //         /* $hours = date('H', $diff);
                    //           $total_hours = $hours*60;
                    //           $minutes = date('i', $diff);
                    //           $total_minutes = $total_hours+$minutes;
                    //           $date_sum = strtotime($select_other_lessons_result['taught_on'].' '.$select_other_lessons_result['taught_at']); */
                    //         //$total_minutes < 30;
                    //         if ($diff > 1800) {

                    //             $today_lesson_with_gap_30_cnt = 1;
                    //         }
                    //     }
                    // }
                    //echo '<br>I am here :- '.$today_lesson_with_gap_30_cnt;
                    ?>
                    <script type="text/javascript">

                        function change_level_of_student() {

                            val = jQuery('#student_level_select').val();
                            jQuery('#student_level').val(val);
                            if (val != '') {

                                jQuery('.comman_loading_image').show();
                                jQuery.post(
                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                        {
                                            action: 'change_level_of_student',
                                            level_id: val,
                                            student_id: <?php //echo $select_date_for_title_result->student_id; ?>,
                                        }, function (response) {

                                    jQuery('.comman_loading_image').hide();
                                    jQuery('#response_div_points_to_improve').html('');
                                    jQuery('#response_div_strong_points').html('');
                                    jQuery('#rating_type_clicked').html('');
                                    var clciked_item = jQuery('#last_clicked_item').val();
                                    location.reload();
                                }
                                );
                            }
                        }
                        function getSelectionHtml() {
                            //replaceCopiedText();
                            var html = "";
                            var last_final_text = '';
                            html = jQuery('#editor_textarea').html();
                            html = html.replace(/&nbsp;/gi, ' ');
                            //html = searchReplace(html, '<div><br></div>', "<br>");

                            var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
                            var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
                            if (isChrome || isSafari) {
                                html = searchReplace(html, '<br>', "");
                            }


                            html = searchReplace(html, '<div>', "");
                            html = searchReplace(html, '</div>', "<br>");
                            html = searchReplace(html, '<br><br><br><br>', "<br><br>");
                            html = searchReplace(html, '<br><br><br>', "<br><br>");

                            jQuery('#editor_textarea').html(html);
                            lines = html.split("<br>");

                            var total_length = parseInt(lines.length) - 1;
                            var lines_array = [];
                            var html_after_translation = '';

                            var count_correct_lines = '';
                            var count_incorrect_lines = '';
                            for (i = 0; i <= total_length; i++) {
                                if (lines[i] != '' && lines[i] != 'undefined') {
                                    var OChar = lines[i].split(" ").pop();
                                    if (OChar != '' && (OChar == 'o' || OChar == 'O')) {
                                        count_correct_lines = count_correct_lines + 1;
                                    }

                                    if (OChar != '' && (OChar == 'x' || OChar == 'X')) {
                                        count_incorrect_lines = count_incorrect_lines + 1;
                                    }

                                }
                            }
                            if (count_correct_lines != count_incorrect_lines) {
                                alert('Before we can wrap, partner, just make sure the Incorrect and Corrected Phrases are all good!');
                                return false;
                            }

                            for (i = 0; i <= total_length; i++) {

                                if (lines[i] != '' && lines[i] != 'undefined') {

                                    lines_array.push(lines[i]);

                                    if (lines_array.length <= 2 && html_after_translation != '') {
                                        html_after_translation = html_after_translation + '<br>';
                                    }
                                } else {

                                    if (lines_array.length == 2) {

                                        var first_line = lines_array[0];
                                        var second_line = lines_array[1];
                                        var OChar = first_line.split(" ").pop();
                                        var XChar = second_line.split(" ").pop();
                                        if (((OChar == 'O' || OChar == 'o') && (XChar == 'X' || XChar == 'x')) || ((OChar == 'X' || OChar == 'x') && (XChar == 'O' || XChar == 'o'))) {


                                            if ((first_line.split(" ").pop() == 'O' || first_line.split(" ").pop() == 'o') && (second_line.split(" ").pop() == 'X' || second_line.split(" ").pop() == 'x')) {

                                                var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                                                var after_replace = strip_tags('<div>' + show_string + '<div>');
                                                //after_replace = searchReplace(after_replace, ' ?', '?'); 
                                                after_replace = after_replace + '\n';
                                                after_replace = searchReplace(after_replace, '{', '');
                                                after_replace = searchReplace(after_replace, '}', '');
                                                after_replace = encodeURI(after_replace);

                                                var relaced_with = '<div class="correct_incorrect"><span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></span>';
                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                                                html_after_translation = html_after_translation + relaced_with + '<br>';

                                                var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                                                var after_replace = strip_tags('<div>' + show_string + '</div>');
                                                //after_replace = searchReplace(after_replace, ' ?', '?');
                                                after_replace = after_replace + '\n';
                                                after_replace = searchReplace(after_replace, '{', '');
                                                after_replace = searchReplace(after_replace, '}', '');
                                                after_replace = encodeURI(after_replace);
                                                var relaced_with = '<strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></strike></div>';
                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(second_line, relaced_with));
                                                html_after_translation = html_after_translation + relaced_with + '<br>';

                                            }
                                            if ((first_line.split(" ").pop() == 'X' || first_line.split(" ").pop() == 'x') && (second_line.split(" ").pop() == 'O' || second_line.split(" ").pop() == 'o')) {

                                                var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                                                var after_replace = strip_tags('<div>' + show_string + '</div>');
                                                //after_replace = searchReplace(after_replace, ' ?', '?');
                                                after_replace = after_replace + '\n';
                                                after_replace = searchReplace(after_replace, '{', '');
                                                after_replace = searchReplace(after_replace, '}', '');
                                                after_replace = encodeURI(after_replace);
                                                var relaced_with = '<div class="correct_incorrect"><strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></strike>';
                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                                                html_after_translation = html_after_translation + relaced_with + '<br>';

                                                var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                                                var after_replace = strip_tags('<div>' + show_string + '</div>');
                                                //after_replace = searchReplace(after_replace, ' ?', '?');
                                                after_replace = after_replace + '\n';
                                                after_replace = searchReplace(after_replace, '{', '');
                                                after_replace = searchReplace(after_replace, '}', '');
                                                after_replace = encodeURI(after_replace);
                                                var relaced_with = '<span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></span></div>';
                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(second_line, relaced_with));

                                                html_after_translation = html_after_translation + relaced_with + '<br>';
                                            }

                                        } else {

                                            if ((lines_array[0] != '' && lines_array[0] != 'undefined') && (lines_array[1] != '' && lines_array[1] != 'undefined')) {

                                                new_string = lines_array[0] + '<br>' + lines_array[1];
                                                var link_string = lines_array[0] + '\n' + lines_array[1];
                                                var one_mor_str = searchReplace(link_string, '{', '');
                                                var final_link = searchReplace(one_mor_str, '}', '');
                                                final_link = encodeURI(final_link);
                                                //final_link = searchReplace(final_link, ' ?', '?'); 
                                                var relaced_with = '<span class="arp" style="display: inline"><b><a class="arp_link" target="_blank" href="https://translate.google.com/#en/ja/' + final_link + '">' + new_string + '</a></b></span>';

                                                editor_text = jQuery('#editor_textarea').html();

                                                jQuery('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                                                html_after_translation = html_after_translation + relaced_with + '<br>';
                                            } else {

                                                new_string = lines_array[0] + '<br>' + lines_array[1];
                                                var link_string = lines_array[0] + '\n' + lines_array[1];
                                                var one_mor_str = searchReplace(link_string, '{', '');
                                                var final_link = searchReplace(one_mor_str, '}', '');
                                                final_link = encodeURI(final_link);

                                                var relaced_with = '<span class="" style="display: inline"><b><a class="" target="_blank" href="https://translate.google.com/#en/ja/' + final_link + '">' + new_string + '</a></b></span>';

                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                                                html_after_translation = html_after_translation + relaced_with + '<br>';
                                            }
                                        }
                                        lines_array = [];
                                    } else {


                                        for (x = 0; x < lines_array.length; x++) {

                                            if (lines_array[x].trim() != '' && lines_array[x] != 'undefined') {

                                                if (lines_array[x].indexOf('http://') != '-1' || lines_array[x].indexOf('https://') != '-1') {

                                                    if (lines_array[x] != '' && lines_array[x] != 'undefined') {

                                                        var relaced_with = '<b><a class="google_translate_link" target="_blank" href="' + lines_array[x] + '">' + lines_array[x] + '</a></b>';
                                                        editor_text = jQuery('#editor_textarea').html();
                                                        jQuery('#editor_textarea').html(editor_text.replace(lines_array[x], relaced_with));

                                                        html_after_translation = html_after_translation + relaced_with + '<br>';
                                                    }
                                                } else {
                                                    if (lines_array[x].trim() != '' && lines_array[x] != 'undefined') {

                                                        new_string = lines_array[x];
                                                        new_string = searchReplace(new_string, '{', '');
                                                        new_string = searchReplace(new_string, '}', '');
                                                        new_string = encodeURI(new_string);
                                                        //new_string = searchReplace(new_string, ' ?', '?');
                                                        var relaced_with = '<b><a class="google_translate_link" target="_blank" href="https://translate.google.com/#en/ja/' + new_string + '">' + lines_array[x] + '</a></b>';
                                                        editor_text = jQuery('#editor_textarea').html();
                                                        jQuery('#editor_textarea').html(editor_text.replace(lines_array[x], relaced_with));

                                                        html_after_translation = html_after_translation + relaced_with + '<br>';
                                                    }
                                                }

                                            }

                                        }
                                        lines_array = [];
                                    }
                                }
                            }
                            if (lines_array.length == 2) {
                                var first_line = lines_array[0];
                                var second_line = lines_array[1];
                                var OChar = first_line.split(" ").pop();
                                var XChar = second_line.split(" ").pop();
                                if (((OChar == 'O' || OChar == 'o') && (XChar == 'X' || XChar == 'x')) || ((OChar == 'X' || OChar == 'x') && (XChar == 'O' || XChar == 'o'))) {

                                    if ((first_line.split(" ").pop() == 'O' || first_line.split(" ").pop() == 'o') && (second_line.split(" ").pop() == 'X' || second_line.split(" ").pop() == 'x')) {

                                        var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                                        var after_replace = strip_tags('<div>' + show_string + '<div>');
                                        //after_replace = searchReplace(after_replace, ' ?', '?'); 
                                        after_replace = after_replace + '\n';
                                        after_replace = searchReplace(after_replace, '{', '');
                                        after_replace = searchReplace(after_replace, '}', '');
                                        after_replace = encodeURI(after_replace);

                                        var relaced_with = '<div class="correct_incorrect"><span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></span>';
                                        editor_text = jQuery('#editor_textarea').html();
                                        jQuery('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                                        html_after_translation = html_after_translation + relaced_with + '<br>';

                                        var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                                        var after_replace = strip_tags('<div>' + show_string + '</div>');
                                        //after_replace = searchReplace(after_replace, ' ?', '?');
                                        after_replace = after_replace + '\n';
                                        after_replace = searchReplace(after_replace, '{', '');
                                        after_replace = searchReplace(after_replace, '}', '');
                                        after_replace = encodeURI(after_replace);
                                        var relaced_with = '<strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></strike></div>';
                                        editor_text = jQuery('#editor_textarea').html();
                                        jQuery('#editor_textarea').html(editor_text.replace(second_line, relaced_with));
                                        html_after_translation = html_after_translation + relaced_with + '<br>';

                                    }
                                    if ((first_line.split(" ").pop() == 'X' || first_line.split(" ").pop() == 'x') && (second_line.split(" ").pop() == 'O' || second_line.split(" ").pop() == 'o')) {

                                        var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                                        var after_replace = strip_tags('<div>' + show_string + '</div>');
                                        //after_replace = searchReplace(after_replace, ' ?', '?');
                                        after_replace = after_replace + '\n';
                                        after_replace = searchReplace(after_replace, '{', '');
                                        after_replace = searchReplace(after_replace, '}', '');
                                        after_replace = encodeURI(after_replace);
                                        var relaced_with = '<div class="correct_incorrect"><strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></strike>';
                                        editor_text = jQuery('#editor_textarea').html();
                                        jQuery('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                                        html_after_translation = html_after_translation + relaced_with + '<br>';

                                        var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                                        var after_replace = strip_tags('<div>' + show_string + '</div>');
                                        //after_replace = searchReplace(after_replace, ' ?', '?');
                                        after_replace = after_replace + '\n';
                                        after_replace = searchReplace(after_replace, '{', '');
                                        after_replace = searchReplace(after_replace, '}', '');
                                        after_replace = encodeURI(after_replace);
                                        var relaced_with = '<span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' + after_replace + '">' + show_string + '</a></b></span></div>';
                                        editor_text = jQuery('#editor_textarea').html();
                                        jQuery('#editor_textarea').html(editor_text.replace(second_line, relaced_with));

                                        html_after_translation = html_after_translation + relaced_with + '<br>';
                                    }

                                } else {

                                    if ((lines_array[0] != '' && lines_array[0] != 'undefined') && (lines_array[1] != '' && lines_array[1] != 'undefined')) {

                                        new_string = lines_array[0] + '<br>' + lines_array[1];
                                        var link_string = lines_array[0] + '\n' + lines_array[1];
                                        var one_mor_str = searchReplace(link_string, '{', '');
                                        var final_link = searchReplace(one_mor_str, '}', '');
                                        final_link = encodeURI(final_link);
                                        //final_link = searchReplace(final_link, ' ?', '?'); 
                                        var relaced_with = '<span class="arp" style="display: inline"><b><a class="arp_link" target="_blank" href="https://translate.google.com/#en/ja/' + final_link + '">' + new_string + '</a></b></span>';

                                        editor_text = jQuery('#editor_textarea').html();

                                        jQuery('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                                        html_after_translation = html_after_translation + relaced_with + '<br>';
                                    } else {

                                        new_string = lines_array[0] + '<br>' + lines_array[1];
                                        var link_string = lines_array[0] + '\n' + lines_array[1];
                                        var one_mor_str = searchReplace(link_string, '{', '');
                                        var final_link = searchReplace(one_mor_str, '}', '');
                                        final_link = encodeURI(final_link);

                                        var relaced_with = '<span class="" style="display: inline"><b><a class="" target="_blank" href="https://translate.google.com/#en/ja/' + final_link + '">' + new_string + '</a></b></span>';

                                        editor_text = jQuery('#editor_textarea').html();
                                        jQuery('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                                        html_after_translation = html_after_translation + relaced_with + '<br>';
                                    }
                                }
                                lines_array = [];
                            } else {
                                for (x = 0; x < lines_array.length; x++) {

                                    if (lines_array[x].trim() != '' && lines_array[x] != 'undefined') {

                                        if (lines_array[x].indexOf('http://') != '-1' || lines_array[x].indexOf('https://') != '-1') {

                                            if (lines_array[x] != '' && lines_array[x] != 'undefined') {

                                                var relaced_with = '<b><a class="google_translate_link" target="_blank" href="' + lines_array[x] + '">' + lines_array[x] + '</a></b>';
                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(lines_array[x], relaced_with));

                                                html_after_translation = html_after_translation + relaced_with + '<br>';
                                            }
                                        } else {
                                            if (lines_array[x].trim() != '' && lines_array[x] != 'undefined') {

                                                new_string = lines_array[x];
                                                new_string = searchReplace(new_string, '{', '');
                                                new_string = searchReplace(new_string, '}', '');
                                                new_string = encodeURI(new_string);
                                                //new_string = searchReplace(new_string, ' ?', '?');
                                                var relaced_with = '<b><a class="google_translate_link" target="_blank" href="https://translate.google.com/#en/ja/' + new_string + '">' + lines_array[x] + '</a></b>';
                                                editor_text = jQuery('#editor_textarea').html();
                                                jQuery('#editor_textarea').html(editor_text.replace(lines_array[x], relaced_with));

                                                html_after_translation = html_after_translation + relaced_with + '<br>';
                                            }
                                        }

                                    }

                                }
                                lines_array = [];
                            }
                            html_after_translation = searchReplace(html_after_translation, '<br><br><br><br>', "<br><br>");
                            html_after_translation = searchReplace(html_after_translation, '<br><br><br>', "<br><br>");
                            jQuery('#editor_textarea').html(html_after_translation);
                        }
                        function strip_tags(str) {

                            str = str.toString();
                            var new_str = str.replace(/<\/?[^>]+>/gi, '');
                            return new_str;
                        }
                        function revertToOldHtml() {

                            jQuery('#preview_button').show();
                            jQuery('.botm-eye-icon').show();
                            jQuery('#editor_textarea').attr('contenteditable', 'true');
                            jQuery('#editor_textarea').html(jQuery('#oldHtmlArea').html());
                            jQuery('#editor_text_with_brases').html('')
                            jQuery('.clicked_not_clicked').val(0);
                            jQuery('#previewHtmlAreaParent').hide();
                            jQuery('.botm-eye-icon-white').hide();
                            jQuery('#bind_field').val(0);

                            jQuery('.btn-t1').css('opacity', '1');
                            jQuery('.btn-t2').css('opacity', '1');
                            jQuery('.btn-t3').css('opacity', '1');
                            jQuery('.btn-t4').css('opacity', '1');
                            jQuery('#undo').css('opacity', '1');

                        }
                        function changeHtml() {

                            jQuery('#previewHtmlAreaParent').hide();
                        }
						
						function replaceAt(s, n, t) {
							return s.substring(0, n) + t + s.substring(n + 1);
						}
						
						function replaceTopicTag(str) {
							var regex = /{{/gi, result, indices = [];
							while ( (result = regex.exec(str)) ) {
								var indx = result.index;
								//alert(indx);
								var indx2 = str.indexOf("}", indx);
								//alert(indx2);
								var str2 = str.substr(indx2+1, 1);
								//alert(str2); 
								if(str2 == '}'){
									str = replaceAt(str, indx, '<span class="topictag">');
									str = replaceAt(str, indx+23, '');
									var indx3 = str.indexOf("}", indx+23);
									str = replaceAt(str, indx3, '</span>');
									str = replaceAt(str, indx3+7, '');		
								}
								
								//alert(str);
							}
							return str;
						}


                        function preview_lesson() {


                            var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
                            var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
                            if (isChrome || isSafari) {
                                jQuery("#editor_textarea").contents().filter(function () {
                                    return this.nodeType == Node.TEXT_NODE;
                                }).wrap('<div></div>');
                            }
                            //jQuery("#editor_textarea").html(searchReplace(jQuery("#editor_textarea").html(), '<br>', ""));
                            if (jQuery('#bind_field').val() == 0) {


                                var openBrace = countInstancesOf(jQuery('#editor_textarea').text(), '{');
                                var closeBrace = countInstancesOf(jQuery('#editor_textarea').text(), '}');
                                if (openBrace != closeBrace) {

                                    alert('There is Mismatch in keyword, keyPhrase, Topic Tag braces please cross check once again');
                                    return false;
                                }
                                if (jQuery.trim(jQuery('#editor_textarea').text()) != '') {

                                    jQuery('#editor_textarea').attr('contenteditable', 'false');
                                    jQuery('#preview_button').hide();
                                    jQuery('.botm-eye-icon').hide();
                                    var old_html = jQuery('#editor_textarea').html();
                                    jQuery('#oldHtmlArea').html(old_html);
                                    getSelectionHtml();
                                    var str = jQuery('#editor_textarea').html();
                                    jQuery('#editor_text_with_brases').html(str);
									
									/*str = searchReplace(str, "{{{", '<span class="topictag">');
                                    str = searchReplace(str, "}}}", '</span>');
                                    str = searchReplace(str, "{{", '<span class="keyword">');
                                    str = searchReplace(str, "}}", '</span>');
                                    str = searchReplace(str, "{", '<span class="keyphrase">');
                                    str = searchReplace(str, "}", '</span>');*/
									/*str = searchReplace(str, "{{", '<span class="topictag">');
                                    str = searchReplace(str, "}}", '</span>');*/
									
									str = replaceTopicTag(str);
                                    str = searchReplace(str, "{", '<span class="keyphrase">');
                                    str = searchReplace(str, "}", '</span>');

									var myregexp = /<span[^>]+?class="keyphrase".*?>([\s\S]*?)<\/span>/g;
									var match = myregexp.exec(str);
									var result = "";
									var matched_result = [];
									while (match != null) {
										result = RegExp.$1;
										matched_result.push(result);
										match = myregexp.exec(str);
									}
									matched_result.forEach(function(word){
										if(word.split(" ").length > 1){
											str = searchReplace(str, '<span class="keyphrase">'+word+'</span>', '<span class="keyword">'+word+'</span>');
										}
									});
									
                                    /*Create anchor for entered url in canvas start*/
                                    /*var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                                     str = str.replace(exp, "<a target='_blank' class='glow' href='$1'>$1</a>");
                                     var exp2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
                                     str = str.replace(exp2, '$1<a target="_blank" class="glow" href="http://$2">$2</a>');*/
                                    jQuery('#editor_textarea').html(str);
                                    /*Create anchor for entered url in canvas end*/

                                    jQuery('#editor_textarea').html(str);

                                    jQuery('.topictag').each(function (i, e) {

                                        if (jQuery(this).html() != '') {

                                            jQuery(this).html(jQuery(this).html().trim());
                                        }
                                    });
                                    jQuery('.keyword').each(function (i, e) {

                                        if (jQuery(this).html() != '') {

                                            jQuery(this).html(jQuery(this).html().trim());
                                        }
                                    })
                                            ;
                                    jQuery('.keyphrase').each(function (i, e) {

                                        if (jQuery(this).html() != '') {

                                            jQuery(this).html(jQuery(this).html().trim());
                                        }
                                    });

                                    jQuery('#editor_textarea').each(function () {
                                        if (this.childNodes[0].tagName && this.childNodes[0].tagName.toLowerCase() == 'br') {
                                            jQuery(this.childNodes[0]).remove();
                                        }

                                    });

                                    var topic_tag = jQuery("#editor_textarea .topictag");
                                    var topic_tag_length = topic_tag.length;
                                    var topic_tag_html = '';
                                    if (topic_tag_length > 0) {
                                        for (z = 0; z < topic_tag_length; z++) {

                                            if (jQuery(topic_tag[z]).html() != '') {

                                                topic_tag_html += jQuery(topic_tag[z]).html() + ', ';
                                            }
                                        }
                                    }
                                    jQuery('.current_lesson_topic').html(topic_tag_html.slice(0, -2));
                                    jQuery('#previewHtmlAreaParent').show();
                                    jQuery('.botm-eye-icon-white').show();
                                    jQuery('.clicked_not_clicked').val(1);
                                    jQuery('#bind_field').val(1);
                                    jQuery('.btn-t1').css('opacity', '0.49');
                                    jQuery('.btn-t2').css('opacity', '0.49');
                                    jQuery('.btn-t3').css('opacity', '0.49');
                                    jQuery('.btn-t4').css('opacity', '0.49');
                                    jQuery('#undo').css('opacity', '0.49');


                                } else {

                                    //alert('Add any text to preview');
                                    return false;
                                }
                            } else {
                                alert('You are in review mode');
                            }
                        }
                        function countInstancesOf(str, i) {

                            var count = 0;
                            var pos = -1;

                            while ((pos = str.indexOf(i, pos + 1)) !== - 1)
                                ++count;
                            return count;
                        }
                        function no_wrap_lesson() {
                            jQuery('#alert-message-1').hide();
                        }
                        function wrap_lesson(action) {

                            if (jQuery('#stuNoShow').prop('checked') == false) {

                                if (jQuery('#editor_textarea').text() == '') {

                                    alert('Hey cowboy! At least put something on the canvas before wrapping.');
                                    return false;
                                }
                            }
                            var old_html_content = jQuery('#editor_textarea').html();
                            if (jQuery('.clicked_not_clicked').val() == 0) {

                                if (jQuery('#response_div_points_to_improve').html() == '' && jQuery('#response_div_strong_points').html == '') {
                                    alert('Please check atleast one strong points or points to improve must be there before wrap');
                                    return false;
                                }
                            }
                            if (jQuery('.clicked_not_clicked').val() == 0) {

                                preview_lesson();
                            }
                            jQuery(".strong_points").each(function () {

                                jQuery(this).prop("checked", 'checked');
                            });
                            jQuery(".points_to_improve").each(function () {

                                jQuery(this).prop("checked", 'checked');
                            });
                            var arp_post_data = '';
                            var cor_incor_post_data = '';
                            var topic_tag_html = '';
                            var not_under_arp = '';
                            var keyword_not_under_arp_data = '';
                            var keyword_phrase_not_under_arp_data = '';
                            var arp_array = jQuery('#editor_text_with_brases span.arp');
                            var arp_length = arp_array.length;
                            for (i = 0; i < arp_length; i++) {

                                if (jQuery(arp_array[i]).html() != '') {

                                    arp_post_data += jQuery(arp_array[i]).html() + '^^';
                                }
                            }

                            var cor_incor_array = jQuery('#editor_text_with_brases div.correct_incorrect');
                            var cor_incor_length = cor_incor_array.length;
                            for (x = 0; x < cor_incor_length; x++) {

                                if (jQuery(cor_incor_array[x]).html() != '') {

                                    cor_incor_post_data += jQuery(cor_incor_array[x]).html() + '%%';
                                }
                            }

                            var keyword_not_under_arp = jQuery("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");
                            var keyword_not_under_arp_length = keyword_not_under_arp.length;
                            for (z = 0; z < keyword_not_under_arp_length; z++) {

                                if (jQuery(keyword_not_under_arp[z]).html() != '') {

                                    keyword_not_under_arp_data += jQuery(keyword_not_under_arp[z]).html() + '**';
                                }
                            }

                            var keyword_phrase_not_under_arp = jQuery("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
                            var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
                            for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {

                                if (jQuery(keyword_phrase_not_under_arp[z]).html() != '') {

                                    keyword_phrase_not_under_arp_data += jQuery(keyword_phrase_not_under_arp[z]).html() + '$$';
                                }
                            }

                            var topic_tag = jQuery("#editor_textarea .topictag");
                            var topic_tag_length = topic_tag.length;
                            for (z = 0; z < topic_tag_length; z++) {

                                if (jQuery(topic_tag[z]).html() != '') {

                                    topic_tag_html += jQuery(topic_tag[z]).html() + '*$';
                                }
                            }
                            if (topic_tag_html == '' && jQuery('#stuNoShow').prop('checked') == false) {
                                alert('Hey amazing teacher. Not so fast, gotta at least input 1 Topic.');
                                return false;
                            }

                            if (jQuery('#stuNoShow').prop('checked') == false) {

                                if (arp_post_data == '') {

                                    alert('There must be atleast 1 ARP to successfully wrap this lesson');
                                    return false;
                                }
                            }
                            if (jQuery('#lesson_comment_textarea').html() == '') {

                                alert('Please enter any text in comment before wrap lesson');
                                jQuery('#editor_textarea').html(old_html_content);
                                return false;
                            }
                            var p_to_i = [];
                            if (jQuery('#stuNoShow').prop('checked') == false) {
                                jQuery('#response_div_points_to_improve div :checked').each(function (i, e) {

                                    if (jQuery(this).val() != '') {

                                        p_to_i.push(jQuery(this).val());
                                    }
                                });
                                var s_points = [];
                                jQuery('#response_div_strong_points div :checked').each(function (i, e) {

                                    if (jQuery(this).val() != '') {

                                        s_points.push(jQuery(this).val());
                                    }
                                });
                                var homeWork_task = [];
                                jQuery('.homeWork_task').each(function (i, e) {

                                    if (jQuery(this).val() != '') {

                                        homeWork_task.push(jQuery(this).val());
                                    }
                                });
                                var lesson_material_task = [];
                                jQuery('.lesson_material_task').each(function (i, e) {

                                    if (jQuery(this).val() != '') {

                                        lesson_material_task.push(jQuery(this).val());
                                    }
                                });
                                var lesson_task = [];
                                jQuery('.lesson_task').each(function (i, e) {

                                    if (jQuery(this).val() != '') {

                                        lesson_task.push(jQuery(this).val());
                                    }
                                });
                                var next_lesson_task = [];
                                jQuery('.next_lesson_task').each(function (i, e) {

                                    if (jQuery(this).val() != '') {

                                        next_lesson_task.push(jQuery(this).val());
                                    }
                                });


                                if (jQuery('.clicked_not_clicked').val() == 0) {

                                    if (jQuery('#editor_textarea').text() != '') {
                                        canvas_html = jQuery('#editor_textarea').html();
                                    } else {
                                        return false;
                                    }
                                } else {

                                    if (jQuery('#oldHtmlArea').text() != '') {
                                        canvas_html = jQuery('#oldHtmlArea').html()
                                    } else {
                                        return false;
                                    }
                                }
                            }
                            var ca_rating = jQuery('#rating_point_1').text();
                            var fp_rating = jQuery('#rating_point_2').text();
                            var lc_rating = jQuery('#rating_point_3').text();
                            var v_rating = jQuery('#rating_point_4').text();
                            var ga_rating = jQuery('#rating_point_5').text();
                            var overall_rating = jQuery('#rating_point_result').text();

                            if (jQuery('#stuNoShow').prop('checked') == false) {
    <?php //if ($today_lesson_with_gap_30_cnt == 1) { ?>


                                    jQuery('.modal').hide();
                                    jQuery('#alert-message-2').show();

    <?php //} else { ?>
                                    keyword_len = jQuery("#editor_textarea .keyword").length
                                    keyphrase_len = jQuery("#editor_textarea .keyphrase").length
                                    if ((keyword_len == '' || keyword_len == 0) && (keyphrase_len == '' || keyphrase_len == 0)) {

                                        jQuery('.modal').hide();
                                        jQuery('#alert-message-3').show();
                                        jQuery('.comman_loading_image').hide();
                                    } else {
                                        jQuery('.modal').hide();
                                        jQuery('#alert-message-1').show();
                                    }
    <?php //} ?>

                            } else {
                                jQuery('.modal').hide();
                                jQuery('#alert-message-1').show();
                            }
                        }
                        function check_keyword_entered() {

                            /*var keyword_not_under_arp_data = '';
                             var keyword_phrase_not_under_arp_data = '';
                             
                             var keyword_not_under_arp = jQuery("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");
                             var keyword_not_under_arp_length = keyword_not_under_arp.length;
                             for(z = 0; z < keyword_not_under_arp_length; z++) {
                             
                             if(jQuery(keyword_not_under_arp[z]).html() != '')  {
                             
                             keyword_not_under_arp_data += jQuery(keyword_not_under_arp[z]).html()+'**';
                             }
                             }
                             var keyword_phrase_not_under_arp = jQuery("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
                             var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
                             for(z = 0; z < keyword_phrase_not_under_arp_length; z++) {
                             
                             if(jQuery(keyword_phrase_not_under_arp[z]).html() != '')  {
                             
                             keyword_phrase_not_under_arp_data += jQuery(keyword_phrase_not_under_arp[z]).html()+'$$';
                             }
                             }*/
                            if (jQuery('#stuNoShow').prop('checked') == false) {
                                keyword_len = jQuery("#editor_textarea .keyword").length
                                keyphrase_len = jQuery("#editor_textarea .keyphrase").length
                                if ((keyword_len == '' || keyword_len == 0) && (keyphrase_len == '' || keyphrase_len == 0)) {
                                    jQuery('.modal').hide();
                                    jQuery('#alert-message-3').show();
                                } else {
                                    finaly_wrap_lesson();
                                }
                            } else {
                                finaly_wrap_lesson();
                            }
                        }
                        function finaly_wrap_lesson() {

                            jQuery('.comman_loading_image').show();
                            jQuery('#alert-message-1').hide();
                            jQuery('#alert-message-2').hide();
                            jQuery('#alert-message-3').hide();
                            jQuery('#alert-message-4').hide();
                            var arp_post_data = '';
                            var cor_incor_post_data = '';
                            var topic_tag_html = '';
                            var not_under_arp = '';
                            var keyword_not_under_arp_data = '';
                            var keyword_phrase_not_under_arp_data = '';
                            var p_to_i = [];
                            var s_points = [];
                            var homeWork_task = [];
                            var lesson_material_task = [];
                            var lesson_task = [];
                            var next_lesson_task = [];
                            if (jQuery('#stuNoShow').prop('checked') == false) {
                                var arp_array = jQuery('#editor_text_with_brases span.arp');
                                var arp_length = arp_array.length;
                                for (i = 0; i < arp_length; i++) {

                                    if (jQuery(arp_array[i]).html() != '') {

                                        arp_post_data += jQuery(arp_array[i]).html() + '^^';
                                    }
                                }
                                var cor_incor_array = jQuery('#editor_text_with_brases div.correct_incorrect');
                                var cor_incor_length = cor_incor_array.length;
                                for (x = 0; x < cor_incor_length; x++) {

                                    if (jQuery(cor_incor_array[x]).html() != '') {

                                        cor_incor_post_data += jQuery(cor_incor_array[x]).html() + '%%';
                                    }
                                }
                                var keyword_not_under_arp = jQuery("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");
                                var keyword_not_under_arp_length = keyword_not_under_arp.length;
                                for (z = 0; z < keyword_not_under_arp_length; z++) {

                                    if (jQuery(keyword_not_under_arp[z]).html() != '') {

                                        keyword_not_under_arp_data += jQuery(keyword_not_under_arp[z]).html() + '**';
                                    }
                                }
                                var keyword_phrase_not_under_arp = jQuery("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
                                var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
                                for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {

                                    if (jQuery(keyword_phrase_not_under_arp[z]).html() != '') {

                                        keyword_phrase_not_under_arp_data += jQuery(keyword_phrase_not_under_arp[z]).html() + '$$';
                                    }
                                }
                                var topic_tag = jQuery("#editor_textarea .topictag");
                                var topic_tag_length = topic_tag.length;
                                for (z = 0; z < topic_tag_length; z++) {

                                    if (jQuery(topic_tag[z]).html() != '') {

                                        topic_tag_html += jQuery(topic_tag[z]).html() + '*$';
                                    }
                                }

                                if (jQuery('.clicked_not_clicked').val() == 0) {

                                    if (jQuery('#editor_textarea').text() != '') {
                                        canvas_html = jQuery('#editor_textarea').html();
                                    } else {
                                        return false;
                                    }
                                } else {

                                    if (jQuery('#oldHtmlArea').text() != '') {
                                        canvas_html = jQuery('#oldHtmlArea').html()
                                    } else {
                                        return false;
                                    }
                                }
                            }
                            jQuery('#response_div_points_to_improve div :checked').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    p_to_i.push(jQuery(this).val());
                                }
                            });
                            jQuery('#response_div_strong_points div :checked').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    s_points.push(jQuery(this).val());
                                }
                            });
                            jQuery('.homeWork_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    homeWork_task.push(jQuery(this).val());
                                }
                            });
                            jQuery('.lesson_material_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    lesson_material_task.push(jQuery(this).val());
                                }
                            });
                            jQuery('.lesson_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    lesson_task.push(jQuery(this).val());
                                }
                            });
                            jQuery('.next_lesson_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    next_lesson_task.push(jQuery(this).val());
                                }
                            });
                            var ca_rating = jQuery('#rating_point_1').text();
                            var fp_rating = jQuery('#rating_point_2').text();
                            var lc_rating = jQuery('#rating_point_3').text();
                            var v_rating = jQuery('#rating_point_4').text();
                            var ga_rating = jQuery('#rating_point_5').text();
                            var overall_rating = jQuery('#rating_point_result').text();
                            jQuery('#check_wrap_click').val(1);
                            jQuery.post(
                                    '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                    {
                                        action: 'saveOnePageDataInTempTable',
                                        canvas_html_others: canvas_html,
                                        canvas_html: jQuery('#editor_textarea').html(),
                                        string: arp_post_data,
                                        string_2: cor_incor_post_data,
                                        topic_tag_html: topic_tag_html,
                                        keyword_not_under_arp_data: keyword_not_under_arp_data,
                                        keyword_phrase_not_under_arp_data: keyword_phrase_not_under_arp_data,
                                        lesson_comment_textarea: jQuery('#lesson_comment_textarea').html(),
                                        points_to_improve: p_to_i,
                                        strong_points: s_points,
                                        lesson_material_textarea: lesson_material_task,
                                        lesson_tasks_textarea: lesson_task,
                                        homework_lesson_material_textarea: homeWork_task,
                                        next_lesson_task_textarea: next_lesson_task,
                                        ca_rating: ca_rating,
                                        fp_rating: fp_rating,
                                        lc_rating: lc_rating,
                                        v_rating: v_rating,
                                        ga_rating: ga_rating,
                                        overall_rating: overall_rating,
                                        stunoshow: jQuery('#stuNoShow').attr('checked'),
                                        clicked_rating_type: jQuery('#rating_type_clicked').val(),
                                        last_clicked_item: jQuery('#last_clicked_item').val(),
                                        lesson_record_id: '<?php //echo $lessonRecordId; ?>',
                                        taught_date: '<?php //echo $_REQUEST['taught_date']; ?>',
                                        taught_time: '<?php //echo $_REQUEST['taught_time']; ?>',
                                        type: 'arp_correct_incorr',
                                        async: true,
                                    }, function (response) {

                                if (response) {

                                    var strVale = response;
                                    var intValArray = strVale.split(',');
                                    var get_last_u_key = strVale.split(',').pop(-1);
                                    for (var i = 0; i < intValArray.length; i++) {

                                        if (intValArray[i] != '') {

                                            jQuery.post('<?php //echo site_url(); ?>/TCPDF-master/examples/generate_pdf.php',
                                                    {
                                                        unique_key: intValArray[i]
                                                    }, function (res) {

                                                jQuery('#alert-message-4').show();
                                                //alert('Your lesson has been wrapped successfully.');
                                                jQuery('.comman_loading_image').hide();
                                                window.location.assign("<?php echo site_url(); ?>/en/onepage-report/?unique_key=" + get_last_u_key);

                                            }
                                            );
                                        }

                                    }
                                }
                            }
                            );
                        }
                        function save_for_next_lessons() {

                            jQuery('.comman_loading_image').show();
                            jQuery('#alert-message-2').show();
                            var arp_post_data = '';
                            var cor_incor_post_data = '';
                            var topic_tag_html = '';
                            var not_under_arp = '';
                            var keyword_not_under_arp_data = '';
                            var keyword_phrase_not_under_arp_data = '';
                            var arp_array = jQuery('#editor_text_with_brases span.arp');
                            var arp_length = arp_array.length;
                            for (i = 0; i < arp_length; i++) {

                                if (jQuery(arp_array[i]).html() != '') {

                                    arp_post_data += jQuery(arp_array[i]).html() + '^^';
                                }
                            }
                            var cor_incor_array = jQuery('#editor_text_with_brases div.correct_incorrect');
                            var cor_incor_length = cor_incor_array.length;
                            for (x = 0; x < cor_incor_length; x++) {

                                if (jQuery(cor_incor_array[x]).html() != '') {

                                    cor_incor_post_data += jQuery(cor_incor_array[x]).html() + '%%';
                                }
                            }
                            var keyword_not_under_arp = jQuery("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");
                            var keyword_not_under_arp_length = keyword_not_under_arp.length;
                            for (z = 0; z < keyword_not_under_arp_length; z++) {

                                if (jQuery(keyword_not_under_arp[z]).html() != '') {

                                    keyword_not_under_arp_data += jQuery(keyword_not_under_arp[z]).html() + '**';
                                }
                            }
                            var keyword_phrase_not_under_arp = jQuery("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
                            var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
                            for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {

                                if (jQuery(keyword_phrase_not_under_arp[z]).html() != '') {

                                    keyword_phrase_not_under_arp_data += jQuery(keyword_phrase_not_under_arp[z]).html() + '$$';
                                }
                            }
                            var topic_tag = jQuery("#editor_textarea .topictag");
                            var topic_tag_length = topic_tag.length;
                            for (z = 0; z < topic_tag_length; z++) {

                                if (jQuery(topic_tag[z]).html() != '') {

                                    topic_tag_html += jQuery(topic_tag[z]).html() + '*$';
                                }
                            }
                            var p_to_i = [];
                            jQuery('#response_div_points_to_improve div :checked').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    p_to_i.push(jQuery(this).val());
                                }
                            });
                            var s_points = [];
                            jQuery('#response_div_strong_points div :checked').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    s_points.push(jQuery(this).val());
                                }
                            });
                            var homeWork_task = [];
                            jQuery('.homeWork_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    homeWork_task.push(jQuery(this).val());
                                }
                            });
                            var lesson_material_task = [];
                            jQuery('.lesson_material_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    lesson_material_task.push(jQuery(this).val());
                                }
                            });
                            var lesson_task = [];
                            jQuery('.lesson_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    lesson_task.push(jQuery(this).val());
                                }
                            });
                            var next_lesson_task = [];
                            jQuery('.next_lesson_task').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    next_lesson_task.push(jQuery(this).val());
                                }
                            });

                            if (jQuery('.clicked_not_clicked').val() == 0) {

                                if (jQuery('#editor_textarea').text() != '') {
                                    canvas_html = jQuery('#editor_textarea').html();
                                } else {
                                    return false;
                                }
                            } else {

                                if (jQuery('#oldHtmlArea').text() != '') {
                                    canvas_html = jQuery('#oldHtmlArea').html()
                                } else {
                                    return false;
                                }
                            }
                            var ca_rating = jQuery('#rating_point_1').text();
                            var fp_rating = jQuery('#rating_point_2').text();
                            var lc_rating = jQuery('#rating_point_3').text();
                            var v_rating = jQuery('#rating_point_4').text();
                            var ga_rating = jQuery('#rating_point_5').text();
                            var overall_rating = jQuery('#rating_point_result').text();
                            jQuery('#check_wrap_click').val(1);
                            jQuery.post(
                                    '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                    {
                                        action: 'saveDataForNextLessons',
                                        canvas_html: canvas_html,
                                        canvas_html_others: jQuery('#editor_textarea').html(),
                                        string: arp_post_data,
                                        string_2: cor_incor_post_data,
                                        topic_tag_html: topic_tag_html,
                                        keyword_not_under_arp_data: keyword_not_under_arp_data,
                                        keyword_phrase_not_under_arp_data: keyword_phrase_not_under_arp_data,
                                        lesson_comment_textarea: jQuery('#lesson_comment_textarea').html(),
                                        points_to_improve: p_to_i,
                                        strong_points: s_points,
                                        lesson_material_textarea: lesson_material_task,
                                        lesson_tasks_textarea: lesson_task,
                                        homework_lesson_material_textarea: homeWork_task,
                                        next_lesson_task_textarea: next_lesson_task,
                                        ca_rating: ca_rating,
                                        fp_rating: fp_rating,
                                        lc_rating: lc_rating,
                                        v_rating: v_rating,
                                        ga_rating: ga_rating,
                                        overall_rating: overall_rating,
                                        stunoshow: jQuery('#stuNoShow').attr('checked'),
                                        clicked_rating_type: jQuery('#rating_type_clicked').val(),
                                        last_clicked_item: jQuery('#last_clicked_item').val(),
                                        lesson_record_id: '<?php //echo $lessonRecordId; ?>',
                                        taught_date: '<?php //echo $_REQUEST['taught_date']; ?>',
                                        taught_time: '<?php //echo $_REQUEST['taught_time']; ?>',
                                        type: 'arp_correct_incorr',
                                        async: true,
                                    }, function (response) {
                                jQuery('.comman_loading_image').hide();
                                jQuery('#alert-message-2').hide();
                            }
                            );
                        }
                        function autoSaveData() {

                            canvas_html = '';
                            var arp_post_data = '';
                            var cor_incor_post_data = '';
                            var topic_tag_html = '';
                            var keyword_not_under_arp_data = '';
                            var keyword_phrase_not_under_arp_data = '';
                            var arp_array = jQuery('#editor_text_with_brases span.arp');
                            var arp_length = arp_array.length;
                            for (i = 0; i < arp_length; i++) {

                                if (jQuery(arp_array[i]).html() != '') {

                                    arp_post_data += jQuery(arp_array[i]).html() + '^^';
                                }
                            }

                            var cor_incor_array = jQuery('#editor_text_with_brases div.correct_incorrect');
                            var cor_incor_length = cor_incor_array.length;
                            for (x = 0; x < cor_incor_length; x++) {

                                if (jQuery(cor_incor_array[x]).html() != '') {

                                    cor_incor_post_data += jQuery(cor_incor_array[x]).html() + '%%';
                                }
                            }

                            var keyword_not_under_arp = jQuery("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");
                            var keyword_not_under_arp_length = keyword_not_under_arp.length;
                            for (z = 0; z < keyword_not_under_arp_length; z++) {

                                if (jQuery(keyword_not_under_arp[z]).html() != '') {

                                    keyword_not_under_arp_data += jQuery(keyword_not_under_arp[z]).html() + '**';
                                }
                            }

                            var keyword_phrase_not_under_arp = jQuery("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
                            var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
                            for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {

                                if (jQuery(keyword_phrase_not_under_arp[z]).html() != '') {

                                    keyword_phrase_not_under_arp_data += jQuery(keyword_phrase_not_under_arp[z]).html() + '$$';
                                }
                            }

                            var topic_tag = jQuery("#editor_textarea .topictag");
                            var topic_tag_length = topic_tag.length;
                            for (z = 0; z < topic_tag_length; z++) {

                                if (jQuery(topic_tag[z]).html() != '') {

                                    topic_tag_html += jQuery(topic_tag[z]).html() + '*$';
                                }
                            }

                            if (jQuery('.clicked_not_clicked').val() == 0) {

                                if (jQuery('#editor_textarea').text() != '') {
                                    canvas_html = jQuery('#editor_textarea').html();
                                } else {
                                    return false;
                                }
                            } else {

                                if (jQuery('#oldHtmlArea').text() != '') {
                                    canvas_html = jQuery('#oldHtmlArea').html()
                                } else {
                                    return false;
                                }
                            }
                            var p_to_i = [];
                            jQuery('#response_div_points_to_improve div :checkbox').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    p_to_i.push(jQuery(this).val());
                                }
                            });
                            var s_points = [];
                            jQuery('#response_div_strong_points div :checkbox').each(function (i, e) {

                                if (jQuery(this).val() != '') {

                                    s_points.push(jQuery(this).val());
                                }
                            });

                            if (jQuery('#check_wrap_click').val() == 0 && canvas_html != '') {

                                var homeWork_task = [];
                                jQuery('.homeWork_task').each(function (i, e) {

                                    homeWork_task.push(jQuery(this).val());
                                });
                                var lesson_material_task = [];
                                jQuery('.lesson_material_task').each(function (i, e) {

                                    lesson_material_task.push(jQuery(this).val());
                                });
                                var lesson_task = [];
                                jQuery('.lesson_task').each(function (i, e) {

                                    lesson_task.push(jQuery(this).val());
                                });
                                var next_lesson_task = [];
                                jQuery('.next_lesson_task').each(function (i, e) {

                                    next_lesson_task.push(jQuery(this).val());
                                });
                                var ca_rating = jQuery('#rating_point_1').text();
                                var fp_rating = jQuery('#rating_point_2').text();
                                var lc_rating = jQuery('#rating_point_3').text();
                                var v_rating = jQuery('#rating_point_4').text();
                                var ga_rating = jQuery('#rating_point_5').text();
                                var overall_rating = jQuery('#rating_point_result').text();
                                jQuery.post(
                                        '<?php //echo admin_url('admin-ajax.php', 'relative'); ?>',
                                        {
                                            action: 'autoSaveData',
                                            canvas_html_with_tags: jQuery('#editor_textarea').html(),
                                            canvas_html: canvas_html,
                                            string: arp_post_data,
                                            string_2: cor_incor_post_data,
                                            topic_tag_html: topic_tag_html,
                                            keyword_not_under_arp_data: keyword_not_under_arp_data,
                                            keyword_phrase_not_under_arp_data: keyword_phrase_not_under_arp_data,
                                            lesson_comment_textarea: jQuery('#lesson_comment_textarea').html(),
                                            points_to_improve: p_to_i,
                                            strong_points: s_points,
                                            ca_rating: ca_rating,
                                            fp_rating: fp_rating,
                                            lc_rating: lc_rating,
                                            v_rating: v_rating,
                                            ga_rating: ga_rating,
                                            overall_rating: overall_rating,
                                            lesson_material_textarea: lesson_material_task,
                                            lesson_tasks_textarea: lesson_task,
                                            homework_lesson_material_textarea: homeWork_task,
                                            next_lesson_task_textarea: next_lesson_task,
                                            last_clicked_item: jQuery('#last_clicked_item').val(),
                                            lesson_record_id: '<?php //echo $lessonRecordId; ?>',
                                            taught_date: '<?php //echo $_REQUEST['taught_date']; ?>',
                                            taught_time: '<?php //echo $_REQUEST['taught_time']; ?>',
                                            async: true,
                                        }, function (response) {
                                }
                                );
                            }
                        }
                        function toggle_menu(id) {

                            jQuery("#" + id).slideToggle("slow");
                        }
                        function showhiddenlevels(show_class) {

                            jQuery('.points_to_improve_prev_lesson').hide();
                            jQuery('.strong_points_prev_lesson').hide();
                            jQuery('#last_clicked_item').val(show_class);

    <?php if ($student_level) { ?>

                                jQuery('.' + show_class + '_' +<?php //echo $student_level; ?> + '_container').show();
                                jQuery('.' + show_class + '_' +<?php //echo $student_level + 1; ?> + '_container').show();
                                jQuery('.' + show_class + '_' +<?php //echo $student_level - 1; ?> + '_container').show();
    <?php } ?>
                        }
                        function check_rating_lie_between(rating_no) {

                            var rating = 5 * (parseInt(rating_no) / 100);
                            if (rating == 0) {

                                rating = 1;
                            }
                            return rating.toFixed(2);
                        }
                        function searchReplace(str, search, replacement) {

                            return str.replace(new RegExp(search, 'g'), replacement);
                        }

                    </script>


                <?php //} ?>

            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php //bloginfo('template_directory'); ?>/js/simple-undo.js"></script>
<script language="javascript" type="text/javascript">
				jQuery(document).ready(function(){
                    jQuery('.show_all_bookings').on('click', function () {
                        jQuery('#current_booking').toggle();
                        jQuery('#all_bookings').toggle();
                        if (jQuery('.show_all_bookings').text() == 'Show All') {
                            jQuery('.show_all_bookings').text('Show Current');
                        } else {
                            jQuery('.show_all_bookings').text('Show All');
                        }
						return false;
                    });
				});
</script>
<script type="text/javascript">
    function updateButtons(history) {
        jQuery('#undo').attr('disabled', !history.canUndo());
        jQuery('#redo').attr('disabled', !history.canRedo());
    }
    function setEditorContents(contents) {
        jQuery('#editor_textarea').html(contents);
    }
    function keep_focus() {
        var t = jQuery("#editor_textarea");
        var l = jQuery("#editor_textarea").html().length;
        jQuery(t).focus();
    }
    jQuery(function () {
        var counter = 0;

        var history = new SimpleUndo({
            maxLength: 500,
            provider: function (done) {
                done(jQuery('#editor_textarea').html());
            },
            onUpdate: function () {
                //onUpdate is called in constructor, making history undefined
                if (!history)
                    return;
                updateButtons(history);
            }
        });

        /*document.addEventListener('keydown', function(event){
         if(event.keyCode == 90 && event.ctrlKey){
         event.preventDefault();
         history.undo(setEditorContents);
         keep_focus();
         }
         if(event.keyCode == 89 && event.ctrlKey){
         event.preventDefault();
         history.redo(setEditorContents);
         keep_focus();
         }
         }, false);*/

        jQuery('#undo').click(function () {
            history.undo(setEditorContents);
        });
        jQuery('#redo').click(function () {
            history.redo(setEditorContents);
        });
        jQuery('#editor_textarea').keypress(function () {
            history.save();
        });
        jQuery('.btn-t1').click(function () {
            history.save();
        });
        jQuery('.btn-t2').click(function () {
            history.save();
        });
        jQuery('.btn-t3').click(function () {
            history.save();
        });
        jQuery('#editor_textarea').on('focus', function () {
            history.save();
        });
        updateButtons(history);
    });
	
	
	
	/*jQuery('.close-popup').on('click touchstart', function() {
		jQuery('.close-popup').parents('.homwork_popup_parent').css('display', 'none');
		jQuery('.close-popup').parents('.homwork_popup').removeClass('homwork_popup');
		jQuery('.close-popup').parents('.pop-up-holder').removeClass('pop-up-holder');
		jQuery('.close-popup').remove();
	});*/
	
	jQuery(document).ready(function() { // better to use $(document).ready(function(){
		jQuery('.close-popup').on('click touchstart', function() {
			jQuery('.close-popup').parents('.homwork_popup_parent').css('display', 'none');
			jQuery('.close-popup').parents('.homwork_popup').removeClass('homwork_popup');
			jQuery('.close-popup').parents('.pop-up-holder').removeClass('pop-up-holder');
			jQuery('.close-popup').remove();
		});
		
		jQuery(".lmdiv").on('click touchstart', function() {
			jQuery(this).addClass("grey i");
		  var valu = jQuery(this).attr("data-attr");
		  if(valu == 1) {		  
			  var currentvalue = jQuery('#abc1').val();
			  jQuery("#hlm1").val(currentvalue);
		  } else if(valu == 2) {		  
			  var currentvalue = jQuery('#abc2').val();
			  jQuery("#hlm2").val(currentvalue);
		  } else if(valu == 3) {		  
			  var currentvalue = jQuery('#abc3').val();
			  jQuery("#hlm3").val(currentvalue);
		  }
		});
		
		jQuery(".ltdiv").on('click touchstart', function() {
			jQuery(this).addClass("grey i");
		  var valu = jQuery(this).attr("data-attr");
		  if(valu == 1) {		  
			  var currentvalue = jQuery('#lt1').val();
			  jQuery("#nlt1").val(currentvalue);
		  } else if(valu == 2) {		  
			  var currentvalue = jQuery('#lt2').val();
			  jQuery("#nlt2").val(currentvalue);
		  } else if(valu == 3) {		  
			  var currentvalue = jQuery('#lt3').val();
			  jQuery("#nlt3").val(currentvalue);
		  }
		});
		
		jQuery('#alert-message-5').show();
	});

</script>

<?php
//get_footer();
?>