@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 grid-margin">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4 fw-bold text-primary">
                            Charge Your Wallet
                        </h4>

                        {{-- Current Wallet Info --}}
                        @php
                            $wallet = \App\Models\Wallet::where('user_id', auth()->id())->first();
                        @endphp

                        <div class="mb-4 text-center">
                            <p class="fw-semibold text-muted mb-1">Current Balance</p>
                            <h4 class="text-success fw-bold mb-0">
                                ${{ number_format($wallet->current_balance ?? 0, 2) }}
                            </h4>
                        </div>

                        {{-- Transaction Form --}}
                        <form action="{{route('payment.post')}}" method="Post">
                            @csrf
                            <div class="mb-3">
                                <label for="amount" class="form-label fw-semibold">Enter Amount to Charge ($)</label>
                                <input type="number" name="amount" id="amount" class="form-control form-control-lg @error('amount') is-invalid @enderror"
                                       min="1" required placeholder="Enter Here">
                                @error('amount')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mt-4 text-end">
                                <button    class="btn btn-primary px-4 py-2 fw-bold">
                                    Proceed to Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Mock Result Section --}}
                @if(session('success'))
                    <div class="alert alert-success mt-4 text-center fw-semibold">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
