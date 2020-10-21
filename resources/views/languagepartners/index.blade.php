@extends('layouts.app',['title'=> __('labels.student_dashboard')])
@section('title', __('labels.student_dashboard'))
@section('content')
    
<div class="" id="teacherlist">
	<style>
		#teacherlist .container {
			max-width: 800px !important;
		}
			
		@media (max-width: 991px) {
			.container {
				max-width: 100%;
			}
		}
	</style>

	<div class="container">
		<div class="top">
			<div class="row">
				<div class="col-6 left">
					<img src="{{ asset('images/list_lp/FilterIcon.png') }}" class="setting">
				</div>

				<div class="col-6 align-right right">
					<span>View</span>
					<div class="nav-wrapper">
						<div class="dropdown">
							<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<label>05</label>
								<img src="{{ asset('images/list_lp/DownOn.png') }}">
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="#">05</a>
								<a class="dropdown-item" href="#">10</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="list-content">
			<div id="available_teacherlist">

			</div>
		</div>
	</div>
</div>
							
							<div class="tab-content d-none" id="payment-form">
								<input id="cardholder-name" type="text">
								<!-- placeholder for Elements -->
								<form id="payment-form">
								
								  <div id="card-element">
									<!-- Elements will create input elements here -->
								  </div>

								  <!-- We'll put the error messages in this element -->
								  <div id="card-errors" role="alert"></div>

								  <input type="hidden" id="teacher_id" name="teacher_id" value="" />
								  <input type="hidden" id="time" name="time" value="" />
								  <button id="submit">Pay</button>
								  <div>I authorise <?php echo env('APP_NAME');?> to send instructions to the financial institution that issued my card to take payments from my card account in accordance with the terms of my agreement with you.</div>
								</form>	
								
							</div>
							
							<div class="tab-content d-none" id="booking-form">
								
								<!-- placeholder for Elements -->
								
								
								  <button id="submit_book">Book a session</button>
								  
								
								
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
				var action = "<?php echo route('students.getAvailableTeachers.index')?>";
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
							$('#available_teacherlist').html(result.html);

						} else {
						
						}
					}, 
					error :function(result){
											
					}
				});
			}
		
			$(document).ready(function () {
				getTeacherList();
				var myVar = setInterval(getTeacherList, 30000);				
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
		
		<?php
			$test_Publishable_key = config('services.stripe.test_Publishable_key');
			$createcustomerurl = route('students.createCustomer.index');
			$bookSession = route('students.bookSession.index');
			$redirectUrl = route('students.session.index');
			$customeremail = $user_email;
			$customername = $user_firstname;
		?>	
		<script type="text/javascript">
			var stripe = Stripe('<?php echo $test_Publishable_key;?>');
			var clientSecret = '<?php echo $client_secret;?>';
			var elements = stripe.elements();

			// Set up Stripe.js and Elements to use in checkout form
			var style = {
			  base: {
				color: "#32325d",
			  }
			};

			
			var card = elements.create("card", { style: style });
			card.mount("#card-element");
			
			card.addEventListener('change', ({error}) => {
			  const displayError = document.getElementById('card-errors');
			  if (error) {
				displayError.textContent = error.message;
			  } else {
				displayError.textContent = '';
			  }
			});
			
			var cardholderName = document.getElementById('cardholder-name');
			//var cardholderEmail = '<?php echo $customeremail;?>';
			var form = document.getElementById('payment-form');
			var action = '<?php echo $createcustomerurl;?>';
			form.addEventListener('submit', function(ev) {
				$('.app-loader').removeClass('d-none');
			  ev.preventDefault();
			  stripe.confirmCardPayment(clientSecret, {
				payment_method: {
				  card: card,
				  billing_details: {
					name: cardholderName.value,
					/*address: {
						line1: 'Ebishu',
						city: 'Tokyo',
						state: 'Tokyo',
						country:'JP',
					},*/
				  }
				}
			  }).then(function(result) {
				if (result.error) {
				  // Show error to your customer (e.g., insufficient funds)
				  $.toast({
						heading: 'Error',
						text: result.error.message,
						icon: 'error',
						position: 'top-right',
						afterHidden: function () {
							location.reload();
						}
					})
				  console.log(result.error.message);
				} else {
				  // The payment has been processed!
				  if (result.paymentIntent.status === 'succeeded') {
						//$('.app-loader').addClass('d-none');
						console.log('Payment done'+result.paymentIntent.payment_method);
						createCustomer(result.paymentIntent.payment_method);
					// Show a success message to your customer
					//pm_1GAsPgEUXgAQv9ra8y2GpDVi
					// There's a risk of the customer closing the window before callback
					// execution. Set up a webhook or plugin to listen for the
					// payment_intent.succeeded event that handles any business critical
					// post-payment actions.
				  }
				}
			  });
			});
			
			

		function createCustomer(payment_method) {
			var cardholderName = '<?php echo $customername;?>';
			var cardholderEmail = '<?php echo $customeremail;?>';
			var action = '<?php echo $createcustomerurl;?>';
			var teacher_id = $('#teacher_id').val();
			var time = $('#time').val();
			$.ajax({
				url : action,
				data : {
					payment_method: payment_method,
					name: cardholderName,
					email: cardholderEmail,
					teacher_id: teacher_id,
					time: time,
				},
				dataType: 'JSON',
				type: 'POST',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				beforeSend: function () {
				   //$('.app-loader').removeClass('d-none');
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
								window.location.href = '<?php echo $redirectUrl;?>';
							}
						});

					} else {
						$.toast({
							heading: 'Error',
							text: result.message,
							icon: 'error',
							position: 'top-right',
							afterHidden: function () {
								location.reload();
							}
						})
					}
				}, error :function(res){
					$('.app-loader').addClass('d-none');
					$.each(res.responseJSON.errors,function(key, value){
						$.toast({
							heading: 'Error',
							text: value,
							icon: 'error',
							position: 'top-right',
							afterHidden: function () {
								location.reload();
							}
						})
					});
				}
			});
		}
		
		$('#submit_book').click(function() {
			var teacher_id = $('#teacher_id').val();
			var time = $('#time').val();
			var action = '<?php echo $bookSession;?>';
			$.ajax({
				url : action,
				data : {
					teacher_id: teacher_id,
					time: time,
				},
				dataType: 'JSON',
				type: 'POST',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				beforeSend: function () {
				   //$('.app-loader').removeClass('d-none');
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
								window.location.href = '<?php echo $redirectUrl;?>';
							}
						});

					} else {
						$.toast({
							heading: 'Error',
							text: result.message,
							icon: 'error',
							position: 'top-right',
							afterHidden: function () {
								location.reload();
							}
						})
					}
				}, error :function(res){
					$('.app-loader').addClass('d-none');
					$.each(res.responseJSON.errors,function(key, value){
						$.toast({
							heading: 'Error',
							text: value,
							icon: 'error',
							position: 'top-right',
							afterHidden: function () {
								location.reload();
							}
						})
					});
				}
			});
			
			
		});
		
		</script>

@endpush

@endsection
