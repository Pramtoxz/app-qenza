<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
        <a href="<?= site_url('faktur') ?>" class="text-muted"><i class="ri-arrow-left-line me-1"></i> Kembali</a>
        <h4 class="mt-1 mb-0">Detail Reservasi</h4>
    </div>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-outline-primary btn-sm"><i class="ri-printer-line me-1"></i> Print</button>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-3">
          <div class="col-md-4">
            <small class="text-muted d-block">ID Faktur</small>
            <strong><?= $faktur['idreservasi'] ?></strong>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">Tanggal</small>
            <strong><?= date('d M Y', strtotime($faktur['tgl'])) ?></strong>
            <small class="text-muted d-block"><?= $faktur['jamdatang'] ?></small>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">Status Bayar</small>
                <?php if ($faktur['status_bayar'] == 'lunas'): ?>
                    <span class="badge bg-success fs-6">Lunas</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark fs-6">Belum Bayar</span>
                <?php endif; ?>
            </div>
        </div>
        <hr class="my-2">
        <div class="row g-3">
          <div class="col-md-5">
            <small class="text-muted d-block">Pelanggan</small>
            <strong><?= $faktur['nama_pelanggan'] ?></strong>
            <small class="text-muted d-block"><?= $faktur['alamat'] ?> · <?= $faktur['nohp'] ?></small>
          </div>
          <div class="col-md-4">
            <small class="text-muted d-block">Total</small>
            <strong class="text-primary fs-5">Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></strong>
          </div>
        </div>
    </div>
</div>

<h5 class="mb-3"><i class="ri-car-line me-2"></i>Kendaraan (<?= count($kendaraan) ?>)</h5>

