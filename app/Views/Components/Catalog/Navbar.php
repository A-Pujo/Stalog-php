<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand navbar-light shadow" style="background-color: rgba(255, 255, 255, 0.3);">
    <a class="navbar-brand d-flex" href="<?= base_url() ?>">
        <img src="<?= base_url('/assets/img/banner-ls.png') ?>" width="30" height="30" alt="">
        <span class="align-self-center">&nbsp;Lapak Staner</span>
    </a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-3">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#modal-opening">Panduan</a>
        </li>
        <?php if(logged_in() && in_groups('guests')) : ?>
        <li class="nav-item mr-3">
            <?php if(strpos(user()->email, 'pknstan.ac.id') != false) : ?> 
            <a class="nav-link" href="<?= base_url() . '/catalog/buka' ?>">Buka Toko!</a>
            <?php endif; ?>
        </li>
        <?php endif; ?>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle btn btn-info" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php if(in_groups('store_owner') || in_groups('admin') ) : ?>
                <a class="dropdown-item" href="<?= base_url('/panel') ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Panel Toko
                </a>
                <div class="dropdown-divider"></div>
                <?php endif; ?>
                <?php if(logged_in()) : ?>
                <a class="dropdown-item" href="<?= base_url('/logout') ?>" onclick="return confirm('Apa anda yakin untuk mengakhiri sesi akun?')">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
                <?php else : ?>
                <a class="dropdown-item" href="<?= base_url('/login') ?>">
                    <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Login Penjual
                </a>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>
<!-- Navbar -->