<?php

namespace App\Models;

use CodeIgniter\Model;

class DocsModel extends Model
{
    protected $table = 'docs';
    protected $allowedFields = ['file_name', 'author', 'release_year'];
}

class DocsModel1 extends Model
{

    protected $table = 'sentence';
    protected $allowedFields = ['sentence_id', 'text_sentence', 'key_sentence'];
}

class DocsModel2 extends Model
{
    protected $table = 'text';
    protected $allowedFields = ['token_id', 'sentence_id', 'token'];
}
