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
                        <a href="<?= site_url('selesai/formtambah') ?>" class="btn btn-danger">Tambah Data</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelSelesai">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Selesai</th>
                                    <th>ID Pencucian</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Plat Nomor</th>
                                    <th>Paket</th> 
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
        $('#tabelSelesai').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('selesai/viewSelesai') ?>",
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
            var idselesai = $(this).data('idselesai');

            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                text: "Data pencucian akan dikembalikan ke status 'dijemput'",
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
                        url: "<?php echo site_url('selesai/delete'); ?>",
                        data: {
                            idselesai: idselesai
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
                                $('#tabelSelesai').DataTable().ajax.reload();
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

        $(document).on('click', '.btn-edit', function() {
            var idselesai = $(this).data('idselesai');
            window.location.href = "<?php echo site_url('selesai/formedit/'); ?>" + idselesai;
        });

        $(document).on('click', '.btn-detail', function() {
            var idselesai = $(this).data('idselesai');
            window.location.href = "<?= site_url('selesai/detail/') ?>" + idselesai;
        });
    });
</script>
<?= $this->endSection() ?>