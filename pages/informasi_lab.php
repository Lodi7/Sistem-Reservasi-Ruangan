<?php

$page = 'informasi_lab';


include __DIR__ . '/../config/config.php';

include __DIR__ . '/../helpers/labs.php';

$labs = getLabs($conn);


?>

<section id="informasi-lab" class="mt-30 px-5 sm:px-15 md:px-25">
    <div class="flex flex-col items-center justify-center text-center max-w-full gap-6.25">
        <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold">Informasi Lab</h1>
        <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed max-w-3xl">Reservasi laboratorium kini
            lebih
            cepat dan praktis. Pilih jadwal, cek ketersediaan, dan booking lab langsung
            secara online</p>
        <div class="grid lg:grid-cols-2 xl:grid-cols-3 grid-cols-1 gap-7.25 items-stretch ">
            <?php
            include __DIR__ .
                '/../components/render_card_labs.php';
            ?>
        </div>
    </div>
</section>