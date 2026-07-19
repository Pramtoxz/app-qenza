<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Faktur - Qenza</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="<?= site_url('assets/img/logoqenza.jpeg') ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eeeef8', 100: '#d5d5ef', 600: '#3a3a6e', 800: '#0e0e37' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased min-h-screen flex flex-col">

<?php if (isset($error)): ?>
<main class="flex-1 flex items-center justify-center px-5 py-12">
    <div class="w-full max-w-md text-center">
        <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        </div>
        <h1 class="text-xl font-bold text-brand-800 mb-2">Faktur Tidak Ditemukan</h1>
        <p class="text-sm text-gray-500 leading-relaxed mb-8"><?= $error ?></p>
        <a href="<?= base_url() ?>" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-brand-800 rounded-xl hover:bg-brand-600 transition-colors min-h-[48px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</main>
<?php endif; ?>

<?php if (isset($faktur)): ?>
<main class="flex-1">
    <div class="max-w-2xl mx-auto px-5 py-6 sm:py-10">

        <div class="flex items-center gap-3 mb-6">
            <img src="<?= base_url('assets/img/logoqenza.jpeg') ?>" alt="Qenza" class="w-8 h-8 rounded-md object-cover">
            <span class="text-sm font-bold text-brand-800 tracking-tight">Pencucian Qenza</span>
        </div>

        <div class="bg-brand-800 text-white rounded-2xl p-5 sm:p-8 mb-5">
            <p class="text-[11px] font-semibold uppercase tracking-widest text-white/50 mb-1">Tracking Faktur</p>
            <h1 class="text-[22px] sm:text-3xl font-extrabold tracking-tight mb-1 break-all">#<?= $faktur['idreservasi'] ?></h1>
            <p class="text-sm text-white/50 mt-2"><?= date('l, d F Y', strtotime($faktur['tgl'])) ?></p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 mb-5">
            <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-2">Pelanggan</p>
            <p class="font-bold text-brand-800 text-[15px]"><?= $faktur['nama_pelanggan'] ?></p>
            <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                <?= $faktur['alamat'] ?><br>
                <?= $faktur['nohp'] ?>
            </p>
        </div>

        <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-3">Kendaraan</p>

        <?php foreach ($kendaraan as $k): ?>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 mb-4">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Plat Nomor</p>
                    <p class="text-lg font-extrabold text-brand-800 tracking-tight"><?= $k['platnomor'] ?></p>
                </div>
                <?php
                    $statusConfig = [
                        'pending'   => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',  'dot' => 'bg-gray-400',  'label' => 'Menunggu'],
                        'diproses'  => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Diproses'],
                        'dijemput'  => ['bg' => 'bg-blue-50',    'text' => 'text-blue-700',  'dot' => 'bg-blue-500',  'label' => 'Siap Dijemput'],
                        'selesai'   => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700','dot'=> 'bg-emerald-500','label' => 'Selesai'],
                        'batal'     => ['bg' => 'bg-red-50',     'text' => 'text-red-700',   'dot' => 'bg-red-500',   'label' => 'Dibatalkan'],
                    ];
                    $s = $statusConfig[$k['status']] ?? $statusConfig['pending'];
                ?>
                <span class="inline-flex items-center gap-1.5 <?= $s['bg'] ?> <?= $s['text'] ?> text-xs font-bold px-3 py-2 rounded-full whitespace-nowrap min-h-[40px]">
                    <span class="w-2 h-2 rounded-full <?= $s['dot'] ?> shrink-0"></span>
                    <?= $s['label'] ?>
                </span>
            </div>

            <div class="border-t border-gray-100 pt-4 space-y-3">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Karyawan</p>
                    <p class="text-sm font-semibold text-gray-700"><?= $k['nama_karyawan'] ?? 'Belum ditugaskan' ?></p>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1.5">Paket Cucian</p>
                    <div class="flex flex-wrap gap-1.5">
                        <?php foreach ($k['paket_list'] as $p): ?>
                            <span class="inline-block text-xs font-semibold bg-brand-50 text-brand-800 px-2.5 py-1.5 rounded-lg"><?= $p['namapaket'] ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="text-center mt-8 mb-2">
            <button onclick="location.reload()" id="refreshBtn" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3.5 text-sm font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 rounded-xl transition-colors min-h-[48px]">
                <svg id="refreshIcon" class="w-4 h-4 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                Refresh Status
            </button>
            <p class="text-xs text-gray-400 mt-3">Auto-refresh setiap 30 detik</p>
        </div>

    </div>
</main>
<?php endif; ?>

<footer class="border-t border-gray-200 bg-white mt-auto">
    <div class="max-w-2xl mx-auto px-5 py-5 flex flex-col sm:flex-row items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            <img src="<?= base_url('assets/img/logoqenza.jpeg') ?>" alt="Qenza" class="w-5 h-5 rounded object-cover">
            <span class="text-xs font-bold text-brand-800">Pencucian Qenza</span>
        </div>
        <p class="text-xs text-gray-400">&copy; <?= date('Y') ?> Qenza. Semua hak dilindungi.</p>
    </div>
</footer>

<?php if (isset($faktur)): ?>
<script>
    setTimeout(function() { location.reload(); }, 30000);
    document.getElementById('refreshBtn').addEventListener('click', function() {
        document.getElementById('refreshIcon').classList.add('rotate-[360deg]');
    });
</script>
<?php endif; ?>

</body>
</html>
