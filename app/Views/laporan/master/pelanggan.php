<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 no-print">
    <h4 class="mb-0">Laporan Pelanggan</h4>
    <div>
        <button onclick="loadData()" class="btn btn-outline-primary btn-sm"><i class="ri-refresh-line me-1"></i> Muat</button>
        <button onclick="cetakLaporan()" class="btn btn-primary btn-sm"><i class="ri-printer-line me-1"></i> Cetak</button>
    </div>
</div>

<div class="card shadow-sm no-print">
    <div class="card-body">
        <div id="tabelContent"><p class="text-muted text-center py-4">Klik "Muat" untuk menampilkan data</p></div>
    </div>
</div>

<div id="printArea" style="display:none;"></div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
var dataLoaded = '';

function loadData() {
    $('#tabelContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
    $.ajax({url: '<?= base_url('laporan-master/pelanggan/view') ?>', dataType: 'json', success: function(r) {
        dataLoaded = r.data || '';
        $('#tabelContent').html(dataLoaded || '<p class="text-muted text-center">Tidak ada data</p>');
    }});
}

function cetakLaporan() {
    if (!dataLoaded) { Swal.fire('Perhatian', 'Muat data terlebih dahulu', 'warning'); return; }
    var w = window.open('', '_blank');
    w.document.write('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Laporan Pelanggan</title>' +
        '<style>@page{size:A4;margin:2cm;}body{font-family:"Times New Roman",serif;font-size:12px;color:#000;}' +
        '.header{text-align:center;margin-bottom:20px;}.header h2{margin:0;font-size:18px;}.header p{margin:2px 0;font-size:12px;}' +
        '.header hr{border:1px solid #000;margin:10px 0;}.title{font-size:16px;font-weight:bold;text-decoration:underline;margin:15px 0;}' +
        'table{width:100%;border-collapse:collapse;margin:15px 0;font-size:11px;}th,td{border:1px solid #000;padding:6px 8px;text-align:left;}th{background:#f0f0f0;font-weight:bold;text-align:center;}' +
        '.footer{margin-top:30px;text-align:right;}.footer .sign{display:inline-block;text-align:center;width:200px;}.footer .sign .space{margin-top:60px;border-bottom:1px solid #000;}' +
        '</style></head><body>' +
        '<div class="header"><h2>PENCUCIAN QENZA</h2><p>Sungai Jodi, Kec. Lubuk Tarok, Kabupaten Sijunjung</p><hr><div class="title">Laporan Data Pelanggan</div></div>' +
        dataLoaded +
        '<div class="footer"><div class="sign"><p>Sijunjung, <?= date("d F Y") ?></p><p style="font-weight:bold;margin-top:5px;">Pimpinan</p><div class="space">&nbsp;</div></div></div>' +
        '</body></html>');
    w.document.close();
    w.onload = function() { w.print(); };
}

$(function() { loadData(); });
</script>
<?= $this->endSection() ?>
