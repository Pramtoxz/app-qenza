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
    min-width: 920px;
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

.col-nama {
    font-weight: 600;
    color: #2c3e50;
    text-align: left !important;
    width: 200px;
    padding: 15px 12px !important;
}

.col-alamat {
    width: 250px;
    word-wrap: break-word;
    color: #555;
    text-align: left !important;
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    padding: 15px 12px !important;
}

.col-nohp {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #27ae60;
    text-align: center !important;
    width: 130px;
    padding: 15px 12px !important;
}

.col-jk {
    text-align: center !important;
    width: 140px;
    padding: 15px 12px !important;
}

.col-jk .badge {
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    white-space: nowrap;
}

.col-jk .badge-male {
    background: linear-gradient(135deg, #3498db 0%, #5dade2 100%);
    color: white;
}

.col-jk .badge-female {
    background: linear-gradient(135deg, #e74c3c 0%, #ec7063 100%);
    color: white;
}

.col-platnomor {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: #8e44ad;
    text-transform: uppercase;
    text-align: center !important;
    width: 140px;
    font-size: 12px;
    padding: 15px 12px !important;
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
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
    }
    
    .modern-table thead th {
        font-size: 10px;
    }
    
    .col-alamat {
        max-width: 100px;
        font-size: 10px;
    }
    
    .col-nama {
        width: auto;
        min-width: 80px;
    }
    
    .col-nohp {
        width: auto;
        min-width: 90px;
        font-size: 10px;
    }
    
    .col-jk {
        width: auto;
        min-width: 70px;
    }
    
    .col-jk .badge {
        font-size: 8px;
        padding: 4px 6px;
    }
    
    .col-platnomor {
        width: auto;
        min-width: 80px;
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
    
    .table-stats {
        background: white !important;
        border-top: 1px solid #000;
    }
    
    .col-jk .badge {
        background: #f0f0f0 !important;
        color: #000 !important;
        border: 1px solid #000;
    }
}
</style>

<?php if (empty($pelanggan)): ?>
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <h5>Tidak Ada Data Pelanggan</h5>
        <p class="text-muted">Belum ada data pelanggan yang terdaftar dalam sistem.</p>
    </div>
<?php else: ?>
    <div class="modern-table-container">
        <table class="modern-table">
            <thead>
                                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th style="width: 200px; text-align: left;">Nama Pelanggan</th>
                    <th style="width: 250px; text-align: left;">Alamat</th>
                    <th style="width: 130px; text-align: center;">No HP</th>
                    <th style="width: 140px; text-align: center;">Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody>
    <?php $no = 1; ?>
                <?php foreach ($pelanggan as $key => $value): ?>
                <tr>
                    <td class="col-no"><?= $no++ ?></td>
                    <td class="col-nama"><?= esc($value['nama']) ?></td>
                    <td class="col-alamat"><?= esc($value['alamat']) ?></td>
                    <td class="col-nohp"><?= esc($value['nohp']) ?></td>
                    <td class="col-jk">
                        <?php if (strtolower($value['jk']) == 'laki-laki' || strtolower($value['jk']) == 'l'): ?>
                            <span class="badge badge-male">
                                <i class="fas fa-mars me-1"></i>Laki-laki
                            </span>
                        <?php else: ?>
                            <span class="badge badge-female">
                                <i class="fas fa-venus me-1"></i>Perempuan
                            </span>
                        <?php endif; ?>
                    </td>
    </tr>
                <?php endforeach; ?>
            </tbody>
</table>
        
        <div class="table-stats">
            <div class="stats-item">
                <i class="fas fa-users"></i>
                <span><strong>Total Pelanggan:</strong> <?= count($pelanggan) ?> orang</span>
            </div>
            <div class="stats-item">
                <i class="fas fa-calendar"></i>
                <span><strong>Dicetak:</strong> <?= date('d F Y, H:i') ?> WIB</span>
            </div>
        </div>
    </div>
<?php endif; ?>