<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sistem Absensi Sabbath School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        /* ===== NAVBAR ===== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .05);
            z-index: 50;
        }

        .nav-inner {
            max-width: 1200px;
            margin: auto;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-weight: 700;
            font-size: 18px;
            color: #1e293b;
        }

        .btn-login {
            padding: 10px 22px;
            background: #2563eb;
            color: #fff;
            border-radius: 999px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-login:hover {
            background: #1e40af;
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background:
                linear-gradient(rgba(15, 23, 42, .65), rgba(15, 23, 42, .65)),
                url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 110px 20px 40px;
        }

        .hero-content {
            max-width: 640px;
            color: #fff;
            animation: fadeUp .8s ease;
        }

        .hero-content h1 {
            font-size: 40px;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 18px;
            opacity: .9;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .btn-primary {
            display: inline-block;
            padding: 14px 34px;
            background: #22c55e;
            color: #064e3b;
            font-weight: 700;
            border-radius: 12px;
            transition: .3s;
        }

        .btn-primary:hover {
            background: #16a34a;
            transform: translateY(-2px);
        }

        /* ===== SECTION ===== */
        .section {
            padding: 90px 20px;
        }

        .section-inner {
            max-width: 1200px;
            margin: auto;
        }

        .section-title {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 50px;
        }

        .section-title h2 {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .section-title p {
            color: #475569;
            line-height: 1.7;
        }

        /* ===== FEATURES BACKGROUND (KELOMPOK) ===== */
        .section-features {
            background:
                linear-gradient(rgba(248, 250, 252, .94), rgba(248, 250, 252, .94)),
                url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d');
            background-size: cover;
            background-position: center;
        }

        /* ===== FEATURES ===== */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
            transition: .3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, .12);
        }

        .feature-card h3 {
            margin: 0 0 12px;
            font-size: 20px;
        }

        .feature-card p {
            color: #475569;
            line-height: 1.6;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 30px;
            color: #64748b;
            font-size: 14px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media(max-width: 900px) {
            .features {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 32px;
            }
        }
    </style>
</head>

<body>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h1>Sistem Absensi Sabbath School</h1>
            <p>
                Solusi digital untuk mencatat dan memantau
                aktivitas kelompok Sabbath School secara
                mingguan, rapi, dan terstruktur.
            </p>
            <a href="<?= site_url('login') ?>" class="btn-primary">
                Masuk sebagai Pengurus / Admin
            </a>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="section section-features">
        <div class="section-inner">
            <div class="section-title">
                <h2>Mengelola Absensi dengan Mudah</h2>
                <p>
                    Dirancang untuk membantu pengurus kelompok
                    dalam mencatat aktivitas Sabbath School
                    secara konsisten dan terorganisir.
                </p>
            </div>

            <div class="features">
                <div class="feature-card">
                    <h3>📋 Pencatatan Terstruktur</h3>
                    <p>
                        Absensi mingguan dicatat berdasarkan
                        kelompok dengan format yang rapi.
                    </p>
                </div>

                <div class="feature-card">
                    <h3>📊 Rekap Otomatis</h3>
                    <p>
                        Data direkap per bulan dan dapat
                        diekspor ke Excel.
                    </p>
                </div>

                <div class="feature-card">
                    <h3>🔐 Akses Aman</h3>
                    <p>
                        Sistem hanya dapat diakses oleh
                        pengurus dan admin.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        © <?= date('Y') ?> Sistem Absensi Sabbath School
    </footer>

</body>

</html>