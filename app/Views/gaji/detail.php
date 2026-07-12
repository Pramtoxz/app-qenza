<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="invoice p-4">
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo" style="height: 80px;">
            </div>
            <h3 class="text-primary font-weight-bold mb-1">Detail Gaji Karyawan</h3>
            <h5 class="text-muted">Qenza - Cucian Salju Sijunjung</h5>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">ID Gaji #<?= $gaji['idgaji'] ?></span>
                            <div class="row mt-2">
                                <div class="col-6 text-white"><small>Karyawan:</small><br><strong><?= $gaji['nama_karyawan'] ?></strong></div>
                                <div class="col-6 text-white"><small>Periode:</small><br><strong><?= ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$gaji['bulan']-1] ?> <?= $gaji['tahun'] ?></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-primary card-outline shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-user-tie mr-2"></i>Info Karyawan</h5>
                </div>
                <div class="card-body">
                    <h5 class="text-primary"><?= $gaji['nama_karyawan'] ?></h5>
                    <p class="mb-1"><i class="fas fa-map-marker-alt mr-2 text-muted"></i><?= $gaji['alamat'] ?></p>
                    <p class="mb-0"><i class="fas fa-phone mr-2 text-muted"></i><?= $gaji['nohp'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success card-outline shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-calculator mr-2"></i>Ringkasan Gaji</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td width="50%">Jumlah Cucian:</td><td class="font-weight-bold"><?= $gaji['jumlah_cucian'] ?> cucian</td></tr>
                        <tr><td>Total Upah:</td><td class="font-weight-bold">Rp <?= number_format($gaji['total_upah'], 0, ',', '.') ?></td></tr>
                        <tr><td>Bonus:</td><td class="font-weight-bold text-success">+ Rp <?= number_format($gaji['bonus'], 0, ',', '.') ?></td></tr>
                        <tr><td>Potongan:</td><td class="font-weight-bold text-danger">- Rp <?= number_format($gaji['potongan'], 0, ',', '.') ?></td></tr>
                        <tr style="border-top: 2px solid #28a745;"><td class="h5">Total Bayar:</td><td class="font-weight-bold text-success h5">Rp <?= number_format($gaji['total_bayar'], 0, ',', '.') ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($pencucianList)): ?>
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-list mr-2"></i>Daftar Pencucian Selesai</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white">No</th>
                            <th class="text-white">ID Pencucian</th>
                            <th class="text-white">Tanggal</th>
                            <th class="text-white">Plat Nomor</th>
                            <th class="text-white">Paket</th>
                            <th class="text-white">Upah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; $totalUpah = 0; foreach ($pencucianList as $p): 
                            $upah = ($p['upah1'] ?? 0) + ($p['upah2'] ?? 0);
                            $totalUpah += $upah;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $p['idpencucian'] ?></td>
                            <td><?= date('d/m/Y', strtotime($p['tgl'])) ?></td>
                            <td><?= $p['platnomor'] ?></td>
                            <td>
                                <?= $p['namapaket'] ?>
                                <?= !empty($p['namapaket2']) ? ' + ' . $p['namapaket2'] : '' ?>
                            </td>
                            <td class="font-weight-bold text-success">Rp <?= number_format($upah, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="5" class="text-right font-weight-bold">Total Upah:</td>
                            <td class="font-weight-bold text-primary h5">Rp <?= number_format($totalUpah, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm no-print">
        <div class="card-body d-flex justify-content-between">
            <a href="<?= base_url() ?>/gaji" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <div>
                <a href="<?= site_url('gaji/slip/') . $gaji['idgaji'] ?>" class="btn btn-info btn-lg">
                    <i class="fas fa-print mr-2"></i>Cetak Slip Gaji
                </a>
                <a href="<?= site_url('gaji/formedit/') . $gaji['idgaji'] ?>" class="btn btn-warning btn-lg ml-2">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= $this->endSection() ?>
