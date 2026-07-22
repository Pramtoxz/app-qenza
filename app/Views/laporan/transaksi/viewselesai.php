<?php if (empty($selesai)): ?>
    <p class="text-muted text-center">Tidak ada data transaksi selesai</p>
<?php else: ?>
    <?php
    $rekap = [];
    $totalSemua = 0;
    foreach ($selesai as $s) {
        $tgl = !empty($s['tglpencucian']) ? date('d/m/Y', strtotime($s['tglpencucian'])) : '-';
        if (!isset($rekap[$tgl])) $rekap[$tgl] = 0;
        $rekap[$tgl] += ($s['totalbayar'] ?? 0);
        $totalSemua += ($s['totalbayar'] ?? 0);
    }
    ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>Tanggal</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($rekap as $tgl => $total): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $tgl ?></td>
                <td class="text-end">Rp <?= number_format($total, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-success">
                <td colspan="2" class="text-end fw-bold">Total Pendapatan:</td>
                <td class="text-end fw-bold">Rp <?= number_format($totalSemua, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <small class="text-muted">Total: <?= count($selesai) ?> transaksi | Pendapatan: Rp <?= number_format($totalSemua, 0, ',', '.') ?></small>
<?php endif; ?>
