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
                                {{-- Example static data (replace with @foreach later) --}}
                                @foreach($payments as $key => $payment)
                                    @if($payment->status === 'Approved' || $payment->status === 'Paid')
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $payment->consulter->name ?? '-' }}</td>
                                            <td>{{ $payment->date }}</td>
                                            <td><strong>{{$payment->amount}} Dollar</strong></td>
                                            <td>
                                                @if($payment->status === 'Approved')
                                                    <a href="" target="_blank"
                                                       class="btn btn-success btn-sm">
                                                        Pay Now
                                                    </a>
                                                @elseif($payment->status === 'Paid')
                                                    <span class="badge bg-primary">Paid</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                {{-- End Example --}}
                                </tbody>
                            </table>
                        </div>

                        <!-- ✅ Account Summary Section -->

                        <!-- /Account Summary Section -->

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

