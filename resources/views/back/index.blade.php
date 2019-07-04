<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Huka</title>

    <!-- Fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <style>
      /* Theming */

      /* Primary color for the background */
      .gjs-one-bg {
        background-color: #363E46;
      }

      /* Secondary color for the text color */
      .gjs-two-color {
        color: rgba(246, 246, 246, 1);
      }

      /* Tertiary color for the background */
      .gjs-three-bg {
        background-color: #FC9627;
        color: white;
      }

      /* Quaternary color for the text color */
      .gjs-four-color,
      .gjs-four-color-h:hover {
        color: #FC9627;
      }

      /* Reset some default styling */
      .gjs-cv-canvas {
        top: 0;
        width: 100%;
        height: 100%;
      }
      .panel__top {
        padding: 0;
        width: 100%;
        height: 7%;
        min-height: 43px;
        max-height: 45px;
        display: flex;
        position: initial;
        justify-content: center;
        justify-content: space-between;
      }
      .panel__basic-actions {
        width: 9%;
        max-width: 126px;
        position: initial;
        border: 2px solid rgba(0,0,0,0.2);
      }

      .panel__devices {
        margin-left: 38%;
        position: initial;
      }

      .panel__options {
        margin-left: 20%;
        position: initial;
      }

      .panel__switcher {
        width: 20%;
        max-width: 200px;
        border: 2px solid rgba(0,0,0,0.2);
        position: initial;
      }

      .editor-row {
        display: flex;
        justify-content: flex-start;
        align-items: stretch;
        flex-wrap: nowrap;
        height: 100%;
      }

      .editor-canvas {
        flex-grow: 1;
      }

      .panel__right {
        flex-basis: 190px;
        position: relative;
        overflow-y: auto;
        height: 400px;
      }

      .pages-btn{
        width: 100%; 
        background: rgba(0,0,0,0.1); 
        color: white; 
        padding-right: 10px;
        outline: none; 
        border: 1px solid rgba(0,0,0,0.25);
      }
      .pages-btn:focus{
        background: rgba(255,255,255,0.1);
      }



      .step-vertical-menu {
        border-right: 1px solid #eaecf1;
      }

      .step-vertical-menu ul {
        margin: 0px;
        padding: 0px;
      }

      .step-vertical-menu ul>li {
        display: block;
        position: relative;
      }

      .step-vertical-menu ul>li>a {
        display: block;
        padding: 10px 5px 5px 35px;
        color: #333c4e;
        font-size: 17px;
      }

      .step-vertical-menu ul>li>a:before {
        content: '';
        position: absolute;
        width: 2px;
        height: calc(100% - 25px);
        background-color: #bdc2ce;
        left: 13px;
        bottom: -9px;
        z-index: 3;
      }

      .step-vertical-menu ul>li>a .ico {
        font-size: 14px;
        position: absolute;
        left: 10px;
        top: 15px;
        z-index: 2;
      }

      .step-vertical-menu ul>li>a:after {
        content: '';
        position: absolute;
        border: 2px solid #3490dc;
        border-radius: 50%;
        top: 14px;
        left: 6px;
        width: 16px;
        height: 16px;
        z-index: 3;
      }

      .step-vertical-menu ul>li>a .desc {
        display: block;
        color: #bdc2ce;
        font-size: 11px;
        letter-spacing: .9px;
      }

      .step-vertical-menu ul>li.complete>a:before {
        background-color: #5cb85c;
        opacity: 1;
        height: calc(100% - 25px);
        bottom: -9px;
      }

      .step-vertical-menu ul>li.complete>a:after {
        display:none;
      }
      .step-vertical-menu ul>li.locked>a:after {
        display:none;
      }
      .step-vertical-menu ul>li:last-child>a:before {
        display:none;
      }

      .step-vertical-menu ul>li.complete>a .ico {
        left: 8px;
      }

      .step-vertical-menu ul>li>a .ico.ico-green {
        color: #5cb85c;
      }

      .step-vertical-menu ul>li>a .ico.ico-muted {
        color: #bdc2ce;
      }

      .step-vertical-menu ul>li.current {
        background-color: #fff;
      }

      .step-vertical-menu ul>li.current>a:before {
        background-color: #3490dc;
        opacity: 1;
      }

      .step-vertical-menu ul>li.current>a:after {
        border-color: #3490dc;
        background-color: #3490dc;
        opacity: 1;
      }

      .step-vertical-menu ul>li.current:after, .step-vertical-menu ul>li.current:before {
        left: 100%;
        top: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
      }

      .step-vertical-menu ul>li.current:after {
        border-color: rgba(255,255,255,0);
        border-left-color: #fff;
        border-width: 10px;
        margin-top: -10px;
      }

      .step-vertical-menu ul>li.current:before {
        border-color: rgba(234,236,241,0);
        border-left-color: #eaecf1;
        border-width: 11px;
        margin-top: -11px;
      }
      
    </style>
  </head>
  <body id="page-top"  >
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dash.init') }}">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="icon-fa-huka"></i>
          </div>
          <div class="sidebar-brand-text mx-3">
            huka
          </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dash.init') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          <i class="far fa-eye fa-lg"></i> Interfaces
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ (request()->is('admin/dashboard/pages')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dash.pages') }}">
            <span>Pages</span>
          </a>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item {{ (request()->is('admin/dashboard/layouts')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dash.layouts') }}">
            <span>Layouts</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          <i class="fas fa-puzzle-piece fa-lg"></i> Addons
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ (request()->is('admin/dashboard/products/modules')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dash.products') }}">
            <span>Modules</span>
          </a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item {{ (request()->is('admin/dashboard/products/templates')) ? 'active' : '' }}">
          <a class="nav-link" href="#">
            <span>Templates</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          <i class="fas fa-fw fa-cog"></i> Advanced parameters
        </div>

        <li class="nav-item">
          <a class="nav-link" href="#">
            <span>Información</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>
           <!--<button class="rounded-circle border-0" id="sidebarToggle"></button> -->
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-secondary rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>

              <!-- Nav Item - Messages -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="{{ route('select.editor') }}">
                  Edit Web
                  <span class="ml-2"><i class="far fa-edit"></i></span>
                </a>
              </li>

              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                @if(Auth::guard('admins')->user())
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::guard('admins')->user()->firstname }} {{ Auth::guard('admins')->user()->lastname }}
                    <span class="ml-2"><i class="far fa-user-circle fa-lg"></i></span>
                  </a>
                @endif

                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                </div>
              </li>

            </ul>

          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Content -->
              <main role="main" class="mb-3">
                @yield('dash-content')
              </main>
            <!-- End Content -->

          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Huka 2019</span>
            </div>
          </div>
        </footer>

        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->
    </div>

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <form action="{{ route('admin.logout') }}" method="post">
              @csrf
              <button class="btn btn-primary">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom scripts for all pages-->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/test.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    <script type="text/javascript">
      
      function alert(message, action){
        var value = confirm(message);
        if (value == true) {
          window.location.href = action;
        }
      }
      $(document).ready(function() {
        $('.data-table').DataTable({
          searching: false,
          lengthChange: false,
          orderCellsTop: true,
          fixedHeader: true
        });
      });

    </script>

    @stack('extra_scripts')

  </body>
</html>
