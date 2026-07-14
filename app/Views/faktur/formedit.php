<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form id="formEditFaktur" action="<?= site_url('faktur/updatedata/' . $faktur['idreservasi']) ?>">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="idreservasi" class="form-label">ID Faktur</label>
                            <input type="text" id="idreservasi" name="idreservasi" class="form-control" value="<?= $faktur['idreservasi'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label for="idpelanggan" class="form-label">Pelanggan</label>
                            <div class="input-group">
                                <input type="hidden" id="idpelanggan" name="idpelanggan" value="<?= $faktur['idpelanggan'] ?>">
                                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="<?= $faktur['nama_pelanggan'] ?>" readonly>
                                <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modalcariPelanggan"><i class="ri-search-line me-1"></i> Cari</button>
                                <div class="invalid-feedback error_idpelanggan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" id="nohp" class="form-control" value="<?= $faktur['nohp'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" id="alamat" class="form-control" value="<?= $faktur['alamat'] ?>" readonly>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="ri-car-line me-2"></i>Daftar Kendaraan</h5>
                    <button type="button" class="btn btn-success btn-sm" id="btnTambahKendaraan">
                        <i class="ri-add-line me-1"></i> Tambah Kendaraan
                    </button>
                </div>

                <div id="kendaraanContainer">
                    <?php foreach ($kendaraan as $i => $k): ?>
                        <div class="card mb-3 kendaraan-row" data-index="<?= $i ?>" id="kendaraan_<?= $i ?>">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="ri-car-line me-1"></i> Kendaraan #<?= $i + 1 ?>
                                    <?php if ($k['status'] != 'pending'): ?>
                                        <span class="badge bg-warning ms-2"><?= ucfirst($k['status']) ?></span>
                                    <?php endif; ?>
                                </h6>
                                <?php if ($k['status'] == 'pending'): ?>
                                    <button type="button" class="btn btn-danger btn-sm btnHapusKendaraan" data-index="<?= $i ?>">
                                        <i class="ri-delete-bin-line"></i> Hapus
                                    </button>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><small>Tidak dapat dihapus</small></span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="mb-3">
                                            <label class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                                            <input type="text" name="kendaraan[<?= $i ?>][platnomor]" class="form-control platnomor-input" value="<?= $k['platnomor'] ?>" <?= $k['status'] != 'pending' ? 'readonly' : '' ?>>
                                            <input type="hidden" name="kendaraan[<?= $i ?>][id]" value="<?= $k['id'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="mb-3">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <?php if ($k['status'] == 'pending'): ?>
                                                    <button type="button" class="btn btn-info btnPilihPaket" data-index="<?= $i ?>">
                                                        <i class="ri-add-line me-1"></i> Pilih Paket
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="paket-list" id="paketList_<?= $i ?>">
                                    <?php if (!empty($k['paket_list'])): ?>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php foreach ($k['paket_list'] as $pi => $p): ?>
                                                <span class="badge bg-primary d-flex align-items-center gap-1 px-3 py-2">
                                                    <?= $p['namapaket'] ?> (Rp <?= number_format($p['harga'], 0, ',', '.') ?>)
                                                    <input type="hidden" name="kendaraan[<?= $i ?>][paket][]" value="<?= $p['idpaket'] ?>">
                                                    <?php if ($k['status'] == 'pending'): ?>
                                                        <button type="button" class="btn-close btn-close-white btnHapusPaket" data-idx="<?= $i ?>" data-pi="<?= $pi ?>" style="font-size:0.6em"></button>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted small">Belum ada paket dipilih</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mb-3 text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg" id="tombolSimpan">
                        <i class="ri-save-line"></i> Update Faktur
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalcariPelanggan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalcariPaket" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPaketTitle">Pilih Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        var kendaraanIndex = <?= count($kendaraan) ?>;
        var activeKendaraanIndex = -1;

        function formatRupiah(value) {
            if (!value) return '';
            const cleanValue = value.toString().replace(/[^0-9]/g, '');
            if (cleanValue === '') return '';
            const number = parseInt(cleanValue, 10);
            if (isNaN(number) || number === 0) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        // Initialize paket data from existing kendaraan
        <?php foreach ($kendaraan as $i => $k): ?>
            <?php if (!empty($k['paket_list'])): ?>
                var paketData_<?= $i ?> = [
                    <?php foreach ($k['paket_list'] as $p): ?>
                        { id: '<?= $p['idpaket'] ?>', nama: '<?= addslashes($p['namapaket']) ?>', harga: <?= $p['harga'] ?>, jenis: '<?= addslashes($p['jenis'] ?? '') ?>' },
                    <?php endforeach; ?>
                ];
                $('#paketList_<?= $i ?>').data('paket', paketData_<?= $i ?>);
            <?php endif; ?>
        <?php endforeach; ?>

        function addKendaraanRow() {
            var idx = kendaraanIndex++;
            var html = `
                <div class="card mb-3 kendaraan-row" data-index="${idx}" id="kendaraan_${idx}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="ri-car-line me-1"></i> Kendaraan #${idx + 1}</h6>
                        <button type="button" class="btn btn-danger btn-sm btnHapusKendaraan" data-index="${idx}">
                            <i class="ri-delete-bin-line"></i> Hapus
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                                    <input type="text" name="kendaraan[${idx}][platnomor]" class="form-control platnomor-input" placeholder="Contoh: BA 1234 AA" required>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="button" class="btn btn-info btnPilihPaket" data-index="${idx}">
                                            <i class="ri-add-line me-1"></i> Pilih Paket
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="paket-list" id="paketList_${idx}">
                            <p class="text-muted small">Belum ada paket dipilih</p>
                        </div>
                    </div>
                </div>
            `;
            $('#kendaraanContainer').append(html);
        }

        function renderPaketList(idx) {
            var container = $(`#paketList_${idx}`);
            var paketData = container.data('paket') || [];
            if (paketData.length === 0) {
                container.html('<p class="text-muted small">Belum ada paket dipilih</p>');
                return;
            }
            var html = '<div class="d-flex flex-wrap gap-2">';
            paketData.forEach(function(p, i) {
                html += `<span class="badge bg-primary d-flex align-items-center gap-1 px-3 py-2">
                    ${p.nama} (${formatRupiah(p.harga)})
                    <input type="hidden" name="kendaraan[${idx}][paket][]" value="${p.id}">
                    <button type="button" class="btn-close btn-close-white btnHapusPaket" data-idx="${idx}" data-pi="${i}" style="font-size:0.6em"></button>
                </span>`;
            });
            html += '</div>';
            container.html(html);
        }

        $('#btnTambahKendaraan').click(function() {
            addKendaraanRow();
        });

        $(document).on('click', '.btnHapusKendaraan', function() {
            var idx = $(this).data('index');
            var count = $('.kendaraan-row').length;
            if (count <= 1) {
                Swal.fire('Peringatan', 'Minimal harus ada 1 kendaraan', 'warning');
                return;
            }
            $(`#kendaraan_${idx}`).remove();
        });

        $(document).on('click', '.btnPilihPaket', function() {
            activeKendaraanIndex = $(this).data('index');
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            $('#modalcariPaket .modal-body').html(loader);
            $('#modalcariPaket').modal('show');
            $.get('<?= site_url('faktur/getpaket') ?>', function(data) {
                $('#modalcariPaket .modal-body').html(data);
            });
        });

        $(document).on('click', '.btn-pilihpaket', function() {
            if (activeKendaraanIndex < 0) return;
            var idx = activeKendaraanIndex;
            var container = $(`#paketList_${idx}`);
            var paketData = container.data('paket') || [];

            var idpaket = $(this).data('idpaket');
            var exists = paketData.some(function(p) { return p.id == idpaket; });
            if (exists) {
                Swal.fire('Info', 'Paket sudah dipilih untuk kendaraan ini', 'info');
                return;
            }

            paketData.push({
                id: idpaket,
                nama: $(this).data('namapaket'),
                harga: $(this).data('harga'),
                jenis: $(this).data('jenis')
            });
            container.data('paket', paketData);
            renderPaketList(idx);
            $('#modalcariPaket').modal('hide');
        });

        $(document).on('click', '.btnHapusPaket', function() {
            var idx = $(this).data('idx');
            var pi = $(this).data('pi');
            var container = $(`#paketList_${idx}`);
            var paketData = container.data('paket') || [];
            paketData.splice(pi, 1);
            container.data('paket', paketData);
            renderPaketList(idx);
        });

        $('#modalcariPelanggan').on('show.bs.modal', function() {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);
            $.get('<?= site_url('faktur/getpelanggan') ?>', function(data) {
                $('#modalcariPelanggan .modal-body').html(data);
            });
        });

        $(document).on('click', '.btn-pilihpelanggan', function() {
            $('#idpelanggan').val($(this).data('idpelanggan'));
            $('#nama_pelanggan').val($(this).data('nama_pelanggan'));
            $('#alamat').val($(this).data('alamat'));
            $('#nohp').val($(this).data('nohp'));
            $('#modalcariPelanggan').modal('hide');
        });

        $('#formEditFaktur').submit(function(e) {
            e.preventDefault();

            var idpelanggan = $('#idpelanggan').val();
            if (!idpelanggan) {
                Swal.fire('Peringatan', 'Pilih pelanggan terlebih dahulu', 'warning');
                return;
            }

            var kendaraan = [];
            var valid = true;
            $('.kendaraan-row').each(function() {
                var idx = $(this).data('index');
                var platnomor = $(this).find('.platnomor-input').val().trim();
                var container = $(`#paketList_${idx}`);
                var paketData = container.data('paket') || [];
                var paketIds = paketData.map(function(p) { return p.id; });
                var existingId = $(this).find('input[name="kendaraan[' + idx + '][id]"]').val();

                if (!platnomor) {
                    Swal.fire('Peringatan', 'Plat nomor kendaraan #' + (idx + 1) + ' harus diisi', 'warning');
                    valid = false;
                    return false;
                }
                if (paketIds.length === 0) {
                    Swal.fire('Peringatan', 'Pilih minimal 1 paket untuk kendaraan #' + (idx + 1), 'warning');
                    valid = false;
                    return false;
                }
                var item = { platnomor: platnomor, paket: paketIds };
                if (existingId) item.id = existingId;
                kendaraan.push(item);
            });

            if (!valid) return;
            if (kendaraan.length === 0) {
                Swal.fire('Peringatan', 'Minimal harus ada 1 kendaraan', 'warning');
                return;
            }

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
                    $('#tombolSimpan').html('<i class="ri-save-line"></i> Update Faktur').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        var err = response.error;
                        if (typeof err === 'string') {
                            Swal.fire('Gagal!', err, 'warning');
                        } else {
                            var msgs = Object.values(err).join('<br>');
                            Swal.fire('Validasi!', msgs, 'warning');
                        }
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
                            window.location.href = '<?= site_url('faktur') ?>';
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
