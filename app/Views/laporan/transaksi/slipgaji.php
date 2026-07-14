<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.report-container {
    background: white;
    padding: 20px;
    margin-top: 15px;
    min-height: 300px;
}
.loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
}
.loading-container i { font-size: 36px; opacity: .4; }
.slip-result {
    border: 2px solid #333;
    padding: 20px;
    background: #fff;
}
.slip-header {
    text-align: center;
    border-bottom: 3px solid #333;
    padding-bottom: 15px;
    margin-bottom: 20px;
}
.slip-header img { height: 60px; margin-bottom: 10px; }
.slip-header h1 { margin: 0; font-size: 20px; }
.slip-header h2 { margin: 5px 0 0; font-size: 14px; color: #666; }
.info-section { display: flex; gap: 20px; margin-bottom: 20px; }
.info-box { flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 5px; }
.info-box h3 { margin: 0 0 10px; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
.info-box table { width: 100%; font-size: 12px; }
.info-box table td { padding: 3px 0; }
.info-box table td:first-child { width: 40%; font-weight: bold; }
table.detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
table.detail-table th, table.detail-table td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
table.detail-table th { background: #333; color: white; }
table.detail-table tfoot td { font-weight: bold; background: #f8f9fa; }
.total-box {
    border: 2px solid #28a745;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    background: #d4edda;
    text-align: center;
}
.total-box h3 { margin: 0; color: #28a745; font-size: 18px; }
.total-box .amount { font-size: 24px; font-weight: bold; color: #28a745; margin-top: 5px; }
@media print {
    .card-header, .btn, .alert, .filter-section { display: none !important; }
    .report-container { box-shadow: none; border: none; margin: 0; padding: 0; }
}
</style>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-money-bill-wave me-2"></i>
                Laporan Slip Gaji Karyawan
            </h3>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="alert alert-info filter-section">
                <h5>
                    <i class="fas fa-filter me-2"></i>
                    Parameter Slip Gaji
                </h5>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                                <select name="idkaryawan" id="idkaryawan" class="form-control" required>
                                    <option value="">-- Pilih Karyawan --</option>
                                    <?php foreach ($karyawan as $k): ?>
                                        <option value="<?= $k['idkaryawan'] ?>"><?= esc($k['nama']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Awal <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="tglmulai" name="tglmulai">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="tglakhir" name="tglakhir">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button class="btn btn-primary w-100" onclick="TampilkanSlip()">
                                        <i class="fas fa-search me-2"></i>
                                        Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Container -->
            <div class="report-container" id="printHalaman">
                <div class="tabelSlipGaji">
                    <div class="loading-container">
                        <div style="text-align: center;">
                            <i class="fas fa-money-bill-wave" style="font-size: 48px; margin-bottom: 20px; opacity: 0.7;"></i>
                            <h5>Slip Gaji Karyawan</h5>
                            <p class="text-muted">Pilih karyawan dan masukkan rentang tanggal, lalu klik "Tampilkan"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function TampilkanSlip() {
        let idkaryawan = $('#idkaryawan').val();
        let tglmulai = $('#tglmulai').val();
        let tglakhir = $('#tglakhir').val();
        
        if (idkaryawan == '') {
            showNotification('warning', 'Perhatian', 'Karyawan belum dipilih!');
            $('#idkaryawan').focus();
            return;
        } else if (tglmulai == '') {
            showNotification('warning', 'Perhatian', 'Tanggal Awal belum diisi!');
            $('#tglmulai').focus();
            return;
        } else if (tglakhir == '') {
            showNotification('warning', 'Perhatian', 'Tanggal Akhir belum diisi!');
            $('#tglakhir').focus();
            return;
        } else if (new Date(tglmulai) > new Date(tglakhir)) {
            showNotification('warning', 'Perhatian', 'Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir!');
            $('#tglmulai').focus();
            return;
        }

        const $btn = $('.btn-primary');
        const $container = $('.tabelSlipGaji');
        const originalBtnText = $btn.html();
        
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></iMemuat...').prop('disabled', true);
        
        $container.html(`
            <div class="loading-container">
                <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                <h5>Memuat Data Slip Gaji</h5>
                <p class="text-muted">Sedang menghitung upah karyawan...</p>
            </div>
        `);

        $.ajax({
            type: "POST",
            url: "<?= base_url('laporan-transaksi/slip-gaji/getkaryawan') ?>",
            data: {
                idkaryawan: idkaryawan,
                tglmulai: tglmulai,
                tglakhir: tglakhir,
            },
            dataType: "JSON",
            timeout: 30000,
            success: function(response) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                if (response.sukses) {
                    let html = renderSlip(response);
                    $container.fadeOut(300, function() {
                        $(this).html(html).fadeIn(300);
                    });
                    showNotification('success', 'Data Berhasil Dimuat', 'Slip gaji berhasil ditampilkan');
                } else if (response.error) {
                    $container.html(`
                        <div class="text-center p-5">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 48px; margin-bottom: 20px;"></i>
                            <h5 class="text-warning">Error</h5>
                            <p class="text-muted">${response.error}</p>
                        </div>
                    `);
                    showNotification('error', 'Error', response.error);
                }
            },
            error: function(xhr, status, error) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                let errorMessage = 'Terjadi kesalahan saat memuat data';
                if (status === 'timeout') errorMessage = 'Koneksi timeout. Silakan coba lagi.';
                else if (xhr.status === 404) errorMessage = 'Endpoint tidak ditemukan';
                else if (xhr.status === 500) errorMessage = 'Kesalahan server internal';
                
                $container.html(`
                    <div class="text-center p-5">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 48px; margin-bottom: 20px;"></i>
                        <h5 class="text-warning">Gagal Memuat Data</h5>
                        <p class="text-muted">${errorMessage}</p>
                        <button class="btn btn-warning btn-sm" onclick="TampilkanSlip()">
                            <i class="fas fa-redo me-2"></i>Coba Lagi
                        </button>
                    </div>
                `);
                showNotification('error', 'Error', errorMessage);
            }
        });
    }

    function renderSlip(data) {
        let k = data.karyawan;
        let list = data.pencucianList;
        let totalUpah = data.total_upah;
        let tglmulai = formatDate(data.tglmulai);
        let tglakhir = formatDate(data.tglakhir);
        let namaBulan = tglmulai + ' - ' + tglakhir;

        let rows = '';
        let no = 1;
        for (let i = 0; i < list.length; i++) {
            let p = list[i];
            let upah = parseInt(p.upah) || 0;
            rows += `
                <tr>
                    <td style="text-align: center;">${no++}</td>
                    <td>${p.id}</td>
                    <td>${formatDate(p.tgl)}</td>
                    <td>${p.platnomor}</td>
                    <td>${p.namapaket}</td>
                    <td style="text-align: right;">Rp ${formatRupiah(upah)}</td>
                </tr>
            `;
        }

        let tableSection = '';
        if (list.length > 0) {
            tableSection = `
                <h3 style="margin: 0 0 10px; font-size: 14px;">Detail Pencucian Selesai</h3>
                <table class="detail-table">
                    <thead>
                            <tr>
                            <th style="text-align: center; width: 40px;">No</th>
                            <th>ID Kendaraan</th>
                            <th>Tanggal</th>
                            <th>Plat Nomor</th>
                            <th>Paket</th>
                            <th style="text-align: right;">Upah</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: right;">Total Upah:</td>
                            <td style="text-align: right;">Rp ${formatRupiah(totalUpah)}</td>
                        </tr>
                    </tfoot>
                </table>
            `;
        } else {
            tableSection = `
                <div class="text-center p-4" style="background: #f8f9fa; border-radius: 5px; margin: 15px 0;">
                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Tidak ada data pencucian selesai pada periode ini</p>
                </div>
            `;
        }

        return `
            <div class="slip-result">
                <div class="slip-header">
                    <img src="<?= base_url('assets/img/logoqenza.jpg') ?>" alt="Logo">
                    <h1>SLIP GAJI KARYAWAN</h1>
                    <h2>Qenza - Cucian Salju Sijunjung</h2>
                </div>

                <div style="text-align: center; background: #007bff; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    <strong>Periode: ${namaBulan}</strong> &nbsp;|&nbsp;
                    <strong>Jumlah Cucian: ${data.jumlah_cucian}</strong>
                </div>

                <div class="info-section">
                    <div class="info-box">
                        <h3>Data Karyawan</h3>
                        <table>
                            <tr><td>ID Karyawan</td><td>: ${k.idkaryawan}</td></tr>
                            <tr><td>Nama</td><td>: ${k.nama}</td></tr>
                            <tr><td>Alamat</td><td>: ${k.alamat || '-'}</td></tr>
                            <tr><td>No HP</td><td>: ${k.nohp || '-'}</td></tr>
                        </table>
                    </div>
                    <div class="info-box">
                        <h3>Ringkasan</h3>
                        <table>
                            <tr><td>Jumlah Cucian</td><td>: ${data.jumlah_cucian} cucian</td></tr>
                            <tr><td>Total Upah</td><td>: Rp ${formatRupiah(totalUpah)}</td></tr>
                        </table>
                    </div>
                </div>

                ${tableSection}

                <div class="total-box">
                    <h3>TOTAL UPAH</h3>
                    <div class="amount">Rp ${formatRupiah(totalUpah)}</div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn btn-success btn-lg" onclick="CetakSlip()">
                        <i class="fas fa-print me-2"></i>Cetak Slip Gaji
                    </button>
                </div>
            </div>
        `;
    }

    function CetakSlip() {
        let idkaryawan = $('#idkaryawan').val();
        let tglmulai = $('#tglmulai').val();
        let tglakhir = $('#tglakhir').val();

        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "<?= base_url('laporan-transaksi/slip-gaji/cetak') ?>";
        form.target = '_blank';

        let fields = {idkaryawan, tglmulai, tglakhir};
        for (let key in fields) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = fields[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function showNotification(type, title, message) {
        const icons = { success: 'success', error: 'error', warning: 'warning', info: 'info' };
        const colors = { success: '#28a745', error: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
        
        Swal.fire({
            icon: icons[type],
            title: title,
            text: message,
            confirmButtonColor: colors[type],
            timer: type === 'success' ? 2000 : undefined,
            showConfirmButton: type !== 'success',
            toast: type === 'success',
            position: type === 'success' ? 'top-end' : 'center',
            timerProgressBar: type === 'success'
        });
    }
</script>
<?= $this->endSection() ?>
