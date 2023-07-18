@extends('admin.layout.app')
@section('pageTitle','Home')
@section('content')

<main id="main-container">
        
  <div class="content">
    <div class="row">
      
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-users fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">{{ @$totalUsers }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Total Users</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-wallet fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">&#x20A6;{{ @$totalWalletBalance }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Total Wallet Balance</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-money fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">&#x20A6;{{ @$totalFundings }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Total Fundings</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-users fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">{{ @$activeUsers }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Active Users</div>
            </div>
          </div>
        </a>
      </div>
      
    </div>
   
  </div>
  
</main>
@endsection
