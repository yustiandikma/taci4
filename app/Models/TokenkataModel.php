<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenkataModel extends Model
{
    protected $table = 'tokenkata';
    protected $allowedFields = [
        'token'
    ];
}
