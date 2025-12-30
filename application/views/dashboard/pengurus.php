<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Kelompok</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
        }

        .navbar {
            background: #2563eb;
            color: #fff;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 18px;
            margin: 0;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .container {
            padding: 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        .card h3 {
            margin: 0;
            font-size: 15px;
            color: #64748b;
        }

        .card p {
            font-size: 28px;
            margin: 10px 0 0;
            font-weight: bold;
            color: #0f172a;
        }

        .section {
            margin-top: 30px;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .placeholder {
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
            color: #64748b;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h1>Dashboard Kelompok</h1>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </div>

    <div class="container">

        <div class="cards">
            <div class="card green">
                <h3>Total Anggota</h3>
                <p><?= $total_anggota ?></p>
            </div>
            <div class="card indigo">
                <h3>Bulan Aktif</h3>
                <p style="font-size:22px"><?= date('F Y') ?></p>
            </div>
        </div>

        <div class="section">
            <h2>Rekap Aktivitas Kelompok</h2>

            <table style="width:100%;border-collapse:collapse;margin-top:15px">
                <tr style="background:#f1f5f9">
                    <th style="padding:12px;text-align:left">Kode</th>
                    <th style="padding:12px;text-align:left">Aktivitas</th>
                    <th style="padding:12px;text-align:right">Checklist</th>
                </tr>
                <?php foreach ($summary as $s): ?>
                    <tr>
                        <td style="padding:12px"><?= $s->kode ?></td>
                        <td style="padding:12px"><?= $s->nama ?></td>
                        <td style="padding:12px;text-align:right;font-weight:600">
                            <?= $s->total ?: 0 ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>


    </div>

</body>

</html>