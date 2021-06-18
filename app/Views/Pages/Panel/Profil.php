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
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">Edit Profil</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">
                    <?= form_open_multipart(base_url('panel/updateprofil') . '/' . $toko['id'], ['method' => 'post', 'autocomplete' => 'off']) ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="name">Nama Toko</label>
                            <input class="form-control" type="text" id="name" name="name" value="<?= $toko['name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug Toko</label>
                            <input class="form-control" id="slug" type="text" value="<?= $toko['name'] ?>" readonly name="slug">
                        </div>
                        <div class="form-group">
                            <label for="social_instagram">Instagram</label>
                            <input class="form-control" type="text"id="social_instagram" name="social_instagram" placeholder="Username IG">
                        </div>
                        <div class="form-group">
                            <label for="store_whatsapp">WA Toko</label>
                            <input class="form-control" type="text"id="store_whatsapp" name="store_whatsapp" placeholder="Format: 08xxxxxxxxxx" value="<?= $toko['store_whatsapp'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_whatsapp">WA Pemilik</label>
                            <input class="form-control" type="text"id="user_whatsapp" name="user_whatsapp" placeholder="Format: 08xxxxxxxxxx" value="<?= $toko['user_whatsapp'] ?>">
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="customFile" onchange="filePreview()">
                            <label class="custom-file-label" for="customFile">Pilih gambar baru</label>
                        </div>
                        <input type="hidden" class="custom-file-input" name="old_pic" value="<?= $toko['store_image'] ?>">
                        <input class="form-control" type="hidden" name="old_name" value="<?= $toko['name'] ?>">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apa anda yakin dengan data yang telah diisi?')">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->