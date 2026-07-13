<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/img/logoqenza.jpg">
    <style>
        :root {
            --accent: #0e0e37;
            --accent-soft: #eeeef8;
            --dark: #0e0e37;
            --gray-900: #0e0e37;
            --gray-600: #555;
            --gray-400: #999;
            --gray-200: #e5e5e5;
            --gray-100: #f5f5f5;
            --bg: #fafafa;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            color: var(--gray-900);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        /* ── NAV ── */
        .site-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 0 0;
            transition: background .35s, box-shadow .35s, padding .35s;
        }
        .site-nav.scrolled {
            background: #fff;
            box-shadow: 0 1px 0 var(--gray-200);
        }
        .site-nav .inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 32px;
            transition: padding .35s;
        }
        .site-nav.scrolled .inner { padding: 12px 32px; }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .nav-logo img { height: 36px; width: auto; border-radius: 6px; }
        .nav-logo span {
            font-weight: 800; font-size: 1.05rem; color: var(--dark);
            letter-spacing: -.3px;
        }
        .nav-links { display: flex; align-items: center; gap: 28px; list-style: none; margin: 0; padding: 0; }
        .nav-links a {
            font-size: .875rem; font-weight: 500; color: var(--gray-600);
            text-decoration: none; transition: color .2s;
        }
        .nav-links a:hover { color: var(--dark); }
        .nav-cta {
            background: var(--dark) !important;
            color: #fff !important;
            padding: 8px 22px !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
            font-size: .85rem !important;
            transition: opacity .2s;
        }
        .nav-cta:hover { opacity: .8; color: #fff !important; }
        .nav-toggle {
            display: none; background: none; border: none; cursor: pointer;
            font-size: 1.2rem; color: var(--dark); padding: 4px;
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 32px 80px;
            background: #fff;
            overflow: hidden;
        }
        .hero .inner {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        .hero-tag {
            display: inline-block;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent);
            margin-bottom: 20px;
            position: relative;
            padding-left: 28px;
        }
        .hero-tag::before {
            content: '';
            position: absolute; left: 0; top: 50%;
            width: 18px; height: 2px;
            background: var(--accent);
            transform: translateY(-50%);
        }
        .hero h1 {
            font-size: clamp(2.4rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin: 0 0 24px;
            color: var(--dark);
        }
        .hero h1 em {
            font-style: normal;
            color: var(--accent);
        }
        .hero-desc {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--gray-600);
            max-width: 480px;
            margin: 0 0 36px;
        }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-solid {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--accent); color: #fff;
            padding: 14px 28px; border-radius: 8px;
            font-weight: 600; font-size: .95rem;
            text-decoration: none; border: none; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-solid:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(14,14,55,.25); color: #fff; text-decoration: none; }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent; color: var(--dark);
            padding: 14px 28px; border-radius: 8px;
            font-weight: 600; font-size: .95rem;
            text-decoration: none;
            border: 1.5px solid var(--gray-200);
            transition: border-color .2s, background .2s;
        }
        .btn-ghost:hover { border-color: var(--dark); background: var(--gray-100); color: var(--dark); text-decoration: none; }
        .hero-visual {
            position: relative;
        }
        .hero-img-main {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            border-radius: 12px;
            display: block;
        }
        .hero-stat-card {
            position: absolute;
            bottom: -20px; left: -20px;
            background: #fff;
            padding: 18px 24px;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
            display: flex; align-items: center; gap: 14px;
        }
        .hero-stat-card .num {
            font-size: 1.6rem; font-weight: 800; color: var(--accent);
            line-height: 1;
        }
        .hero-stat-card .label {
            font-size: .75rem; color: var(--gray-400);
            font-weight: 600; text-transform: uppercase; letter-spacing: .5px;
            line-height: 1.3;
        }

        /* ── SECTION UTILS ── */
        .section { padding: 100px 32px; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-label {
            font-size: .7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 2.5px; color: var(--accent); margin-bottom: 14px;
        }
        .section-title {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800; letter-spacing: -1px;
            line-height: 1.15; margin: 0 0 16px; color: var(--dark);
        }
        .section-desc {
            font-size: 1.05rem; color: var(--gray-600);
            line-height: 1.7; max-width: 540px;
        }

        /* ── SERVICES ── */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0;
            margin-top: 60px;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .service-item {
            padding: 44px 36px;
            border-right: 1px solid var(--gray-200);
            border-bottom: 1px solid var(--gray-200);
            transition: background .2s;
            position: relative;
        }
        .service-item:nth-child(2n) { border-right: none; }
        .service-item:nth-last-child(-n+2) { border-bottom: none; }
        .service-item:hover { background: var(--accent-soft); }
        .service-num {
            font-size: .7rem; font-weight: 700; color: var(--gray-400);
            text-transform: uppercase; letter-spacing: 1.5px;
            margin-bottom: 18px;
        }
        .service-item h3 {
            font-size: 1.25rem; font-weight: 700;
            margin: 0 0 10px; color: var(--dark);
        }
        .service-item p {
            font-size: .9rem; color: var(--gray-600);
            line-height: 1.6; margin: 0 0 16px;
        }
        .service-tags {
            display: flex; flex-wrap: wrap; gap: 6px;
        }
        .service-tags span {
            font-size: .72rem; font-weight: 600;
            padding: 4px 10px; border-radius: 4px;
            background: var(--gray-100); color: var(--gray-600);
            letter-spacing: .2px;
        }

        /* ── PACKAGES ── */
        .packages-section { background: #fff; }
        .pkg-list { margin-top: 50px; }
        .pkg-row {
            display: grid;
            grid-template-columns: 1fr auto auto;
            align-items: center;
            gap: 24px;
            padding: 28px 0;
            border-bottom: 1px solid var(--gray-200);
            transition: background .15s;
        }
        .pkg-row:first-child { border-top: 1px solid var(--gray-200); }
        .pkg-row:hover { background: var(--accent-soft); margin: 0 -16px; padding: 28px 16px; border-radius: 8px; }
        .pkg-name {
            font-size: 1.1rem; font-weight: 700; color: var(--dark);
            margin: 0 0 4px;
        }
        .pkg-desc {
            font-size: .85rem; color: var(--gray-400); margin: 0;
            max-width: 400px;
        }
        .pkg-type {
            font-size: .72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: var(--accent);
            background: var(--accent-soft);
            padding: 5px 14px; border-radius: 4px;
            white-space: nowrap;
        }
        .pkg-price {
            font-size: 1.2rem; font-weight: 800; color: var(--dark);
            white-space: nowrap;
            letter-spacing: -.5px;
        }

        /* ── TRACKING ── */
        .tracking-section { background: var(--gray-100); }
        .tracking-box {
            margin-top: 40px;
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }
        .tracking-how h4 {
            font-size: 1.1rem; font-weight: 700; margin: 0 0 20px;
        }
        .tracking-step {
            display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;
        }
        .tracking-step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--accent-soft); color: var(--accent);
            font-size: .75rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }
        .tracking-step-text { font-size: .9rem; color: var(--gray-600); line-height: 1.5; }
        .tracking-step-text strong { color: var(--dark); }
        .tracking-form label {
            font-size: .8rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: var(--gray-400);
            margin-bottom: 8px; display: block;
        }
        .tracking-form input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            margin-bottom: 14px;
            transition: border-color .2s;
        }
        .tracking-form input:focus { outline: none; border-color: var(--accent); }
        .tracking-form .btn-solid { width: 100%; justify-content: center; padding: 16px; }

        /* ── CONTACT ── */
        .contact-section { background: #fff; }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 48px;
            margin-top: 50px;
        }
        .contact-item {
            display: flex; gap: 16px; margin-bottom: 32px;
        }
        .contact-icon {
            width: 44px; height: 44px; border-radius: 8px;
            background: var(--accent-soft); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .contact-item h5 {
            font-size: .8rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: var(--gray-400); margin: 0 0 4px;
        }
        .contact-item p {
            font-size: .95rem; color: var(--dark); margin: 0; line-height: 1.5;
        }
        .map-frame {
            width: 100%; height: 100%; min-height: 360px;
            border-radius: 12px; overflow: hidden;
            border: 1px solid var(--gray-200);
        }
        .map-frame iframe { width: 100%; height: 100%; border: 0; display: block; }
        .map-link {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 20px;
            font-size: .85rem; font-weight: 600; color: var(--accent);
            text-decoration: none;
        }
        .map-link:hover { text-decoration: underline; color: var(--accent); }

        /* ── FOOTER ── */
        .site-footer {
            background: var(--dark);
            color: #fff;
            padding: 48px 32px;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-brand { display: flex; align-items: center; gap: 10px; }
        .footer-brand img { height: 28px; border-radius: 4px; }
        .footer-brand span { font-weight: 700; font-size: .95rem; }
        .footer-copy { font-size: .8rem; color: var(--gray-400); }
        .footer-socials { display: flex; gap: 10px; }
        .footer-socials a {
            width: 36px; height: 36px; border-radius: 6px;
            background: rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .85rem;
            transition: background .2s;
        }
        .footer-socials a:hover { background: var(--accent); color: #fff; text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .hero .inner { grid-template-columns: 1fr; gap: 40px; }
            .hero-visual { order: -1; }
            .hero-stat-card { bottom: -14px; left: 16px; }
            .services-grid { grid-template-columns: 1fr; }
            .service-item { border-right: none !important; }
            .service-item:last-child { border-bottom: none; }
            .pkg-row { grid-template-columns: 1fr; gap: 8px; }
            .pkg-type { justify-self: start; }
            .tracking-box { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
            .map-frame { min-height: 280px; }
        }
        @media (max-width: 767px) {
            .nav-links { display: none; }
            .nav-links.open {
                display: flex; flex-direction: column;
                position: absolute; top: 100%; left: 0; right: 0;
                background: #fff; padding: 20px 32px;
                box-shadow: 0 8px 20px rgba(0,0,0,.06);
                gap: 16px;
            }
            .nav-toggle { display: block; }
            .hero { padding: 100px 20px 60px; min-height: auto; }
            .section { padding: 60px 20px; }
            .tracking-box { padding: 24px; }
        }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav class="site-nav" id="siteNav">
        <div class="inner">
            <a class="nav-logo" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza">
                <span>Qenza</span>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#paket">Harga</a></li>
                <li><a href="#lacak">Lacak</a></li>
                <li><a href="#kontak">Kontak</a></li>
                <li><a href="<?= base_url('auth') ?>" class="nav-cta">Masuk</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="inner">
            <div class="hero-text">
                <span class="hero-tag">Cucian Salju Sijunjung</span>
                <h1>Bersih <em>sempurna</em>,<br>kilau <em>terjaga</em>.</h1>
                <p class="hero-desc">Cuci mobil & motor profesional di Sijunjung. Dikerjakan tenaga berpengalaman dengan peralatan modern — kendaraan Anda kembali seperti baru.</p>
                <div class="hero-actions">
                    <a href="#paket" class="btn-solid"><i class="fas fa-arrow-right"></i> Lihat Paket</a>
                    <a href="#lacak" class="btn-ghost"><i class="fas fa-search"></i> Lacak Cucian</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza Car Wash" class="hero-img-main">
                <div class="hero-stat-card">
                    <div>
                        <div class="num">1000+</div>
                        <div class="label">Kendaraan<br>sudah dicuci</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section class="section" id="layanan" style="background:#fff">
        <div class="section-inner">
            <span class="section-label">Apa yang kami kerjakan</span>
            <h2 class="section-title">Layanan kami</h2>
            <p class="section-desc">Empat jenis layanan untuk menjaga kendaraan Anda tetap bersih dan terawat.</p>
            <div class="services-grid">
                <div class="service-item">
                    <div class="service-num">01</div>
                    <h3>Cuci Mobil</h3>
                    <p>Pencucian menyeluruh exterior dan interior. Shampo khusus, vacuum, dan poles kaca.</p>
                    <div class="service-tags">
                        <span>Cuci Body</span>
                        <span>Vacuum</span>
                        <span>Poles Kaca</span>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-num">02</div>
                    <h3>Cuci Motor</h3>
                    <p>Pencucian body, pembersihan mesin, dan poles velg untuk semua jenis motor.</p>
                    <div class="service-tags">
                        <span>Cuci Body</span>
                        <span>Bersih Mesin</span>
                        <span>Poles Velg</span>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-num">03</div>
                    <h3>Waxing</h3>
                    <p>Lindungi cat kendaraan dengan wax premium. Coating protection untuk kilau tahan lama.</p>
                    <div class="service-tags">
                        <span>Wax Premium</span>
                        <span>Coating</span>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-num">04</div>
                    <h3>Detailing</h3>
                    <p>Perawatan menyeluruh untuk kendaraan premium. Full detailing, engine bay, deep clean.</p>
                    <div class="service-tags">
                        <span>Full Detail</span>
                        <span>Engine Bay</span>
                        <span>Interior</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PACKAGES -->
    <section class="section packages-section" id="paket">
        <div class="section-inner">
            <span class="section-label">Paket & Harga</span>
            <h2 class="section-title">Pilih yang sesuai</h2>
            <p class="section-desc">Harga transparan, tanpa biaya tersembunyi. Semua paket sudah termasuk pelayanan terbaik.</p>
            <div class="pkg-list">
                <?php foreach ($paket as $item): ?>
                <div class="pkg-row">
                    <div>
                        <div class="pkg-name"><?= $item['namapaket'] ?></div>
                        <p class="pkg-desc"><?= $item['keterangan'] ?></p>
                    </div>
                    <span class="pkg-type"><?= $item['jenis'] ?></span>
                    <span class="pkg-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- TRACKING -->
    <section class="section tracking-section" id="lacak">
        <div class="section-inner">
            <span class="section-label">Cek Status</span>
            <h2 class="section-title">Lacak cucian Anda</h2>
            <p class="section-desc">Masukkan ID pencucian dari nota Anda untuk melihat status terkini.</p>
            <div class="tracking-box">
                <div class="tracking-how">
                    <h4>Cara melacak</h4>
                    <div class="tracking-step">
                        <span class="tracking-step-num">1</span>
                        <span class="tracking-step-text"><strong>Scan QR Code</strong> yang tertera pada nota pencucian Anda</span>
                    </div>
                    <div class="tracking-step">
                        <span class="tracking-step-num">2</span>
                        <span class="tracking-step-text">Atau <strong>masukkan ID</strong> pencucian secara manual di form sebelah</span>
                    </div>
                    <div class="tracking-step">
                        <span class="tracking-step-num">3</span>
                        <span class="tracking-step-text">Status akan <strong>otomatis refresh</strong> setiap 30 detik</span>
                    </div>
                </div>
                <div class="tracking-form">
                    <form action="<?= base_url('tracking') ?>" method="GET">
                        <label for="trackId">ID Pencucian</label>
                        <input type="text" id="trackId" name="id" placeholder="FKP-20260626-0001" required>
                        <button type="submit" class="btn-solid"><i class="fas fa-search"></i> Lacak Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section class="section contact-section" id="kontak">
        <div class="section-inner">
            <span class="section-label">Kunjungi kami</span>
            <h2 class="section-title">Lokasi & Kontak</h2>
            <div class="contact-grid">
                <div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h5>Alamat</h5>
                            <p>Sungai Jodi, Kec. Lubuk Tarok, Kabupaten Sijunjung, Sumatera Barat 27553</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h5>Telepon</h5>
                            <p>+62 751 123 4567</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h5>Jam Buka</h5>
                            <p>Setiap hari, 07:00 — 20:00 WIB</p>
                        </div>
                    </div>
                    <a href="https://maps.app.goo.gl/foFNR5XGSr5bhycS8" target="_blank" class="map-link">
                        <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                    </a>
                </div>
                <div class="map-frame">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.4155282838396!2d101.0058536!3d-0.8141514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2b150903083ac1%3A0xb1f3918c03ca0e8d!2sQenza%20carwash!5e0!3m2!1sid!2sid!4v1782476048220!5m2!1sid!2sid"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-cross-origin"
                        title="Lokasi Qenza Car Wash"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Qenza">
                <span>Qenza Car Wash</span>
            </div>
            <span class="footer-copy">&copy; <?= date('Y') ?> Qenza. Semua hak dilindungi.</span>
            <div class="footer-socials">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // Nav scroll effect
        var nav = document.getElementById('siteNav');
        window.addEventListener('scroll', function() {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Mobile toggle
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('open');
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(function(a) {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                var t = document.querySelector(this.getAttribute('href'));
                if (t) {
                    t.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    document.getElementById('navLinks').classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>
