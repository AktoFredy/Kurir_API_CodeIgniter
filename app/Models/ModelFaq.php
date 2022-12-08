<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelFaq extends Model
{

    protected $table            = 'faq';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'question', 'answer',
     ];
}
