<?php
$data = [
    [
        'gambar' => '/assets/images/Lab/Rekayasa-Data-dan-Bisnis-Digital.png',
        'title' => 'Ruang Laboratorium',
        'deskripsi' => 'Akses ke ruang laboratorium yang dilengkapi dengan infrastruktur jaringan modern dan meja kerja ergonomis.'
    ],
    [
        'gambar' => '/assets/images/kabel.png',
        'title' => 'Alat Uji Modern',
        'deskripsi' => 'Tersedia berbagai peralatan pendukung penelitian mulai dari perangkat hardware terbaru hingga instrumen modern lainnya.'
    ],
    [
        'gambar' => '/assets/images/ngoding.png',
        'title' => 'Software dan Tool',
        'deskripsi' => 'Setiap unit komputer telah terintegrasi dengan perangkat lunak berlisensi resmi untuk analisis data, simulasi, dan pengembangan program.'
    ]
];
?>

<section class="px-5 sm:px-15 md:px-25 mt-30">
    <div class="flex flex-col items-center text-center justify-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">
            Fasilitas Lab
        </h1>
        <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed mt-4 max-w-3xl">
            LabHub menyediakan layanan sewa lab dengan fasilitas lengkap
            untuk mendukung kegiatan akademik Anda.
        </p>
        <div class="flex mt-7 xl:gap-6.5 gap-4 justify-center xl:flex-row flex-col">
            <?php foreach ($data as $fasilitas): ?>
                <?php
                $title = $fasilitas['title'];
                $gambar = $fasilitas['gambar'];
                $deskripsi = $fasilitas['deskripsi'];
                include __DIR__ . '/../../components/card_fasilitas.php';
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>