@extends('user.dashboard.dashboard')

@section('content')

    <div class="page-content">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Approved Reservations</h4>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Consultant</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wallets as $key => $wallet)
                                    @if($wallet->status == 'Approved' || $wallet->status =='Paid')
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $wallet->consulter->name ?? '-' }}</td>
                                            <td>{{ $wallet->date }}</td>
                                            <td><strong>{{ $wallet->amount }}</strong></td>
                                            <td>
                                                @if($wallet->status =='Approved')
                                                    <form action="{{ route('reservation.payment.post', $wallet->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            Pay Now
                                                        </button>
                                                    </form>
                                                @elseif($wallet->status == 'Paid')
                                                    <span class="badge bg-primary">Paid</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

