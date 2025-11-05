@extends('consulter.dashboard.dashboard')

@section('content')
    <div class="page-content">
        {{-- Calendar + Add Time Section --}}
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Add Available Time</h4>

                {{-- ✅ Normal POST form --}}
                <form class="row g-3" action="{{ route('consulter.set.calender') }}" method="POST">
                    @csrf
                    <div class="col-md-4">
                        <label for="date" class="form-label">Select Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control" required>
                    </div>

                    {{-- 💰 Amount Field --}}
                    <div class="col-md-4">
                        <label for="amount" class="form-label">Amount (per session)</label>
                        <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" min="0" required>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success mt-3">Add Time</button>
                    </div>
                </form>

                <hr class="my-4">

                <h5 class="mb-3">My Available Times</h5>
                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Amount</th>
                        <th>Status / Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($calenders as $calender)
                        <tr>
                            <td>{{ $calender->date }}</td>
                            <td>{{ $calender->start_time }}</td>
                            <td>{{ $calender->end_time }}</td>
                            <td>{{ $calender->amount ?? '—' }}</td>
                            <td>
                                @if($calender->status === 'pending')
                                    {{-- ✅ SweetAlert Delete Form --}}
                                    <form action="{{ route('consulter.delete.calender', $calender->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                    </form>
                                @elseif($calender->status === 'paid')
                                    <span class="badge bg-gradient-light">Paid</span>
                                @elseif($calender->status === 'Approved')
                                    <span class="badge bg-success">Reserved</span>
                                @else
                                    <span class="badge bg-secondary">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No available times yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function (e) {
                    const form = this.closest("form");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won’t be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
