<?php
    $tasks = !empty($booking->tasks) ? $booking->tasks->toArray() : [];
?>
<div class="card-header" id="heading-3">
    <h5 class="mb-0">
        <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false"
            aria-controls="collapse-3">
            Lesson Materials and Tasks ・教材
        </a>
    </h5>
</div>
<div id="collapse-3" class="collapse" data-parent="#accordion" aria-labelledby="heading-3">
    <div class="card-body">
        @include('teachers.dashboard.index.onepage.detail.report.lesson-task-form')
    </div>
</div>

<div class="modal" id="lesson-task-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="open_update_rating_popup();"><i class="fas fa-times"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<style>
.form-group.lesson .lessn_btn {
    top: -35px;
    /* bottom: 35px; */
}
</style>


<script>
    $(document).on('click', '.cpy_lessons_tasks', function(e){
        e.preventDefault();
        let id = $(this).attr('id').replace('cpy_','');
        let cpy_to = $(this).data('copy_to');
        $(this).addClass('grey-bg');
        let taskVal = $('#'+id).val();
        $('textarea#'+cpy_to).text(taskVal);
    });

    $(document).ready(function () {
        @if($booking->status=='booked')
            $('#alert-message-5').modal('show');
            $('#lesson-task-modal').modal('show');
			$(".lesson_materials_task").appendTo("#lesson-task-modal .modal-body");
        @endif

        $('#alert-message-5').on('hidden.bs.modal', function (e) {
            if($("#lesson-task-modal").hasClass('show')){
                $('body').addClass('modal-open');
            } else {
                $('body').removeClass('modal-open');
				
            }
        });
		var taskTimer = setInterval(function(){
			console.log('task-timer');
			if(!$("#lesson-task-modal").hasClass('show')){
                $(".lesson_materials_task").appendTo("#collapse-3 .card-body");
				clearInterval(taskTimer);
            }
    		
		}, 1000);
		
    });
</script>
<script>
$('#alert-message-5').modal({backdrop: 'static', keyboard: false}) 
$('#lesson-task-modal').modal({backdrop: 'static', keyboard: false}) 
</script>
