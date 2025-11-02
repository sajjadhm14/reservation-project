@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 grid-margin">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 text-center">

                        <h4 class="card-title text-primary fw-bold mb-4">
                            Mock Zarinpal Payment
                        </h4>

                        {{-- WalletPayment Summary --}}


                        <div class="alert alert-info fw-semibold mb-4">
                            Please confirm your payment.
                            You can either complete or cancel this transaction.
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('payment.callback', ['Status' => 'success', 'Authority' => $ref ?? 'mock123', 'reservation_id' => $reservation_id ?? 0]) }}"
                               class="btn btn-success px-4 py-2 fw-bold rounded-pill">
                                Pay Now
                            </a>

                            <a href="{{ route('payment.callback', ['Status' => 'cancelled', 'Authority' => $ref ?? 'mock123', 'reservation_id' => $reservation_id ?? 0]) }}"
                               class="btn btn-outline-danger px-4 py-2 fw-bold rounded-pill">
                                Cancel
                            </a>
                        </div>

                        {{-- Footer Info --}}
                        <div class="mt-5 text-muted small">
                            <p class="mb-0">This is a <strong>mock payment</strong> page for testing only.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

