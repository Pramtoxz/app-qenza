<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="invoice p-4">
    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo Qenza" style="height: 80px;">
            </div>
            <h3 class="text-primary fw-bold mb-1">Faktur Reservasi Qenza</h3>
            <h5 class="text-muted">Cucian Salju Sijunjung</h5>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="p-4 rounded-3 text-white" style="background-color: #487FFF;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <i class="fas fa-car fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">ID Reservasi #<?= $pencucian['idpencucian'] ?></h6>
                                <div class="row mt-2">
                                    <div class="col-6"><small>Tanggal:</small><br><strong><?= date('d F Y', strtotime($pencucian['tgl'])) ?></strong></div>
                                    <div class="col-6"><small>Jam Datang:</small><br><strong><?= $pencucian['jamdatang'] ?></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <!-- Detail Pelanggan -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-user me-2"></i>Detail Pelanggan</h5>
                </div>
                <div class="card-body">
                    <h5 class="text-primary"><?= $pencucian['nama_pelanggan'] ?></h5>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i><?= $pencucian['alamat'] ?></p>
                    <p class="mb-1"><i class="fas fa-phone me-2 text-muted"></i><?= $pencucian['nohp'] ?></p>
                    <p class="mb-0"><i class="fas fa-car me-2 text-muted"></i><?= $pencucian['platnomor'] ?></p>
                </div>
            </div>
        </div>

        <!-- Detail Paket -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-box me-2"></i>Detail Paket</h5>
                </div>
                <div class="card-body">
                    <h5 class="text-primary"><?= $pencucian['namapaket'] ?></h5>
                    <p class="mb-1"><i class="fas fa-tag me-2 text-muted"></i>Jenis: <?= $pencucian['jenis'] ?></p>
                    <p class="mb-1"><i class="fas fa-money-bill-wave me-2 text-muted"></i>Rp <?= number_format($pencucian['harga'], 0, ',', '.') ?></p>
                    <?php if (!empty($pencucian['namapaket2'])): ?>
                        <hr class="my-2">
                        <h5 class="text-primary"><?= $pencucian['namapaket2'] ?></h5>
                        <p class="mb-1"><i class="fas fa-tag me-2 text-muted"></i>Jenis: <?= $pencucian['jenis2'] ?></p>
                        <p class="mb-1"><i class="fas fa-money-bill-wave me-2 text-muted"></i>Rp <?= number_format($pencucian['harga2'], 0, ',', '.') ?></p>
                    <?php endif; ?>
                    <h4 class="text-success fw-bold mt-3">
                        <i class="fas fa-money-bill-wave me-2"></i>Rp <?= number_format($totalHarga, 0, ',', '.') ?>
                    </h4>
                </div>
            </div>
        </div>

        <!-- Detail Karyawan -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-user-tie me-2"></i>Detail Karyawan</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($pencucian['nama_karyawan'])): ?>
                        <h5 class="text-primary"><?= $pencucian['nama_karyawan'] ?></h5>
                    <?php else: ?>
                        <h5 class="text-muted"><i>Belum ditugaskan</i></h5>
                    <?php endif; ?>
                    <p class="mb-2">Status:</p>
                    <?php if ($pencucian['status'] == 'pending'): ?>
                        <span class="badge bg-secondary"><i class="fas fa-clock me-1"></i>Menunggu Proses</span>
                    <?php elseif ($pencucian['status'] == 'diproses'): ?>
                        <span class="badge bg-warning"><i class="fas fa-spinner me-1"></i>Sedang Diproses</span>
                    <?php elseif ($pencucian['status'] == 'dijemput'): ?>
                        <span class="badge bg-info"><i class="fas fa-check me-1"></i>Siap Dijemput</span>
                    <?php elseif ($pencucian['status'] == 'selesai'): ?>
                        <span class="badge bg-success"><i class="fas fa-check-double me-1"></i>Selesai</span>
                    <?php elseif ($pencucian['status'] == 'batal'): ?>
                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Batal</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-table me-2"></i>Ringkasan Reservasi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead style="background-color: #487FFF;">
                        <tr>
                            <th class="text-white">ID Reservasi</th>
                            <th class="text-white">Pelanggan</th>
                            <th class="text-white">Plat Nomor</th>
                            <th class="text-white">Paket</th>
                            <th class="text-white">Karyawan</th>
                            <th class="text-white">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $pencucian['idpencucian'] ?></td>
                            <td><?= $pencucian['nama_pelanggan'] ?></td>
                            <td><?= $pencucian['platnomor'] ?></td>
                            <td>
                                <?= $pencucian['namapaket'] ?>
                                <?php if (!empty($pencucian['namapaket2'])): ?>
                                    + <?= $pencucian['namapaket2'] ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $pencucian['nama_karyawan'] ?? '<span class="text-muted"><i>Belum ditugaskan</i></span>' ?></td>
                            <td class="fw-bold text-success">Rp <?= number_format($totalHarga, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Total Harga Paket:</h5>
                <h4 class="text-primary fw-bold mb-0">Rp <?= number_format($totalHarga, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>

    <!-- QR Code & Signature Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><i class="fas fa-qrcode me-2"></i>QR Code Tracking</h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Silakan scan kode QR berikut untuk melacak status cucian Anda:</p>
                    <div class="border rounded p-3 d-inline-block bg-light">
                        <img src="<?= $qrCodeImage ?>" alt="Kode QR" style="width: 120px; height: 120px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><i class="fas fa-signature me-2"></i>Tanda Tangan</h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Sijunjung, <?= date('d F Y') ?></p>
                    <div class="my-4">
                        <img src="<?= base_url() ?>/assets/img/acc.png" alt="Tanda Tangan" style="width: 120px;">
                    </div>
                    <h5 class="text-primary fw-bold">Qenza</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card shadow-sm no-print">
        <div class="card-body d-flex justify-content-between">
            <a href="<?= base_url() ?>/pencucian" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="#" onclick="window.print();" class="btn btn-primary btn-lg">
                <i class="fas fa-print me-2"></i>Print
            </a>
        </div>
    </div>
</div>

<!-- Print-only Invoice Layout -->
<div id="print-invoice" style="display: none;">
    <div style="font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; max-width: 21cm; margin: 0 auto; padding: 1cm;">
        <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 15px;">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo" style="height: 60px; margin-bottom: 10px;">
            <h1 style="margin: 0; color: #343a40; font-size: 18px; font-weight: bold;">Faktur Reservasi Qenza</h1>
            <h2 style="margin: 5px 0 0 0; color: #343a40; font-size: 14px;">Cucian Salju Sijunjung</h2>
        </div>
        <div style="text-align: center; background: #f8f9fa; border: 2px solid #343a40; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            <strong style="font-size: 16px; color: #343a40;">ID Reservasi #<?= $pencucian['idpencucian'] ?></strong>
            <div style="margin-top: 8px; display: flex; justify-content: center; gap: 30px;">
                <span><strong>Tanggal:</strong> <?= date('d F Y', strtotime($pencucian['tgl'])) ?></span>
                <span><strong>Jam Datang:</strong> <?= $pencucian['jamdatang'] ?></span>
            </div>
        </div>
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <div style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px;">
                <h3 style="margin: 0 0 8px 0; color: #343a40; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Detail Pelanggan</h3>
                <div><strong><?= $pencucian['nama_pelanggan'] ?></strong></div>
                <div style="margin-top: 5px; font-size: 11px; line-height: 1.3;">
                    <div><?= $pencucian['alamat'] ?></div>
                    <div><?= $pencucian['nohp'] ?></div>
                    <div><?= $pencucian['platnomor'] ?></div>
                </div>
            </div>
            <div style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px;">
                <h3 style="margin: 0 0 8px 0; color: #343a40; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Detail Paket</h3>
                <div><strong><?= $pencucian['namapaket'] ?></strong></div>
                <div style="margin-top: 5px; font-size: 11px;">
                    <div>Jenis: <?= $pencucian['jenis'] ?></div>
                    <div style="font-weight: bold; color: #28a745;">Rp <?= number_format($pencucian['harga'], 0, ',', '.') ?></div>
                </div>
                <?php if (!empty($pencucian['namapaket2'])): ?>
                    <hr style="margin: 5px 0;">
                    <div><strong><?= $pencucian['namapaket2'] ?></strong></div>
                    <div style="font-size: 11px;">Rp <?= number_format($pencucian['harga2'], 0, ',', '.') ?></div>
                <?php endif; ?>
            </div>
            <div style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px;">
                <h3 style="margin: 0 0 8px 0; color: #343a40; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Detail Karyawan</h3>
                <div><strong><?= $pencucian['nama_karyawan'] ?? 'Belum ditugaskan' ?></strong></div>
                <div style="margin-top: 5px; font-size: 11px;">
                    Status:
                    <?php if ($pencucian['status'] == 'pending'): ?>
                        <span style="background: #6c757d; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Menunggu</span>
                    <?php elseif ($pencucian['status'] == 'diproses'): ?>
                        <span style="background: #ffc107; color: #856404; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Diproses</span>
                    <?php elseif ($pencucian['status'] == 'dijemput'): ?>
                        <span style="background: #007bff; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Dijemput</span>
                    <?php elseif ($pencucian['status'] == 'selesai'): ?>
                        <span style="background: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Selesai</span>
                    <?php elseif ($pencucian['status'] == 'batal'): ?>
                        <span style="background: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Batal</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 10px 0; color: #343a40; font-size: 14px;">Ringkasan Reservasi</h3>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr style="background: #343a40; color: white;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">ID</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Pelanggan</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Plat</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Paket</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Karyawan</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $pencucian['idpencucian'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $pencucian['nama_pelanggan'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $pencucian['platnomor'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;">
                            <?= $pencucian['namapaket'] ?>
                            <?= !empty($pencucian['namapaket2']) ? ' + ' . $pencucian['namapaket2'] : '' ?>
                        </td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $pencucian['nama_karyawan'] ?? 'Belum ditugaskan' ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px; font-weight: bold; color: #28a745;">Rp <?= number_format($totalHarga, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: right; margin-top: 10px; padding: 8px; background: #f8f9fa; border: 1px solid #343a40; border-radius: 5px;">
                <strong style="font-size: 14px;">Total: <span style="color: #343a40;">Rp <?= number_format($totalHarga, 0, ',', '.') ?></span></strong>
            </div>
        </div>
        <div style="display: flex; gap: 20px; margin-top: 20px;">
            <div style="flex: 1; text-align: center; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0; color: #343a40; font-size: 12px;">QR Code Tracking</h4>
                <img src="<?= $qrCodeImage ?>" alt="QR Code" style="width: 80px; height: 80px;">
            </div>
            <div style="flex: 1; text-align: center; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0; color: #343a40; font-size: 12px;">Tanda Tangan</h4>
                <div style="margin-bottom: 8px; font-size: 10px;">Sijunjung, <?= date('d F Y') ?></div>
                <img src="<?= base_url() ?>/assets/img/acc.png" alt="TTD" style="width: 80px; margin: 10px 0;">
                <div style="font-weight: bold; color: #343a40; font-size: 11px;">Qenza</div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #print-invoice, #print-invoice * { visibility: visible; }
    #print-invoice { position: absolute; left: 0; top: 0; width: 100%; display: block !important; }
    @page { size: A4; margin: 0.5cm; }
}
</style>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= $this->endSection() ?>
