<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelWedding">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pelanggan</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Plat Nomor</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelWedding').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pencucian/viewgetpelanggan',
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
        // Event listener sudah ada di formtambah.php
        // Tidak perlu duplikasi handler di sini
    });
</script>