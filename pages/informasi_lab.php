<?php

$page = 'informasi_lab';

$labs = [
    [
        'gambar' => '/assets/images/lab/Lab-PPSTI.png',
        'status' => 'Tersedia',
        'nama' => 'Lab PPSTI',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 60,
        'kapasitas' => 30,
        'lokasi' => 'FIK-II, Lantai 2',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC, Proyektor'
    ],
    [
        'gambar' => '/assets/images/lab/lab-SCR.png',
        'status' => 'Perbaikan',
        'nama' => 'Lab SCR',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 50,
        'kapasitas' => 30,
        'lokasi' => 'FIK-II, Lantai 2',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC'
    ],
    [
        'gambar' => '/assets/images/lab/Lab-Sain-Data.png',
        'status' => 'Non-aktif',
        'nama' => 'Lab Sains Data',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 40,
        'kapasitas' => 30,
        'lokasi' => 'FIK-II, Lantai 2',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC, Proyektor'
    ],
    [
        'gambar' => '/assets/images/lab/Lab-INSYDE.png',
        'status' => 'Tersedia',
        'nama' => 'Lab INSYDE',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 60,
        'kapasitas' => 30,
        'lokasi' => 'FIK-II, Lantai 3',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC'
    ],
    [
        'gambar' => '/assets/images/lab/Lab-MSI.png',
        'status' => 'Tersedia',
        'nama' => 'Lab MSI',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 50,
        'kapasitas' => 20,
        'lokasi' => 'FIK-II, Lantai 3',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC, Proyektor'
    ],
    [
        'gambar' => '/assets/images/lab/Lab-Solusi.png',
        'status' => 'Perbaikan',
        'nama' => 'Lab Solusi',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 40,
        'kapasitas' => 30,
        'lokasi' => 'FIK-II, Lantai 2',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC, Proyektor'
    ],
    [
        'gambar' => '/assets/images/lab/Rekayasa-Data-dan-Bisnis-DIgital.png',
        'status' => 'Tersedia',
        'nama' => 'Lab Lab Rekayasa Data dan Bisnis Digital',
        'kategori' => 'Lab FASILKOM',
        'ukuran' => 60,
        'kapasitas' => 30,
        'lokasi' => 'FIK-II, Lantai 2',
        'jam_buka' => '07:00',
        'jam_tutup' => '15:30',
        'fasilitas' => 'Wi-Fi, Computer, AC, Proyektor'
    ]
];
include __DIR__ . '/../components/navbar.php';
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
                $gambar = $lab['gambar'];
                $status = $lab['status'];
                $nama = $lab['nama'];
                $kategori = $lab['kategori'];
                $ukuran = $lab['ukuran'];
                $kapasitas = $lab['kapasitas'];
                $lokasi = $lab['lokasi'];
                $jam_buka = $lab['jam_buka'];
                $jam_tutup = $lab['jam_tutup'];
                $fasilitas = $lab['fasilitas'];
                include __DIR__ . '/../components/card_lab.php';
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>