<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Faktur</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Plat Kendaraan</th>
            <th class="text-center">Jumlah</th>
            <th class="no-short">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($pencucian as $p): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><strong><?= esc($p['idreservasi']) ?></strong></td>
            <td><?= date('d/m/Y', strtotime($p['tgl'])) ?></td>
            <td><?= esc($p['nama_pelanggan']) ?></td>
            <td><?= esc($p['plat_list']) ?></td>
            <td class="text-center"><?= $p['jumlah_kendaraan'] ?></td>
            <td>
                <button type="button" class="btn btn-primary btn-sm btn-pilihfaktur"
                    data-idreservasi="<?= esc($p['idreservasi']) ?>"
                    data-nama_pelanggan="<?= esc($p['nama_pelanggan']) ?>"
                    data-tgl="<?= $p['tgl'] ?>">
                    Pilih
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if (empty($pencucian)): ?>
    <p class="text-muted text-center py-3">Tidak ada kendaraan yang siap dijemput</p>
<?php endif; ?>
