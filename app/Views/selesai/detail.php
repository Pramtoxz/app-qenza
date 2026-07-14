<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
        <a href="<?= site_url('selesai') ?>" class="text-muted"><i class="ri-arrow-left-line me-1"></i> Kembali</a>
        <h4 class="mt-1 mb-0">Detail Checkout</h4>
    </div>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-outline-primary btn-sm"><i class="ri-printer-line me-1"></i> Print Struk</button>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-md-3">
                <small class="text-muted d-block">ID Selesai</small>
                <strong><?= $selesai['idselesai'] ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">ID Faktur</small>
                <strong><?= $selesai['idreservasi'] ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Tanggal</small>
                <strong><?= date('d M Y', strtotime($selesai['tgl'])) ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Jam Datang → Jemput</small>
                <strong><?= $selesai['jamdatang'] ?? '-' ?> → <?= $selesai['jamjemput'] ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header py-2"><strong>Pelanggan & Kendaraan</strong></div>
    <div class="card-body py-2">
        <div class="row">
            <div class="col-md-4">
                <small class="text-muted d-block">Nama</small>
                <strong><?= $selesai['nama_pelanggan'] ?></strong>
                <small class="text-muted d-block"><?= $selesai['alamat'] ?> · <?= $selesai['nohp'] ?></small>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Plat Nomor</small>
                <strong><?= $selesai['platnomor'] ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Paket</small>
                <?php foreach ($paketList as $p): ?>
                    <span class="badge bg-info me-1"><?= $p['namapaket'] ?></span>
                <?php endforeach; ?>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">Karyawan</small>
                <strong><?= $selesai['nama_karyawan'] ?? '-' ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header py-2"><strong>Pembayaran</strong></div>
    <div class="card-body py-3">
        <table class="table table-sm mb-0">
            <tr>
                <td class="text-muted">Total Bayar</td>
                <td class="text-end fw-bold">Rp <?= number_format($selesai['totalbayar'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-muted">Uang Diterima</td>
                <td class="text-end fw-bold">Rp <?= number_format($selesai['totaldibayar'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php $kembalian = ($selesai['totaldibayar'] ?? 0) - $selesai['totalbayar']; ?>
            <tr class="table-<?= $kembalian >= 0 ? 'success' : 'danger' ?>">
                <td class="fw-bold">Kembalian</td>
                <td class="text-end fw-bold">Rp <?= number_format($kembalian, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>
</div>

<!-- RawBT Thermal Receipt (80mm) -->
<div id="print-invoice" style="display: none;">
    <div style="font-family: 'Courier New', monospace; font-size: 11px; line-height: 1.4; max-width: 80mm; margin: 0 auto; padding: 5mm;">
        <div style="text-align: center; margin-bottom: 8px; border-bottom: 1px dashed #000; padding-bottom: 6px;">
            <div style="font-weight: bold; font-size: 14px;">QENZA</div>
            <div style="font-size: 10px;">Cucian Salju Sijunjung</div>
        </div>

        <div style="text-align: center; margin-bottom: 8px; border-bottom: 1px dashed #000; padding-bottom: 6px;">
            <div style="font-weight: bold; font-size: 12px;">STRUK PEMBAYARAN</div>
            <div style="font-size: 10px;"><?= $selesai['idselesai'] ?></div>
        </div>

        <div style="margin-bottom: 6px; font-size: 10px;">
            <div>Tgl: <?= date('d/m/Y', strtotime($selesai['tgl'])) ?></div>
            <div>Jam: <?= $selesai['jamdatang'] ?? '-' ?> → <?= $selesai['jamjemput'] ?></div>
            <div>Pel: <?= $selesai['nama_pelanggan'] ?></div>
            <div>Plat: <?= $selesai['platnomor'] ?></div>
        </div>

        <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 4px 0; margin: 6px 0;">
            <?php foreach ($paketList as $p): ?>
                <div style="display: flex; justify-content: space-between;">
                    <span><?= $p['namapaket'] ?></span>
                    <span><?= number_format($p['harga'], 0, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 12px; margin: 6px 0;">
            <span>TOTAL</span>
            <span>Rp <?= number_format($totalHarga, 0, ',', '.') ?></span>
        </div>

        <div style="border-top: 1px dashed #000; padding-top: 4px; margin-top: 4px; font-size: 10px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Bayar</span>
                <span>Rp <?= number_format($selesai['totalbayar'], 0, ',', '.') ?></span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Diterima</span>
                <span>Rp <?= number_format($selesai['totaldibayar'] ?? 0, 0, ',', '.') ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; font-weight: bold; border-top: 1px dotted #999; padding-top: 3px; margin-top: 3px;">
                <span>Kembali</span>
                <span>Rp <?= number_format($kembalian, 0, ',', '.') ?></span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 10px; border-top: 1px dashed #000; padding-top: 6px; font-size: 9px;">
            <div>Terima kasih atas kunjungan Anda</div>
            <div>Kendaraan bersih, hati senang!</div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #print-invoice, #print-invoice * { visibility: visible; }
    #print-invoice { position: absolute; left: 0; top: 0; width: 100%; display: block !important; }
    @page { size: 80mm auto; margin: 2mm; }
}
</style>

<?= $this->endSection() ?>
