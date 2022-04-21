<?php

namespace App\Controllers;

// require __DIR__ . '/vendor/autoload.php';

use App\Models\DocsModel;
use Spatie\PdfToText\Pdf;
use Rubix\ML\Tokenizers\Word;
use Rubix\ML\Tokenizers\NGram;
use App\Controllers\BaseController;
use Rubix\ML\Tokenizers\Sentence;
use Rubix\ML\Transformers\TokenHashingVectorizer;


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
        $pdfttxt =  strtolower(Pdf::getText($fileDokumen, $path));
        // dd($pdfttxt);
        // echo $pdfttxt;
        // die;
        $pdfttxtCsfdg =
            preg_replace('/[^\p{L}\p{N}.]/', " ", $pdfttxt);

        // dd($pdfttxtCsfdg);

        // echo ($pdfttxtCsfdg);
        // die;
        $pdfttxtPregSplit =
            preg_split('/(?<=[!?.])./', $pdfttxtCsfdg);

        // $pdfttxtCsfdg1 = preg_replace("/./", ' ', $pdfttxtPregSplit);
        // // dd($pdfttxtCsfdg1);
        // $tokenizer = new Word();

        // dd($tokenizer);

        dd($pdfttxtPregSplit);
        // echo $pdfttxtPregSplit;
        // die;

        // dd($pdfttxtTrim);
        // echo $pdfttxtTrim;
        // die;

        $tokenizer = new NGram(1, 3);


        // dd($tokenizer);
        echo $tokenizer;
        die;


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


        // $namaDokumen = "PreprocessingTextuntukMeminimalisirKatayangTidakBerartidalamProsesTextMining.pdf";
        // //prosed dokumen pdf menggunakan library


        // $pdfToText = Pdf::getText('./public/doc/' . $namaDokumen);
        // dd($pdfToText);
        // die();

        session()->setFlashdata('pesan', 'Data Telah Berhasil Ditambahkan!');

        return redirect()->to('/');
    }
}
