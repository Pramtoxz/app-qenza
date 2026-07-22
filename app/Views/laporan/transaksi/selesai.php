<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 no-print">
    <h4 class="mb-0">Laporan Pendapatan</h4>
    <button onclick="cetakLaporan()" class="btn btn-primary btn-sm"><i class="ri-printer-line me-1"></i> Cetak</button>
</div>

<div class="card shadow-sm mb-3 no-print">
    <div class="card-body py-3">
        <div class="row g-2 align-items-end">
            <div class="col-auto"><strong class="small">Semua:</strong></div>
            <div class="col-auto"><button class="btn btn-outline-secondary btn-sm" onclick="loadSemua()">Muat Semua</button></div>
            <div class="col-auto"><strong class="small">Tanggal:</strong></div>
            <div class="col-auto"><input type="date" id="tglmulai" class="form-control form-control-sm"></div>
            <div class="col-auto"><input type="date" id="tglakhir" class="form-control form-control-sm"></div>
            <div class="col-auto"><button class="btn btn-primary btn-sm" onclick="loadTanggal()">Filter</button></div>
        </div>
        <div class="row g-2 align-items-end mt-2">
            <div class="col-auto"><strong class="small">Bulan:</strong></div>
            <div class="col-auto">
                <select id="bulan" class="form-select form-select-sm">
                    <option value="">-- Pilih --</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-auto"><input type="number" id="tahunBulan" class="form-control form-control-sm" value="<?= date('Y') ?>" style="width:90px;"></div>
            <div class="col-auto"><button class="btn btn-primary btn-sm" onclick="loadBulan()">Filter Bulan</button></div>
            <div class="col-auto"><strong class="small">Tahun:</strong></div>
            <div class="col-auto"><input type="number" id="tahunFilter" class="form-control form-control-sm" value="<?= date('Y') ?>" style="width:90px;"></div>
            <div class="col-auto"><button class="btn btn-primary btn-sm" onclick="loadTahun()">Filter Tahun</button></div>
        </div>
    </div>
</div>

<div class="card shadow-sm no-print">
    <div class="card-body">
        <div id="tabelContent"><p class="text-muted text-center py-4">Pilih filter untuk menampilkan data</p></div>
    </div>
</div>

<div id="printArea" style="display:none;"></div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
var dataLoaded = '';
var judulLaporan = 'Laporan Pendapatan';
var periodeLaporan = '';

function loadSemua() {
    judulLaporan = 'Laporan Pendapatan';
    periodeLaporan = '';
    $('#tabelContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
    $.ajax({url: '<?= base_url('laporan-transaksi/selesai/view') ?>', dataType: 'json', success: function(r) {
        dataLoaded = r.data || '';
        $('#tabelContent').html(dataLoaded || '<p class="text-muted text-center">Tidak ada data</p>');
    }});
}
function loadTanggal() {
    var a = $('#tglmulai').val(), b = $('#tglakhir').val();
    if (!a || !b) { Swal.fire('Perhatian', 'Isi tanggal awal dan akhir', 'warning'); return; }
    judulLaporan = 'Laporan Pendapatan';
    periodeLaporan = fmtDate(a) + ' - ' + fmtDate(b);
    $('#tabelContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
    $.ajax({url: '<?= base_url('laporan-transaksi/selesai/viewtanggal') ?>', type: 'POST', data: {tglmulai: a, tglakhir: b}, dataType: 'json', success: function(r) {
        dataLoaded = r.data || '';
        $('#tabelContent').html(dataLoaded || '<p class="text-muted text-center">Tidak ada data</p>');
    }});
}
function loadBulan() {
    var bl = $('#bulan').val(), th = $('#tahunBulan').val();
    if (!bl) { Swal.fire('Perhatian', 'Pilih bulan', 'warning'); return; }
    var bulanNames = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    judulLaporan = 'Laporan Pendapatan Bulan';
    periodeLaporan = bulanNames[parseInt(bl)] + ' ' + th;
    $('#tabelContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
    $.ajax({url: '<?= base_url('laporan-transaksi/selesai/viewbulan') ?>', type: 'POST', data: {bulan: bl, tahun: th}, dataType: 'json', success: function(r) {
        dataLoaded = r.data || '';
        $('#tabelContent').html(dataLoaded || '<p class="text-muted text-center">Tidak ada data</p>');
    }});
}
function loadTahun() {
    var th = $('#tahunFilter').val();
    if (!th) { Swal.fire('Perhatian', 'Pilih tahun', 'warning'); return; }
    judulLaporan = 'Laporan Pendapatan Tahun';
    periodeLaporan = th;
    $('#tabelContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
    $.ajax({url: '<?= base_url('laporan-transaksi/selesai/viewtahun') ?>', type: 'POST', data: {tahun: th}, dataType: 'json', success: function(r) {
        dataLoaded = r.data || '';
        $('#tabelContent').html(dataLoaded || '<p class="text-muted text-center">Tidak ada data</p>');
    }});
}

function fmtDate(s) { var d=new Date(s); return d.getDate()+' '+['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'][d.getMonth()]+' '+d.getFullYear(); }

function cetakLaporan() {
    if (!dataLoaded) { Swal.fire('Perhatian', 'Muat data terlebih dahulu', 'warning'); return; }
    var periodeHtml = periodeLaporan ? '<p style="margin:2px 0;font-size:11px;">Periode: ' + periodeLaporan + '</p>' : '';
    var w = window.open('', '_blank');
    w.document.write('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' + judulLaporan + '</title>' +
        '<style>@page{size:A4 landscape;margin:1.5cm;}body{font-family:"Times New Roman",serif;font-size:11px;color:#000;}' +
        '.header{text-align:center;margin-bottom:15px;}.header h2{margin:0;font-size:16px;}.header p{margin:2px 0;font-size:11px;}' +
        '.header hr{border:1px solid #000;margin:8px 0;}.title{font-size:14px;font-weight:bold;text-decoration:underline;margin:10px 0;}' +
        'table{width:100%;border-collapse:collapse;margin:10px 0;font-size:10px;}th,td{border:1px solid #000;padding:5px 6px;text-align:left;}th{background:#f0f0f0;font-weight:bold;text-align:center;}' +
        '.footer{margin-top:25px;text-align:right;}.footer .sign{display:inline-block;text-align:center;width:200px;}.footer .sign .space{margin-top:50px;border-bottom:1px solid #000;}' +
        '</style></head><body>' +
        '<div class="header"><h2>PENCUCIAN QENZA</h2><p>Sungai Jodi, Kec. Lubuk Tarok, Kabupaten Sijunjung</p><hr><div class="title">' + judulLaporan + '</div>' + periodeHtml + '</div>' +
        dataLoaded +
        '<div class="footer"><div class="sign"><p>Sijunjung, <?= date("d F Y") ?></p><p style="font-weight:bold;margin-top:5px;">Pimpinan</p><div class="space">&nbsp;</div></div></div>' +
        '</body></html>');
    w.document.close();
    w.onload = function() { w.print(); };
}
</script>
<?= $this->endSection() ?>
