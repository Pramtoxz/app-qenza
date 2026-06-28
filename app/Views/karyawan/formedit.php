<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Edit Data Karyawan</h3>
            </div>

            <div class="card-body">
                <?= form_open(base_url('karyawan/updatedata'), ['id' => 'formedit', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="idkaryawan">ID Karyawan</label>
                            <input type="text" id="idkaryawan" name="idkaryawan" class="form-control" value="<?= $karyawan['idkaryawan']; ?>" readonly>
                            <div class="invalid-feedback error_idkaryawan"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama">Nama Karyawan</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $karyawan['nama']; ?>">
                            <div class="invalid-feedback error_nama"></div>
                        </div>                        
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="number" id="nohp" name="nohp" class="form-control" value="<?= $karyawan['nohp']; ?>">
                            <div class="invalid-feedback error_nohp"></div>
                        </div> 
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" id="alamat" name="alamat" class="form-control"><?= isset($karyawan['alamat']) ? $karyawan['alamat'] : '' ?></textarea>
                            <div class="invalid-feedback error_alamat"></div>
                        </div>                       
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary" id="tombolSimpan">
                                <i class="fas fa-save"></i> SIMPAN
                            </button>
                            <a class="btn btn-secondary ml-2" href="<?= base_url('karyawan') ?>">
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
        $('#formedit').submit(function(e) {
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