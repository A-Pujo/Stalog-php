<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
</div>

<!-- Content Row -->
<div class="row">
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
                <h6 class="m-0 font-weight-bold text-primary">Tabel Toko</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Email</th>
                                <th>WA Toko</th>
                                <th>WA pemilik</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Email</th>
                                <th>WA Toko</th>
                                <th>WA pemilik</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($tokoAktif as $p) : ?>
                            <tr>
                                <td><?= $p['name'] ?></td>
                                <td><?= $p['email'] ?></td>
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

<!-- tabel editor's pick -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Editor's Pick</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">
                    <a href="#" class="btn btn-success btn-icon-split mb-3" data-toggle="modal" data-target="#pick-modal"><span class="icon text-white-50"><i class="fas fa-plus"></i></span><span class="text">Tambah</span></a>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable-product" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Paket</th>
                                    <th>Produk</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama Paket</th>
                                    <th>Produk</th>
                                    <th>Hapus</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($paketProduk as $d) : ?>
                                <tr>
                                    <td><?= $d['package_name'] ?></td>
                                    <td><?= $d['product_ids'] ?></td>
                                    <td><a href="<?= base_url() . '/panel/hapusPackage/' . $d['id'] ?>" class="btn btn-danger">Hapus</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- tabel editor's pick -->
<?php endif; ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php if(in_groups('admin')) : ?>
<!-- Modal -->
<div class="modal fade" id="pick-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open(base_url() . '/panel/tambahPackage') ?>
                    <div class="form-group">
                        <label for="package-name">Nama Paket</label>
                        <input type="text" class="form-control" id="package-name" placeholder="Back to Campus" name="package-name">
                    </div>
                    <div class="form-group">
                        <label for="packet-products">Produk</label>
                        <select id="packet-products" class="js-basic-multiple form-control" name="products[]" multiple="multiple" style="width: 100%;">
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= $p['idp'] ?>"><?= $p['title'] ?></option>
                            <?php endforeach;?>
                        </select>
                        <small class="form-text text-muted">Bisa pilih lebih dari 1 produk.</small>
                    </div>


                    <hr>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>