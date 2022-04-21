<?php

namespace App\Models;

use CodeIgniter\Model;

class DocsModel extends Model
{
    protected $table = 'docs';
    protected $allowedFields = ['file_name', 'author', 'release_year'];
}


