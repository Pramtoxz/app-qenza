<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelPaket">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Paket</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelPaket').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pencucian/viewgetpaket',
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
        // Event listener untuk memilih paket
        $(document).on('click', '.btn-pilihpaket', function() {
            var idpaket = $(this).data('idpaket');
            var namapaket = $(this).data('namapaket');
            var harga = $(this).data('harga');
            var jenis = $(this).data('jenis');
            
            $('#idpaket').val(idpaket);
            $('#namapaket').val(namapaket);
            $('#harga').val(formatRupiah(harga));
            $('#jenis').val(jenis);
            $('#modalcariPaket').modal('hide');
        });
    });

    // Format currency function
    function formatRupiah(value) {
        if (!value || value === '') return '';
        const cleanValue = value.toString().replace(/[^0-9]/g, '');
        if (cleanValue === '') return '';
        const number = parseInt(cleanValue, 10);
        if (isNaN(number) || number === 0) return '';
        return 'Rp. ' + number.toLocaleString('id-ID');
    }
</script>