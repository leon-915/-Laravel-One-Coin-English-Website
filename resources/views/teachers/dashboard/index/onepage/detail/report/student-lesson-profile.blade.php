<div class="card-header" id="heading-8">
    <h5 class="mb-0">
        <a class="collapsed" role="button" data-toggle="collapse"
            href="#collapse-8" aria-expanded="false"
            aria-controls="collapse-8">
            Profile ・ プロフィール
        </a>
    </h5>
</div>

<div id="collapse-8" class="collapse" data-parent="#accordion"
    aria-labelledby="heading-8">
    <div class="card-body">
        <div class="point_to_improve profile">
            <div class="row">
                <div class="col-12">
                    <div class="select cust">
                        <select name="student_lesson_level" id="student_lesson_level" data-lesson-id="{{$studentLesson->id}}" data-user-id="{{$studentLesson->user_id}}"  data-booking-id="{{$booking->id}}">
                            @foreach ($levels as $key => $level)
                                <option value="{{$level->id}}"
                                {{ (!empty($student->student_level_id) && ($level->id == $student->student_level_id)) ? 'selected' : '' }}>{{$level->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="student-lesson-profile-detail">
                        @include('teachers.dashboard.index.onepage.detail.report.student-lesson-profile.detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('change','#student_lesson_level',function(e){
        e.preventDefault();
        let level = $(this).val();
        let lesson = $(this).data('lesson-id');
        let user_id = $(this).data('user-id');
        let booking_id = $(this).data('booking-id');
        $.ajax({
            data : {
                'student_level_id' : level,
                'id' : lesson,
                'user_id' : user_id,
                'booking_id' : booking_id,
            },
            url : '{{ route('teachers.dashboard.onepage.updatelevel') }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type : 'POST',
            dataType : 'JSON',
            beforeSend : function(){
                $('#student-lesson-profile-detail').html('');
                $('.app-loader').removeClass('d-none');
            },
            success : function (res) {
                if(res.type == 'success'){
					window.location = "{{ route('teachers.dashboard.index') }}?ref=canvas"
                    /*$('.app-loader').addClass('d-none');
                    $('#student-lesson-profile-detail').html(res.html);
                    $('#student-sessoin-point-to-improve-detail').html(res.phtml);*/
                }
            }
        })
    });
</script>
