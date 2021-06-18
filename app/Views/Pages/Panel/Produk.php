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

<?php if(in_groups('store_owner')) : ?>
<div class="row">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Produk</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    <?= form_open_multipart(base_url('panel/tambahproduk/'), ['method' => 'post', 'autocomplete' => 'off']) ?>
                    <!-- <form action="<?= base_url('panel/tambahproduk/') ?>" method="post" enctype="multipart/form-data" autocomplete="off"> -->
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="title">Judul Produk</label>
                            <input class="form-control" type="text" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="title_hash">Hash Judul</label>
                            <input class="form-control" id="title_hash" type="text" value="" readonly name="title_hash">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input class="form-control" type="text"id="category" name="category">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="customFile" onchange="filePreview()">
                            <label class="custom-file-label" for="customFile">Pilih gambar</label>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="price">
                        </div>
                        <div class="form-group">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                                <label class="form-check-label" for="is_active">
                                    Aktif ?
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" id="stock" name="in_stock">
                                <label class="form-check-label" for="stock">
                                    In Stock ?
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apa anda yakin dengan data yang telah diisi?')">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

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
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aktif</th>
                                <th>Toko</th>
                                <?= (in_groups('store_owner')) ? '<th>Aksi</th>' : '' ?>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aktif</th>
                                <th>Toko</th>
                                <?= (in_groups('store_owner')) ? '<th>Aksi</th>' : '' ?>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($produk as $k) : ?>
                            <tr>
                                <td><?= $k['title'] ?></td>
                                <td><?= $k['category'] ?></td>
                                <td><?= $k['price'] ?></td>
                                <td><?= ($k['in_stock'] == 1) ? 'True' : 'False' ?></td>
                                <td><?=  ($k['is_active'] == 1) ? 'True' : 'False'  ?></td>
                                <td><?= (in_groups('admin')) ? $k['name'] : $toko['name'] ?></td>
                                <?php if(in_groups('store_owner')) : ?>
                                <td>
                                    <a href="<?= base_url('panel/disableproduk/'.$k['id']) ?>" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Apa anda yakin ingin menonaktifkan produk ini?')"><i class="fas fa-times"></i></a>
                                    <a href="<?= base_url('panel/enableproduk/'.$k['id']) ?>" class="btn btn-success btn-circle btn-sm" onclick="return confirm('Apa anda yakin ingin mengaktifkan produk ini?')"><i class="fas fa-check"></i></a>
                                    <a href="<?= base_url('panel/emptyproduk/'.$k['id']) ?>" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Apa produk ini benar-benar out of stock?')"><i class="fas fa-box-open"></i></a>
                                    <a href="<?= base_url('panel/repopulateproduk/'.$k['id']) ?>" class="btn btn-success btn-circle btn-sm" onclick="return confirm('Apa produk ini benar-benar sudah tersedia?')"><i class="fab fa-stack-overflow"></i></a>
                                </td>
                                <?php endif; ?>
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