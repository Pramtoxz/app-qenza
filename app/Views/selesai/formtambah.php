<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
        <a href="<?= site_url('selesai') ?>" class="text-muted"><i class="ri-arrow-left-line me-1"></i> Kembali</a>
        <h4 class="mt-1 mb-0">Checkout Kendaraan</h4>
    </div>
</div>

<?= form_open('selesai/save', ['id' => 'formtambahselesai']) ?>
<?= csrf_field() ?>

<div class="card shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">ID Selesai</label>
                <input type="text" id="idselesai" name="idselesai" class="form-control" value="<?= $next_id ?>" readonly>
            </div>
            <div class="col-md-8">
                <label class="form-label small text-muted">Faktur</label>
                <div class="input-group">
                    <input type="hidden" id="idreservasi_selected">
                    <input type="text" id="display_faktur" class="form-control" placeholder="Pilih faktur..." readonly>
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalcariFaktur"><i class="ri-search-line me-1"></i> Cari</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detailFaktur" style="display: none;">
    <div class="card shadow-sm mb-3">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <strong>Detail Faktur</strong>
            <span class="badge bg-info" id="badgeSisaBayar">Sisa Bayar: Rp 0</span>
        </div>
        <div class="card-body py-2">
            <div class="row mb-2">
                <div class="col-md-6">
                    <small class="text-muted d-block">Pelanggan</small>
                    <strong id="detail_nama_pelanggan">-</strong>
                </div>
            </div>
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th style="width:40px" class="text-center">✓</th>
                        <th>Plat Nomor</th>
                        <th>Paket</th>
                        <th>Karyawan</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Status Bayar</th>
                    </tr>
                </thead>
                <tbody id="kendaraanList"></tbody>
                <tfoot>
                    <tr class="table-light">
                        <td colspan="4" class="text-end fw-bold">Total yang harus dibayar:</td>
                        <td class="text-end fw-bold text-primary" id="totalHarusBayar">Rp 0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div id="checkoutForm">
        <div class="card shadow-sm mb-3">
            <div class="card-header py-2"><strong>Pembayaran</strong></div>
            <div class="card-body py-3">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Jam Jemput</label>
                        <input type="time" id="jamjemput" name="jamjemput" class="form-control" value="<?= date('H:i') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Total Bayar</label>
                        <input type="number" id="totalbayar" name="totalbayar" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Uang Diterima</label>
                        <input type="number" id="totaldibayar" name="totaldibayar" class="form-control" placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Kembalian</label>
                        <input type="text" id="display_kembalian" class="form-control" readonly value="Rp 0">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-success"><i class="ri-check-double-line me-1"></i> Selesaikan & Bayar</button>
        </div>
    </div>
</div>

<?= form_close() ?>

<!-- Modal Pilih Faktur -->
<div class="modal fade" id="modalcariFaktur" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Pilih Faktur</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalFakturContent"></div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    var kendaraanData = [];

    function formatRupiah(v) {
        if (!v) return 'Rp 0';
        return 'Rp ' + parseInt(v).toLocaleString('id-ID');
    }

    function hitungTotal() {
        var total = 0;
        kendaraanData.forEach(function(k) {
            if (k.status_bayar === 'belum') {
                var cb = $('#cb_' + k.id_detail_kendaraan);
                if (cb.is(':checked')) {
                    total += parseInt(k.harga) || 0;
                }
            }
        });
        $('#totalbayar').val(total);
        $('#totalHarusBayar').text(formatRupiah(total));
        hitungKembalian();
    }

    function hitungKembalian() {
        var bayar = parseInt($('#totalbayar').val()) || 0;
        var dibayar = parseInt($('#totaldibayar').val()) || 0;
        var kembali = dibayar - bayar;
        $('#display_kembalian').val(formatRupiah(kembali));
        $('#display_kembalian').css('color', kembali < 0 ? '#dc3545' : '');
    }

    $('#totaldibayar').on('input', hitungKembalian);

    $('#modalcariFaktur').on('show.bs.modal', function() {
        $('#modalFakturContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
        $.get('<?= site_url('selesai/viewgetpencuciandijemput') ?>', function(data) {
            $('#modalFakturContent').html(data);
        });
    });

    $(document).on('click', '.btn-pilihfaktur', function() {
        var btn = $(this);
        var idreservasi = btn.data('idreservasi');
        var namaPelanggan = btn.data('nama_pelanggan');

        $('#idreservasi_selected').val(idreservasi);
        $('#display_faktur').val(idreservasi + ' - ' + namaPelanggan);
        $('#detail_nama_pelanggan').text(namaPelanggan);
        $('#modalcariFaktur').modal('hide');

        $('#kendaraanList').html('<tr><td colspan="6" class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></td></tr>');
        $('#detailFaktur').slideDown();

        $.ajax({
            url: '<?= site_url('selesai/getkendaranbyfaktur') ?>',
            data: { idreservasi: idreservasi },
            dataType: 'json',
            success: function(r) {
                kendaraanData = r.kendaraan;
                $('#badgeSisaBayar').text('Sisa Bayar: ' + formatRupiah(r.total_belum_bayar));

                var html = '';
                kendaraanData.forEach(function(k) {
                    var isLunas = k.status_bayar === 'lunas';
                    html += '<tr>' +
                        '<td class="text-center">' +
                            (isLunas
                                ? '<i class="ri-check-double-line text-success"></i>'
                                : '<input type="checkbox" class="form-check-input cb-kendaraan" id="cb_' + k.id_detail_kendaraan + '" data-id="' + k.id_detail_kendaraan + '" checked>')
                        + '</td>' +
                        '<td><strong>' + k.platnomor + '</strong></td>' +
                        '<td>' + (k.namapaket || '-') + '</td>' +
                        '<td>' + (k.nama_karyawan || '-') + '</td>' +
                        '<td class="text-end">' + formatRupiah(k.harga) + '</td>' +
                        '<td class="text-center">' +
                            (isLunas
                                ? '<span class="badge bg-success">Lunas (Bayar Di Muka)</span>'
                                : '<span class="badge bg-warning text-dark">Belum Bayar</span>')
                        + '</td>' +
                        '</tr>';
                });
                $('#kendaraanList').html(html);
                hitungTotal();
            }
        });
    });

    $(document).on('change', '.cb-kendaraan', function() {
        hitungTotal();
    });

    $('#formtambahselesai').submit(function(e) {
        e.preventDefault();

        var selectedIds = [];
        $('.cb-kendaraan:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length === 0) {
            Swal.fire('Perhatian', 'Pilih minimal 1 kendaraan yang akan di-checkout', 'warning');
            return;
        }

        var totalbayar = parseInt($('#totalbayar').val()) || 0;
        var totaldibayar = parseInt($('#totaldibayar').val()) || 0;

        if (totalbayar > 0 && totaldibayar < totalbayar) {
            Swal.fire('Perhatian', 'Uang diterima kurang dari total bayar', 'warning');
            return;
        }

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {
                idselesai: $('#idselesai').val(),
                id_kendaraan_list: selectedIds,
                jamjemput: $('#jamjemput').val(),
                totalbayar: totalbayar,
                totaldibayar: totaldibayar
            },
            dataType: "json",
            success: function(r) {
                if (r.error) {
                    var msgs = typeof r.error === 'object' ? Object.values(r.error).join(', ') : r.error;
                    Swal.fire('Gagal!', msgs, 'warning');
                    return;
                }
                if (r.sukses) {
                    Swal.fire('Berhasil!', r.sukses, 'success').then(function() {
                        window.location.href = '<?= site_url('selesai') ?>';
                    });
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
