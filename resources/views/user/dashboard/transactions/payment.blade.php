@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3 mt-5">
                    <div class="card-body text-center py-5">
                        <h4 class="text-primary fw-bold mb-4">Mock Payment Gateway</h4>
                        <p>Amount: <strong>{{ number_format($amount) }}</strong> Rials</p>
                        <p>Ref ID: <code>{{ $ref_id }}</code></p>

                        <div class="mt-4">
                            <a href="{{ route('payment.callback', ['status' => 'success', 'ref_id' => $ref_id]) }}"
                               class="btn btn-success px-4">Pay Now</a>

                            <a href="{{ route( 'payment.callback', ['status' => 'cancelled', 'ref_id' => $ref_id]) }}"
                               class="btn btn-outline-danger px-4 ms-2">Cancel</a>
                        </div>

                        <p class="text-muted small mt-4">This is a mock payment page for testing only.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
