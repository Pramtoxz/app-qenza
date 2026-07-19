<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji - <?= $karyawan['nama'] ?></title>
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
        .total-box { border: 2px solid #28a745; border-radius: 5px; padding: 15px; margin-bottom: 20px; background: #d4edda; text-align: center; }
        .total-box h3 { margin: 0; color: #28a745; font-size: 14px; }
        .total-box .amount { font-size: 24px; font-weight: bold; color: #28a745; margin-top: 5px; }
        .footer { display: flex; gap: 20px; margin-top: 30px; }
        .footer-box { flex: 1; text-align: center; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        .signature-line { margin-top: 50px; border-top: 1px solid #333; padding-top: 5px; }
        @media print { body { padding: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="slip-container">
        <div class="header">
            <img src="<?= base_url('assets/img/logoqenza.jpeg') ?>" alt="Logo">
            <h1>GAJI KARYAWAN</h1>
            <h2>Qenza - Cucian Salju Sijunjung</h2>
        </div>

        <?php
            $bulanNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $tglmulaiFmt = date('d', strtotime($tglmulai)) . ' ' . $bulanNames[date('n', strtotime($tglmulai))-1] . ' ' . date('Y', strtotime($tglmulai));
            $tglakhirFmt = date('d', strtotime($tglakhir)) . ' ' . $bulanNames[date('n', strtotime($tglakhir))-1] . ' ' . date('Y', strtotime($tglakhir));
        ?>

        <div style="text-align: center; background: #000000; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            <strong>Periode: <?= $tglmulaiFmt ?> - <?= $tglakhirFmt ?></strong> &nbsp;|&nbsp;
            <strong>Jumlah Cucian: <?= count($pencucianList) ?></strong>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3>Data Karyawan</h3>
                <table>
                    <tr><td>ID Karyawan</td><td>: <?= $karyawan['idkaryawan'] ?></td></tr>
                    <tr><td>Nama</td><td>: <?= $karyawan['nama'] ?></td></tr>
                    <tr><td>Alamat</td><td>: <?= $karyawan['alamat'] ?? '-' ?></td></tr>
                    <tr><td>No HP</td><td>: <?= $karyawan['nohp'] ?? '-' ?></td></tr>
                </table>
            </div>
            <div class="info-box">
                <h3>Ringkasan</h3>
                <table>
                    <tr><td>Jumlah Cucian</td><td>: <?= count($pencucianList) ?> cucian</td></tr>
                    <tr><td>Total Upah</td><td>: Rp <?= number_format($totalUpah, 0, ',', '.') ?></td></tr>
                </table>
            </div>
        </div>

        <?php if (!empty($pencucianList)): ?>
        <h3 style="margin: 0 0 10px; font-size: 14px;">Detail Pencucian Selesai</h3>
        <table class="detail-table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 40px;">No</th>
                    <th>ID Kendaraan</th>
                    <th>Tanggal</th>
                    <th>Plat Nomor</th>
                    <th>Paket</th>
                    <th style="text-align: right;">Upah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pencucianList as $p): 
                    $upah = ($p['upah'] ?? 0);
                ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= $p['id'] ?></td>
                    <td><?= date('d/m/Y', strtotime($p['tgl'])) ?></td>
                    <td><?= $p['platnomor'] ?></td>
                    <td><?= $p['namapaket'] ?></td>
                    <td style="text-align: right;">Rp <?= number_format($upah, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Total Upah:</td>
                    <td style="text-align: right;">Rp <?= number_format($totalUpah, 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
        <div style="text-align: center; padding: 30px; background: #f8f9fa; border-radius: 5px; margin: 15px 0;">
            <p style="color: #666;">Tidak ada data pencucian selesai pada periode ini</p>
        </div>
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
                    <p style="margin: 0; font-size: 11px; font-weight: bold;"><?= $karyawan['nama'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" style="padding: 10px 30px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            Cetak Gaji Karyawan
        </button>
        <button onclick="window.close();" style="padding: 10px 30px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            Tutup
        </button>
    </div>
</body>
</html>
