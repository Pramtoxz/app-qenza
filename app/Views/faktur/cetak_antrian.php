<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Antrian - <?= $faktur['idreservasi'] ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= site_url('assets/img/logoqenza.jpeg') ?>">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Courier New', monospace;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .ticket {
            max-width: 300px;
            width: 100%;
            background: white;
            border: 2px dashed #333;
            padding: 15px;
            text-align: center;
        }
        .ticket-logo {
            margin-bottom: 8px;
        }
        .ticket-logo img {
            height: 40px;
        }
        .ticket-company {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .ticket-subtitle {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
            border-bottom: 1px dashed #999;
            padding-bottom: 8px;
        }
        .ticket-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .queue-number {
            font-size: 64px;
            font-weight: bold;
            color: #000;
            margin: 10px 0;
            line-height: 1;
        }
        .queue-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 15px;
            border-bottom: 1px dashed #999;
            padding-bottom: 8px;
        }
        .info-section {
            text-align: left;
            margin: 10px 0;
            font-size: 11px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            border-bottom: 1px dotted #ddd;
        }
        .info-label {
            font-weight: bold;
        }
        .kendaraan-section {
            text-align: left;
            margin: 10px 0;
            border-top: 1px dashed #999;
            padding-top: 8px;
        }
        .kendaraan-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .kendaraan-item {
            font-size: 10px;
            padding: 2px 0 2px 10px;
        }
        .qr-section {
            margin: 12px 0;
            border-top: 1px dashed #999;
            padding-top: 8px;
        }
        .qr-section img {
            width: 80px;
            height: 80px;
        }
        .qr-label {
            font-size: 8px;
            color: #666;
            margin-top: 3px;
        }
        .estimation {
            margin: 8px 0;
            padding: 5px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        .footer-note {
            border-top: 1px dashed #999;
            padding-top: 8px;
            margin-top: 10px;
            font-size: 9px;
            color: #666;
        }
        .btn-group {
            margin-top: 15px;
        }
        .btn-group button, .btn-group a {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background: #28a745;
            color: white;
        }
        .btn-back {
            background: #6c757d;
            color: white;
        }
        @media print {
            body { background: white; padding: 0; }
            .btn-group { display: none !important; }
            .ticket { border: 1px solid #000; max-width: 80mm; }
            @page { size: 80mm auto; margin: 2mm; }
        }
    </style>
</head>
<body>
    <div>
        <div class="ticket">
            <div class="ticket-logo">
                <img src="<?= base_url('assets/img/logoqenza.jpeg') ?>" alt="Qenza">
            </div>
            <div class="ticket-company">QENZA</div>
            <div class="ticket-subtitle">Cucian Salju Sijunjung</div>

            <div class="ticket-title">Reservasi</div>
            <div class="queue-number" style="font-size: 18px; margin: 15px 0; word-break: break-all;"><?= $faktur['idreservasi'] ?></div>
            <div class="queue-label">NOMOR FAKTUR</div>

            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">ID Faktur:</span>
                    <span><?= $faktur['idreservasi'] ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pelanggan:</span>
                    <span><?= esc($faktur['nama_pelanggan']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal:</span>
                    <span><?= date('d/m/Y', strtotime($faktur['tgl'])) ?></span>
                </div>
            </div>

            <div class="kendaraan-section">
                <div class="kendaraan-title">Kendaraan:</div>
                <?php $grandTotal = 0; ?>
                <?php foreach ($kendaraan as $k): ?>
                    <?php $subTotal = 0; ?>
                    <div class="kendaraan-item">
                        <strong><?= esc($k['platnomor']) ?></strong>
                        <?php foreach ($k['paket_list'] as $p): ?>
                            <?php $subTotal += $p['harga']; ?>
                            <br>&nbsp;&nbsp;- <?= esc($p['namapaket']) ?> .. <?= number_format($p['harga'], 0, ',', '.') ?>
                        <?php endforeach; ?>
                        <br>&nbsp;&nbsp;<strong>Subtotal: Rp <?= number_format($subTotal, 0, ',', '.') ?></strong>
                    </div>
                    <?php $grandTotal += $subTotal; ?>
                <?php endforeach; ?>
                <div style="border-top: 1px dashed #999; margin-top: 8px; padding-top: 8px; text-align: right; font-weight: bold; font-size: 12px;">
                    TOTAL: Rp <?= number_format($grandTotal, 0, ',', '.') ?>
                </div>
            </div>

            <div class="qr-section">
                <img src="<?= $qrCodeImage ?>" alt="QR Code">
                <div class="qr-label">Scan untuk cek status kendaraan</div>
            </div>

            <div class="footer-note">
                <div><strong>Simpan tiket ini sebagai bukti</strong></div>
                <div>Terima kasih telah mempercayakan kendaraan Anda kepada kami!</div>
            </div>
        </div>

        <div class="btn-group" style="text-align: center;">
            <a href="<?= site_url('faktur') ?>" class="btn-back"><i class="ri-arrow-left-line"></i> Kembali</a>
            <button class="btn-print" onclick="window.print()"><i class="ri-printer-line"></i> Cetak Tiket</button>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        };
    </script>
</body>
</html>
