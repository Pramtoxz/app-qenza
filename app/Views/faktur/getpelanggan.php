<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelPelanggan">
        <thead>
            <tr>
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
    if ($.fn.DataTable.isDataTable('#tabelPelanggan')) {
        $('#tabelPelanggan').DataTable().destroy();
    }

    $('#tabelPelanggan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('faktur/viewgetpelanggan') ?>',
        info: true,
        ordering: true,
        paging: true,
        order: [[0, 'desc']],
        aoColumnDefs: [{ bSortable: false, aTargets: ["no-short"] }]
    });
</script>
