<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-Qenza <?= $title ?? '' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/favicon.png" sizes="16x16">
    <?php include(APPPATH . 'Views/assets/css.php') ?>
</head>

<body>
    <aside class="sidebar">
        <button type="button" class="sidebar-close-btn">
            <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
        </button>
        <div>
            <a href="<?= base_url('/') ?>" class="sidebar-logo">
                <img src="<?= base_url() ?>assets/images/sidebar.png" alt="site logo" class="light-logo">
                <img src="<?= base_url() ?>assets/images/logo-light.png" alt="site logo" class="dark-logo">
                <img src="<?= base_url() ?>assets/images/logo-icon.png" alt="site logo" class="logo-icon">
            </a>
        </div>
        <div class="sidebar-menu-area">
            <?= $this->include('layout/sidebar') ?>
        </div>
    </aside>

    <main class="dashboard-main">
        <?= $this->include('layout/navbar') ?>

        <div class="dashboard-main-body">
            <?= $this->renderSection('content') ?>
        </div>

        <?= $this->include('layout/footer') ?>
    </main>

    <?php include(APPPATH . 'Views/assets/js.php') ?>

    <script>
    $(document).on('click', '.btnLogout', function() {
        Swal.fire({
            title: "Apakah anda yakin ingin keluar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                setTimeout(function() {
                    window.location.href = '<?= site_url('auth/logout') ?>';
                }, 1000);
            }
        });
    });

    $('.select2').select2()
    </script>

    <?= $this->renderSection('script') ?>
</body>

</html>
