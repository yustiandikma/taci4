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

        //ubah nama menjadi besar di tiap kata
        $authorKata = $this->request->getVar('author');
        $authorKata = ucwords($authorKata);

        // // dd($authorKata);

        //ambil dokumen
        // $fileDokumen = $this->request->getFiles('file_name');
        // dd($fileDokumen);
        $fileDokumen = $this->request->getFile('file_name');

        $path = 'c:/Program Files/Git/mingw64/bin/pdftotext';
        $pdfttxt  = Pdf::getText($fileDokumen, $path);
        // return $pdfttxt;
        // dd($pdfttxt);
        // echo $pdfttxt;
        // die;

        // // This is the test text we're going to use


        // // Create a new instance
        // $Sentence    = new Sentence;

        // // Split into array of sentences
        // $sentences    = $Sentence->split($pdfttxt);

        // dd($sentences);
        // var_dump($sentences);
        // die;


        // Count the number of sentences
        // $count        = $Sentence->count($text);

        $pdfttxtCsfdg =
            preg_replace('/[^\p{L}\p{N}.]/', " ", $pdfttxt);
        // dd($pdfttxtCsfdg);
        // echo $pdfttxtCsfdg;
        // die;

        //create a new instance
        $sentence = new Sentence;

        //split into array of sentences
        $sentences = $sentence->split($pdfttxtCsfdg);

        $pdfttxtCsfdg1 =
            preg_replace('/[^\p{L}\p{N}]/', " ", $sentences);


        // dd($pdfttxtCsfdg1);



        // $sentences = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $pdfttxtCsfdg);

        // dd($sentences);

        // echo $sentences;
        // die;

        // echo $pdfttxtCsfdg;
        // die;

        // dd($pdfttxtCsfdg);

        // $token = explode('.', $pdfttxtCsfdg);

        // dd($colors);
        // d($pdfttxtCsfdg1);
        //size off mengembalikan jumlah elemen dalam array , size of adalah alias dari fungsi count().

        $n = sizeof($pdfttxtCsfdg1);
        for ($i = 0; $i < $n; $i++) {
            // echo ("1. $pdfttxtCsfdg1[$i]. \n ");
            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
            $output = $stemmer->stem($pdfttxtCsfdg1[$i]);
            // dd($output);
            d($output);
            $exxpplode = explode(' ', $output);
            d($exxpplode);
        }
        // d($output);
        // die;

        // $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        // $stemmer  = $stemmerFactory->createStemmer();
        // // $output   = $stemmer->stem($pdfttxtCsfdg1);

        // foreach ($pdfttxtCsfdg1 as $stem) {
        //     # code...
        //     // print($stem);
        //     // die;
        //     $output = $stemmer->stem($stem);
        //     var_dump($output);
        //     // echo $output;
        //     die;
        // }

        // dd($output);

        // echo $output;

        // die;
        // foreach ($pdfttxtCsfdg1 as $p =>) {
        // }

        // $token    =
        //     explode(" ", $output);

        // dd($token);
        // dd($output);



        // dd($token);

        // dd($tokens);

        // $del = " ";
        // $token = strtok($pdfttxtCsfdg, $del);
        // while ($token !== false) {
        //     echo "$token \n";
        //     $token = strtok($del);
        // }

        // dd($token);

        // dd($pdfttxtCsfdg);

        // // echo ($pdfttxtCsfdg);
        // // die;
        // $pdfttxtPregSplit =
        //     preg_split('/(?<=[!?.])./', $pdfttxtCsfdg);

        // $pdfttxtCsfdg1 = preg_replace("/./", ' ', $pdfttxtPregSplit);
        // // dd($pdfttxtCsfdg1);
        // $tokenizer = new Word();

        // dd($tokenizer);

        // dd($pdfttxtPregSplit);
        // // echo $pdfttxtPregSplit;
        // // die;

        // // dd($pdfttxtTrim);
        // // echo $pdfttxtTrim;
        // // die;

        // $tokenizer = new NGram(1, 3);


        // // dd($tokenizer);
        // echo $tokenizer;
        // die;


        // $tokenizer = new NGram(1, 3);
        // $transformer = new TokenHashingVectorizer(10000, new NGram(1, 2));

        // $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        // $stemmer  = $stemmerFactory->createStemmer();

        // $output   = $stemmer->stem($pdfttxtTrim);

        // echo $output;
        // die;
        // dd($fileDokumen);
        // $getText =
        //     Pdf::getText($fileDokumen);
        // dd($getText);

        // // bersihkan string nama dokumen
        // $namaFileDokumen = preg_replace("/[-_]/", "", $fileDokumen);
        // // dd($namaFileDokumen);

        //pindahkan file ke folder dokumen
        $fileDokumen->move('doc');
        // dd($fileDokumen);

        // $path = 'c:/Program Files/Git/mingw64/bin/pdftotext';
        // $pdftotext = Pdf::getText($fileDokumen, $path);

        // dd($pdftotext);

        //ambil nama file dokumen
        $namaDokumen = $fileDokumen->getName();

        // dd($fileDokumen);
        // $path = 'c:/Program Files/Git/mingw64/bin/pdftotext';
        // $fPath = '\public\doc';
        // $pdftotext = Pdf::getText($namaDokumen, $fPath);
        // // $text = (new Pdf())
        //     ->setPdf($namaDokumen)
        //     ->text();
        // $temppath = 'C:/xampp/tmp';
        // $path = 'c:/Program Files/Git/mingw64/bin/pdftotext';
        // echo Pdf::getText($temppath . $fileDokumen, $path);

        // dd($pdftotext);

        // $namaDokumen = str_replace(' ', '', $namaDokumen);
        // $namaDokumen = preg_replace("/[-_]/", "", $namaDokumen);

        // dd($namaDokumen);

        // // //ambil dokumen untuk di proses
        // // $getDokumen = $this->request->getFile('file_name');
        // // // dd($getDokumen);

        // // dd($fileDokumen);
        // // $pdfToText = (new Pdf())->setPDF($namaDokumen)->text();
        // // $pdfToText = Pdf::getText(base_url() . "/public/doc/".$namaDokumen);
        // // dd($pdfToText);


        $this->docsModel->save([
            'file_name' => $namaDokumen,
            'author' => $authorKata,
            'release_year' => $this->request->getVar('release_year'),
        ]);

        $id = $this->docsModel->getInsertID();
        dd($id);

        // $dosc1 =
        //     $this->docsModel->findAll();

        // $getLastId = DB::statement()

        // dd($getLastId);

        // // $docsfid = $this->docsModel->get('id');

        // // dd($docsfid);

        // dd($dosc1);


        // $this->docsModel1->save(
        //     [
        //         'doc_id' => ,
        //         'text_sentence' => ,
        //         'key_sentence' =>,
        //     ]
        // );


        // $namaDokumen = "PreprocessingTextuntukMeminimalisirKatayangTidakBerartidalamProsesTextMining.pdf";
        // //prosed dokumen pdf menggunakan library


        // $pdfToText = Pdf::getText('./public/doc/' . $namaDokumen);
        // dd($pdfToText);
        // die();

        die;

        session()->setFlashdata('pesan', 'Data Telah Berhasil Ditambahkan!');
        //mengembalikan di page awal 

        return redirect()->to('/');
    }
}
