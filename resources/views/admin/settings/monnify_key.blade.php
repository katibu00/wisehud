@extends('admin.layout.app')
@section('pageTitle', 'Monnify API Key')
@section('content')

<main id="main-container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Monnify API Key</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="container">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('monnify_api_key') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="publicKey" class="form-label">Public Key</label>
                                <input type="text" class="form-control" id="publicKey" name="public_key" value="{{ $monnifyKeys->public_key ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="secretKey" class="form-label">Secret Key</label>
                                <input type="text" class="form-control" id="secretKey" name="secret_key" value="{{ $monnifyKeys->secret_key ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="contractCode" class="form-label">Contract Code</label>
                                <input type="text" class="form-control" id="contractCode" name="contract_code" value="{{ $monnifyKeys->contract_code ?? '' }}">
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
