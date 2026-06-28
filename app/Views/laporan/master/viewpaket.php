<style>
/* Modern Table Styles */
.modern-table-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(111, 66, 193, 0.08);
    border: 1px solid rgba(111, 66, 193, 0.1);
    margin: 20px 0;
}

.modern-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

.modern-table thead {
    background: linear-gradient(135deg, #007bff 0%, #007bff 100%);
    color: white;
}

.modern-table thead th {
    padding: 18px 15px;
    font-weight: 600;
    text-align: center;
    border: none;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    position: relative;
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
    padding: 15px;
    border: none;
    vertical-align: middle;
    color: #333;
    font-weight: 500;
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
}

.col-nama {
    font-weight: 600;
    color: #2c3e50;
}

.col-alamat {
    max-width: 200px;
    word-wrap: break-word;
    color: #555;
}

.col-nohp {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #27ae60;
}

.col-jk {
    text-align: center;
}

.col-jk .badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.col-jk .badge-male {
    background: linear-gradient(135deg, #3498db 0%, #5dade2 100%);
    color: white;
}

.col-jk .badge-female {
    background: linear-gradient(135deg, #e74c3c 0%, #ec7063 100%);
    color: white;
}

.col-harga {
    text-align: center;
}

.col-harga .price-tag {
    background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    font-family: 'Courier New', monospace;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.col-jenis {
    text-align: center;
}

.col-jenis .badge-jenis {
    background: linear-gradient(135deg, #007bff 0%, #007bff 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(111, 66, 193, 0.3);
}

.col-keterangan {
    max-width: 250px;
    word-wrap: break-word;
    color: #555;
    font-style: italic;
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
        font-size: 12px;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 10px 8px;
    }
    
    .col-alamat {
        max-width: 120px;
        font-size: 11px;
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
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
    }
}

/* Print Styles */
@media print {
    .modern-table-container {
        box-shadow: none;
        border: 1px solid #000;
    }
    
    .modern-table thead {
        background: #f0f0f0 !important;
        color: #000 !important;
    }
    
    .modern-table tbody tr:hover {
        background: white !important;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .table-stats {
        background: white !important;
        border-top: 1px solid #000;
    }
}
</style>

<?php if (empty($paket)): ?>
    <div class="empty-state">
        <i class="fas fa-list"></i>
        <h5>Tidak Ada Data Paket Cucian</h5>
        <p class="text-muted">Belum ada data paket cucian yang terdaftar dalam sistem.</p>
    </div>
<?php else: ?>
    <div class="modern-table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Paket</th>
                    <th>Harga</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($paket as $key => $value): ?>
                <tr>
                    <td class="col-no"><?= $no++ ?></td>
                    <td class="col-nama"><?= esc($value['namapaket']) ?></td>
                    <td class="col-harga">
                        <span class="price-tag">
                            Rp <?= number_format($value['harga'], 0, ',', '.') ?>
                        </span>
                    </td>
                    <td class="col-jenis">
                        <span class="badge badge-jenis">
                            <i class="fas fa-tag mr-1"></i><?= esc($value['jenis']) ?>
                        </span>
                    </td>
                    <td class="col-keterangan"><?= esc($value['keterangan']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="table-stats">
            <div class="stats-item">
                <i class="fas fa-list"></i>
                <span><strong>Total Paket:</strong> <?= count($paket) ?> paket</span>
            </div>
            <div class="stats-item">
                <i class="fas fa-calendar"></i>
                <span><strong>Dicetak:</strong> <?= date('d F Y, H:i') ?> WIB</span>
            </div>
        </div>
    </div>
<?php endif; ?>