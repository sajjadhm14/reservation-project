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
        // Toastr config (keep as you already added)
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "10000",
            "extendedTimeOut": "5000",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        function updateStatus(button, newStatus, submitId) {
            const $button = $(button);
            const $row = $button.closest('tr');
            $button.prop('disabled', true).text('Updating...');

            $.ajax({
                url: "{{ url('user/submit/post') }}/" + submitId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function (response) {
                    if (response.status === 200) {
                        // 1) Show toast
                        if (newStatus === 'Cancelled') {
                            toastr.success('Reservation Cancelled Successfully!');
                        } else {
                            toastr.success('Reservation Approved Successfully — please make it Paid!');
                        }

                        // 2) Update badge in the row
                        const $badge = $row.find('span.badge');
                        // remove all bg-* classes and add the one we need
                        $badge
                            .removeClass('bg-success bg-danger bg-primary bg-warning text-dark')
                            .addClass(
                                newStatus === 'Approved' ? 'bg-success' :
                                    newStatus === 'Cancelled' ? 'bg-danger' :
                                        newStatus === 'Paid' ? 'bg-primary' : 'bg-warning text-dark'
                            )
                            .text(newStatus);

                        // 3) Replace action buttons (keep markup similar to your blades)
                        let actionHtml = '';
                        if (newStatus === 'Approved') {
                            actionHtml = '<button class="btn btn-secondary btn-sm me-1" disabled>Approved</button>' +
                                '<button class="btn btn-danger btn-sm" onclick="updateStatus(this, \'Cancelled\', ' + submitId + ')">Cancel</button>';
                        } else if (newStatus === 'Cancelled') {
                            actionHtml = '<button class="btn btn-danger btn-sm" disabled>Cancelled</button>';
                        } else if (newStatus === 'Paid') {
                            actionHtml = '<button class="btn btn-primary btn-sm" disabled>Paid</button>';
                        } else {
                            actionHtml = '<button class="btn btn-success btn-sm me-1" onclick="updateStatus(this, \'Approved\', ' + submitId + ')">Approve</button>' +
                                '<button class="btn btn-danger btn-sm" onclick="updateStatus(this, \'Cancelled\', ' + submitId + ')">Cancel</button>';
                        }
                        $row.find('td').last().html(actionHtml);

                        // 4) restore original button text (if still present)
                        $button.prop('disabled', false).text(function(){
                            // safe fallback text — depends on button type
                            return (newStatus === 'Approved') ? 'Approve' : (newStatus === 'Cancelled' ? 'Cancel' : 'Update');
                        });

                    } else {
                        toastr.error('Failed to update status!');
                        $button.prop('disabled', false).text('Retry');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Something went wrong with the request.');
                    $button.prop('disabled', false).text('Retry');
                }
            });
        }
    </script>


@endsection
