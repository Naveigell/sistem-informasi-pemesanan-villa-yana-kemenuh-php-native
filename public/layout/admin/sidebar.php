
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= route('admin.dashboard.index'); ?>">Villa</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= route('admin.dashboard.index'); ?>">Vl</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Home</li>
            <li><a class="nav-link" href="<?= route('admin.dashboard.index'); ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <li><a class="nav-link" href="<?= route('admin.testimonials.index'); ?>"><i class="fa fa-star"></i> <span>Testimoni</span></a></li>
            <li class="menu-header">Additional</li>
            <li><a class="nav-link" href="<?= route('admin.rooms.index'); ?>"><i class="fa fa-building"></i> <span>Kamar</span></a></li>
            <li class="menu-header">Promo</li>
            <li><a class="nav-link" href="<?= route('admin.promos.index'); ?>"><i class="fa fa-certificate"></i> <span>Promo</span></a></li>
            <li class="menu-header">Pemesanan</li>
            <li><a class="nav-link" href="<?= route('admin.orders.index'); ?>"><i class="fa fa-shopping-cart"></i> <span>Pemesanan</span></a></li>
            <li class="menu-header">Komplain</li>
            <li><a class="nav-link" href="<?= route('admin.complaints.index'); ?>"><i class="fa fa-envelope-open"></i> <span>Komplain</span></a></li>
            <li class="menu-header">Laporan</li>
            <li><a class="nav-link" href="<?= route('admin.reports.incomes.index'); ?>"><i class="fa fa-print"></i> <span>Laporan</span></a></li>
        </ul>
    </aside>
</div>