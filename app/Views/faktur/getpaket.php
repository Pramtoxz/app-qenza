<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelPaket">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    if ($.fn.DataTable.isDataTable('#tabelPaket')) {
        $('#tabelPaket').DataTable().destroy();
    }

    $('#tabelPaket').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('faktur/viewgetpaket') ?>',
        info: true,
        ordering: true,
        paging: true,
        order: [[0, 'desc']],
        aoColumnDefs: [{ bSortable: false, aTargets: ["no-short"] }]
    });
</script>
