<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji - <?= $gaji['idgaji'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .slip-container { max-width: 800px; margin: 0 auto; border: 2px solid #333; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header img { height: 60px; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header h2 { margin: 5px 0 0; font-size: 14px; color: #666; }
        .info-section { display: flex; gap: 20px; margin-bottom: 20px; }
        .info-box { flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px; }
        .info-box h3 { margin: 0 0 10px; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-box table { width: 100%; font-size: 12px; }
        .info-box table td { padding: 3px 0; }
        .info-box table td:first-child { width: 40%; font-weight: bold; }
        table.detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.detail-table th, table.detail-table td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
        table.detail-table th { background: #333; color: white; }
        table.detail-table tfoot td { font-weight: bold; background: #f8f9fa; }
        .payment-box { border: 2px solid #17a2b8; border-radius: 5px; padding: 15px; margin-bottom: 20px; }
        .payment-box h3 { margin: 0 0 15px; color: #17a2b8; text-align: center; font-size: 14px; }
        .payment-table { width: 100%; border-collapse: collapse; }
        .payment-table td { padding: 8px; }
        .payment-table td:first-child { width: 60%; text-align: right; font-weight: bold; }
        .payment-table td:last-child { text-align: right; font-weight: bold; }
        .total-row { border-top: 3px solid #28a745; background: #d4edda; }
        .total-row td { font-size: 16px; color: #28a745; padding: 12px 8px; }
        .footer { display: flex; gap: 20px; margin-top: 30px; }
        .footer-box { flex: 1; text-align: center; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        .signature-line { margin-top: 50px; border-top: 1px solid #333; padding-top: 5px; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .status-dibayar { background: #28a745; color: white; }
        .status-draft { background: #ffc107; color: #333; }
        @media print { body { padding: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="slip-container">
        <div class="header">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo">
            <h1>SLIP GAJI KARYAWAN</h1>
            <h2>Qenza - Cucian Salju Sijunjung</h2>
        </div>

        <div style="text-align: center; background: #007bff; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            <strong>ID Gaji: <?= $gaji['idgaji'] ?></strong> &nbsp;|&nbsp;
            <strong>Periode: <?= ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$gaji['bulan']-1] ?> <?= $gaji['tahun'] ?></strong> &nbsp;|&nbsp;
            <span class="status-badge <?= $gaji['status'] == 'dibayar' ? 'status-dibayar' : 'status-draft' ?>"><?= strtoupper($gaji['status']) ?></span>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3>Data Karyawan</h3>
                <table>
                    <tr><td>ID Karyawan</td><td>: <?= $gaji['idkaryawan'] ?></td></tr>
                    <tr><td>Nama</td><td>: <?= $gaji['nama_karyawan'] ?></td></tr>
                    <tr><td>Alamat</td><td>: <?= $gaji['alamat'] ?></td></tr>
                    <tr><td>No HP</td><td>: <?= $gaji['nohp'] ?></td></tr>
                </table>
            </div>
            <div class="info-box">
                <h3>Ringkasan</h3>
                <table>
                    <tr><td>Jumlah Cucian</td><td>: <?= $gaji['jumlah_cucian'] ?> cucian</td></tr>
                    <tr><td>Total Upah</td><td>: Rp <?= number_format($gaji['total_upah'], 0, ',', '.') ?></td></tr>
                    <tr><td>Bonus</td><td>: Rp <?= number_format($gaji['bonus'], 0, ',', '.') ?></td></tr>
                    <tr><td>Potongan</td><td>: Rp <?= number_format($gaji['potongan'], 0, ',', '.') ?></td></tr>
                </table>
            </div>
        </div>

        <?php if (!empty($pencucianList)): ?>
        <h3 style="margin: 0 0 10px; font-size: 14px;">Detail Pencucian Selesai</h3>
        <table class="detail-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pencucian</th>
                    <th>Tanggal</th>
                    <th>Plat Nomor</th>
                    <th>Paket</th>
                    <th>Upah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pencucianList as $p): 
                    $upah = ($p['upah1'] ?? 0) + ($p['upah2'] ?? 0);
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['idpencucian'] ?></td>
                    <td><?= date('d/m/Y', strtotime($p['tgl'])) ?></td>
                    <td><?= $p['platnomor'] ?></td>
                    <td><?= $p['namapaket'] ?><?= !empty($p['namapaket2']) ? ' + ' . $p['namapaket2'] : '' ?></td>
                    <td>Rp <?= number_format($upah, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Total Upah:</td>
                    <td>Rp <?= number_format($gaji['total_upah'], 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>

        <div class="payment-box">
            <h3>Perhitungan Gaji</h3>
            <table class="payment-table">
                <tr><td>Total Upah</td><td>Rp <?= number_format($gaji['total_upah'], 0, ',', '.') ?></td></tr>
                <tr><td>+ Bonus</td><td style="color: #28a745;">Rp <?= number_format($gaji['bonus'], 0, ',', '.') ?></td></tr>
                <tr><td>- Potongan</td><td style="color: #dc3545;">Rp <?= number_format($gaji['potongan'], 0, ',', '.') ?></td></tr>
                <tr class="total-row"><td>TOTAL BAYAR</td><td>Rp <?= number_format($gaji['total_bayar'], 0, ',', '.') ?></td></tr>
            </table>
        </div>

        <?php if ($gaji['tanggal_bayar']): ?>
        <p style="text-align: center; font-size: 12px; color: #666;">
            Dibayarkan pada: <strong><?= date('d F Y', strtotime($gaji['tanggal_bayar'])) ?></strong>
        </p>
        <?php endif; ?>

        <div class="footer">
            <div class="footer-box">
                <p style="margin: 0; font-size: 11px;">Dibuat oleh,</p>
                <div class="signature-line">
                    <p style="margin: 0; font-size: 11px; font-weight: bold;">Admin</p>
                </div>
            </div>
            <div class="footer-box">
                <p style="margin: 0; font-size: 11px;">Diterima oleh,</p>
                <div class="signature-line">
                    <p style="margin: 0; font-size: 11px; font-weight: bold;"><?= $gaji['nama_karyawan'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" style="padding: 10px 30px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            Print Slip Gaji
        </button>
        <a href="<?= site_url('gaji/detail/') . $gaji['idgaji'] ?>" style="padding: 10px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 14px;">
            Kembali
        </a>
    </div>
</body>
</html>
