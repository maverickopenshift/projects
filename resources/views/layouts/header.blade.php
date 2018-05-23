<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    {{-- <a href="{!! url('/') !!}" class="logo">
      <img src="images/logo-2.png" title="{{env('APP_NAME')}}" />
    </a> --}}

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                @if(Modules\Users\Entities\UsersPgs::is_pgs())
                  <li class="user user-menu">
                      <!-- Menu Toggle Button -->
                      <a href="{{ route('pgs') }}" class="btn btn-block btn-danger">
                          <i class="fa fa-users"></i>
                          PGS
                      </a>
                  </li>
                @endif
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="{{ route('home.profile') }}" class="btn btn-block btn-danger">
                        <i class="fa fa-user"></i>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->name }}  </span>
                        <i>/ {{ session('nik') }} / {{ session('posisi') }} as 
                          @if(Auth::user()->roles[0]->name=="vendor")
                            (Supplier)
                          @else
                            ({{ Auth::user()->roles[0]->name }})
                          @endif
                           </i>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="{{ route('logout') }}" class="btn btn-block btn-danger">
                      <i class="fa fa-sign-out"></i>
                        Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
