<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelpengiriman extends Model
{
    protected $table            = 'pengiriman';
    protected $primaryKey       = 'idP';
    protected $allowedFields    = [
        'idP', 'namaPengirim', 'namaPenerima', 'desBarang', 'kotaAsal', 'kotaTujuan', 'alamatLengkap', 'ongkos'
     ];
    
}
