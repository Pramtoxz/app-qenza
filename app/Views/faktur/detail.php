<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="invoice p-4">
    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo Qenza" style="height: 80px;">
            </div>
            <h3 class="text-primary fw-bold mb-1">Faktur Pencucian Qenza</h3>
            <h5 class="text-muted">Cucian Salju Sijunjung</h5>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="p-4 rounded-3 text-white" style="background-color: #487FFF;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-file-text-line fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">Faktur #<?= $faktur['idreservasi'] ?></h6>
                                <div class="row mt-2">
                                    <div class="col-6"><small>Tanggal:</small><br><strong><?= date('d F Y', strtotime($faktur['tgl'])) ?></strong></div>
                                    <div class="col-6"><small>Nomor Antrian:</small><br><strong><?= str_pad($faktur['nomor_antrian'], 2, '0', STR_PAD_LEFT) ?></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Pelanggan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="ri-user-line me-2"></i>Detail Pelanggan</h5>
                </div>
                <div class="card-body">
                    <h5 class="text-primary"><?= $faktur['nama_pelanggan'] ?></h5>
                    <p class="mb-1"><i class="ri-map-pin-line me-2 text-muted"></i><?= $faktur['alamat'] ?></p>
                    <p class="mb-0"><i class="ri-phone-line me-2 text-muted"></i><?= $faktur['nohp'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="ri-qr-code-line me-2"></i>QR Code Tracking</h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Scan untuk melacak status:</p>
                    <div class="border rounded p-3 d-inline-block bg-light">
                        <img src="<?= $qrCodeImage ?>" alt="QR Code" style="width: 120px; height: 120px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Kendaraan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="ri-car-line me-2"></i>Daftar Kendaraan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead style="background-color: #487FFF;">
                        <tr>
                            <th class="text-white">No</th>
                            <th class="text-white">Plat Nomor</th>
                            <th class="text-white">Paket</th>
                            <th class="text-white">Karyawan</th>
                            <th class="text-white">Status</th>
                            <th class="text-white text-end">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $grandTotal = 0; ?>
                        <?php foreach ($kendaraan as $i => $k): ?>
                            <?php
                            $kendaraanTotal = 0;
                            foreach ($k['paket_list'] as $p) {
                                $kendaraanTotal += $p['harga'];
                            }
                            $grandTotal += $kendaraanTotal;
                            ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $k['platnomor'] ?></td>
                                <td>
                                    <?php foreach ($k['paket_list'] as $p): ?>
                                        <span class="badge bg-info me-1"><?= $p['namapaket'] ?></span>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= $k['nama_karyawan'] ?? '<span class="text-muted"><i>Belum ditugaskan</i></span>' ?></td>
                                <td>
                                    <?php if ($k['status'] == 'pending'): ?>
                                        <span class="badge bg-secondary"><i class="ri-time-line me-1"></i>Pending</span>
                                    <?php elseif ($k['status'] == 'diproses'): ?>
                                        <span class="badge bg-warning"><i class="ri-loader-4-line me-1"></i>Diproses</span>
                                    <?php elseif ($k['status'] == 'dijemput'): ?>
                                        <span class="badge bg-info"><i class="ri-check-line me-1"></i>Dijemput</span>
                                    <?php elseif ($k['status'] == 'selesai'): ?>
                                        <span class="badge bg-success"><i class="ri-check-double-line me-1"></i>Selesai</span>
                                    <?php elseif ($k['status'] == 'batal'): ?>
                                        <span class="badge bg-danger"><i class="ri-close-line me-1"></i>Batal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-success text-end">Rp <?= number_format($kendaraanTotal, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Grand Total:</h5>
                <h4 class="text-primary fw-bold mb-0">Rp <?= number_format($grandTotal, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>

    <!-- Signature -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><i class="ri-edit-line me-2"></i>Tanda Tangan</h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Sijunjung, <?= date('d F Y') ?></p>
                    <div class="my-4">
                        <img src="<?= site_url('assets/img/acc.png') ?>" alt="Tanda Tangan" style="width: 120px;">
                    </div>
                    <h5 class="text-primary fw-bold">Qenza</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card shadow-sm no-print">
        <div class="card-body d-flex justify-content-between">
            <a href="<?= site_url('faktur') ?>" class="btn btn-secondary btn-lg">
                <i class="ri-arrow-left-line me-2"></i>Kembali
            </a>
            <a href="#" onclick="window.print();" class="btn btn-primary btn-lg">
                <i class="ri-printer-line me-2"></i>Print
            </a>
        </div>
    </div>
</div>

<!-- Print-only Invoice Layout (Thermal 80mm) -->
<div id="print-invoice" style="display: none;">
    <div style="font-family: 'Courier New', monospace; font-size: 11px; line-height: 1.4; max-width: 80mm; margin: 0 auto; padding: 5mm;">
        <div style="text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 8px;">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo" style="height: 40px; margin-bottom: 5px;">
            <div style="font-weight: bold; font-size: 13px;">QENZA</div>
            <div style="font-size: 10px;">Cucian Salju Sijunjung</div>
        </div>
        <div style="text-align: center; margin-bottom: 8px;">
            <div style="font-weight: bold; font-size: 12px;">FAKTUR #<?= $faktur['idreservasi'] ?></div>
            <div style="font-size: 10px;"><?= date('d/m/Y', strtotime($faktur['tgl'])) ?></div>
        </div>
        <div style="border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 5px;">
            <div><strong>Pelanggan:</strong> <?= $faktur['nama_pelanggan'] ?></div>
            <div style="font-size: 10px;"><?= $faktur['alamat'] ?> | <?= $faktur['nohp'] ?></div>
        </div>
        <?php foreach ($kendaraan as $i => $k): ?>
            <?php $kt = 0; foreach ($k['paket_list'] as $p) { $kt += $p['harga']; } ?>
            <div style="border-bottom: 1px dotted #ccc; padding: 3px 0;">
                <div style="font-weight: bold;"><?= $k['platnomor'] ?></div>
                <?php foreach ($k['paket_list'] as $p): ?>
                    <div style="font-size: 10px; padding-left: 8px;"><?= $p['namapaket'] ?> .. <?= number_format($p['harga'], 0, ',', '.') ?></div>
                <?php endforeach; ?>
                <div style="text-align: right; font-weight: bold;">Rp <?= number_format($kt, 0, ',', '.') ?></div>
            </div>
        <?php endforeach; ?>
        <div style="border-top: 2px solid #000; padding-top: 5px; margin-top: 5px; text-align: right;">
            <div style="font-weight: bold; font-size: 13px;">TOTAL: Rp <?= number_format($grandTotal, 0, ',', '.') ?></div>
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <img src="<?= $qrCodeImage ?>" alt="QR" style="width: 60px; height: 60px;">
            <div style="font-size: 8px; margin-top: 3px;">Scan untuk cek status</div>
        </div>
        <div style="text-align: center; margin-top: 8px; font-size: 9px; border-top: 1px dashed #000; padding-top: 5px;">
            <div>Terima kasih atas kunjungan Anda</div>
            <div>Simpan faktur ini sebagai bukti</div>
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
<?= $this->section('script') ?>
<?= $this->endSection() ?>
