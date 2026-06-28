<style>
/* Modern Table Styles */
.modern-table-container {
    background: white;
    border-radius: 15px;
    overflow-x: auto;
    overflow-y: hidden;
    box-shadow: 0 10px 30px rgba(111, 66, 193, 0.08);
    border: 1px solid rgba(111, 66, 193, 0.1);
    margin: 20px 0;
    -webkit-overflow-scrolling: touch;
}

.modern-table {
    width: 100%;
    min-width: 700px;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
    table-layout: fixed;
}

.modern-table thead {
    background: linear-gradient(135deg, #007bff 0%, #007bff 100%);
    color: white;
}

.modern-table thead th {
    padding: 15px 12px;
    font-weight: 600;
    border: none;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    position: relative;
    vertical-align: middle;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
}

.modern-table thead th:first-child {
    border-top-left-radius: 0;
}

.modern-table thead th:last-child {
    border-top-right-radius: 0;
}

.modern-table thead th::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
}

.modern-table tbody tr {
    background: white;
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(111, 66, 193, 0.08);
}

.modern-table tbody tr:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
    transform: scale(1.01);
    box-shadow: 0 5px 15px rgba(111, 66, 193, 0.1);
}

.modern-table tbody tr:last-child {
    border-bottom: none;
}

.modern-table tbody td {
    padding: 15px 12px;
    border: none;
    vertical-align: middle;
    color: #333;
    font-weight: 500;
    word-wrap: break-word;
}

.modern-table tbody td:first-child {
    text-align: center;
    font-weight: 600;
    color: #007bff;
    background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
    width: 60px;
}

/* Column Specific Styles */
.col-no {
    background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%) !important;
    font-weight: 700 !important;
    color: #007bff !important;
    text-align: center !important;
    font-size: 15px;
    width: 60px;
    padding: 15px 12px !important;
}

.col-id {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #2c3e50;
    text-align: center !important;
    width: 120px;
    font-size: 13px;
    padding: 15px 12px !important;
}

.col-name {
    font-weight: 600;
    color: #2c3e50;
    text-align: center !important;
    width: 150px;
    padding: 15px 12px !important;
}

.col-date {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #e67e22;
    text-align: center !important;
    width: 120px;
    padding: 15px 12px !important;
}

.col-paket {
    font-weight: 600;
    color: #27ae60;
    text-align: left !important;
    width: 150px;
    padding: 15px 12px !important;
}

.col-price {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #e74c3c;
    text-align: center !important;
    width: 140px;
    padding: 15px 12px !important;
}

/* Footer Total Styles */
.total-row {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    border-top: 3px solid #007bff !important;
    color: #000 !important;
    font-weight: 700 !important;
}

.total-row td {
    color: #000 !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    padding: 20px 12px !important;
    border: 1px solid #dee2e6 !important;
}

.total-row .total-empty {
    background: transparent !important;
    border: none !important;
    padding: 20px 12px !important;
}

.total-row .total-final {
    text-align: center !important;
    color: #000 !important;
    font-size: 16px !important;
    font-weight: 700 !important;
    padding: 20px 12px !important;
    border: 1px solid #dee2e6 !important;
}

.total-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.total-label-text {
    font-size: 14px;
    font-weight: 600;
    color: #000;
}

.total-amount-text {
    font-family: 'Courier New', monospace;
    font-size: 18px !important;
    font-weight: 900 !important;
    color: #007bff !important;
}

