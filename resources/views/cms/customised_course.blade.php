
@extends('layouts.app',['title'=>'Casual Conversation'])
@section('title', 'Casual Conversation')
@section('content')

    <section class="sub_page_padding">
        <div class="container">
            <div class="aboutus_detail_box">
                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                <h5>{{__('casual_conversation.casual_conversation')}}</h5>
                                <p>{{__('casual_conversation.casual_conversation_heading1_text')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <h5>{{__('casual_conversation.heading_use_case_1')}}</h5>
                                <p>1) {{__('casual_conversation.casual_conversation_use_case_1_text')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <h5>{{__('casual_conversation.heading_use_case_2')}}</h5>
                                <p>1) {{__('casual_conversation.casual_conversation_use_case_2_text')}}</p>
                            </div>
                            <div class="prvcy_margin">
                                <h5>{{__('casual_conversation.heading_use_case_3')}}</h5>
                                <p>1) {{__('casual_conversation.casual_conversation_use_case_3_text')}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                @include('cms.flexible_pricing_section')
                            </div>
                        </div>
                    </div>
                </div>
				<div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                @include('cms.lesson_anywhere_section')
                            </div>
                        </div>
                    </div>
                </div>
				<div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                @include('cms.amazing_language_partners_section')
                            </div>
                        </div>
                    </div>
                </div>
				<div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                @include('cms.what_our_learners_say_section')
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="business_sec">
                    <div class="row">
                        <div class="col-12">
                            <div class="prvcy_margin">
                                @include('cms.book_a_lesson_section')
                            </div>
                        </div>
                    </div>
                </div>

              </div>
        </div>
    </section>

@push('script')

    <script type="text/javascript">
        //set content bottom padding
        $("#content").css("padding-bottom", $("footer").outerHeight()+'px');
        $("#content").css("padding-top", $("header").outerHeight()+'px');

        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            });
        });
    </script>

@endpush
@endsection
