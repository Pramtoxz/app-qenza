<?php if (empty($gaji)): ?>
    <p class="text-muted text-center">Tidak ada data gaji karyawan</p>
<?php else: ?>
    <?php
    $totalUpahSemua = 0;
    foreach ($gaji as $g) { $totalUpahSemua += ($g['total_upah'] ?? 0); }
    $bulanNames = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    if (($filter_type ?? '') === 'tahun'):
    ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>Bulan</th>
                <th>Nama Karyawan</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($gaji as $g): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $bulanNames[(int)($g['bulan_num'] ?? 0)] ?? '-' ?></td>
                <td><?= esc($g['nama_karyawan']) ?></td>
                <td class="text-end">Rp <?= number_format($g['total_upah'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-success">
                <td colspan="3" class="text-end fw-bold">Total:</td>
                <td class="text-end fw-bold">Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <?php else: ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>Tanggal</th>
                <th>Nama Karyawan</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($gaji as $g): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= !empty($g['tgl']) ? date('d/m/Y', strtotime($g['tgl'])) : '-' ?></td>
                <td><?= esc($g['nama_karyawan']) ?></td>
                <td class="text-end">Rp <?= number_format($g['total_upah'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-success">
                <td colspan="3" class="text-end fw-bold">Total:</td>
                <td class="text-end fw-bold">Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
    <small class="text-muted"><?= count($gaji) ?> data | Total: Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></small>
<?php endif; ?>
