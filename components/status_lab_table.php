<?php foreach ($jadwal as $item): ?>
    <?php
    $statusClass =
        'bg-[#CFF7D3] text-[#14AE5C]';

    // Dipakai
    if (
        $item['status']
        == 'Dipakai'
    ) {

        $statusClass =
            'bg-[#FDD3D0] text-[#EC221F]';

    }

    // Perbaikan
    elseif (
        $item['status']
        == 'Perbaikan'
    ) {

        $statusClass =
            'bg-[#FFF1C2] text-[#BF6A02]';

    }


    // nonaktif
    elseif (

        $item['status']
        == 'Non-aktif'
        ||
        $item['status']
        == 'Nonaktif Hari Ini'

    ) {

        $statusClass =
            'bg-gray-200 text-gray-700';

    }

    ?>


    <div class="
            grid
            grid-cols-3
            border-t
            border-gray-300
        ">

        <!-- sesi -->
        <div class="
                flex
                justify-center
                items-center
                py-5
                px-5
                
                xl:px-15
                text-[12px]
                sm:text-md
                md:text-lg
                xl:text-2xl
                border-r
                border-gray-300
            ">

            <?= $item['sesi'] ?>

        </div>


        <!-- jam -->
        <div class="
                flex
                justify-center
                items-center
                py-5
                px-2
                xl:px-15
                text-[12px]
                sm:text-md
                md:text-lg
                xl:text-2xl
                border-r
                border-gray-300
                whitespace-nowrap
            ">
            <?= $item['jam'] ?>
        </div>


        <!-- status -->
        <div class="
                flex
                justify-center
                items-center
                py-5
                px-1.5
                md:px-5
                xl:px-15
            ">

            <span class="
                    py-1.5
                    rounded-full
                    text-[12px]
                    md:text-md
                    xl:text-2xl
                    text-center
                    font-medium
                    w-full
                    <?= $statusClass ?>
                ">

                <?= $item['status'] ?>

            </span>

        </div>

    </div>

<?php endforeach; ?>