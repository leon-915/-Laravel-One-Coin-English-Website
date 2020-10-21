@extends('layouts.app',['title'=> __('labels.products')])
@section('title', __('labels.products'))
@section('content')

<section class="profile_sec my_card">
    <div class="container">
        <div class="my_card_sec">
            <div class="row">
                <div class="col-12">
                    <div class="card_title">
                        <h3>
						@if($category_id == 1)
							{{__('labels.aspire_coaching_pricing')}}
						@elseif($category_id == 2)
							{{__('labels.casual_conversation_pricing')}}
						@else
							{{__('labels.accent_kids_pricing')}}	
						@endif
						</h3>
                        @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            {{ $error }} </div>
                        @endforeach
                        @endif </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                    <ul class="products-page">
						@if(!empty($products))
							@foreach($products as $product)
								<li class="product"> 
									<h3>
									@if(App::isLocale('en'))
										{{ $product->service_name_en }}
									@else
										{{ $product->title }}
									@endif
									</h3>
									<span class="price"> 
										<span class="amount">
											¥<?php echo number_format($product->price / $product->available_lessons)?>
										</span><br/>
										<span class="one-lesson-price">({{ __('labels.1_lesson_price') }} )</span>
									</span> 
									<span>
									<p>{{ __('labels.course_price') }}<br>
										¥<?php 
										echo number_format((int) $product->price); ?> {{ __('labels.ex_tax') }}<br>
										・{{ $product->available_lessons }} {{ __('labels.lessons') }}<br>
										・{{ $product->no_of_days }} {{ __('labels.day_term') }}</p>
									</span> <a href="<?php echo url('student/add-cart/' . $product->id)?>" class="add_to_cart_button">{{ __('labels.purchase') }}</a> 
								</li>							
							@endforeach
						@endif
                        <!--li class="product"> 
                            <h3>60 Min 1 Lesson 7 Days</h3>
                            <span class="price"> <span class="amount">¥20,000</span><br/><span class="one-lesson-price">(1 Lesson Price)</span> </span> 
                            <span>
                            <p>Course Price<br>
                                ¥20,000 (ex. tax)<br>
                                ・1 lessons<br>
                                ・7-day term</p>
                            </span> <a href="#" class="add_to_cart_button">Purchase</a> 
                        </li>
                        <li class="product"> 
                            <h3>60 Min 1 Lesson 7 Days</h3>
                            <span class="price"> <span class="amount">¥20,000</span><br/><span class="one-lesson-price">(1 Lesson Price)</span> </span> 
                            <span>
                            <p>Course Price<br>
                                ¥20,000 (ex. tax)<br>
                                ・1 lessons<br>
                                ・7-day term</p>
                            </span> <a href="#" class="add_to_cart_button">Purchase</a> 
                        </li>
                        <li class="product"> 
                            <h3>60 Min 1 Lesson 7 Days</h3>
                            <span class="price"> <span class="amount">¥20,000</span><br/><span class="one-lesson-price">(1 Lesson Price)</span> </span> 
                            <span>
                            <p>Course Price<br>
                                ¥20,000 (ex. tax)<br>
                                ・1 lessons<br>
                                ・7-day term</p>
                            </span> <a href="#" class="add_to_cart_button">Purchase</a> 
                        </li>
                        <li class="product"> 
                            <h3>60 Min 1 Lesson 7 Days</h3>
                            <span class="price"> <span class="amount">¥20,000</span><br/><span class="one-lesson-price">(1 Lesson Price)</span> </span> 
                            <span>
                            <p>Course Price<br>
                                ¥20,000 (ex. tax)<br>
                                ・1 lessons<br>
                                ・7-day term</p>
                            </span> <a href="#" class="add_to_cart_button">Purchase</a> 
                        </li-->
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
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

    @endpush
<style>

        .cart_bottom_btn .btn_custon {
           
        }

    </style>
@endsection 