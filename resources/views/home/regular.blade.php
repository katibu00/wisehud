@extends('layout.app')
@section('pageTitle', 'Home')
@section('content')

<div class="page-content-wrapper">
   
    <!-- Tiny Slider One Wrapper -->
    <div class="pt-3"></div>
    <div class="container dikrection-rtl">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray"><i class="fa-solid fa-wallet"></i></div>
                <p class="mb-0">Add Funds</p>
              </div>
            </div>
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray"><i class="fa-solid fa-comment-dots"></i></div>
                <p class="mb-0">Chat</p>
              </div>
            </div>
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <p class="mb-0">History</p>
              </div>
            </div>
          <div class="row g-3">
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray"><i class="fa-solid fa-money-check"></i></div>
                <p class="mb-0">Balance</p>
              </div>
            </div>
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray"><i class="fa-solid fa-address-book"></i></div>
                <p class="mb-0">Contact Us</p>
              </div>
            </div>
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <a href="{{ route('logout') }}">
                <div class="card mx-auto bg-gray"><i class="fa-solid fa-right-from-bracket"></i></div>
                <p class="mb-0">Logout</p></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="pt-3"></div> --}}
    <div class="container">
      <div class="card">
        <div class="card-body">
          <div class="standard-tab">
            <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
             
              @if(is_array($accounts) && count($accounts) > 0)
                @foreach($accounts as $key => $account)
                <li class="nav-item" role="presentation">
                  <button class="btn {{ $loop->first ? 'active': '' }}" id="key{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#key{{ $key }}" type="button" role="tab" aria-controls="key{{ $key }}" aria-selected="{{ $loop->first ? 'true': 'false' }}">{{ $account['bankName'] }}</button>
                </li>
               
                @endforeach
              @endif

            </ul>
            <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
             
              @if(is_array($accounts) && count($accounts) > 0)
                @foreach($accounts as $key => $account)
                <div class="tab-pane fade {{ $loop->first ? 'show active': '' }}" id="key{{ $key }}" role="tabpanel" aria-labelledby="key{{ $key }}-tab">
                  <h6>{{ $account['accountNumber'] }}</h6>
                  <p class="mb-0">{{ $account['accountName'] }}</p>
                </div>
                @endforeach
              @endif

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="pt-3"></div>

    <div class="container">
      <div class="card ca">
        <div class="card-body d-flex align-items-center direction-rtl">
          <div class="card-img-wrap"><i class="fa-solid fa-wallet fa-3x"></i></div>
          <div class="card-content">
            <h5 class="mb-3">Your Wallet Balance: &#8358;{{ number_format(auth()->user()->wallet->balance) }}</h5><a class="btn btn-info btn-round" href="#">Add Funds</a>
          </div>
        </div>
      </div>
    </div>
   
   
  
    <div class="pb-3"></div>
  </div>
  
@endsection