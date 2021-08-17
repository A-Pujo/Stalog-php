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
                            <label for="category">Kategori</label>
                            <select class="custom-select js-basic-single" id="category" name="category" style="width: 100%;">
                                <?php foreach($category as $ct) : ?>
                                <option value="<?= $ct['id'] ?>"><?= $ct['category'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="customFile[]" onchange="filePreview()" multiple>
                            <label class="custom-file-label" for="customFile">Pilih gambar</label>
                            <small style="color: #e65247">*Maksimal 3 gambar dengan ukuran maksimal 300kb per gambar. Dapat memilih lebih dari satu gambar dalam 1x unggah.</small>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="price" placeholder="20000">
                        </div>
                        <div class="form-group">
                            <label>Stock</label> <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="in_stock" id="inlineRadio1" value="Kosong">
                                <label class="form-check-label" for="inlineRadio1">Kosong</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="in_stock" id="inlineRadio2" value="Pre-Order">
                                <label class="form-check-label" for="inlineRadio2">Pre-Order</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="in_stock" id="inlineRadio3" value="Tersedia">
                                <label class="form-check-label" for="inlineRadio3">Tersedia</label>
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
                                <?= (in_groups('store_owner') || in_groups('admin')) ? '<th>Edit</th>' : '' ?>
                                <th>Stok</th>
                                <th>Aktif</th>
                                <th>Dilihat</th>
                                <th>Toko</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <?= (in_groups('store_owner') || in_groups('admin')) ? '<th>Edit</th>' : '' ?>
                                <th>Stok</th>
                                <th>Aktif</th>
                                <th>Dilihat</th>
                                <th>Toko</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($produk as $k) : ?>
                            <tr>
                                <td id="colTitle-<?= $k['idp'] ?>"><?= $k['title'] ?></td>
                                <td id="colCat-<?= $k['idp'] ?>"><?= $k['category'] ?></td>
                                <td id="colPrc-<?= $k['idp'] ?>"><?= $k['price'] ?></td>
                                <td>
                                    <button href="#" class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#d-modal-<?= $k['idp'] ?>"><i class="far fa-edit"></i></button>
                                </td>
                                <td id="colStk-<?= $k['idp'] ?>"><?= $k['in_stock'] ?></td>
                                <td>
                                    <?php if($k['is_active'] == 1) : ?>
                                    <a href="<?= base_url('panel/disableproduk/'.$k['idp']) ?>" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Apa anda yakin ingin menonaktifkan produk ini?')"><i class="fas fa-times"></i></a>
                                    <?php else: ?>
                                    <a href="<?= base_url('panel/enableproduk/'.$k['idp']) ?>" class="btn btn-success btn-circle btn-sm" onclick="return confirm('Apa anda yakin ingin mengaktifkan produk ini?')"><i class="fas fa-check"></i></a>
                                    <a href="<?= base_url('panel/hapusproduk/'.$k['idp']) ?>" class="btn btn-warning btn-circle btn-sm" onclick="return confirm('Apa anda yakin ingin menghapus produk ini?')"><i class="far fa-trash-alt"></i></a>
                                    <?php endif; ?>
                                </td>
                                <td><?= $k['view_counter'] ?>x</td>
                                <td><?= (in_groups('admin')) ? $k['name'] : $toko['name'] ?></td>
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

<!-- Modal -->
<?php if(in_groups('store_owner')) : ?>
<?php foreach ($produk as $pmdl) :?>
<div class="modal fade" id="d-modal-<?= $pmdl['idp'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Edit Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" id="title-<?= $pmdl['idp'] ?>" value="<?= $pmdl['title'] ?>" name="title">
                    <input type="hidden" id="oldTitle-<?= $pmdl['idp'] ?>" value="<?= $pmdl['title'] ?>">
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="custom-select" id="curCategory-<?= $pmdl['idp'] ?>" style="width: 100%;">
                        <?php foreach($category as $ct) : ?>
                        <option value="<?= $ct['id'] ?>" <?= ($pmdl['category'] == $ct['category']) ? 'selected' : '' ?>><?= $ct['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" id="oldCat-<?= $pmdl['idp'] ?>" value="<?= $pmdl['category_id'] ?>">
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" class="form-control" id="price-<?= $pmdl['idp'] ?>" value="<?= $pmdl['price'] ?>" name="price">
                    <input type="hidden" id="oldPrc-<?= $pmdl['idp'] ?>" value="<?= $pmdl['price'] ?>">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="newDesc-<?= $pmdl['idp'] ?>" class="form-control" id="newDesc-<?= $pmdl['idp'] ?>" rows="5"><?= html_entity_decode($pmdl['description'] ) ?></textarea>
                    <input type="hidden" id="oldDesc-<?= $pmdl['idp'] ?>" value="<?= html_entity_decode($pmdl['description']) ?>">
                    <button class="btn btn-primary btn-sm" id="tmblSave-<?= $pmdl['idp'] ?>">save deskripsi</button>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <select class="form-control" id="curStock-<?= $pmdl['idp'] ?>" name="in_stock">
                        <?php $listSt = array('Kosong', 'Pre-Order', 'Tersedia'); foreach($listSt as $cST) : ?>
                        <option value="<?= $cST ?>" <?= ($pmdl['in_stock'] == $cST) ? 'selected' : '' ?>> <?= $cST ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" id="oldStk-<?= $pmdl['idp'] ?>" value="<?= $pmdl['in_stock'] ?>">
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<!-- End of Main Content -->