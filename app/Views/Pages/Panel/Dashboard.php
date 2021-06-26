<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produk <?= (in_groups('admin')) ? 'Terdaftar' : 'Aktif' ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (in_groups('admin')) ? count($produk) : count($produkAktif) . ' dari '. count($produkTotal) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Earnings (Monthly) Card Example -->
    <?php if(in_groups('admin')) : ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Toko Terdaftar
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= count($tokoAktif) ?> Unit</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(in_groups('admin')) : ?>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pengajuan Toko</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($tokoPending) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Content Row -->
<?php if(in_groups('admin')) : ?>
<!-- tabel toko -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>WA Toko</th>
                                <th>WA pemilik</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Toko</th>
                                <th>WA Toko</th>
                                <th>WA pemilik</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($tokoAktif as $p) : ?>
                            <tr>
                                <td><?= $p['name'] ?></td>
                                <td><a href="https://wa.me/<?= $p['store_whatsapp'] ?>"><?= $p['store_whatsapp'] ?></a></td>
                                <td><a href="https://wa.me/<?= $p['user_whatsapp'] ?>"><?= $p['user_whatsapp'] ?></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->