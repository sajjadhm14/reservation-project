@extends('consulter.dashboard.dashboard')

@section('content')
    <div class="page-content">
        {{-- Calendar + Add Time Section --}}
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Add Available Time</h4>

                <form class="row g-3"  action="{{ route('consulter.set.calender') }}"  method="POST" id="calenderForm">
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
                        <button type="submit" class="btn btn-success mt-3" id="addTimeBtn">Add Time</button>
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

                    <tbody id="timeTable">
                    @forelse($calenders as $calender)
                        <tr data-id="{{ $calender->id }}">
                            <td>{{ $calender->date }}</td>
                            <td>{{ $calender->start_time }}</td>
                            <td>{{ $calender->end_time }}</td>
                            <td>{{ $calender->amount ?? '—' }}</td>
                            <td>
                                    @if($calender->status === 'pending')
                                        <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                    @elseif($calender->status === 'paid')
                                        <span class = "badge bg-gradient-light">paid</span>
                                    @elseif( $calender->status === 'Approved')
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

    {{-- JS for form submission + delete --}}
    <script>
        // ----- Handle Add Time -----
        document.getElementById('calenderForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch("{{ route('consulter.set.calender') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert('✅ Time added successfully!');
                        form.reset();

                        if (data.newCalender) {
                            const newRow = `
                            <tr data-id="${data.newCalender.id}">
                                <td>${data.newCalender.date}</td>
                                <td>${data.newCalender.start_time}</td>
                                <td>${data.newCalender.end_time}</td>
                                <td>${data.newCalender.amount}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>`;
                            document.getElementById('timeTable').insertAdjacentHTML('beforeend', newRow);
                        }
                    } else {
                        alert('⚠️ Error adding time!');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('❌ Something went wrong!');
                });
        });

        // ----- Handle Delete Button -----
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-btn')) {
                const row = e.target.closest('tr');
                const id = row.dataset.id;

                if (!confirm('Are you sure you want to delete this time?')) return;

                fetch(`{{ url('consulter/calender/delete') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            alert('🗑️ Time deleted successfully!');
                        } else {
                            alert(data.message || '⚠️ Error deleting time!');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('❌ Something went wrong!');
                    });
            }
        });
    </script>
@endsection
