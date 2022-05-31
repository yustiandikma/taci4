<?php

namespace App\Controllers;

// require __DIR__ . '/vendor/autoload.php';

use App\Models\DocsModel;
use Spatie\PdfToText\Pdf;
use App\Models\DocsModel1;
use App\Models\DocsModel2;
use Vanderlee\Sentence\Sentence;
use App\Controllers\BaseController;

class Docs extends BaseController
{
    protected $docsModel;
    protected $docsModel1;
    protected $docsModel2;

    public function __construct()
    {
        $this->docsModel = new DocsModel();

        $this->docsModel1 = new DocsModel1();

        $this->docsModel2 = new DocsModel2();
    }

    // protected $sentenceModel;
    // // public function __construct()
    // {
    //     $this->sentenceModel = new SentenceModel();
    // }


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

        if (!$this->validate([
            'author' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Author harus diisi.'
                ]
            ],
            'release_year' => [
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'Tahun harus diisi.',
                    'is_natural' => 'Kolom Tahun Rilis Harus Diisi Angka'
                ]
            ],
            'file_name' => [
                'rules' => 'uploaded[file_name]|max_size[file_name,15000]|mime_in[file_name,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih File Dokumen Terlebih Dahulu',
                    'max_size' => 'Ukuran File Terlalu Besar',
                    'mime_in'  => 'File Yang Dipilih Bukan Berformat PDF'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            // return redirect()->to('docs/create')->withInput()->with('validation', $validation);
            return redirect()->to('docs/create')->withInput();
        }

        //ubah nama menjadi kecil di tiap kata
        $authorKata = $this->request->getVar('author');
        $authorKata = ucwords($authorKata);

        // // dd($authorKata);

        //ambil dokumen
        // $fileDokumen = $this->request->getFiles('file_name');
        // dd($fileDokumen);
        $fileDokumen = $this->request->getFile('file_name');

        //memulai library pdftotext
        $path = 'c:/Program Files/Git/mingw64/bin/pdftotext';
        $pdfttxt  = Pdf::getText($fileDokumen, $path);

        //cleaning pertama
        $pdfttxtCsfdg =
            preg_replace('/[^\p{L}\p{N}.]/', " ", $pdfttxt);

        //create a new instance
        $sentence = new Sentence;

        //memulai library text to sentences
        //split into array of sentences
        $sentences = $sentence->split($pdfttxtCsfdg);

        //cleaning ke 2
        $pdfttxtCsfdg1 =
            preg_replace('/[^\p{L}\p{N}]/', " ", $sentences);

        //pindahkan file ke folder dokumen
        $fileDokumen->move('doc');
        // dd($fileDokumen);

        //ambil nama file dokumen
        $namaDokumen = $fileDokumen->getName();

        //proses penyimpanan ke tabel docs
        $this->docsModel->save([
            'file_name' => $namaDokumen,
            'author' => $authorKata,
            'release_year' => $this->request->getVar('release_year'),
        ]);

        //mendapatakan last id dari tabel docs
        $lastIdDocs = $this->docsModel->getInsertID();
        d($lastIdDocs);

        $n = sizeof($pdfttxtCsfdg1);
        for ($i = 0; $i < $n; $i++) {
            // echo ("1. $pdfttxtCsfdg1[$i]. \n ");
            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
            $output = $stemmer->stem($pdfttxtCsfdg1[$i]);
            // dd($output);
            d($output);
            $exxpplode = explode(
                ' ',
                $output
            );
            d($exxpplode);
        }


        die;

        session()->setFlashdata('pesan', 'Data Telah Berhasil Ditambahkan!');
        //mengembalikan di page awal 

        return redirect()->to('/');
    }
}
