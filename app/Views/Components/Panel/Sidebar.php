<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('panel/') ?>">
    <div class="sidebar-brand-icon">
      <i class="fas fa-store-alt"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Panel Toko</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= ($activeMenu == '1') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('panel/') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Produk
</div>

<li class="nav-item <?= ($activeMenu == '2.1') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('panel/produk') ?>"><i class="fas fa-box"></i>&nbsp;<span>Daftar Produk</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<?php if(in_groups('admin')) : ?>
<div class="sidebar-heading">
    Toko
</div>

<li class="nav-item <?= ($activeMenu == '3.1') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('panel/daftar-toko') ?>"><i class="fas fa-store"></i></i>&nbsp;<span>Daftar Toko</span></a>
</li>

<li class="nav-item <?= ($activeMenu == '3.2') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('panel/toko-pending') ?>"><i class="fas fa-envelope-open-text"></i>&nbsp;<span>Pengajuan Toko</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php endif; ?>

<div class="sidebar-heading">
    Catalog
</div>

<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/catalog') ?>"><i class="fas fa-home"></i>&nbsp;<span>Kembali</span></a>
</li>

<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->