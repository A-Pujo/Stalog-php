<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Produk extends Model
{
    protected $table = 'products';
    protected $useTimestamps = true;
    protected $allowedFields = ['store_id', 'title', 'title_hash', 'category_id', 'description', 'image', 'price', 'in_stock', 'is_active'];
}

?>