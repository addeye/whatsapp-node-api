<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{request()->is('dashboard') ? 'active' : ''}}" aria-current="page"
                    href="/dashboard">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{request()->is('user*') ? 'active' : ''}}" href="/user">
                    <span data-feather="alert-octagon" class="align-text-bottom"></span>
                    User
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{request()->is('device*') ? 'active' : ''}}" href="/device">
                    <span data-feather="alert-octagon" class="align-text-bottom"></span>
                    Device
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{request()->is('group*') ? 'active' : ''}}" href="/group">
                    <span data-feather="alert-octagon" class="align-text-bottom"></span>
                    Group
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{request()->is('setting*') ? 'active' : ''}}" href="/setting">
                    <span data-feather="alert-octagon" class="align-text-bottom"></span>
                    Setting
                </a>
            </li>
        </ul>
    </div>
</nav>
