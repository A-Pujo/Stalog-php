<div class="container-fluid bg-white py-5">
    <!-- produk -->
    <div class="container mt-3">
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
        <div class="row py-3">
            <div class="col">
                <div class="card rounded shadow-lg p-3">
                    <div class="card-body">
                        <h5 class="card-title">Formulir Pengajuan Pembukaan Toko.</h5>
                        <hr>
                        <?= form_open_multipart(base_url().'/catalog/ajukan', ['autocomplete' => 'off', 'method' => 'post']) ?>
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="name">Nama Toko</label>
                                <input type="text" class="form-control" id="name" placeholder="Masukkan Nama" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" value="" name="slug" readonly>
                            </div>
                            <input type="hidden" id="user_id" name="user_id" value="<?= user()->id ?>">
                            <div class="form-group">
                                <label for="store_desc">Deskripsi Toko</label>
                                <textarea type="text" class="form-control" id="store_desc" placeholder="Masukkan Deskripsi" name="store_desc" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputGroupSelect05">Lokasi</label>
                                <select class="js-example-basic-single custom-select" id="inputGroupSelect05" name="regency">
                                    <?php foreach($lokasi as $lk) : ?>
                                    <option value="<?= $lk['id'] ?>"><?= $lk['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="social_instagram">Username Instagram</label>
                                    <input type="text" class="form-control" id="social_instagram" placeholder="pknstan" name="social_instagram">
                                    <small>*Opsional</small>
                                </div>
                                <div class="form-group col-md">
                                    <label for="ext_link">Tautan Eksternal</label>
                                    <input type="text" class="form-control" id="ext_link" placeholder="https://linktr.ee/blablabla" name="ext_link">
                                    <small>*Opsional</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="store_whatsapp">Whatsapp Toko</label>
                                        <input type="text" class="form-control" id="store_whatsapp" placeholder="Format : 62816xxxxxxxx" name="store_whatsapp">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="user_whatsapp">Whatsapp Pemilik</label>
                                        <input type="text" class="form-control" id="user_whatsapp" placeholder="Bisa disamakan WA Toko." name="user_whatsapp">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <!-- <div class="col">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile-1" name="store_document" onchange="filePreview_1()">
                                        <label class="custom-file-label" for="customFile-1" id="customFile-1-label">Pilih Dokumen..</label>
                                        <small class="text-muted">*Dokumen lampiran toko harus sesuai dengan <a href="#">format</a> yang telah disedikan.</small>
                                    </div>
                                </div> -->
                                <div class="col">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile-2" name="store_image" onchange="filePreview_2()">
                                        <label class="custom-file-label" for="customFile-2" id="customFile-2-label">Pilih Gambar..</label>
                                        <small class="text-muted">*Gambar dengan ukuran maksimal 3mb dan format jpg, png, dan jpeg digunakan sebagai foto profil toko .</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3" onclick="return confirm('Apakah anda sudah yakin dengan data yang anda isi?')">Ajukan!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- produk -->
</div>