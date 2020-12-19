<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];

        return view('komik/index', $data);
    }

    public function detail($slugh)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slugh)
        ];

        //jika komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slugh . ' tidak ditemukan.');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        // session(); di pindah ke Basecontroller
        $data = [
            'title' => 'Tambah Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        //validation
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]|alpha_numeric_punct',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.',
                    'alpha_numeric_punct' => '{field} harap diisi tanpa karakter khusus.'
                ]
            ],
            'penulis' => [
                'rules' => 'required|alpha_numeric_punct',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_numeric_punct' => '{field} harap diisi tanpa karakter khusus.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required|alpha_numeric_punct',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_numeric_punct' => '{field} harap diisi tanpa karakter khusus.'
                ]
            ],
            'sampul' => [
                //Yang ini juga rulesnya bener + ada uploaded untuk cek file
                // 'rules' => 'is_image[sampul]|max_size[sampul,1048]|uploaded[sampul]|mime_in[sampul,image/png,image/jpg,image/jpeg]',
                // 'errors' => [
                //     'max-size' => 'File terlalu besar',
                //     'uploaded' => '{field} harus diisi',
                //     'is_image' => 'Ini bukan gambar',
                //     'mime_in' => 'Ini bukan gambar'
                // ] // yg dibawah gak ada uploaded
                'rules' => 'is_image[sampul]|max_size[sampul,1048]|mime_in[sampul,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max-size' => 'File terlalu besar',
                    'is_image' => 'Ini bukan gambar',
                    'mime_in' => 'Ini bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to(base_url('komik/create'))->withInput()->with('validation', $validation);
            return redirect()->to(base_url('komik/create'))->withInput();
        }
        //Cara upload gambar biasa tanpa nama random
        // $fileSampul = $this->request->getFile('sampul'); //ambil gambar
        //apakah ada gambar yang di upload ?
        // if ($fileSampul->getError() == 4) {
        //     $namaSampul = 'no image.jpg';
        // } else {
        //     $fileSampul->move('img'); //pindahkan file ke folder img
        //     $namaSampul = $fileSampul->getName(); //ambill nama file
        // }

        //Cara upload gambar dengan nama random
        $fileSampul = $this->request->getFile('sampul'); //ambil gambar
        //cek gambar di upload atau gak
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'no image.jpg';
        } else {
            $namaSampul = $fileSampul->getRandomName(); //generate nama gambar random
            $fileSampul->move('img', $namaSampul); //pindahkan file ke folder img disertai nama randomnya
        }

        $slugh = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slugh' => $slugh,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashData('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to(base_url('komik'));
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);

        //cek jika file gambar nya default
        if ($komik['sampul'] != 'no image.jpg') {
            //hapus gambar
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashData('pesan', 'Data berhasil dihapus.');
        return redirect()->to(base_url('komik'));
    }

    public function edit($slugh)
    {
        $data = [
            'title' => 'Rubah Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slugh)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        //cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slugh'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required|alpha_numeric_punct';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]|alpha_numeric_punct';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.',
                    'alpha_numeric_punct' => '{field} harap diisi tanpa karakter khusus.'
                ]
            ],
            'penulis' => [
                'rules' => 'required|alpha_numeric_punct',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_numeric_punct' => '{field} harap diisi tanpa karakter khusus.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required|alpha_numeric_punct',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'alpha_numeric_punct' => '{field} harap diisi tanpa karakter khusus.'
                ]
            ],
            'sampul' => [
                'rules' => 'is_image[sampul]|max_size[sampul,1048]|mime_in[sampul,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max-size' => 'File terlalu besar',
                    'is_image' => 'Ini bukan gambar',
                    'mime_in' => 'Ini bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to(base_url('komik/edit/' . $this->request->getVar('slugh')))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        $fileSampulLama = $this->request->getVar('sampulLama');

        //cek gambar, apakah tetap gambar lama?
        if ($fileSampul->getError() == 4) {
            $namaSampul = $fileSampulLama;
        } else {
            //generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            //hapus file yang lama
            if ($fileSampulLama != 'no image.jpg') {
                unlink('img/' . $fileSampulLama);
            }
        }

        $slugh = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slugh' => $slugh,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashData('pesan', 'Data berhasil dirubah.');

        return redirect()->to(base_url('komik'));
    }
}
