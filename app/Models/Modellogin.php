<?php

namespace App\Models;

use CodeIgniter\Model;

class Modellogin extends Model
{
    protected $table = 'users';
    public function ceklogin($username){
        $query = $this->table($this->table)->getWhere(['username' => $username]);
        return $query;
    }
}
