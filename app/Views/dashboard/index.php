<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="<?= base_url('/admin') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= number_format($totalPelanggan) ?></h3>
                        <p>Total Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url('/pelanggan') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= number_format($pencucianHariIni) ?></h3>
                        <p>Pencucian Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-sparkles"></i>
                    </div>
                    <a href="<?= base_url('/pencucian') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= number_format($totalKaryawan) ?></h3>
                        <p>Total Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <a href="<?= base_url('/karyawan') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rp <?= number_format($pendapatanBulanIni, 0, ',', '.') ?></h3>
                        <p>Pendapatan Bulan Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="<?= base_url('laporan-transaksi/selesai') ?>" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Status Pencucian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm">Sedang Diproses</span>
                                    <span class="badge badge-warning"><?= $statusStats['diproses'] ?></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: <?= $totalPencucian > 0 ? ($statusStats['diproses'] / $totalPencucian * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm">Siap Dijemput</span>
                                    <span class="badge badge-info"><?= $statusStats['dijemput'] ?></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: <?= $totalPencucian > 0 ? ($statusStats['dijemput'] / $totalPencucian * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm">Selesai</span>
                                    <span class="badge badge-success"><?= $statusStats['selesai'] ?></span>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-clock mr-1"></i> Pencucian Terbaru</h3>
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
                                        <td><code><?= $item['idpencucian'] ?></code></td>
                                        <td><?= $item['nama_pelanggan'] ?></td>
                                        <td><?= $item['namapaket'] ?></td>
                                        <td><?= $item['nama_karyawan'] ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($item['tgl'] . ' ' . $item['jamdatang'])) ?></td>
                                        <td>
                                            <?php if ($item['status'] == 'diproses'): ?>
                                                <span class="badge badge-warning">Diproses</span>
                                            <?php elseif ($item['status'] == 'dijemput'): ?>
                                                <span class="badge badge-info">Siap Dijemput</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox text-muted" style="font-size:40px;opacity:.4"></i>
                            <p class="text-muted mt-2">Belum ada data pencucian</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
setTimeout(function() { location.reload(); }, 300000);
</script>
<?= $this->endSection() ?>
