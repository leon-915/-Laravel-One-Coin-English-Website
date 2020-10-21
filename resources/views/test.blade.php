@extends('layouts.app',['title'=> __('labels.teacher_bid_job')])
@section('title', __('labels.teacher_bid_job'))
@section('content')
    @push('scripts')
        <script>
            var api_key = 'AIzaSyBfZsHgLneeGwPF9XIiKgR_kyO8W7xNsTA';
            var folderId = '16cGc1mYXoN1FciGpeh9e2WgG6OCksnqT3pxtJz9FCps';
            var url = 'https://www.googleapis.com/drive/v3/files?key=' + api_key;
            var promise = $.getJSON(url, function (data, status) {
// on success
            });
            promise.done(function (data) {
// do something with the data
                console.log(data);
            }).fail(function (err) {
                console.log(err);
            });
        </script>
    @endpush

@endsection