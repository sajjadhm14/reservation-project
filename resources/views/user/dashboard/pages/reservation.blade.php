@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Consultants List</h4>

                        <div class="d-flex flex-column gap-3">
                            {{-- Consultant Card --}}
                            @foreach($consulters as $key => $consulter)
                                <div class="card shadow-sm w-100">
                                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                        <div>
                                            <h5 class="card-title mb-4">{{ $consulter->name }}</h5>
                                            <p class="card-text text-muted mb-2">{{ $consulter->specialty }}</p>
                                        </div>
                                        <div class="mt-3 mt-md-0">
                                            <button type="button"
                                                    class="btn btn-primary px-4 py-2 fw-bold btn-reserve"
                                                    data-id="{{ $consulter->id }}"
                                                    data-name="{{ $consulter->name }}"
                                                    style="font-size: 15px;">
                                                Reserve
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Available times --}}
                                    <div class="available-times d-none" id="times-{{ $consulter->id }}">
                                        @foreach($calenders->where('consulter_id', $consulter->id) as $calender)
                                            <div class="time-slot"
                                                 data-date="{{ \Carbon\Carbon::parse($calender->date)->format('Y-m-d') }}"
                                                 data-start="{{ $calender->start_time }}"
                                                 data-end="{{ $calender->end_time }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            {{-- /Consultant Card --}}
                        </div>

                        <!-- Reservation Modal -->
                        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reservationModalLabel">Available Times</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="availableTimes" class="row g-3"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Reservation Modal -->

                        <!-- Hidden Template -->
                        <template id="timeSlotTemplate">
                            <div class="col-md-4">
                                <div class="card border shadow-sm text-center p-3 available-slot" style="cursor:pointer;">
                                    <h6 class="mb-1 slot-date"></h6>
                                    <p class="text-muted mb-2 slot-time"></p>
                                    <button type="button" class="btn btn-sm btn-outline-primary reserve-slot-btn">Reserve</button>
                                </div>
                            </div>
                        </template>
                        <!-- /Hidden Template -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const reservationModalEl = document.getElementById('reservationModal');
            const reservationModal = new bootstrap.Modal(reservationModalEl);

            // Show modal on Reserve button click
            $(document).on('click', '.btn-reserve', function () {
                const consulterId = $(this).data('id');
                const consulterName = $(this).data('name');

                $('#reservationModalLabel').text('Available Times for ' + consulterName);
                $('#availableTimes').empty();

                const slots = $(`#times-${consulterId} .time-slot`);
                const template = document.getElementById('timeSlotTemplate').content;

                slots.each(function () {
                    const date = $(this).data('date');
                    const start = $(this).data('start');
                    const end = $(this).data('end');

                    const clone = document.importNode(template, true);
                    const $card = $(clone).find('.available-slot');

                    $card.attr({
                        'data-date': date,
                        'data-start': start,
                        'data-end': end,
                        'data-consulter-id': consulterId
                    });

                    $card.find('.slot-date').text(date);
                    $card.find('.slot-time').text(`${start} - ${end}`);

                    $('#availableTimes').append($card.closest('.col-md-4'));
                });

                reservationModal.show();
            });

            // Handle reservation click inside modal
            $(document).on('click', '.reserve-slot-btn', function () {
                const $btn = $(this);
                const card = $btn.closest('.available-slot');
                const date = card.data('date');
                const start = card.data('start');
                const end = card.data('end');
                const consulterId = card.data('consulter-id');

                $btn.prop('disabled', true).text('Reserving...');

                fetch("{{ route('reservation.post') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        consulter_id: consulterId,
                        date: date,
                        start_time: start,
                        end_time: end
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(`Reserved for ${date} (${start} - ${end})`);
                            card.closest('.col-md-4').fadeOut(300, function () { $(this).remove(); });
                        } else {
                            toastr.error(data.message || 'Reservation failed!');
                        }
                    })
                    .catch(() => toastr.error('Something went wrong!'))
                    .finally(() => $btn.prop('disabled', false).text('Reserve'));
            });
        });
    </script>
@endsection
