@extends('admin.layout.app')
@section('pageTitle', 'Paystack API Keys')
@section('content')

<main id="main-container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">OpenPaystackAI API Key</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('paystack_key') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="public_key" class="form-label">Public Key</label>
                                <input type="text" class="form-control" id="public_key" name="public_key" value="{{ $openAIKey->public_key ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="secret_key" class="form-label">Secret Key</label>
                                <input type="text" class="form-control" id="secret_key" name="secret_key" value="{{ $openAIKey->secret_key ?? '' }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
