<?php if (empty($karyawan)): ?>
    <p class="text-muted text-center">Tidak ada data karyawan</p>
<?php else: ?>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center" style="width:40px">No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th class="text-center">No HP</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($karyawan as $k): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($k['idkaryawan']) ?></td>
                <td><?= esc($k['nama']) ?></td>
                <td><?= esc($k['alamat']) ?></td>
                <td class="text-center"><?= esc($k['nohp']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <small class="text-muted">Total: <?= count($karyawan) ?> karyawan</small>
<?php endif; ?>
