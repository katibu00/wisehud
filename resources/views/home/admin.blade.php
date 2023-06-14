@extends('layout.app')
@section('PageTitle', 'Admin Home')
@section('content')

    <section class="welcome-section">
        <div class="container">
            <div class="rolw">

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
    </section>

@endsection
