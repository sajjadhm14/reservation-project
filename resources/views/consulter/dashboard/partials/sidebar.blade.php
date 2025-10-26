<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{route('consulter.dashboard')}}" class="sidebar-brand">
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
                <a href="{{route('consulter.dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="{{route('consulter.calender')}}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="box"></i>--}}
{{--                    <span class="link-title">Calender</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{route('check.reservation')}}" class="nav-link">--}}
{{--                    <i class="link-icon" data-feather="box"></i>--}}
{{--                    <span class="link-title">Check Reservation</span>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    </div>
</nav>
