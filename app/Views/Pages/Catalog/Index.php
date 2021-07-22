<style>
    /* divider */
    .editorial {
        display: block;
        width: 100%;
        height: 60px;
        max-height: 60px;
        margin: 0;
        z-index:5;
    }

    .parallax1 > use {
        animation: move-forever1 10s linear infinite;
        &:nth-child(1) {
            animation-delay: -2s;
        }
    }
    .parallax2 > use {
        animation: move-forever2 8s linear infinite;
        &:nth-child(1) {
            animation-delay: -2s;
        }
    }
    .parallax3 > use {
        animation: move-forever3 6s linear infinite;
        &:nth-child(1) {
            animation-delay: -2s;
        }
    }
    .parallax4 > use {
        animation: move-forever4 4s linear infinite;
        &:nth-child(1) {
            animation-delay: -2s;
        }
    }
    @keyframes move-forever1 {
        0% {
            transform: translate(85px, 0%);
        }
        100% {
            transform: translate(-90px, 0%);
        }
    }
    @keyframes move-forever2 {
        0% {
            transform: translate(-90px, 0%);
        }
        100% {
            transform: translate(85px, 0%);
        }
    }
    @keyframes move-forever3 {
        0% {
            transform: translate(85px, 0%);
        }
        100% {
            transform: translate(-90px, 0%);
        }
    }
    @keyframes move-forever4 {
        0% {
            transform: translate(-90px, 0%);
        }
        100% {
            transform: translate(85px, 0%);
        }
    }
    /* divider */

    body{
        background-color: #DFEEEA;
    }
</style>

<div class="container mt-5 p-2">
    <div class="row mt-5">
        <div class="col-12">
            <!-- Flash Data Pesan Upload -->
            <?php if (session()->getFlashData('pesan')) : ?>
            <div class="alert alert-info" role="alert">
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

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 col-sm-12">
            <img src="<?= base_url('assets/img/beranda.svg') ?>" class="rounded mx-auto d-block w-100">
        </div>
    </div>
</div>

<!-- divider atas -->
<svg class="editorial" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
    <defs>
        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax1">
        <use xlink:href="#gentle-wave" x="50" y="3" fill="#f461c1"/>
    </g>
    <g class="parallax2">
        <use xlink:href="#gentle-wave" x="50" y="0" fill="#4579e2"/>
    </g>
    <g class="parallax3">
        <use xlink:href="#gentle-wave" x="50" y="9" fill="#3461c1"/>
    </g>
    <g class="parallax4">
        <use xlink:href="#gentle-wave" x="50" y="6" fill="#fff"/>  
    </g>
</svg>
<!-- divider -->

<div class="container-fluid bg-white py-5">
    <div class="container">
        <h1 class="text-center">
            Lapak Staner
        </h1>
        <p class="text-center text-muted">Tempat mencari apa yang kamu cari.</p>

        <!-- search bar -->
        <?= form_open(base_url() . '/catalog/cari', ['autocomplete' => 'off', 'method' => 'get']) ?>
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
                    <button class="btn btn-info" type="submit" id="button-addon1"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- search bar -->
    </div>

    <!-- produk -->
    <div class="container">
        <div class="row">
            <?php 
            $dmp = array();
            // fetch produk
            foreach($produk as $k) :

            $k['image'] = explode(';', $k['image']);

            $k['price'] = str_split(strrev($k['price']), 3);
            $k['price'] = strrev(implode('.', $k['price']));
            // array_push($dmp, $k['image']);
            ?>
            <div class="col-lg-3 my-2">
                <div class="card shadow-sm" style="height: 300px;">
                    <a href="<?= base_url() . '/catalog/produk/' . $k['title_hash'] ?>"><img class="card-img-top" src="<?= base_url() . '/assets/uploads/product_image/' . $k['image'][0] ?>" alt="Card image cap" style="height: 200px;"></a>
                    <div class="card-body">
                        <h6 class="card-title"><a href="<?= base_url() . '/catalog/produk/' . $k['title_hash'] ?>" style="font-size: 1rem;"><?= (strlen($k['title']) > 20) ? substr($k['title'], 0, 20) . '..' : $k['title'] ?></a></h6>
                        <!-- <p class="card-text"><?= (strlen($k['description']) > 30) ? substr($k['description'], 0, 30) . '..' : $k['description'] ?></p> -->
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Rp <?= $k['price'] ?></li>
                    </ul>
                </div>
            </div>
            <?php 
            endforeach; 
            // dd($dmp);
            ?>
        </div>
    </div>
    <!-- produk -->
    
    <?php if(empty($produk)) : ?>
    <div class="row">
        <div class="col">
            <img src="<?= base_url('') . '/assets/img/404.svg' ?>" class="mx-auto d-block w-50">
        </div>
    </div>
    <?php else : ?>
    <?= $pager->links() ?>
    <?php endif; ?>
    
    <div class="modal hide fade" id="modal-opening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Halo!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-4 text-center">
            <p>Tes nich.</p>
            <div class="h_iframe">
                <img class="ratio" src="http://placehold.it/16x9"/>
                <iframe width="640" height="360" type="text/html" 
                    src="https://www.youtube.com/embed/Tt93EZWfVKk">
                </iframe> 
            </div>
          </div>
        </div>
      </div>
    </div>

    
</div>