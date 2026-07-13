<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="invoice p-4">
    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo Pencucian Qenza" style="height: 80px;">
            </div>
            <h3 class="text-primary fw-bold mb-1">Faktur Pembayaran Pencucian Qenza</h3>
            <h5 class="text-muted">Cucian Salju Sijunjung</h5>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="p-4 rounded-3 text-white" style="background-color: #28a745;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">ID Selesai #<?= $selesai['idselesai'] ?> | Pencucian #<?= $selesai['idpencucian'] ?></h6>
                                <div class="row mt-2">
                                    <div class="col-4"><small>Tanggal Masuk:</small><br><strong><?= date('d F Y', strtotime($selesai['tgl'])) ?></strong></div>
                                    <div class="col-4"><small>Jam Datang:</small><br><strong><?= $selesai['jamdatang'] ?></strong></div>
                                    <div class="col-4"><small>Jam Jemput:</small><br><strong><?= $selesai['jamjemput'] ?></strong></div>
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
                    <h5 class="text-primary"><?= $selesai['nama_pelanggan'] ?></h5>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i><?= $selesai['alamat'] ?></p>
                    <p class="mb-1"><i class="fas fa-phone me-2 text-muted"></i><?= $selesai['nohp'] ?></p>
                    <p class="mb-0"><i class="fas fa-car me-2 text-muted"></i><?= $selesai['platnomor'] ?></p>
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
                    <h5 class="text-primary"><?= $selesai['namapaket'] ?></h5>
                    <p class="mb-1"><i class="fas fa-tag me-2 text-muted"></i>Jenis: <?= $selesai['jenis'] ?></p>
                    <h4 class="text-success fw-bold mt-3">
                        <i class="fas fa-money-bill-wave me-2"></i>Rp <?= number_format($selesai['harga'], 0, ',', '.') ?>
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
                    <h5 class="text-primary"><?= $selesai['nama_karyawan'] ?></h5>
                    <p class="mb-2">Status:</p>
                    <span class="badge bg-success-600"><i class="fas fa-check-double me-1"></i>Selesai - Kendaraan sudah dijemput</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-table me-2"></i>Ringkasan Pembayaran</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead style="background-color: #487FFF;">
                        <tr>
                            <th class="text-white">ID Selesai</th>
                            <th class="text-white">ID Pencucian</th>
                            <th class="text-white">Pelanggan</th>
                            <th class="text-white">Paket</th>
                            <th class="text-white">Karyawan</th>
                            <th class="text-white">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $selesai['idselesai'] ?></td>
                            <td><?= $selesai['idpencucian'] ?></td>
                            <td><?= $selesai['nama_pelanggan'] ?></td>
                            <td><?= $selesai['namapaket'] ?></td>
                            <td><?= $selesai['nama_karyawan'] ?></td>
                            <td class="fw-bold text-success">Rp <?= number_format($selesai['harga'], 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Pembayaran -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-calculator me-2"></i>Detail Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right fw-bold" style="width:50%">Total Bayar:</td>
                            <td class="fw-bold text-primary h5">Rp <?= number_format($selesai['totalbayar'], 0, ',', '.') ?></td>
                        </tr>
                        <?php if (isset($selesai['totaldibayar'])): ?>
                        <tr>
                            <td class="text-right fw-bold">Total Di Bayar:</td>
                            <td class="fw-bold text-success h5">Rp <?= number_format($selesai['totaldibayar'], 0, ',', '.') ?></td>
                        </tr>
                        <?php 
                        $kembalian = $selesai['totaldibayar'] - $selesai['totalbayar'];
                        $kembalianClass = $kembalian >= 0 ? 'success' : 'danger';
                        ?>
                        <tr class="bg-<?= $kembalianClass ?>">
                            <td class="text-right fw-bold text-white h5">Kembalian:</td>
                            <td class="fw-bold text-white h4">Rp <?= number_format($kembalian, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center pt-3">
                                <?php if ($kembalian >= 0): ?>
                                    <span class="badge bg-success-600 p-2" style="font-size: 14px;">
                                        <i class="fas fa-check-circle me-1"></i> Pembayaran Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-600 p-2" style="font-size: 14px;">
                                        <i class="fas fa-exclamation-circle me-1"></i> Pembayaran Kurang
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr class="bg-success">
                            <td class="text-right fw-bold text-white h5">Status:</td>
                            <td class="fw-bold text-white h4">LUNAS</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center pt-3">
                                <span class="badge bg-success-600 p-2" style="font-size: 14px;">
                                    <i class="fas fa-check-circle me-1"></i> Pembayaran Selesai
                                </span>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Thank You & Signature Section -->
    <div class="row mb-4">
        <!-- Thank You Section -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><i class="fas fa-heart me-2"></i>Terima Kasih</h5>
                </div>
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-3">Terima kasih atas kepercayaan Anda!</h5>
                    <p class="text-muted mb-4">Kendaraan Anda telah selesai dicuci dan sudah dapat dijemput.</p>
                    <span class="badge bg-success-600 p-2" style="font-size: 16px;">
                        <i class="fas fa-check-circle me-1"></i> LUNAS
                    </span>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
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
                    <h5 class="text-primary fw-bold mb-2">Pencucian Qenza</h5>
                    <p class="text-muted">Terima kasih dan sampai jumpa kembali!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card shadow-sm no-print">
        <div class="card-body d-flex justify-content-between">
            <a href="<?= base_url() ?>/selesai" class="btn btn-secondary btn-lg">
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
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 15px;">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo" style="height: 60px; margin-bottom: 10px;">
            <h1 style="margin: 0; color: #343a40; font-size: 18px; font-weight: bold;">Faktur Pembayaran Pencucian Qenza</h1>
            <h2 style="margin: 5px 0 0 0; color: #343a40; font-size: 14px;">Cucian Salju Sijunjung</h2>
        </div>
        
        <!-- ID & Date Info -->
        <div style="text-align: center; background: #28a745; color: white; border: 2px solid #28a745; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            <strong style="font-size: 16px;">ID Selesai #<?= $selesai['idselesai'] ?> | Pencucian #<?= $selesai['idpencucian'] ?></strong>
            <div style="margin-top: 8px; display: flex; justify-content: center; gap: 30px;">
                <span><strong>Tanggal:</strong> <?= date('d F Y', strtotime($selesai['tgl'])) ?></span>
                <span><strong>Jam Datang:</strong> <?= $selesai['jamdatang'] ?></span>
                <span><strong>Jam Jemput:</strong> <?= $selesai['jamjemput'] ?></span>
            </div>
        </div>
        
        <!-- Info Section -->
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <!-- Pelanggan -->
            <div style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px;">
                <h3 style="margin: 0 0 8px 0; color: #343a40; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Detail Pelanggan</h3>
                <div><strong><?= $selesai['nama_pelanggan'] ?></strong></div>
                <div style="margin-top: 5px; font-size: 11px; line-height: 1.3;">
                    <div><?= $selesai['alamat'] ?></div>
                    <div><?= $selesai['nohp'] ?></div>
                    <div><?= $selesai['platnomor'] ?></div>
                </div>
            </div>
            
            <!-- Paket -->
            <div style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px;">
                <h3 style="margin: 0 0 8px 0; color: #343a40; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Detail Paket</h3>
                <div><strong><?= $selesai['namapaket'] ?></strong></div>
                <div style="margin-top: 5px; font-size: 11px;">
                    <div>Jenis: <?= $selesai['jenis'] ?></div>
                    <div style="font-weight: bold; color: #28a745;">Rp <?= number_format($selesai['harga'], 0, ',', '.') ?></div>
                </div>
            </div>
            
            <!-- Karyawan -->
            <div style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px;">
                <h3 style="margin: 0 0 8px 0; color: #343a40; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Detail Karyawan</h3>
                <div><strong><?= $selesai['nama_karyawan'] ?></strong></div>
                <div style="margin-top: 5px; font-size: 11px;">
                    Status: 
                    <span style="background: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Selesai</span>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 10px 0; color: #343a40; font-size: 14px;">Ringkasan Pembayaran</h3>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr style="background: #343a40; color: white;">
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">ID Selesai</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">ID Pencucian</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Pelanggan</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Paket</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Karyawan</th>
                        <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $selesai['idselesai'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $selesai['idpencucian'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $selesai['nama_pelanggan'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $selesai['namapaket'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px;"><?= $selesai['nama_karyawan'] ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-size: 11px; font-weight: bold; color: #28a745;">Rp <?= number_format($selesai['harga'], 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Payment Details -->
        <div style="margin-bottom: 20px; border: 2px solid #17a2b8; border-radius: 5px; padding: 15px;">
            <h3 style="margin: 0 0 15px 0; color: #17a2b8; font-size: 14px; text-align: center;">Detail Pembayaran</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 12px;">Total Bayar:</td>
                    <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 12px; color: #007bff;">Rp <?= number_format($selesai['totalbayar'], 0, ',', '.') ?></td>
                </tr>
                <?php if (isset($selesai['totaldibayar'])): ?>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 12px;">Total Di Bayar:</td>
                    <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 12px; color: #28a745;">Rp <?= number_format($selesai['totaldibayar'], 0, ',', '.') ?></td>
                </tr>
                <?php 
                $kembalian = $selesai['totaldibayar'] - $selesai['totalbayar'];
                $kembalianColor = $kembalian >= 0 ? '#28a745' : '#dc3545';
                ?>
                <tr style="border-top: 2px solid #17a2b8; background: #f8f9fa;">
                    <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 14px; color: <?= $kembalianColor ?>;">Kembalian:</td>
                    <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 14px; color: <?= $kembalianColor ?>;">Rp <?= number_format($kembalian, 0, ',', '.') ?></td>
                </tr>
                <?php else: ?>
                <tr style="border-top: 2px solid #17a2b8; background: #f8f9fa;">
                    <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 14px; color: #28a745;">Status:</td>
                    <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 14px; color: #28a745;">LUNAS</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <!-- Footer -->
        <div style="display: flex; gap: 20px; margin-top: 30px;">
            <!-- Thank You -->
            <div style="flex: 1; text-align: center; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0; color: #28a745; font-size: 12px;">Terima Kasih</h4>
                <div style="margin-bottom: 8px; font-size: 11px; font-weight: bold;">Terima kasih atas kepercayaan Anda!</div>
                <div style="font-size: 10px; color: #666;">Kendaraan sudah dijemput</div>
                <div style="margin-top: 10px; background: #28a745; color: white; padding: 5px 10px; border-radius: 3px; font-size: 10px; font-weight: bold;">LUNAS</div>
            </div>
            
            <!-- Signature -->
            <div style="flex: 1; text-align: center; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h4 style="margin: 0 0 10px 0; color: #343a40; font-size: 12px;">Tanda Tangan</h4>
                <div style="margin-bottom: 8px; font-size: 10px;">Sijunjung, <?= date('d F Y') ?></div>
                <img src="<?= base_url() ?>/assets/img/acc.png" alt="TTD" style="width: 80px; margin: 10px 0;">
                <div style="font-weight: bold; color: #343a40; font-size: 11px;">Pencucian Qenza</div>
                <div style="font-size: 9px; color: #666;">Sampai jumpa kembali!</div>
            </div>
        </div>
        
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    
    #print-invoice, #print-invoice * {
        visibility: visible;
    }
    
    #print-invoice {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        display: block !important;
    }
    
    @page {
        size: A4;
        margin: 0.5cm;
    }
}
</style>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= $this->endSection() ?>
