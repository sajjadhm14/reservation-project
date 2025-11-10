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

                        {{-- ✅ Mock Payment Actions --}}
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('payment.post', ['Status' => 'OK', 'Authority' => $ref_id ?? 'mock123']) }}"
                               class="btn btn-success px-4 py-2 fw-bold rounded-pill">
                                Pay Now
                            </a>

                            <a href="{{ route('payment.post', ['Status' => 'NOK', 'Authority' => $ref_id ?? 'mock123']) }}"
                               class="btn btn-outline-danger px-4 py-2 fw-bold rounded-pill">
                                Cancel
                            </a>
                        </div>

                        <p class="text-muted small mt-4">This is a mock payment page for testing only.</p>
                        <p class="text-secondary mt-3" id="countdownText">
                            Redirecting in <span id="timer">10:00</span> minutes...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Countdown + Auto Fail Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let timeLeft = 600; // 10 minutes
            const timerEl = document.getElementById('timer');

            const countdown = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    autoFail();
                }
            }, 1000);

            function autoFail() {
                window.location.href = "{{ route('payment.post', ['Status' => 'FAILED', 'Authority' => $ref_id ?? 'mock123', 'reservation_id' => $reservation_id ?? 0]) }}";
            }
        });
    </script>
@endsection
