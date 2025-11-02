@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3 mt-5">
                    <div class="card-body text-center py-5">
                        @php
                            $callback =   \App\Models\WalletPayment::latest()->first();
                        @endphp
                        {{-- ✅ Tick Icon --}}
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 80px;"></i>
                        </div>

                        {{-- Title --}}
                        <h4 class="fw-bold text-success mb-3">Payment Successful</h4>

                        {{-- Reference Number --}}
                        <div class="mb-4">
                            <p class="fw-semibold text-muted mb-1">Reference Number</p>
                            <h5 class="fw-bold text-primary">
                                {{$callback->ref_number}}
                            </h5>
                        </div>

                        {{-- Redirect Button --}}
                        <div>
                            <a href="{{route('user.dashboard')}}" class="btn btn-primary px-4 py-2 fw-bold">
                                Go to Dashboard
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

