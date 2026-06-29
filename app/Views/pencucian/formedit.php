<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header text-center">
                <h3 class="card-title" style="color: #007bff;">
                    <i class="fas fa-edit"></i> Edit Data Pencucian
                </h3>
            </div>
            <div class="card-body">
                <?= form_open('pencucian/updatedata/' . $pencucian['idpencucian'], ['id' => 'formeditpencucian']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="idpencucian">ID Pencucian</label>
                            <input type="text" id="idpencucian" name="idpencucian" class="form-control" value="<?= $pencucian['idpencucian'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpelanggan">Pelanggan</label>
                            <div class="input-group">
                                <input type="hidden" id="idpelanggan" name="idpelanggan" class="form-control" value="<?= $pencucian['idpelanggan'] ?>" readonly>
                                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="<?= $pencucian['nama_pelanggan'] ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modalcariPelanggan">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idpelanggan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="platnomor">Plat Nomor</label>
                            <input type="text" id="platnomor" name="platnomor" class="form-control" value="<?= isset($pencucian['platnomor']) ? $pencucian['platnomor'] : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="text" id="nohp" name="nohp" class="form-control" value="<?= isset($pencucian['nohp']) ? $pencucian['nohp'] : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" value="<?= isset($pencucian['alamat']) ? $pencucian['alamat'] : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpaket">Paket Cucian</label>
                            <div class="input-group">
                                <input type="hidden" id="idpaket" name="idpaket" class="form-control" value="<?= $pencucian['idpaket'] ?>" readonly>
                                <input type="text" id="namapaket" name="namapaket" class="form-control" value="<?= $pencucian['namapaket'] ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modalcariPaket">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idpaket"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="harga">Harga Paket</label>
                            <input type="text" id="harga" name="harga" class="form-control" value="<?= isset($pencucian['harga']) ? 'Rp. ' . number_format($pencucian['harga'], 0, ',', '.') : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="jenis">Jenis Paket</label>
                            <input type="text" id="jenis" name="jenis" class="form-control" value="<?= isset($pencucian['jenis']) ? $pencucian['jenis'] : '' ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                        <i class="fas fa-save"></i> Update Pencucian
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
                    <h5 class="modal-title">Pilih Paket Cucian</h5>
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
<script>
    $(function() {
        function formatRupiah(value) {
            if (!value) return '';
            const cleanValue = value.toString().replace(/[^0-9]/g, '');
            if (cleanValue === '') return '';
            const number = parseInt(cleanValue, 10);
            if (isNaN(number) || number === 0) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        $('#formeditpencucian').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idpencucian: $('#idpencucian').val(),
                    idpelanggan: $('#idpelanggan').val(),
                    idpaket: $('#idpaket').val()
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu').prop('disabled', true);
                },
                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Update Pencucian').prop('disabled', false);
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
                        if (err.error_idpaket) {
                            $('#namapaket').addClass('is-invalid');
                            $('.error_idpaket').html(err.error_idpaket);
                        } else {
                            $('#namapaket').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idpaket').html('');
                        }
                    }
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 2000,
                            showConfirmButton: false,
                            allowOutsideClick: false
                        }).then(function() {
                            window.location.href = '<?= site_url('/pencucian') ?>';
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

        $('#modalcariPaket').on('show.bs.modal', function() {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);
            $.get('<?= base_url() ?>/pencucian/getpaket', function(data) {
                $('#modalcariPaket .modal-body').html(data);
            });
        });

        $(document).on('click', '.btn-pilihpelanggan', function() {
            $('#idpelanggan').val($(this).data('idpelanggan'));
            $('#nama_pelanggan').val($(this).data('nama_pelanggan'));
            $('#alamat').val($(this).data('alamat'));
            $('#nohp').val($(this).data('nohp'));
            $('#platnomor').val($(this).data('platnomor'));
            $('#modalcariPelanggan').modal('hide');
        });

        $(document).on('click', '.btn-pilihpaket', function() {
            $('#idpaket').val($(this).data('idpaket'));
            $('#namapaket').val($(this).data('namapaket'));
            $('#harga').val(formatRupiah($(this).data('harga')));
            $('#jenis').val($(this).data('jenis'));
            $('#modalcariPaket').modal('hide');
        });
    });
</script>
<?= $this->endSection() ?>
