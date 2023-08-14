@extends('layout.app')
@section('pageTitle', 'Wallet')
@section('content')

    <div class="page-content-wrapper">

        <!-- Tiny Slider One Wrapper -->
        <div class="pt-3"></div>
        <div class="container dikrection-rtl">
            
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="standard-tab">
                            <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">

                                @if (is_array($accounts) && count($accounts) > 0)
                                    @foreach ($accounts as $key => $account)
                                        <li class="nav-item" role="presentation">
                                            <button class="btn {{ $loop->first ? 'active' : '' }}"
                                                id="key{{ $key }}-tab" data-bs-toggle="tab"
                                                data-bs-target="#key{{ $key }}" type="button" role="tab"
                                                aria-controls="key{{ $key }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $account['bankName'] }}</button>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                            <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">

                                @if (is_array($accounts) && count($accounts) > 0)
                                    @foreach ($accounts as $key => $account)
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                            id="key{{ $key }}" role="tabpanel"
                                            aria-labelledby="key{{ $key }}-tab">
                                            <div class="d-flex align-items-center">
                                                <h6 class="mr-2"><span class="font-weight-bold">Acc. No.:</span></h6>
                                                <p class="mb-0">{{ $account['accountNumber'] }}</p>
                                                <button class="btn btn-link btn-sm ml-2"
                                                    onclick="copyToClipboard('{{ $account['accountNumber'] }}')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                            <p class="mb-0"><span class="font-weight-bold">Acc. Name:</span>
                                                {{ $account['accountName'] }}</p>
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
                            <h5 class="mb-3">Your Wallet Balance:
                                &#8358;{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->balance, 2) : 'N/A' }}
                            </h5><a class="btn btn-info btn-round" href="#">Add Funds</a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="pb-3"></div>
        </div>



    @endsection

    @section('js')

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

    

        <script>
            function copyToClipboard(text) {
                const input = document.createElement('input');
                input.setAttribute('value', text);
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);

                // Show a success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Account number copied to clipboard.',
                    timer: 2000, // Show the alert for 2 seconds
                    timerProgressBar: true,
                });
            }
        </script>


    @endsection
