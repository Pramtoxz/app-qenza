<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Faktur - Qenza</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="<?= site_url('assets/img/logoqenza.jpg') ?>">
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

        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 18px; border-radius: 20px;
            font-size: .85rem; font-weight: 700;
        }

        .kendaraan-card {
            background: var(--accent-soft);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 16px;
        }
        .kendaraan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .kendaraan-plat {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--accent);
        }
        .kendaraan-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .kendaraan-info-item {
            font-size: .85rem;
        }
        .kendaraan-info-item .ki-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #999;
            margin-bottom: 4px;
        }
        .kendaraan-info-item .ki-value {
            font-weight: 600;
            color: var(--accent);
        }
        .paket-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }
        .paket-tag {
            font-size: .75rem;
            font-weight: 600;
            padding: 4px 10px;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            color: var(--accent);
        }

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
            .kendaraan-info { grid-template-columns: 1fr; }
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
            <span>Pencucian Qenza</span>
        </a>
        <div class="nav-right">
            <a href="<?= base_url() ?>">Beranda</a>
            <a href="<?= base_url('auth/login') ?>" class="btn-nav">Masuk</a>
        </div>
    </nav>

    <div class="page-wrap">
        <div class="page-label">Pelacakkan Faktur</div>
        <h1 class="page-title">Lacak status faktur</h1>
        <p class="page-desc">Masukkan ID Faktur dari nota Anda untuk melihat status terkini kendaraan.</p>

        <div class="card-white">
            <form action="<?= base_url('faktur/tracking') ?>" method="GET">
                <div class="field" style="margin-bottom:16px">
                    <label for="trackId">ID Faktur</label>
                    <input type="text" id="trackId" name="id"
                           value="<?= isset($_GET['id']) ? esc($_GET['id']) : '' ?>"
                           placeholder="FKP-20260714-0001" required>
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

        <?php if (isset($faktur)): ?>
        <div style="background:#fff;border:1px solid #e5e5e5;border-radius:10px;overflow:hidden;margin-bottom:24px">
            <div class="result-header">
                <div>
                    <h3>#<?= $faktur['idreservasi'] ?></h3>
                    <span class="sub">Status faktur pencucian kendaraan Anda</span>
                </div>
                <div class="meta">
                    <div class="label">Tanggal</div>
                    <div class="val"><?= date('d M Y', strtotime($faktur['tgl'])) ?></div>
                    <div class="label" style="margin-top:2px">Antrian: <?= str_pad($faktur['nomor_antrian'], 2, '0', STR_PAD_LEFT) ?></div>
                </div>
            </div>

            <div class="result-body">
                <!-- Pelanggan Info -->
                <div style="background: var(--accent-soft); border-radius: 10px; padding: 16px; margin-bottom: 20px;">
                    <div style="font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 8px; padding-left: 12px; border-left: 3px solid var(--accent);">Pelanggan</div>
                    <div style="font-weight: 700; color: var(--accent); font-size: .95rem;"><?= $faktur['nama_pelanggan'] ?></div>
                    <div style="font-size: .8rem; color: #666; line-height: 1.6;">
                        <?= $faktur['alamat'] ?><br>
                        <?= $faktur['nohp'] ?>
                    </div>
                </div>

                <!-- Daftar Kendaraan -->
                <h4 style="font-weight: 700; margin-bottom: 16px; font-size: 1rem;">Daftar Kendaraan</h4>
                <?php foreach ($kendaraan as $k): ?>
                <div class="kendaraan-card">
                    <div class="kendaraan-header">
                        <span class="kendaraan-plat"><i class="fas fa-car me-2"></i><?= $k['platnomor'] ?></span>
                        <?php if ($k['status'] == 'pending'): ?>
                            <span class="status-badge" style="background:#f3f4f6;color:#6b7280;"><i class="fas fa-clipboard-list"></i> Menunggu Proses</span>
                        <?php elseif ($k['status'] == 'diproses'): ?>
                            <span class="status-badge" style="background:#fef9c3;color:#a16207;"><i class="fas fa-clock"></i> Sedang Diproses</span>
                        <?php elseif ($k['status'] == 'dijemput'): ?>
                            <span class="status-badge" style="background:#dbeafe;color:#1d4ed8;"><i class="fas fa-car"></i> Siap Dijemput</span>
                        <?php elseif ($k['status'] == 'selesai'): ?>
                            <span class="status-badge" style="background:#dcfce7;color:#15803d;"><i class="fas fa-check-circle"></i> Selesai</span>
                        <?php elseif ($k['status'] == 'batal'): ?>
                            <span class="status-badge" style="background:#fef2f2;color:#b91c1c;"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                        <?php endif; ?>
                    </div>
                    <div class="kendaraan-info">
                        <div class="kendaraan-info-item">
                            <div class="ki-label">Karyawan</div>
                            <div class="ki-value"><?= $k['nama_karyawan'] ?? 'Belum ditugaskan' ?></div>
                        </div>
                        <div class="kendaraan-info-item">
                            <div class="ki-label">Paket</div>
                            <div class="paket-tags">
                                <?php foreach ($k['paket_list'] as $p): ?>
                                    <span class="paket-tag"><?= $p['namapaket'] ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="action-row">
                    <a href="<?= base_url() ?>" class="btn-ghost-sm"><i class="fas fa-arrow-left me-1"></i> Beranda</a>
                    <button onclick="location.reload()" class="btn-accent-sm"><i class="fas fa-sync-alt me-1"></i> Refresh</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <footer class="site-footer">
        <div class="footer-brand">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza">
            <span>Pencucian Qenza</span>
        </div>
        <span class="footer-copy">&copy; <?= date('Y') ?> Qenza. Semua hak dilindungi.</span>
    </footer>

    <script>
        <?php if (isset($faktur)): ?>
        setTimeout(function() { location.reload(); }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>
