<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          <li>
              <a href="{{url('/')}}">
                  <img src="{{asset('/images/logo.png')}}" alt="Consys">
              </a>
          </li>
            @permission('manajemen-dashboard')
            <li class="treeview {{Request::is("documents/dasboard")?'active':''}}">
                <a href="{{route('doc')}}"> <img src="{{asset('/images/icon-dashboard.png')}}" title="Dashboard" />
                    <span>Dashboard</span></a>
            </li>
            @endpermission
            @permission('lihat-template-pasal-pasal|lihat-kontrak|tambah-kontrak')
            <li class="treeview {{Request::is("documents/*") || Request::is("documents")?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-users.png')}}" title="Management Kontrak" />
                <span>Manajemen Kontrak</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                @permission('tambah-kontrak')
                  <li class="treeview {{Request::is("documents/create/*")?'active':''}}">
                    <a href="#"><span>Tambah Kontrak</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu ">
                      <li class="{{Request::is("documents/create/khs")?'active':''}}" ><a href="{{route('doc.create',['type'=>'khs'])}}">KHS</a></li>
                      <li class="{{Request::is("documents/create/turnkey")?'active':''}}" ><a href="{{route('doc.create',['type'=>'turnkey'])}}">Turnkey</a></li>
                      <li class="{{Request::is("documents/create/sp")?'active':''}}" ><a href="{{route('doc.create',['type'=>'sp'])}}">Surat Pesanan (SP)</a></li>
                      <li class="{{Request::is("documents/create/amandemen-sp")?'active':''}}" ><a href="{{route('doc.create',['type'=>'amandemen_sp'])}}">Amandemen (SP)</a></li>
                      <li class="{{Request::is("documents/create/amandemen-kontrak")?'active':''}}" ><a href="{{route('doc.create',['type'=>'amandemen_kontrak'])}}">Amandemen Kontrak</a></li>
                      <li class="#" ><a href="#">Adendum</a></li>
                      <li class="#" ><a href="#">Side Letter</a></li>
                    </ul>
                  </li>
                @endpermission
                @permission('lihat-kontrak')
                  <li class="{{Request::is("documents")?'active':''}}" ><a href="{{route('doc')}}">Data Kontrak</a></li>
                @endpermission
                @permission('lihat-template-pasal-pasal')
                  <li class="{{Request::is("documents/doc-template") || Request::is("documents/doc-template/create") || Request::is("documents/doc-template/*/edit")?'active':''}}" ><a href="{{route('doc.template')}}">Template Pasal - Pasal</a></li>
                @endpermission
              </ul>
            </li>
            @endpermission
            {{-- <li>
                <a href="#"> <img src="{{asset('/images/icon-search.png')}}" title="Search" />
                    <span>Search</span></a>
            </li>
            <li class="treeview {{Request::is("documents/create/*")?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-entry-new.png')}}" title="Entry Dokumen Baru" />
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
            </li> --}}

            {{-- <li>
                <a href="#"> <img src="{{asset('/images/icon-edit.png')}}" title="Perubahan Kontrak" />
                    <span>Perubahan Kontrak</span></a>
            </li>
            <li>
                <a href="#"> <img src="{{asset('/images/icon-entry.png')}}" title="Entry Document Perijinan" />
                    <span>Entry Document Perijinan</span></a>
            </li>

            <li class="treeview">
              <a href="#"><img src="{{asset('/images/icon-documents.png')}}" title="My Documents" />
                <span>My Documents</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Archive</a></li>
              </ul>
            </li> --}}
            @permission('lihat-user|lihat-role|lihat-permission')
            <li class="treeview {{Request::is("users/*") || Request::is("users")?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-users.png')}}" title="Management User" />
                <span>Manajemen User</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                @permission('lihat-user')
                  <li class="{{Request::is("users")?'active':''}}" ><a href="{{route('users')}}">Users</a></li>
                @endpermission

                @permission('lihat-role')
                <li class="{{Request::is("users/roles")?'active':''}}" ><a href="{{route('users.roles')}}">Roles</a></li>
                @endpermission

                @permission('lihat-permission')
                <li class="{{Request::is("users/permissions")?'active':''}}"><a href="{{route('users.permissions')}}">Permissions</a></li>
                @endpermission
              </ul>
            </li>
            @endpermission

            @permission('lihat-supplier|lihat-klasifikasi-usaha|lihat-badan-usaha')
            <li class="treeview {{Request::is("supplier/*") || Request::is("supplier")?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-users.png')}}" title="Management Supplier" />
                <span>Manajemen Supplier</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                @permission('lihat-supplier')
                  <li class="{{Request::is("supplier/create") || Request::is("supplier/*/edit") || Request::is("supplier")?'active':''}}" ><a href="{{route('supplier')}}">Supplier</a></li>
                @endpermission

                @permission('lihat-klasifikasi-usaha')
                  <li class="{{Request::is("supplier/klasifikasiusaha")?'active':''}}" ><a href="{{route('supplier.klasifikasi')}}">Klasifikasi Usaha</a></li>
                @endpermission

                @permission('lihat-badan-usaha')
                <li class="{{Request::is("supplier/badanusaha")?'active':''}}" ><a href="{{route('supplier.badanusaha')}}">Badan Usaha</a></li>
                @endpermission
              </ul>
            </li>
            @endpermission

            @role('vendor')
            <li class="treeview {{Request::is("usersupplier/*") || Request::is("supplierUser")?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-user.png')}}" title="Management Supplier" />
                <span>User Profile</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li class="{{Request::is("usersupplier/profileVendor")?'active':''}}" ><a href="{{route('profile')}}">Ubah Password</a></li>
                <li class="{{Request::is("usersupplier/dataSupplier")?'active':'' || Request::is("usersupplier/kelengkapanData")?'active':''}}" ><a href="{{route('supplier.list')}}">Kelengkapan Data</a></li>
              </ul>

            </li>
            @endrole
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
