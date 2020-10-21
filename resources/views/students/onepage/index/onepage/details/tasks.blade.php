<?php $tasks = !empty($studentLesson->tasks) ? $studentLesson->tasks->toArray() : []; ?>
<div class="card">
    <div class="card-header" id="heading-5">
        <h5 class="mb-0">
            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5"
                aria-expanded="false" aria-controls="collapse-5">
                Homework Lesson Materials and Tasks 自習課題
            </a>
        </h5>
    </div>
    <div id="collapse-5" class="collapse" data-parent="#accordion" aria-labelledby="heading-5">
        <div class="card-body">
            <div class="improve_point marg">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="steelblue">Lesson Materials and Tasks・教材 </h4>
                        @if (!empty($tasks['lessons_material_and_tasks_1']))
                            <div class="point_text">
                                <p>1) <?= nl2br($tasks['lessons_material_and_tasks_1']) ?></p>
                            </div>
                        @endif

                        @if (!empty($tasks['lessons_material_and_tasks_2']))
                            <div class="point_text">
                                <p>2) <?= nl2br($tasks['lessons_material_and_tasks_2'])?></p>
                            </div>
                        @endif

                        @if (!empty($tasks['lessons_material_and_tasks_3']))
                            <div class="point_text">
                                <p>3) <?= nl2br($tasks['lessons_material_and_tasks_3']) ?></p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <h4 class="steelblue">Lesson Tasks・課題 </h4>
                        @if (!empty($tasks['lessons_tasks_1']))
                            <div class="point_text"><p>1) <?= nl2br($tasks['lessons_tasks_1']) ?></p></div>
                        @endif
                        @if (!empty($tasks['lessons_tasks_2']))
                            <div class="point_text"><p>2) <?= nl2br($tasks['lessons_tasks_2']) ?></p></div>
                        @endif
                        @if (!empty($tasks['lessons_tasks_3']))
                            <div class="point_text"><p>3) <?= nl2br($tasks['lessons_tasks_3']) ?></p></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="improve_point marg">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="red">Homework Lesson Materials and Tasks・ 自習課題 </h4>
                        @if (!empty($tasks['homework_lessons_material_and_tasks_1']))
                            <div class="point_text">
                                <p>1) <?= nl2br($tasks['homework_lessons_material_and_tasks_1']) ?></p>
                            </div>
                        @endif
                        @if (!empty($tasks['homework_lessons_material_and_tasks_2']))
                            <div class="point_text">
                                <p>2) <?= nl2br($tasks['homework_lessons_material_and_tasks_2'])?></p>
                            </div>
                        @endif
                        @if (!empty($tasks['homework_lessons_material_and_tasks_3']))
                            <div class="point_text">
                                <p>3) <?= nl2br($tasks['homework_lessons_material_and_tasks_3']) ?></p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <h4 class="red">Next Lesson Tasks ・次回のレッスン課題</h4>
                        @if (!empty($tasks['next_lessons_tasks_1']))
                            <div class="point_text">
                                <p>1) <?= nl2br($tasks['next_lessons_tasks_1']) ?></p>
                            </div>
                        @endif
                        @if (!empty($tasks['next_lessons_tasks_2']))
                            <div class="point_text">
                                <p>2) <?= nl2br($tasks['next_lessons_tasks_2']) ?></p>
                            </div>
                        @endif
                        @if (!empty($tasks['next_lessons_tasks_3']))
                            <div class="point_text">
                                <p>3) <?= nl2br($tasks['next_lessons_tasks_3']) ?></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
