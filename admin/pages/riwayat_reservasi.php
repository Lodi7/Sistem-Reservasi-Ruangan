<?php
$page = 'riwayat_reservasi';

include __DIR__ . '/../../config/config.php';

//page    
$limit = 10;

$pageNumber =
    isset($_GET['p'])
    ? (int) $_GET['p']
    : 1;

if ($pageNumber < 1) {

    $pageNumber = 1;

}

$offset =
    ($pageNumber - 1) * $limit;

//total data
$stmtCount =
    mysqli_prepare(

        $conn,
        "SELECT COUNT(*) as total
        FROM reservasi
        WHERE status = 'Selesai'
        OR status = 'Tidak Hadir'
        "

    );

mysqli_stmt_execute(
    $stmtCount
);

$countResult =
    mysqli_stmt_get_result(
        $stmtCount
    );

$totalData =
    mysqli_fetch_assoc(
        $countResult
    )['total'];

$totalPages =
    ceil(
        $totalData / $limit
    );


$stmt =
    mysqli_prepare(

        $conn,

        "SELECT

            reservasi.id,
            reservasi.status,
            reservasi.kode_reservasi,

            users.nama,

            labs.nama_lab,

            jadwal.tanggal,
            jadwal.jam_mulai,
            jadwal.jam_selesai

        FROM reservasi

        JOIN users
        ON reservasi.user_id = users.id

        JOIN jadwal
        ON reservasi.jadwal_id = jadwal.id

        JOIN labs
        ON jadwal.lab_id = labs.id

        WHERE reservasi.status IN ( 
        'Selesai',
        'Tidak Hadir') 

        ORDER BY jadwal.tanggal DESC

        LIMIT ? OFFSET ?"

    );

mysqli_stmt_bind_param(

    $stmt,

    "ii",
    $limit,
    $offset

);

mysqli_stmt_execute(
    $stmt
);

$result =
    mysqli_stmt_get_result(
        $stmt
    );

?>


