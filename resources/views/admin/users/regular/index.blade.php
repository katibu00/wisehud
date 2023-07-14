@extends('admin.layout.app')
@section('pageTitle', 'Regular Users')

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Regular Users</h5>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                @include('admin.users.regular.table')
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </main>


    <div class="modal" id="modal-normal" tabindex="-1" role="dialog" aria-labelledby="modal-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-rounded shadow-none mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="manualFundingModalLabel">Manual Funding for <span id="userName"></span>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm my-3">
                        <form id="manualFundingForm">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" required>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full block-content-sm text-end border-top">
                        <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-alt-primary" id="submitManualFunding">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>







@endsection

@section('js')
    <script src="/jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();

            $('.manual-funding').on('click', function(e) {
                e.preventDefault();

                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');

                $('#userName').text(userName);
                $('#modal-normal').modal('show');

                // Store the userId and userName in the submit button's data attributes
                $('#submitManualFunding').data('user-id', userId);
                $('#submitManualFunding').data('user-name', userName);

            });

            $('#submitManualFunding').on('click', function() {
                var amount = $('#amount').val();
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');
                var $button = $(this);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('manual-funding') }}', 
                    method: 'POST',
                    data: {
                        userId: userId,
                        userName: userName,
                        amount: amount
                    },
                    beforeSend: function() {
                        $button.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        $button.prop('disabled', true);
                    },
                    success: function(response) {
                        
                        $('#manualFundingForm')[0].reset();
                        $('#modal-normal').modal('hide');
                        $('.table').load(location.href+' .table');

                        $button.html('Done');
                        $button.prop('disabled', false);
                        toastr.success('Manual funding submitted successfully');

                    },
                    error: function(xhr, status, error) {
                        // Handle the error case (if any)                            

                    }
                });

            });
        });
    </script>



@endsection
