<?php

namespace App\Controllers;

class Catalog extends BaseController
{
    protected $TOKO, $PRODUK, $CATEGORY, $LOKASI;

    function __construct()
    {
        $this->TOKO = new \App\Models\M_Toko();
        $this->PRODUK = new \App\Models\M_Produk();
        $this->CATEGORY = new \App\Models\M_Category();
        $this->LOKASI = new \App\Models\M_Lokasi();
    }

    // Landing, Home 
    public function index()
    {
        $produk = $this->PRODUK->join('store', 'store.id = products.store_id')->join('product_category', 'product_category.id = products.category_id')->where(['is_active' => 1, 'active' => 1,])->orderBy('idp', 'DESC');
        $data = [
            'title' => 'Beranda',
            'produk' => $produk->paginate(12),
            'pager' => $produk->pager,
            'lokasi' => $this->LOKASI->findAll(),
            'kategori' => $this->CATEGORY->findAll(),
        ];

        echo view('Components/Catalog/Header', $data);
        echo view('Components/Catalog/Navbar', $data);
        echo view('Pages/Catalog/Index', $data);
        echo view('Components/Catalog/Footer', $data);
    }

    // login helper function
    public function userLogin()
    {
        return redirect()->to(base_url());
    }

    // Search
    public function cari($category = 'Kategori..', $lokasi = 'Lokasi..', $search = null)
    {
        // dd($this->request->getGet());
        $price_filter = ($this->request->getVar('price-filter')) ? $this->request->getVar('price-filter') : 'ASC';
        $produk = $this->PRODUK->join('store', 'store.id = products.store_id')->where(['is_active' => 1, 'active' => 1,])->orderBy('price', $price_filter);

        $category = ($this->request->getVar('category')) ? $this->request->getVar('category') : $category;
        $lokasi = ($this->request->getVar('regency')) ? $this->request->getVar('regency') : $lokasi;
        $search = ($this->request->getVar('search')) ? $this->request->getVar('search') : $search;

        // dd([$category, $lokasi, $search]);

        if($category != 'Kategori..' && $lokasi != 'Lokasi..' && $search != null) {
            $prd = $produk->like(['title' => $search,])->where(['category_id' => $category, 'regency_id' => $lokasi]);
        }

        else if ($category != 'Kategori..' && $search != null){
            $prd = $produk->like(['title' => $search,])->where(['category_id' => $category,]);
        }

        else if ($category != 'Kategori..' && $lokasi != 'Lokasi..'){
            $prd = $produk->like(['category_id' => $category,])->where(['regency_id' => $lokasi]);
        }

        else if ($search != null && $lokasi != 'Lokasi..'){
            $prd = $produk->like(['title' => $search,])->where(['regency_id' => $lokasi]);
        }

        else if ($category != 'Kategori..'){
            $prd = $produk->where(['category_id' => $category]);
        }

        else if ($search != null) {
            $prd = $produk->like(['title' => $search])->orLike('description', $search);
        }

        else if ($lokasi != 'Lokasi..'){
            $prd = $produk->where(['regency_id' => $lokasi]);
        }

        else if(! empty($price_filter)){
            $prd = $produk;
        }

        else{
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Pencarian',
            'produk' => $prd->paginate(12),
            'pager' => $prd->pager,
            'kategori' => $this->CATEGORY->findAll(),
            'lokasi' => $this->LOKASI->findAll(),
        ];

        echo view('Components/Catalog/Header', $data);
        echo view('Components/Catalog/Navbar', $data);
        echo view('Pages/Catalog/Search', $data);
        echo view('Components/Catalog/Footer', $data);
    }

    // Single Product
    public function produk($title_hash = null)
    {
        $produk = $this->PRODUK->join('store', 'store.id = products.store_id')->join('product_category', 'product_category.id = products.category_id')->where(['title_hash' => $title_hash, 'is_active' => 1, 'active' => 1])->first();

        $data = [
            'title' => 'Barang',
            'produk' => $produk,
            'kategori' => $this->CATEGORY->findAll(),
            'lokasi' => $this->LOKASI->findAll(),
        ];

        if(! empty($produk)) {
            $orderText = 'Permisi saya ingin memesan barang ' . $produk['title'] . ' di laman Lapak Staner dengan tautan ' . base_url() . '/catalog/produk/' . $produk['title_hash'] . ' Apakah masih tersedia?';
            $orderText = urlencode($orderText);
            $data['orderText'] = $orderText;
            $data['lokasiToko'] = $this->LOKASI->where(['id' => $produk['regency_id']])->first();
            $viewCounter = $produk['view_counter'] + 1;
            $this->PRODUK->where(['title_hash' => $title_hash, 'is_active' => 1,])->update(null, ['view_counter' => (int)$viewCounter,]);
        }

        echo view('Components/Catalog/Header', $data);
        echo view('Components/Catalog/Navbar', $data);
        echo view('Pages/Catalog/SingleProduct', $data);
        echo view('Components/Catalog/Footer', $data);
    }

