<?php

$page = 'tentang_kami';

$sections = [
    'hero',
    'content_tentang_kami'
];

include __DIR__ . '/../components/navbar.php';

foreach ($sections as $section) {

    include __DIR__ . "/../sections//tentang-kami/{$section}.php";

}
?>