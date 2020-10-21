<nav class="main-nav d-none d-lg-block">
	<button type="button" class="mobile-nav-toggle d-lg-none"><a class="fa-bars-more">More</a><i class="fa fa-times"></i></button>
	<ul>				  		
		<li class="{{ request()->is('casual_conversation') ? 'active' : '' }}"><a href="{{ url('casual_conversation') }}">{{__('casual_conversation.customised_courses')}}</a></li>	
		<li class="{{ request()->is('onepage_canvas') ? 'active' : '' }}"><a href="{{ url('onepage_canvas') }}">{{__('casual_conversation.onepage_canvas')}}</a></li>	
		<li class="{{ request()->is('lesson_anywhere') ? 'active' : '' }}"><a href="{{ url('lesson_anywhere') }}">{{__('casual_conversation.lesson_anywhere')}}</a></li>	
		<li class="{{ request()->is('language_partners') ? 'active' : '' }}"><a href="{{ url('language_partners') }}">{{__('casual_conversation.language_partners')}}</a></li>	
		<li class="{{ request()->is('pricing') ? 'active' : '' }}"><a href="{{ url('pricing') }}">{{__('casual_conversation.pricing')}}</a></li>	
		<li class="{{ request()->is('testimonials') ? 'active' : '' }}"><a href="{{ url('testimonials') }}">{{__('casual_conversation.testimonials')}}</a></li>	
	</ul>
</nav>

@push('scripts')
<script>	
	$('.mobile-nav-toggle').click(function(){
		
		if($(this).parents('nav[class^="main-nav"]').eq(0).hasClass('open', 1000)){
			$('.main-nav').removeClass('open', 1000).css('width', '');
		}else {
			$('.main-nav').removeClass('open', 1000).css('width', '');
			$(this).parents('nav[class^="main-nav"]').eq(0).addClass('open', 1000);
		}
	});	
</script>
@endpush


