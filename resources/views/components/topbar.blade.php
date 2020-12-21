    <header class="header">
        <div class="logo-container">
            <a href="#" class="logo"><img src="{{ asset('img/logo.png') }}" alt="" height="35"></a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div class="userbox" id="userbox">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture">
                        <img class="img-circle" src="{{ asset('img/user.jpg') }}" alt="">
                    </figure>
                    <div class="profile-info" data-lock-name="Anonim" data-lock-email="email@non.im">
                        <span class="name">Anonim</span>
                        <span class="role">Administrator</span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>
                        <li>
                            <a href="#" role="menuitem" tabindex="-1"><i class="fa fa-user"></i> Profilku</a>
                        </li>
                        <li>
                            <a href="#" role="menuitem" tabindex="-1"><i class="fa fa-power-off"></i> Keluar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