<?php $grandTotal = 0; ?>
<?php foreach ($kendaraan as $i => $k): ?>
    <?php
    $kendaraanTotal = 0;
    foreach ($k['paket_list'] as $p) {
        $kendaraanTotal += $p['harga'];
    }
    $grandTotal += $kendaraanTotal;

    $statusClass = match($k['status']) {
        'pending' => 'secondary',
        'diproses' => 'warning',
        'dijemput' => 'info',
        'selesai' => 'success',
        'batal' => 'danger',
        default => 'secondary'
    };
    $statusLabel = match($k['status']) {
        'pending' => 'Pending',
        'diproses' => 'Diproses',
        'dijemput' => 'Dijemput',
        'selesai' => 'Selesai',
        'batal' => 'Batal',
        default => $k['status']
    };
    ?>
    <div class="card shadow-sm mb-3">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <div>
                <strong class="me-2"><?= $k['platnomor'] ?></strong>
                <span class="badge bg-<?= $statusClass ?>"><?= $statusLabel ?></span>
                <?php if ($k['nama_karyawan']): ?>
                    <span class="ms-2"><i class="ri-user-3-line me-1"></i><?= $k['nama_karyawan'] ?></span>
                <?php else: ?>
                    <span class="ms-2 text-muted"><i class="ri-user-3-line me-1"></i>Belum ditugaskan</span>
                <?php endif; ?>
            </div>
            <div class="no-print">
                <?php if ($k['status'] == 'pending'): ?>
                    <button type="button" class="btn btn-success btn-sm btn-assign-detail" data-idkendaraan="<?= $k['id'] ?>">
                        <i class="ri-user-add-line me-1"></i>Assign Karyawan
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm btn-batal-detail" data-idkendaraan="<?= $k['id'] ?>">
                        <i class="ri-close-circle-line me-1"></i>Batal
                    </button>
                <?php elseif ($k['status'] == 'diproses'): ?>
                    <button type="button" class="btn btn-info btn-sm btn-status-detail" data-idkendaraan="<?= $k['id'] ?>">
                        <i class="ri-check-double-line me-1"></i>Tandai Dijemput
                    </button>
                <?php elseif ($k['status'] == 'dijemput'): ?>
                    <span class="text-muted small"><i>Menunggu checkout</i></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body py-2">
            <table class="table table-sm mb-0">
                <thead>
                    <tr class="text-muted small">
                        <th>Paket</th>
                        <th>Jenis</th>
                        <th class="text-end">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($k['paket_list'] as $p): ?>
                        <tr>
                            <td><?= $p['namapaket'] ?></td>
                            <td><span class="badge bg-light text-dark"><?= $p['jenis'] ?></span></td>
                            <td class="text-end">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="fw-bold">
                        <td colspan="2">Subtotal</td>
                        <td class="text-end text-primary">Rp <?= number_format($kendaraanTotal, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php endforeach; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Grand Total</h5>
        <h4 class="mb-0 fw-bold text-primary">Rp <?= number_format($grandTotal, 0, ',', '.') ?></h4>
    </div>
</div>

<!-- Modal Assign Karyawan -->
<div class="modal fade" id="modalAssignKaryawan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white py-2">
                <h6 class="modal-title"><i class="ri-user-add-line me-2"></i>Pilih Karyawan</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="assign_idkendaraan">
                <div id="assign-karyawan-content"></div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Print-only Invoice (Thermal 80mm) -->
<div id="print-invoice" style="display: none;">
    <div style="font-family: 'Courier New', monospace; font-size: 11px; line-height: 1.4; max-width: 80mm; margin: 0 auto; padding: 5mm;">
        <div style="text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 8px;">
            <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo" style="height: 40px; margin-bottom: 5px;">
            <div style="font-weight: bold; font-size: 13px;">QENZA</div>
            <div style="font-size: 10px;">Cucian Salju Sijunjung</div>
        </div>
        <div style="text-align: center; margin-bottom: 8px;">
            <div style="font-weight: bold; font-size: 12px;">FAKTUR #<?= $faktur['idreservasi'] ?></div>
            <div style="font-size: 10px;"><?= date('d/m/Y', strtotime($faktur['tgl'])) ?></div>
        </div>
        <div style="border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 5px;">
            <div><strong>Pelanggan:</strong> <?= $faktur['nama_pelanggan'] ?></div>
            <div style="font-size: 10px;"><?= $faktur['alamat'] ?> | <?= $faktur['nohp'] ?></div>
        </div>
        <?php foreach ($kendaraan as $i => $k): ?>
            <?php $kt = 0; foreach ($k['paket_list'] as $p) { $kt += $p['harga']; } ?>
            <div style="border-bottom: 1px dotted #ccc; padding: 3px 0;">
                <div style="font-weight: bold;"><?= $k['platnomor'] ?></div>
                <?php foreach ($k['paket_list'] as $p): ?>
                    <div style="font-size: 10px; padding-left: 8px;"><?= $p['namapaket'] ?> .. <?= number_format($p['harga'], 0, ',', '.') ?></div>
                <?php endforeach; ?>
                <div style="text-align: right; font-weight: bold;">Rp <?= number_format($kt, 0, ',', '.') ?></div>
            </div>
        <?php endforeach; ?>
        <div style="border-top: 2px solid #000; padding-top: 5px; margin-top: 5px; text-align: right;">
            <div style="font-weight: bold; font-size: 13px;">TOTAL: Rp <?= number_format($grandTotal, 0, ',', '.') ?></div>
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <img src="<?= $qrCodeImage ?>" alt="QR" style="width: 60px; height: 60px;">
            <div style="font-size: 8px; margin-top: 3px;">Scan untuk cek status</div>
        </div>
        <div style="text-align: center; margin-top: 8px; font-size: 9px; border-top: 1px dashed #000; padding-top: 5px;">
            <div>Terima kasih atas kunjungan Anda</div>
            <div>Simpan faktur ini sebagai bukti</div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #print-invoice, #print-invoice * { visibility: visible; }
    #print-invoice { position: absolute; left: 0; top: 0; width: 100%; display: block !important; }
    @page { size: 80mm auto; margin: 2mm; }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).on('click', '.btn-assign-detail', function() {
        var idkendaraan = $(this).data('idkendaraan');
        $('#assign_idkendaraan').val(idkendaraan);
        $('#assign-karyawan-content').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
        $('#modalAssignKaryawan').modal('show');
        $.get('<?= site_url('faktur/getkaryawan') ?>', function(data) {
            $('#assign-karyawan-content').html(data);
        });
    });

    $(document).on('click', '.btn-pilihkaryawan', function() {
        var idkaryawan = $(this).data('idkaryawan');
        var namakaryawan = $(this).data('namakaryawan');
        var idkendaraan = $('#assign_idkendaraan').val();

        Swal.fire({
            title: 'Assign ' + namakaryawan + '?',
            text: 'Karyawan ini akan mulai mengerjakan kendaraan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Assign!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('faktur/assignKaryawan') ?>",
                    data: { id: idkendaraan, idkaryawan: idkaryawan },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            $('#modalAssignKaryawan').modal('hide');
                            Swal.fire('Berhasil!', response.sukses, 'success').then(() => location.reload());
                        } else if (response.error) {
                            Swal.fire('Gagal!', typeof response.error === 'object' ? Object.values(response.error).join(', ') : response.error, 'warning');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-status-detail', function() {
        var idkendaraan = $(this).data('idkendaraan');
        Swal.fire({
            title: 'Tandai Dijemput?',
            text: 'Kendaraan sudah selesai dicuci dan siap dijemput',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Dijemput!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('faktur/ubahstatus') ?>",
                    data: { id: idkendaraan },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success').then(() => location.reload());
                        } else if (response.error) {
                            Swal.fire('Gagal!', response.error, 'warning');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-batal-detail', function() {
        var idkendaraan = $(this).data('idkendaraan');
        Swal.fire({
            title: 'Batalkan kendaraan ini?',
            text: 'Status akan diubah menjadi Batal',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('faktur/ubahbatal') ?>",
                    data: { id: idkendaraan },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success').then(() => location.reload());
                        } else if (response.error) {
                            Swal.fire('Gagal!', response.error, 'warning');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>
