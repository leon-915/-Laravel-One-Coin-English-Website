@extends('layouts.app',['title'=> __('labels.student_dashboard')])
@section('title', __('labels.student_dashboard'))
@section('content')
    
	<div class="" id="teacherlist">

	</div>
	
	
@push('scripts')
	
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
		
		function getTeacherList() {
			var action = "<?php echo route('students.getOnlineTeachers.index')?>";
			$.ajax({
				url : action,
				dataType: 'JSON',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				beforeSend: function () {
				   //$('.app-loader').removeClass('d-none');
				},
				success: function (result) {
					//$('.app-loader').addClass('d-none');

					if (result.type == 'success') {

						//$('.app-loader').addClass('d-none');
						$('#teacherlist').html(result.html);

					} else {
					
					}
				}, 
				error :function(result){
										
				}
			});
		}
	
		$(document).ready(function () {
			getTeacherList();
			// var myVar = setInterval(getTeacherList, 30000);				
		});
		
		function clear_Interval() {
			clearInterval();
		}
		
		function make_teacher_fav(teacher_id){
			$('#teacher_id').val('');
			$('#time').val('');
			$('#payment-form').addClass('d-none'); 
			var starData = {
				teacher_id: teacher_id,
			}
			
			$.ajax({
				url: '{{route('student.favoritelp')}}',
				type: "POST",
				data: starData,
				cache: false,
				headers: {
					'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(){
					$('.app-loader').removeClass('d-none');
				},
				success : function(res){
					// localtion.reload();
					$('.app-loader').addClass('d-none');
					if(res.type == 'success'){
						setTimeout(function(){// wait for 5 secs(2)
							//location.reload(); // then reload the page.(3)
							getTeacherList();
						}, 1000);
						$.toast({
							heading: 'Success',
							text: res.message,
							position: 'top-right',
							icon: 'success'
						});
					}
				}
			});
		}
		
		function make_teacher_un_fav(teacher_id){
			$('#teacher_id').val('');
			$('#time').val('');
			$('#payment-form').addClass('d-none'); 
			
			var starData = {
				teacher_id: teacher_id,
			}
			
			$.ajax({
				url: '{{route('student.unfavoritelp')}}',
				type: "POST",
				data: starData,
				cache: false,
				headers: {
					'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(){
					$('.app-loader').removeClass('d-none');
				},
				success : function(res){
					// localtion.reload();
					$('.app-loader').addClass('d-none');
					if(res.type == 'success'){
						setTimeout(function(){// wait for 5 secs(2)
							//location.reload(); // then reload the page.(3)
							getTeacherList();
						}, 1000);
						$.toast({
							heading: 'Success',
							text: res.message,
							position: 'top-right',
							icon: 'success'
						});
					}
				}
			});
		}
		
		function checkTeacherAvailability(teacher_id){
			var data = {
				teacher_id: teacher_id,
			}
			
			$.ajax({
				url: '{{route('student.teacheravailability')}}',
				type: "POST",
				data: data,
				cache: false,
				headers: {
					'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(){
					$('.app-loader').removeClass('d-none');
				},
				success : function(res){
					// localtion.reload();
					$('.app-loader').addClass('d-none');
					if(res.type == 'success' && res.is_available == true){
						$('#teacher_id').val(teacher_id);
						$('#time').val(res.time);
						if(res.balance > 0) {
							$('#booking-form').removeClass('d-none'); 
						} else {
							$('#payment-form').removeClass('d-none');   
						}							
					} else {
						$.toast({
							heading: 'Error',
							text: 'This teacher is unavailable right now. Please choose other one.',
							icon: 'error',
							position: 'top-right'
						})
					}
				}
			});
		}
	</script>


@endpush

@endsection
