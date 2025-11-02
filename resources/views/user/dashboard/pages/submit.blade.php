@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">My Reserved Times</h4>

                        @foreach($submits as $key => $submit)
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Consultant</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>end Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $submit->consulter->name }}</td>
                                        <td>{{ $submit->date }}</td>
                                        <td>{{ $submit->start_time }}</td>
                                        <td>{{ $submit->end_time }}</td>
                                        <td>
                                        <span class="badge
                                            {{ $submit->status === 'Approved' ? 'bg-success' : ($submit->status === 'Cancelled' ? 'bg-danger' : ($submit->status === 'Paid' ? 'bg-primary' : 'bg-warning text-dark')) }}">
                                            {{ $submit->status }}
                                        </span>
                                        </td>
                                        <td>
                                            @if($submit->status === 'Approved')
                                                <button class="btn btn-secondary btn-sm me-1" disabled>Approved</button>
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="updateStatus(this, 'Cancelled', {{ $submit->id }})">Cancel</button>
                                            @elseif($submit->status === 'Cancelled')
                                                <button class="btn btn-danger btn-sm" disabled>Cancelled</button>
                                            @elseif($submit->status === 'paid')
                                                <button class="btn btn-primary btn-sm" disabled>Paid</button>
                                            @else
                                                <button class="btn btn-success btn-sm me-1"
                                                        onclick="updateStatus(this, 'Approved', {{ $submit->id }})">Approve</button>
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="updateStatus(this, 'Cancelled', {{ $submit->id }})">Cancel</button>
                                            @endif
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--     ✅ AJAX Status Update Script --}}
    <script>

        function updateStatus(button, newStatus, submitId) {
            const $button = $(button);
            $button.prop('disabled', true).text('Updating...');

            $.ajax({
                url: "{{ url('user/submit/post') }}/" + submitId, // ✅ correct dynamic route
                type: "POST", // ✅ correct method
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function (response) {
                    if (response.status === 200) {
                        if (newStatus === 'Cancelled') {
                            toastr.success('Reservation cancelled and time slot is now available for others!');
                        } else {
                            toastr.success('Status updated successfully!');
                        }
                        location.reload(); // simplest way to refresh view state
                    } else {
                        toastr.error('Failed to update status!');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // 🧠 this shows exact error in console
                    toastr.error('Something went wrong with the request.');
                }
            });
        }


    </script>

@endsection
