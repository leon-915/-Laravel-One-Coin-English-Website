@extends('layouts.app',['title'=>__('labels.stu_my_account')])
@section('title',__('labels.stu_my_account'))
@section('content')
    <div id="content" class="clearfix">
        <section class="profile_sec clearfix">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="profile_inner tab_pnle_sec">
                            <div class="card custome_nav acc-student">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation">
                                        <a href="#classroom" aria-controls="classroom" role="tab" data-toggle="tab"
                                           class="acc_tab" data-url="{{route('student.account.get.class')}}">
                                            <span>{{__('labels.stu_classroom_lesson')}}</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#accent" aria-controls="accent" role="tab" data-toggle="tab"
                                           class="acc_tab">
                                            <span>{{__('labels.stu_accent_one_plan')}}</span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content table-container">
                                    <div role="tabpanel" class="tab-pane active student-account" id="classroom">
                                    </div>

                                    <div role="tabpane2" class="tab-pane" id="accent">
                                        @include('students.account.index.oneplan')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="{{asset('js/student/account/index.js')}}"></script>
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

        @include('students.account.index.js')
        {{-- <script src="{{ asset('js/student/profile/index.js') }}"></script> --}}
    @endpush

@endsection
