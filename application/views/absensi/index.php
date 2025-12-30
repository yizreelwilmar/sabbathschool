<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi Mingguan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f0f9ff, #f8fafc);
        }

        .wrapper {
            padding: 30px
        }

        h2 {
            margin-bottom: 10px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            font-size: 14px;
        }

        th {
            background: #2563eb;
            color: #fff;
            position: sticky;
            top: 0;
        }

        td:first-child,
        th:first-child {
            text-align: left;
            padding-left: 18px;
        }

        input[type=checkbox] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .filter {
            margin-bottom: 20px;
        }

        .filter a {
            margin-right: 10px;
            text-decoration: none;
            padding: 8px 14px;
            background: #e0f2fe;
            border-radius: 999px;
            color: #0369a1;
        }

        .filter a.active {
            background: #2563eb;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <h2>Absensi Minggu ke-<?= $minggu ?></h2>

        <div class="filter">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <a href="?minggu=<?= $i ?>" class="<?= $minggu == $i ? 'active' : '' ?>">
                    Minggu <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>

        <table>
            <tr>
                <th>Nama</th>
                <?php foreach ($aktivitas as $a): ?>
                    <th><?= $a->kode ?></th>
                <?php endforeach; ?>
            </tr>

            <?php foreach ($anggota as $ag): ?>
                <tr>
                    <td><?= $ag->nama ?></td>
                    <?php foreach ($aktivitas as $ak): ?>
                        <td>
                            <input type="checkbox"
                                onchange="toggle(this,<?= $ag->id ?>,<?= $ak->id ?>)">
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function toggle(el, anggota, aktivitas) {
            fetch("<?= site_url('absensi/toggle') ?>", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: "id_anggota=" + anggota +
                    "&id_aktivitas=" + aktivitas +
                    "&id_kelompok=<?= $id_kelompok ?>" +
                    "&bulan=<?= $bulan ?>" +
                    "&tahun=<?= $tahun ?>" +
                    "&minggu_ke=<?= $minggu ?>"
            });
        }
    </script>

</body>

</html>