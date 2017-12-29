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
                <a href="{{route('doc',['status'=>'selesai'])}}"> <img src="{{asset('/images/icon-dashboard.png')}}" title="Dashboard" />
                    <span>Dashboard</span></a>
            </li>
            @endpermission
            @permission('lihat-template-pasal-pasal|lihat-kontrak|tambah-kontrak')
            <li class="treeview {{Request::is("documents/*") || Request::is("documents")?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-users.png')}}" title="Management Kontrak" />
                <span>Manajemen Dokumen</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                @permission('tambah-kontrak')
                  <li class="treeview {{Request::is("documents/create/*")?'active':''}}">
                    <a href="#"><span>Buat Baru</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu ">
                      <li class="{{Request::is("documents/create/surat_pengikatan")?'active':''}}" ><a href="{{route('doc.create',['type'=>'surat_pengikatan'])}}">Surat Pengikatan</a></li>
                      <li class="{{Request::is("documents/create/khs")?'active':''}}" ><a href="{{route('doc.create',['type'=>'khs'])}}">KHS</a></li>
                      <li class="{{Request::is("documents/create/turnkey")?'active':''}}" ><a href="{{route('doc.create',['type'=>'turnkey'])}}">Turnkey</a></li>
                      <li class="{{Request::is("documents/create/sp")?'active':''}}" ><a href="{{route('doc.create',['type'=>'sp'])}}">Surat Pesanan (SP)</a></li>
                      <li class="{{Request::is("documents/create/amandemen_sp")?'active':''}}" ><a href="{{route('doc.create',['type'=>'amandemen_sp'])}}">Amandemen SP</a></li>
                      <li class="{{Request::is("documents/create/amandemen_kontrak")?'active':''}}" ><a href="{{route('doc.create',['type'=>'amandemen_kontrak'])}}">Amandemen Kontrak</a></li>
                      <li class="{{Request::is("documents/create/adendum")?'active':''}}" ><a href="{{route('doc.create',['type'=>'adendum'])}}">Addendum</a></li>
                      <li class="{{Request::is("documents/create/side_letter")?'active':''}}" ><a href="{{route('doc.create',['type'=>'side_letter'])}}">Side Letter</a></li>
                      <li class="{{Request::is("documents/create/mou")?'active':''}}" ><a href="{{route('doc.create',['type'=>'mou'])}}">MoU</a></li>
                    </ul>
                  </li>
                @endpermission

                @permission('lihat-kontrak')
                  @if(!Laratrust::hasRole('approver'))
                    <li class="{{Request::is("documents/status/draft")?'active':''}}" ><a href="{{route('doc',['status'=>'draft'])}}">Draft</a></li>
                  @endif
                  <li class="{{Request::is("documents/status/proses")?'active':''}}" ><a href="{{route('doc',['status'=>'proses'])}}">Perlu Diproses</a></li>
                @endpermission
                @permission('lihat-kontrak')
                  <li class="{{Request::is("documents/status/tracking")?'active':''}}" ><a href="{{route('doc',['status'=>'tracking'])}}">Tracking Proses</a></li>
                  <li class="{{Request::is("documents/status/selesai")?'active':''}}" ><a href="{{route('doc',['status'=>'selesai'])}}">Selesai</a></li>
                @endpermission
                @permission('lihat-template-pasal-pasal')
                  <li class="{{Request::is("documents/doc-template") || Request::is("documents/doc-template/create") || Request::is("documents/doc-template/*/edit")?'active':''}}" ><a href="{{route('doc.template')}}">Template Kontrak</a></li>
                @endpermission
              </ul>
            </li>
            @endpermission
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
                  <li class="{{Request::is("supplier/sap")?'active':''}}" ><a href="{{route('suppliersap')}}">Supplier SAP</a></li>
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

            @permission('lihat-catalog')
            <li class="treeview {{Request::is('catalog/*') ?'active':''}}">
              <a href="#"><img src="{{asset('/images/icon-user.png')}}" title="Catalog" />
                <span>Catalog</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                @permission('catalog-product')
                  <li class="{{Request::is('catalog/category') ?'active':''}}"><a href="{{route('catalog.category')}}">Category</a></li>
                @endpermission
                @permission('catalog-product')
                  <li class="{{Request::is('catalog/product') ?'active':''}}"><a href="{{route('catalog.product')}}">Product</a></li>
                @endpermission
                @permission('lihat-catalog')
                  <li class="{{Request::is('catalog/catalog_list') ?'active':''}}"><a href="{{route('catalog.list')}}">List Kategori & Product</a></li>
                @endpermission
              </ul>
            </li>
            @endpermission

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
