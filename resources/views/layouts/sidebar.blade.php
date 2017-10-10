<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          <li>
              <a href="{{url('/')}}">
                  <img src="{{url('/images/logo.png')}}" alt="Consys">
              </a>
          </li>
            <li class="treeview {{Request::is("documents")?'active':''}}">
                <a href="{{route('doc')}}"> <img src="{{url('/images/icon-dashboard.png')}}" title="Dashboard" />
                    <span>Dashboard</span></a>
            </li>
            <li>
                <a href="#"> <img src="{{url('/images/icon-search.png')}}" title="Search" />
                    <span>Search</span></a>
            </li>
            <li class="treeview {{Request::is("documents/create/*")?'active':''}}">
              <a href="#"><img src="{{url('/images/icon-entry-new.png')}}" title="Entry Dokumen Baru" />
                <span>Entry Dokumen Baru</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu  {{Request::is("documents/create/*")?'menu-open':''}}">
                <li class="{{Request::is("documents/create/kontrak")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'kontrak'])}}">Kontrak</a></li>
                <li class="{{Request::is("documents/create/mou")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'mou'])}}">MoU</a></li>
                <li class="{{Request::is("documents/create/nda")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'nda'])}}">NDA</a></li>
                <li class="{{Request::is("documents/create/nota_kesepakatan")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'nota_kesepakatan'])}}">Nota Kesepakatan</a></li>
                <li class="{{Request::is("documents/create/berita_acara")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'berita_acara'])}}">Berita Acara</a></li>
                <li class="{{Request::is("documents/create/settlemet_agreement")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'settlemet_agreement'])}}">Settlement Agreement</a></li>
                <li class="{{Request::is("documents/create/engagement_letter")?'active':''}}">
                  <a href="{{route('doc.create',['type'=>'engagement_letter'])}}">Engagement Letter</a></li>
              </ul>
            </li>

            <li>
                <a href="#"> <img src="{{url('/images/icon-edit.png')}}" title="Perubahan Kontrak" />
                    <span>Perubahan Kontrak</span></a>
            </li>
            <li>
                <a href="#"> <img src="{{url('/images/icon-entry.png')}}" title="Entry Document Perijinan" />
                    <span>Entry Document Perijinan</span></a>
            </li>

            <li class="treeview">
              <a href="#"><img src="{{url('/images/icon-documents.png')}}" title="My Documents" />
                <span>My Documents</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Archive</a></li>
              </ul>
            </li>
            <li class="treeview {{Request::is("users/*") || Request::is("users")?'active':''}}">
              <a href="#"><img src="{{url('/images/icon-users.png')}}" title="Management User" />
                <span>Management User</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li class="{{Request::is("users")?'active':''}}" ><a href="{{route('users')}}">Users</a></li>
                <li class="{{Request::is("users/roles")?'active':''}}" ><a href="{{route('users.roles')}}">Roles</a></li>
                <li class="{{Request::is("users/permissions")?'active':''}}"><a href="{{route('users.permissions')}}">Permissions</a></li>
              </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
