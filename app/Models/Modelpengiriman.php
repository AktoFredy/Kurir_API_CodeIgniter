<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelpengiriman extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengiriman';
    protected $primaryKey       = 'idP';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'namaPengirim', 'namaPenerima', 'desBarang', 'kotaAsal', 'kotaTujuan', 'alamatLengkap', 'ongkos'
     ];
    
}
