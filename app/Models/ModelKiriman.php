<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKiriman extends Model
{
    protected $table            = 'kiriman';
    protected $primaryKey       = 'id_kiriman';
    protected $allowedFields    = [
        'id_kiriman', 'nama_barang', 'berat', 'pecah_belah', 'cover', 'asuransi',
     ];
}
