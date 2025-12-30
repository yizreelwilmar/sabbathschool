<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Sekolah Sabat</title>

    <link rel="icon" href="https://img.icons8.com/ios-filled/50/2563eb/church.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            min-height: 550px;
        }

        .bg-login-image {
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.9), rgba(34, 74, 190, 0.8)), url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');
            background-position: center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 40px;
        }

        .login-content {
            padding: 50px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #d1d3e2;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-login {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        .input-group-text {
            border-radius: 10px;
            border: 1px solid #d1d3e2;
            background-color: #f8f9fc;
            cursor: pointer;
        }

        .brand-logo {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 10px;
            display: inline-block;
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .bg-login-image {
                display: none;
            }

            .login-content {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card login-card">
                    <div class="row g-0 h-100">

                        <div class="col-lg-6 bg-login-image">
                            <div class="mb-4">
                                <i class="fas fa-church fa-3x mb-3"></i>
                                <h3>UKSS App</h3>
                            </div>
                            <h4 class="fw-light">"Melayani Tuhan dengan ketertiban dan kedisiplinan."</h4>
                            <p class="mt-3 opacity-75 small">Sistem Absensi Sekolah Sabat Digital</p>
                        </div>

                        <div class="col-lg-6">
                            <div class="login-content h-100 d-flex flex-column justify-content-center">
                                <div class="text-center mb-4">
                                    <h1 class="h4 text-gray-900 mb-2 fw-bold">Selamat Datang!</h1>
                                    <p class="text-muted small">Silakan masuk untuk mengelola data.</p>
                                </div>

                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <?= $this->session->flashdata('error') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <form class="user" method="post" action="<?= site_url('auth/process') ?>">

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                            <input type="text" class="form-control" name="username" placeholder="Masukkan username" required autofocus>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                            <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Masukkan password" required>
                                            <span class="input-group-text" onclick="togglePassword()">
                                                <i class="fas fa-eye text-muted" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3 shadow">
                                        Masuk <i class="fas fa-sign-in-alt ms-1"></i>
                                    </button>

                                </form>

                                <div class="text-center mt-3">
                                    <a class="small text-decoration-none text-muted" href="<?= site_url('/') ?>">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Utama
                                    </a>
                                </div>

                                <div class="text-center mt-5">
                                    <small class="text-muted text-xs">&copy; <?= date('Y') ?> UKSS App. All Rights Reserved.</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("passwordInput");
            var toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>