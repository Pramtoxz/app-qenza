<?php if (empty($reservasi)): ?>
    <p class="text-muted text-center">Tidak ada data reservasi</p>
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
                <th>Jam Datang</th>
                <th>Pelanggan</th>
                <th>Plat Nomor</th>
                <th>Paket</th>
                <th>Karyawan</th>
                <th class="text-center">Status Cuci</th>
                <th class="text-center">Status Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($reservasi as $r): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($r['idreservasi']) ?></td>
                <td><?= date('d/m/Y', strtotime($r['tgl'])) ?></td>
                <td><?= $r['jamdatang'] ? date('H:i', strtotime($r['jamdatang'])) : '-' ?></td>
                <td><?= esc($r['nama_pelanggan']) ?></td>
                <td><strong><?= esc($r['platnomor']) ?></strong></td>
                <td><?= esc($r['namapaket'] ?? '-') ?></td>
                <td><?= esc($r['nama_karyawan'] ?? '-') ?></td>
                <td class="text-center">
                    <?php
                    $statusMap = [
                        'pending' => '<span class="badge bg-secondary">Pending</span>',
                        'diproses' => '<span class="badge bg-warning">Diproses</span>',
                        'dijemput' => '<span class="badge bg-info">Bisa Di Jemput</span>',
                        'selesai' => '<span class="badge bg-success">Selesai</span>',
                        'batal' => '<span class="badge bg-danger">Batal</span>',
                    ];
                    echo $statusMap[$r['status']] ?? $r['status'];
                    ?>
                </td>
                <td class="text-center">
                    <?php if (($r['status_bayar'] ?? 'belum') == 'lunas'): ?>
                        <span class="badge bg-success">Lunas</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <small class="text-muted">Total: <?= count($reservasi) ?> kendaraan</small>
<?php endif; ?>
