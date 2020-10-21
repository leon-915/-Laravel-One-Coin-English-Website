@extends('admin.layouts.admin', ['title'=>'Dashboard'])

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
        <span class="page-title-icon bg-gradient-info text-white mr-2">
            <i class="mdi mdi-home"></i>
        </span>
        Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                {{-- <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview
                    <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li> --}}
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                    <h4 class="font-weight-normal mb-3">Total Users
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?= !empty($totalUsers) ? $totalUsers : 0 ?></h2>
                    <h6 class="card-text">&nbsp;</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                    <h4 class="font-weight-normal mb-3">Weekly Orders
                    <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">45,6334</h2>
                    <h6 class="card-text">Decreased by 10%</h6>
                </div>
            </div>
        </div>
         <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                    <h4 class="font-weight-normal mb-3">Visitors Online
                    <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">95,5741</h2>
                    <h6 class="card-text">Increased by 5%</h6>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection

@push('scripts')
	<script src="{{ asset('assets/admin/js/dashboard.js') }}"></script>
		@if(Session::has('message'))
			<script>
			$.toast({
				heading: 'Success',
				text: "<?= Session::get('message') ?>",
				icon: 'success',
				position: 'top-right',
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
