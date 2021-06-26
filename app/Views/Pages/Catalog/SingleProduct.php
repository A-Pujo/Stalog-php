<div class="container-fluid bg-white py-5">
    <?php if(empty($produk)) : ?>
    <div class="row py-5">
        <div class="col">
            <img src="<?= base_url('') . '/assets/img/404.svg' ?>" class="mx-auto d-block w-50">
        </div>
    </div>
    <?php else : ?>
    <!-- produk -->
    <div class="container mt-5">
        <div class="row py-3 rounded shadow-lg">
            <div class="col-sm col-lg-8">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                        $produk['image'] = explode(';', $produk['image']);
                        $it = 0; $tImg = (count($produk['image']) != 1) ? count($produk['image'])-1 : count($produk['image']);
                        foreach($produk['image'] as $carImg) :
                        if($it == $tImg) continue;
                        ?>
                        <div class="carousel-item <?= ($it == 0) ? 'active' : '' ?>">
                            <img class="d-block w-100 rounded" src="<?= base_url() . '/assets/uploads/product_image/' . $carImg ?>" alt="First slide">
                        </div>
                        <?php $it++; endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-sm col-lg-4 pt-2">
                <h2> <?= $produk['title'] ?></h2> 
                <a href="<?= base_url() . '/catalog/cari/' . $produk['category_id'] ?>" class="btn btn-sm btn-info"><?= $produk['category'] ?></a>
                <hr>
                <p class="text-muted">
                    <div class="d-flex justify-content-between">
                        <div>Oleh : <b class=""><?= $produk['name'] ?></b></div>
                        <div> Stok : <b class="<?= ($produk['in_stock'] != 0) ? 'text-info' : 'text-warning' ?>"><?= ($produk['in_stock'] != 0) ? 'Tersedia' : 'Kosong' ?></b> </div>
                    </div>
                    <div class="text-muted"><small><?= $lokasiToko['name']; ?></small></div>
                    <br>
                    <?= $produk['description'] ?>
                </p>
                <hr>
                <div class="d-flex justify-content-between">
                    <?php
                        $produk['price'] = str_split(strrev($produk['price']), 3);
                        if(count($produk['price']) > 1) {
                            $price = '';
                            foreach ($produk['price'] as $p) {
                                $price .= $p . '.';
                            }
                            $produk['price'] = strrev($price);
                        } else {
                            $produk['price'] = '.' . $produk['price'][0];
                        }
                    ?>
                    <div class="align-self-center">Rp<?= $produk['price'] ?></div>
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
        <?= form_open(base_url() . '/catalog/cari', ['autocomplete' => 'off', 'method' => 'get', 'class' => 'mt-5']) ?>
            <?= csrf_field() ?>
            <div class="input-group row my-4">
                <div class="col">
                    <select class="js-example-basic-single custom-select" id="inputGroupSelect04" name="category">
                        <option>Kategori..</option>
                        <?php foreach($kategori as $c) : ?>
                        <option value="<?= $c['id'] ?>"><?= $c['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <select class="js-example-basic-single custom-select" id="inputGroupSelect05" name="regency">
                        <option>Lokasi..</option>
                        <?php foreach($lokasi as $lk) : ?>
                        <option value="<?= $lk['id'] ?>"><?= $lk['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="input-group my-4">
                <input type="text" class="form-control" placeholder="Cari di sini." name="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon1"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- search bar -->
    </div>
</div>