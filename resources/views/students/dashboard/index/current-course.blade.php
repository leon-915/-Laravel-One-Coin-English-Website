
@if ($package)
    @include('students.dashboard.index.current-course.packages')
@endif

@include('students.dashboard.index.current-course.lessons')

<div class="modal fade modal-danger show" id="exampleModalPrimary" tabindex="-1" role="dialog" aria-labelledby="exampleModalPrimary" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">{{__('labels.dash_model_delete')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{__('labels.dash_model_are_you_sure')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gradient-primary btn-rounded btn-fw yes_delete">{{__('labels.dash_model_submit')}}</button>
                <button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" data-dismiss="modal">{{__('labels.dash_model_cancel')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click','a.page-link', function(e){
        e.preventDefault();
        var pUrl = $(this).attr('href');
        var service_id = $(this).parent('li').parent('ul').parent('div.current-course-pagination').data('service');
        var lesson_id = $(this).parent('li').parent('ul').parent('div.current-course-pagination').data('lesson_id');
        var package_id = $(this).parent('li').parent('ul').parent('div.current-course-pagination').data('package_id');

        if(package_id){
            $.ajax({
                url : pUrl,
                data: {
                    'package_id' : package_id,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    $('.app-loader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.type == 'success') {
                        $('.app-loader').addClass('d-none');
                        $('#current-package-booking-container-'+package_id).html(res.html);
                    }
                }
            });
        } else {
            $.ajax({
                url : pUrl,
                data: {
                    'service_id' : service_id,
                    'lesson_id'  : lesson_id,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    $('.app-loader').removeClass('d-none');
                },
                success: function (res) {
                    if (res.type == 'success') {
                        $('.app-loader').addClass('d-none');
                        $('#current-booking-container-'+lesson_id).html(res.html);
                    }
                }
            });
        }

    });
</script>


