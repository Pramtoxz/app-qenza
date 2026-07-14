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
                        <a href="<?= site_url('faktur/formtambah') ?>" class="btn btn-danger">Tambah Faktur</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelFaktur">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Jumlah Kendaraan</th>
                                    <th>Status</th>
                                    <th>Status Bayar</th>
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
                <h5 class="modal-title"><i class="ri-user-add-line me-2"></i>Assign Karyawan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="assign_idreservasi">
                <input type="hidden" id="assign_idkendaraan">
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
        var table = $('#tabelFaktur').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('faktur/viewFaktur') ?>",
            info: true,
            ordering: true,
            paging: true,
            order: [[1, 'desc']],
            aoColumnDefs: [{ bSortable: false, aTargets: ["no-short"] }]
        });

        $(document).on('click', '.btn-detail', function() {
            window.location.href = "<?= site_url('faktur/detail/') ?>" + $(this).data('idreservasi');
        });

        $(document).on('click', '.btn-cetak-antrian', function() {
            window.location.href = "<?= site_url('faktur/cetakAntrian/') ?>" + $(this).data('idreservasi');
        });

        $(document).on('click', '.btn-assign', function() {
            var idreservasi = $(this).data('idreservasi');
            var idkendaraan = $(this).data('idkendaraan');
            $('#assign_idreservasi').val(idreservasi);
            $('#assign_idkendaraan').val(idkendaraan);
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            $('#assign-karyawan-content').html(loader);
            $('#modalAssignKaryawan').modal('show');

            $.get('<?= site_url('faktur/getkaryawan') ?>', function(data) {
                $('#assign-karyawan-content').html(data);
            });
        });

        $(document).on('click', '.btn-pilihkaryawan', function() {
            var idkaryawan = $(this).data('idkaryawan');
            var namakaryawan = $(this).data('namakaryawan');
            var idkendaraan = $('#assign_idkendaraan').val();

            Swal.fire({
                title: 'Assign Karyawan?',
                text: 'Assign ' + namakaryawan + ' ke kendaraan ini?',
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
                        url: "<?= site_url('faktur/assignKaryawan') ?>",
                        data: { id: idkendaraan, idkaryawan: idkaryawan },
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
            var idreservasi = $(this).data('idreservasi');
            Swal.fire({
                title: 'Hapus faktur ini?',
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
                        url: "<?= site_url('faktur/delete') ?>",
                        data: { idreservasi: idreservasi },
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
            var idkendaraan = $(this).data('idkendaraan');
            Swal.fire({
                title: 'Ubah Status Kendaraan?',
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
                        url: "<?= site_url('faktur/ubahstatus') ?>",
                        data: { id: idkendaraan },
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

        $(document).on('click', '.btn-batal', function() {
            var idkendaraan = $(this).data('idkendaraan');
            Swal.fire({
                title: 'Batalkan kendaraan ini?',
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
                        url: "<?= site_url('faktur/ubahbatal') ?>",
                        data: { id: idkendaraan },
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
    });
</script>
<?= $this->endSection() ?>
