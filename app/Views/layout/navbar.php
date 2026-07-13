<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                <div class="dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
                        <img src="<?= base_url() ?>assets/images/user.png" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-sm">
                        <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-2"><?= esc(session()->get('username') ?? 'Admin') ?></h6>
                                <span class="text-secondary-light fw-medium text-sm"><?= ucfirst(esc(session()->get('role') ?? 'admin')) ?></span>
                            </div>
                            <button type="button" class="hover-text-danger">
                                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                            </button>
                        </div>
                        <ul class="to-top-list">
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">
                                    <iconify-icon icon="icon-park-outline:setting-two" class="icon text-xl"></iconify-icon> Ubah Password
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3 btnLogout" href="javascript:void(0)">
                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius-16">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ri-user-line me-2"></i>Profil Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="rounded-circle bg-primary-600 d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px">
                        <iconify-icon icon="solar:user-bold" class="text-white" style="font-size:36px"></iconify-icon>
                    </div>
                    <h5 class="mt-2 fw-bold"><?= session()->get('username') ?? 'Admin' ?></h5>
                    <span class="badge bg-primary-600"><?= ucfirst(session()->get('role') ?? 'admin') ?></span>
                </div>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-secondary-light" width="120">Username</td><td><?= session()->get('username') ?? '-' ?></td></tr>
                    <tr><td class="text-secondary-light">Email</td><td><?= session()->get('email') ?? '-' ?></td></tr>
                    <tr><td class="text-secondary-light">Status</td><td><span class="badge bg-success-600">Aktif</span></td></tr>
                    <tr><td class="text-secondary-light">Login Terakhir</td><td><?= date('d M Y H:i') ?></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius-16">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ri-key-2-line me-2"></i>Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-16">
                        <label class="form-label fw-semibold">Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" placeholder="Password saat ini" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                <i class="ri-eye-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-16">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" placeholder="Min. 6 karakter" required minlength="6">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                <i class="ri-eye-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-16">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Ulangi password baru" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                <i class="ri-eye-line"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="savePasswordBtn">
                    <i class="ri-save-line me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.toggle-password').on('click', function() {
        var targetId = $(this).data('target');
        var $input = $('#' + targetId);
        var $icon = $(this).find('i');
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
        }
    });

    $('#savePasswordBtn').on('click', function() {
        var current = $('#currentPassword').val();
        var newPw = $('#newPassword').val();
        var confirm = $('#confirmPassword').val();

        if (!current || !newPw || !confirm) {
            Swal.fire({ title: 'Error', text: 'Semua field harus diisi', icon: 'error', confirmButtonColor: '#0e0e37' });
            return;
        }
        if (newPw.length < 6) {
            Swal.fire({ title: 'Error', text: 'Password baru minimal 6 karakter', icon: 'error', confirmButtonColor: '#0e0e37' });
            return;
        }
        if (newPw !== confirm) {
            Swal.fire({ title: 'Error', text: 'Konfirmasi password tidak cocok', icon: 'error', confirmButtonColor: '#0e0e37' });
            return;
        }

        var $btn = $(this);
        var orig = $btn.html();
        $btn.html('<i class="ri-loader-4-line me-1"></i>Menyimpan...').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('auth/change-password') ?>',
            type: 'POST',
            data: { current_password: current, new_password: newPw, confirm_password: confirm },
            success: function(res) {
                $btn.html(orig).prop('disabled', false);
                if (res.status === 'success') {
                    Swal.fire({ title: 'Berhasil', text: 'Password berhasil diubah', icon: 'success', confirmButtonColor: '#0e0e37' }).then(function() {
                        bootstrap.Modal.getInstance(document.getElementById('settingsModal')).hide();
                        $('#changePasswordForm')[0].reset();
                    });
                } else {
                    Swal.fire({ title: 'Error', text: res.message || 'Gagal mengubah password', icon: 'error', confirmButtonColor: '#0e0e37' });
                }
            },
            error: function() {
                $btn.html(orig).prop('disabled', false);
                Swal.fire({ title: 'Error', text: 'Terjadi kesalahan sistem', icon: 'error', confirmButtonColor: '#0e0e37' });
            }
        });
    });

    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form').each(function() { this.reset(); });
        $(this).find('.toggle-password').each(function() {
            var $input = $('#' + $(this).data('target'));
            $input.attr('type', 'password');
            $(this).find('i').removeClass('ri-eye-off-line').addClass('ri-eye-line');
        });
    });
});
</script>
