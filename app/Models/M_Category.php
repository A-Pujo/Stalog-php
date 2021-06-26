<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Category extends Model
{
    protected $table = 'product_category';
    protected $useTimestamps = false;
    protected $allowedFields = ['category'];
}

?>