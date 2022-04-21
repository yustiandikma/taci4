<?php

namespace App\Controllers;

class Beranda extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Beranda'
        ];

        return view('beranda', $data);
    }
}