<section class="mt-20 px-4 sm:px-6 lg:px-25 min-h-screen py-10">

    <div class="flex flex-col gap-10">

        <!-- judul -->
        <div class="
            flex
            flex-col
            items-center
            text-center
            gap-3
        ">

            <h1 class="
                text-3xl
                sm:text-4xl
                md:text-5xl
                xl:text-6xl
                font-bold
            ">
                Riwayat Reservasi
            </h1>

        </div>


        <!-- tabel -->
        <div class="
            border
        border-gray-300
            rounded-[10px]
            overflow-hidden
            bg-white
            md:shadow-md
            w-full
        ">

            <!-- desktop -->
            <div class="hidden md:block">

                <!-- header -->
                <div class="
                    grid
                    grid-cols-[repeat(4,minmax(0,1fr))_130px_120px_80px]                    
                    lg:grid-cols-[repeat(4,minmax(0,1fr))_130px_120px_120px]
                    xl:grid-cols-[repeat(4,minmax(0,1fr))_200px_120px_150px]
                    bg-[#FF925C]
                    text-white
                    font-semibold
                ">
                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Nama
                    </div>

                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Lab
                    </div>

                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Tanggal
                    </div>

                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Jam Reservasi
                    </div>

                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Status
                    </div>

                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Kode
                    </div>
                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Aksi
                    </div>

                </div>


                <!-- body -->
                <div class="divide-y divide-gray-300">

                    <?php if (
                        mysqli_num_rows($result)
                        > 0
                    ): ?>


                        <?php while (
                            $item =
                            mysqli_fetch_assoc(
                                $result
                            )
                        ): ?>


                            <?php

                            $statusClass =
                                'bg-[#FDD3D0] text-[#EC221F]';

                            if (
                                $item['status']
                                == 'Selesai'
                            ) {

                                $statusClass =
                                    'bg-[#CFF7D3] text-[#14AE5C]';

                            }

                            ?>


                            <div class="
                                grid
                                grid-cols-[repeat(4,minmax(0,1fr))_130px_120px_80px]                                
                                lg:grid-cols-[repeat(4,minmax(0,1fr))_130px_120px_120px]
                                xl:grid-cols-[repeat(4,minmax(0,1fr))_200px_120px_150px]
                                items-stretch
                            ">
                                <!-- nama -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                    flex
                                    items-center
                                    justify-center
                                    text-center
                                    wrap-break-word
                                ">

                                    <?= htmlspecialchars(
                                        $item['nama']
                                    ) ?>

                                </div>

                                <!-- lab -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                    flex
                                    items-center
                                    justify-center
                                    text-center
                                    wrap-break-word
                                ">

                                    <?= htmlspecialchars(
                                        $item['nama_lab']
                                    ) ?>

                                </div>


                                <!-- tanggal -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                    flex
                                    items-center
                                    justify-center
                                    text-center
                                    lg:whitespace-nowrap
                                ">

                                    <?= date(

                                        'd F Y',

                                        strtotime(
                                            $item['tanggal']
                                        )

                                    ) ?>

                                </div>


                                <!-- jam -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                    flex
                                    items-center
                                    justify-center
                                    text-center
                                    lg:whitespace-nowrap
                                ">

                                    <?= substr(
                                        $item['jam_mulai'],
                                        0,
                                        5
                                    ) ?>

                                    -

                                    <?= substr(
                                        $item['jam_selesai'],
                                        0,
                                        5
                                    ) ?>

                                </div>


                                <!-- status -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                    flex
                                    justify-center
                                    items-center
                                ">

                                    <div class="
                                        flex
                                        justify-center
                                        items-center
                                        w-full
                                    ">

                                        <span class="
                                            px-4
                                            py-2
                                            rounded-full
                                            font-medium
                                            text-center
                                            whitespace-nowrap
                                            <?= $statusClass ?>
                                        ">
                                            <?php if ($item['status'] == 'Selesai'): ?>
                                                <?= $item['status'] ?>
                                            <?php else: ?>             <?= $item['status'] ?>
                                            <?php endif; ?>
                                        </span>

                                    </div>

                                </div>

                                <!-- kode reservasi -->
                                <div class="
                                                    py-6
                                                    px-4
                                                    border-r
                                                    border-gray-300
                                                    flex
                                                    items-center
                                                    justify-center
                                                    text-center
                                                    break-all
                                                ">
                                    <?= htmlspecialchars(
                                        $item['kode_reservasi']
                                    ) ?>
                                </div>

                                <!-- aksi -->
                                <div class="
                                    py-6
                                    px-4
                                    flex
                                    justify-center
                                    items-center
                                ">

                                    <a href="?page=detail_reservasi&id=<?= $item['id'] ?>&from=<?= $page ?>" class="
                                                    w-8
                                                    h-8
                                                    lg:w-11
                                                    lg:h-11
                                                    rounded-full
                                                    bg-[#FFF1C2]
                                                    flex
                                                    items-center
                                                    justify-center
                                                    hover:opacity-70
                                                ">

                                        <i data-lucide="eye" class="
                                                        text-[#BF6A02]
                                                    ">
                                        </i>

                                    </a>

                                </div>


                            </div>

                        <?php endwhile; ?>


                    <?php else: ?>


                        <div class="
                            py-20
                            text-center
                            text-gray-500
                            text-lg
                        ">

                            Belum ada riwayat reservasi.

                        </div>

                    <?php endif; ?>

                </div>

            </div>


            <!-- mobile -->
            <div class="md:hidden">

                <?php mysqli_data_seek($result, 0); ?>

                <?php if (
                    mysqli_num_rows($result) > 0
                ): ?>

                    <div class="
            flex
            flex-col
            divide-y
            divide-gray-300
        ">

                        <?php while (
                            $item =
                            mysqli_fetch_assoc(
                                $result
                            )
                        ): ?>

                            <?php

                            $statusClass =
                                'bg-[#FDD3D0] text-[#EC221F]';

                            if (

                                $item['status'] == 'Selesai'

                            ) {

                                $statusClass =
                                    'bg-[#CFF7D3] text-[#14AE5C]';

                            }

                            ?>

                            <div class="
                    p-5
                    flex
                    flex-col
                    gap-4
                ">

                                <!-- nama -->
                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Nama
                                    </p>

                                    <p class="
                            font-semibold
                        ">
                                        <?= htmlspecialchars(
                                            $item['nama']
                                        ) ?>
                                    </p>

                                </div>

                                <!-- lab -->
                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Laboratorium
                                    </p>

                                    <p>

                                        <?= htmlspecialchars(
                                            $item['nama_lab']
                                        ) ?>

                                    </p>

                                </div>

                                <!-- tanggal -->
                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Tanggal
                                    </p>

                                    <p>

                                        <?= date(

                                            'd F Y',

                                            strtotime(
                                                $item['tanggal']
                                            )

                                        ) ?>

                                    </p>

                                </div>

                                <!-- jam -->
                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Jam Reservasi
                                    </p>

                                    <p>

                                        <?= substr(
                                            $item['jam_mulai'],
                                            0,
                                            5
                                        ) ?>

                                        -

                                        <?= substr(
                                            $item['jam_selesai'],
                                            0,
                                            5
                                        ) ?>

                                    </p>

                                </div>

                                <!-- status -->
                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                            mb-2
                        ">
                                        Status
                                    </p>

                                    <span class="
                            px-4
                            py-2
                            rounded-full
                            text-sm
                            font-medium
                            inline-block
                            <?= $statusClass ?>
                        ">

                                        <?php if (

                                            $item['status'] == 'Selesai'

                                        ): ?>

                                            <?= $item['status'] ?>

                                        <?php else: ?>

                                            <?= $item['status'] ?>

                                        <?php endif; ?>

                                    </span>

                                </div>

                                <!-- kode -->
                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Kode Reservasi
                                    </p>

                                    <p class="
                            font-medium
                            break-all
                        ">

                                        <?php if (
                                            $item['status'] !== 'Ditolak' && $item['status'] !== 'Dibatalkan'
                                        ): ?>

                                            <?= htmlspecialchars(
                                                $item['kode_reservasi']
                                            ) ?>

                                        <?php else: ?>

                                            -

                                        <?php endif; ?>

                                    </p>

                                </div>

                                <!-- aksi -->
                                <div class="
                        flex
                        justify-end
                    ">

                                    <a href="?page=detail_reservasi&id=<?= $item['id'] ?>&from=<?= $page ?>" class="
                                w-8
                                h-8
                                rounded-full
                                bg-[#FFF1C2]
                                flex
                                items-center
                                justify-center
                                cursor-pointer
                                hover:opacity-70
                            ">

                                        <i data-lucide="eye" class="
                                    text-[#BF6A02]
                                ">
                                        </i>

                                    </a>

                                </div>

                            </div>

                        <?php endwhile; ?>

                    </div>

                <?php else: ?>

                    <div class="
            py-20
            text-center
            text-gray-500
        ">

                        Belum ada riwayat reservasi.

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>
    <?php if ($totalPages > 1): ?>

        <div class="flex justify-center gap-2 mt-8">

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                <a href="?page=riwayat_reservasi&p=<?= $i ?>" class="
                px-4 py-2 rounded-lg border border-gray-300
                <?= $i == $pageNumber
                    ? 'bg-[#FF925C] text-white'
                    : 'bg-white' ?>
            ">
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>
    <?php endif; ?>

</section>