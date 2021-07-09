<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Toko extends Model
{
    protected $table = 'store';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'name', 'slug', 'store_desc', 'regency_id', 'store_image', 'store_document', 'active', 'social_instagram', 'ext_link', 'store_whatsapp', 'user_whatsapp'];
}

?>