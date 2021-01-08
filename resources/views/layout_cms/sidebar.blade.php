<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#" target="_blank">School App</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#" target="_blank">SA</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Starter</li>
            <li class="{{ (request()->routeIs('majors*')) ? 'active' : '' }}">
                <a href="{{ route('majors.index') }}" class="nav-link">
                    <i class="fas fa-building"></i><span>Majors/Classes</span>
                </a>
            </li>
            <li class="{{ (request()->routeIs('students*')) ? 'active' : '' }}">
                <a href="{{ route('students.index') }}" class="nav-link">
                    <i class="fas fa-user"></i><span>Students</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
