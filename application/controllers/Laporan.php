<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

// Panggil Library PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

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

        // --- HITUNG JUMLAH SABTU DI BULAN INI ---
        $jumlah_minggu = 0;
        $total_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        for ($d = 1; $d <= $total_hari; $d++) {
            $tgl_cek = "$tahun-$bulan-$d";
            if (date('N', strtotime($tgl_cek)) == 6) { // 6 = Sabtu
                $jumlah_minggu++;
            }
        }
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

    // --- FUNGSI EXPORT EXCEL BARU (MENGGUNAKAN PHPSPREADSHEET) ---
    public function export_excel()
    {
        // 1. Ambil Filter & Validasi
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $id_kelompok = $this->input->get('id_kelompok');

        if (!$bulan || !$tahun || !$id_kelompok) {
            redirect('laporan');
        }

        // 2. Hitung Minggu
        $jumlah_minggu = 0;
        $total_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        for ($d = 1; $d <= $total_hari; $d++) {
            if (date('N', strtotime("$tahun-$bulan-$d")) == 6) $jumlah_minggu++;
        }
        $total_minggu = ($jumlah_minggu > 0) ? $jumlah_minggu : 4;

        // 3. Ambil Data
        $list_aktivitas = $this->Absensi_model->get_aktivitas();
        $hasil = $this->Laporan_model->get_rekap_bulanan_mingguan($bulan, $tahun, $id_kelompok);
        $anggota = $hasil['anggota'];
        $rekap = $hasil['rekap'];
        $detail_kelompok = $this->Kelompok_model->get_by_id($id_kelompok);

        // Helper Nama Bulan
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
        $nama_bulan = isset($list_bulan[$bulan]) ? $list_bulan[$bulan] : '-';

        // ==========================================
        // MULAI GENERATE EXCEL PHPSPREADSHEET
        // ==========================================

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- A. DEFINISI STYLE ---
        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']], // Biru Bootstrap
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $styleSubHeader = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EAECF4']], // Abu-abu Terang
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $styleBorder = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $styleCheck = [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1CC88A']], // Hijau
            'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ];

        // --- B. JUDUL LAPORAN ---
        $sheet->setCellValue('A1', 'LAPORAN REKAPITULASI ABSENSI - ' . strtoupper($detail_kelompok->nama_kelompok));
        $sheet->setCellValue('A2', 'PERIODE: ' . strtoupper($nama_bulan) . ' ' . $tahun);
        $sheet->mergeCells('A1:J1'); // Merge judul (sesuaikan J jika kolom banyak)
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // --- C. HEADER TABEL (Baris 4 & 5) ---

        // 1. Kolom Statis (No & Nama)
        $sheet->setCellValue('A4', 'No')->mergeCells('A4:A5');
        $sheet->setCellValue('B4', 'Nama Anggota')->mergeCells('B4:B5');

        // 2. Kolom Dinamis (Aktivitas & Minggu)
        $colIndex = 3; // Mulai dari Kolom C (Index 3)

        foreach ($list_aktivitas as $akt) {
            // Konversi index angka ke huruf Excel (misal: 3 -> C)
            $startCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $endCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + $total_minggu - 1);

            // Set Header Aktivitas (Merge Cell selebar jumlah minggu)
            $sheet->setCellValue($startCol . '4', $akt->kode);
            $sheet->mergeCells($startCol . '4:' . $endCol . '4');

            // Set Sub-Header Minggu (1, 2, 3...)
            for ($m = 1; $m <= $total_minggu; $m++) {
                $currentCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue($currentCol . '5', $m);
                $sheet->getColumnDimension($currentCol)->setWidth(4); // Kecilkan lebar kolom minggu
                $colIndex++;
            }
        }

        // Terapkan Style Header
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex - 1);
        $sheet->getStyle('A4:' . $lastCol . '4')->applyFromArray($styleHeader);
        $sheet->getStyle('A5:' . $lastCol . '5')->applyFromArray($styleSubHeader);

        // --- D. ISI DATA (LOOPING BARIS) ---
        $row = 6;
        $no = 1;

        if (!empty($anggota)) {
            foreach ($anggota as $a) {
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $a['nama_anggota']);
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Reset kolom ke C untuk isi centang
                $colIndex = 3;
                foreach ($list_aktivitas as $akt) {
                    for ($m = 1; $m <= $total_minggu; $m++) {
                        $cellAddr = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex) . $row;

                        // Cek apakah ada data rekap
                        if (isset($rekap[$a['id']][$akt->id][$m])) {
                            $sheet->setCellValue($cellAddr, 'v');
                            $sheet->getStyle($cellAddr)->applyFromArray($styleCheck);
                        } else {
                            // Kosong atau tanda strip
                            $sheet->setCellValue($cellAddr, '');
                        }
                        $colIndex++;
                    }
                }
                $row++;
            }
        } else {
            $sheet->setCellValue('A6', 'Tidak ada data anggota.');
            $sheet->mergeCells('A6:' . $lastCol . '6');
            $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row++;
        }

        // --- E. FINALISASI (BORDER & WIDTH) ---
        // Border seluruh tabel
        $sheet->getStyle('A4:' . $lastCol . ($row - 1))->applyFromArray($styleBorder);

        // Auto Width untuk Kolom No & Nama
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // --- F. DOWNLOAD FILE ---
        $filename = "Rekap_Absen_" . $detail_kelompok->nama_kelompok . "_" . $nama_bulan . "_" . $tahun . ".xlsx";

        // Bersihkan spasi di filename agar aman
        $filename = str_replace(' ', '_', $filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
