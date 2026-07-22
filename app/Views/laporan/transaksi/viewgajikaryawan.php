<?php if (empty($gaji)): ?>
    <p class="text-muted text-center">Tidak ada data gaji karyawan</p>
<?php else: ?>
    <?php $totalUpahSemua = 0; ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>Nama Karyawan</th>
                <th class="text-center">Jumlah Cucian</th>
                <th class="text-end">Total Upah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($gaji as $g): ?>
            <?php $totalUpahSemua += ($g['total_upah'] ?? 0); ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($g['nama_karyawan']) ?></td>
                <td class="text-center"><?= $g['jumlah_cucian'] ?> kendaraan</td>
                <td class="text-end">Rp <?= number_format($g['total_upah'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-success">
                <td colspan="3" class="text-end fw-bold">Total Gaji:</td>
                <td class="text-end fw-bold">Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <small class="text-muted">Periode: <?= $bulan ?> / <?= $tahun ?> | Total: <?= count($gaji) ?> karyawan | Total Upah: Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></small>
<?php endif; ?>
