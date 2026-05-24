<?php
$articles = [
    [
        'title' => 'Solusi Reservasi Laboratorium yang Lebih Praktis',
        'deskripsi' => 'Website Reservasi Lab Informatika FASILKOM UPN Veteran Jawa Timur dibuat untuk mempermudah proses pemesanan laboratorium secara online. Dengan sistem ini, pengguna dapat melihat jadwal, mengecek ketersediaan lab, dan melakukan reservasi dengan lebih cepat, mudah, dan terorganisir. Website ini hadir sebagai solusi digital untuk menggantikan proses reservasi manual yang sering kali memerlukan waktu lebih lama dan berisiko menyebabkan bentroknya jadwal penggunaan laboratorium. Melalui platform ini, seluruh proses peminjaman dapat dilakukan dalam satu sistem yang terintegrasi sehingga pengguna tidak perlu lagi melakukan pengecekan secara langsung ke laboratorium. Selain membantu mahasiswa dalam melakukan reservasi, website ini juga membantu pihak pengelola laboratorium dalam mengatur jadwal, memantau penggunaan ruangan, serta mengelola data reservasi dengan lebih rapi dan efisien. Dengan tampilan antarmuka yang modern, responsif, dan mudah dipahami, sistem ini diharapkan dapat memberikan pengalaman penggunaan yang nyaman sekaligus mendukung kegiatan akademik dan praktikum di lingkungan FASILKOM UPN Veteran Jawa Timur secara lebih efektif dan terstruktur.'
    ],
    [
        'title' => 'Akses Mudah dalam Satu Platform',
        'deskripsi' => 'Mulai dari melihat ketersediaan ruangan, melakukan reservasi, hingga mengecek riwayat penggunaan laboratorium, semuanya dapat dilakukan langsung melalui website ini. Dengan tampilan yang sederhana dan responsif, pengguna dapat mengakses layanan kapan saja tanpa kesulitan.'
    ],
    [
        'title' => 'Pengelolaan Data yang Lebih Terorganisir dan Efisien',
        'deskripsi' => 'Sistem ini dirancang bukan hanya untuk mempermudah pengguna, tetapi juga membantu admin dalam mengelola data reservasi dengan lebih rapi. Setiap jadwal, riwayat peminjaman, dan aktivitas pengguna tersimpan secara sistematis sehingga proses monitoring laboratorium menjadi lebih efektif, minim bentrok jadwal, dan lebih efisien untuk digunakan dalam lingkungan kampus modern.'
    ]
];
?>

<article class="mt-12.5 flex gap-12.25 flex-col px-5 sm:px-15 md:px-25">
    <?php foreach ($articles as $article): ?>
        <section class="px-10 sm:px-15.25 xl:px-40.25 ">
            <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold ">
                <?= $article['title'] ?>
            </h1>
            <P class="text-justify text-sm sm:text-base md:text-lg lg:text-xl  leading-relaxed mt-5">
                <?= $article['deskripsi'] ?>
            </P>
        </section>
    <?php endforeach; ?>
</article>