<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{route('user.dashboard')}}" class="sidebar-brand">
            <span>Dashboard</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{route('user.dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('reservation')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Make Reservation</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('submit')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Submit Reservation</span>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="{{route('payment.index')}}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="box"></i>--}}
{{--                    <span class="link-title">Payment</span>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    </div>
</nav>
