@if($errors->has('name') || $errors->has('addr') || $errors->has('fulladdr') || $errors->has('phone') || $errors->has('fax'))
<script>setTimeout(()=>{
  document.getElementById('addmedd').click();
  },1000)</script>
@endif
@if($errors->has('testname') || $errors->has('type'))
<script>setTimeout(()=>{
  document.getElementById('addtestt').click();
  },1000)</script>
@endif

<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/dashboard" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" title="Full screen" data-widget="fullscreen" href="#" role="button">
            <box-icon name='expand'></box-icon>
          </a>
        </li>

        <li class="nav-item">
        <a class="nav-link" title="Logout"  data-toggle="modal" data-target="#logout">
          <box-icon name='log-out'></box-icon>
        </a>
        </li>
      </ul>
    </nav>
    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Alert!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          Are you sure you want logout?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <a href="/signout" type="button" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->

      <!-- Sidebar -->
      <div class="sidebar mt-1">
        <!-- Sidebar user (optional) -->

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
                  <a href="/dashboard" class="nav-link  @if(Route::currentRouteName()=='dashboard') active @endif"">
                    <i class="fas fa-chart-line"></i>
                    <p>
                      Dashboard
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                    <a href="/account/user" class="nav-link  @if(Route::currentRouteName()=='accountuser') active @endif"">
                        <i class="fas fa-user-edit"></i>
                      <p>
                        Update Profile
                      </p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/account/password" class="nav-link  @if(Route::currentRouteName()=='accountpass') active @endif"">
                        <i class="fas fa-user-cog"></i>
                      <p>
                        Edit Password
                      </p>
                    </a>
                  </li>


                @if(Session::has('permission.5'))
                 <li class="nav-item">
                  <a href="/new/task" class="nav-link  @if(Route::currentRouteName()=='newtask') active @endif"">
                    <i class="fas fa-plus-circle"></i>
                    <p>
                      New Task
                    </p>
                  </a>
                </li>
                @endif

            @if(Session::has('permission.6') ||  Session::has('permission.7') || Session::has('permission.8') || Session::has('permission.9') || Session::has('permission.10') || Session::has('permission.11') || Session::has('permission.12'))
            <li class="nav-item   @if(Route::currentRouteName()=='accepted' || Route::currentRouteName()=='rejected'|| Route::currentRouteName()=='pending' || Route::currentRouteName()=='last' || Route::currentRouteName()=='dailytask'  || Route::currentRouteName()=='findtask' || Route::currentRouteName()=='waitingtask' || Route::currentRouteName()=='returnedonline' || Route::currentRouteName()=='waitinglast') menu-open @endif">
              <a href="#" class="nav-link @if(Route::currentRouteName()=='accepted' || Route::currentRouteName()=='rejected'|| Route::currentRouteName()=='pending' || Route::currentRouteName()=='last' || Route::currentRouteName()=='dailytask'   || Route::currentRouteName()=='findtask' ) active @endif">
                <i class="fas fa-tasks"></i>
                <p>
                  Medical Examinations
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                @if(Session::has('permission.7'))
                <li class="nav-item">
                  <a href="/task/accepted" class="nav-link @if(Route::currentRouteName()=='accepted') active @endif">
                    <i class="far fa-check-circle" style="color: green"></i>
                    <p>Accepted</p>
                    <span class="right badge bg-gradient-success badge-success">{{ DB::table('task')->where('Status','Accepted')->count() }}</span>
                  </a>
                </li>
                @endif

                @if(Session::has('permission.8'))
                <li class="nav-item">
                  <a href="/task/rejected" class="nav-link @if(Route::currentRouteName()=='rejected') active @endif">
                    <i class="far fa-times-circle" style="color: red"></i>
                    <p>Rejected</p>
                    <span class="right badge bg-gradient-danger badge-danger">{{ DB::table('task')->where('Status','Rejected')->count() }}</span>
                  </a>
                </li>
                @endif

                @if(Session::has('permission.6'))
                    <li class="nav-item">
                        <a href="/task/waiting" class="nav-link @if(Route::currentRouteName()=='waitingtask' || Route::currentRouteName()=='waitinglast') active @endif">
                          <i class="fas fa-hourglass-half" style="color:rgb(204, 229, 255)"></i>
                          <p>Waiting</p>
                          <span class="right badge bg-gradient-secondary badge-warning text-white">{{ DB::table('request')->where('Status','waiting')->count() }}</span>
                        </a>
                      </li>
                @endif

                @if(Session::has('permission.12'))
                <li class="nav-item">
                  <a href="/task/pending" class="nav-link @if(Route::currentRouteName()=='pending' || Route::currentRouteName()=='last') active @endif">
                    <i class="far fa-pause-circle" style="color:rgb(255, 196, 0)"></i>
                    <p>Pending</p>
                    <span class="right badge bg-gradient-warning badge-warning text-white">{{ DB::table('request')->where('Status','requested')->count() }}</span>
                  </a>
                </li>
                @endif

                @if(Session::has('permission.9'))
                <li class="nav-item">
                    <a href="/task/returned/online" class="nav-link @if(Route::currentRouteName()=='returnedonline') active @endif">
                        <i class="fas fa-undo" style="color: red"></i>
                      <p>Returned</p>
                      <span class="right badge bg-gradient-danger badge-danger">{{ DB::table('RequestReturn')->count() }}</span>
                    </a>
                </li>
                @endif

                @if(Session::has('permission.10'))
	            <li class="nav-item">
                  <a href="/task/daily" class="nav-link  @if(Route::currentRouteName()=='dailytask') active @endif"">
                    <i class="fas fa-calendar-day text-info"></i>
                    <p>
                      Daily
                    </p>
		              <span class="right badge bg-gradient-info  badge-info text-white">{{ App\Models\Requested::whereDate('created_at', '=', date('Y-m-d'))->count() }}</span>
                  </a>
                </li>
                @endif

                @if(Session::has('permission.11'))
                <li class="nav-item">
                  <a href="/task/find" class="nav-link  @if(Route::currentRouteName()=='findtask') active @endif"">
                    <i class="fas fa-search text-primary"></i>
                    <p>
                      Find
                    </p>
                    <span class="right badge bg-gradient-primary badge-primary text-white">{{ App\Models\Task::count()+App\Models\Requested::count() }}</span>
                  </a >
                </li>
                @endif

              </ul>
            </li>
            @endif

            @if(Session::has('permission.15'))
                <li class="nav-item">
                    <a href="/list/medical/center" class="nav-link  @if(Route::currentRouteName()=='listmedicalcenters') active @endif"">
                      <i class="fas fa-hospital"></i>
                      <p>
                        Medical Centers
                      </p>
                    </a>
                  </li>
            @endif

            @if (Session::has('permission.16'))
                <li class="nav-item">
                    <a href="/list/tests" class="nav-link  @if(Route::currentRouteName()=='listtests') active @endif"">
                      <i class="fas fa-vial"></i>
                      <p>
                        Medical Tests
                      </p>
                    </a>
                </li>
            @endif
                @if(Session::has('permission.1'))
                <li class="nav-item">
                    <a href="/register/user" class="nav-link  @if(Route::currentRouteName()=='registeruser') active @endif"">
                      <i class="fas fa-user-plus"></i>
                      <p>
                        Registration
                      </p>
                    </a>
                </li>
                @endif

                @if(Session::has('permission.2'))
                <li class="nav-item">
                    <a href="/list/staffs" class="nav-link  @if(Route::currentRouteName()=='liststaffs' || Route::currentRouteName()=='editStaff') active @endif">
                      <i class="fas fa-user-friends"></i>
                      <p>
                        Staffs
                      </p>
                    </a>
                </li>
                @endif

                @if(Session::has('permission.3'))
                <li class="nav-item">
                    <a href="/list/users" class="nav-link  @if(Route::currentRouteName()=='listusers' || Route::currentRouteName()=='editUser') active @endif"">
                      <i class="fas fa-users"></i>
                      <p>
                        University Professors
                      </p>
                    </a>
                </li>
                @endif

                @if(Session::has('permission.4'))
                <li class="nav-item">
                    <a href="/app/settings" class="nav-link  @if(Route::currentRouteName()=='appsettings') active @endif"">
                      <i class="fas fa-cog"></i>
                      <p>
                        Settings
                      </p>
                    </a>
                </li>
                @endif




          </ul>

        </nav>
        <!-- /.sidebar-menu -->
      </div>

    </aside>

