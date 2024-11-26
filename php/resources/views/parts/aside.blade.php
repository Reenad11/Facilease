<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/dashboard') ? 'active2' : ''}}" href="{{route('admin.dashboard')}}"><i class="bi bi-grid"></i><span>Home</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/roomTypes*') ? 'active2' : ''}}" href="{{ route('admin.roomTypes.index') }}">
            <i class="bi bi-menu-button-wide"></i>
            <span>Room Types</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/rooms*') ? 'active2' : ''}}" href="{{ route('admin.rooms.index') }}">
            <i class="bi bi-house-door-fill"></i>
            <span>Rooms</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/feedbacks*') ? 'active2' : ''}}" href="{{ route('admin.feedbacks.index') }}">
            <i class="bi bi-star-fill"></i>
            <span>Feedbacks</span>
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/faculties*') ? 'active2' : ''}}" href="{{ route('admin.faculties.index') }}">
            <i class="bi bi-house"></i>
            <span>Faculties </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/reservations*') ? 'active2' : ''}}" href="{{ route('admin.reservations.index') }}">
            <i class="bi bi-calendar-check"></i>
            <span>Reservations </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/reports/reservation-utilization*') ? 'active2' : ''}}" href="{{ route('admin.reports.reservationUtilization') }}">
            <i class="bi bi-bar-chart"></i>
            <span>Reservation Utilization </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{request()->is('admin/reports/faculty-activity*') ? 'active2' : ''}}" href="{{ route('admin.reports.facultyActivity') }}">
            <i class="bi bi-bar-chart"></i>
            <span>Faculty Activity  </span>
        </a>
    </li>
</ul>
