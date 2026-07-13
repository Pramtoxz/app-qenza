<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title"><?= $title ?></h3>
            </div>

            <div class="card-body">
                <?= form_open('karyawan/save', ['id' => 'formtambahkaryawan', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="idkaryawan" class="form-label">ID Karyawan</label>
                            <input type="text" id="idkaryawan" name="idkaryawan" class="form-control" value="<?= $auto_number ?>" readonly>
                            <div class="invalid-feedback error_idkaryawan"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama Karyawan</label>
                            <input type="text" id="nama" name="nama" class="form-control">
                            <div class="invalid-feedback error_nama"></div>
                        </div>                        
                        <div class="form-group">
                            <label for="nohp" class="form-label">No HP</label>
                            <input type="number" id="nohp" name="nohp" class="form-control">
                            <div class="invalid-feedback error_nohp"></div>
                        </div> 
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea type="text" id="alamat" name="alamat" class="form-control"></textarea>
                            <div class="invalid-feedback error_alamat"></div>
                        </div>                       
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary" id="tombolSimpan">
                                <i class="fas fa-save"></i> SIMPAN
                            </button>
                            <a class="btn btn-secondary ms-2" href="<?= base_url('karyawan') ?>">
                                <i class="fas fa-arrow-left"></i> KEMBALI
                            </a>
                        </div>
                    </div>
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
        $('#formtambahkaryawan').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this); // Menggunakan FormData untuk mendukung file upload
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: formData, // Menggunakan formData untuk mendukung file upload
                contentType: false, // Menunjukkan tidak adanya konten
                processData: false, // Menunjukkan tidak adanya proses data
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolSimpan').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                    $('#tombolSimpan').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_idkaryawan) {
                            $('#idkaryawan').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idkaryawan').html(err.error_idkaryawan);
                        } else {
                            $('#idkaryawan').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idkaryawan').html('');
                        }
                        if (err.error_nama) {
                            $('#nama').addClass('is-invalid').removeClass('is-valid');
                            $('.error_nama').html(err.error_nama);
                        } else {
                            $('#nama').removeClass('is-invalid').addClass('is-valid');
                            $('.error_nama').html('');
                        }

                        if (err.error_alamat) {
                            $('#alamat').addClass('is-invalid').removeClass('is-valid');
                            $('.error_alamat').html(err.error_alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid').addClass('is-valid');
                            $('.error_alamat').html('');
                        }
                    }

                    if (response.sukses) {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                        });
                        swalWithBootstrapButtons.fire({
                            title: "Sukses!",
                            text: "Data karyawan berhasil disimpan.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= site_url('karyawan') ?>';
                            }
                        });
                    }
                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });

            return false;
        });
    });
</script>
<?= $this->endSection() ?>