<nav class="main-nav d-none d-lg-block">
	<ul>				  		
		<li><a href="{{ url('') }}">{{__('casual_conversation.home')}}</a></li>	
		<li class="{{ request()->is('casual_conversation') ? 'active' : '' }}"><a href="{{ url('casual_conversation') }}">{{__('casual_conversation.casual_conversation')}}</a></li>	
		<li class="{{ request()->is('aspire_coaching') ? 'active' : '' }}"><a href="{{ url('aspire_coaching') }}">{{__('casual_conversation.aspire_coachiing')}}</a></li>	
		<li class="{{ request()->is('kids') ? 'active' : '' }}"><a href="{{ url('kids') }}">{{__('casual_conversation.kids')}}</a></li>	
	</ul>
</nav>