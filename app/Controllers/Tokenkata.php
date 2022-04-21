<?php

namespace App\Controllers;

use CodeIgniter\Model;
use App\Models\TokenkataModel;
use App\Controllers\BaseController;

class tokenkata extends BaseController
{
    protected $tokenkataModel;
    public function __construct()
    {
        $this->tokenkataModel = new TokenkataModel();
    }

    public function index()
    {
        $tokenkata = $this->tokenkataModel->findAll();
        $data = [
            'title' => 'Daftar Kata',
            'tokenkata' => $tokenkata
        ];

        return view('tokenkata/index', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'title' => 'Form Tambah Data',
            'validation' => \Config\Services::validation(),
        ];

        return view('tokenkata/create', $data);
    }

    public function save()
    {
        // dd($this->request->getVar());

        //validasi input
        // if (!$this->validate([
        //     'dokumen' => [
        //         'rules' => 'uploaded',
        //         'errors' => [
        //             'uploaded' => 'silahkan pilih {field} terlebih dahulu'
        //         ]
        //     ]
        // ])) {
        //     $validation = \Config\Services::validation();
        //     // dd($validation);
        //     return redirect()->to('/tokenkata/create')->withInput()->with('validation', $validation);
        // }

        if (!$this->validate([
            'dokumen' => [
                'rules' => 'uploaded[dokumen]|max_size[dokumen,15000]|mime_in[dokumen,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih File Dokumen Terlebih Dahulu',
                    'max_size' => 'Ukuran File Terlalu Besar',
                    'mime_in'  => 'File Yang Dipilih Bukan Berformat PDF'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            // dd($validation);
            // return redirect()->to('/tokenkata/create')->withInput()->with('validation', $validation);
            return redirect()->to('/tokenkata/create')->withInput();
        }

        // ambil dokumen
        $fileDokumen = $this->request->getFile('dokumen');

        dd($fileDokumen);

        //pindahkan file ke folder dokumen
        $fileDokumen->move('doc');

        //ambil nama file
        $namaDokumen = $fileDokumen->getName();


        $this->tokenkataModel->save([
            'token' => $namaDokumen
        ]);

        session()->setFlashdata('pesan', 'Data Telah Berhasil Ditambahkan!');

        return redirect()->to('/');
    }
}
