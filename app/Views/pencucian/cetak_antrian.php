<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .ticket {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 2px dashed #007bff;
        }
        
        .ticket-header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .ticket-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .ticket-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        
        .ticket-body {
            padding: 30px 20px;
            text-align: center;
        }
        
        .queue-number {
            font-size: 72px;
            font-weight: bold;
            color: #007bff;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .queue-label {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 30px;
        }
        
        .info-section {
            text-align: left;
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
        }
        
        .estimation {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        
        .estimation-time {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .estimation-note {
            font-size: 12px;
            color: #6c757d;
            font-style: italic;
        }
        
        .footer-note {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
        
        .print-button {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
        }
        
        .print-button:hover {
            background: #218838;
        }
        
        .back-button {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 10px;
            text-decoration: none;
            display: inline-block;
        }
        
        .back-button:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .ticket {
                box-shadow: none;
                border: 1px solid #000;
            }
            .print-button, .back-button {
                display: none;
            }
        }
        
        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            letter-spacing: 2px;
            background: #000;
            color: #fff;
            padding: 5px 10px;
            margin: 10px 0;
            border-radius: 3px;
        }
    </style>
    <div class="ticket">
        <div class="ticket-header">
            <h1>OTOBIZZ</h1>
            <p>Car Wash & Detailing</p>
        </div>
        
        <div class="ticket-body">
            <div class="queue-number"><?= str_pad($pencucian['nomor_antrian'], 2, '0', STR_PAD_LEFT) ?></div>
            <div class="queue-label">NOMOR ANTRIAN</div>
            
            <div class="barcode"><?= $pencucian['idpencucian'] ?></div>
            
            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">Nama Pelanggan:</span>
                    <span class="info-value"><?= esc($pencucian['nama_pelanggan']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Plat Nomor:</span>
                    <span class="info-value"><?= esc($pencucian['platnomor']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Paket:</span>
                    <span class="info-value"><?= esc($pencucian['namapaket']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Harga:</span>
                    <span class="info-value">Rp <?= number_format($pencucian['harga'], 0, ',', '.') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($pencucian['tgl'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jam Datang:</span>
                    <span class="info-value"><?= date('H:i', strtotime($pencucian['jamdatang'])) ?></span>
                </div>
            </div>
            
            <div class="estimation">
                <div class="estimation-note">
                    <?php if($antrian_sebelum > 0): ?>
                        Ada <?= $antrian_sebelum ?> antrian sebelum Anda
                    <?php else: ?>
                        Antrian berikutnya akan diproses
                    <?php endif; ?>
                </div>
            </div>
            
            <a href="<?= site_url('pencucian') ?>" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button class="print-button" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Tiket
            </button>
        </div>
        
        <div class="footer-note">
            <p><strong>Simpan tiket ini sebagai bukti antrian</strong></p>
            <p>Hubungi kami jika ada pertanyaan: 0812-3456-7890</p>
            <p>Terima kasih telah mempercayakan kendaraan Anda kepada kami!</p>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // Auto focus untuk memudahkan print
    $(document).ready(function() {
        $('.print-button').focus();
    });
    
    // Keyboard shortcut untuk print
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 'p') {
            event.preventDefault();
            window.print();
        }
    });
</script>
<?= $this->endSection() ?>
