<?php

$page = 'informasi_lab';

include __DIR__ . "/../config/config.php";

$query = mysqli_query(
    $conn,
    "SELECT *
    FROM labs"
);

$labs = [];

while (
    $lab = mysqli_fetch_assoc($query)
) {
    $lokasi =
        str_replace(

            [
                'Gedung ',
                ' UPNVJT'
            ],

            '',

            $lab['lokasi']

        );

    $fasilitas_raw =
        explode(
            ",",
            $lab['fasilitas']
        );

    $fasilitas =
        array_slice(
            $fasilitas_raw,
            0,
            3
        );

    $fasilitas =
        array_map(

            function ($item) {

                return preg_replace(
                    '/^\d+\s*/',
                    '',
                    trim($item)
                );

            },

            $fasilitas

        );

    $labs[] = [
        'id' => $lab['id'],
        'slug' => $lab['slug'],
        'nama' =>
            $lab['nama_lab'],

        'gambar' =>
            $lab['gambar'],

        'status' =>
            $lab['status'],

        'kategori' =>
            $lab['kategori'],

        'luas' =>
            $lab['luas'],

        'kapasitas' =>
            $lab['kapasitas'],

        'lokasi' =>
            $lokasi,

        'jam_buka' =>
            substr(
                $lab['jam_buka'],
                0,
                5
            ),

        'jam_tutup' =>
            substr(
                $lab['jam_tutup'],
                0,
                5
            ),

        'fasilitas' =>
            $fasilitas

    ];
}

?>
<section id="informasi-lab" class="mt-30 px-5 sm:px-15 md:px-25">
    <div class="flex flex-col items-center justify-center text-center max-w-full gap-6.25">
        <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold">Informasi Lab</h1>
        <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed max-w-3xl">Reservasi laboratorium kini
            lebih
            cepat dan praktis. Pilih jadwal, cek ketersediaan, dan booking lab langsung
            secara online</p>
        <div class="grid lg:grid-cols-2 xl:grid-cols-3 grid-cols-1 gap-7.25 items-stretch ">
            <?php foreach ($labs as $lab): ?>
                <?php
                $id = $lab['id'];
                $nama = $lab['nama'];
                $gambar = $lab['gambar'];
                $status = $lab['status'];
                $kategori =
                    $lab['kategori'];

                $luas =
                    $lab['luas'];

                $kapasitas =
                    $lab['kapasitas'];

                $lokasi =
                    $lab['lokasi'];

                $jam_buka =
                    $lab['jam_buka'];

                $jam_tutup =
                    $lab['jam_tutup'];

                $fasilitas =
                    $lab['fasilitas'];
                $slug = $lab['slug'];

                include __DIR__ . '/../components/card_lab.php'
                    ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>