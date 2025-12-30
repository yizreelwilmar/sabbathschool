<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        auth_check();
        $this->load->model(['Laporan_model', 'Kelompok_model', 'Absensi_model']);
    }

    public function index()
    {
        $data['title'] = 'Laporan Bulanan';

        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('n');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');

        if ($this->session->userdata('role') == 'pengurus') {
            $id_kelompok = $this->session->userdata('id_kelompok');
        } else {
            $id_kelompok = $this->input->get('id_kelompok');
        }

        $data['bulan_pilih'] = $bulan;
        $data['tahun_pilih'] = $tahun;
        $data['id_kelompok_pilih'] = $id_kelompok;

        // --- [BARU] HITUNG JUMLAH SABTU DI BULAN INI ---
        // Logika: Loop dari tgl 1 sampai akhir bulan, hitung berapa kali ketemu hari Sabtu (6)
        $jumlah_minggu = 0;
        $total_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        for ($d = 1; $d <= $total_hari; $d++) {
            $tgl_cek = "$tahun-$bulan-$d";
            if (date('N', strtotime($tgl_cek)) == 6) { // 6 = Sabtu
                $jumlah_minggu++;
            }
        }
        // Jika entah kenapa 0 (error date), default ke 4 biar aman
        $data['total_minggu'] = ($jumlah_minggu > 0) ? $jumlah_minggu : 4;
        // -----------------------------------------------

        $data['list_aktivitas'] = $this->Absensi_model->get_aktivitas();

        if ($id_kelompok) {
            $hasil = $this->Laporan_model->get_rekap_bulanan_mingguan($bulan, $tahun, $id_kelompok);
            $data['anggota'] = $hasil['anggota'];
            $data['rekap']   = $hasil['rekap'];
            $data['detail_kelompok'] = $this->Kelompok_model->get_by_id($id_kelompok);
        }

        if ($this->session->userdata('role') == 'admin') {
            $data['list_kelompok'] = $this->Kelompok_model->get_all();
        }

        $data['list_bulan'] = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $data['isi'] = 'laporan/index';
        $this->load->view('layout/wrapper', $data);
    }

    public function export_excel()
    {
        // 1. Ambil Filter (Sama persis dengan index)
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $id_kelompok = $this->input->get('id_kelompok');

        // Validasi sederhana
        if (!$bulan || !$tahun || !$id_kelompok) {
            redirect('laporan');
        }

        // 2. Hitung Minggu (Logika Sama)
        $jumlah_minggu = 0;
        $total_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        for ($d = 1; $d <= $total_hari; $d++) {
            if (date('N', strtotime("$tahun-$bulan-$d")) == 6) $jumlah_minggu++;
        }
        $data['total_minggu'] = ($jumlah_minggu > 0) ? $jumlah_minggu : 4;

        // 3. Ambil Data
        $data['list_aktivitas'] = $this->Absensi_model->get_aktivitas();
        $hasil = $this->Laporan_model->get_rekap_bulanan_mingguan($bulan, $tahun, $id_kelompok);

        $data['anggota'] = $hasil['anggota'];
        $data['rekap']   = $hasil['rekap'];
        $data['detail_kelompok'] = $this->Kelompok_model->get_by_id($id_kelompok);

        // Data Tambahan untuk Judul
        $list_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $data['nama_bulan'] = $list_bulan[$bulan];
        $data['tahun'] = $tahun;

        // 4. Load View Khusus Excel (Tanpa Header/Footer Website)
        $this->load->view('laporan/excel_view', $data);
    }
}
