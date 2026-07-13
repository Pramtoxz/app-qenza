<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Tambah Data Gaji</h3>
            </div>
            <div class="card-body">
                <?= form_open('gaji/save', ['id' => 'formtambahgaji']) ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="idgaji" class="form-label">ID Gaji</label>
                    <input type="text" id="idgaji" name="idgaji" class="form-control" value="<?= $next_id ?>" readonly>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                            <select id="bulan" name="bulan" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == date('n') ? 'selected' : '' ?>>
                                        <?= ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$i-1] ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback error_bulan"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" id="tahun" name="tahun" class="form-control" value="<?= date('Y') ?>" min="2020" max="2030">
                            <div class="invalid-feedback error_tahun"></div>
                        </div>
                    </div>
                </div>
                   <div class="mb-3">
                    <label for="idkaryawan" class="form-label">Karyawan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="hidden" id="idkaryawan" name="idkaryawan">
                        <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" placeholder="Pilih Karyawan" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modalcariKaryawan">Cari</button>
                        </div>
                        <div class="invalid-feedback error_idkaryawan"></div>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-info" id="btnHitungUpah">
                        <i class="fas fa-calculator"></i> Hitung Upah
                    </button>
                </div>

                <div id="hasilHitung" style="display: none;">
                    <hr>
                    <div class="mb-3">
                        <label for="jumlah_cucian" class="form-label">Jumlah Cucian Selesai</label>
                        <input type="number" id="jumlah_cucian" name="jumlah_cucian" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="total_upah" class="form-label">Total Upah</label>
                        <input type="hidden" id="total_upah_raw" name="total_upah" value="0">
                        <input type="text" id="total_upah" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="bonus" class="form-label">Bonus</label>
                        <input type="number" id="bonus" name="bonus" class="form-control" value="0" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="potongan" class="form-label">Potongan</label>
                        <input type="number" id="potongan" name="potongan" class="form-control" value="0" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="total_bayar_display" class="form-label">Total Bayar</label>
                        <input type="text" id="total_bayar_display" class="form-control fw-bold text-success" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                        <input type="date" id="tanggal_bayar" name="tanggal_bayar" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="draft">Draft</option>
                            <option value="dibayar">Dibayar</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan" style="display: none;">
                        <i class="fas fa-save"></i> Simpan Gaji
                    </button>
                    <a class="btn btn-secondary btn-lg ms-2" href="<?= base_url() ?>gaji">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalcariKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            if (!value) return 'Rp. 0';
            return 'Rp. ' + parseInt(value).toLocaleString('id-ID');
        }

        function hitungTotalBayar() {
            var upah = parseInt($('#total_upah_raw').val()) || 0;
            var bonus = parseInt($('#bonus').val()) || 0;
            var potongan = parseInt($('#potongan').val()) || 0;
            var total = upah + bonus - potongan;
            $('#total_bayar_display').val(formatRupiah(total));
        }

        $('#modalcariKaryawan').on('show.bs.modal', function() {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);
            $.get('<?= base_url() ?>/gaji/getkaryawan', function(data) {
                $('#modalcariKaryawan .modal-body').html(data);
            });
        });

        $(document).on('click', '.btn-pilihkaryawan-gaji', function() {
            $('#idkaryawan').val($(this).data('idkaryawan'));
            $('#nama_karyawan').val($(this).data('nama'));
            $('#modalcariKaryawan').modal('hide');
        });

        $('#btnHitungUpah').click(function() {
            var idkaryawan = $('#idkaryawan').val();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();

            if (!idkaryawan || !bulan || !tahun) {
                Swal.fire('Peringatan', 'Pilih karyawan, bulan, dan tahun terlebih dahulu', 'warning');
                return;
            }

            $(this).html('<i class="fas fa-spin fa-spinner"></i> Menghitung...').prop('disabled', true);

            $.ajax({
                type: "POST",
                url: "<?= site_url('gaji/hitungUpah') ?>",
                data: { idkaryawan: idkaryawan, bulan: bulan, tahun: tahun },
                dataType: 'json',
                success: function(response) {
                    $('#btnHitungUpah').html('<i class="fas fa-calculator"></i> Hitung Upah Otomatis').prop('disabled', false);

                    if (response.sukses) {
                        $('#jumlah_cucian').val(response.jumlah_cucian);
                        $('#total_upah').val(formatRupiah(response.total_upah));
                        $('#total_upah_raw').val(response.total_upah);
                        hitungTotalBayar();
                        $('#hasilHitung').slideDown('slow');
                        $('#tombolSimpan').show();
                    } else {
                        Swal.fire('Error', response.error, 'error');
                    }
                },
                error: function() {
                    $('#btnHitungUpah').html('<i class="fas fa-calculator"></i> Hitung Upah Otomatis').prop('disabled', false);
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        });

        $('#bonus, #potongan').on('input', function() {
            hitungTotalBayar();
        });

        $('#formtambahgaji').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idgaji: $('#idgaji').val(),
                    idkaryawan: $('#idkaryawan').val(),
                    bulan: $('#bulan').val(),
                    tahun: $('#tahun').val(),
                    jumlah_cucian: $('#jumlah_cucian').val(),
                    total_upah: $('#total_upah_raw').val(),
                    bonus: $('#bonus').val(),
                    potongan: $('#potongan').val(),
                    tanggal_bayar: $('#tanggal_bayar').val(),
                    status: $('#status').val()
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu').prop('disabled', true);
                },
                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan Gaji').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;
                        if (err.error_idkaryawan) {
                            $('#nama_karyawan').addClass('is-invalid');
                            $('.error_idkaryawan').html(err.error_idkaryawan);
                        }
                        if (err.error_bulan) {
                            $('#bulan').addClass('is-invalid');
                            $('.error_bulan').html(err.error_bulan);
                        }
                        if (err.error_tahun) {
                            $('#tahun').addClass('is-invalid');
                            $('.error_tahun').html(err.error_tahun);
                        }
                    }
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = '<?= site_url('/gaji/detail/') ?>' + response.idgaji;
                        });
                    }
                },
                error: function(e) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan: ' + e.responseText });
                }
            });
            return false;
        });
    });
</script>
<?= $this->endSection() ?>
