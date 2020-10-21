@extends('layouts.app',['title'=>'Teacher Profile'])
@section('title', 'Teacher Profile')

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile_inner">
                        <!--div class="row">
                            <div class="heading col-12">
                                <h3>{{ __('Profile') }}</h3>
                            </div>
                        </div-->

                        <div class="row">
                            @if(Session::has('message'))
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">
                                        <strong>{{ Session::get('message') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if (count($errors) > 0)
                                <div class="col-12">
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="profile_form pro_information row">
                            @include('teachers.profile.index.newpersonal-info')
                        </div>

                        <!--div class="profile_form sent_referral">
                            {!! Form::open(array('route' => 'teachers.profile.refer.earn.reward','id'=>'refer_earn_reward','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
                            @include('teachers.profile.index.refer_and_earn')
                            {!! Form::close() !!}
                        </div-->

                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter : 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif
        <script>
            $('#refer_earn_reward').validate({
                ignore: "",
                rules: {
                    email: {
                        required: true,
                    },

                },
                messages: {
                    email: {
                        required: "Please enter email"
                    },
                }
            });
        </script>

        <script>

            let emailExistUrl = '{{ route('teachers.register.email.exist') }}';
            let schHtml = <?= json_encode(View::make('teachers.register.schedule.single')->render()) ?>;
            let Url = '{{ route('teachers.profile.info.save') }}';

        </script>
		<script type="text/javascript">
			var setLineNotificationFlag = '{{ route('setLineNotificationFlag') }}';
			$(document).ready(function(){
				var redirectUrl = '<?= route('teachers.profile.index') ?>';

				$('#disable_lineNotification').on('click',function(){
					let user_id = $(this).val(),
					csrfToken = $('meta[name="csrf-token"]').attr('content');
					$.ajax({
						url: setLineNotificationFlag,
						type: 'POST',
						data: { user_id : user_id, data_to_update : 0 },
						headers: {
							'X-CSRF-Token': csrfToken
						},
						beforeSend:function(){
							$('.app-loader').removeClass('d-none');
						},
						success: function (result) {
							$('.app-loader').addClass('d-none');
							//$('#qrModal').modal('hide');
							$.toast({
								heading: 'Success',
								text: "Line notification status saved successfully",
								icon: 'success',
								position: 'top-right',
								afterHidden: function () {
									window.location.href = redirectUrl;
								}
							})
						}
					});
				});
				
				$('#audio, #video').on('click',function(){
					csrfToken = $('meta[name="csrf-token"]').attr('content');
					var media = $(this).attr('id');
					$.ajax({
						url: '<?php echo route('teachers.delete.media');?>',
						type: 'POST',
						data: { media : media },
						headers: {
							'X-CSRF-Token': csrfToken
						},
						beforeSend:function(){
							$('.app-loader').removeClass('d-none');
						},
						success: function (result) {
							$('.app-loader').addClass('d-none');
							if (result.type == 'success') {
								$.toast({
									heading: 'Success',
									text: result.message,
									icon: 'success',
									position: 'top-right',
									afterHidden: function () {
										if(media == 'video'){
											$('.video_desc').html('');
										}
										
										if(media == 'audio'){
											$('.audio_desc').html('');
										}
									}
								})
							}
						}
					});
				});
				
			});
			
			/*$(document).ready(function(){
				console.log($('input[name=japanese_resident]').val());
				if($('input[name=japanese_resident]:checked').val() == '1') {
					$('#address_line_div').removeClass('d-none');
				}
			});*/
		</script>
        <script src="{{ asset('js/teacher/profile.js') }}"></script>
    @endpush
@endsection
