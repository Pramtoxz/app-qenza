<?php if (empty($gaji)): ?>
    <p class="text-muted text-center">Tidak ada data gaji karyawan</p>
<?php else: ?>
    <?php
    $totalUpahSemua = 0;
    foreach ($gaji as $g) { $totalUpahSemua += ($g['total_upah'] ?? 0); }
    $bulanNames = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $bulanLabel = ($bulanNames[(int)$bulan] ?? $bulan) . ' ' . $tahun;
    ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $bulanLabel ?></td>
                <td class="text-end">Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="table-success">
                <td class="fw-bold">Total</td>
                <td class="text-end fw-bold">Rp <?= number_format($totalUpahSemua, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <small class="text-muted">Periode: <?= $bulanLabel ?> | <?= count($gaji) ?> karyawan</small>
<?php endif; ?>
