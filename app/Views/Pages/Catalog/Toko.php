<style>
    .iframe-container {
      overflow: hidden;
      /* 16:9 aspect ratio */
      padding-top: 56.25%;
      position: relative;
    }
    
    .iframe-container iframe {
       border: 0;
       height: 100%;
       left: 0;
       position: absolute;
       top: 0;
       width: 100%;
    }
</style>
<div class="container-fluid bg-white py-5">
    <?php if(empty($toko)) : ?>
    <div class="row py-5">
        <div class="col">
            <img src="<?= base_url('') . '/assets/img/404.svg' ?>" class="mx-auto d-block w-50">
        </div>
    </div>
    <?php else : ?>
    <!-- etalase toko -->
    <div class="container mt-5">
        <div class="row py-3 rounded shadow-lg">
            <div class="col-lg-3 p-3">
                <img class="d-block w-100 rounded" src="<?= base_url() . '/assets/uploads/store_image/' . $toko['store_image'] ?>">
            </div>
            <div class="col-lg-9 px-5 py-3">
                <div class="d-lg-flex justify-content-between">
                    <h4 class="align-self-center"><b><?= $toko['name'] ?></b></h4>
                    <h6 class="align-self-center"><small><?= $lokasiToko['name'] ?></small></h6>
                </div>
                <div class="text-left">
                    <?= html_entity_decode($toko['store_desc']) ?>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    <a href="https://www.instagram.com/<?= $toko['social_instagram'] ?>" target="_blank" class="btn btn-danger btn-circle mx-1"><i class="fab fa-instagram"></i></a>
                    <?php if(! empty($produk['ext_link']) and $produk['ext_link'] != null) : ?>
                    <a href="<?= $toko['ext_link'] ?>" target="_blank" class="btn btn-warning btn-circle mx-1"><i class="fas fa-link"></i></a>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="row">
                    <?php 
                        $dmp = array();
                        foreach($produk as $k) : 
                        $k['image'] = explode(';', $k['image']);

                        $k['price'] = str_split(strrev($k['price']), 3);
                        $k['price'] = strrev(implode('.', $k['price']));
                    ?>
                    
                    <div class="col-lg-3 my-2">
                        <div class="card shadow-sm" style="height: 240px;">
                            <a href="<?= base_url() . '/catalog/produk/' . $k['title_hash'] ?>"><img class="card-img-top" src="<?= base_url() . '/assets/uploads/product_image/' . $k['image'][0] ?>" alt="<?= $k['title'] ?>" style="height: 140px;"></a>
                            <div class="card-body">
                                <h6 class="card-title"><a href="<?= base_url() . '/catalog/produk/' . $k['title_hash'] ?>" style="font-size: 1rem;"><?= (strlen($k['title']) > 12) ? substr($k['title'], 0, 12) . '..' : $k['title'] ?></a></h6>
                                <!-- <p class="card-text"><?= (strlen($k['description']) > 30) ? substr($k['description'], 0, 30) . '..' : $k['description'] ?></p> -->
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Rp <?= $k['price'] ?></li>
                            </ul>
                        </div>
                    </div>

                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <?= $pager->links() ?>
                    </div>
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
                <div class="col-md input-group mt-2">
                    <select class="js-example-basic-single custom-select" id="inputGroupSelect04" name="category">
                        <option>Kategori..</option>
                        <?php foreach($kategori as $c) : ?>
                        <option value="<?= $c['id'] ?>"><?= $c['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md input-group mt-2">
                    <select class="js-example-basic-single custom-select" id="inputGroupSelect05" name="regency">
                        <option>Lokasi..</option>
                        <?php foreach($lokasi as $lk) : ?>
                        <option value="<?= $lk['id'] ?>"><?= $lk['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md input-group mt-2">
                    <select class="js-example-basic-single custom-select" id="inputGroupSelect06" name="price-filter">
                        <option value="ASC">Harga &#8595;</option>
                        <option value="DESC">Harga &#8593;</option>
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