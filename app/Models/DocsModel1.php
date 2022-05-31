<?php

namespace App\Models;

use CodeIgniter\Model;

class SentenceModel extends Model
{
    protected $table = 'sentence';
    protected $allowedFields = ['sentence_id', 'doc_id', 'text_sentence', 'key_sentence'];
}
