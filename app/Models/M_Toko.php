<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Toko extends Model
{
    protected $table = 'store';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'name', 'slug', 'store_image', 'store_document', 'active', 'social_instagram', 'store_whatsapp', 'user_whatsapp'];
}

?>