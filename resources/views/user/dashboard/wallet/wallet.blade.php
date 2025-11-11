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
                            $reservations = \App\Models\Reservation::where('user_id', auth()->id())
                                ->where('status', 'approved')
                                ->get();

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

                        <div class="text-end mt-3 mb-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('wallet.charge') }}" class="btn btn-primary px-4 py-2 fw-bold">
                                Charge Account
                            </a>
                            <a href="{{ route('reservation.payment') }}" class="btn btn-success px-4 py-2 fw-bold">
                                Pay Reservation
                            </a>
                        </div>

                        <!-- ===================== WALLET HISTORY ===================== -->
                        <div class="border-top pt-4 mt-4">
                            <h5 class="mb-3 fw-bold text-primary text-center">Wallet Payment History</h5>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($historys as $key => $history)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                                            <td>Wallet Charge</td>
                                            <td>
                                                @if($history->status == 'success')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($history->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($history->status == 'failed')
                                                    <span class="badge bg-warning">Failed</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($history->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ===================== RESERVATION PAYMENTS ===================== -->
                        @php
                            $reserves = \App\Models\Reservation::where('user_id', auth()->id())
                                ->where('status' , 'paid')
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();
                        @endphp

                        <div class="border-top pt-4 mt-4">
                            <h5 class="mb-3 fw-bold text-success text-center">Reservation Payment History</h5>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Consulter name</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($reserves as $key => $reserve)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $reserve->created_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $reserve->consulter->name }}</td>
                                            <td>
                                                @if($reserve->status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($reserve->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($reserve->status == 'failed')
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($reserve->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-muted">No reservation payments yet.</td>
                                        </tr>
                                    @endforelse
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
