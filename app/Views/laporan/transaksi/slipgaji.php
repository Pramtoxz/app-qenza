<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Slip Gaji Karyawan</h4>
</div>

<div class="card shadow-sm mb-3 no-print">
    <div class="card-body py-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Karyawan</label>
                <select id="idkaryawan" class="form-select form-select-sm">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($karyawan as $k): ?>
                        <option value="<?= $k['idkaryawan'] ?>"><?= esc($k['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Dari</label>
                <input type="date" id="tglmulai" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Sampai</label>
                <input type="date" id="tglakhir" class="form-control form-control-sm">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm" onclick="loadSlip()">Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<div id="slipContent"></div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
function loadSlip() {
    var k = $('#idkaryawan').val(), a = $('#tglmulai').val(), b = $('#tglakhir').val();
    if (!k) { Swal.fire('Perhatian', 'Pilih karyawan', 'warning'); return; }
    if (!a || !b) { Swal.fire('Perhatian', 'Isi tanggal', 'warning'); return; }
    $('#slipContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
    $.post('<?= base_url('laporan-transaksi/slip-gaji/getkaryawan') ?>', {idkaryawan: k, tglmulai: a, tglakhir: b}, function(r) {
        if (r.error) { $('#slipContent').html('<div class="alert alert-warning">' + r.error + '</div>'); return; }
        if (!r.sukses) { $('#slipContent').html('<p class="text-muted text-center">Tidak ada data</p>'); return; }
        renderSlip(r);
    });
}

function renderSlip(d) {
    var rows = '';
    var no = 1;
    var total = 0;
    d.pencucianList.forEach(function(p) {
        var upah = parseInt(p.upah) || 0;
        total += upah;
        rows += '<tr><td class="text-center">' + no++ + '</td><td>' + fmtDate(p.tgl) + '</td><td>' + p.platnomor + '</td><td>' + p.namapaket + '</td><td class="text-end">' + fmtRp(upah) + '</td></tr>';
    });

    var html = '<div class="card shadow-sm" id="printArea"><div class="card-body">' +
        '<div class="text-center mb-3">' +
            '<div class="d-none d-print-block"><strong style="font-size:16px;">Pencucian Qenza</strong><br><small>Sungai Jodi, Kec. Lubuk Tarok, Kabupaten Sijunjung</small><hr style="border-top:1px solid #000;"></div>' +
            '<strong>Slip Gaji Karyawan</strong><br>' +
            '<small class="text-muted">Periode: ' + fmtDate(d.tglmulai) + ' - ' + fmtDate(d.tglakhir) + '</small>' +
        '</div>' +
        '<div class="row mb-3"><div class="col-md-6"><table class="table table-sm table-borderless mb-0">' +
            '<tr><td class="text-muted" width="120">ID</td><td>: ' + d.karyawan.idkaryawan + '</td></tr>' +
            '<tr><td class="text-muted">Nama</td><td>: ' + d.karyawan.nama + '</td></tr>' +
            '<tr><td class="text-muted">Alamat</td><td>: ' + (d.karyawan.alamat || '-') + '</td></tr>' +
            '<tr><td class="text-muted">No HP</td><td>: ' + (d.karyawan.nohp || '-') + '</td></tr>' +
        '</table></div>' +
        '<div class="col-md-6"><table class="table table-sm table-borderless mb-0">' +
            '<tr><td class="text-muted" width="120">Jumlah Cucian</td><td>: ' + d.jumlah_cucian + '</td></tr>' +
            '<tr><td class="text-muted">Total Upah</td><td class="fw-bold text-success">: ' + fmtRp(total) + '</td></tr>' +
        '</table></div></div>';

    if (d.pencucianList.length > 0) {
        html += '<table class="table table-bordered table-sm"><thead><tr><th class="text-center" style="width:40px">No</th><th>Tanggal</th><th>Plat Nomor</th><th>Paket</th><th class="text-end">Upah</th></tr></thead><tbody>' + rows + '</tbody><tfoot><tr><td colspan="4" class="text-end fw-bold">Total</td><td class="text-end fw-bold">' + fmtRp(total) + '</td></tr></tfoot></table>';
    } else {
        html += '<p class="text-muted text-center py-3">Tidak ada data pencucian selesai pada periode ini</p>';
    }

    html += '</div></div>' +
        '<div class="text-end mt-2 no-print"><button class="btn btn-success btn-sm" onclick="cetakSlip()"><i class="ri-printer-line me-1"></i> Cetak Slip</button></div>';

    $('#slipContent').html(html);
}

function cetakSlip() {
    var f = document.createElement('form');
    f.method = 'POST';
    f.action = '<?= base_url('laporan-transaksi/slip-gaji/cetak') ?>';
    f.target = '_blank';
    [{n:'idkaryawan',v:$('#idkaryawan').val()},{n:'tglmulai',v:$('#tglmulai').val()},{n:'tglakhir',v:$('#tglakhir').val()}].forEach(function(i) {
        var el = document.createElement('input'); el.type='hidden'; el.name=i.n; el.value=i.v; f.appendChild(el);
    });
    document.body.appendChild(f); f.submit(); document.body.removeChild(f);
}

function fmtRp(n) { return 'Rp ' + parseInt(n).toLocaleString('id-ID'); }
function fmtDate(s) { var d=new Date(s); return d.getDate()+' '+['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'][d.getMonth()]+' '+d.getFullYear(); }
</script>
<?= $this->endSection() ?>
