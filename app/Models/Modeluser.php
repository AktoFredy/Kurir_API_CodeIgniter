<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeluser extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'idU';
    protected $allowedFields    = [
        'idU', 'email', 'username', 'password', 'tanggalLahir', 'noTelepon' 
    ];

}
