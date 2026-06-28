<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('pencucian/formtambah') ?>" class="btn btn-danger">Tambah Data</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelCucian">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Cucian</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Plat Nomor</th>
                                    <th>Paket</th>
                                    <th>Karyawan</th>
                                    <th>Status</th>
                                    <th class="no-short">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tabelCucian').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('pencucian/viewCucian') ?>",
            info: true,
            ordering: true,
            paging: true,
            order: [
                [0, 'desc']
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-short"]
            }],
        });

        $(document).on('click', '.btn-delete', function() {
            var idpencucian = $(this).data('idpencucian');

            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('pencucian/delete'); ?>",
                        data: {
                            idpencucian: idpencucian
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.sukses,
                                    icon: 'success'
                                });
                                // Refresh DataTable
                                $('#tabelCucian').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus data',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-status', function() {
            var idpencucian = $(this).data('idpencucian');

            Swal.fire({
                title: 'Apakah Anda yakin ingin Mengubah Status ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ganti Status!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('/pencucian/ubahstatus'); ?>",
                        data: {
                            idpencucian: idpencucian
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.sukses,
                                    icon: 'success'
                                });
                                // Refresh DataTable
                                $('#tabelCucian').DataTable().ajax.reload();
                            } else if (response.error) {
                                // Handle specific error messages from server
                                Swal.fire({
                                    title: 'Tidak Dapat Mengubah Status!',
                                    text: response.error,
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal mengubah status',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal mengubah status',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.btn-edit', function() {
        var idpencucian = $(this).data('idpencucian');
        window.location.href = "<?php echo site_url('pencucian/formedit/'); ?>" + idpencucian;
    });

    $(document).on('click', '.btn-detail', function() {
        var idpencucian = $(this).data('idpencucian');
        window.location.href = "<?= site_url('pencucian/detail/') ?>" + idpencucian;
    });

    $(document).on('click', '.btn-cetak-antrian', function() {
        var idpencucian = $(this).data('idpencucian');
        
        // Langsung ke halaman cetak antrian
        window.location.href = "<?= site_url('pencucian/cetakAntrian/') ?>" + idpencucian;
    });
</script>
<?= $this->endSection() ?>