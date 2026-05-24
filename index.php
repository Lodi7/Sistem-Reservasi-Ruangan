<?php

session_start();

$page = $_GET['page'] ?? 'beranda';


$hideLayoutNavbar = [

];

$hideLayoutFooter = [
    'login',
    'register',
    'lupa_password',
    'verifikasi_otp',
    'reset_password'
];

include 'layouts/header.php';


if (!in_array($page, $hideLayoutNavbar)) {

    include 'components/navbar.php';

}

switch ($page) {

    case 'beranda':
        include 'pages/beranda.php';
        break;

    case 'tentang_kami':
        include 'pages/tentang_kami.php';
        break;

    case 'informasi_lab':
        include 'pages/informasi_lab.php';
        break;

    case 'ajukan_reservasi':
        include 'pages/ajukan_reservasi.php';
        break;

    case 'jadwal_lab':
        include 'pages/jadwal_lab.php';
        break;

    case 'riwayat_reservasi':
        include 'pages/riwayat_reservasi.php';
        break;

    case 'login':
        include 'auth/login.php';
        break;

    case 'register':
        include 'auth/register.php';
        break;

    case 'profile':
        include 'pages/profile.php';
        break;

    case 'logout':
        include 'auth/logout.php';
        break;

    case 'lupa_password':
        include 'auth/lupa_password.php';
        break;

    case 'verifikasi_otp':
        include 'auth/verifikasi_otp.php';
        break;

    case 'reset_password':
        include 'auth/reset_password.php';
        break;

    default:
        include 'pages/404.php';
        break;
}
if (!in_array($page, $hideLayoutFooter)) {

    include 'components/footer.php';

}

include 'layouts/footer.php';

?>