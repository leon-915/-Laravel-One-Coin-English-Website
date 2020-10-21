@extends('layouts.app',['title'=>'Teacher Registration Step 2'])
@section('title', 'Teacher Registration Step 2')

@section('content')
    <section class="techregister_two register_sec">
		<div class="container">
			<div class="row">
				<div class="col-md-8 m-auto">
					<div class="register_inner">
                        <div>
                            <h4 class="text-center" style="color: red;line-height: 50px;vertical-align: middle;">You have already submitted stage 2 form and can not resubmit now.</h4>
                        </div>
                        {{--  --}}
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
