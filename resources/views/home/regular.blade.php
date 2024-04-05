@extends('layout.app')
@section('pageTitle', 'Home')
@section('content')

    <div class="page-content-wrapper">

        <div class="pt-3"></div>

        <div class="container direction-rtl">
            <div class="card mb-3 text-center">
                {{-- <div class="card-header bg-primary text-white">
            <h4 class="my-0">User Balance</h4>
          </div> --}}
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-wallet2 me-3"></i>Main Balance
                                    </h5>
                                    <p id="main-balance" class="card-text display-6">
                                        ₦{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->balance, 2) : 'N/A' }}
                                    </p>
                                    <!-- Add funds button -->
                                    <a href="{{ route('wallet.index') }}" class="btn btn-primary btn-sm">Add Funds</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div class="row g-3">
                        <div class="col-4">
                            <a href="" class="text-decoration-none">
                                <div class="feature-card mx-auto">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-arrow-left-right me-3"></i>
                                    </div>
                                    <p class="mb-0">Transactions</p>
                                </div>
                            </a>
                        </div>

                        @php
                            $number = App\Models\Charges::select('whatsapp_number')->first();
                        @endphp
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="https://wa.me/{{ $number->whatsapp_number }}?text=My%20name%20is" target="_blank"
                                    rel="noopener noreferrer">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-whatsapp me-3"></i>
                                    </div>
                                    <p class="mb-0">Contact Us</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-box-arrow-right me-3"></i>
                                    </div>
                                    <p class="mb-0">Logout</p>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- New Menu Icons -->
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="#">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-chat-left-dots me-3"></i>
                                    </div>
                                    <p class="mb-0">AI Chat</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="#">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-arrow-up-circle me-3"></i>
                                    </div>
                                    <p class="mb-0">Upgrade Plan</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="#">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-journal me-3"></i>
                                    </div>
                                    <p class="mb-0">Chat History</p>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>



        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div class="row g-3">
                        @if ($marqueeNotification)
                            <marquee class="marquee-notification" behavior="scroll" direction="left">
                                {{ $marqueeNotification->message }}
                            </marquee>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <style>
            .marquee-notification {
                font-size: 1.2em;
                font-weight: bold;
                color: #d63384;
                padding: 10px;
                /* background-color: #e9ecef;  */
                border-radius: 8px;
            }

            .bonus-container {
                background-color: #f0f0f0;
                border-radius: 5px;
                padding: 10px;
                font-weight: bold;
            }
        </style>



        <div class="container">
            <div class="card bg-primary rounded-0 rounded-top">
                <div class="card-body text-center py-3">
                    <h6 class="mb-0 text-white line-height-1">Fund Your Wallet</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">


                    <div class="standard-tab">
                        <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
                            @foreach ($accounts as $index => $account)
                                <li class="nav-item" role="presentation">
                                    <button class="btn {{ $index === 0 ? 'active' : '' }}"
                                        id="account-tab-{{ $index }}" data-bs-toggle="tab"
                                        data-bs-target="#account-{{ $index }}" type="button" role="tab"
                                        aria-controls="account-{{ $index }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $account['bankName'] }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
                            @foreach ($accounts as $index => $account)
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                    id="account-{{ $index }}" role="tabpanel"
                                    aria-labelledby="account-tab-{{ $index }}">
                                    <h6>{{ $account['bankName'] }}</h6>
                                    <p class="mb-0">Account Number: {{ $account['accountNumber'] }}</p>
                                    <p class="mb-0">Account Name: {{ $account['accountName'] }}</p>
                                    <p class="mb-0">Charges: 1%</p>
                                    <button class="btn btn-sm btn-primary copy-btn"
                                        data-clipboard-text="{{ $account['accountNumber'] }}" type="button"><i
                                            class="bi bi-clipboard"></i> Copy Account Number</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
       
    </div>


    <div class="pb-3"></div>

    <div class="container">
        <div class="card bg-primary mb-3 bg-img" style="background-image: url('img/core-img/1.png')">
            <div class="card-body direction-rtl p-5">
                <h2 class="text-white">Referral Program</h2>
                <p class="mb-4 text-white">Share your referral link with your contacts and get NGN 200 for every referral!
                </p>
                <div class="mb-3">
                    <strong class="text-white">Your Referral Link:</strong>
                    <input type="text" id="referralLink" class="form-control"
                        value="{{ route('register') }}?referral_code={{ auth()->user()->referral_code }}" readonly>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success" onclick="shareOnWhatsApp()">Share on WhatsApp</button>
                    <button class="btn btn-info" onclick="copyLink()">Copy Link</button>
                </div>
                <div>
                    <strong class="text-white">Total Users Referred:</strong>
                    <span class="text-white">{{ auth()->user()->referredUsers()->count() }}</span>
                </div>
            </div>
        </div>
    </div>


    <div class="pb-3"></div>

    </div>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <script>
        function shareOnWhatsApp() {

            var leadingMessage = "Welcome to Wisehud AI, your gateway to next-level conversational AI solutions! Elevate your customer interactions, streamline operations, and stay ahead of the curve with our cutting-edge AI chat assistants. Don't miss out on the future of communication – sign up now using my referral link and unlock the power of intelligent conversations!\n\n";
            var referralLink = document.getElementById('referralLink').value;
            var shareMessage = leadingMessage + referralLink;


            var shareURL = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(shareMessage);

            window.open(shareURL, '_blank');
        }


        function copyLink() {

            var referralLinkInput = document.getElementById('referralLink');
            referralLinkInput.select();
            referralLinkInput.setSelectionRange(0, 99999);

            document.execCommand('copy');

            referralLinkInput.setSelectionRange(0, 0);

            toastr.success('Referral link copied to clipboard!');
        }
    </script>


@endsection
