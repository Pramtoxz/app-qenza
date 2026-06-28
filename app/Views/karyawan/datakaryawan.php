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
                        <a href="<?= site_url('karyawan/formtambah') ?>" class="btn btn-danger">Tambah Data</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelKaryawan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Karyawan</th>
                                    <th>Nama Karyawan</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
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
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="modal-header"
                style="background-color: #D81B60; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-id-card mr-2"></i> Detail Karyawan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="detail-content" style="overflow-y: auto;">
                <!-- Detail Karyawan akan dimuat melalui AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tabelKaryawan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('karyawan/viewKaryawan') ?>",
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
            var idkaryawan = $(this).data('idkaryawan');

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
                        url: "<?php echo site_url('karyawan/delete'); ?>",
                        data: {
                            idkaryawan: idkaryawan
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
                                $('#tabelkaryawan').DataTable().ajax.reload();
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
    });

    $(document).on('click', '.btn-edit', function() {
        var idkaryawan = $(this).data('idkaryawan');
        window.location.href = "<?php echo site_url('karyawan/formedit/'); ?>" + idkaryawan;
    });

    $(document).on('click', '.btn-detail', function() {
        var idkaryawan = $(this).data('idkaryawan');
        $.ajax({
            type: "GET",
            url: "<?= site_url('karyawan/detail/') ?>" + idkaryawan,
            dataType: 'html',
            success: function(response) {
                $('#detail-content').html(response);
                document.getElementById('detailModal').classList.remove('hidden');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Gagal memuat detail karyawan');
            }
        });
    });

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Tutup modal jika mengklik diluar modal
    window.onclick = function(event) {
        var modal = document.getElementById('detailModal');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
</script>
<?= $this->endSection() ?>