<?php if (empty($pencucian)): ?>
    <p class="text-muted text-center">Tidak ada data pencucian</p>
<?php else: ?>
    <?php
    $bulanNames = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $periodeText = '';
    if (!empty($tglmulai) && !empty($tglakhir)) {
        $periodeText = 'dari ' . date('d/m/Y', strtotime($tglmulai)) . ' sd/ ' . date('d/m/Y', strtotime($tglakhir));
    } elseif (!empty($bulan) && !empty($tahun)) {
        $periodeText = 'Periode: ' . ($bulanNames[(int)$bulan] ?? '') . ' ' . $tahun;
    } elseif (!empty($tahun)) {
        $periodeText = 'Periode: ' . $tahun;
    }
    ?>
    <?php if ($periodeText): ?>
        <div class="mb-2"><strong><?= $periodeText ?></strong></div>
    <?php endif; ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>ID Faktur</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Plat Nomor</th>
                <th>Paket</th>
                <th>Karyawan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pencucian as $p): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($p['idreservasi']) ?></td>
                <td><?= date('d/m/Y', strtotime($p['tglpencucian'])) ?></td>
                <td><?= esc($p['nama_pelanggan']) ?></td>
                <td><strong><?= esc($p['platnomor']) ?></strong></td>
                <td><?= esc($p['namapaket']) ?></td>
                <td><?= esc($p['nama_karyawan'] ?? '-') ?></td>
                <td class="text-center"><?= $p['status'] == 'dijemput' ? 'Bisa Di Jemput' : ucfirst($p['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <small class="text-muted">Total: <?= count($pencucian) ?> kendaraan</small>
<?php endif; ?>
