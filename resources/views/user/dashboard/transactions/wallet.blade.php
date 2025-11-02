@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 grid-margin">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body py-4 px-4">
                        <h4 class="card-title mb-4 text-center fw-bold text-primary">
                            Account Summary
                        </h4>

                        @php
                            $wallet = \App\Models\Wallet::where('user_id', auth()->id())->first();
                            $reservations = \App\Models\Reservation::where('user_id', auth()->id())->get();

                            $currentBalance = $wallet->current_balance ?? 0;
                            $totalPayments = $reservations->sum('amount');
                            $remainingBalance = $currentBalance - $totalPayments;
                        @endphp

                        <div class="row text-center mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="fw-semibold mb-1 text-muted">Current Account Balance</p>
                                <h5 class="text-success mb-0">
                                    ${{ number_format($currentBalance, 2) }}
                                </h5>
                            </div>

                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="fw-semibold mb-1 text-muted">Total Payment Amount</p>
                                <h5 class="text-danger mb-0">
                                    ${{ number_format($totalPayments, 2) }}
                                </h5>
                            </div>

                            <div class="col-md-4">
                                <p class="fw-semibold mb-1 text-muted">Remaining Balance After Payment</p>
                                <h5 class="fw-bold mb-0 {{ $remainingBalance < 0 ? 'text-danger' : 'text-primary' }}">
                                    ${{ number_format($remainingBalance, 2) }}
                                </h5>
                            </div>
                        </div>

                        <div class="text-end mt-3 mb-4">
                            <a href="{{ route('wallet.charge') }}" class="btn btn-primary px-4 py-2 fw-bold">
                                Charge Account
                            </a>
                        </div>
                        <div class="text-end mt-3 mb-4">
                            <a href="{{ route('wallet.charge') }}" class="btn btn-primary px-4 py-2 fw-bold">
                                Pay Reservation
                            </a>
                        </div>


                        <!-- ===================== Account History Section ===================== -->

                        <div class="border-top pt-4">
                            <h5 class="mb-3 fw-bold text-primary text-center">Account History</h5>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center">
                                    <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Balance After</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($historys as $key=>$history)
                                        <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$history->created_at}}</td>
                                        <td>Wallet charge</td>
                                        <td><span class="badge bg-success">Credit</span></td>
                                        <td>{{$history->current_balance}}</td>
                                        <td>{{$history->remaining_balance}}</td>
                                    </tr>
                                    @endforeach
                                    <!-- Example static rows (you will replace later with dynamic data) -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- ==================================================================== -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
