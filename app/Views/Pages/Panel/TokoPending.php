<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
</div>

<div class="row">
    <div class="col-12">
        <!-- Flash Data Pesan Upload -->
        <?php if (session()->getFlashData('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('pesan'); ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashData('errors')) : ?>
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Upss.</h4>
            <hr>
            <p class="mb-0"> <?= session()->getFlashData('errors'); ?> </p>
        </div>
        <?php endif; ?>
        <!-- /Flash Data Pesan Upload -->
    </div>
</div>

<!-- Content Row -->
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
                                <th>Nama</th>
                                <th>Instagram</th>
                                <th>WA Toko</th>
                                <th>WA Pemilik</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama</th>
                                <th>Instagram</th>
                                <th>WA Toko</th>
                                <th>WA Pemilik</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($toko as $k) : ?>
                            <tr>
                                <td><?= $k['name'] ?></td>
                                <td><?= $k['social_instagram'] ?></td>
                                <td><?= $k['store_whatsapp'] ?></td>
                                <td><?= $k['user_whatsapp'] ?></td>
                                <td><a href="<?= base_url('assets/uploads/store_document'). '/' . $k['store_document'] ?>">Lampiran</a></td>
                                <td>
                                    <a href="<?= base_url('panel/aktivasitoko/'.$k['id']) ?>" class="btn btn-success btn-circle btn-sm" onclick="return confirm('Apa anda yakin ingin mengaktifkan toko ini?')"><i class="fas fa-check"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->