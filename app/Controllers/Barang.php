<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\PenyesuaianModel;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $currentpage = $this->request->getVar('page_barang') ? $this->request->getVar('page_barang') : 1;
        $keyword = $this->request->getVar('keyword');
        $barang = $this->barangModel;
        $data = [
            'title' => 'Data Barang',
            'barang'  => $barang->paginate(25, 'barang'),
            'pager' => $this->barangModel->pager,
            'act'   => 'barang',
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/barang/index', $data);
    }

    public function pencarian()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword)
            return redirect()->to(base_url('/item/search/' . $keyword))->withInput();
        else
            return redirect()->to(base_url('/item'));
    }

    public function cari($keyword)
    {
        $currentpage = $this->request->getVar('page_barang') ? $this->request->getVar('page_barang') : 1;
        $barang = $this->barangModel->cari($keyword);
        $data = [
            'title' => 'Data Barang',
            'barang'  => $barang->paginate(25, 'barang'),
            'pager' => $this->barangModel->pager,
            'act'   => 'barang',
            'currentPage' => $currentpage,
            'keyword' => $keyword,
        ];
        return view('admin/barang/index', $data);
    }

    public function detail($idBarang)
    {
        $barang = $this->barangModel->find($idBarang);

        if (empty($barang)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/barang'))->withInput();
        }

        $data = [
            'title' => 'Detail Barang',
            'barang' => $barang,
            'act'   => 'barang',
        ];
        return view('admin/barang/detail', $data);
    }

    public function detail_qrcode($idBarang)
    {
        $barang = $this->barangModel->find($idBarang);

        if (empty($barang)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/barang'))->withInput();
        }

        $data = [
            'title' => 'Detail Barang',
            'barang' => $barang,
            'act'   => 'barang',
        ];
        return view('admin/barang/qr_detail', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Barang',
            'act'   => 'barang',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/barang/add', $data);
    }

    public function simpan()
    {
    // 1. Validasi Input
    if (!$this->validate([
        'nm_barang' => [
            'rules' => 'required',
            'errors' => ['required' => 'Nama barang wajib diisi!']
        ],
        'satuan' => [
            'rules' => 'required|max_length[10]',
            'errors' => ['required' => 'Satuan wajib diisi!']
        ],
        'hrg_barang' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Harga barang wajib diisi!',
                'numeric'  => 'Harga harus berupa angka!'
            ]
        ]
    ])) {
        return redirect()->to(base_url('/item/add'))->withInput();
    }

    try {
        $idBarang = $this->barangModel->kodegen();
        
        $data = [
            'id_barang'    => $idBarang,
            'nm_barang'    => $this->request->getVar('nm_barang'),
            'display_name' => $this->request->getVar('display_name'),
            'spek'         => $this->request->getVar('spek'),
            'satuan'       => ucwords($this->request->getVar('satuan')),
            'stok'         => 0,
            'hrg_barang'   => $this->request->getVar('hrg_barang'),
        ];

        $this->db->transStart();
        $this->barangModel->insert($data);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setflashdata('failed', 'Gagal menyimpan ke database.');
            return redirect()->to(base_url('item/add'))->withInput();
        }

        session()->setflashdata('success', 'Data barang berhasil ditambah.');
        return redirect()->to(base_url('item'));

    } catch (\Exception $e) {
        // Jika stuck, pesan ini akan memberitahu apa yang salah (misal: kolom tidak ditemukan)
        session()->setflashdata('failed', 'Error: ' . $e->getMessage());
        return redirect()->to(base_url('item/add'))->withInput();
    }
    }

    public function ubah($idBarang)
    {
        $barang = $this->barangModel->find($idBarang);
        if (empty($barang)) {
            session()->setflashdata('failed', 'Oops... Data tidak ditemukan. Silahkan pilih data.');
            return redirect()->to(base_url('/item'))->withInput();
        }

        $data = [
            'title' => 'Edit Data Barang',
            'barang'  => $barang,
            'act'   => 'barang',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/barang/edit', $data);
    }

    public function ubah_data($idBarang)
    {
        if (!$this->validate([
            'nm_barang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama barang wajib diisi!',
                ]
            ],
            'display_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Display Name wajib diisi!',
                ]
            ],
            'satuan' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'Satuan wajib diisi!',
                    'max_length' => 'Panjang maksimal untuk kolom ini sebesar 10 huruf!'
                ]
            ]
        ])) {
            return redirect()->to(base_url('/item/edit/' . $idBarang))->withInput();
        }

        $barang = $this->barangModel->find($idBarang);

        $data = [
            'id_barang'    => $barang['id_barang'],
            'nm_barang'    => $this->request->getVar('nm_barang'),
            'display_name' => $this->request->getVar('display_name'),
            'spek'         => $this->request->getVar('spek'),
            'satuan'       => ucwords($this->request->getVar('satuan')),
            'hrg_barang'   => $this->request->getVar('hrg_barang'),
        ];

        $this->db->transStart();
        $this->barangModel->update($barang['id_barang'], $data);
        $this->db->transComplete();

        if ($this->db->transStatus() == false) {
            session()->setflashdata('failed', 'Data barang gagal diubah.');
            return redirect()->to(base_url('item'));
        } elseif ($this->db->transStatus() == true) {
            session()->setflashdata('success', 'Data barang berhasil diubah.');
            return redirect()->to(base_url('item'));
        }
    }

    public function data_barang()
    {
        $request = \Config\Services::request();
        $keyword = $request->getPostGet('term');
        $barang = $this->barangModel->cari_barang($keyword);
        $w = array();
        foreach ($barang as $a) :
            $w[] = [
                "label" => $a['id_barang'] . ' - ' . $a['nm_barang'],
                "id_barang" => $a['id_barang'],
            ];
        endforeach;
        echo json_encode($w);
    }

    public function cetak_qr($idBarang)
    {
    $barang = $this->barangModel->find($idBarang);

    if (!$barang) {
        session()->setFlashdata('failed', 'Data barang tidak ditemukan');
        return redirect()->to(base_url('item'));
    }

    // Load TCPDF
    require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';

    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Setting dokumen
    $pdf->SetCreator('DRT Inventory');
    $pdf->SetAuthor('DRT Inventory');
    $pdf->SetTitle('QR Barang');
    $pdf->SetMargins(20, 20, 20);
    $pdf->AddPage();

    // Style QR
    $style = [
        'border' => 0,
        'padding' => 2,
        'fgcolor' => [0, 0, 0],
        'bgcolor' => false,
    ];

    // Isi QR (URL detail barang)
    $qrText = base_url('item/detail_qrcode/' . $barang['id_barang']);

    // Cetak QR
    $pdf->write2DBarcode(
        $qrText,
        'QRCODE,H',
        60,
        40,
        80,
        80,
        $style,
        'N'
    );

    // Teks di bawah QR
    $pdf->SetY(130);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 8, $barang['nm_barang'], 0, 1, 'C');

    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 6, 'ID: ' . $barang['id_barang'], 0, 1, 'C');

    // Output PDF
    $pdf->Output('QR_' . $barang['id_barang'] . '.pdf', 'I');
    exit;
    }



    public function hapus($idBarang)
    {
    $barangModel = new \App\Models\BarangModel();
    
    // 1. Cek apakah barang ada
    $barang = $barangModel->find($idBarang);
    if (!$barang) {
        session()->setFlashdata('failed', 'Data barang tidak ditemukan.');
        return redirect()->to(base_url('item'));
    }

    try {
        $this->db->transStart();

        // 2. Hapus referensi di SEMUA tabel detail (Child Tables)
        // Hapus dari detail suplai (sesuai error terbaru Anda)
        $this->db->table('suplai_detail')->where('id_barang', $idBarang)->delete();
        
        // Hapus dari detail keluar
        $this->db->table('keluar_detail')->where('id_barang', $idBarang)->delete();
        
        // Jika ada tabel lain (misal: penyesuaian_detail), tambahkan di sini:
        // $this->db->table('penyesuaian_detail')->where('id_barang', $idBarang)->delete();

        // 3. Hapus data utama di tabel barang
        $barangModel->delete($idBarang);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('failed', 'Gagal menghapus data karena masalah database.');
        } else {
            session()->setFlashdata('success', 'Data barang dan semua riwayat transaksi terkait berhasil dihapus.');
        }

    } catch (\Exception $e) {
        // Menangkap error jika ada constraint lain yang belum teratasi
        session()->setFlashdata('failed', 'Gagal menghapus: ' . $e->getMessage());
    }

    return redirect()->to(base_url('item'));
    }
}