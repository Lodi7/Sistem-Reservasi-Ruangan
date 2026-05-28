<?php

$page = 'jadwal_lab';

include __DIR__ . '/../components/data_jadwal.php';

?>


<section class="mt-30 px-5 sm:px-15 md:px-25 min-h-screen">

    <div class="flex flex-col items-center justify-center text-center max-w-full gap-6.25">

        <!-- judul -->
        <div class="flex flex-col gap-4">

            <h1 class="
                text-4xl
                md:text-5xl
                xl:text-6xl
                font-bold 
            ">

                Jadwal Lab

            </h1>

            <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed max-w-3xl">

                Pilih tanggal dan sesi untuk check ketersedian lab

            </p>

        </div>


        <!-- filter -->
        <div class="
            flex
            gap-4
            flex-wrap
            items-center
            w-full
        ">
            <div class="flex flex-col justify-center items-start gap-2 w-full md:w-80 lg:w-100">
                <label class="text-2xl">Pilih Lab</label>
                <div class="relative cursor-pointer w-full">
                    <!-- lab -->
                    <select id="labSelect" class="
                    border
                    rounded-xl
                    md:rounded-2xl
                    px-2.5
                    py-2.75
                    md:px-4.5
                    md:py-4.75
                    appearance-none
                    cursor-pointer
                    border-[#AAAAAA]
                    text-[#767676]
                    text-sm
                    md:text-base
                    w-full
                ">

                        <?php foreach (
                            $labs as $lab
                        ): ?>

                            <option value="<?= $lab['id'] ?>">

                                <?= htmlspecialchars(
                                    $lab['nama_lab']
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>
                    <i data-lucide="chevron-down"
                        class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-[#767676]">
                    </i>
                </div>
            </div>

            <div class="flex flex-col justify-center items-start gap-2">
                <label class="text-2xl">Pilih Tanggal</label>
                <!-- tanggal -->
                <input type="text" id="tanggal" class="
                    border
                    rounded-xl
                    md:rounded-2xl
                    px-2.5
                    py-2.75
                    text-sm
                    md:text-base
                    md:px-4.5
                    md:py-4.75
                    appearance-none
                    border-[#AAAAAA]
                    text-[#767676]
                ">
            </div>

        </div>

        <!-- arti warna -->
        <div class="
                flex
                flex-wrap
                gap-5
                w-full
                
            ">

            <div class="
                    flex
                    items-center
                    gap-2
                ">

                <div class="
                        w-3
                        h-3
                        rounded-full
                        bg-[#FF925C]/20
                    "></div>

                <span class="
                        text-sm
                        text-gray-500
                        font-medium
                    ">
                    Tersedia
                </span>

            </div>


            <div class="
                    flex
                    items-center
                    gap-2
                ">

                <div class="
                        w-3
                        h-3
                        rounded-full
                        bg-[#FF925C]
                    "></div>

                <span class="
                        text-sm
                        text-gray-500
                        font-medium
                    ">
                    Dipilih
                </span>

            </div>

            <div class="
                    flex
                    items-center
                    gap-2
                ">

                <div class="
                        w-3
                        h-3
                        rounded-full
                        bg-[#F5F5F5]
                    "></div>

                <span class="
                        text-sm
                        text-gray-500
                        font-medium
                    ">
                    Penuh
                </span>

            </div>

        </div>

        <!-- tabel -->
        <div class="
            border
            overflow-hidden
            bg-white
                border-gray-300
                rounded-[10px]
                shadow-md
                w-full
        ">

            <!-- header tabel -->
            <div class="
                bg-[#FF925C]
                text-white
                 px-2
                md:px-8
                py-5
                flex
                justify-between
                items-center
                gap-5
            ">

                <!-- tanggal -->
                <h2 id="jadwalDate" class="
                        text-base
                        sm:text-lg
                        lg:text-xl
                        xl:text-2xl
                        font-medium
                    ">

                </h2>


                <!-- lab -->
                <div class="
                    flex
                    flex-col
                    text-right
                    overflow-hidden
                ">

                    <p id="jadwalLab" class="
                            text-sm    
                    sm:text-base
                    md:text-lg
                            truncate
                        ">

                    </p>

                    <p id="jadwalLocation" class="
                            text-[12px]
                    md:text-sm
                    opacity-80
                    truncate
                    text-right
                        ">

                    </p>

                </div>

            </div>


            <!-- manggil table -->
            <div id="jadwalTable">
            </div>

        </div>

    </div>

</section>