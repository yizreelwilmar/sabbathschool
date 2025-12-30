<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            background: #fff;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .2);
        }

        .login-info {
            background:
                linear-gradient(rgba(37, 99, 235, .8), rgba(37, 99, 235, .8)),
                url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-info h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .login-info p {
            line-height: 1.6;
            opacity: .95;
        }

        .login-form {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            margin-bottom: 25px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            margin-bottom: 15px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            padding: 14px;
            border-radius: 10px;
            border: none;
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            background: #1e40af;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        .back {
            text-align: center;
            margin-top: 15px;
        }

        .back a {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
        }

        @media(max-width:768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .login-info {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- INFO -->
        <div class="login-info">
            <h2>Selamat Datang Kembali!</h2>
            <p>Masuk untuk mengelola aplikasi Sabbath School Anda. Masukkan
                username dan password Anda untuk melanjutkan.</p>
        </div>

        <!-- FORM -->
        <div class="login-form">
            <h2>Login</h2>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="error">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('auth/process') ?>">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Masuk</button>
            </form>

            <div class="back">
                <a href="<?= site_url('/') ?>">← Kembali ke Landing</a>
            </div>
        </div>

    </div>

</body>

</html>