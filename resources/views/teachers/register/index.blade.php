@extends('layouts.app',['title'=>'Teacher Registration'])
@section('title', 'Teacher Registration')

@section('content')
    <section class="register_sec">
		<div class="container">
			<div class="row">
				<div class="col-md-8 m-auto">
					<div class="register_inner">
					    <h3>Teacher Recruitment Form</h3>
                        
                        <div class="form-group">
                            @php
                                $errs = $errors->all();
                            @endphp
                            @if($errs)
                                @foreach ($errs as $key=>$err)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $err }}</strong>
                                </div>
                                @endforeach
                            @endif
						</div>
						@if(Session::has('message'))
							<div class="form-group">                            
									<div class="alert alert-success" role="alert">
										<strong><?php echo Session::get('message'); ?></strong>
									</div>                            
							</div>
						@else	
							<p>* Denotes required fields</p>
							{!! Form::open(array('route' => 'teachers.register.store','class'=>'form_field', 'id'=>'teacher-register','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
							
								<!--div class="form-group">
									<label>{{ __('labels.first_name')}}<span>*</span></label>
									<input type="text" name="firstname" class="form-control" required="">
								</div>
								<div class="form-group">
									<label>{{ __('labels.last_name')}}<span>*</span></label>
									<input type="text" name="lastname" class="form-control" required="">
								</div-->

								<div class="form-group">
									<label>{{ __('labels.email')}}<span>*</span></label>
									<input type="email" name="email" id="email" class="form-control" required="">
								</div>
								

								<div class="submit_register clear-fix">
									<label class="checkcontainer">
										Please accept our <a href="{{ url('terms-of-use') }}">Terms of Use</a> &
										<a href="{{ url('privacy-policy') }}">Privacy Policy</a>
										<input type="checkbox" name="check_terms" required>
										<span class="checkmark"></span>
									</label>
								</div>
								
								<div class="submit_btn">
									<button type="submit" value="Submit" class="btn_sub btnsub_arr">Submit</button>
								</div>
							
							{!! Form::close() !!}
						@endif
				    </div>
				</div>
			</div>
		</div>
        <style>
            /*.cr-slider {
                -webkit-appearance: none !important;
                width: 300px !important;
                max-width: 100% !important;
                padding-top: 8px !important;
                padding-bottom: 8px !important;
                background-color: transparent !important;
            }*/

            input[type="range"] {
              display: block;
              -webkit-appearance: none;
              background-color: #f5f5f5;
              width: 100%;
              height: 5px;
              border-radius: 5px;
              margin: 0 auto;
              outline: 0;
            }
            .cr-slider::-webkit-slider-thumb {
              -webkit-appearance: none;
              background-color: #043a6b;
              width: 25px;
              height: 25px;
              border-radius: 50%;
              border: 2px solid white;
              cursor: pointer;
              transition: .3s ease-in-out;
            }
            .cr-slider::-webkit-slider-thumb{background-color: #043a6b;margin-top: -10px;}

            .cr-slider::-webkit-slider-thumb:hover {

                border: 1px solid #fff;
              }
            input[type="range"]::-webkit-slider-thumb:active {
                transform: scale(1.2);
            }

        </style>
    </section>

    @push('scripts')
        
        <script>
            let emailExistUrl = '{{ route('teachers.register.email.exist') }}';
            let schHtml = <?= json_encode(View::make('teachers.register.schedule.single')->render()) ?>;
        </script>
        <script src="{{ asset('js/teacher/register.js') }}"></script>
		
	<script type="text/javascript">
		var placeSearch, autocomplete;

		function initAutocomplete() {
		  // Create the autocomplete object, restricting the search predictions to
		  // geographical location types.
		  autocomplete = new google.maps.places.Autocomplete(
			  document.getElementById('autocomplete'), {types: ['geocode']});

		}
		
		$(document).ready(function(){
		
		});

    </script>
    @endpush
@endsection
