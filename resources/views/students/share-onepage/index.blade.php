@extends('layouts.app',['title'=> __('labels.stu_reservation')])
@section('title', __('labels.stu_reservation'))
@section('content')

    <section class="profile_sec reservation_sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="profile_inner tab_pnle_sec">
                        @if (!empty($booking) && $booking->toArray())
                            @include('students.share-onepage.index.onepage')
                        @else
                            <div class="one_pg_tab stud">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <p>{{__('labels.stu_not_complete_any_lessons')}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
        /*$CA = !empty($avgRatData['CA']) ? $avgRatData['CA'] : 0;
        $FP = !empty($avgRatData['FP']) ? $avgRatData['FP'] : 0;
        $LC = !empty($avgRatData['LC']) ? $avgRatData['LC'] : 0;
        $V = !empty($avgRatData['V']) ? $avgRatData['V'] : 0 ;
        $GA = !empty($avgRatData['GA']) ? $avgRatData['GA'] : 0;
        $AVE = ($CA + $FP + $LC + $V + $GA)/ 5;*/
		
		$CA = !empty($booking['ca_rating']) ? $booking['ca_rating'] : 5;
		$FP = !empty($booking['fp_rating']) ? $booking['fp_rating'] : 5;
		$LC = !empty($booking['lc_rating']) ? $booking['lc_rating'] : 5;
		$V = !empty($booking['v_rating']) ? $booking['v_rating'] : 5;
		$GA = !empty($booking['ga_rating']) ? $booking['ga_rating'] : 5;
		$AVE = ($CA + $FP + $LC + $V + $GA) / 5;
    ?>

    @push('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
        <script type="text/javascript" src="{{ asset('plugins/text-to-speech/articulate.min.js') }}"></script>
        <script>
            $(document).on('click', '.onepage-tabs',function(e){
                e.preventDefault();
                window.location.href = $(this).attr('href');
            });
        </script>
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
        @include('students.onepage.index.onepage.details.trend-js')
        <script>
            function speak(obj) {
                $(obj).articulate('speak');
            };

            function pause() {
                $().articulate('pause');
            };

            function resume() {
                $().articulate('resume');
            };

            function stop() {
                $().articulate('stop');
            };
        </script>
		<script type="text/javascript">
		function show_japanes_text(span_id) {

            $('#' + span_id).toggle();
            if ($('.' + span_id).text() == 'Read More') {

            $('.' + span_id).text('Read Less');
            } else {

            $('.' + span_id).text('Read More');
            }
        }
		</script>
    @endpush
@endsection
