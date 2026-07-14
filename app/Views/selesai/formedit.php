<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Kendaraan Selesai</h3>
            </div>
            <div class="card-body">
                <?= form_open('selesai/updatedata/' . $selesai['idselesai'], ['id' => 'formeditselesai']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="idselesai" class="form-label">ID Selesai</label>
                            <input type="text" id="idselesai" name="idselesai" class="form-control" value="<?= $selesai['idselesai'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label for="idreservasi" class="form-label">ID Faktur</label>
                            <div class="input-group">
                                <input type="text" id="idreservasi" name="idreservasi" class="form-control" value="<?= $selesai['idreservasi'] ?> - <?= $selesai['nama_pelanggan'] ?> (<?= $selesai['platnomor'] ?>)" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" disabled>Tidak dapat diubah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Kendaraan yang Dipilih -->
                <div id="detailPencucianTerpilih" class="mb-4">
                    <hr class="my-4" style="border-top: 3px solid #007bff;">
                    <div class="text-center mb-4">
                        <h4 style="color: #007bff;">
                            <i class="fas fa-info-circle fa-lg"></i> 
                            <span class="ms-2">Detail Kendaraan Terpilih</span>
                        </h4>
                        <p class="text-muted">Data kendaraan yang akan diselesaikan</p>
                    </div>
                    
                    <div class="row">
                        <!-- Detail Pelanggan -->
                        <div class="col-md-4">
                            <div class="card" style="border-color: #007bff;">
                                <div class="card-header text-white" style="background-color: #007bff;">
                                    <h6 class="mb-0"><i class="fas fa-user"></i> Detail Pelanggan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Nama:</strong></td>
                                            <td id="detail_nama_pelanggan"><?= $selesai['nama_pelanggan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Plat Nomor:</strong></td>
                                            <td id="detail_platnomor"><?= $selesai['platnomor'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detail Paket -->
                        <div class="col-md-4">
                            <div class="card" style="border-color: #007bff;">
                                <div class="card-header text-white" style="background-color: #007bff;">
                                    <h6 class="mb-0"><i class="fas fa-box"></i> Detail Paket</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Paket:</strong></td>
                                            <td id="detail_namapaket"><?= $paketDisplay ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Harga:</strong></td>
                                            <td id="detail_harga" class="fw-bold" style="color: #007bff;">Rp. <?= number_format($totalHarga, 0, ',', '.') ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detail Waktu -->
                        <div class="col-md-4">
                            <div class="card" style="border-color: #007bff;">
                                <div class="card-header text-white" style="background-color: #007bff;">
                                    <h6 class="mb-0"><i class="fas fa-clock"></i> Detail Waktu</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Tanggal:</strong></td>
                                            <td id="detail_tgl"><?= date('d F Y', strtotime($selesai['tgl'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Karyawan:</strong></td>
                                            <td id="detail_nama_karyawan"><?= $selesai['nama_karyawan'] ?? '-' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input untuk Penyelesaian -->
                <div id="formPenyelesaian">
                    <hr class="my-4" style="border-top: 2px solid #28a745;">
                    <div class="text-center mb-4">
                        <h4 style="color: #28a745;">
                            <i class="fas fa-clipboard-check fa-lg"></i> 
                            <span class="ms-2">Data Penyelesaian</span>
                        </h4>
                        <p class="text-muted">Masukkan detail penyelesaian kendaraan</p>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="jamjemput" class="form-label">Jam Jemput</label>
                                <input type="time" id="jamjemput" name="jamjemput" class="form-control" value="<?= $selesai['jamjemput'] ?>">
                                <div class="invalid-feedback error_jamjemput"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="totalbayar" class="form-label">Total Bayar</label>
                                <input type="number" id="totalbayar" name="totalbayar" class="form-control" value="<?= $selesai['totalbayar'] ?>" readonly>
                                <div class="invalid-feedback error_totalbayar"></div>
                                <small class="form-text text-muted">Harga paket: <span id="harga_paket_display">Rp. <?= number_format($totalHarga, 0, ',', '.') ?></span></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="totaldibayar" class="form-label">Total Di Bayar</label>
                                <input type="number" id="totaldibayar" name="totaldibayar" class="form-control" value="<?= isset($selesai['totaldibayar']) ? $selesai['totaldibayar'] : '' ?>" placeholder="Uang yang diberikan pelanggan">
                                <div class="invalid-feedback error_totaldibayar"></div>
                                <small class="form-text text-muted">Masukkan jumlah uang pelanggan</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Perhitungan Kembalian -->
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-6">
                            <div class="card" style="border-color: #17a2b8; background-color: #f8f9fa;">
                                <div class="card-header text-white" style="background-color: #17a2b8;">
                                    <h6 class="mb-0"><i class="fas fa-calculator"></i> Perhitungan Kasir</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td width="50%"><strong>Total Bayar:</strong></td>
                                            <td id="display_total_bayar" class="text-right fw-bold">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Di Bayar:</strong></td>
                                            <td id="display_total_dibayar" class="text-right fw-bold">Rp 0</td>
                                        </tr>
                                        <tr style="border-top: 2px solid #17a2b8;">
                                            <td><strong>Kembalian:</strong></td>
                                            <td id="display_kembalian" class="text-right fw-bold" style="font-size: 1.2em; color: #28a745;">Rp 0</td>
                                        </tr>
                                    </table>
                                    <div id="status_pembayaran" class="mt-2 text-center">
                                        <span class="badge bg-secondary-600">Belum ada pembayaran</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                        <i class="fas fa-save"></i> Update Data Selesai
                    </button>
                    <a class="btn btn-secondary btn-lg ms-2" href="<?= site_url('selesai') ?>">
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
<style>
    .card {
        transition: all 0.3s ease;
        border-radius: 10px;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .table td {
        padding: 0.5rem 0.25rem;
        vertical-align: middle;
    }
    
    .table strong {
        color: #495057;
    }
    
    #detailPencucianTerpilih {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(111,66,193,0.1);
    }
    
    #formPenyelesaian {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(40,167,69,0.1);
    }
</style>
<script>
    $(function() {
        function formatRupiah(value) {
            if (!value || value === '') return '';
            const cleanValue = value.toString().replace(/[^0-9]/g, '');
            if (cleanValue === '') return '';
            const number = parseInt(cleanValue, 10);
            if (isNaN(number) || number === 0) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        function hitungKembalian() {
            var totalBayar = parseInt($('#totalbayar').val()) || 0;
            var totalDiBayar = parseInt($('#totaldibayar').val()) || 0;
            var kembalian = totalDiBayar - totalBayar;
            
            $('#display_total_bayar').text(formatRupiah(totalBayar));
            $('#display_total_dibayar').text(formatRupiah(totalDiBayar));
            $('#display_kembalian').text(formatRupiah(kembalian));
            
            var statusBadge = $('#status_pembayaran');
            if (totalBayar === 0) {
                statusBadge.html('<span class="badge bg-secondary-600">Belum ada pembayaran</span>');
            } else if (totalDiBayar === 0) {
                statusBadge.html('<span class="badge bg-warning-600">Menunggu pembayaran</span>');
            } else if (kembalian < 0) {
                statusBadge.html('<span class="badge bg-danger-600">Pembayaran kurang Rp ' + formatRupiah(Math.abs(kembalian)).replace('Rp. ', '') + '</span>');
                $('#display_kembalian').css('color', '#dc3545');
            } else if (kembalian === 0) {
                statusBadge.html('<span class="badge bg-success-600">Pembayaran pas</span>');
                $('#display_kembalian').css('color', '#28a745');
            } else {
                statusBadge.html('<span class="badge bg-info-600">Kembalian Rp ' + formatRupiah(kembalian).replace('Rp. ', '') + '</span>');
                $('#display_kembalian').css('color', '#28a745');
            }
        }

        $('#totaldibayar, #totalbayar').on('input keyup', function() {
            hitungKembalian();
        });

        $('#formeditselesai').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idselesai: $('#idselesai').val(),
                    jamjemput: $('#jamjemput').val(),
                    totalbayar: $('#totalbayar').val(),
                    totaldibayar: $('#totaldibayar').val()
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolSimpan').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Update Data Selesai');
                    $('#tombolSimpan').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_jamjemput) {
                            $('#jamjemput').addClass('is-invalid').removeClass('is-valid');
                            $('.error_jamjemput').html(err.error_jamjemput);
                        } else {
                            $('#jamjemput').removeClass('is-invalid').addClass('is-valid');
                            $('.error_jamjemput').html('');
                        }
                        if (err.error_totalbayar) {
                            $('#totalbayar').addClass('is-invalid').removeClass('is-valid');
                            $('.error_totalbayar').html(err.error_totalbayar);
                        } else {
                            $('#totalbayar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_totalbayar').html('');
                        }
                        if (err.error_totaldibayar) {
                            $('#totaldibayar').addClass('is-invalid').removeClass('is-valid');
                            $('.error_totaldibayar').html(err.error_totaldibayar);
                        } else {
                            $('#totaldibayar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_totaldibayar').html('');
                        }
                    }

                    if (response.sukses) {
                        var idselesai = response.idselesai;
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 2000,
                            showConfirmButton: false,
                            showCancelButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                const formSection = document.getElementById('formPenyelesaian');
                                if (formSection) {
                                    formSection.style.background = 'linear-gradient(45deg, #c3e6cb, #a8dadc)';
                                    formSection.style.border = '2px solid #28a745';
                                }
                            }
                        }).then(function() {
                            window.location.href = '<?= site_url('/selesai/detail/') ?>' + idselesai;
                        });
                    }
                },

                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + e.responseText
                    });
                }
            });

            return false;
        });

        hitungKembalian();

    });
</script>
<?= $this->endSection() ?>
