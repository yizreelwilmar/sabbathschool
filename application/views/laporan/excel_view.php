<?php
// Header agar browser membacanya sebagai file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap_Absen_" . $nama_bulan . "_" . $tahun . ".xls");
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #4e73df;
            color: white;
        }

        .sub-header {
            background-color: #eaecf4;
            color: black;
        }

        .text-left {
            text-align: left;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="title">
        LAPORAN REKAPITULASI ABSENSI - <?= strtoupper($detail_kelompok->nama_kelompok) ?><br>
        PERIODE: <?= strtoupper($nama_bulan) ?> <?= $tahun ?>
    </div>

    <table>
        <thead>
            <tr>
                <th class="header" rowspan="2" width="5%">No</th>
                <th class="header text-left" rowspan="2" width="25%">Nama Anggota</th>
                <?php foreach ($list_aktivitas as $akt): ?>
                    <th class="header" colspan="<?= $total_minggu ?>"><?= $akt->kode ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($list_aktivitas as $akt): ?>
                    <?php for ($m = 1; $m <= $total_minggu; $m++): ?>
                        <th class="sub-header"><?= $m ?></th>
                    <?php endfor; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($anggota as $a): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-left"><b><?= $a['nama_anggota'] ?></b></td>
                    <?php foreach ($list_aktivitas as $akt): ?>
                        <?php for ($m = 1; $m <= $total_minggu; $m++):
                            $is_checked = isset($rekap[$a['id']][$akt->id][$m]);
                        ?>
                            <td style="<?= $is_checked ? 'background-color:#1cc88a; color:white;' : '' ?>">
                                <?= $is_checked ? 'v' : '' ?>
                            </td>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>