<?php

ob_start();
session_start();

include __DIR__ . '/../middleware/admin.php';

$page = $_GET['page'] ?? 'dashboard';

include __DIR__ . '/../layouts/header_admin.php';
include __DIR__ . '/../components/navbar_admin.php';

switch ($page) {

    case 'dashboard':
        include __DIR__ . '/pages/dashboard.php';
        break;

    case 'kelola_permohonan':
        include __DIR__ . '/pages/kelola_permohonan.php';
        break;

    case 'detail_reservasi':
        include __DIR__ . '/pages/detail_reservasi.php';
        break;

    case 'riwayat_permohonan':
        include __DIR__ . '/pages/riwayat_permohonan.php';
        break;

    case 'reservasi_hari_ini':
        include __DIR__ . '/pages/reservasi_hari_ini.php';
        break;

    case 'manajemen_operasional':
        include __DIR__ . '/pages/manajemen_operasional.php';
        break;

    case 'ubah_profile':
        include __DIR__ . '/pages/ubah_profile.php';
        break;

    case 'ubah_password':
        include __DIR__ . '/../pages/ubah_password.php';
        break;

    case 'logout':
        include __DIR__ . '/../auth/logout.php';
        break;

    default:
        include __DIR__ . '/../pages/404.php';
        break;

}

include __DIR__ . '/../layouts/footer_admin.php';

?>