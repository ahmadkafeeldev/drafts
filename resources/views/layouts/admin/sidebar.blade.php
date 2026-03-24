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
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Admin Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Interface
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="{{route('admin.users.index')}}">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span></a>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{route('admin.staff.index')}}">
        <i class="fas fa-fw fa-users"></i>
        <span>Staff</span></a>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{route('admin.borough.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>Borough</span></a>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{route('admin.news_groups.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>News Groups</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{route('admin.news_papers.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>News Papers</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{route('admin.area.index')}}">
        <i class="fas fa-fw fa-list"></i>
        <span>Area's</span></a>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
        aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-fw fa-list"></i>
        <span>PLO Bookings</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="collapseOne" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">          
            <a class="collapse-item" href="{{route('admin.plo_index')}}">Pending</a>
            <a class="collapse-item" href="{{route('admin.plo_processing_bookings')}}">Processing</a>
            <a class="collapse-item" href="{{route('admin.plo_completed_bookings')}}">Completed</a>
            <a class="collapse-item" href="{{route('admin.plo_cancelled_bookings')}}">Cancelled</a>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-list"></i>
        <span>Processing Order Bookings</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">          
            <a class="collapse-item" href="{{route('admin.bookings.index')}}">Pending</a>
            <a class="collapse-item" href="{{route('admin.processing_bookings')}}">Processing</a>
            <a class="collapse-item" href="{{route('admin.completed_bookings')}}">Completed</a>
            <a class="collapse-item" href="{{route('admin.cancelled_bookings')}}">Cancelled</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link collapsed disabled" href="#" data-toggle="collapse" data-target="#collapseThree"
        aria-expanded="true" aria-controls="collapseThree">
        <i class="fas fa-fw fa-list"></i>
        <span>Draft Order Bookings</span>
    </a>
    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">          
            <a class="collapse-item" href="{{route('admin.bookings.index')}}">Pending</a>
            <a class="collapse-item" href="{{route('admin.processing_bookings')}}">Processing</a>
            <a class="collapse-item" href="{{route('admin.completed_bookings')}}">Completed</a>
            <a class="collapse-item" href="{{route('admin.cancelled_bookings')}}">Cancelled</a>
        </div>
    </div>
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
