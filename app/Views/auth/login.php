<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Qenza</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/img/logoqenza.jpeg">
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
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSnIpDC1okcfLnkgReR4gTw8tQUCTLJEQBehr0YyKPH90KgJZ5o3fm_bV9S&s=10') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(14,14,55,.65);
            z-index: 1;
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
        .field-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .field-row label {
            font-size: .85rem; color: #555; cursor: pointer;
            display: flex; align-items: center; gap: 6px; margin: 0;
            font-weight: 500; text-transform: none; letter-spacing: 0;
        }
        .field-row input[type="checkbox"] {
            width: 16px; height: 16px; accent-color: #0e0e37;
        }
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
        .auth-links .back-home {
            display: inline-block;
            margin-top: 12px;
            font-size: .8rem;
        }
        .alert-msg {
            padding: 10px 14px;
            border-radius: 6px;
            font-size: .85rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-msg .close-alert {
            margin-left: auto; background: none; border: none;
            cursor: pointer; font-size: 1rem; color: inherit; opacity: .5;
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
        <div class="brand" style="position:relative;z-index:2;">
            <img src="<?= base_url('assets/img/logoqenza.jpeg') ?>" alt="Qenza">
            <div class="brand-name">Qenza</div>
            <div class="brand-sub">Cucian Salju Sijunjung</div>
        </div>
        <div class="auth-left-quote" style="position:relative;z-index:2;">
            <strong>Kendaraan bersih, hati senang.</strong><br>
            Sistem manajemen pencucian untuk memantau pesanan, pelacakkan status, dan kelola operasional harian.
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form">
            <h1>Masuk</h1>
            <p class="subtitle">Silakan login untuk melanjutkan ke dashboard.</p>

            <?php if(session()->getFlashdata('error')): ?>
            <div class="alert-msg alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
                <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
            <?php endif; ?>

            <div id="alert-message" class="alert-msg alert-danger" style="display:none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="alert-text"></span>
                <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>

            <?php if(session()->getFlashdata('message')): ?>
            <div class="alert-msg alert-success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('message') ?>
                <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
            <?php endif; ?>

            <form id="formAuthentication">
                <div class="field">
                    <label for="username">Username atau Email</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username atau email" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="field-row">
                    <label>
                        <input type="checkbox" id="remember" name="remember"> Ingat saya
                    </label>
                </div>
                <button type="submit" id="login-btn" class="btn-submit">
                    <span id="login-text">Masuk</span>
                </button>
            </form>

            <div class="auth-links">
                <a href="<?= site_url('/') ?>" class="back-home">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $('#formAuthentication').on('submit', function(e) {
            e.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();
            var remember = $('#remember').is(':checked') ? 'on' : 'off';
            var $btn = $('#login-btn');
            var $text = $('#login-text');

            $('#alert-message').hide();
            $btn.prop('disabled', true);
            $text.html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');

            $.ajax({
                url: '<?= site_url('auth/login') ?>',
                type: 'POST',
                data: { username: username, password: password, remember: remember },
                success: function(response) {
                    if (response.status === 'success') {
                        $text.html('<i class="fas fa-check mr-2"></i>Berhasil!');
                        Swal.fire({
                            title: 'Login Berhasil!',
                            text: 'Selamat datang di Applikasi Pencucian Qenza',
                            icon: 'success',
                            confirmButtonColor: '#0e0e37',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = response.redirect;
                        });
                    } else {
                        $btn.prop('disabled', false);
                        $text.text('Masuk');
                        $('#alert-text').text(response.message);
                        $('#alert-message').show();
                    }
                },
                error: function() {
                    $btn.prop('disabled', false);
                    $text.text('Masuk');
                    $('#alert-text').text('Terjadi kesalahan sistem. Silakan coba lagi.');
                    $('#alert-message').show();
                }
            });
        });
    });
    </script>
</body>
</html>
