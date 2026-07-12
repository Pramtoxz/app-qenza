<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-body">
                <?= form_open('pencucian/save', ['id' => 'formtambahpencucian']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="idpencucian">ID Reservasi</label>
                            <input type="text" id="idpencucian" name="idpencucian" class="form-control" value="<?= $next_id ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpelanggan">Pelanggan</label>
                            <div class="input-group">
                                <input type="hidden" id="idpelanggan" name="idpelanggan" class="form-control" readonly>
                                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder="Pilih Pelanggan" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modalcariPelanggan">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idpelanggan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="platnomor">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" id="platnomor" name="platnomor" class="form-control" placeholder="Contoh: BA 1234 AA">
                            <div class="invalid-feedback error_platnomor"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="text" id="nohp" name="nohp" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpaket">Paket Cucian 1</label>
                            <div class="input-group">
                                <input type="hidden" id="idpaket" name="idpaket" class="form-control" readonly>
                                <input type="text" id="namapaket" name="namapaket" class="form-control" placeholder="Pilih Paket" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info btn-cari-paket" type="button" data-target="1">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idpaket"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="harga">Harga Paket 1</label>
                            <input type="text" id="harga" name="harga" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="jenis">Jenis Paket 1</label>
                            <input type="text" id="jenis" name="jenis" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpaket2">Paket Cucian 2 <small class="text-muted">(Opsional, harus sama jenis)</small></label>
                            <div class="input-group">
                                <input type="hidden" id="idpaket2" name="idpaket2" class="form-control" readonly>
                                <input type="text" id="namapaket2" name="namapaket2" class="form-control" placeholder="Pilih Paket 2 (Opsional)" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info btn-cari-paket" type="button" data-target="2">Cari</button>
                                    <button class="btn btn-danger" type="button" id="btnHapusPaket2" style="display: none;"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="invalid-feedback error_idpaket2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="harga2">Harga Paket 2</label>
                            <input type="text" id="harga2" name="harga2" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="jenis2">Jenis Paket 2</label>
                            <input type="text" id="jenis2" name="jenis2" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div id="detailPencucianPreview" style="display: none;">
                    <hr>
                    <div class="text-center mb-4">
                        <h4><i class="fas fa-eye mr-2"></i>Detail Reservasi</h4>
                        <p class="text-muted">Preview data sebelum disimpan</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="fas fa-user mr-1"></i> Detail Pelanggan</h6>
                                </div>
                                <div class="card-body p-2">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td width="40%"><strong>ID:</strong></td><td id="preview_idpelanggan">-</td></tr>
                                        <tr><td><strong>Nama:</strong></td><td id="preview_nama_pelanggan">-</td></tr>
                                        <tr><td><strong>Plat:</strong></td><td id="preview_platnomor">-</td></tr>
                                        <tr><td><strong>No HP:</strong></td><td id="preview_nohp">-</td></tr>
                                        <tr><td><strong>Alamat:</strong></td><td id="preview_alamat">-</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="fas fa-box mr-1"></i> Detail Paket</h6>
                                </div>
                                <div class="card-body p-2">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td width="40%"><strong>Paket 1:</strong></td><td id="preview_namapaket">-</td></tr>
                                        <tr><td><strong>Jenis:</strong></td><td id="preview_jenis">-</td></tr>
                                        <tr><td><strong>Harga 1:</strong></td><td id="preview_harga" class="font-weight-bold text-primary">-</td></tr>
                                        <tr id="preview_row_paket2" style="display: none;"><td><strong>Paket 2:</strong></td><td id="preview_namapaket2">-</td></tr>
                                        <tr id="preview_row_harga2" style="display: none;"><td><strong>Harga 2:</strong></td><td id="preview_harga2" class="font-weight-bold text-primary">-</td></tr>
                                        <tr><td><strong>Total:</strong></td><td id="preview_total_harga" class="font-weight-bold text-success">-</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="fas fa-info-circle mr-1"></i> Informasi Reservasi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4"><strong>ID Reservasi:</strong><br><span class="badge badge-info" id="preview_idpencucian"><?= $next_id ?></span></div>
                                        <div class="col-md-4"><strong>Tanggal:</strong><br><span id="preview_tanggal"><?= date('d F Y') ?></span></div>
                                        <div class="col-md-4"><strong>Status:</strong><br><span class="badge badge-secondary">Pending</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                        <i class="fas fa-save"></i> Simpan Reservasi
                    </button>
                    <button type="button" class="btn btn-warning btn-lg ml-2" id="btnResetForm">
                        <i class="fas fa-redo"></i> Reset Form
                    </button>
                    <a class="btn btn-secondary btn-lg ml-2" href="<?= base_url() ?>pencucian">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalcariPelanggan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalcariPaket" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPaketTitle">Pilih Paket</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<style>.table td { vertical-align: middle; }</style>
<script>
    $(function() {
        var paketTarget = 1;

        function formatRupiah(value) {
            if (!value) return '';
            const cleanValue = value.toString().replace(/[^0-9]/g, '');
            if (cleanValue === '') return '';
            const number = parseInt(cleanValue, 10);
            if (isNaN(number) || number === 0) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        function hitungTotalHarga() {
            var harga1 = parseInt($('#harga').val().toString().replace(/[^0-9]/g, '')) || 0;
            var harga2 = parseInt($('#harga2').val().toString().replace(/[^0-9]/g, '')) || 0;
            var total = harga1 + harga2;
            if (total > 0) {
                $('#preview_total_harga').text(formatRupiah(total));
            } else {
                $('#preview_total_harga').text('-');
            }
        }

        function checkCompleteData() {
            var idpelanggan = $('#idpelanggan').val();
            var idpaket = $('#idpaket').val();
            var platnomor = $('#platnomor').val();

            if (idpelanggan && idpaket && platnomor) {
                $('#detailPencucianPreview').slideDown('slow');
                var now = new Date();
                var tanggal = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                $('#preview_tanggal').text(tanggal);
                hitungTotalHarga();
                $('html, body').animate({ scrollTop: $("#detailPencucianPreview").offset().top - 100 }, 1000);
            } else {
                $('#detailPencucianPreview').slideUp('fast');
            }
        }

        function resetFormAndPreview() {
            $('#idpelanggan, #nama_pelanggan, #alamat, #nohp').val('');
            $('#platnomor').val('');
            $('#idpaket, #namapaket, #harga, #jenis').val('');
            $('#idpaket2, #namapaket2, #harga2, #jenis2').val('');
            $('#btnHapusPaket2').hide();
            $('#preview_idpelanggan, #preview_nama_pelanggan, #preview_alamat, #preview_nohp').text('-');
            $('#preview_platnomor').text('-');
            $('#preview_idpaket, #preview_namapaket, #preview_harga, #preview_jenis').text('-');
            $('#preview_namapaket2, #preview_harga2').text('-');
            $('#preview_row_paket2, #preview_row_harga2').hide();
            $('#preview_total_harga').text('-');
            $('#detailPencucianPreview').hide();
        }

        $('#platnomor').on('input', function() {
            checkCompleteData();
        });

        $('#formtambahpencucian').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idpencucian: $('#idpencucian').val(),
                    idpelanggan: $('#idpelanggan').val(),
                    platnomor: $('#platnomor').val(),
                    idpaket: $('#idpaket').val(),
                    idpaket2: $('#idpaket2').val()
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu').prop('disabled', true);
                },
                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan Reservasi').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;
                        if (err.error_idpelanggan) {
                            $('#nama_pelanggan').addClass('is-invalid');
                            $('.error_idpelanggan').html(err.error_idpelanggan);
                        } else {
                            $('#nama_pelanggan').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idpelanggan').html('');
                        }
                        if (err.error_platnomor) {
                            $('#platnomor').addClass('is-invalid');
                            $('.error_platnomor').html(err.error_platnomor);
                        } else {
                            $('#platnomor').removeClass('is-invalid').addClass('is-valid');
                            $('.error_platnomor').html('');
                        }
                        if (err.error_idpaket) {
                            $('#namapaket').addClass('is-invalid');
                            $('.error_idpaket').html(err.error_idpaket);
                        } else {
                            $('#namapaket').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idpaket').html('');
                        }
                        if (err.error_idpaket2) {
                            $('#namapaket2').addClass('is-invalid');
                            $('.error_idpaket2').html(err.error_idpaket2);
                        } else {
                            $('#namapaket2').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idpaket2').html('');
                        }
                    }
                    if (response.sukses) {
                        var idpencucian = response.idpencucian;
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 2000,
                            showConfirmButton: false,
                            allowOutsideClick: false
                        }).then(function() {
                            window.location.href = '<?= site_url('/pencucian/cetakAntrian/') ?>' + idpencucian;
                        });
                    }
                },
                error: function(e) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan: ' + e.responseText });
                }
            });
            return false;
        });

        $('#modalcariPelanggan').on('show.bs.modal', function() {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);
            $.get('<?= base_url() ?>/pencucian/getpelanggan', function(data) {
                $('#modalcariPelanggan .modal-body').html(data);
            });
        });

        $(document).on('click', '.btn-cari-paket', function() {
            paketTarget = $(this).data('target');
            $('#modalPaketTitle').text('Pilih Paket Cucian ' + paketTarget);
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $('#modalcariPaket .modal-body').html(loader);
            $('#modalcariPaket').modal('show');
            $.get('<?= base_url() ?>/pencucian/getpaket', function(data) {
                $('#modalcariPaket .modal-body').html(data);
            });
        });

        $(document).on('click', '.btn-pilihpelanggan', function() {
            $('#idpelanggan').val($(this).data('idpelanggan'));
            $('#nama_pelanggan').val($(this).data('nama_pelanggan'));
            $('#alamat').val($(this).data('alamat'));
            $('#nohp').val($(this).data('nohp'));
            $('#preview_idpelanggan').text($(this).data('idpelanggan'));
            $('#preview_nama_pelanggan').text($(this).data('nama_pelanggan'));
            $('#preview_alamat').text($(this).data('alamat'));
            $('#preview_nohp').text($(this).data('nohp'));
            $('#preview_platnomor').text($('#platnomor').val() || '-');
            $('#modalcariPelanggan').modal('hide');
            checkCompleteData();
        });

        $(document).on('click', '.btn-pilihpaket', function() {
            if (paketTarget === 2) {
                var jenis1 = $('#jenis').val();
                var jenis2 = $(this).data('jenis');
                if (jenis1 && jenis2 && jenis1 !== jenis2) {
                    Swal.fire('Peringatan', 'Jenis paket ke-2 harus sama dengan paket ke-1 (' + jenis1 + ')', 'warning');
                    return;
                }
                $('#idpaket2').val($(this).data('idpaket'));
                $('#namapaket2').val($(this).data('namapaket'));
                $('#harga2').val(formatRupiah($(this).data('harga')));
                $('#jenis2').val($(this).data('jenis'));
                $('#preview_namapaket2').text($(this).data('namapaket'));
                $('#preview_harga2').text(formatRupiah($(this).data('harga')));
                $('#preview_row_paket2, #preview_row_harga2').show();
                $('#btnHapusPaket2').show();
            } else {
                $('#idpaket').val($(this).data('idpaket'));
                $('#namapaket').val($(this).data('namapaket'));
                $('#harga').val(formatRupiah($(this).data('harga')));
                $('#jenis').val($(this).data('jenis'));
                $('#preview_idpaket').text($(this).data('idpaket'));
                $('#preview_namapaket').text($(this).data('namapaket'));
                $('#preview_harga').text(formatRupiah($(this).data('harga')));
                $('#preview_jenis').text($(this).data('jenis'));

                if ($('#idpaket2').val()) {
                    var jenisBaru = $(this).data('jenis');
                    var jenis2 = $('#jenis2').val();
                    if (jenisBaru !== jenis2) {
                        $('#idpaket2, #namapaket2, #harga2, #jenis2').val('');
                        $('#preview_namapaket2, #preview_harga2').text('-');
                        $('#preview_row_paket2, #preview_row_harga2').hide();
                        $('#btnHapusPaket2').hide();
                        Swal.fire('Info', 'Paket 2 direset karena jenis berbeda', 'info');
                    }
                }
            }
            $('#modalcariPaket').modal('hide');
            checkCompleteData();
        });

        $('#btnHapusPaket2').click(function() {
            $('#idpaket2, #namapaket2, #harga2, #jenis2').val('');
            $('#preview_namapaket2, #preview_harga2').text('-');
            $('#preview_row_paket2, #preview_row_harga2').hide();
            $(this).hide();
            hitungTotalHarga();
        });

        $('#btnResetForm').click(function() {
            Swal.fire({
                title: 'Reset Form?',
                text: "Semua data yang sudah diisi akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetFormAndPreview();
                    Swal.fire({ icon: 'success', title: 'Form direset!', timer: 1500, showConfirmButton: false });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
