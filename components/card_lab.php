<?php

$statusClass = match ($status) {
    'Tersedia' => 'bg-[#CFF7D3] text-[#307445]',
    'Perbaikan' => 'bg-[#FFF1C2] text-[#BF6A02]',
    'Non-aktif' => 'bg-[#FDD3D0] text-[#EE3835]',
    default => 'bg-gray-400 text-gray-900'
};

?>
<div
    class="flex flex-col h-full justify-start items-start gap-5 p-4 md:p-5 w-full lg:max-w-98.25 shadow rounded-[28px] shadow-black/25 text-left hover:-translate-y-1 hover:shadow-[#FF925C] hover:shadow-xl transition duration-300">

    <!-- isi card -->
    <a href="index.php?page=detail_lab&lab=<?= $slug ?>" class="flex flex-col gap-5 flex-1 w-full">

        <div class="relative w-full">
            <img src="<?= $gambar ?>" alt="<?= $nama ?>"
                class="w-full h-44 sm:h-52 lg:h-50 xl:h-54.5 object-cover rounded-[20px]" />

            <span
                class="absolute top-3 right-3 px-3.75 py-1.25 font-semibold text-xs md:text-[13px] rounded-xl text-center <?= $statusClass ?>">

                <?= $status ?>

            </span>
        </div>

        <div class="flex flex-col text-lg md:text-xl">
            <h2 class="font-semibold"><?= $nama ?></h2>
            <p class="font-light"><?= $kategori ?></p>
        </div>

        <div
            class="grid grid-cols-2 md:flex justify-between items-start md:items-center gap-4 md:gap-0 w-full border-y border-[#D0D0D0] py-3">

            <div class="flex gap-2 items-center">
                <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="p-1.25 w-7 h-7 rounded bg-[#FF925C]">

                    <path
                        d="M19.7803 6.05328C20.0732 5.76039 20.0732 5.28551 19.7803 4.99262L15.0074 0.219648C14.7145 -0.0732454 14.2396 -0.0732453 13.9467 0.219648C13.6538 0.512542 13.6538 0.987415 13.9467 1.28031L18.1893 5.52295L13.9467 9.76559C13.6538 10.0585 13.6538 10.5334 13.9467 10.8262C14.2396 11.1191 14.7145 11.1191 15.0074 10.8262L19.7803 6.05328ZM11.25 5.52295L11.25 6.27295L19.25 6.27295L19.25 5.52295L19.25 4.77295L11.25 4.77295L11.25 5.52295Z"
                        fill="white" />

                    <path
                        d="M0.219669 6.05328C-0.0732241 5.76039 -0.073224 5.28551 0.219669 4.99262L4.99264 0.219648C5.28553 -0.0732454 5.76041 -0.0732453 6.0533 0.219648C6.34619 0.512542 6.34619 0.987415 6.0533 1.28031L1.81066 5.52295L6.0533 9.76559C6.34619 10.0585 6.34619 10.5334 6.0533 10.8262C5.76041 11.1191 5.28553 11.1191 4.99264 10.8262L0.219669 6.05328ZM8.75 5.52295L8.75 6.27295L0.75 6.27295L0.75 5.52295L0.75 4.77295L8.75 4.77295L8.75 5.52295Z"
                        fill="white" />

                </svg>

                <span class="font-semibold text-sm md:text-base">
                    <?= $luas ?>
                </span>

                <p class="font-light text-sm md:text-base">m²</p>
            </div>

            <div class="flex gap-2 items-center">
                <svg width="24" height="15" viewBox="0 0 24 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="p-1.25 w-7 h-7 rounded bg-[#FF925C]">

                    <path
                        d="M12 0C12.9283 0 13.8185 0.368749 14.4749 1.02513C15.1313 1.6815 15.5 2.57174 15.5 3.5C15.5 4.42826 15.1313 5.3185 14.4749 5.97487C13.8185 6.63125 12.9283 7 12 7C11.0717 7 10.1815 6.63125 9.52513 5.97487C8.86875 5.3185 8.5 4.42826 8.5 3.5C8.5 2.57174 8.86875 1.6815 9.52513 1.02513C10.1815 0.368749 11.0717 0 12 0ZM5 2.5C5.56 2.5 6.08 2.65 6.53 2.92C6.38 4.35 6.8 5.77 7.66 6.88C7.16 7.84 6.16 8.5 5 8.5C4.20435 8.5 3.44129 8.18393 2.87868 7.62132C2.31607 7.05871 2 6.29565 2 5.5C2 4.70435 2.31607 3.94129 2.87868 3.37868C3.44129 2.81607 4.20435 2.5 5 2.5ZM19 2.5C19.7956 2.5 20.5587 2.81607 21.1213 3.37868C21.6839 3.94129 22 4.70435 22 5.5C22 6.29565 21.6839 7.05871 21.1213 7.62132C20.5587 8.18393 19.7956 8.5 19 8.5C17.84 8.5 16.84 7.84 16.34 6.88C17.2115 5.75423 17.6161 4.33616 17.47 2.92C17.92 2.65 18.44 2.5 19 2.5ZM5.5 12.75C5.5 10.68 8.41 9 12 9C15.59 9 18.5 10.68 18.5 12.75V14.5H5.5V12.75ZM0 14.5V13C0 11.61 1.89 10.44 4.45 10.1C3.86 10.78 3.5 11.72 3.5 12.75V14.5H0ZM24 14.5H20.5V12.75C20.5 11.72 20.14 10.78 19.55 10.1C22.11 10.44 24 11.61 24 13V14.5Z"
                        fill="white" />

                </svg>

                <span class="font-semibold text-sm md:text-base">
                    <?= $kapasitas ?>
                </span>

                <p class="font-light text-sm md:text-base">Orang</p>
            </div>

            <div class="flex gap-2 items-center col-span-2 md:col-span-1">
                <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="p-1.25 w-7 h-7 rounded bg-[#FF925C]">
                    <path
                        d="M14.657 14.6567L10.414 18.8997C10.039 19.2743 9.53059 19.4848 9.0005 19.4848C8.47042 19.4848 7.96202 19.2743 7.587 18.8997L3.343 14.6567C2.22422 13.5379 1.46234 12.1124 1.15369 10.5606C0.845043 9.00873 1.00349 7.40022 1.60901 5.93844C2.21452 4.47665 3.2399 3.22725 4.55548 2.34821C5.87107 1.46918 7.41777 1 9 1C10.5822 1 12.1289 1.46918 13.4445 2.34821C14.7601 3.22725 15.7855 4.47665 16.391 5.93844C16.9965 7.40022 17.155 9.00873 16.8463 10.5606C16.5377 12.1124 15.7758 13.5379 14.657 14.6567Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M5.625 9.11743C5.625 10.0125 5.98058 10.871 6.61351 11.5039C7.24645 12.1369 8.10489 12.4924 9 12.4924C9.89511 12.4924 10.7536 12.1369 11.3865 11.5039C12.0194 10.871 12.375 10.0125 12.375 9.11743C12.375 8.22233 12.0194 7.36388 11.3865 6.73095C10.7536 6.09801 9.89511 5.74243 9 5.74243C8.10489 5.74243 7.24645 6.09801 6.61351 6.73095C5.98058 7.36388 5.625 8.22233 5.625 9.11743Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <span class="font-semibold text-sm md:text-base">
                    <?= $lokasi ?>
                </span>
            </div>
        </div>

        <div class="flex flex-col max-w-50">
            <div class="flex gap-2 items-center">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="p-1.25 w-7 h-7 rounded bg-[#FF925C]">
                    <path
                        d="M10 18C14.4 18 18 14.4 18 10C18 5.6 14.4 2 10 2C5.6 2 2 5.6 2 10C2 14.4 5.6 18 10 18ZM10 0C15.5 0 20 4.5 20 10C20 15.5 15.5 20 10 20C4.5 20 0 15.5 0 10C0 4.5 4.5 0 10 0ZM15 9.5V11H9V5H10.5V9.5H15Z"
                        fill="white" />
                </svg>

                <h2 class="font-semibold text-lg md:text-xl">
                    Jam Operasional
                </h2>
            </div>

            <p class="text-center ml-2 font-light text-sm md:text-base">
                <span><?= $jam_buka ?></span> -
                <span><?= $jam_tutup ?></span> WIB
            </p>
        </div>

        <div class="flex gap-2 flex-col w-full">

            <div class="flex gap-2 items-center">
                <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="p-1.25 w-7 h-7 rounded bg-[#FF925C]">

                    <path
                        d="M15 11H17V14H20V16H17V19H15V16H12V14H15V11ZM10 0L20 9H16C15.0402 9.00063 14.0946 9.23129 13.2424 9.67266C12.3901 10.114 11.6561 10.7532 11.1018 11.5367C10.5474 12.3202 10.189 13.2252 10.0565 14.1757C9.92392 15.1263 10.0211 16.0948 10.34 17H3V9H0L10 0Z"
                        fill="white" />

                </svg>

                <h2 class="font-semibold text-lg md:text-xl">
                    Fasilitas
                </h2>
            </div>

            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3">

                <?php

                foreach ($fasilitas as $fasilitas_item):
                    ?>

                    <span
                        class="font-light text-sm md:text-base border-2 text-center hover:bg-[#FF925C] hover:text-white hover:-translate-y-0.5 transition duration-300 border-[#FF925C] rounded-full px-3 py-1">

                        <?= trim($fasilitas_item) ?>

                    </span>

                <?php endforeach; ?>

            </div>
        </div>
    </a>
    <!-- tombol -->
    <?php if (isset($_SESSION['is_login'])): ?>
        <a href="index.php?page=ajukan_reservasi" class="w-full p-2 flex justify-center items-center text-center rounded-full font-semibold text-base md:text-xl text-white <?= $status == 'Tersedia'
            ? 'bg-[#FF925C] cursor-pointer'
            : 'bg-gray-300 cursor-not-allowed pointer-events-none' ?>">

            Ajukan Reservasi

        </a><?php else: ?>
        <a href="index.php?page=login" class="w-full p-2 flex justify-center items-center text-center rounded-full font-semibold text-base md:text-xl text-white <?= $status == 'Tersedia'
            ? 'bg-[#FF925C] cursor-pointer'
            : 'bg-gray-300 cursor-not-allowed pointer-events-none' ?>">

            Ajukan Reservasi

        </a>
    <?php endif; ?>

</div>