<?php

namespace App\Controllers;


class Panel extends BaseController
{
    protected $TOKO, $PRODUK, $CATEGORY, $PACKAGE, $LOKASI, $GROUPUSER, $Email;

    function __construct()
    {
        $this->TOKO = new \App\Models\M_Toko();
        $this->PRODUK = new \App\Models\M_Produk();
        $this->CATEGORY = new \App\Models\M_Category();
        $this->PACKAGE =  new \App\Models\M_Package();
        $this->LOKASI = new \App\Models\M_Lokasi();
        $this->GROUPUSER = new \App\Models\M_Group_User();
        $this->Email = \Config\Services::email();
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
                'tokoAktif' => $this->TOKO->join('users', 'users.id = store.user_id')->where(['store.active' => 1,])->findAll(),
                'tokoPending' => $this->TOKO->where(['active' => 0,])->findAll(),
                'produk' => $this->PRODUK->findAll(),
                'paketProduk' => $this->PACKAGE->findAll(),
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

        // dd($this->TOKO->select('*, users.updated_at as UUA, store.updated_at as supdated_at')->join('users', 'users.id = store.user_id')->where(['store.active' => 1,])->findAll());

        $data = [
            'title' => 'Daftar Toko',
            'activeMenu' => '3.1',
            'toko' => $this->TOKO->select('*, users.updated_at as UUA, store.updated_at as supdated_at')->join('users', 'users.id = store.user_id')->where(['store.active' => 1,])->findAll(),
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
            'toko' => $this->TOKO->join('users', 'users.id = store.user_id')->where(['store.active' => 0])->findAll(),
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
            'store_desc' => $this->request->getVar('store_desc'),
            'regency_id' => $this->request->getVar('regency'),
            'social_instagram' => $this->request->getVar('social_instagram'),
            'ext_link' => $this->request->getVar('ext_link'),
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
            'is_active' => 1,
            'in_stock' => $this->request->getVar('in_stock'),
		]);
		
		$this->session->setFlashdata('pesan', 'Data berhasil ditambahkan.');

