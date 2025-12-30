<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f0f9ff, #f8fafc);
            color: #0f172a;
        }

        /* ===== LAYOUT ===== */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2563eb, #1e40af);
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            box-shadow: 4px 0 30px rgba(0, 0, 0, .15);
        }

        .sidebar .logo {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            padding: 22px;
            letter-spacing: .5px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            flex: 1;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 14px 26px;
            color: #e0e7ff;
            text-decoration: none;
            font-size: 15px;
            transition: .25s;
            border-left: 4px solid transparent;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: rgba(255, 255, 255, .15);
            color: #fff;
            border-left: 4px solid #a5f3fc;
        }

        .sidebar .logout {
            border-top: 1px solid rgba(255, 255, 255, .2);
        }

        .sidebar .logout a {
            color: #fecaca;
            padding: 14px 26px;
            display: block;
            text-decoration: none;
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: #fff;
            padding: 18px 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
        }

        .topbar h1 {
            font-size: 20px;
            margin: 0;
        }

        .topbar span {
            background: #e0f2fe;
            color: #0369a1;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        /* ===== CONTENT ===== */
        .content {
            padding: 32px;
        }

        /* ===== CARDS ===== */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
            margin-bottom: 32px;
        }

        .card {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-6px);
        }

        .card h3 {
            margin: 0;
            font-size: 14px;
            color: #64748b;
        }

        .card p {
            margin-top: 12px;
            font-size: 34px;
            font-weight: 800;
        }

        .card.blue {
            border-top: 5px solid #2563eb;
        }

        .card.green {
            border-top: 5px solid #22c55e;
        }

        .card.indigo {
            border-top: 5px solid #6366f1;
        }

        /* ===== SECTION ===== */
        .section {
            background: #fff;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
        }

        .section h2 {
            margin-top: 0;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .section p {
            color: #475569;
            line-height: 1.6;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width:768px) {
            .sidebar {
                display: none;
            }

            .content {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo">
                Sabbath School
            </div>

            <ul>
                <li><a href="#" class="active">Dashboard</a></li>
                <li><a href="#">Master Kelompok</a></li>
                <li><a href="#">Master Anggota</a></li>
                <li><a href="#">Absensi Mingguan</a></li>
                <li><a href="#">Laporan</a></li>
            </ul>

            <div class="logout">
                <a href="<?= site_url('logout') ?>">Logout</a>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="main">

            <!-- TOPBAR -->
            <div class="topbar">
                <h1>Dashboard Admin</h1>
                <span><?= date('F Y') ?></span>
            </div>

            <!-- CONTENT -->
            <div class="content">

                <!-- SUMMARY -->
                <div class="cards">
                    <div class="card blue">
                        <h3>Total Kelompok</h3>
                        <p>—</p>
                    </div>
                    <div class="card green">
                        <h3>Total Anggota</h3>
                        <p>—</p>
                    </div>
                    <div class="card indigo">
                        <h3>Bulan Aktif</h3>
                        <p style="font-size:22px"><?= date('F Y') ?></p>
                    </div>
                </div>

                <!-- SECTION -->
                <div class="section">
                    <h2>Ringkasan Aktivitas</h2>
                    <p>
                        Data rekap seluruh kelompok akan ditampilkan di sini
                        setelah absensi mulai diinput oleh pengurus masing-masing.
                    </p>
                </div>

            </div>

        </div>

    </div>

</body>

</html>