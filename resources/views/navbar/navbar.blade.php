 <div id="layoutSidenav_nav">
     <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
         <div class="sb-sidenav-menu">
             <div class="nav">
                 <div class="sb-sidenav-menu-heading">Core</div>
                 <a class="nav-link {{ Request::segment(2) == '' ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Dashboard
                 </a>
                 <a class="nav-link {{ Request::segment(1) == 'master' ? 'active' : '' }} collapsed" href="#"
                     data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false"
                     aria-controls="collapseLayouts">
                     <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                     Master Data
                     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                 </a>
                 <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                     data-bs-parent="#sidenavAccordion">
                     <nav class="sb-sidenav-menu-nested nav">
                         <a class="nav-link {{ Request::segment(2) == 'daftar-barang' ? 'active' : '' }}"
                             href="{{ url('/master/daftar-barang') }}">Data Barang</a>
                         <a class="nav-link {{ Request::segment(2) == 'daftar-supplier' ? 'active' : '' }}"
                             href=" {{ url('/master/daftar-supplier') }} ">Data Suppliers</a>
                     </nav>
                 </div>
                 <a class="nav-link {{ Request::segment(2) == 'kasir' ? 'active' : '' }}"
                     href="{{ url('dashboard/kasir') }}">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Kasir
                 </a>
                 <div class="sb-sidenav-menu-heading">Addons</div>
                 <a class="nav-link" href="charts.html">
                     <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                     Charts
                 </a>
                 <a class="nav-link" href="tables.html">
                     <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                     Tables
                 </a>
             </div>
         </div>
         <div class="sb-sidenav-footer">
             <div class="small">Logged in as:</div>
             Start Bootstrap
         </div>
     </nav>
 </div>
