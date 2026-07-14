<?php if (empty($selesai)): ?>
    <p class="text-muted text-center">Tidak ada data transaksi selesai</p>
<?php else: ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>ID Selesai</th>
                <th>ID Faktur</th>
                <th>Pelanggan</th>
                <th>Plat Nomor</th>
                <th class="text-end">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($selesai as $s): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($s['idselesai']) ?></td>
                <td><?= esc($s['idreservasi']) ?></td>
                <td><?= esc($s['nama_pelanggan']) ?></td>
                <td><strong><?= esc($s['platnomor']) ?></strong></td>
                <td class="text-end">Rp <?= number_format($s['totalbayar'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <small class="text-muted">Total: <?= count($selesai) ?> transaksi</small>
<?php endif; ?>
