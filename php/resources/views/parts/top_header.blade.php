<div class="d-flex align-items-center justify-content-between">
    <a href="#" class="logo d-flex align-items-center">
        <img style="    max-height: 57px;" src="{{ asset('logo.png') }}" alt="">
    </a>

    @if(auth('faculty')->check())
        <a href="{{route('faculty.dashboard')}}" class="hItem">
            <span class="d-none d-lg-block"><i class="bx bx-home"></i>Home</span>
        </a>
        <a href="{{route('faculty.dashboard')}}" class="hItem">
            <span class="d-none d-lg-block"><i class="bi bi-house-door"></i> Rooms</span>
        </a>
    @else
        <i class="bi bi-list toggle-sidebar-btn"></i>
    @endif
</div>
<div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
            </a>
        </li><!-- End Search Icon-->
        @auth('admin')
        <li class="nav-item dropdown">
            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                @php
                    $unreadCount = \App\Models\Notification::where('status', 'unread')->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="badge bg-primary badge-number">{{ $unreadCount }}</span>
                @endif
            </a><!-- End Notification Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                <li class="dropdown-header">
                    You have {{ $unreadCount }} new notifications
                    <a href="{{ route('admin.notifications.index') }}">
                        <span class="badge rounded-pill bg-primary p-2 ms-2">View all</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>

                @foreach(\App\Models\Notification::where('status', 'unread')->orderBy('date_time', 'desc')->take(5)->get() as $notification)
                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>{{ $notification->faculty->fullname ?? 'System' }}</h4>
                            <p>{{ $notification->message }}</p>
                            <p>{{ $notification->date_time}}</p>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                @endforeach

                @if($unreadCount === 0)
                    <li class="notification-item text-center">No new notifications</li>
                @else
                    <li class="dropdown-footer">
                        <a href="{{ route('admin.notifications.index') }}">Show all notifications</a>
                    </li>
                @endif
            </ul><!-- End Notification Dropdown Items -->
        </li>
        @endauth

        {{--        <li class="nav-item dropdown">--}}
        {{--            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">--}}
        {{--                <i class="bi bi-chat-left-text"></i>--}}
        {{--                <span class="badge bg-success badge-number">3</span>--}}
        {{--            </a><!-- End Messages Icon -->--}}

        {{--            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">--}}
        {{--                <li class="dropdown-header">--}}
        {{--                    You have 3 new messages--}}
        {{--                    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>--}}
        {{--                </li>--}}
        {{--                <li>--}}
        {{--                    <hr class="dropdown-divider">--}}
        {{--                </li>--}}
        {{--                <li class="message-item">--}}
        {{--                    <a href="#">--}}
        {{--                        <img src="{{ asset('assets/img/messages-3.jpg') }}" alt="" class="rounded-circle">--}}
        {{--                        <div>--}}
        {{--                            <h4>David Muldon</h4>--}}
        {{--                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>--}}
        {{--                            <p>8 hrs. ago</p>--}}
        {{--                        </div>--}}
        {{--                    </a>--}}
        {{--                </li>--}}
        {{--                <li>--}}
        {{--                    <hr class="dropdown-divider">--}}
        {{--                </li>--}}
        {{--                <li class="dropdown-footer">--}}
        {{--                    <a href="#">Show all messages</a>--}}
        {{--                </li>--}}

        {{--            </ul><!-- End Messages Dropdown Items -->--}}

        {{--        </li><!-- End Messages Nav -->--}}

        <li class="nav-item dropdown pe-3">
            @auth('admin')
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth('admin')->user()->fullname }}</h6>
                        <span>Admin</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Profile Link -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.showProfile') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Logout -->
                    <li>
                        <a onclick="confirmLogout(event,'logoutForm')" class="dropdown-item d-flex align-items-center"
                           href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logoutForm" action="{{ route('auth.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_type" value="admin">
                        </form>
                    </li>
                </ul>
            @endauth
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/img/profile.png') }}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">Welcome</span>
            </a>
            @auth('admin')
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth('admin')->user()->fullname }}</h6>
                        <span>Admin</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Profile Link -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.showProfile') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Logout -->
                    <li>
                        <a onclick="confirmLogout(event,'logoutForm')" class="dropdown-item d-flex align-items-center"
                           href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logoutForm" action="{{ route('auth.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_type" value="admin">
                        </form>
                    </li>
                </ul>
            @endauth

            @auth('student')
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{auth('student')->user()->fullname}}</h6>
                        <span>Admin</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('student.showProfile')}}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a onclick="confirmLogout(event,'logoutForm')" class="dropdown-item d-flex align-items-center"
                           href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logoutForm" action="{{route('auth.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_type" value="admin">
                        </form>
                    </li>
                </ul>
            @endauth

            @auth('faculty')
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{auth('faculty')->user()->fullname}}</h6>
                        <span>faculty</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('faculty.showProfile')}}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a onclick="confirmLogout(event,'logoutForm')" class="dropdown-item d-flex align-items-center"
                           href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        <form id="logoutForm" action="{{route('auth.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_type" value="faculty">
                        </form>
                    </li>
                </ul>
            @endauth
        </li>
    </ul>
</nav>
