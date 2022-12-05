<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenerima extends Model
{
    protected $table            = 'penerima';
    protected $primaryKey       = 'id_penerima';
    protected $allowedFields    = [
        'id_penerima', 'nama_penerima', 'no_hp', 'gender', 'kode_pos'
     ];
}
