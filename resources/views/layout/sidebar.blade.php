<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('assets/images/logo.png') }}" alt="">&nbsp;<img src="{{ asset('assets/images/logo_name.png') }}" alt="Logo"
                            srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                @if (Auth::user()->role == 'admin')
                    <li class="sidebar-item">
                        <a href="/admin/dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/admin/data-lahan" class='sidebar-link'>
                            <i class="bi bi-map-fill"></i>
                            <span>Data Seluruh Lahan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/admin/manage-user" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Manage User</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item">
                        <a href="/user/dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/user/data-lahan" class='sidebar-link'>
                            <i class="bi bi-map-fill"></i>
                            <span>Data Lahan</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a href="/logout" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
