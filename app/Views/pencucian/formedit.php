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
                            <label for="idpelanggan">ID Pelanggan</label>
                            <div class="input-group">
                                <input type="hidden" id="idpelanggan" name="idpelanggan" class="form-control" value="<?= $pencucian['idpelanggan'] ?>" readonly>
                                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="<?= $pencucian['nama_pelanggan'] ?>" placeholder="Pilih Pelanggan" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="btnModalCariPelanggan" data-toggle="modal" data-target="#modalcariPelanggan">Cari</button>
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
                            <label for="idpaket">ID Paket</label>
                            <div class="input-group">
                                <input type="hidden" id="idpaket" name="idpaket" class="form-control" value="<?= $pencucian['idpaket'] ?>" readonly>
                                <input type="text" id="namapaket" name="namapaket" class="form-control" value="<?= $pencucian['namapaket'] ?>" placeholder="Pilih Paket" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="btnModalCariPaket" data-toggle="modal" data-target="#modalcariPaket">Cari</button>
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idkaryawan">ID Karyawan</label>
                            <div class="input-group">
                                <input type="hidden" id="idkaryawan" name="idkaryawan" class="form-control" value="<?= $pencucian['idkaryawan'] ?>" readonly>
                                <input type="text" id="namakaryawan" name="namakaryawan" class="form-control" value="<?= $pencucian['nama_karyawan'] ?>" placeholder="Pilih Karyawan" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="btnModalCariKaryawan" data-toggle="modal" data-target="#modalcariKaryawan">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idkaryawan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="alamatkaryawan">Alamat Karyawan</label>
                            <input type="text" id="alamatkaryawan" name="alamatkaryawan" class="form-control" value="<?= isset($pencucian['alamat_karyawan']) ? $pencucian['alamat_karyawan'] : '' ?>" readonly>
                        </div>
                    </div>
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nohpkaryawan">No HP Karyawan</label>
                            <input type="text" id="nohpkaryawan" name="nohpkaryawan" class="form-control" value="<?= isset($pencucian['nohp_karyawan']) ? $pencucian['nohp_karyawan'] : '' ?>" readonly>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Detail Pencucian Preview -->
                <div id="detailPencucianPreview" class="animated-section">
                    <hr class="my-4" style="border-top: 3px solid #007bff;">
                    <div class="text-center mb-4">
                        <h4 style="color: #007bff;">
                            <i class="fas fa-eye fa-lg"></i> 
                            <span class="ml-2">Detail Pencucian</span>
                        </h4>
                        <p class="text-muted">Preview data pencucian</p>
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
                                            <td width="40%"><strong>ID:</strong></td>
                                            <td id="preview_idpelanggan"><?= $pencucian['idpelanggan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td id="preview_nama_pelanggan"><?= $pencucian['nama_pelanggan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Plat Nomor:</strong></td>
                                            <td id="preview_platnomor"><?= isset($pencucian['platnomor']) ? $pencucian['platnomor'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>No HP:</strong></td>
                                            <td id="preview_nohp"><?= isset($pencucian['nohp']) ? $pencucian['nohp'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td id="preview_alamat"><?= isset($pencucian['alamat']) ? $pencucian['alamat'] : '-' ?></td>
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
                                            <td width="40%"><strong>ID:</strong></td>
                                            <td id="preview_idpaket"><?= $pencucian['idpaket'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Paket:</strong></td>
                                            <td id="preview_namapaket"><?= $pencucian['namapaket'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis:</strong></td>
                                            <td id="preview_jenis"><?= isset($pencucian['jenis']) ? $pencucian['jenis'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Harga:</strong></td>
                                            <td id="preview_harga" class="font-weight-bold" style="color: #007bff;"><?= isset($pencucian['harga']) ? 'Rp. ' . number_format($pencucian['harga'], 0, ',', '.') : '-' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detail Karyawan -->
                        <div class="col-md-4">
                            <div class="card" style="border-color: #007bff;">
                                <div class="card-header text-white" style="background-color: #007bff;">
                                    <h6 class="mb-0"><i class="fas fa-user-tie"></i> Detail Karyawan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>ID:</strong></td>
                                            <td id="preview_idkaryawan"><?= $pencucian['idkaryawan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td id="preview_namakaryawan"><?= $pencucian['nama_karyawan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>No HP:</strong></td>
                                            <td id="preview_nohpkaryawan"><?= isset($pencucian['nohp_karyawan']) ? $pencucian['nohp_karyawan'] : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td id="preview_alamatkaryawan"><?= isset($pencucian['alamat_karyawan']) ? $pencucian['alamat_karyawan'] : '-' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Tambahan -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card" style="border-color: #007bff;">
                                <div class="card-header text-white" style="background-color: #007bff;">
                                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Pencucian</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>ID Pencucian:</strong><br>
                                            <span class="badge" style="background-color: #007bff; color: white;" id="preview_idpencucian"><?= $pencucian['idpencucian'] ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Tanggal:</strong><br>
                                            <span class="text-muted" id="preview_tanggal"><?= date('d F Y', strtotime($pencucian['tgl'])) ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Jam Datang:</strong><br>
                                            <span class="text-muted" id="preview_jam"><?= $pencucian['jamdatang'] ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Status:</strong><br>
                                            <span class="badge badge-warning"><?= ucfirst($pencucian['status']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <!-- modal cari Pelanggan -->
    <div class="modal fade" id="modalcariPelanggan" tabindex="-1" role="dialog" aria-labelledby="modalcariPelangganLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcariPelangganLabel">Pilih Pelanggan untuk Pencucian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "getpelanggan.php" -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal cari Paket -->
    <div class="modal fade" id="modalcariPaket" tabindex="-1" role="dialog" aria-labelledby="modalcariPaketLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcariPaketLabel">Pilih Paket untuk Pencucian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "getpaket.php" -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal cari Karyawan -->
    <div class="modal fade" id="modalcariKaryawan" tabindex="-1" role="dialog" aria-labelledby="modalcariKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcariKaryawanLabel">Pilih Karyawan untuk Pencucian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "getkaryawan.php" -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<style>
    .animated-section {
        transition: all 0.3s ease-in-out;
    }
    
    .card {
        transition: all 0.3s ease;
        border-radius: 10px;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.8em;
    }
    
    .table td {
        padding: 0.5rem 0.25rem;
        vertical-align: middle;
    }
    
    .table strong {
        color: #495057;
    }
    
    #detailPencucianPreview {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 10px 30px rgba(111,66,193,0.1);
    }
</style>
<script>
    $(function() {
        // Format currency function
        function formatRupiah(value) {
            if (!value || value === '') return '';
            const cleanValue = value.toString().replace(/[^0-9]/g, '');
            if (cleanValue === '') return '';
            const number = parseInt(cleanValue, 10);
            if (isNaN(number) || number === 0) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        // Load detail pelanggan saat halaman load
        function loadDetailPelanggan(idpelanggan) {
            // Simulasi load detail pelanggan berdasarkan ID
            // Dalam implementasi nyata, gunakan AJAX untuk mengambil dari database
            $.ajax({
                type: "GET",
                url: "<?= site_url('pencucian/viewgetpelanggan') ?>",
                success: function(response) {
                    // Parse response dan cari data yang sesuai
                    // Untuk sementara, kita set manual karena data sudah ada di view
                }
            });
        }

        // Load detail paket saat halaman load
        function loadDetailPaket(idpaket) {
            // Simulasi load detail paket berdasarkan ID
        }

        // Load detail karyawan saat halaman load  
        function loadDetailKaryawan(idkaryawan) {
            // Simulasi load detail karyawan berdasarkan ID
        }
        
        $('#formeditpencucian').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idpencucian: $('#idpencucian').val(),
                    idpelanggan: $('#idpelanggan').val(),
                    idpaket: $('#idpaket').val(),
                    idkaryawan: $('#idkaryawan').val()
                },
              
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolSimpan').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Update Pencucian');
                    $('#tombolSimpan').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_idpelanggan) {
                            $('#nama_pelanggan').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idpelanggan').html(err.error_idpelanggan);
                        } else {
                            $('#nama_pelanggan').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idpelanggan').html('');
                        }
                        if (err.error_idpaket) {
                            $('#namapaket').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idpaket').html(err.error_idpaket);
                        } else {
                            $('#namapaket').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idpaket').html('');
                        }
                        if (err.error_idkaryawan) {
                            $('#namakaryawan').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idkaryawan').html(err.error_idkaryawan);
                        } else {
                            $('#namakaryawan').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idkaryawan').html('');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 2000,
                            showConfirmButton: false,
                            showCancelButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                const preview = document.getElementById('detailPencucianPreview');
                                if (preview) {
                                    preview.style.border = '2px solid #007bff';
                                    preview.style.borderRadius = '10px';
                                }
                            }
                        }).then(function() {
                            window.location.href = '<?= site_url('/pencucian') ?>';
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

        $('#modalcariPelanggan').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            $.get('<?= base_url() ?>/pencucian/getpelanggan', function(data) {
                $('#modalcariPelanggan .modal-body').html(data);
            });
        });

        $('#modalcariPaket').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            $.get('<?= base_url() ?>/pencucian/getpaket', function(data) {
                $('#modalcariPaket .modal-body').html(data);
            });
        });
        
        $('#modalcariKaryawan').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            $.get('<?= base_url() ?>/pencucian/getkaryawan', function(data) {
                $('#modalcariKaryawan .modal-body').html(data);
            });
        });
        
        // Event saat pelanggan dipilih
        $(document).on('click', '.btn-pilihpelanggan', function() {
            var idpelanggan = $(this).data('idpelanggan');
            var nama_pelanggan = $(this).data('nama_pelanggan');
            var alamat = $(this).data('alamat');
            var nohp = $(this).data('nohp');
            var platnomor = $(this).data('platnomor');
            
            // Set data ke form
            $('#idpelanggan').val(idpelanggan);
            $('#nama_pelanggan').val(nama_pelanggan);
            $('#alamat').val(alamat);
            $('#nohp').val(nohp);
            $('#platnomor').val(platnomor);
            
            // Update preview
            $('#preview_idpelanggan').text(idpelanggan);
            $('#preview_nama_pelanggan').text(nama_pelanggan);
            $('#preview_alamat').text(alamat);
            $('#preview_nohp').text(nohp);
            $('#preview_platnomor').text(platnomor);
            
            $('#modalcariPelanggan').modal('hide');
        });

        // Event saat paket dipilih
        $(document).on('click', '.btn-pilihpaket', function() {
            var idpaket = $(this).data('idpaket');
            var namapaket = $(this).data('namapaket');
            var harga = $(this).data('harga');
            var jenis = $(this).data('jenis');
            
            // Set data ke form
            $('#idpaket').val(idpaket);
            $('#namapaket').val(namapaket);
            $('#harga').val(formatRupiah(harga));
            $('#jenis').val(jenis);
            
            // Update preview
            $('#preview_idpaket').text(idpaket);
            $('#preview_namapaket').text(namapaket);
            $('#preview_harga').text(formatRupiah(harga));
            $('#preview_jenis').text(jenis);
            
            $('#modalcariPaket').modal('hide');
        });

        // Event saat karyawan dipilih
        $(document).on('click', '.btn-pilihkaryawan', function() {
            var idkaryawan = $(this).data('idkaryawan');
            var namakaryawan = $(this).data('namakaryawan');
            var alamat = $(this).data('alamat');
            var nohp = $(this).data('nohp');
            
            // Set data ke form
            $('#idkaryawan').val(idkaryawan);
            $('#namakaryawan').val(namakaryawan);
            $('#alamatkaryawan').val(alamat);
            $('#nohpkaryawan').val(nohp);
            
            // Update preview
            $('#preview_idkaryawan').text(idkaryawan);
            $('#preview_namakaryawan').text(namakaryawan);
            $('#preview_alamatkaryawan').text(alamat);
            $('#preview_nohpkaryawan').text(nohp);
            
            $('#modalcariKaryawan').modal('hide');
        });

    });
</script>
<?= $this->endSection() ?>