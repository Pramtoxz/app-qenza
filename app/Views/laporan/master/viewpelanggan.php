<?php if (empty($pelanggan)): ?>
    <p class="text-muted text-center">Tidak ada data pelanggan</p>
<?php else: ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th class="text-center">No HP</th>
                <th class="text-center" style="width:100px">JK</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pelanggan as $p): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($p['nama']) ?></td>
                <td><?= esc($p['alamat']) ?></td>
                <td class="text-center"><?= esc($p['nohp']) ?></td>
                <td class="text-center"><?= $p['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <small class="text-muted">Total: <?= count($pelanggan) ?> pelanggan</small>
<?php endif; ?>
