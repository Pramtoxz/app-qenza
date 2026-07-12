<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header text-center">
                <h3 class="card-title"><i class="fas fa-edit"></i> Edit Data Gaji</h3>
            </div>
            <div class="card-body">
                <?= form_open('gaji/updatedata/' . $gaji['idgaji'], ['id' => 'formeditgaji']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idgaji">ID Gaji</label>
                            <input type="text" id="idgaji" name="idgaji" class="form-control" value="<?= $gaji['idgaji'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Karyawan</label>
                            <input type="text" class="form-control" value="<?= $gaji['nama_karyawan'] ?> (<?= $gaji['idkaryawan'] ?>)" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Bulan</label>
                            <input type="text" class="form-control" value="<?= ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$gaji['bulan']-1] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" class="form-control" value="<?= $gaji['tahun'] ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Jumlah Cucian</label>
                            <input type="text" class="form-control" value="<?= $gaji['jumlah_cucian'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Total Upah</label>
                            <input type="text" class="form-control" value="Rp. <?= number_format($gaji['total_upah'], 0, ',', '.') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="bonus">Bonus</label>
                            <input type="number" id="bonus" name="bonus" class="form-control" value="<?= $gaji['bonus'] ?>" min="0">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="potongan">Potongan</label>
                            <input type="number" id="potongan" name="potongan" class="form-control" value="<?= $gaji['potongan'] ?>" min="0">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Total Bayar</label>
                            <input type="text" id="total_bayar_display" class="form-control font-weight-bold text-success" value="Rp. <?= number_format($gaji['total_bayar'], 0, ',', '.') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="tanggal_bayar">Tanggal Bayar</label>
                            <input type="date" id="tanggal_bayar" name="tanggal_bayar" class="form-control" value="<?= $gaji['tanggal_bayar'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="draft" <?= $gaji['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="dibayar" <?= $gaji['status'] == 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                        <i class="fas fa-save"></i> Update Gaji
                    </button>
                    <a class="btn btn-info btn-lg ml-2" href="<?= site_url('gaji/slip/') . $gaji['idgaji'] ?>">
                        <i class="fas fa-print"></i> Cetak Slip
                    </a>
                    <a class="btn btn-secondary btn-lg ml-2" href="<?= base_url() ?>gaji">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        function formatRupiah(value) {
            return 'Rp. ' + parseInt(value || 0).toLocaleString('id-ID');
        }

        function hitungTotalBayar() {
            var upah = <?= $gaji['total_upah'] ?>;
            var bonus = parseInt($('#bonus').val()) || 0;
            var potongan = parseInt($('#potongan').val()) || 0;
            var total = upah + bonus - potongan;
            $('#total_bayar_display').val(formatRupiah(total));
        }

        $('#bonus, #potongan').on('input', function() {
            hitungTotalBayar();
        });

        $('#formeditgaji').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idgaji: $('#idgaji').val(),
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
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Update Gaji').prop('disabled', false);
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = '<?= site_url('/gaji') ?>';
                        });
                    }
                },
                error: function(e) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan' });
                }
            });
            return false;
        });
    });
</script>
<?= $this->endSection() ?>
