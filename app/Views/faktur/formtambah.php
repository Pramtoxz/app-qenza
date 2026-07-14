<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form id="formTambahReservasi" action="<?= site_url('faktur/save') ?>">
                <?= csrf_field() ?>

                <!-- Header: ID + Pelanggan -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">ID Reservasi</label>
                                    <input type="text" id="idreservasi" name="idreservasi" class="form-control" value="<?= $next_id ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label">Pelanggan</label>
                                    <div class="input-group">
                                        <input type="hidden" id="idpelanggan" name="idpelanggan">
                                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder="Pilih Pelanggan" readonly>
                                        <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modalcariPelanggan"><i class="ri-search-line me-1"></i> Cari</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">No HP</label>
                                    <input type="text" id="nohp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" id="alamat" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input: Plat Nomor + Paket + Tambah -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-end g-2">
                            <div class="col-md-3">
                                <label class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                                <input type="text" id="inputPlatnomor" class="form-control" placeholder="Contoh: BA 1234 AA">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-info w-100" type="button" id="btnPilihPaket" disabled>
                                    <i class="ri-add-line me-1"></i> Pilih Paket
                                </button>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Paket Terpilih</label>
                                <input type="text" id="inputPaketDisplay" class="form-control" readonly placeholder="Belum ada paket">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-success w-100" type="button" id="btnTambahKeTable">
                                    <i class="ri-add-line-circle me-1"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table: Daftar Kendaraan -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-car-line me-2"></i>Daftar Kendaraan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th style="width:40px; text-align:center;">No</th>
                                        <th>Plat Nomor</th>
                                        <th>Paket</th>
                                        <th style="width:120px; text-align:right;">Harga</th>
                                        <th style="width:70px; text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelOrderBody">
                                    <tr id="emptyRow">
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="ri-inbox-line fa-2x mb-2 d-block" style="opacity:0.5"></i>
                                            Belum ada kendaraan ditambahkan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Total + Simpan -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-0">Total: <span id="grandTotal" class="text-success fw-bold">Rp 0</span></h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                                    <i class="ri-save-line"></i> Simpan Reservasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pilih Pelanggan -->
    <div class="modal fade" id="modalcariPelanggan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pilih Paket -->
    <div class="modal fade" id="modalcariPaket" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    var orderItems = [];
    var selectedPaket = null;

    function formatRupiah(val) {
        return 'Rp. ' + parseInt(val).toLocaleString('id-ID');
    }

    function renderSelectedPaket() {
        if (!selectedPaket) {
            $('#inputPaketDisplay').val('');
            return;
        }
        $('#inputPaketDisplay').val(selectedPaket.nama + ' (' + formatRupiah(selectedPaket.harga) + ')');
    }

    function renderTable() {
        var tbody = $('#tabelOrderBody');
        tbody.empty();

        if (orderItems.length === 0) {
            tbody.html('<tr id="emptyRow"><td colspan="5" class="text-center text-muted py-4">' +
                '<i class="ri-inbox-line" style="font-size:24px; opacity:0.5;"></i><br>Belum ada kendaraan ditambahkan</td></tr>');
            $('#grandTotal').text('Rp 0');
            return;
        }

        var grandTotal = 0;
        orderItems.forEach(function(item, itemIdx) {
            grandTotal += parseInt(item.paket.harga);
            tbody.append(
                '<tr>' +
                '<td style="text-align:center;">' + (itemIdx + 1) + '</td>' +
                '<td><strong>' + item.platnomor + '</strong></td>' +
                '<td>' + item.paket.nama + ' <span class="text-muted">(' + formatRupiah(item.paket.harga) + ')</span></td>' +
                '<td style="text-align:right;"><strong>' + formatRupiah(item.paket.harga) + '</strong></td>' +
                '<td style="text-align:center;"><button type="button" class="btn btn-danger btn-sm btnHapusOrder" data-idx="' + itemIdx + '"><i class="ri-delete-bin-line" style="font-size:11px;"></i></button></td>' +
                '</tr>'
            );
        });

        $('#grandTotal').text(formatRupiah(grandTotal));
    }

    // Pilih Pelanggan
    $('#modalcariPelanggan').on('show.bs.modal', function() {
        $(this).find('.modal-body').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
        $.get('<?= site_url('faktur/getpelanggan') ?>', function(data) {
            $('#modalcariPelanggan .modal-body').html(data);
        });
    });

    $(document).on('click', '.btn-pilihpelanggan', function() {
        $('#idpelanggan').val($(this).data('idpelanggan'));
        $('#nama_pelanggan').val($(this).data('nama_pelanggan'));
        $('#nohp').val($(this).data('nohp'));
        $('#alamat').val($(this).data('alamat'));
        $('#modalcariPelanggan').modal('hide');
    });

    // Toggle tombol Pilih Paket berdasarkan plat nomor
    $('#inputPlatnomor').on('input', function() {
        $('#btnPilihPaket').prop('disabled', !$(this).val().trim());
    });

    // Pilih Paket
    $('#btnPilihPaket').click(function() {
        $('#modalcariPaket .modal-body').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
        $('#modalcariPaket').modal('show');
        $.get('<?= site_url('faktur/getpaket') ?>', function(data) {
            $('#modalcariPaket .modal-body').html(data);
        });
    });

    $(document).on('click', '.btn-pilihpaket', function() {
        selectedPaket = {
            id: $(this).data('idpaket'),
            nama: $(this).data('namapaket'),
            harga: $(this).data('harga'),
            jenis: $(this).data('jenis')
        };
        renderSelectedPaket();
        $('#modalcariPaket').modal('hide');
    });


    // Tambah ke table
    $('#btnTambahKeTable').click(function() {
        var platnomor = $('#inputPlatnomor').val().trim().toUpperCase();
        if (!platnomor) {
            Swal.fire('Peringatan', 'Isi plat nomor terlebih dahulu', 'warning');
            $('#inputPlatnomor').focus();
            return;
        }
        if (!selectedPaket) {
            Swal.fire('Peringatan', 'Pilih paket terlebih dahulu', 'warning');
            return;
        }

        orderItems.push({
            platnomor: platnomor,
            paket: JSON.parse(JSON.stringify(selectedPaket))
        });

        selectedPaket = null;
        renderSelectedPaket();
        renderTable();
    });

    // Enter di plat nomor
    $('#inputPlatnomor').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            if (selectedPaket) {
                $('#btnTambahKeTable').click();
            } else {
                $('#btnPilihPaket').click();
            }
        }
    });

    // Hapus dari table
    $(document).on('click', '.btnHapusOrder', function() {
        orderItems.splice($(this).data('idx'), 1);
        renderTable();
    });

    // Simpan
    $('#formTambahReservasi').submit(function(e) {
        e.preventDefault();

        var idpelanggan = $('#idpelanggan').val();
        if (!idpelanggan) {
            Swal.fire('Peringatan', 'Pilih pelanggan terlebih dahulu', 'warning');
            return;
        }
        if (orderItems.length === 0) {
            Swal.fire('Peringatan', 'Tambahkan minimal 1 kendaraan', 'warning');
            return;
        }

        // Group by platnomor untuk kirim ke server
        var kendaraanMap = {};
        orderItems.forEach(function(item) {
            if (!kendaraanMap[item.platnomor]) {
                kendaraanMap[item.platnomor] = [];
            }
            kendaraanMap[item.platnomor].push(item.paket.id);
        });

        var kendaraan = Object.keys(kendaraanMap).map(function(plat) {
            return { platnomor: plat, paket: kendaraanMap[plat] };
        });

        var postData = {
            idreservasi: $('#idreservasi').val(),
            idpelanggan: idpelanggan,
            kendaraan: kendaraan
        };

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: JSON.stringify(postData),
            contentType: 'application/json',
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('<i class="ri-loader-4-line"></i> Tunggu').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('<i class="ri-save-line"></i> Simpan Reservasi').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    var err = typeof response.error === 'string' ? response.error : Object.values(response.error).join('<br>');
                    Swal.fire('Gagal!', err, 'warning');
                    return;
                }
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.sukses,
                        timer: 2000,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    }).then(function() {
                        window.location.href = '<?= site_url('faktur/cetakAntrian/') ?>' + response.idreservasi;
                    });
                }
            },
            error: function(e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan: ' + e.responseText });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
