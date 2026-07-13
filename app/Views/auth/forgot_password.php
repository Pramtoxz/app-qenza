<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Qenza</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/img/logoqenza.jpg">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
        }
        .auth-left {
            width: 42%;
            background: #0e0e37;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.06);
        }
        .auth-left::before {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.04);
        }
        .brand { position: relative; z-index: 2; }
        .brand img { height: 40px; border-radius: 6px; margin-bottom: 16px; }
        .brand-name { color: #fff; font-weight: 800; font-size: 1.3rem; letter-spacing: -.3px; }
        .brand-sub { color: rgba(255,255,255,.4); font-size: .85rem; margin-top: 4px; }
        .auth-left-quote {
            position: relative; z-index: 2;
            color: rgba(255,255,255,.55);
            font-size: .9rem;
            line-height: 1.6;
            max-width: 320px;
        }
        .auth-left-quote strong { color: #fff; font-weight: 600; }
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background: #fafafa;
        }
        .auth-form {
            width: 100%;
            max-width: 380px;
        }
        .auth-form h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0e0e37;
            letter-spacing: -.5px;
            margin-bottom: 6px;
        }
        .auth-form .subtitle {
            font-size: .9rem;
            color: #999;
            margin-bottom: 32px;
        }
        .field { margin-bottom: 20px; }
        .field label {
            display: block;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #999;
            margin-bottom: 8px;
        }
        .field input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e5e5e5;
            border-radius: 8px;
            font-size: .95rem;
            font-family: inherit;
            background: #fff;
            transition: border-color .2s;
        }
        .field input:focus { outline: none; border-color: #0e0e37; }
        .field input::placeholder { color: #ccc; }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #0e0e37;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: opacity .2s;
        }
        .btn-submit:hover { opacity: .85; }
        .btn-submit:disabled { opacity: .5; cursor: not-allowed; }
        .auth-links {
            margin-top: 24px;
            text-align: center;
        }
        .auth-links a {
            font-size: .85rem;
            color: #999;
            text-decoration: none;
            transition: color .2s;
        }
        .auth-links a:hover { color: #0e0e37; }
        .auth-links .link-bold { color: #0e0e37; font-weight: 600; }
        .auth-links .sep { margin: 0 8px; color: #ddd; }
        .alert-msg {
            padding: 10px 14px;
            border-radius: 6px;
            font-size: .85rem;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .alert-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-info-box {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 20px;
        }
        .alert-info-box h6 {
            font-size: .82rem;
            font-weight: 700;
            color: #0e0e37;
            margin-bottom: 8px;
        }
        .alert-info-box ul {
            margin: 0; padding-left: 18px;
            font-size: .8rem; color: #666; line-height: 1.7;
        }
        .field-error {
            font-size: .78rem; color: #b91c1c;
            margin-top: 4px;
        }
        @media (max-width: 768px) {
            .auth-left { display: none; }
            body { background: #fafafa; }
            .auth-right { padding: 32px 20px; }
        }
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="brand">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza">
            <div class="brand-name">Qenza</div>
            <div class="brand-sub">Cucian Salju Sijunjung</div>
        </div>
        <div class="auth-left-quote">
            <strong>Lupa password?</strong><br>
            Jangan khawatir. Kami akan mengirimkan kode OTP ke email Anda untuk reset password.
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form">
            <h1>Lupa Password</h1>
            <p class="subtitle">Masukkan email Anda, kode OTP akan dikirim untuk reset.</p>

            <?php if(session()->getFlashdata('error')): ?>
            <div class="alert-msg alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('message')): ?>
            <div class="alert-msg alert-success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('message') ?>
            </div>
            <?php endif; ?>

            <form id="formForgotPassword" action="<?= site_url('auth/forgot-password') ?>" method="POST">
                <div class="field">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="email@contoh.com" required autofocus>
                    <?php if(isset($validation) && $validation->hasError('email')): ?>
                        <p class="field-error"><i class="fas fa-exclamation-triangle me-1"></i><?= $validation->getError('email') ?></p>
                    <?php endif; ?>
                </div>

                <div class="alert-info-box">
                    <h6><i class="fas fa-info-circle me-1"></i>Cara kerja reset password:</h6>
                    <ul>
                        <li>Kode OTP akan dikirim ke email Anda</li>
                        <li>Kode berlaku selama 10 menit</li>
                        <li>Periksa folder spam jika tidak menerima email</li>
                    </ul>
                </div>

                <button type="submit" id="submit-btn" class="btn-submit">
                    <span id="submit-text">Kirim Kode OTP</span>
                </button>
            </form>

            <div class="auth-links">
                <a href="<?= site_url('auth') ?>" class="link-bold"><i class="fas fa-arrow-left me-1"></i>Kembali ke Login</a>
                <span class="sep">|</span>
                <a href="<?= site_url('/') ?>">Beranda</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#formForgotPassword').on('submit', function() {
            var email = $('#email').val().trim();
            if (!email) return false;
            $('#submit-btn').prop('disabled', true);
            $('#submit-text').html('<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...');
        });
    });
    </script>
</body>
</html>
