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
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 col-sm-12">
            <img src="<?= base_url('assets/img/search.svg') ?>" class="rounded mx-auto d-block w-100">
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
            Stan Catalog.
        </h1>
        <p class="text-center text-muted">Tempat mencari apa yang kamu cari.</p>

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

    <!-- produk -->
    <div class="container">
        <div class="row">
            <?php foreach($produk as $k) : ?>
            <div class="col-lg-3 my-2">
                <div class="card shadow-sm">
                    <img class="card-img-top" src="<?= base_url() . '/assets/uploads/product_image/' . $k['image'] ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><a href="<?= base_url() . '/catalog/produk/' . $k['title_hash'] ?>"><?= $k['title'] ?></a></h5>
                        <p class="card-text"><?= (strlen($k['description']) > 30) ? substr($k['description'], 0, 30) . '..' : $k['description'] ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">RP <?= $k['price'] ?></li>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
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
    

</div>