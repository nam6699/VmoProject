<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
    <h1><span class="primary-text">Vmo</span>Tools</h1>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block text-uppercase">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('tool.index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Tools Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('request.index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Requests Management</p>
            </a>
          </li>
          @role('super admin')
          <li class="nav-item">
            <a href="{{route('user.index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Users Management</p>
            </a>
          </li>
          @endrole
          @role('super admin')
          <li class="nav-item">
            <a href="{{route('role.index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Roles Management</p>
            </a>
          </li>
         @endrole
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>