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
    .card-header, .btn, .callout { display: none !important; }
    .report-container { box-shadow: none; border: none; margin: 0; padding: 0; }
}
</style>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>
                Laporan Data Paket Cucian
            </h3>
        </div>
        
        <div class="card-body">
            <!-- Control Panel -->
            <div class="callout callout-info">
                <h5>
                    <i class="fas fa-cog mr-2"></i>
                    Panel Kontrol Laporan
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center">
                            <button class="btn btn-primary mr-2 mb-2" onclick="ViewLaporanSemua()" 
                                    title="Memuat dan menampilkan data paket cucian terbaru (Ctrl+R)">
                                <i class="fas fa-eye mr-2"></i>
                                Tampilkan Laporan
                            </button>
                            <button class="btn btn-success mr-2 mb-2" onclick="PrintLaporan()" 
                                    title="Mencetak laporan dalam format yang siap cetak (Ctrl+P)">
                                <i class="fas fa-print mr-2"></i>
                                Cetak Laporan
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Klik "Tampilkan Laporan" untuk melihat data terbaru
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Container -->
            <div class="report-container" id="printHalaman">
                <div class="print-header">
                    <div class="print-logo-section">
                        <img src="<?= base_url() ?>/assets/img/logoqenza.jpg" alt="Logo Pencucian Qenza" class="print-logo">
                        <div class="print-company-info">
                            <h1>Pencucian Qenza</h1>
                            <p>Sungai jodi, Kec. Lubuk Tarok, Kabupaten Sijunjung, Sumatera Barat 27553</p>
                        </div>
                    </div>
                    <hr class="print-divider">
                    <div class="print-title">Laporan Data Paket Cucian</div>
                </div>
                
                <!-- Table Container -->
                <div class="tabelAset">
                    <div class="loading-container">
                        <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                        <h5>Menunggu Data Laporan</h5>
                        <p class="text-muted">Klik tombol "Tampilkan Laporan" untuk memuat data</p>
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
        const $container = $('.tabelAset');
        $container.html(`
            <div class="loading-container">
                <div style="text-align: center;">
                    <i class="fas fa-chart-line" style="font-size: 48px; margin-bottom: 20px; opacity: 0.7;"></i>
                    <h5>Selamat Datang di Laporan Paket Cucian</h5>
                    <p class="text-muted">Klik tombol "Tampilkan Laporan" untuk memuat data paket cucian terbaru</p>
                </div>
            </div>
        `);
    }

    function ViewLaporanSemua() {
        const $btn = $('.btn-primary');
        const $container = $('.tabelAset');
        const originalBtnText = $btn.html();
        
        $btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Memuat Data...').prop('disabled', true);
        
        $container.html(`
            <div class="loading-container">
                <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
                <h5>Memuat Data Paket Cucian</h5>
                <p class="text-muted">Sedang mengambil data dari server...</p>
            </div>
        `);

        $.ajax({
            type: "GET",
            url: "<?= base_url('laporan-master/paket/view') ?>",
            dataType: "JSON",
            timeout: 30000,
            success: function(response) {
                $btn.html(originalBtnText).prop('disabled', false);
                
                if (response.data) {
                    $container.fadeOut(300, function() {
                        $(this).html(response.data).fadeIn(300);
                    });
                    showNotification('success', 'Data Berhasil Dimuat', 'Data paket cucian telah berhasil ditampilkan');
                } else {
                    $container.html(`
                        <div class="text-center p-5">
                            <i class="fas fa-list fa-3x text-muted mb-3"></i>
                            <h5>Tidak Ada Data</h5>
                            <p class="text-muted">Belum ada data paket cucian yang tersedia</p>
                        </div>
                    `);
                    showNotification('info', 'Data Kosong', 'Belum ada data paket cucian yang tersedia');
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
                            <i class="fas fa-redo mr-2"></i>Coba Lagi
                        </button>
                    </div>
                `);
                
                showNotification('error', 'Error', errorMessage);
                console.error('AJAX Error:', xhr, status, error);
            }
        });
    }

    function PrintLaporan() {
        const $printBtn = $('.btn-success');
        const originalBtnText = $printBtn.html();
        
        const hasData = $('.tabelAset table').length > 0;
        
        if (!hasData) {
            showNotification('warning', 'Perhatian', 'Silakan tampilkan data terlebih dahulu sebelum mencetak');
            return;
        }
        
        $printBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Mempersiapkan...').prop('disabled', true);
        
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
                    <title>Laporan Paket Cucian - Pencucian Qenza</title>
                    <style>
                        @page {
                            size: A4;
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
                            font-size: 12px;
                            line-height: 1.4;
                        }
                        .print-header { 
                            text-align: center; 
                            margin-bottom: 30px; 
                            page-break-inside: avoid;
                        }
                        .print-logo-section { 
                            display: flex; 
                            align-items: center; 
                            justify-content: center; 
                            margin-bottom: 20px; 
                            gap: 30px;
                            flex-wrap: wrap;
                        }
                        .print-logo { 
                            height: 80px;
                            max-width: 80px;
                            object-fit: contain;
                        }
                        .print-company-info h1 { 
                            font-size: 20px; 
                            margin: 0; 
                            font-weight: bold; 
                        }
                        .print-company-info p { 
                            font-size: 14px; 
                            margin: 5px 0; 
                        }
                        .print-divider { 
                            border: 1px solid #000; 
                            margin: 15px 0; 
                        }
                        .print-title { 
                            font-size: 18px; 
                            font-weight: bold; 
                            text-decoration: underline; 
                            margin: 15px 0; 
                            text-align: center;
                        }
                        table { 
                            width: 100%; 
                            border-collapse: collapse; 
                            margin: 15px 0;
                            page-break-inside: auto;
                        }
                        th, td { 
                            border: 1px solid #000; 
                            padding: 6px 8px; 
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
                        }
                        tr {
                            page-break-inside: avoid;
                        }
                        .print-footer { 
                            display: flex; 
                            justify-content: space-between; 
                            margin-top: 30px;
                            page-break-inside: avoid;
                        }
                        .print-signature { 
                            text-align: center;
                        }
                        .signature-space { 
                            margin-top: 60px;
                        }
                        .table-stats { 
                            border: 1px solid #000;
                            padding: 10px;
                            margin-top: 15px;
                            background-color: #f9f9f9;
                        }
                        .loading-container { display: none !important; }
                        .price-tag,
                        .badge-jenis {
                            background: #f0f0f0 !important;
                            color: #000 !important;
                            padding: 4px 8px;
                            border: 1px solid #000;
                            border-radius: 0;
                            font-family: 'Times New Roman', serif;
                        }
                        @media print {
                            body { 
                                margin: 0;
                                padding: 15px;
                            }
                            .print-logo-section { 
                                flex-direction: column; 
                                text-align: center;
                                gap: 15px;
                            }
                            .print-logo {
                                height: 60px;
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
