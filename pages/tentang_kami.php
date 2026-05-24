<?php

$page = 'tentang_kami';

$sections = [
    'hero',
    'content_tentang_kami'
];

foreach ($sections as $section) {

    include __DIR__ . "/../sections//tentang-kami/{$section}.php";

}
?>