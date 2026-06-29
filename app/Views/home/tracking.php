<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status - Qenza</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/img/logoqenza.jpg">
    <style>
        :root { --accent: #0e0e37; --accent-soft: #eeeef8; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            background: #fafafa;
            color: #1a1a1a;
        }
        .site-nav {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo img { height: 32px; border-radius: 5px; }
        .nav-logo span { font-weight: 800; font-size: 1rem; color: var(--accent); }
        .nav-right { display: flex; align-items: center; gap: 16px; }
        .nav-right a {
            font-size: .85rem; font-weight: 500; color: #777;
            text-decoration: none; transition: color .2s;
        }
        .nav-right a:hover { color: var(--accent); }
        .nav-right .btn-nav {
            background: var(--accent); color: #fff;
            padding: 7px 18px; border-radius: 6px;
            font-weight: 600; font-size: .82rem;
            transition: opacity .2s;
        }
        .nav-right .btn-nav:hover { opacity: .8; color: #fff; text-decoration: none; }

        .page-wrap { max-width: 820px; margin: 0 auto; padding: 48px 24px 80px; }
        .page-label {
            font-size: .7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 2.5px; color: var(--accent); margin-bottom: 10px;
        }
        .page-title {
            font-size: 2rem; font-weight: 800; color: var(--accent);
            letter-spacing: -.8px; margin-bottom: 8px;
        }
        .page-desc { font-size: .95rem; color: #777; line-height: 1.6; margin-bottom: 36px; max-width: 560px; }

        .card-white {
            background: #fff; border: 1px solid #e5e5e5;
            border-radius: 10px; padding: 32px; margin-bottom: 24px;
        }
        .field label {
            display: block; font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .8px; color: #999;
            margin-bottom: 8px;
        }
        .field input {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #e5e5e5; border-radius: 8px;
            font-size: .95rem; font-family: inherit;
            transition: border-color .2s;
        }
        .field input:focus { outline: none; border-color: var(--accent); }
        .field input::placeholder { color: #ccc; }
        .btn-accent {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 14px;
            background: var(--accent); color: #fff;
            border: none; border-radius: 8px;
            font-size: .95rem; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: opacity .2s;
        }
        .btn-accent:hover { opacity: .85; }

        .alert-err {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 16px; border-radius: 8px;
            background: #fef2f2; border: 1px solid #fecaca;
            color: #b91c1c; font-size: .88rem; margin-bottom: 20px;
        }
        .alert-err i { font-size: 1.1rem; flex-shrink: 0; }

        .result-header {
            background: var(--accent); color: #fff;
            padding: 24px 32px; border-radius: 10px 10px 0 0;
            display: flex; justify-content: space-between; align-items: flex-start;
            flex-wrap: wrap; gap: 12px;
        }
        .result-header h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 4px; }
        .result-header .sub { font-size: .85rem; color: rgba(255,255,255,.6); }
        .result-header .meta { text-align: right; }
        .result-header .meta .label { font-size: .75rem; color: rgba(255,255,255,.5); }
        .result-header .meta .val { font-weight: 700; font-size: .95rem; }
        .result-body { padding: 32px; }

        .timeline {
            display: flex; align-items: center; justify-content: center;
            gap: 0; margin-bottom: 32px; flex-wrap: wrap;
        }
        .tl-step { display: flex; flex-direction: column; align-items: center; }
        .tl-dot {
            width: 42px; height: 42px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .85rem; margin-bottom: 6px;
        }
        .tl-dot.on { background: #16a34a; }
        .tl-dot.off { background: #d1d5db; }
        .tl-label { font-size: .72rem; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: .5px; }
        .tl-line { width: 52px; height: 3px; border-radius: 2px; margin-bottom: 18px; }
        .tl-line.on { background: #16a34a; }
        .tl-line.off { background: #d1d5db; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 18px; border-radius: 20px;
            font-size: .85rem; font-weight: 700;
        }
        .status-badge.proses { background: #fef9c3; color: #a16207; }
        .status-badge.jemput { background: #dbeafe; color: #1d4ed8; }
        .status-badge.selesai { background: #dcfce7; color: #15803d; }
        .status-msg { font-size: .9rem; color: #777; margin-top: 8px; }

        .detail-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 28px; }
        .detail-box {
            background: var(--accent-soft); border-radius: 10px; padding: 20px;
        }
        .detail-box-title {
            font-size: .7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: #999; margin-bottom: 10px;
            padding-left: 12px; border-left: 3px solid var(--accent);
        }
        .detail-box .name { font-weight: 700; color: var(--accent); font-size: .95rem; margin-bottom: 6px; }
        .detail-box .info { font-size: .8rem; color: #666; line-height: 1.6; }

        .action-row { display: flex; gap: 10px; justify-content: center; margin-top: 28px; flex-wrap: wrap; }
        .btn-ghost-sm {
            padding: 10px 22px; background: #f5f5f5; color: #555;
            border: 1px solid #e5e5e5; border-radius: 8px;
            font-size: .85rem; font-weight: 600; font-family: inherit;
            cursor: pointer; text-decoration: none; transition: all .2s;
        }
        .btn-ghost-sm:hover { border-color: var(--accent); color: var(--accent); text-decoration: none; }
        .btn-accent-sm {
            padding: 10px 22px; background: var(--accent); color: #fff;
            border: none; border-radius: 8px;
            font-size: .85rem; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: opacity .2s;
        }
        .btn-accent-sm:hover { opacity: .85; }

        .help-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .help-item {
            display: flex; align-items: center; gap: 12px;
            padding: 14px; background: var(--accent-soft); border-radius: 8px;
        }
        .help-item .hi-icon {
            width: 36px; height: 36px; border-radius: 8px;
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; flex-shrink: 0;
        }
        .help-item .hi-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #999; }
        .help-item .hi-val { font-size: .85rem; font-weight: 600; color: var(--accent); }

        .site-footer {
            background: var(--accent); color: #fff;
            padding: 32px;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px;
        }
        .footer-brand { display: flex; align-items: center; gap: 8px; }
        .footer-brand img { height: 24px; border-radius: 4px; }
        .footer-brand span { font-weight: 700; font-size: .9rem; }
        .footer-copy { font-size: .75rem; color: rgba(255,255,255,.4); }

        @media (max-width: 768px) {
            .detail-grid { grid-template-columns: 1fr; }
            .help-grid { grid-template-columns: 1fr; }
            .result-header { flex-direction: column; }
            .result-header .meta { text-align: left; }
            .page-wrap { padding: 32px 16px 60px; }
        }
    </style>
</head>
<body>

    <nav class="site-nav">
        <a class="nav-logo" href="<?= base_url() ?>">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza">
            <span>Qenza</span>
        </a>
        <div class="nav-right">
            <a href="<?= base_url() ?>">Beranda</a>
            <a href="<?= base_url('auth/login') ?>" class="btn-nav">Masuk</a>
        </div>
    </nav>

    <div class="page-wrap">
        <div class="page-label">Pelacakkan</div>
        <h1 class="page-title">Lacak status cucian</h1>
        <p class="page-desc">Masukkan ID pencucian dari nota Anda untuk melihat status terkini kendaraan.</p>

        <div class="card-white">
            <form action="<?= base_url('tracking') ?>" method="GET">
                <div class="field" style="margin-bottom:16px">
                    <label for="trackId">ID Pencucian</label>
                    <input type="text" id="trackId" name="id"
                           value="<?= isset($_GET['id']) ? esc($_GET['id']) : '' ?>"
                           placeholder="FKP-20260626-0001" required>
                </div>
                <button type="submit" class="btn-accent"><i class="fas fa-search"></i> Lacak</button>
            </form>
        </div>

        <?php if (isset($error)): ?>
        <div class="alert-err">
            <i class="fas fa-exclamation-triangle"></i>
            <div><strong>Tidak ditemukan.</strong> <?= $error ?></div>
        </div>
        <?php endif; ?>

        <?php if (isset($pencucian)): ?>
        <div style="background:#fff;border:1px solid #e5e5e5;border-radius:10px;overflow:hidden;margin-bottom:24px">
            <div class="result-header">
                <div>
                    <h3>#<?= $pencucian['idpencucian'] ?></h3>
                    <span class="sub">Status pencucian kendaraan Anda</span>
                </div>
                <div class="meta">
                    <div class="label">Tanggal</div>
                    <div class="val"><?= date('d M Y', strtotime($pencucian['tgl'])) ?></div>
                    <div class="label" style="margin-top:2px">Jam: <?= $pencucian['jamdatang'] ?></div>
                </div>
            </div>

            <div class="result-body">
                <div class="timeline">
                    <div class="tl-step">
                        <div class="tl-dot <?= in_array($pencucian['status'], ['pending', 'diproses', 'dijemput', 'selesai']) ? 'on' : 'off' ?>">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <span class="tl-label">Pending</span>
                    </div>
                    <div class="tl-line <?= in_array($pencucian['status'], ['diproses', 'dijemput', 'selesai']) ? 'on' : 'off' ?>"></div>
                    <div class="tl-step">
                        <div class="tl-dot <?= in_array($pencucian['status'], ['diproses', 'dijemput', 'selesai']) ? 'on' : 'off' ?>">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="tl-label">Diproses</span>
                    </div>
                    <div class="tl-line <?= in_array($pencucian['status'], ['dijemput', 'selesai']) ? 'on' : 'off' ?>"></div>
                    <div class="tl-step">
                        <div class="tl-dot <?= in_array($pencucian['status'], ['dijemput', 'selesai']) ? 'on' : 'off' ?>">
                            <i class="fas fa-car"></i>
                        </div>
                        <span class="tl-label">Dijemput</span>
                    </div>
                    <div class="tl-line <?= $pencucian['status'] == 'selesai' ? 'on' : 'off' ?>"></div>
                    <div class="tl-step">
                        <div class="tl-dot <?= $pencucian['status'] == 'selesai' ? 'on' : 'off' ?>">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="tl-label">Selesai</span>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <?php if ($pencucian['status'] == 'pending'): ?>
                        <span class="status-badge" style="background:#f3f4f6;color:#6b7280;"><i class="fas fa-clipboard-list"></i> Menunggu Proses</span>
                        <p class="status-msg">Pesanan Anda sedang menunggu untuk diproses.</p>
                    <?php elseif ($pencucian['status'] == 'diproses'): ?>
                        <span class="status-badge proses"><i class="fas fa-clock"></i> Sedang Diproses</span>
                        <p class="status-msg">Kendaraan sedang dalam proses pencucian.</p>
                    <?php elseif ($pencucian['status'] == 'dijemput'): ?>
                        <span class="status-badge jemput"><i class="fas fa-car"></i> Siap Dijemput</span>
                        <p class="status-msg">Kendaraan sudah selesai dan siap dijemput.</p>
                    <?php elseif ($pencucian['status'] == 'selesai'): ?>
                        <span class="status-badge selesai"><i class="fas fa-check-circle"></i> Selesai</span>
                        <p class="status-msg">Terima kasih! Kendaraan sudah dijemput.</p>
                    <?php elseif ($pencucian['status'] == 'batal'): ?>
                        <span class="status-badge" style="background:#fef2f2;color:#b91c1c;"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                        <p class="status-msg">Pesanan ini telah dibatalkan.</p>
                    <?php endif; ?>
                </div>

                <div class="detail-grid">
                    <div class="detail-box">
                        <div class="detail-box-title">Pelanggan</div>
                        <div class="name"><?= $pencucian['nama_pelanggan'] ?></div>
                        <div class="info">
                            <?= $pencucian['alamat'] ?><br>
                            <?= $pencucian['nohp'] ?><br>
                            <?= $pencucian['platnomor'] ?>
                        </div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-title">Paket</div>
                        <div class="name"><?= $pencucian['namapaket'] ?></div>
                        <div class="info">
                            <?= $pencucian['jenis'] ?><br>
                            <strong style="color:#16a34a;font-size:1rem">Rp <?= number_format($pencucian['harga'], 0, ',', '.') ?></strong>
                        </div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-title">Karyawan</div>
                        <div class="name"><?= $pencucian['nama_karyawan'] ?? 'Belum ditugaskan' ?></div>
                        <div class="info"><?= !empty($pencucian['nama_karyawan']) ? 'Penanggung jawab pencucian' : 'Menunggu penugasan karyawan' ?></div>
                    </div>
                </div>

                <div class="action-row">
                    <a href="<?= base_url() ?>" class="btn-ghost-sm"><i class="fas fa-arrow-left mr-1"></i> Beranda</a>
                    <?php if (!in_array($pencucian['status'], ['selesai', 'batal'])): ?>
                    <button onclick="location.reload()" class="btn-accent-sm"><i class="fas fa-sync-alt mr-1"></i> Refresh</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="card-white">
            <h4 style="font-weight:700;margin-bottom:16px;font-size:1.1rem">Butuh bantuan?</h4>
            <div class="help-grid">
                <div class="help-item">
                    <div class="hi-icon"><i class="fas fa-phone"></i></div>
                    <div><div class="hi-label">Telepon</div><div class="hi-val">+62 751 123 4567</div></div>
                </div>
                <div class="help-item">
                    <div class="hi-icon"><i class="fab fa-whatsapp"></i></div>
                    <div><div class="hi-label">WhatsApp</div><div class="hi-val">+62 811 123 4567</div></div>
                </div>
                <div class="help-item">
                    <div class="hi-icon"><i class="fas fa-clock"></i></div>
                    <div><div class="hi-label">Jam Layanan</div><div class="hi-val">07:00 - 20:00 WIB</div></div>
                </div>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="footer-brand">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza">
            <span>Qenza</span>
        </div>
        <span class="footer-copy">&copy; <?= date('Y') ?> Qenza. Semua hak dilindungi.</span>
    </footer>

    <script>
        <?php if (isset($pencucian) && !in_array($pencucian['status'], ['selesai', 'batal'])): ?>
        setTimeout(function() { location.reload(); }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>
