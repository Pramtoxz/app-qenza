<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelKaryawan">
        <thead>
            <tr>
                <th>No</th>
                <th>Status</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelKaryawan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pencucian/viewgetkaryawan',
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

    $(document).ready(function() {
        // Event listener untuk memilih karyawan
        $(document).on('click', '.btn-pilihkaryawan', function() {
            var idkaryawan = $(this).data('idkaryawan');
            var namakaryawan = $(this).data('namakaryawan');
            var alamat = $(this).data('alamat');
            var nohp = $(this).data('nohp');
            
            $('#idkaryawan').val(idkaryawan);
            $('#namakaryawan').val(namakaryawan);
            $('#alamatkaryawan').val(alamat);
            $('#nohpkaryawan').val(nohp);
            $('#modalcariKaryawan').modal('hide');
        });
    });
</script>