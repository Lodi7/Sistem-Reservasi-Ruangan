<?php

$page = 'beranda';

$sections = [
    'hero',
    'tentang_kami',
    'informasi_lab',
    'fasilitas_lab',
    'status_lab'
];

include __DIR__ . '/../components/navbar.php';

foreach ($sections as $section) {

    include __DIR__ . "/../sections//beranda/{$section}.php";

}
?>