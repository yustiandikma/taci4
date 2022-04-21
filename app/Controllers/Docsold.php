<?php

namespace App\Controllers;

use App\Models\DocsModel;
use Spatie\PdfToText\Pdf;
use App\Controllers\BaseController;

class Docs extends BaseController
{
    protected $docsModel;
    public function __construct()
    {
        $this->docsModel = new DocsModel();
    }


    public function index()
    {
        $docs = $this->docsModel->findAll();
        $data = [
            'title' => 'Docs Index',
            'docs'  => $docs
        ];

        return view('docs/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data',
            'validation' => \Config\Services::validation()
        ];

        return view('docs/create', $data);
    }

    public function save()
    {
        //validasi input

        // if (!$this->validate([
        //     'author' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'Author harus diisi.'
        //         ]
        //     ],
        //     'release_year' => [
        //         'rules' => 'required|is_natural',
        //         'errors' => [
        //             'required' => 'Tahun harus diisi.',
        //             'is_natural' => 'Kolom Tahun Rilis Harus Diisi Angka'
        //         ]
        //     ],
        //     'file_name' => [
        //         'rules' => 'uploaded[file_name]|max_size[file_name,15000]|mime_in[file_name,application/pdf]',
        //         'errors' => [
        //             'uploaded' => 'Pilih File Dokumen Terlebih Dahulu',
        //             'max_size' => 'Ukuran File Terlalu Besar',
        //             'mime_in'  => 'File Yang Dipilih Bukan Berformat PDF'
        //         ]
        //     ]
        // ])) {
        //     $validation = \Config\Services::validation();
        //     // return redirect()->to('docs/create')->withInput()->with('validation', $validation);
        //     return redirect()->to('docs/create')->withInput();
        // }

        // //ubah nama menjadi besar di tiap kata
        // $authorKata = $this->request->getVar('author');
        // $authorKata = ucwords($authorKata);

        // // dd($authorKata);

        // //ambil dokumen
        // $fileDokumen = $this->request->getFile('file_name');
        // // dd($fileDokumen);

        // //pindahkan file ke folder dokumen
        // $fileDokumen->move('doc');

        // //ambil nama file dokumen
        // $namaDokumen = $fileDokumen->getName();
        // $namaDokumen = str_replace(' ', '', $namaDokumen);
        // $namaDokumen = preg_replace("/[-_]/", "", $namaDokumen);

        // // dd($namaDokumen);

        // // //ambil dokumen untuk di proses
        // // $getDokumen = $this->request->getFile('file_name');
        // // // dd($getDokumen);

        // // dd($fileDokumen);
        // // $pdfToText = (new Pdf())->setPDF($namaDokumen)->text();
        // // $pdfToText = Pdf::getText(base_url() . "/public/doc/".$namaDokumen);
        // // dd($pdfToText);


        // $this->docsModel->save([
        //     'file_name' => $namaDokumen,
        //     'author' => $authorKata,
        //     'release_year' => $this->request->getVar('release_year'),
        // ]);


        $namaDokumen = "PreprocessingTextuntukMeminimalisirKatayangTidakBerartidalamProsesTextMining.pdf";
        //prosed dokumen pdf menggunakan library


        $pdfToText = Pdf::getText('./public/doc/' . $namaDokumen);
        dd($pdfToText);
        die();

        session()->setFlashdata('pesan', 'Data Telah Berhasil Ditambahkan!');

        return redirect()->to('/');
    }
}
