<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-icon">
        <!--<i class="fas fa-laugh-wink"></i>-->
        <!-- <img src = "http://dev.arfideveloper.com/xzit/public/app_icon.png" alt = "Logo" style = "width: 60px; height:45px;"> -->
    </div>
    <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('staff.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Staff Panel</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Interface
</div> -->

<!-- Nav Item - Pages Collapse Menu -->

<li class="nav-item">
    <a class="nav-link" href="{{route('staff.bookings.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>Bookings</span></a>
</li>

<!-- <li class="nav-item">
    <a class="nav-link" href="{{route('user.report.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>Report</span></a>
</li> -->

<li class="nav-item">
    <a class="nav-link" data-toggle="modal" data-target="#logoutModal" href="#">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span></a>
</li>


<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->

</ul>
<!-- End of Sidebar -->