<nav class="main-header navbar navbar-expand navbar-primary navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Cari..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    <i class="fas fa-user mr-1"></i> Panel Admin
                </span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#profileModal">
                    <i class="fas fa-user mr-2"></i> Profil Saya
                </a>
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#settingsModal">
                    <i class="fas fa-key mr-2"></i> Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('auth/logout') ?>" class="dropdown-item text-danger btnLogout">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user mr-2"></i>Profil Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="rounded-circle bg-navy d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px">
                        <i class="fas fa-user text-white" style="font-size:36px"></i>
                    </div>
                    <h5 class="mt-2 font-weight-bold"><?= session()->get('username') ?? 'Admin' ?></h5>
                    <span class="badge badge-info"><?= ucfirst(session()->get('role') ?? 'admin') ?></span>
                </div>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted" width="120">Username</td><td><?= session()->get('username') ?? '-' ?></td></tr>
                    <tr><td class="text-muted">Email</td><td><?= session()->get('email') ?? '-' ?></td></tr>
                    <tr><td class="text-muted">Status</td><td><span class="badge badge-success">Aktif</span></td></tr>
                    <tr><td class="text-muted">Login Terakhir</td><td><?= date('d M Y H:i') ?></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-key mr-2"></i>Ubah Password</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label>Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" placeholder="Password saat ini" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" placeholder="Min. 6 karakter" required minlength="6">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Ulangi password baru" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="savePasswordBtn">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.toggle-password').on('click', function() {
        var targetId = $(this).data('target');
        var $input = $('#' + targetId);
        var $icon = $(this).find('i');
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
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
        $btn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Menyimpan...').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('auth/change-password') ?>',
            type: 'POST',
            data: { current_password: current, new_password: newPw, confirm_password: confirm },
            success: function(res) {
                $btn.html(orig).prop('disabled', false);
                if (res.status === 'success') {
                    Swal.fire({ title: 'Berhasil', text: 'Password berhasil diubah', icon: 'success', confirmButtonColor: '#0e0e37' }).then(function() {
                        $('#settingsModal').modal('hide');
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
            $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        });
    });
});
</script>