		return redirect()->to('/panel/produk');
    }

    public function tambahPackage()
    {

        // dd($this->request->getVar('products'));
        if(! in_groups('admin')){
            return redirect()->to(base_url() . '/panel');
        }

        if(!$this->validate([
            'package-name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Paket harus diisi.',
                ],
            ],
            'products' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus ada minimal 1 produk.'
                ],
            ]
        ])){
            $this->session->setFlashdata('errors', $this->validation->listErrors());
            return redirect()->to(base_url() . '/panel')->withInput();
        }

        $this->PACKAGE->save([
            'package_name' => $this->request->getVar('package-name'),
            'product_ids' => implode(';', $this->request->getVar('products')),
        ]);

        $this->session->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to(base_url() . '/panel')->withInput();
    }

    public function hapusPackage($id)
    {
        if(! in_groups('admin')){
            return redirect()->to(base_url() . '/panel');
        }

        $this->PACKAGE->delete($id);

        $this->session->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url() . '/panel')->withInput();
    }

    public function aktivasitoko($slug)
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }
        
        $toko = $this->TOKO->join('users', 'users.id = store.user_id')->where(['slug' => $slug])->first();
        // dd(empty($toko));

        if(! empty($toko)){
            
            $this->Email->setFrom($this->Email->fromEmail, $this->Email->fromName);
            $this->Email->setTo($toko['email']);
            $this->Email->setSubject('Aktivasi Toko');
            $this->Email->setMessage('Selamat! Tokomu sudah diaktifkan oleh pihak admin Lapak Stanner.');
            $this->Email->send();

            $this->GROUPUSER->where(['user_id' => $toko['user_id'],])->update(null, ['group_id' => 2]);
            
            $this->TOKO->where(['slug' => $slug,])->update(null, ['active' => 1]);
    
            $this->session->setFlashdata('pesan', 'Toko berhasil diaktifkan.');
    
            return redirect()->to('/panel/toko-pending');
        }

        $this->session->setFlashdata('errors', 'Toko gagal diaktifkan.');
    
        return redirect()->to('/panel/toko-pending');
    }

    public function disabletoko($slug)
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }
        
        $toko = $this->TOKO->join('users', 'users.id = store.user_id')->where(['slug' => $slug])->first();

        if(! empty($toko)){

            $this->Email->setFrom($this->Email->fromEmail, $this->Email->fromName);
            $this->Email->setTo($toko['email']);
            $this->Email->setSubject('Penonaktifan Toko');
            $this->Email->setMessage('Mohon maaf. Tokomu dinonaktifkan oleh pihak admin Lapak Stanner. <br>Silahkan hubungi admin untuk konfirmasi!');
            $this->Email->send();

            $this->GROUPUSER->where(['user_id' => $toko['user_id'],])->update(null, ['group_id' => 1]);
            
            $this->TOKO->where(['slug' => $slug,])->update(null, ['active' => 0]);
    
            $this->session->setFlashdata('pesan', 'Toko berhasil dinonaktifkan.');
    
            return redirect()->to('/panel/daftar-toko');
        }

        $this->session->setFlashdata('errors', 'Toko gagal dinonaktifkan.');
    
        return redirect()->to('/panel/daftar-toko');
    }

    public function hapustoko($slug)
    {
        if (! in_groups('admin')) {
            return redirect()->to(base_url());
        }
        
        $toko = $this->TOKO->join('users', 'users.id = store.user_id')->where(['slug' => $slug, 'store.active' => 0,])->first();

        if(! empty($toko)){

            $this->Email->setFrom($this->Email->fromEmail, $this->Email->fromName);
            $this->Email->setTo($toko['email']);
            $this->Email->setSubject('Penolakan Pengajuan Toko');
            $this->Email->setMessage('Mohon maaf. Pengajuan tokomu tidak bisa diterima karena adanya ketidaksesuain data. <br>Silahkan ajukan lagi di lain waktu dengan data yang sesuai!');
            $this->Email->send();
            
            $this->TOKO->where(['slug' => $slug, 'active' => 0])->delete();

            $this->session->setFlashdata('pesan', 'Pengajuan toko berhasil dihapus.');

            return redirect()->to('/panel/daftar-toko');
        }

        $this->session->setFlashdata('errors', 'Pengajuan toko gagal dihapus.');

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

    public function enableproduk($id)
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }
        
        $this->PRODUK->where(['idp' => $id])->update(null, ['is_active' => 1,]);

        $this->session->setFlashdata('pesan', 'Produk berhasil diaktifkan.');

        return redirect()->to('/panel/produk');
    }

    public function hapusproduk($id)
    {
        if (in_groups('guests')) {
            return redirect()->to(base_url());
        }
        
        $dataRow = $this->PRODUK->join('store', 'store.id = products.store_id')->join('users', 'users.id = store.user_id')->where(['users.id' => user()->id ,'idp' => $id, 'is_active' => 0])->first();

        if(empty($dataRow)){
            $this->session->setFlashdata('errors', 'Produk yang kamu maksud tidak ditemukan.');

            return redirect()->to('/panel/produk');   
        } else {
            $images = explode(';', $dataRow['image']);
            array_pop($images);
            // dd($images);

            foreach ($images as $img) {
                unlink('assets/uploads/product_image/' . $img);
            }

            $this->PRODUK->where(['idp' => $id, 'is_active' => 0])->delete();

            $this->session->setFlashdata('pesan', 'Produk ' . $dataRow['title'] . ' berhasil dihapus.');

            return redirect()->to('/panel/produk');   
        }
    }

    // public function emptyproduk($id)
    // {
    //     if (in_groups('guests')) {
    //         return redirect()->to(base_url());
    //     }
        
    //     $this->PRODUK->where(['idp' => $id])->update(null, ['in_stock' => 0,]);

    //     $this->session->setFlashdata('pesan', 'Produk berhasil dikosongkan.');

	// 	return redirect()->to('/panel/produk');
    // }

    // public function repopulateproduk($id)
    // {
    //     if (in_groups('guests')) {
    //         return redirect()->to(base_url());
    //     }
        
    //     $this->PRODUK->where(['idp' => $id])->update(null, ['in_stock' => 1,]);

    //     $this->session->setFlashdata('pesan', 'Data produk berhasil diubah.');

	// 	return redirect()->to('/panel/produk');
    // }

    public function ajaxUpdateHelper()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('idp');
            $title = $this->request->getGet('title');
            $price = $this->request->getGet('price');
            $curCategory = $this->request->getGet('cur_category');
            $desc = $this->request->getGet('desc');
            $stock = $this->request->getGet('in_stock');

            if($price){
                $this->PRODUK->where(['idp' => $id])->update(null, ['price' => $price]);
            }
            else if($title){
                $this->PRODUK->where(['idp' => $id])->update(null, ['title' => $title]);
            }
            else if($curCategory){
                $this->PRODUK->where(['idp' => $id])->update(null, ['category_id' => $curCategory]);
            }
            else if($desc){
                $this->PRODUK->where(['idp' => $id])->update(null, ['description' => $desc]);
            }
            else if($stock){
                $this->PRODUK->where(['idp' => $id])->update(null, ['in_stock' => $stock]);
            }
            
            return json_encode(['success'=> 'success', 'csrf' => csrf_hash(), 'idp' => $id ]);
        }
    }
}

?>