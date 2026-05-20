<?php include 'layouts/header.php'; ?>
<section id="hero" class="">
    <div class="flex justify-center items-center mt-18 bg-gray-300 w-full">
        <div class="flex flex-col justify-center items-center max-w-87.5 text-center py-35.75">
            <h3 class="font-medium text-xl">LabHub</h3>
            <h2 class="font-bold text-[41.5px] mt-1.5">Selamat Datang!</h2>
            <p class="text-sm leading-relaxed mt-2.75">Solusi tepat untuk proses pendaftaran, reservasi, dan approval
                praktis
                melalui
                LabHub. Tekan
                login untuk
                mulai reservasi.</p>
            <div class="flex justify-center space-x-4 mt-4.25">
                <a href="login.php" class="text-[12px] bg-[#FFE9BD] rounded-4xl px-3 py-2 ">Login</a>
                <a href="info-lab.php" class="text-[12px] bg-[#E0EAFF] rounded-4xl px-3 py-2">Informasi Lab</a>
            </div>
        </div>
    </div>
    <div class="flex justify-center py-12 md:py-16 lg:py-20 px-6">

        <figure class="flex flex-col lg:flex-row items-center gap-10 max-w-7xl w-full">

            <div class="max-w-2xl text-center lg:text-left">

                <figcaption class="mb-6">

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">
                        Informasi Lab
                    </h1>

                    <p class="text-base md:text-lg lg:text-xl leading-relaxed mt-4">
                        LabHub merupakan layanan terpadu untuk reservasi ruangan
                        laboratorium dengan manajemen penjadwalan laboratorium
                        efisien dan ketersediaan ruangan secara real-time
                        melalui sistem digital.
                    </p>

                </figcaption>

                <a href="" class="inline-block bg-[#FFE9BD] rounded-full px-5 py-3 text-sm">
                    Selengkapnya
                </a>

            </div>

            <img src="/assets/images/infoLab.png" alt="Informasi Lab" class="w-full max-w-sm md:max-w-lg lg:max-w-xl">

        </figure>

    </div>
</section>

<?php include 'components/footer.php'; ?>
<?php include 'layouts/footer.php'; ?>