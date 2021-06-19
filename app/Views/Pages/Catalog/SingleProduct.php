<div class="container-fluid bg-white py-5">
    <?php if(empty($produk)) : ?>
    <div class="row">
        <div class="col">
            <img src="<?= base_url('') . '/assets/img/404.svg' ?>" class="mx-auto d-block w-50">
        </div>
    </div>
    <?php else : ?>
    <!-- produk -->
    <div class="container mt-3">
        <div class="row py-3 rounded shadow-lg">
            <div class="col-sm col-lg-8">
                <img src="<?= base_url() . '/assets/uploads/product_image/' . $produk['image'] ?>" class="img-fluid rounded w-100">
            </div>
            <div class="col-sm col-lg-4 pt-2">
                <h2> <?= $produk['title'] ?></h2> 
                <a href="<?= base_url() . '/catalog/cari/' . $produk['category'] ?>" class="btn btn-sm btn-info">Kategori <span class="badge badge-light"><?= $produk['category'] ?></span></a>
                <hr>
                <p class="text-muted">
                    <div class="d-flex justify-content-between">
                        <div>Oleh : <b class=""><?= $produk['name'] ?></b></div>
                        <div> Stok : <b class="<?= ($produk['in_stock'] != 0) ? 'text-info' : 'text-warning' ?>"><?= ($produk['in_stock'] != 0) ? 'Tersedia' : 'Kosong' ?></b> </div>
                    </div>
                    <br>
                    <?= $produk['description'] ?>
                </p>
                <hr>
                <div class="d-flex justify-content-between">
                    <?php 
                        if(strlen($produk['price']) > 3) {
                            $price = str_split(strrev($produk['price']), 3); 
                            $produk['price'] = $price[0] . '.' . $price[1] . '.' . $price[2]; 
                            $produk['price'] = strrev($produk['price']);
                        }
                    ?>
                    <div class="align-self-center">Rp <?= $produk['price'] ?></div>
                    <a href="https://wa.me/<?= $produk['store_whatsapp'] ?>?text=<?= $orderText ?>" target="_blank" class="btn btn-success"><i class="far fa-share-square"></i>&nbsp;Pesan</a>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    <a href="https://www.instagram.com/<?= $produk['social_instagram'] ?>" target="_blank" class="btn btn-danger btn-circle mx-1"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/<?= $produk['store_whatsapp'] ?>" target="_blank" class="btn btn-success btn-circle mx-1"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://wa.me/<?= $produk['user_whatsapp'] ?>" target="_blank" class="btn btn-secondary btn-circle mx-1"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- produk -->
    <?php endif; ?>

    <div class="container">
        <!-- search bar -->
        <?= form_open(base_url() . '/catalog/cari', ['autocomplete' => 'off', 'method' => 'get']) ?>
            <?= csrf_field() ?>
            <div class="input-group my-4">
                <div class="input-group-prepend">
                    <select class="custom-select" id="inputGroupSelect04" name="category">
                        <option selected>Kategori...</option>

                        <?php foreach($category as $c) : ?>
                        <option value="<?= $c ?>"><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="text" class="form-control" placeholder="Cari di sini." name="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon1"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- search bar -->
    </div>
</div>