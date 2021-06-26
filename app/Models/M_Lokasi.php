<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Lokasi extends Model
{
    protected $table = 'regencies';
    protected $useTimestamps = false;
    protected $allowedFields = ['name'];
}

?>