    <header class="header">
        <div class="logo-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="35">
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div class="userbox" id="userbox">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture">
                        <img class="img-circle" src="{{ asset('assets/images/!logged-user.jpg') }}" alt="">
                    </figure>
                    <div class="profile-info" data-lock-name="{{ Auth::user()->name }}" data-lock-email="{{ Auth::user()->email }}">
                        <span class="name">{{ Auth::user()->name }}</span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" role="menuitem" tabindex="-1" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Keluar</a>
                            <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
