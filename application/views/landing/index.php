<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Sekolah Sabat | GMAHK Cililitan</title>

    <meta name="robots" content="noindex, nofollow">

    <link rel="icon" href="<?= base_url('assets/img/favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Background Shape (Hiasan Pengganti Foto) */
        .bg-shape {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50vh;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-bottom-left-radius: 50% 20%;
            border-bottom-right-radius: 50% 20%;
            z-index: -1;
        }

        /* HEADER */
        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: white !important;
        }

        .version-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            backdrop-filter: blur(5px);
        }

        /* HERO CARD */
        .hero-container {
            min-height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding-top: 60px;
        }

        .welcome-card {
            background: white;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .welcome-card:hover {
            transform: translateY(-5px);
            /* Efek Hover Naik */
        }

        .welcome-card::top {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(to right, #2563eb, #60a5fa);
        }

        .verse-box {
            background: #eff6ff;
            color: #1e40af;
            padding: 20px;
            border-radius: 12px;
            margin: 30px 0;
            font-size: 0.95rem;
            font-style: italic;
            border-left: 4px solid var(--primary);
        }

        .btn-login-main {
            background: var(--primary);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            transition: all 0.3s;
        }

        .btn-login-main:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
            /* Efek Tombol Membesar */
            color: white;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.4);
        }

        /* FEATURES ICONS */
        .features-row {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .feature-item {
            text-align: center;
            color: white;
            transition: transform 0.3s;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            background: rgba(255, 255, 255, 0.15);
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 10px;
            font-size: 1.5rem;
            backdrop-filter: blur(5px);
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: auto;
        }

        /* Responsive Text */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 30px;
                margin: 20px;
            }

            .bg-shape {
                height: 40vh;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }

            .features-row {
                color: #333;
                gap: 20px;
            }

            .feature-icon {
                background: #e2e8f0;
                color: var(--primary);
            }
        }
    </style>
</head>

<body>

    <div class="bg-shape"></div>

    <nav class="navbar navbar-dark pt-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-church me-2"></i> GMAHK Cililitan
            </a>
            <span class="version-badge">Sistem Absensi v1.0</span>
        </div>
    </nav>

    <div class="hero-container">

        <div class="welcome-card" data-aos="fade-up" data-aos-duration="1000">
            <div class="mb-3">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                    Portal Pengurus
                </span>
            </div>

            <h1 class="fw-bold mb-2">Selamat Sabat!</h1>
            <p class="text-muted">Silakan masuk untuk mengisi data absensi dan laporan kelas.</p>

            <div class="verse-box" data-aos="zoom-in" data-aos-delay="200">
                <i class="fas fa-quote-left me-2 opacity-50"></i>
                "Ingatlah dan kuduskanlah hari Sabat."
                <div class="mt-2 fw-bold text-end small">- Keluaran 20:8</div>
            </div>

            <a href="<?= site_url('login') ?>" class="btn-login-main">
                <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
            </a>
        </div>

        <div class="features-row">
            <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <div class="small fw-bold">Akses Mudah</div>
            </div>
            <div class="feature-item" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="small fw-bold">Data Aman</div>
            </div>
            <div class="feature-item" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <div class="small fw-bold">Laporan Rapi</div>
            </div>
        </div>

    </div>

    <footer>
        &copy; <?= date('Y') ?> <strong>GMAHK Cililitan</strong>. All Rights Reserved.<br>
        <span class="small opacity-75">Melayani dengan Sepenuh Hati.</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi Animasi
        AOS.init({
            once: true, // Animasi hanya sekali saat load
            offset: 50
        });
    </script>

</body>

</html>