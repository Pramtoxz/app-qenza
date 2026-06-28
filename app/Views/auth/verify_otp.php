<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Qenza</title>
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
        .otp-row {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .otp-input {
            width: 48px; height: 56px;
            text-align: center;
            font-size: 1.3rem;
            font-weight: 700;
            font-family: inherit;
            border: 1.5px solid #e5e5e5;
            border-radius: 8px;
            background: #fff;
            transition: border-color .2s, background .2s, color .2s;
        }
        .otp-input:focus { outline: none; border-color: #0e0e37; }
        .otp-input.filled {
            background: #0e0e37;
            color: #fff;
            border-color: #0e0e37;
        }
        .timer-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: .82rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 20px;
        }
        .timer-badge i { color: #f59e0b; }
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
        .btn-outline {
            padding: 10px 24px;
            background: transparent;
            color: #0e0e37;
            border: 1.5px solid #e5e5e5;
            border-radius: 8px;
            font-size: .85rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }
        .btn-outline:hover { border-color: #0e0e37; background: #f8f9fa; }
        .btn-outline:disabled { opacity: .4; cursor: not-allowed; }
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
            margin-top: 20px;
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
        .resend-area {
            text-align: center;
            margin: 20px 0;
        }
        .resend-area p { font-size: .85rem; color: #999; margin-bottom: 10px; }
        .email-highlight {
            font-size: .85rem; color: #555; text-align: center;
            margin-bottom: 24px;
        }
        .email-highlight strong { color: #0e0e37; }
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
            <strong>Verifikasi identitas Anda.</strong><br>
            Masukkan kode 6 digit yang dikirim ke email untuk melanjutkan proses reset password.
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form">
            <h1>Verifikasi OTP</h1>
            <p class="subtitle">Masukkan kode 6 digit dari email Anda.</p>

            <p class="email-highlight">Kode dikirim ke <strong><?= $email ?></strong></p>

            <?php if(session()->getFlashdata('error')): ?>
            <div class="alert-msg alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <div id="alert-message" class="alert-msg alert-danger" style="display:none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="alert-text"></span>
            </div>

            <?php if(session()->getFlashdata('message')): ?>
            <div class="alert-msg alert-success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('message') ?>
            </div>
            <?php endif; ?>

            <form id="formOTP" action="<?= site_url($action) ?>" method="POST">
                <input type="hidden" name="email" value="<?= $email ?>">
                <input type="hidden" name="type" value="<?= $type ?>">
                <?php if (isset($formData) && !empty($formData)): ?>
                    <?php foreach($formData as $key => $value): ?>
                        <input type="hidden" name="form_data[<?= $key ?>]" value="<?= $value ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="otp-row">
                    <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="0" autofocus>
                    <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="1">
                    <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="2">
                    <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="3">
                    <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="4">
                    <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="5">
                </div>

                <div class="text-center">
                    <span class="timer-badge">
                        <i class="fas fa-clock"></i>
                        Berlaku: <strong id="countdown">10:00</strong>
                    </span>
                </div>

                <button type="submit" id="verify-btn" class="btn-submit" disabled>
                    <span id="verify-text">Verifikasi</span>
                </button>
            </form>

            <div class="resend-area">
                <p>Tidak menerima kode?</p>
                <button id="resendOTP" class="btn-outline" disabled>
                    <i class="fas fa-redo mr-1"></i> <span id="resend-text">Kirim Ulang</span>
                </button>
            </div>

            <div class="alert-info-box">
                <h6><i class="fas fa-info-circle mr-1"></i>Tips:</h6>
                <ul>
                    <li>Periksa folder spam jika kode tidak diterima</li>
                    <li>Kode hanya berlaku sekali pakai</li>
                </ul>
            </div>

            <div class="auth-links">
                <a href="<?= site_url('auth') ?>"><i class="fas fa-arrow-left mr-1"></i>Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        var duration = 10 * 60;
        var timer = duration;
        var countdownInterval;

        $('.otp-input').on('keyup', function(e) {
            var index = parseInt($(this).data('index'));
            var value = $(this).val();

            if (!/^\d$/.test(value) && value !== '') { $(this).val(''); return; }

            if (value) {
                $(this).addClass('filled');
                if (index < 5) $('.otp-input[data-index="' + (index + 1) + '"]').focus();
            } else {
                $(this).removeClass('filled');
            }

            if (e.keyCode === 8 && index > 0 && value === '') {
                $('.otp-input[data-index="' + (index - 1) + '"]').focus();
            }

            checkOTPComplete();
        });

        $('.otp-input').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value) { $(this).addClass('filled'); } else { $(this).removeClass('filled'); }
            checkOTPComplete();
        });

        function checkOTPComplete() {
            var isComplete = true;
            $('.otp-input').each(function() { if ($(this).val() === '') { isComplete = false; return false; } });
            $('#verify-btn').prop('disabled', !isComplete);
        }

        function updateCountdown() {
            var minutes = Math.floor(timer / 60);
            var seconds = timer % 60;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            $('#countdown').text(minutes + ":" + seconds);

            if (timer === 0) {
                clearInterval(countdownInterval);
                $('#resendOTP').prop('disabled', false);
                $('.otp-input').prop('disabled', true).removeClass('filled');
                $('#verify-btn').prop('disabled', true);
                $('#alert-text').text('Kode OTP telah kedaluarsa. Silakan kirim ulang kode.');
                $('#alert-message').show();
            } else {
                timer--;
            }
        }

        countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();

        $('#resendOTP').on('click', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $text = $('#resend-text');

            $button.prop('disabled', true);
            $text.html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');

            $.ajax({
                url: '<?= site_url('auth/resend-otp') ?>',
                type: 'POST',
                data: { email: '<?= $email ?>', type: '<?= $type ?>' },
                success: function(response) {
                    if (response.status === 'success') {
                        timer = duration;
                        clearInterval(countdownInterval);
                        countdownInterval = setInterval(updateCountdown, 1000);
                        $('.otp-input').val('').prop('disabled', false).removeClass('filled');
                        $('.otp-input[data-index="0"]').focus();
                        $('#alert-message').hide();
                        Swal.fire({ title: 'Kode Baru Terkirim!', text: response.message, icon: 'success', confirmButtonColor: '#0e0e37', timer: 2000, showConfirmButton: false });
                        $text.html('<i class="fas fa-redo mr-1"></i>Kirim Ulang');
                    } else {
                        $('#alert-text').text(response.message);
                        $('#alert-message').show();
                        $button.prop('disabled', false);
                        $text.html('<i class="fas fa-redo mr-1"></i>Kirim Ulang');
                    }
                },
                error: function() {
                    $('#alert-text').text('Terjadi kesalahan. Silakan coba lagi.');
                    $('#alert-message').show();
                    $button.prop('disabled', false);
                    $text.html('<i class="fas fa-redo mr-1"></i>Kirim Ulang');
                }
            });
        });

        $('#formOTP').on('submit', function() {
            $('#verify-btn').prop('disabled', true);
            $('#verify-text').html('<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...');
        });

        $(document).on('paste', '.otp-input', function(e) {
            e.preventDefault();
            var paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
            if (/^\d{6}$/.test(paste)) {
                var digits = paste.split('');
                $('.otp-input').each(function(index) { $(this).val(digits[index]).addClass('filled'); });
                checkOTPComplete();
                $('.otp-input').last().focus();
            }
        });
    });
    </script>
</body>
</html>
