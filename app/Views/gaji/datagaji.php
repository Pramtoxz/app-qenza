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
                        <a href="<?= site_url('gaji/formtambah') ?>" class="btn btn-danger">Tambah Data</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelGaji">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Gaji</th>
                                    <th>Nama Karyawan</th>
                                    <th>Periode</th>
                                    <th>Jumlah Cucian</th>
                                    <th>Total Upah</th>
                                    <th>Total Bayar</th>
                                    <th>Tanggal Bayar</th>
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
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var table = $('#tabelGaji').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('gaji/viewGaji') ?>",
            info: true,
            ordering: true,
            paging: true,
            order: [[0, 'desc']],
            aoColumnDefs: [{ bSortable: false, aTargets: ["no-short"] }]
        });

        $(document).on('click', '.btn-detail', function() {
            window.location.href = "<?= site_url('gaji/detail/') ?>" + $(this).data('idgaji');
        });

        $(document).on('click', '.btn-edit', function() {
            window.location.href = "<?= site_url('gaji/formedit/') ?>" + $(this).data('idgaji');
        });

        $(document).on('click', '.btn-delete', function() {
            var idgaji = $(this).data('idgaji');
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
                        url: "<?= site_url('gaji/delete') ?>",
                        data: { idgaji: idgaji },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire('Berhasil!', response.sukses, 'success');
                                table.ajax.reload();
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
