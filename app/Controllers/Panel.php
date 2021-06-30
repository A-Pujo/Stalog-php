<?php

namespace App\Controllers;

class Panel extends BaseController
{
    protected $TOKO, $PRODUK, $CATEGORY, $LOKASI, $GROUPUSER;

    function __construct()
    {
        $this->TOKO = new \App\Models\M_Toko();
        $this->PRODUK = new \App\Models\M_Produk();
        $this->CATEGORY = new \App\Models\M_Category();
        $this->LOKASI = new \App\Models\M_Lokasi();
        $this->GROUPUSER = new \App\Models\M_Group_User();
    }

    public function index()
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }

        else if (in_groups('admin')) {

            $data = [
                'title' => 'Dashboard',
                'activeMenu' => '1',
                'tokoAktif' => $this->TOKO->where(['active' => 1,])->findAll(),
                'tokoPending' => $this->TOKO->where(['active' => 0,])->findAll(),
                'produk' => $this->PRODUK->findAll(),
            ];

        }

        else {
            $toko = $this->TOKO->where(['user_id' => user()->id])->first();

            $data = [
                'title' => 'Dashboard',
                'activeMenu' => '1',
                'toko' => $toko,
                'produkAktif' => $this->PRODUK->where(['is_active' => 1, 'store_id' => $toko['id'],])->findAll(),
                'produkTotal' => $this->PRODUK->where(['store_id' => $toko['id']])->findAll(),
            ];
        }
        

        echo view('Components/Panel/Header', $data);
        echo view('Components/Panel/Sidebar', $data);
        echo view('Components/Panel/MainHeader', $data);
        echo view('Pages/Panel/Dashboard', $data);
        echo view('Components/Panel/Footer', $data);
    }

    public function listProduk()
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }

        else if (in_groups('admin')) {

            $data = [
                'title' => 'Produk',
                'activeMenu' => '2.1',
                'produk' => $this->PRODUK->join('store', 'store.id = products.store_id')->join('product_category', 'product_category.id = products.category_id')->findAll(),
            ];

        }

        else {

            $toko = $this->TOKO->where(['user_id' => user()->id,])->first();

            $data = [
                'title' => 'Produk',
                'activeMenu' => '2.1',
                'produk' => $this->PRODUK->where(['store_id' => $toko['id']])->join('product_category', 'product_category.id = products.category_id')->findAll(),
                'category' => $this->CATEGORY->findAll(),
                'toko' => $toko,
            ];
        }

        echo view('Components/Panel/Header', $data);
        echo view('Components/Panel/Sidebar', $data);
        echo view('Components/Panel/MainHeader', $data);
        echo view('Pages/Panel/Produk', $data);
        echo view('Components/Panel/Footer', $data);
    }

    public function listToko()
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Daftar Toko',
            'activeMenu' => '3.1',
            'toko' => $this->TOKO->where(['active' => 1,])->findAll(),
        ];

        echo view('Components/Panel/Header', $data);
        echo view('Components/Panel/Sidebar', $data);
        echo view('Components/Panel/MainHeader', $data);
        echo view('Pages/Panel/Toko', $data);
        echo view('Components/Panel/Footer', $data);
    }

    public function pengajuanToko()
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Daftar Toko Pending',
            'activeMenu' => '3.2',
            'toko' => $this->TOKO->where(['active' => 0])->findAll(),
        ];

        echo view('Components/Panel/Header', $data);
        echo view('Components/Panel/Sidebar', $data);
        echo view('Components/Panel/MainHeader', $data);
        echo view('Pages/Panel/TokoPending', $data);
        echo view('Components/Panel/Footer', $data);
    }

    public function profil()
    {
        if (! in_groups('store_owner')) {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Profil',
            'activeMenu' => '',
            'toko' => $this->TOKO->where(['user_id' => user()->id])->first(),
            'lokasi' => $this->LOKASI->findAll(),
        ];

        echo view('Components/Panel/Header', $data);
        echo view('Components/Panel/Sidebar', $data);
        echo view('Components/Panel/MainHeader', $data);
        echo view('Pages/Panel/Profil', $data);
        echo view('Components/Panel/Footer', $data);
    }

    public function updateprofil($id)
    {
        if (! in_groups('store_owner')) {
            return redirect()->to(base_url());
        }

        
        if($this->request->getVar('name') != $this->request->getVar('old_name')) 
        {
            $name_rules = 'required|is_unique[store.name]';
            $name_errors = [
                'required' => 'Nama toko harus diisi.',
                'is_unique' => 'Toko sudah terdaftar.',
            ];
        } else
        {
            $name_rules = 'required';
            $name_errors = [
                'required' => 'Nama toko harus diisi.',
            ];
        }

        if(!$this->validate([
			'name' => [
				'rules' => $name_rules,
				'errors' => $name_errors,
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
			'customFile' => [
				'rules' => 'max_size[customFile, 3000]|ext_in[customFile,jpg,png,jpeg]',
				'errors' => [
					'max_size' => 'Ukuran gambar terlalu besar.',
					'ext_in' => 'Format gambar tidak sesuai.',
				],
			],
		])){
			$this->session->setFlashdata('errors', $this->validation->listErrors());
			return redirect()->to('/panel/profil')->withInput();
		}

		// Upload file
        // dd($this->request->getFile('customFile'));
        if ($this->request->getFile('customFile')->isValid()) {
            $file = $this->request->getFile('customFile');
            $fileName = $file->getRandomName();
            $file->move('assets/uploads/store_image/', $fileName);
            if($this->request->getVar('old_pic') != 'default.png'){
                unlink('assets/uploads/store_image/' . $this->request->getVar('old_pic'));
            }
        }
        
        else{
            $fileName = $this->request->getVar('old_pic');
        }


		$this->TOKO->save([
            'id' => $id,
			'name' => $this->request->getVar('name'),
            'slug' => $this->request->getVar('slug'),
            'regency_id' => $this->request->getVar('regency'),
            'social_instagram' => $this->request->getVar('social_instagram'),
            'store_whatsapp' => $this->request->getVar('store_whatsapp'),
            'user_whatsapp' => $this->request->getVar('user_whatsapp'),
			'store_image' => $fileName,
		]);
		
		$this->session->setFlashdata('pesan', 'Data berhasil diperbarui.');

		return redirect()->to('/panel/profil');
    }

    public function tambahproduk()
    {
        if (! in_groups('store_owner')) {
            return redirect()->to(base_url());
        }

        $toko = $this->TOKO->where(['user_id' => user()->id])->first();

        // dd($this->request->getPost());

        if(!$this->validate([
			'title' => [
				'rules' => 'required|is_unique[products.title]',
				'errors' => [
					'required' => 'Judul produk harus diisi.',
					'is_unique' => 'Produk sudah terdaftar.',
				],
			],
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori produk harus diisi.'
                ],
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi produk harus diisi.'
                ],
            ],
			'customFile' => [
				'rules' => 'uploaded[customFile]|max_size[customFile,3000]|ext_in[customFile,jpg,png,jpeg]',
				'errors' => [
					'uploaded' => 'Gambar tidak dipilih.',
					'max_size' => 'Ukuran gambar terlalu besar.',
					'ext_in' => 'Format gambar tidak sesuai.',
				],
			],
            'price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga produk harus diisi.'
                ],
            ],
		])){
			$this->session->setFlashdata('errors', $this->validation->listErrors());
			return redirect()->to('/panel/produk')->withInput();
		}

		// Upload file
        $fileName = '';
        if($imagefile = $this->request->getFiles())
        {
            foreach($imagefile['customFile'] as $img)
            {
                if ($img->isValid() && ! $img->hasMoved())
                {
                    $newName = $img->getRandomName();
                    $img->move('assets/uploads/product_image/', $newName);
                    $fileName .= $newName . ';';
                }
            }
        }

		$this->PRODUK->save([
            'store_id' => $toko['id'],
			'title' => $this->request->getVar('title'),
            'title_hash' => $this->request->getVar('title_hash'),
            'category_id' => (int)$this->request->getVar('category'),
            'description' => $this->request->getVar('description'),
			'image' => $fileName,
            'price' => $this->request->getVar('price'),
            'is_active' => $this->request->getVar('is_active'),
            'in_stock' => $this->request->getVar('in_stock'),
		]);
		
		$this->session->setFlashdata('pesan', 'Data berhasil ditambahkan.');

		return redirect()->to('/panel/produk');
    }

    public function aktivasitoko($id)
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }
        
        $toko = $this->TOKO->where(['id' => $id])->first();
        $this->GROUPUSER->where(['user_id' => $toko['user_id'],])->update(null, ['group_id' => 2]);
        
        $this->TOKO->save([
            'id' => $id,
            'active' => 1,
        ]);

        $this->session->setFlashdata('pesan', 'Toko berhasil diaktifkan.');

		return redirect()->to('/panel/toko-pending');
    }

    public function disabletoko($id)
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }
        
        $toko = $this->TOKO->where(['id' => $id])->first();
        $this->GROUPUSER->where(['user_id' => $toko['user_id'],])->update(null, ['group_id' => 1]);
        
        $this->TOKO->save([
            'id' => $id,
            'active' => 0,
        ]);

        $this->session->setFlashdata('pesan', 'Toko berhasil dinonaktifkan.');

		return redirect()->to('/panel/daftar-toko');
    }

    public function disableproduk($id)
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }

        $this->PRODUK->where(['idp' => $id])->update(null, ['is_active' => 0,]);

        $this->session->setFlashdata('pesan', 'Produk berhasil dinonaktifkan.');

		return redirect()->to('/panel/produk');
    }

    public function emptyproduk($id)
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }
        
        $this->PRODUK->where(['idp' => $id])->update(null, ['in_stock' => 0,]);

        $this->session->setFlashdata('pesan', 'Produk berhasil dikosongkan.');

		return redirect()->to('/panel/produk');
    }

    public function enableproduk($id)
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }
        
        $this->PRODUK->where(['idp' => $id])->update(null, ['is_active' => 1,]);

        $this->session->setFlashdata('pesan', 'Produk berhasil diaktifkan.');

		return redirect()->to('/panel/produk');
    }

    public function repopulateproduk($id)
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }
        
        $this->PRODUK->where(['idp' => $id])->update(null, ['in_stock' => 1,]);

        $this->session->setFlashdata('pesan', 'Data produk berhasil diubah.');

		return redirect()->to('/panel/produk');
    }

    public function ajaxUpdateHelper()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('idp');
            $price = $this->request->getGet('price');
            $curCategory = $this->request->getGet('cur_category');

            if($price){
                $this->PRODUK->where(['idp' => $id])->update(null, ['price' => $price]);
            }
            else{
                $this->PRODUK->where(['idp' => $id])->update(null, ['category_id' => $curCategory]);
            }
            
            return json_encode(['success'=> 'success', 'csrf' => csrf_hash(), 'idp' => $id ]);
        }
    }
}

?>