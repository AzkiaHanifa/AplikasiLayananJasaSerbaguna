<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('admin/dashboard') ? 'bg-primary' : '' }}"
                        href="/admin/dashboard" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('admin/transaksi') ? 'bg-primary' : '' }}"
                        href="/admin/transaksi" aria-expanded="false"><i class="fa-solid fa-car me-2"></i><span
                            class="hide-menu">Transaksi</span></a></li>
                <li class="sidebar-item"> <a
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('admin/mitra') ? 'bg-primary' : '' }}"
                        href="/admin/mitra" aria-expanded="false"><i class="fa-solid fa-receipt me-2"></i><span
                            class="hide-menu">Mitra / Jasa</span></a></li>
                <li class="sidebar-item"> <a
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('admin/kategori-jasa') ? 'bg-primary' : '' }}"
                        href="/admin/kategori-jasa" aria-expanded="false"><i class="fa-solid fa-address-card me-2"></i><span
                            class="hide-menu">Kategori Jasa</span></a></li>
                <li class="sidebar-item"> <a
                        class="sidebar-link waves-effect waves-dark sidebar-link {{ Request::is('admin/user') ? 'bg-primary' : '' }}"
                        href="/admin/user" aria-expanded="false"><i class="fa-solid fa-user me-2"></i><span
                            class="hide-menu">User</span></a></li>
                {{-- <li class="text-center p-40 upgrade-btn">
                    <a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/"
                        class="btn d-block w-100 btn-danger text-white" target="_blank">Upgrade to Pro</a>
                </li> --}}
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
