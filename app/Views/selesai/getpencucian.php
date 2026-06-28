<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelPencucianDijemput">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pencucian</th>
                <th>Tanggal</th>
                <th>Jam Datang</th>
                <th>Pelanggan</th>
                <th>Plat Nomor</th>
                <th>Paket</th>
                <th>Harga</th>
                <th>Karyawan</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    $('#tabelPencucianDijemput').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/selesai/viewgetpencuciandijemput',
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
</script>