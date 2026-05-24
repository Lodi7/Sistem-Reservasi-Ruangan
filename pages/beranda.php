<?php

$page = 'beranda';

$sections = [
    'hero',
    'tentang_kami',
    'informasi_lab',
    'fasilitas_lab',
    'status_lab'
];

foreach ($sections as $section) {

    include __DIR__ . "/../sections//beranda/{$section}.php";

}
?>