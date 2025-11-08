@extends('user.dashboard.dashboard')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="position-relative">
                        <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                            <img src="{{ asset('user/assets/images/pbg.jpg') }}"
                                 class="rounded-top"
                                 alt="profile cover"
                                 style="width: 100%; height: 200px; object-fit: cover;">
                        </figure>
                        <div class="d-flex justify-content-between align-items-center position-absolute w-100 px-2 px-md-4"
                             style="top: 160px;">
                            <div>
                                @php
                                    $user = App\Models\User::find(\Illuminate\Support\Facades\Auth::user()->id);
                                @endphp
                                <span class="h4 ms-3 text-light">{{ $user->name }}</span>
                            </div>

                        </div>
                    </div>

                    <div class="card-body pt-5 mt-4">
                        <h4 class="card-title mb-4">My Paid Reservations</h4>

                        @php
                            $reservations = \App\Models\Reservation::where('user_id', auth()->id())
                                ->where('status', 'paid')
                                ->with('consulter')
                                ->latest()
                                ->get();
                        @endphp

                        @if($reservations->isEmpty())
                            <p class="text-muted text-center mb-0">You have no paid reservations yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Consultant</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reservations as $index => $reserve)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $reserve->consulter->name ?? 'Unknown Consultant' }}</td>
                                            <td>{{ $reserve->date }}</td>
                                            <td>{{ $reserve->start_time }}</td>
                                            <td>{{ $reserve->end_time }}</td>
                                            <td>Our Consulter will be in touch with you</td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
