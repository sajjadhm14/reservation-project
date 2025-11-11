@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3 mt-5">
                    <div class="card-body text-center py-5">

                        <h4 class="text-primary fw-bold mb-4">Mock Payment Gateway</h4>

                        <p>
                            Amount:
                            <strong>{{ number_format($amount) }}</strong> Rials
                        </p>

                        <p>
                            Ref ID:
                            <code>{{ $ref_id }}</code>
                        </p>

                        <div class="mt-4 d-flex justify-content-center gap-3">
                            {{-- ✅ Pay Now --}}
                            <form action="{{ route('gateway.callback.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="success">
                                <input type="hidden" name="ref_id" value="{{ $ref_id }}">
                                <button type="submit" class="btn btn-success px-4">Pay Now</button>
                            </form>

                            {{-- ❌ Cancel --}}
                            <form action="{{ route('gateway.callback.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <input type="hidden" name="ref_id" value="{{ $ref_id }}">
                                <button type="submit" class="btn btn-outline-danger px-4">Cancel</button>
                            </form>
                        </div>

                        <p class="text-muted small mt-4">
                            This is a mock payment page for testing only.
                        </p>

                        <p class="text-secondary mt-3" id="countdownText">
                            Redirecting in <span id="timer">10:00</span> minutes...
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Countdown + Auto-Fail Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let timeLeft = 600; // 10 minutes
            const timerEl = document.getElementById('timer');

            // Countdown timer
            const countdown = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Timer reached 0 => auto-fail
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    autoFail();
                }
            }, 1000);

            // Auto fail after timeout
            function autoFail() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('gateway.callback.post') }}";

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const status = document.createElement('input');
                status.type = 'hidden';
                status.name = 'status';
                status.value = 'failed';

                const ref = document.createElement('input');
                ref.type = 'hidden';
                ref.name = 'ref_id';
                ref.value = '{{ $ref_id }}';

                form.appendChild(csrf);
                form.appendChild(status);
                form.appendChild(ref);

                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
@endsection
