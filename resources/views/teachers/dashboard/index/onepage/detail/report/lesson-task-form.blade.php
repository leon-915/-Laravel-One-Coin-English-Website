<?php
if (!empty($tasks['lessons_material_and_tasks_2'])) {
	$lmt2 =  $tasks['lessons_material_and_tasks_2'];
} else {
	$lmt2 = '';
}
	
if (!empty($tasks['lessons_material_and_tasks_3'])) {
	$lmt3 = $tasks['lessons_material_and_tasks_3'];
} else {
	$lmt3 = '';
}

$display_close_btn = TRUE;	

if (!empty($tasks['lessons_tasks_2'])) {
	$lt2 = $tasks['lessons_tasks_2'];
} else {
	$lt2 = '';
}

if (!empty($tasks['lessons_tasks_3'])) {
	$lt3 = $tasks['lessons_tasks_3'];
} else {
	$lt3 = '';
}

if (!empty($tasks['homework_lessons_material_and_tasks_2'])) {
	$homework_lessons_material_and_tasks_2 = $tasks['homework_lessons_material_and_tasks_2'];
} else {
	$homework_lessons_material_and_tasks_2 = '';
}

if (!empty($tasks['homework_lessons_material_and_tasks_3'])) {
	$homework_lessons_material_and_tasks_3 = $tasks['homework_lessons_material_and_tasks_3'];
} else {
	$homework_lessons_material_and_tasks_3 = '';
}

if (!empty($tasks['next_lessons_tasks_2'])) {
	$next_lessons_tasks_2 = $tasks['next_lessons_tasks_2'];
} else {
	$next_lessons_tasks_2 = '';
}

if (!empty($tasks['next_lessons_tasks_3'])) {
	$next_lessons_tasks_3 = $tasks['next_lessons_tasks_3'];
} else {
	$next_lessons_tasks_3 = '';
}

?>
<div class="lesson_materials_task">
            <div class="row">
                <div class="col-lg-6">
                    <div class="lesson_inner">
                        <h4 class="les_title">Lesson Materials and Tasks・教材</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group lesson">
                                    <textarea name="lessons_material_and_tasks_1" id="lessons_material_and_tasks_1" class="form-control ac-st-lesson-task"><?= !empty($tasks['lessons_material_and_tasks_1']) && ucfirst($tasks['lessons_material_and_tasks_1']) != 'Default Text' ? str_replace('<br>', '', $tasks['lessons_material_and_tasks_1']) : '① Use what we have learnt frequently to remember easily through habit.  
② Avoid translating from English to Japanese. Practice English input and English output. 
③ Without reading, practice saying and acting out your sentences aloud several times for fluency.  
The basic principle for any learning is to create a good habit.
[Please do not delete. Default.]' ?></textarea>
                                    
                                </div>
                            </div>
                        </div>
						
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group lesson">
									<input type="hidden" name="show_close_btn" id="show_close_btn" value="" />
                                    <textarea name="lessons_material_and_tasks_2"  id="lessons_material_and_tasks_2" class="form-control ac-st-lesson-task compare-tasks"><?php echo str_replace('<br>', '', $lmt2); ?></textarea>
									<?php if(trim($lmt2) != '' && trim($homework_lessons_material_and_tasks_2) == '' && (trim($lmt2) !=  trim($homework_lessons_material_and_tasks_2))){ ?>
										<button class="lessn_btn cpy_lessons_tasks lmdiv"  data-attr="2" data-copy_to="homework_lessons_material_and_tasks_2" id="cpy_lessons_material_and_tasks_2"><i class="fas fa-angle-down"></i></button>
										
										<script type="text/javascript" language="javascript">
											show_close_btn_val = jQuery('#show_close_btn').val();
											if(show_close_btn_val == '') {
												jQuery('#show_close_btn').val('lessons_material_and_tasks_2');	
											} else {
												show_close_btn_val = show_close_btn_val +',lessons_material_and_tasks_2';
												jQuery('#show_close_btn').val(show_close_btn_val);	
											}																		
										</script>
									<?php 
										$display_close_btn = FALSE;
									}	?>
																
																
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group lesson">
                                    <textarea name="lessons_material_and_tasks_3"  id="lessons_material_and_tasks_3" class="form-control ac-st-lesson-task compare-tasks"><?php echo str_replace('<br>', '', $lmt3); ?></textarea>
									<?php if(trim($lmt3) != '' && trim($homework_lessons_material_and_tasks_3) == '' && (trim($lmt3) !=  trim($homework_lessons_material_and_tasks_3))){ ?>
										<button class="lessn_btn cpy_lessons_tasks lmdiv"  data-attr="3" data-copy_to="homework_lessons_material_and_tasks_3" id="cpy_lessons_material_and_tasks_3"><i class="fas fa-angle-down"></i></button>
										<script type="text/javascript" language="javascript">
											var show_close_btn_val = jQuery('#show_close_btn').val();
											if(show_close_btn_val == '') {
												jQuery('#show_close_btn').val('lessons_material_and_tasks_3');	
											} else {
												show_close_btn_val = show_close_btn_val +',lessons_material_and_tasks_3';
												jQuery('#show_close_btn').val(show_close_btn_val);	
											}																		
										</script>
									<?php 
										$display_close_btn = FALSE;
									}	?>
																
																
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="lesson_inner">
                        <h4 class="les_title">Lesson Tasks ・課題</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group lesson">
                                    <textarea name="lessons_tasks_1"  id="lessons_tasks_1" class="form-control ac-st-lesson-task"><?= !empty($tasks['lessons_tasks_1']) && ucfirst($tasks['lessons_tasks_1']) != 'Default Text' ? str_replace('<br>', '', $tasks['lessons_tasks_1']) : '① 英語は、何度も使うことで身についていきます。今回学んだ内容を積極的に使うよう意識してみてください。