    // Store Page
    public function toko($slug = null)
    {
        $toko = $this->TOKO->where(['slug' => $slug, 'active' => 1])->first();
        
        if(! empty($toko)) {
            $produk = $this->PRODUK->where(['store_id' => $toko['id']]);
        
            $data = [
                'title' => $toko['name'],
                'toko' => $toko,
                'produk' => $produk->paginate(12),
                'pager' => $produk->pager,
                'lokasiToko' => $this->LOKASI->where(['id' => $toko['regency_id']])->first(),
                'kategori' => $this->CATEGORY->findAll(),
                'lokasi' => $this->LOKASI->findAll(),
            ];

        }
        else{
            $data = [
                'kategori' => $this->CATEGORY->findAll(),
                'lokasi' => $this->LOKASI->findAll(),
                'title' => 'Tidak Diketahui',
            ];  
        }

        // dd($toko);

        echo view('Components/Catalog/Header', $data);
        echo view('Components/Catalog/Navbar', $data);
        echo view('Pages/Catalog/Toko', $data);
        echo view('Components/Catalog/Footer', $data);
    }

    public function buka()
    {
        if (! logged_in()) {
            return redirect()->to(base_url().'/catalog/user-login');
        }

        if (!is_int(strpos(user()->email, 'pknstan.ac.id'))){
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Buka Toko',
            'lokasi' => $this->LOKASI->findAll(),
        ];

        echo view('Components/Catalog/Header', $data);
        echo view('Components/Catalog/Navbar', $data);
        echo view('Pages/Catalog/BukaToko', $data);
        echo view('Components/Catalog/Footer', $data);
    }

    public function ajukan()
    {
        if (! in_groups('guests')) {
            $this->session->setFlashdata('pesan', 'Formulirmu gagal dikirim.');
            return redirect()->to(base_url());
        }

        if(!$this->validate([
			'name' => [
				'rules' => 'required|is_unique[store.name]',
				'errors' => [
                    'required' => 'Nama toko harus diisi.',
                    'is_unique' => 'Toko sudah terdaftar.',
                ],
			],
            'user_id' => [
                'rules' => 'is_unique[store.user_id]',
				'errors' => [
                    'is_unique' => 'Akunmu sudah pernah terdaftar.',
                ],
            ],
            'store_whatsapp' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'WA toko harus diisi.',
                    'alpha_numeric' => 'WA toko tidak boleh menganduk simbo (e.g. +/-;|)',
                ],
            ],
            'user_whatsapp' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'WA pemilik harus diisi.',
                    'alpha_numeric' => 'WA pemilik tidak boleh menganduk simbo (e.g. +/-;|)',
                ],
            ],
            // 'store_document' => [
			// 	'rules' => 'uploaded[store_document]|max_size[store_document, 5000]|ext_in[store_document,docx,doc,pdf]',
			// 	'errors' => [
			// 		'uploaded' => 'Dokumen lampiran tidak dipilih.',
			// 		'max_size' => 'Ukuran dokumen terlalu besar.',
			// 		'ext_in' => 'Format dokumen tidak sesuai.',
			// 	],
			// ],
			'store_image' => [
				'rules' => 'max_size[store_image,3000]|ext_in[store_image,jpg,png,jpeg]',
				'errors' => [
					'max_size' => 'Ukuran gambar terlalu besar.',
					'ext_in' => 'Format gambar tidak sesuai.',
				],
			],
		])){
			$this->session->setFlashdata('errors', $this->validation->listErrors());
			return redirect()->to('/catalog/buka')->withInput();
		}

		// Upload file document
		// $file_doc = $this->request->getFile('store_document');
		// $fileName_doc = $file_doc->getRandomName();
		// $file_doc->move('assets/uploads/store_document/', $fileName_doc);

        // upload file gambar
        if($this->request->getFile('store_image')->isValid()){
            $file_img = $this->request->getFile('store_image');
    		$fileName_img = $file_img->getRandomName();
    		$file_img->move('assets/uploads/store_image/', $fileName_img);
        } else {
            $fileName_img = 'default.png';
        }

		$this->TOKO->save([
			'name' => $this->request->getVar('name'),
            'slug' => $this->request->getVar('slug'),
            'user_id' => user()->id,
            'store_desc' => $this->request->getVar('store_desc'),
            'regency_id' => $this->request->getVar('regency'),
            'social_instagram' => $this->request->getVar('social_instagram'),
            'ext_link' => $this->request->getVar('ext_link'),
            'store_whatsapp' => $this->request->getVar('store_whatsapp'),
            'user_whatsapp' => $this->request->getVar('user_whatsapp'),
            // 'store_document' => $fileName_doc,
            'store_document' => '',
			'store_image' => $fileName_img,
		]);
		
		$this->session->setFlashdata('pesan', 'Formulirmu berhasil dikirim. Silahkan cek email konfirmasi dari Lapak Staner secara berkala dalam 3 x 24 jam.');

		return redirect()->to('/catalog')->withInput();
    }
}

?>