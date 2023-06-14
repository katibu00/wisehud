@extends('layout.app')
@section('PageTitle','User Home')
@section('content')
<section class="welcome-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-3">
                <h3>Welcome, {{ auth()->user()->name }}</h3>
                <p>Your Wallet Balance: &#8358;{{ number_format(auth()->user()->wallet->balance) }}</p>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h5>Account Numbers</h5>
                    </div>
                    <div class="card-body">
                        <div class="horizontal-scroll">

                            <div id="account-carousel" class="owl-carousel">
                                @if(is_array($accounts) && count($accounts) > 0)
                                @foreach($accounts as $account)
                                <div class="account-card">
                                    <h6>{{ $account['bankName'] }}</h6>
                                    <p>{{ $account['accountNumber'] }}</p>
                                    <p>{{ $account['accountName'] }}</p>
                                </div>
                                @endforeach
                                @else
                                <div class="account-card">
                                    <h6>No Account Numbers</h6>
                                    <p></p>
                                    <p></p>
                                </div>
                                @endif
                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="data-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Buy Data Quickly</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group text-left">
                                <label for="network">Network:</label>
                                <select class="form-control" id="network">
                                    <option value=""></option>
                                    <option value="MTN">MTN</option>
                                    <option value="AIRTEL">AIRTEL</option>
                                    <option value="GLO">GLO</option>
                                    <option value="9MOBILE">9MOBILE</option>
                                </select>
                            </div>
                            <div class="form-group text-left">
                                <label for="contact">Number:</label>
                                <select class="form-control" id="contact" name="contact">                                    
                                </select>
                            </div>
                            <div class="form-group text-left" id="phoneField" style="display: none;">
                                <label for="number">Phone Number:</label>
                                <input type="text" class="form-control" id="number">
                            </div>
                            <div class="form-group text-left">
                                <label for="amount">Select Amount:</label>
                                <select class="form-control" id="amount">
                                </select>
                            </div>
                            <div class="form-group text-left">
                                <label for="price">Price:</label>
                                <input type="text" class="form-control" id="price">
                            </div>
                            <button type="submit" class="btn btn-primary">Buy Data</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Recent Transactions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Network</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2023-05-28</td>
                                        <td>Network 1</td>
                                        <td>1GB</td>
                                        <td>Successful</td>
                                    </tr>
                                    <tr>
                                        <td>2023-05-27</td>
                                        <td>Network 2</td>
                                        <td>500MB</td>
                                        <td>Failed</td>
                                    </tr>
                                    <tr>
                                        <td>2023-05-26</td>
                                        <td>Network 3</td>
                                        <td>2GB</td>
                                        <td>Successful</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>  
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 15,
            nav: true,
            dots: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
            mouseDrag: true,
            touchDrag: true,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 40,
                    center: true
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });

    });
</script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(document).ready(function() {
        $('.hero-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            dots: false,
            nav: false
        });
        $('.carousel').carousel({
            interval: 3000, // Adjust the interval as needed (in milliseconds)
            pause: false, // Set to true if you want the auto-scrolling to pause on hover
            ride: 'carousel' // Enable the automatic cycling of the carousel
        });
    });
</script>


<script>
$(document).ready(function() {
    $('#contact').on('change', function() {
        var phoneField = $('#phoneField');
        if ($(this).val() === 'new') {
            phoneField.show();
        } else {
            phoneField.hide();
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        $('#network').on('change', function() {
            var networkId = $(this).val();
            var amountField = $('#amount');
            var contactsField = $('#contact');

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
           
            amountField.html('<option value="">Loading...</option>');

            if (networkId) {

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
                    $.ajax({
                    url: '/fetch-data-plans',
                    method: 'POST',
                    data: { networkId: networkId },
                    success: function(response) {
                        amountField.empty();
                        contactsField.empty();
                        var dataPlans = response.dataPlans;
                        var contacts = response.contacts;
                        var dataPlansHTML = '';
                        dataPlansHTML+= '<option value=""></option>'
                        $.each(dataPlans, function(index, dataPlan) {
                            dataPlansHTML+= '<option value="'+dataPlan.id+'">'+dataPlan.amount+'</option>';
                        });
                        amountField.html(dataPlansHTML);
                        var contactHTML = '';
                        contactHTML+= '<option value=""></option><option value="new">New Number</option>'
                        $.each(contacts, function(index, contact) {
                            contactHTML+= '<option value="'+contact.id+'">'+contact.name+'</option>';
                        });
                        contactsField.html(contactHTML);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    });
</script>
@endsection