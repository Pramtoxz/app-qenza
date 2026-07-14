<div class="table-responsive datatable-minimal">
    <table class="table table-hover" id="tabelKaryawan">
        <thead>
            <tr>
                <th>Status</th>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    if ($.fn.DataTable.isDataTable('#tabelKaryawan')) {
        $('#tabelKaryawan').DataTable().destroy();
    }

    $('#tabelKaryawan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('faktur/viewgetkaryawan') ?>',
        info: true,
        ordering: true,
        paging: true,
        order: [[0, 'asc']],
        aoColumnDefs: [{ bSortable: false, aTargets: ["no-short"] }]
    });
</script>