② 英語から日本語に翻訳するのではなく、英語のままインプットし、英語でアウトプットする練習をしましょう。
③ テキストを見ずに、センテンスを声に出して言ってみましょう。すらすら言えるようになるまで繰り返し練習してください。  
何かを習得する最大のコツは、良い習慣を身につけることです。
[Please do not delete. Default.]' ?></textarea>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group lesson">
                                    <textarea name="lessons_tasks_2" id="lessons_tasks_2" class="form-control ac-st-lesson-task compare-tasks"><?php echo str_replace('<br>', '', $lt2); ?></textarea>
									<?php 
									if(trim($lt2) != '' && trim($next_lessons_tasks_2) == ''){ ?>
											<button class="lessn_btn cpy_lessons_tasks ltdiv" data-attr="2" data-copy_to="next_lessons_tasks_2"  id="cpy_lessons_tasks_2"><i class="fas fa-angle-down"></i></button>
											<script type="text/javascript" language="javascript">
												var show_close_btn_val = jQuery('#show_close_btn').val();
												if(show_close_btn_val == '') {
													jQuery('#show_close_btn').val('lessons_tasks_2');	
												} else {
													show_close_btn_val = show_close_btn_val +',lessons_tasks_2';
													jQuery('#show_close_btn').val(show_close_btn_val);	
												}																		
											</script>
										<?php 
											$display_close_btn = FALSE;
									}	?> 
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group lesson">
                                    <textarea name="lessons_tasks_3" id="lessons_tasks_3" class="form-control ac-st-lesson-task compare-tasks"><?php echo str_replace('<br>', '', $lt3); ?></textarea>
									<?php 
									if(trim($lt3) != '' && trim($next_lessons_tasks_3) == ''){ ?>
											<button class="lessn_btn cpy_lessons_tasks ltdiv" data-attr="3" data-copy_to="next_lessons_tasks_3" id="cpy_lessons_tasks_3"><i class="fas fa-angle-down"></i></button>
											<script type="text/javascript" language="javascript">
												var show_close_btn_val = jQuery('#show_close_btn').val();
												if(show_close_btn_val == '') {
													jQuery('#show_close_btn').val('lessons_tasks_3');	
												} else {
													show_close_btn_val = show_close_btn_val +',lessons_tasks_3';
													jQuery('#show_close_btn').val(show_close_btn_val);	
												}																		
											</script>
										<?php 
											$display_close_btn = FALSE;
									}	?>
																
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="lesson_inner">
                        <h4 class="les_title orange">
                            Homework Lesson Materials and Tasks ・自習課題
                        </h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="homework_lessons_material_and_tasks_1" id="homework_lessons_material_and_tasks_1" class="form-control ac-st-lesson-task"><?= !empty($tasks['homework_lessons_material_and_tasks_1']) ? str_replace('<br>', '', $tasks['homework_lessons_material_and_tasks_1']) : '① Use what we have learnt frequently to remember easily through habit.  
② Avoid translating from English to Japanese. Practice English input and English output. 
③ Without reading, practice saying and acting out your sentences aloud several times for fluency.  
The basic principle for any learning is to create a good habit.
[Please do not delete. Default.]' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="homework_lessons_material_and_tasks_2" id="homework_lessons_material_and_tasks_2" class="form-control ac-st-lesson-task compare-tasks"><?= !empty($tasks['homework_lessons_material_and_tasks_2']) ? str_replace('<br>', '', $tasks['homework_lessons_material_and_tasks_2']) : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="homework_lessons_material_and_tasks_3" id="homework_lessons_material_and_tasks_3" class="form-control ac-st-lesson-task compare-tasks"><?= !empty($tasks['homework_lessons_material_and_tasks_3']) ? str_replace('<br>', '', $tasks['homework_lessons_material_and_tasks_3']) : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="lesson_inner">
                        <h4 class="les_title orange">
                            Next Lesson Tasks ・次回のレッスン課題
                        </h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="next_lessons_tasks_1" id="next_lessons_tasks_1" class="form-control ac-st-lesson-task"><?= !empty($tasks['next_lessons_tasks_1']) ? str_replace('<br>', '', $tasks['next_lessons_tasks_1']) : '① 英語は、何度も使うことで身についていきます。今回学んだ内容を積極的に使うよう意識してみてください。
② 英語から日本語に翻訳するのではなく、英語のままインプットし、英語でアウトプットする練習をしましょう。
③ テキストを見ずに、センテンスを声に出して言ってみましょう。すらすら言えるようになるまで繰り返し練習してください。  
何かを習得する最大のコツは、良い習慣を身につけることです。
[Please do not delete. Default.]' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="next_lessons_tasks_2"  id="next_lessons_tasks_2" class="form-control ac-st-lesson-task compare-tasks"><?= !empty($tasks['next_lessons_tasks_2']) ? str_replace('<br>', '', $tasks['next_lessons_tasks_2']) : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="next_lessons_tasks_3" id="next_lessons_tasks_3" class="form-control ac-st-lesson-task compare-tasks"><?= !empty($tasks['next_lessons_tasks_3']) ? str_replace('<br>', '', $tasks['next_lessons_tasks_3']) : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
		/*.modal-header .close{
			display:none;
		}*/
		.cpy_lessons_taskss{
			display:none;
		}
		</style>
		
<?php
if($display_close_btn == TRUE){ ?>
	<script type="text/javascript" language="javascript">
		$('.close').show();															
	</script>
<?php } else { ?>
	<script type="text/javascript" language="javascript">
		$('.close').hide();															
	</script>
<?php } ?>