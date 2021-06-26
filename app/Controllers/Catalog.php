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

    public function index()
    {
        $produk = $this->PRODUK->join('store', 'store.id = products.store_id')->join('product_category', 'product_category.id = products.category_id')->where(['is_active' => 1, 'active' => 1,]);
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

    public function cari($category = 'Kategori..', $lokasi = 'Lokasi..', $search = null)
    {
        // dd($this->request->getGet());
        $produk = $this->PRODUK->join('store', 'store.id = products.store_id')->where(['is_active' => 1, 'active' => 1,]);

        $category = ($this->request->getVar('category')) ? $this->request->getVar('category') : $category;
        $lokasi = ($this->request->getVar('regency')) ? $this->request->getVar('regency') : $category;
        $search = ($this->request->getVar('search')) ? $this->request->getVar('search') : $search;

        if($category != 'Kategori..' && $lokasi != 'Lokasi..' && $search != null) {
            $prd = $produk->like(['title' => $search, 'category_id' => $category, 'regency_id' => $lokasi]);
        }

        else if ($category != 'Kategori..' && $search != null){
            $prd = $produk->like(['title' => $search, 'category_id' => $category]);
        }

        else if ($category != 'Kategori..' && $lokasi != 'Lokasi..'){
            $prd = $produk->like(['category_id' => $category, 'regency_id' => $lokasi]);
        }

        else if ($search != null && $lokasi != 'Lokasi..'){
            $prd = $produk->like(['title' => $search, 'regency_id' => $lokasi]);
        }

        else if ($category != 'Kategori..'){
            $prd = $produk->like(['category_id' => $category]);
        }

        else if ($search != null) {
            $prd = $produk->like(['title' => $search])->orLike('description', $search);
        }

        else if ($lokasi != 'Lokasi..'){
            $prd = $produk->like(['regency_id' => $lokasi]);
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

    public function produk($title_hash = null)
    {
        $produk = $this->PRODUK->join('store', 'store.id = products.store_id')->join('product_category', 'product_category.id = products.category_id')->where(['title_hash' => $title_hash, 'is_active' => 1, 'active' => 1])->first();
        $data = [
            'title' => 'Barang',
            'produk' => $produk,
            'kategori' => $this->CATEGORY->findAll(),
            'lokasi' => $this->LOKASI->findAll(),
            'lokasiToko' => $this->LOKASI->where(['id' => $produk['regency_id']])->first(),
        ];

        if($produk != null) {
            $orderText = 'Permisi saya ingin memesan barang ' . $produk['title'] . ' di laman Stan Catalog dengan tautan ' . base_url() . '/catalog/produk/' . $produk['title_hash'] . ' Apakah masih tersedia?';
            $orderText = urlencode($orderText);
            $data['orderText'] = $orderText;
        }

        echo view('Components/Catalog/Header', $data);
        echo view('Components/Catalog/Navbar', $data);
        echo view('Pages/Catalog/SingleProduct', $data);
        echo view('Components/Catalog/Footer', $data);
    }

    public function buka()
    {
        if (! logged_in()) {
            return redirect()->to(base_url().'/catalog/user-login');
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
                'rules' => 'required',
                'errors' => [
                    'required' => 'WA toko harus diisi.'
                ],
            ],
            'user_whatsapp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'WA pemilik harus diisi.'
                ],
            ],
            'store_document' => [
				'rules' => 'uploaded[store_document]|max_size[store_document, 5000]|ext_in[store_document,docx,doc,pdf]',
				'errors' => [
					'uploaded' => 'Dokumen lampiran tidak dipilih.',
					'max_size' => 'Ukuran dokumen terlalu besar.',
					'ext_in' => 'Format dokumen tidak sesuai.',
				],
			],
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
		$file_doc = $this->request->getFile('store_document');
		$fileName_doc = $file_doc->getRandomName();
		$file_doc->move('assets/uploads/store_document/', $fileName_doc);

        // upload file gambar
        $file_img = $this->request->getFile('store_image');
		$fileName_img = $file_img->getRandomName();
		$file_img->move('assets/uploads/store_image/', $fileName_img);

		$this->TOKO->save([
			'name' => $this->request->getVar('name'),
            'slug' => $this->request->getVar('slug'),
            'user_id' => user()->id,
            'regency_id' => $this->request->getVar('regency'),
            'social_instagram' => $this->request->getVar('social_instagram'),
            'store_whatsapp' => $this->request->getVar('store_whatsapp'),
            'user_whatsapp' => $this->request->getVar('user_whatsapp'),
            'store_document' => $fileName_doc,
			'store_image' => $fileName_img,
		]);
		
		$this->session->setFlashdata('pesan', 'Formulirmu berhasil dikirim.');

		return redirect()->to('/catalog')->withInput();
    }
}

?>