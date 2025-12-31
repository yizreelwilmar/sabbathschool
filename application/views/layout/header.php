<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'Aplikasi Absensi' ?></title>
    <link rel="icon" href="https://img.icons8.com/ios-filled/50/2563eb/church.png" type="image/png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* 1. SMOOTH SCROLLING GLOBAL */
        html {
            scroll-behavior: smooth;
        }

        /* 2. CUSTOM SCROLLBAR (Biar ganteng, gak kaku) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #4e73df;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #224abe;
        }

        /* 3. PAGE ENTRY ANIMATION (Fade In Up yang smooth) */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        /* Terapkan animasi ke konten utama */
        .container-fluid {
            animation-duration: 0.6s;
            animation-fill-mode: both;
            animation-name: fadeInUp;
        }

        /* 4. GLASSMORPHISM TOPBAR (Efek Kaca Modern) */
        .topbar {
            background-color: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 1000;
            /* Pastikan di atas konten saat discroll */
        }

        /* 5. SIDEBAR HOVER EFFECT */
        .sidebar .nav-item .nav-link {
            transition: all 0.3s ease;
        }

        .sidebar .nav-item .nav-link:hover {
            transform: translateX(5px);
            /* Geser dikit pas di hover */
        }

        /* Sidebar Gradient lebih halus */
        .bg-gradient-primary {
            background-image: linear-gradient(180deg, #4e73df 10%, #2e59d9 100%);
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">