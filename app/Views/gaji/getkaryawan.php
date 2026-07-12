<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelCariKaryawan">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Karyawan</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    $('#tabelCariKaryawan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/gaji/viewgetkaryawan?bulan=' + bulan + '&tahun=' + tahun,
        info: true,
        ordering: true,
        paging: true,
        order: [[0, 'desc']],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });
</script>