/* Table Stats */
.table-stats {
    background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
    padding: 15px 20px;
    border-top: 1px solid rgba(111, 66, 193, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #666;
}

.table-stats .stats-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.table-stats .stats-item i {
    color: #007bff;
    font-size: 14px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

.empty-state i {
    font-size: 48px;
    color: #ddd;
    margin-bottom: 20px;
    display: block;
}

.empty-state h5 {
    color: #666;
    margin-bottom: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modern-table {
        font-size: 11px;
        table-layout: auto;
        min-width: 500px;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
    }
    
    .modern-table thead th {
        font-size: 10px;
    }
    
    .col-name,
    .col-id {
        width: auto;
        min-width: 80px;
        font-size: 10px;
    }
    
    .col-price {
        width: auto;
        min-width: 90px;
        font-size: 10px;
    }
    
    .table-stats {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .modern-table-container {
        margin: 10px -15px;
        border-radius: 0;
    }
    
    .modern-table {
        font-size: 11px;
        min-width: 450px;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
    }
}

/* Filter Info Styles */
.filter-info {
    background: linear-gradient(135deg, #eef2ff 0%, #dde4ff 100%);
    border: 1px solid rgba(111, 66, 193, 0.2);
    border-radius: 12px;
    padding: 18px 25px;
    margin: 20px 0;
    text-align: center;
    box-shadow: 0 4px 15px rgba(111, 66, 193, 0.1);
    transition: all 0.3s ease;
}

.filter-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(111, 66, 193, 0.15);
}

.filter-info p {
    margin: 0;
    color: #007bff;
    font-weight: 600;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.filter-info i {
    color: #007bff;
    font-size: 18px;
}

/* Print Styles */
@media print {
    .filter-info {
        background: white !important;
        border: 1px solid #000;
        margin: 10px 0;
    }
    
    .filter-info p {
        color: #000 !important;
    }
    .modern-table-container {
        box-shadow: none;
        border: 1px solid #000;
        overflow: visible;
    }
    
    .modern-table {
        min-width: auto;
        table-layout: auto;
        width: 100%;
        font-size: 12px;
    }
    
    .modern-table thead {
        background: #f0f0f0 !important;
        color: #000 !important;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
        border: 1px solid #000;
    }
    
    .modern-table tbody tr:hover {
        background: white !important;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .total-row {
        background: #f8f9fa !important;
        color: #000 !important;
        border-top: 2px solid #000 !important;
    }
    
    .total-row td {
        color: #000 !important;
        border: 1px solid #000 !important;
    }
    
    .total-row .total-empty {
        border: none !important;
        background: transparent !important;
    }
    
    .total-row .total-final {
        text-align: center !important;
        font-weight: bold !important;
        border: 1px solid #000 !important;
    }
    
    .total-container {
        display: block;
    }
    
    .total-label-text {
        display: block;
        margin-bottom: 3px;
    }
    
    .total-amount-text {
        color: #000 !important;
        font-weight: bold !important;
    }
    
    .table-stats {
        background: white !important;
        border-top: 1px solid #000;
    }
}
</style>

<?php if (empty($selesai)): ?>
    <div class="empty-state">
        <i class="fas fa-car-wash"></i>
        <h5>Tidak Ada Data Transaksi Selesai</h5>
        <p class="text-muted">Belum ada data transaksi selesai yang terdaftar dalam sistem untuk periode yang dipilih.</p>
    </div>
<?php else: ?>
    <!-- Filter Information -->
    <?php if (isset($tglmulai) && isset($tglakhir)): ?>
    <div class="filter-info">
        <p>
            <i class="fas fa-calendar-day mr-2"></i>
            <strong>Periode:</strong> Dari tanggal <?= date('d-m-Y', strtotime($tglmulai)) ?> s/d <?= date('d-m-Y', strtotime($tglakhir)) ?>
        </p>
    </div>
    <?php elseif (isset($bulan) && isset($tahun)): ?>
    <div class="filter-info">
        <p>
            <i class="fas fa-calendar-alt mr-2"></i>
            <strong>Periode:</strong> 
            <?php 
            $bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            echo $bulanNames[$bulan] . ' ' . $tahun;
            ?>
        </p>
    </div>
    <?php else: ?>
    <div class="filter-info">
        <p>
            <i class="fas fa-list mr-2"></i>
            <strong>Periode:</strong> Semua Data Transaksi Selesai
        </p>
    </div>
    <?php endif; ?>
    
    <div class="modern-table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 120px;">ID Selesai</th>
                    <th style="width: 120px;">ID Pencucian</th>
                    <th style="width: 120px;">Plat Nomor</th>
                    <th style="width: 200px;">Nama Pelanggan</th>
                    <th style="width: 140px;">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $totalBayar = 0;
                
                foreach ($selesai as $row): 
                    $totalBayar += $row['totalbayar'];
                ?>
                <tr>
                    <td class="col-no"><?= $no++ ?></td>
                    <td class="col-id"><?= esc($row['idselesai']) ?></td>
                    <td class="col-id"><?= esc($row['idpencucian']) ?></td>
                    <td class="col-id"><?= esc($row['platnomor']) ?></td>
                    <td class="col-name"><?= esc($row['nama_pelanggan']) ?></td>
                    <td class="col-price">Rp <?= number_format($row['totalbayar'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                
                <tr class="total-row">
                    <td class="total-empty"></td>
                    <td class="total-empty"></td>
                    <td class="total-empty"></td>
                    <td class="total-empty"></td>
                    <td class="total-empty"></td>
                    <td class="total-final">
                        <div class="total-container">
                            <span class="total-label-text">Total Keseluruhan:</span>
                            <span class="total-amount-text">Rp <?= number_format($totalBayar, 0, ',', '.') ?></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="table-stats">
            <div class="stats-item">
                <i class="fas fa-check-circle"></i>
                <span><strong>Total Transaksi Selesai:</strong> <?= count($selesai) ?> transaksi</span>
            </div>
            <div class="stats-item">
                <i class="fas fa-money-bill-wave"></i>
                <span><strong>Total Pendapatan:</strong> Rp <?= number_format($totalBayar, 0, ',', '.') ?></span>
            </div>
            <div class="stats-item">
                <i class="fas fa-calendar"></i>
                <span><strong>Dicetak:</strong> <?= date('d F Y, H:i') ?> WIB</span>
            </div>
        </div>
    </div>
<?php endif; ?> 