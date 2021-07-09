<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Package extends Model
{
    protected $table = 'package';
    protected $useTimestamps = false;
    protected $allowedFields = ['package_name', 'product_ids'];
}

?>