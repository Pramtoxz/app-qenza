<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row gy-4">
    <div class="col-xxl-3 col-sm-6">
        <div class="card h-100 radius-12">
            <div class="card-body p-24">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary-light text-sm fw-medium">Total Faktur</span>
                        <h6 class="mb-0 mt-8"><?= number_format($totalFaktur) ?></h6>
                    </div>
                    <div class="w-48-px h-48-px bg-info-600 rounded-circle d-flex justify-content-center align-items-center">
                        <iconify-icon icon="solar:document-text-outline" class="text-white text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card h-100 radius-12">
            <div class="card-body p-24">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary-light text-sm fw-medium">Kendaraan Hari Ini</span>
                        <h6 class="mb-0 mt-8"><?= number_format($pencucianHariIni) ?></h6>
                    </div>
                    <div class="w-48-px h-48-px bg-danger-600 rounded-circle d-flex justify-content-center align-items-center">
                        <iconify-icon icon="solar:hand-shake-outline" class="text-white text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card h-100 radius-12">
            <div class="card-body p-24">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary-light text-sm fw-medium">Total Pelanggan</span>
                        <h6 class="mb-0 mt-8"><?= number_format($totalPelanggan) ?></h6>
                    </div>
                    <div class="w-48-px h-48-px bg-success-600 rounded-circle d-flex justify-content-center align-items-center">
                        <iconify-icon icon="solar:users-group-two-rounded-outline" class="text-white text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card h-100 radius-12">
            <div class="card-body p-24">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary-light text-sm fw-medium">Pendapatan Bulan Ini</span>
                        <h6 class="mb-0 mt-8">Rp <?= number_format($pendapatanBulanIni, 0, ',', '.') ?></h6>
                    </div>
                    <div class="w-48-px h-48-px bg-warning-600 rounded-circle d-flex justify-content-center align-items-center">
                        <iconify-icon icon="solar:dollar-linear" class="text-white text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4 mt-4">
    <div class="col-12">
        <div class="card radius-12">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="ri-pie-chart-line me-2"></i> Status Pencucian</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">Menunggu (Pending)</span>
                            <span class="badge bg-secondary-600"><?= $statusStats['pending'] ?></span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-secondary" style="width: <?= $totalPencucian > 0 ? ($statusStats['pending'] / $totalPencucian * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">Sedang Diproses</span>
                            <span class="badge bg-warning-600"><?= $statusStats['diproses'] ?></span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: <?= $totalPencucian > 0 ? ($statusStats['diproses'] / $totalPencucian * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">Siap Dijemput</span>
                            <span class="badge bg-info-600"><?= $statusStats['dijemput'] ?></span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: <?= $totalPencucian > 0 ? ($statusStats['dijemput'] / $totalPencucian * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-sm">Selesai</span>
                            <span class="badge bg-success-600"><?= $statusStats['selesai'] ?></span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: <?= $totalPencucian > 0 ? ($statusStats['selesai'] / $totalPencucian * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4 mt-4">
    <div class="col-12">
        <div class="card radius-12">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="ri-time-line me-2"></i> Pencucian Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recentPencucian)): ?>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Paket</th>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentPencucian as $item): ?>
                            <tr>
                                <td><code><?= $item['idreservasi'] ?></code></td>
                                <td><?= $item['nama_pelanggan'] ?></td>
                                <td><span class="text-muted"><?= esc($item['platnomor']) ?></span> &mdash; <?= $item['namapaket'] ?></td>
                                <td><?= $item['nama_karyawan'] ?? '<span class="text-muted">-</span>' ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($item['tgl'] . ' ' . $item['jamdatang'])) ?></td>
                                <td>
                                    <?php if ($item['status'] == 'pending'): ?>
                                        <span class="badge bg-secondary-600">Pending</span>
                                    <?php elseif ($item['status'] == 'diproses'): ?>
                                        <span class="badge bg-warning-600">Diproses</span>
                                    <?php elseif ($item['status'] == 'dijemput'): ?>
                                        <span class="badge bg-info-600">Siap Dijemput</span>
                                    <?php elseif ($item['status'] == 'selesai'): ?>
                                        <span class="badge bg-success-600">Selesai</span>
                                    <?php elseif ($item['status'] == 'batal'): ?>
                                        <span class="badge bg-danger-600">Batal</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <iconify-icon icon="solar:inbox-outline" class="text-muted" style="font-size:40px;opacity:.4"></iconify-icon>
                    <p class="text-muted mt-2">Belum ada data pencucian</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
setTimeout(function() { location.reload(); }, 300000);
</script>
<?= $this->endSection() ?>
