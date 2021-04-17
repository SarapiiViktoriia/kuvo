    <header class="header">
        <div class="logo-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="{{ ucfirst(e(__('logo'))) . ' ' . config('app.name') }}" style="height: 35px;">
            </a>
            <div class="toggle-sidebar-left visible-xs" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div class="userbox" id="userbox">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="{{ asset('assets/images/!logged-user.jpg') }}" class="img-circle" alt="{{ ucwords(e(__(Auth::user()->name))) }}" style="height: 35px;">
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
                            <a href="{{ route('logout') }}" role="menuitem" tabindex="-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i> {{ ucfirst(e(__('keluar'))) }}
                            </a>
                            <form method="post" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
