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
    <a class="nav-link" href="{{ route('user.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Client Panel</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Interface
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="{{route('user.bookings.create')}}">
        <i class="fas fa-fw fa-users"></i>
        <span>Create New Notice</span></a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse"
        aria-expanded="true" aria-controls="collapse">
        <i class="fas fa-fw fa-list"></i>
        <span>Temporary Notices</span>
    </a>
    <div id="collapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">          
            <a class="collapse-item" href="{{route('user.temporary_intent')}}">Notice of Intent</a>
            <a class="collapse-item" href="{{route('user.temporary_making')}}">Notice of Making</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-list"></i>
        <span>Permanent Notices</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">          
            <a class="collapse-item" href="{{route('user.permanent_intent')}}">Notice of Intent</a>
            <a class="collapse-item" href="{{route('user.permanent_making')}}">Notice of Making</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{route('user.bookings.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>My All Notices</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{route('user.report.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>Report</span></a>
</li>

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