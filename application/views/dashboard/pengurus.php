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

        <!-- SUMMARY -->
        <div class="grid">
            <div class="card">
                <h3>Total Anggota</h3>
                <p>—</p>
            </div>
            <div class="card">
                <h3>Bulan Aktif</h3>
                <p><?= date('F Y') ?></p>
            </div>
        </div>

        <!-- SECTION -->
        <div class="section">
            <h2>Ringkasan Absensi Bulan Ini</h2>
            <div class="placeholder">
                Checklist aktivitas mingguan kelompok akan muncul di sini.
            </div>
        </div>

    </div>

</body>

</html>