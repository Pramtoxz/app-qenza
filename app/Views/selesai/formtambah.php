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
                <label class="form-label small text-muted">Kendaraan (status: dijemput)</label>
                <div class="input-group">
                    <input type="hidden" id="id_detail_kendaraan" name="id_detail_kendaraan">
                    <input type="text" id="display_pencucian" class="form-control" placeholder="Pilih kendaraan..." readonly>
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalcariPencucian"><i class="ri-search-line me-1"></i> Cari</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detailCheckout" style="display: none;">
    <div class="card shadow-sm mb-3">
        <div class="card-header py-2"><strong>Detail Kendaraan</strong></div>
        <div class="card-body py-2">
            <div class="row">
                <div class="col-md-4">
                    <small class="text-muted d-block">Pelanggan</small>
                    <strong id="detail_nama_pelanggan">-</strong>
                    <small class="text-muted d-block" id="detail_platnomor">-</small>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Paket</small>
                    <strong id="detail_namapaket">-</strong>
                    <small class="text-muted d-block">Karyawan: <span id="detail_nama_karyawan">-</span></small>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Harga Paket</small>
                    <strong class="text-primary" id="detail_harga">-</strong>
                </div>
            </div>
        </div>
    </div>

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

<?= form_close() ?>

<!-- Modal Pilih Kendaraan -->
<div class="modal fade" id="modalcariPencucian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Pilih Kendaraan Siap Dijemput</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"></div>
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
    function formatRupiah(v) {
        if (!v) return 'Rp 0';
        return 'Rp ' + parseInt(v).toLocaleString('id-ID');
    }

    function hitungKembalian() {
        var bayar = parseInt($('#totalbayar').val()) || 0;
        var dibayar = parseInt($('#totaldibayar').val()) || 0;
        var kembali = dibayar - bayar;
        $('#display_kembalian').val(formatRupiah(kembali));
        if (kembali < 0) {
            $('#display_kembalian').css('color', '#dc3545');
        } else {
            $('#display_kembalian').css('color', '');
        }
    }

    $('#totaldibayar').on('input', hitungKembalian);

    $('#modalcariPencucian').on('show.bs.modal', function() {
        $(this).find('.modal-body').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
        $.get('<?= site_url('selesai/getpencuciandijemput') ?>', function(data) {
            $('#modalcariPencucian .modal-body').html(data);
        });
    });

    $(document).on('click', '.btn-pilihpencucian', function() {
        var btn = $(this);
        $('#id_detail_kendaraan').val(btn.data('id_detail_kendaraan'));
        $('#display_pencucian').val(btn.data('nama_pelanggan') + ' - ' + btn.data('platnomor'));
        $('#detail_nama_pelanggan').text(btn.data('nama_pelanggan'));
        $('#detail_platnomor').text(btn.data('platnomor'));
        $('#detail_namapaket').text(btn.data('namapaket'));
        $('#detail_harga').text(formatRupiah(btn.data('harga')));
        $('#detail_nama_karyawan').text(btn.data('nama_karyawan') || '-');
        $('#totalbayar').val(btn.data('harga'));
        hitungKembalian();
        $('#detailCheckout').slideDown();
        $('#modalcariPencucian').modal('hide');
    });

    $('#formtambahselesai').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {
                idselesai: $('#idselesai').val(),
                id_detail_kendaraan: $('#id_detail_kendaraan').val(),
                jamjemput: $('#jamjemput').val(),
                totalbayar: $('#totalbayar').val(),
                totaldibayar: $('#totaldibayar').val()
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
                        window.location.href = '<?= site_url('selesai/detail/') ?>' + r.idselesai;
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
