<?php
$articles = [
    [
        'title' => 'Solusi Reservasi Laboratorium yang Lebih Praktis',
        'deskripsi' => 'LabHub merupakan website reservasi laboratorium yang dirancang untuk mempermudah proses peminjaman laboratorium di lingkungan Fakultas Ilmu Komputer (FASILKOM) UPN Veteran Jawa Timur. Melalui website ini, pengguna dapat memperoleh informasi mengenai laboratorium yang tersedia, melihat jadwal penggunaan, serta melakukan reservasi secara lebih mudah dan terorganisir. Kehadiran LabHub diharapkan dapat membantu mengurangi kendala yang sering terjadi pada proses reservasi secara manual, seperti kesulitan memperoleh informasi dan bentroknya jadwal penggunaan laboratorium. Selain memberikan kemudahan bagi mahasiswa dan dosen, website ini juga mendukung pengelolaan laboratorium agar menjadi lebih tertata. Dengan demikian, LabHub diharapkan dapat memberikan kemudahan, meningkatkan efisiensi pelayanan, serta mendukung kegiatan akademik di lingkungan FASILKOM UPN Veteran Jawa Timur.'
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
    <?php foreach ($articles as $index => $article): ?>
        <?php $delay = $index * 150; ?>
        <section class="px-10 sm:px-15.25 xl:px-40.25 " data-aos="fade-up" data-aos-delay="<?= $delay ?>">
            <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold ">
                <?= $article['title'] ?>
            </h1>
            <P class="text-justify text-sm sm:text-base md:text-lg lg:text-xl  leading-relaxed mt-5">
                <?= $article['deskripsi'] ?>
            </P>
        </section>
    <?php endforeach; ?>
</article>
