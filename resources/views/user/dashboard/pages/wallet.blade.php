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

                        <div class="row text-center mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="fw-semibold mb-1 text-muted">Current Account Balance</p>
                                <h5 class="text-success mb-0">$150.00</h5>
                            </div>

                            <div class="col-md-4 mb-3 mb-md-0">
                                <p class="fw-semibold mb-1 text-muted">Total Payment Amount</p>
                                <h5 class="text-danger mb-0">$100.00</h5>
                            </div>

                            <div class="col-md-4">
                                <p class="fw-semibold mb-1 text-muted">Remaining Balance After Payment</p>
                                <h5 class="text-primary fw-bold mb-0">$50.00</h5>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button class="btn btn-primary px-4 py-2 fw-bold">
                                Pay $100.00 Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
