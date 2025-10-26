@extends('consulter.dashboard.dashboard')

@section('content')


    <div class="page-content">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="position-relative">
                        <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                            <img src="{{ asset('../../../user/assets/images/pbg.jpg') }}"
                                 class="rounded-top"
                                 alt="profile cover"
                                 style="width: 100%; height: 200px">
                        </figure>
                        <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                            <div>
                                @php
                                    use Illuminate\Support\Facades\Auth;
                                    $consulter = Auth::guard('consulter')->user();
                                @endphp
                                <span class="h4 ms-3 text-light">{{$consulter->name}}</span>
                            </div>
                            <div class="d-none d-md-block">
                                <button class="btn btn-primary btn-icon-text">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="24"
                                         height="24"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-edit btn-icon-prepend">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

