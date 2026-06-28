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
                            <label for="idpencucian">ID Pencucian</label>
                            <input type="text" id="idpencucian" name="idpencucian" class="form-control" value="<?= $next_id ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idpelanggan">ID Pelanggan</label>
                            <div class="input-group">
                                <input type="hidden" id="idpelanggan" name="idpelanggan" class="form-control" readonly>
                                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder="Pilih Pelanggan" readonly>
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
                            <input type="text" id="platnomor" name="platnomor" class="form-control" readonly>
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
                            <label for="idpaket">ID Paket</label>
                            <div class="input-group">
                                <input type="hidden" id="idpaket" name="idpaket" class="form-control" readonly>
                                <input type="text" id="namapaket" name="namapaket" class="form-control" placeholder="Pilih Paket" readonly>
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
                            <input type="text" id="harga" name="harga" class="form-control" readonly>
                        </div>
                    </div>
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label for="jenis">Jenis Paket</label>
                            <input type="text" id="jenis" name="jenis" class="form-control" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idkaryawan">ID Karyawan</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="autoAssignKaryawan" name="autoAssignKaryawan" checked>
                                <label class="form-check-label" for="autoAssignKaryawan">
                                    <i class="fas fa-magic text-primary"></i> Pilih karyawan otomatis
                                </label>
                                <small class="form-text text-muted">Sistem akan memilih karyawan yang tersedia secara otomatis</small>
                            </div>
                            <div class="input-group">
                                <input type="hidden" id="idkaryawan" name="idkaryawan" class="form-control" readonly>
                                <input type="text" id="namakaryawan" name="namakaryawan" class="form-control" placeholder="Pilih Karyawan" readonly disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="btnModalCariKaryawan" data-toggle="modal" data-target="#modalcariKaryawan" disabled>Cari</button>
                                </div>
                                <div class="invalid-feedback error_idkaryawan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="alamatkaryawan">Alamat Karyawan</label>
                            <input type="text" id="alamatkaryawan" name="alamatkaryawan" class="form-control" readonly>
                        </div>
                    </div>
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nohpkaryawan">No HP Karyawan</label>
                            <input type="text" id="nohpkaryawan" name="nohpkaryawan" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Detail Pencucian Preview -->
                <div id="detailPencucianPreview" style="display: none;">
                    <hr>
                    <div class="text-center mb-4">
                        <h4><i class="fas fa-eye mr-2"></i>Detail Pencucian</h4>
                        <p class="text-muted">Preview data sebelum disimpan</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="fas fa-box mr-1"></i> Detail Paket</h6>
                                </div>
                                <div class="card-body p-2">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td width="40%"><strong>ID:</strong></td><td id="preview_idpaket">-</td></tr>
                                        <tr><td><strong>Nama:</strong></td><td id="preview_namapaket">-</td></tr>
                                        <tr><td><strong>Jenis:</strong></td><td id="preview_jenis">-</td></tr>
                                        <tr><td><strong>Harga:</strong></td><td id="preview_harga" class="font-weight-bold text-primary">-</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="fas fa-user-tie mr-1"></i> Detail Karyawan</h6>
                                </div>
                                <div class="card-body p-2">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td width="40%"><strong>ID:</strong></td><td id="preview_idkaryawan">-</td></tr>
                                        <tr><td><strong>Nama:</strong></td><td id="preview_namakaryawan">-</td></tr>
                                        <tr><td><strong>No HP:</strong></td><td id="preview_nohpkaryawan">-</td></tr>
                                        <tr><td><strong>Alamat:</strong></td><td id="preview_alamatkaryawan">-</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="fas fa-info-circle mr-1"></i> Informasi Pencucian</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3"><strong>ID Pencucian:</strong><br><span class="badge badge-info" id="preview_idpencucian"><?= $next_id ?></span></div>
                                        <div class="col-md-3"><strong>Tanggal:</strong><br><span id="preview_tanggal"><?= date('d F Y') ?></span></div>
                                        <div class="col-md-3"><strong>Jam Datang:</strong><br><span id="preview_jam"><?= date('H:i:s') ?></span></div>
                                        <div class="col-md-3"><strong>Status:</strong><br><span class="badge badge-warning">Diproses</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                        <i class="fas fa-save"></i> Simpan Pencucian
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
    .table td { vertical-align: middle; }
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

        // Fungsi untuk mengecek kelengkapan data dan menampilkan preview
        function checkCompleteData() {
            var idpelanggan = $('#idpelanggan').val();
            var idpaket = $('#idpaket').val();
            var idkaryawan = $('#idkaryawan').val();
            var autoAssign = $('#autoAssignKaryawan').is(':checked');
            
            // Jika semua data sudah terisi (atau auto-assign untuk karyawan), tampilkan preview
            if (idpelanggan && idpaket && (idkaryawan || autoAssign)) {
                $('#detailPencucianPreview').slideDown('slow');
                
                // Update waktu real-time
                var now = new Date();
                var tanggal = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                var jam = now.toLocaleTimeString('id-ID');
                
                $('#preview_tanggal').text(tanggal);
                $('#preview_jam').text(jam);
                
                // Scroll ke section preview
                $('html, body').animate({
                    scrollTop: $("#detailPencucianPreview").offset().top - 100
                }, 1000);
                
                // Tambahkan efek highlight pada card
                $('.card').removeClass('shadow-lg').addClass('shadow');
                setTimeout(function() {
                    $('.card').addClass('shadow-lg');
                }, 500);
            } else {
                $('#detailPencucianPreview').slideUp('fast');
            }
        }

        // Fungsi untuk reset form dan preview
        function resetFormAndPreview() {
            // Reset form fields
            $('#idpelanggan, #nama_pelanggan, #alamat, #nohp, #platnomor').val('');
            $('#idpaket, #namapaket, #harga, #jenis').val('');
            $('#idkaryawan, #namakaryawan, #alamatkaryawan, #nohpkaryawan').val('');
            
            // Reset preview fields
            $('#preview_idpelanggan, #preview_nama_pelanggan, #preview_alamat, #preview_nohp, #preview_platnomor').text('-');
            $('#preview_idpaket, #preview_namapaket, #preview_harga, #preview_jenis').text('-');
            $('#preview_idkaryawan, #preview_namakaryawan, #preview_alamatkaryawan, #preview_nohpkaryawan').text('-');
            
            // Sembunyikan preview
            $('#detailPencucianPreview').hide();
        }
        
        $('#formtambahpencucian').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idpencucian: $('#idpencucian').val(),
                    idpelanggan: $('#idpelanggan').val(),
                    idpaket: $('#idpaket').val(),
                    idkaryawan: $('#idkaryawan').val(),
                    autoAssignKaryawan: $('#autoAssignKaryawan').is(':checked') ? 1 : 0
                },
              
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolSimpan').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan Pencucian');
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
                        var idpencucian = response.idpencucian;
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
                                    preview.style.borderRadius = '5px';
                                }
                            }
                        }).then(function() {
                            window.location.href = '<?= site_url('/pencucian/detail/') ?>' + idpencucian;
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

            // Load data here from the server
            $.get('<?= base_url() ?>/pencucian/getpelanggan', function(data) {
                $('#modalcariPelanggan .modal-body').html(data);
            });
        });

        $('#modalcariPaket').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
            $.get('<?= base_url() ?>/pencucian/getpaket', function(data) {
                $('#modalcariPaket .modal-body').html(data);
            });
        });
        $('#modalcariKaryawan').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
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
            checkCompleteData();
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
            checkCompleteData();
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
            checkCompleteData();
        });

        // Tambahkan tombol reset untuk clear semua data
        $(document).on('click', '#btnResetForm', function() {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Form direset!',
                        text: 'Silakan isi data kembali.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Auto-update jam setiap detik jika preview tampil
        setInterval(function() {
            if ($('#detailPencucianPreview').is(':visible')) {
                var now = new Date();
                var jam = now.toLocaleTimeString('id-ID');
                $('#preview_jam').text(jam);
            }
        }, 1000);

        // Event handler untuk checkbox auto-assign karyawan
        $('#autoAssignKaryawan').change(function() {
            if ($(this).is(':checked')) {
                // Auto-assign mode: disable manual selection
                $('#namakaryawan').prop('disabled', true).val('').attr('placeholder', 'Sistem akan memilih otomatis');
                $('#btnModalCariKaryawan').prop('disabled', true);
                $('#idkaryawan').val('');
                
                // Update preview untuk auto-assign
                $('#preview_idkaryawan').text('Auto');
                $('#preview_namakaryawan').text('Sistem akan pilih otomatis');
                $('#preview_alamatkaryawan').text('-');
                $('#preview_nohpkaryawan').text('-');
                
                // Clear manual data
                $('#alamatkaryawan').val('');
                $('#nohpkaryawan').val('');
            } else {
                // Manual mode: enable manual selection
                $('#namakaryawan').prop('disabled', false).attr('placeholder', 'Pilih Karyawan');
                $('#btnModalCariKaryawan').prop('disabled', false);
                
                // Reset preview
                $('#preview_idkaryawan').text('-');
                $('#preview_namakaryawan').text('-');
                $('#preview_alamatkaryawan').text('-');
                $('#preview_nohpkaryawan').text('-');
            }
            
            // Check complete data after toggle
            checkCompleteData();
        });

        // Trigger checkbox change on page load untuk set initial state
        $('#autoAssignKaryawan').trigger('change');

    });
</script>
<?= $this->endSection() ?>