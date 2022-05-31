<?php

namespace App\Models;

use CodeIgniter\Model;

class SentenceModel extends Model
{
    protected $table = 'text';
    protected $allowedFields = ['token_id', 'sentence_id', 'token'];
}
