<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?= $title ?></h5>
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
                                    <th>ID Reservasi</th>
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

<div class="modal fade" id="modalAssignKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Assign Karyawan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="assign_idpencucian">
                <div id="assign-karyawan-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var table = $('#tabelCucian').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('pencucian/viewCucian') ?>",
            info: true,
            ordering: true,
            paging: true,
            order: [[1, 'desc']],
            aoColumnDefs: [{ bSortable: false, aTargets: ["no-short"] }]
        });

        $(document).on('click', '.btn-assign', function() {
            var idpencucian = $(this).data('idpencucian');
            $('#assign_idpencucian').val(idpencucian);
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            $('#assign-karyawan-content').html(loader);
            $('#modalAssignKaryawan').modal('show');

            $.get('<?= base_url() ?>/pencucian/getkaryawan', function(data) {
                $('#assign-karyawan-content').html(data);
            });
        });

        $(document).on('click', '.btn-pilihkaryawan', function() {
            var idkaryawan = $(this).data('idkaryawan');
            var namakaryawan = $(this).data('namakaryawan');
            var idpencucian = $('#assign_idpencucian').val();

            Swal.fire({
                title: 'Assign Karyawan?',
                text: 'Assign ' + namakaryawan + ' ke reservasi ' + idpencucian + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Assign!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('pencucian/assignKaryawan') ?>",
                        data: { idpencucian: idpencucian, idkaryawan: idkaryawan },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                $('#modalAssignKaryawan').modal('hide');
                                Swal.fire('Berhasil!', response.sukses, 'success');
                                table.ajax.reload();
                            } else if (response.error) {
                                Swal.fire('Gagal!', response.error, 'warning');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            var idpencucian = $(this).data('idpencucian');
            Swal.fire({
                title: 'Hapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('pencucian/delete') ?>",
                        data: { idpencucian: idpencucian },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire('Berhasil!', response.sukses, 'success');
                                table.ajax.reload();
                            } else if (response.error) {
                                Swal.fire('Gagal!', response.error, 'warning');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-batal', function() {
            var idpencucian = $(this).data('idpencucian');
            Swal.fire({
                title: 'Batalkan reservasi ini?',
                text: 'Status akan diubah menjadi Batal',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('pencucian/ubahbatal') ?>",
                        data: { idpencucian: idpencucian },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire('Berhasil!', response.sukses, 'success');
                                table.ajax.reload();
                            } else if (response.error) {
                                Swal.fire('Gagal!', response.error, 'warning');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-status', function() {
            var idpencucian = $(this).data('idpencucian');
            Swal.fire({
                title: 'Ubah Status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('pencucian/ubahstatus') ?>",
                        data: { idpencucian: idpencucian },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire('Berhasil!', response.sukses, 'success');
                                table.ajax.reload();
                            } else if (response.error) {
                                Swal.fire('Tidak Dapat Mengubah Status!', response.error, 'warning');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            window.location.href = "<?= site_url('pencucian/formedit/') ?>" + $(this).data('idpencucian');
        });

        $(document).on('click', '.btn-detail', function() {
            window.location.href = "<?= site_url('pencucian/detail/') ?>" + $(this).data('idpencucian');
        });

        $(document).on('click', '.btn-cetak-antrian', function() {
            window.location.href = "<?= site_url('pencucian/cetakAntrian/') ?>" + $(this).data('idpencucian');
        });
    });
</script>
<?= $this->endSection() ?>
