<?php if (empty($paket)): ?>
    <p class="text-muted text-center">Tidak ada data paket cucian</p>
<?php else: ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>ID</th>
                <th>Nama Paket</th>
                <th class="text-center">Jenis</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Upah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($paket as $p): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($p['idpaket']) ?></td>
                <td><?= esc($p['namapaket']) ?></td>
                <td class="text-center"><?= esc($p['jenis']) ?></td>
                <td class="text-end">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                <td class="text-end">Rp <?= number_format($p['upah'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <small class="text-muted">Total: <?= count($paket) ?> paket</small>
<?php endif; ?>
