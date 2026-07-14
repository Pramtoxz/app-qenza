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
.print-header { text-align: center; margin-bottom: 20px; }
.print-logo-section {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    gap: 30px;
}
.print-logo { height: 80px; }
.print-company-info h1 {
    font-size: 22px;
    font-family: 'Times New Roman', serif;
    margin: 0;
    font-weight: bold;
}
.print-company-info p {
    font-size: 14px;
    font-family: 'Times New Roman', serif;
    margin: 5px 0 0;
    color: #666;
}
.print-divider { border: 1px solid #333; margin: 15px 0; }
.print-title {
    font-size: 18px;
    font-family: 'Times New Roman', serif;
    font-weight: bold;
    text-decoration: underline;
    margin: 15px 0;
}
.print-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}
.print-signature { text-align: center; }
.print-signature p { font-family: 'Times New Roman', serif; }
.signature-space { margin-top: 60px; }
@media print {
    .card-header, .btn, .alert { display: none !important; }
    .report-container { box-shadow: none; border: none; margin: 0; padding: 0; }
}
</style>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line me-2"></i>
                Laporan Transaksi Pencucian
            </h3>
        </div>
        
        <div class="card-body">
            <!-- Control Panel -->
            <div class="alert alert-info">
                <h5>
                    <i class="fas fa-cog me-2"></i>
                    Panel Kontrol Laporan
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center">
                            <button class="btn btn-primary me-2 mb-2" onclick="ViewLaporanSemua()" 
                                    title="Memuat dan menampilkan semua data pencucian (Ctrl+R)">
                                <i class="fas fa-eye me-2"></i>
                                Tampilkan Semua Data
                            </button>
                            <button class="btn btn-success me-2 mb-2" onclick="PrintLaporan()" 
                                    title="Mencetak laporan dalam format yang siap cetak (Ctrl+P)">
                                <i class="fas fa-print me-2"></i>
                                Cetak Laporan
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Gunakan filter untuk menampilkan data sesuai periode
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="alert alert-info">
                <h5>
                    <i class="fas fa-filter me-2"></i>
                    Filter Laporan
                </h5>
                
                <!-- Filter by Date Range -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>
                            <i class="fas fa-calendar-day me-2"></i>
                            Filter Berdasarkan Rentang Tanggal
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Awal</label>
                                <input class="form-control" type="date" id="tglmulai" name="tglmulai">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Akhir</label>
                                <input class="form-control" type="date" id="tglakhir" name="tglakhir">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button class="btn btn-info" onclick="ViewLaporanTanggal()">
                                        <i class="fas fa-search me-2"></i>
                                        Tampilkan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter by Month/Year -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>
                            <i class="fas fa-calendar-alt me-2"></i>
                            Filter Berdasarkan Bulan & Tahun
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" 
                                       placeholder="Masukkan tahun (contoh: 2024)" 
                                       min="2020" max="2050" 
                                       value="<?= date('Y') ?>"
                                       title="Masukkan tahun antara 2020 - 2050">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button class="btn btn-info" onclick="ViewLaporanPerbulan()">
                                        <i class="fas fa-search me-2"></i>
                                        Tampilkan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Container -->
            <div class="report-container" id="printHalaman">
                <div class="print-header">
                    <div class="print-logo-section">
                        <img src="<?= site_url('assets/img/logoqenza.jpg') ?>" alt="Logo Pencucian Qenza" class="print-logo">
                        <div class="print-company-info">
                            <h1>Pencucian Qenza</h1>
                            <p>Sungai jodi, Kec. Lubuk Tarok, Kabupaten Sijunjung, Sumatera Barat 27553</p>
                        </div>
                    </div>
                    <hr class="print-divider">
                    <div class="print-title">Laporan Transaksi Pencucian</div>
                </div>
                
                <!-- Table Container -->
                <div class="tabelpencucian">
                    <div class="loading-container">
                        <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                        <h5>Menunggu Data Laporan</h5>
                        <p class="text-muted">Klik tombol "Tampilkan Semua Data" atau gunakan filter untuk memuat data</p>
                    </div>
                </div>

                <!-- Print Footer -->
                <div class="print-footer">
                    <div></div>
                    <?php $tanggal = date('d F Y'); ?>
                    <div class="print-signature">
                        <p>Sijunjung, <?= $tanggal ?></p>
                        <br>
                        <br>
                        <br>
                        <br>
                        <p class="signature-space">Pimpinan</p>
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
    $(document).ready(function() {
        showWelcomeMessage();
    });

    function showWelcomeMessage() {
        const $container = $('.tabelpencucian');
        $container.html(`
            <div class="loading-container">
                <div style="text-align: center;">
                    <i class="fas fa-chart-line" style="font-size: 48px; margin-bottom: 20px; opacity: 0.7;"></i>
                    <h5>Selamat Datang di Laporan Pencucian</h5>
                    <p class="text-muted">Klik tombol "Tampilkan Semua Data" atau gunakan filter untuk memuat data pencucian</p>
                </div>
            </div>
        `);
    }

    function ViewLaporanSemua() {
        const $btn = $('.btn-primary');
        const $container = $('.tabelpencucian');
        const originalBtnText = $btn.html();
        
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Memuat Data...').prop('disabled', true);
        
        $container.html(`
            <div class="loading-container">
                <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                <h5>Memuat Data Pencucian</h5>
                <p class="text-muted">Sedang mengambil data dari server...</p>
            </div>
        `);

        $.ajax({
            type: "GET",
            url: "<?= base_url('laporan-transaksi/pencucian/view') ?>",
            dataType: "JSON",
            timeout: 30000,
            success: function(response) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                if (response.data) {
                    $container.fadeOut(300, function() {
                        $(this).html(response.data).fadeIn(300);
                    });
                    showNotification('success', 'Data Berhasil Dimuat', 'Data pencucian telah berhasil ditampilkan');
                } else {
                    $container.html(`
                        <div class="text-center p-5">
                            <i class="fas fa-car-wash fa-3x text-muted mb-3"></i>
                            <h5>Tidak Ada Data</h5>
                            <p class="text-muted">Belum ada data pencucian yang tersedia</p>
                        </div>
                    `);
                    showNotification('info', 'Data Kosong', 'Belum ada data pencucian yang tersedia');
                }
            },
            error: function(xhr, status, error) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                let errorMessage = 'Terjadi kesalahan saat memuat data';
                
                if (status === 'timeout') {
                    errorMessage = 'Koneksi timeout. Silakan coba lagi.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Endpoint tidak ditemukan';
                } else if (xhr.status === 500) {
                    errorMessage = 'Kesalahan server internal';
                }
                
                $container.html(`
                    <div class="text-center p-5">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 48px; margin-bottom: 20px;"></i>
                        <h5 class="text-warning">Gagal Memuat Data</h5>
                        <p class="text-muted">${errorMessage}</p>
                        <button class="btn btn-warning btn-sm" onclick="ViewLaporanSemua()">
                            <i class="fas fa-redo me-2"></i>Coba Lagi
                        </button>
                    </div>
                `);
                
                showNotification('error', 'Error', errorMessage);
                console.error('AJAX Error:', xhr, status, error);
            }
        });
    }

    function ViewLaporanTanggal() {
        let tglmulai = $('#tglmulai').val();
        let tglakhir = $('#tglakhir').val();
        
        if (tglmulai == '') {
            showNotification('warning', 'Perhatian', 'Tanggal Awal Belum Dipilih!');
            $('#tglmulai').focus();
            return;
        } else if (tglakhir == '') {
            showNotification('warning', 'Perhatian', 'Tanggal Akhir Belum Dipilih!');
            $('#tglakhir').focus();
            return;
        } else if (new Date(tglmulai) > new Date(tglakhir)) {
            showNotification('warning', 'Perhatian', 'Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir!');
            $('#tglmulai').focus();
            return;
        }

        const $btn = $('.btn-info').eq(0);
        const $container = $('.tabelpencucian');
        const originalBtnText = $btn.html();
        
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Memuat...').prop('disabled', true);
        
        $container.html(`
            <div class="loading-container">
                <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                <h5>Memuat Data berdasarkan Tanggal</h5>
                <p class="text-muted">Periode: ${formatDate(tglmulai)} - ${formatDate(tglakhir)}</p>
            </div>
        `);

        $.ajax({
            type: "POST",
            url: "<?= base_url('laporan-transaksi/pencucian/viewtanggal') ?>",
            data: {
                tglmulai: tglmulai,
                tglakhir: tglakhir,
            },
            dataType: "JSON",
            timeout: 30000,
            success: function(response) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                if (response.data) {
                    $container.fadeOut(300, function() {
                        $(this).html(response.data).fadeIn(300);
                    });
                    showNotification('success', 'Data Berhasil Dimuat', `Data pencucian periode ${formatDate(tglmulai)} - ${formatDate(tglakhir)} berhasil ditampilkan`);
                } else {
                    $container.html(`
                        <div class="text-center p-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5>Tidak Ada Data</h5>
                            <p class="text-muted">Tidak ada data pencucian untuk periode ${formatDate(tglmulai)} - ${formatDate(tglakhir)}</p>
                        </div>
                    `);
                    showNotification('info', 'Data Kosong', 'Tidak ada data untuk periode yang dipilih');
                }
            },
            error: function(xhr, status, error) {
                $btn.html(originalBtnText).prop('disabled', false);
                handleAjaxError(xhr, status, error, $container);
            }
        });
    }

    function ViewLaporanPerbulan() {
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();
        
        if (bulan == '') {
            showNotification('warning', 'Perhatian', 'Bulan Belum Dipilih!');
            $('#bulan').focus();
            return;
        } else if (tahun == '') {
            showNotification('warning', 'Perhatian', 'Tahun Belum Dipilih!');
            $('#tahun').focus();
            return;
        } else if (tahun < 2020 || tahun > 2050) {
            showNotification('warning', 'Perhatian', 'Tahun harus antara 2020 - 2050!');
            $('#tahun').focus();
            return;
        }

        const $btn = $('.btn-info').eq(1);
        const $container = $('.tabelpencucian');
        const originalBtnText = $btn.html();
        
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Memuat...').prop('disabled', true);
        
        const bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $container.html(`
            <div class="loading-container">
                <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                <h5>Memuat Data berdasarkan Bulan</h5>
                <p class="text-muted">Periode: ${bulanNames[bulan]} ${tahun}</p>
            </div>
        `);

        $.ajax({
            type: "POST",
            url: "<?= base_url('laporan-transaksi/pencucian/viewbulan') ?>",
            data: {
                bulan: bulan,
                tahun: tahun,
            },
            dataType: "JSON",
            timeout: 30000,
            success: function(response) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                if (response.data) {
                    $container.fadeOut(300, function() {
                        $(this).html(response.data).fadeIn(300);
                    });
                    showNotification('success', 'Data Berhasil Dimuat', `Data pencucian ${bulanNames[bulan]} ${tahun} berhasil ditampilkan`);
                } else {
                    $container.html(`
                        <div class="text-center p-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5>Tidak Ada Data</h5>
                            <p class="text-muted">Tidak ada data pencucian untuk ${bulanNames[bulan]} ${tahun}</p>
                        </div>
                    `);
                    showNotification('info', 'Data Kosong', 'Tidak ada data untuk periode yang dipilih');
                }
            },
            error: function(xhr, status, error) {
                $btn.html(originalBtnText).prop('disabled', false);
                handleAjaxError(xhr, status, error, $container);
            }
        });
    }

    function PrintLaporan() {
        const $printBtn = $('.btn-success');
        const originalBtnText = $printBtn.html();
        
        const hasData = $('.tabelpencucian table').length > 0;
        
        if (!hasData) {
            showNotification('warning', 'Perhatian', 'Silakan tampilkan data terlebih dahulu sebelum mencetak');
            return;
        }
        
        $printBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mempersiapkan...').prop('disabled', true);
        
        try {
            const printContent = document.getElementById('printHalaman');
            
            if (!printContent) {
                throw new Error('Konten untuk dicetak tidak ditemukan');
            }

            const iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.top = '-9999px';
            iframe.style.left = '-9999px';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = 'none';
            
            document.body.appendChild(iframe);
            
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            
            const printHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Laporan Pencucian - Pencucian Qenza</title>
                    <style>
                        @page {
                            size: A4 landscape;
                            margin: 1cm;
                        }
                        * {
                            box-sizing: border-box;
                        }
                        body { 
                            font-family: 'Times New Roman', serif; 
                            margin: 0;
                            padding: 20px;
                            color: #333;
                            background: white;
                            font-size: 10px;
                            line-height: 1.3;
                        }
                        .print-header { 
                            text-align: center; 
                            margin-bottom: 25px; 
                            page-break-inside: avoid;
                        }
                        .print-logo-section { 
                            display: flex; 
                            align-items: center; 
                            justify-content: center; 
                            margin-bottom: 15px; 
                            gap: 25px;
                            flex-wrap: wrap;
                        }
                        .print-logo { 
                            height: 70px;
                            max-width: 70px;
                            object-fit: contain;
                        }
                        .print-company-info h1 { 
                            font-size: 18px; 
                            margin: 0; 
                            font-weight: bold; 
                        }
                        .print-company-info p { 
                            font-size: 12px; 
                            margin: 5px 0; 
                        }
                        .print-divider { 
                            border: 1px solid #000; 
                            margin: 12px 0; 
                        }
                        .print-title { 
                            font-size: 16px; 
                            font-weight: bold; 
                            text-decoration: underline; 
                            margin: 12px 0; 
                            text-align: center;
                        }
                        table { 
                            width: 100%; 
                            border-collapse: collapse; 
                            margin: 12px 0;
                            page-break-inside: auto;
                            font-size: 9px;
                        }
                        th, td { 
                            border: 1px solid #000; 
                            padding: 4px 5px; 
                            text-align: left; 
                            vertical-align: top;
                            word-wrap: break-word;
                        }
                        th { 
                            background-color: #f5f5f5; 
                            font-weight: bold; 
                            text-align: center;
                            page-break-inside: avoid;
                            page-break-after: avoid;
                            font-size: 9px;
                        }
                        tr {
                            page-break-inside: avoid;
                        }
                        .print-footer { 
                            display: flex; 
                            justify-content: space-between; 
                            margin-top: 25px;
                            page-break-inside: avoid;
                        }
                        .print-signature { 
                            text-align: center;
                        }
                        .signature-space { 
                            margin-top: 50px;
                        }
                        .table-stats { 
                            border: 1px solid #000;
                            padding: 8px;
                            margin-top: 12px;
                            background-color: #f9f9f9;
                            font-size: 9px;
                        }
                        .loading-container { display: none !important; }
                        .badge,
                        .status-badge {
                            background: #f0f0f0 !important;
                            color: #000 !important;
                            padding: 2px 4px;
                            border: 1px solid #000;
                            border-radius: 0;
                            font-family: 'Times New Roman', serif;
                            font-size: 8px;
                        }
                        .price-display {
                            font-family: 'Courier New', monospace;
                            font-weight: bold;
                        }
                        @media print {
                            body { 
                                margin: 0;
                                padding: 12px;
                                font-size: 9px;
                            }
                            .print-logo-section { 
                                flex-direction: column; 
                                text-align: center;
                                gap: 12px;
                            }
                            .print-logo {
                                height: 50px;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${printContent.innerHTML}
                </body>
                </html>
            `;
            
            iframeDoc.open();
            iframeDoc.write(printHTML);
            iframeDoc.close();
            
            setTimeout(function() {
                try {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                    
                    setTimeout(function() {
                        document.body.removeChild(iframe);
                    }, 1000);
                    
                    $printBtn.html(originalBtnText).prop('disabled', false);
                    showNotification('success', 'Berhasil', 'Dokumen siap untuk dicetak');
                    
                } catch (printError) {
                    document.body.removeChild(iframe);
                    fallbackPrint(printContent, $printBtn, originalBtnText);
                }
            }, 800);
            
        } catch (error) {
            console.error('Print Error:', error);
            $printBtn.html(originalBtnText).prop('disabled', false);
            showNotification('error', 'Gagal Mencetak', 'Terjadi kesalahan saat mempersiapkan dokumen untuk dicetak');
        }
    }
    
    function fallbackPrint(printContent, $printBtn, originalBtnText) {
        try {
            window.print();
            $printBtn.html(originalBtnText).prop('disabled', false);
            showNotification('success', 'Berhasil', 'Dokumen telah dicetak');
        } catch (fallbackError) {
            console.error('Fallback Print Error:', fallbackError);
            $printBtn.html(originalBtnText).prop('disabled', false);
            showNotification('error', 'Gagal Mencetak', 'Browser tidak mendukung fungsi cetak');
        }
    }

    function handleAjaxError(xhr, status, error, container) {
        let errorMessage = 'Terjadi kesalahan saat memuat data';
        
        if (status === 'timeout') {
            errorMessage = 'Koneksi timeout. Silakan coba lagi.';
        } else if (xhr.status === 404) {
            errorMessage = 'Endpoint tidak ditemukan';
        } else if (xhr.status === 500) {
            errorMessage = 'Kesalahan server internal';
        }
        
        container.html(`
            <div class="text-center p-5">
                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 48px; margin-bottom: 20px;"></i>
                <h5 class="text-warning">Gagal Memuat Data</h5>
                <p class="text-muted">${errorMessage}</p>
                <button class="btn btn-warning btn-sm" onclick="ViewLaporanSemua()">
                    <i class="fas fa-redo me-2"></i>Coba Lagi
                </button>
            </div>
        `);
        
        showNotification('error', 'Error', errorMessage);
        console.error('AJAX Error:', xhr, status, error);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function showNotification(type, title, message) {
        const icons = {
            success: 'success',
            error: 'error',
            warning: 'warning',
            info: 'info'
        };
        
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            warning: '#ffc107',
            info: '#17a2b8'
        };
        
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

    $(document).keydown(function(e) {
        if (e.ctrlKey && e.keyCode === 82) {
            e.preventDefault();
            ViewLaporanSemua();
        }
        
        if (e.ctrlKey && e.keyCode === 80) {
            e.preventDefault();
            PrintLaporan();
        }
    });

    $(function () {
        $('[title]').tooltip();
    });
</script>
<?= $this->endSection() ?>
