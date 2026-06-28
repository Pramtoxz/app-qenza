<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Qenza</title>
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
        .alert-info-box .info-inline {
            font-size: .85rem; color: #555;
        }
        .alert-info-box .info-inline strong { color: #0e0e37; }
        .field-error {
            font-size: .78rem; color: #b91c1c;
            margin-top: 4px;
        }
        .strength-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .strength-row small { font-size: .78rem; color: #999; }
        .strength-row .str-label { font-weight: 700; }
        .strength-bar {
            width: 100%;
            height: 4px;
            background: #e5e5e5;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .strength-bar-fill {
            height: 100%;
            width: 0;
            border-radius: 2px;
            transition: width .3s, background .3s;
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
            <strong>Reset password Anda.</strong><br>
            Buat password baru yang kuat untuk menjaga keamanan akun Anda.
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form">
            <h1>Reset Password</h1>
            <p class="subtitle">Buat password baru untuk akun Anda.</p>

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

            <div class="alert-info-box">
                <p class="info-inline"><i class="fas fa-envelope mr-1"></i> Reset password untuk: <strong><?= $email ?></strong></p>
            </div>

            <form id="formResetPassword" action="<?= site_url('auth/reset-password') ?>" method="POST">
                <input type="hidden" name="email" value="<?= $email ?>">

                <div class="field">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required autofocus>
                    <?php if(isset($validation) && $validation->hasError('password')): ?>
                        <p class="field-error"><i class="fas fa-exclamation-triangle mr-1"></i><?= $validation->getError('password') ?></p>
                    <?php endif; ?>
                </div>

                <div class="strength-row">
                    <small>Kekuatan password:</small>
                    <small id="strength-text" class="str-label">-</small>
                </div>
                <div class="strength-bar">
                    <div id="strength-bar" class="strength-bar-fill"></div>
                </div>

                <div class="field">
                    <label for="password_confirm">Konfirmasi Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Ulangi password" required>
                    <?php if(isset($validation) && $validation->hasError('password_confirm')): ?>
                        <p class="field-error"><i class="fas fa-exclamation-triangle mr-1"></i><?= $validation->getError('password_confirm') ?></p>
                    <?php endif; ?>
                </div>

                <div class="alert-info-box">
                    <h6>Persyaratan:</h6>
                    <ul>
                        <li id="req-length"><i class="fas fa-circle" style="font-size:7px;margin-right:4px;color:#ccc"></i>Minimal 6 karakter</li>
                        <li id="req-match"><i class="fas fa-circle" style="font-size:7px;margin-right:4px;color:#ccc"></i>Password dan konfirmasi harus sama</li>
                    </ul>
                </div>

                <button type="submit" id="submit-btn" class="btn-submit" disabled>
                    <span id="submit-text">Set Password Baru</span>
                </button>
            </form>

            <div class="auth-links">
                <a href="<?= site_url('auth') ?>" class="link-bold"><i class="fas fa-arrow-left mr-1"></i>Kembali ke Login</a>
                <span class="sep">|</span>
                <a href="<?= site_url('/') ?>">Beranda</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        function checkPasswordStrength(password) {
            var s = 0;
            if (password.length >= 6) s += 25;
            if (password.length >= 8) s += 25;
            if (/[A-Z]/.test(password)) s += 25;
            if (/[0-9]/.test(password)) s += 25;
            return s;
        }

        function updateStrength(strength) {
            var $bar = $('#strength-bar');
            var $text = $('#strength-text');
            var colors = { 0: '#ef4444', 25: '#ef4444', 50: '#f59e0b', 75: '#3b82f6', 100: '#22c55e' };
            var labels = { 0: 'Lemah', 25: 'Lemah', 50: 'Sedang', 75: 'Baik', 100: 'Kuat' };
            $bar.css({ width: strength + '%', background: colors[strength] || '#e5e5e5' });
            $text.text(labels[strength] || '-').css('color', colors[strength] || '#999');
        }

        function validateForm() {
            var pw = $('#password').val();
            var cp = $('#password_confirm').val();
            var iconOk = '<i class="fas fa-check-circle" style="font-size:7px;margin-right:4px;color:#22c55e"></i>';
            var iconNo = '<i class="fas fa-circle" style="font-size:7px;margin-right:4px;color:#ccc"></i>';

            $('#req-length i').replaceWith(pw.length >= 6 ? iconOk : iconNo);
            $('#req-match i').replaceWith((pw && cp && pw === cp) ? iconOk : iconNo);

            $('#submit-btn').prop('disabled', !(pw.length >= 6 && pw === cp && pw.length > 0));
        }

        $('#password').on('input', function() {
            updateStrength(checkPasswordStrength($(this).val()));
            validateForm();
        });
        $('#password_confirm').on('input', validateForm);

        $('#formResetPassword').on('submit', function(e) {
            if ($('#password').val() !== $('#password_confirm').val()) {
                e.preventDefault();
                Swal.fire({ title: 'Password Tidak Cocok', text: 'Konfirmasi password harus sama', icon: 'error', confirmButtonColor: '#0e0e37' });
                return false;
            }
            $('#submit-btn').prop('disabled', true);
            $('#submit-text').html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');
        });
    });
    </script>
</body>
</html>
