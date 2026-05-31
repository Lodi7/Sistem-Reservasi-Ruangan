<?php
$page = 'reservasi_hari_ini';

include __DIR__ . '/../../config/config.php';

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

$stmtCount =
    mysqli_prepare(

        $conn,

        "SELECT COUNT(*) as total

        FROM reservasi

        JOIN jadwal
        ON reservasi.jadwal_id = jadwal.id

        WHERE

            jadwal.tanggal = CURDATE()

            AND

            reservasi.status IN (

                'Belum Ambil Kunci',
                'Sedang Berlangsung'

            )"

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
            reservasi.kode_reservasi,
            reservasi.status,

            users.nama,

            labs.nama_lab,

            jadwal.sesi,
            jadwal.jam_mulai,
            jadwal.jam_selesai

        FROM reservasi

        JOIN users
        ON reservasi.user_id = users.id

        JOIN jadwal
        ON reservasi.jadwal_id = jadwal.id

        JOIN labs
        ON jadwal.lab_id = labs.id

        WHERE

            jadwal.tanggal = CURDATE()

            AND

            reservasi.status IN (

                'Belum Ambil Kunci',
                'Sedang Berlangsung'

            )

        ORDER BY jadwal.jam_mulai ASC

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

// uodate status
if (

    isset($_POST['ubah_status'])

) {

    $reservasiId =
        (int) $_POST['reservasi_id'];

    $status =
        $_POST['status'];

    $stmtUpdate =
        mysqli_prepare(

            $conn,

            "UPDATE reservasi

            SET status = ?

            WHERE id = ?"

        );

    mysqli_stmt_bind_param(

        $stmtUpdate,

        "si",

        $status,
        $reservasiId

    );

    mysqli_stmt_execute(
        $stmtUpdate
    );

    header(
        "Location: ?page=reservasi_hari_ini&p=$pageNumber"
    );

    exit;

}
?>

<section class="mt-20 px-4 sm:px-6 lg:px-25 min-h-screen py-10">

    <div class="flex flex-col gap-10">

        <!-- judul -->
        <h1 class="
                text-3xl
                sm:text-4xl
                md:text-5xl
                xl:text-6xl
                font-bold
                text-center
            ">
            Reservasi Hari Ini
        </h1>


        <!-- tabel -->
        <div class="
            md:border
            md:border-gray-300
            rounded-[10px]
            overflow-visible
        bg-white
           md:shadow-md
            w-full
        ">

            <!-- desktop -->
            <div class="hidden md:block">

                <!-- header -->
                <div class="
                    grid
                    grid-cols-[1fr_1fr_1fr_1fr_250px]
                                lg:grid-cols-[1fr_1fr_1fr_1fr_300px]
                                xl:grid-cols-[1fr_1fr_1fr_1fr_400px]
                    bg-[#FF925C]
                    text-white
                    font-semibold
                ">

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
                        Sesi
                    </div>

                    <div class="
                        py-5
                        px-4
                        text-center
                    ">
                        Status
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
                            <div class="
                                grid
                                grid-cols-[1fr_1fr_1fr_1fr_250px]
                                lg:grid-cols-[1fr_1fr_1fr_1fr_300px]
                                xl:grid-cols-[1fr_1fr_1fr_1fr_400px]
                                items-stretch
                            ">

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
                                ">

                                    <?= htmlspecialchars(
                                        $item['kode_reservasi']
                                    ) ?>

                                </div>

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
                                ">

                                    <?= htmlspecialchars($item['nama_lab']) ?>

                                </div>

                                <!-- Sesi -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                    flex
                                    items-center
                                    justify-center
                                    text-center
                                ">
                                    <?= htmlspecialchars($item['sesi']) ?>(
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
                                    ) ?>)

                                </div>

                                <!-- status -->
                                <div class="
                                    py-6
                                    px-2
                                    xl:px-4
                                    flex
                                    justify-center
                                    items-center
                                ">
                                    <?php

                                    $statusConfig = match ($item['status']) {

                                        'Belum Ambil Kunci' => [
                                            'bg' => 'bg-[#FDD3D0]',
                                            'text' => 'text-[#EC221F]'
                                        ],

                                        'Sedang Berlangsung' => [
                                            'bg' => 'bg-[#FFF1C2]',
                                            'text' => 'text-[#BF6A02]'
                                        ],

                                        'Selesai' => [
                                            'bg' => 'bg-[#CFF7D3]',
                                            'text' => 'text-[#14AE5C]'
                                        ]
                                    };
                                    ?>

                                    <form method="POST">

                                        <input type="hidden" name="reservasi_id" value="<?= $item['id'] ?>">

                                        <input type="hidden" name="ubah_status" value="1">

                                        <input type="hidden" name="status" id="status-<?= $item['id'] ?>"
                                            value="<?= $item['status'] ?>">

                                        <div class="relative status-dropdown z-999">

                                            <button type="button" class="dropdown-trigger
                flex
                items-center
                justify-between
                gap-4
                min-w-55
                px-5
                py-3
                rounded-full
                border-2
                <?= $statusConfig['bg'] ?>
                <?= $statusConfig['text'] ?>
            ">

                                                <span>

                                                    <?= $item['status'] ?>

                                                </span>

                                                <i data-lucide="chevron-down" class="w-5 h-5"></i>

                                            </button>

                                            <div class="
                hidden
                absolute
                top-full
                left-0
                mt-2
                w-full
                p-3
                bg-white
                border
                rounded-xl
                z-9999
                overflow-hidden
                dropdown-menu
            ">
                                                <div class="flex flex-col gap-3">
                                                    <button type="button" data-status="Belum Ambil Kunci" class="
                    block
                    w-full
                    rounded-full
                    text-center
                    px-5
                    py-3
                    bg-[#FDD3D0]
                    text-[#EC221F]
                    hover:opacity-80
                ">
                                                        Belum Ambil Kunci
                                                    </button>

                                                    <button type="button" data-status="Sedang Berlangsung" class="
                    block
                    w-full
                    text-center
                    px-5
                    py-3
                    bg-[#FFF1C2]
                    text-[#BF6A02]
                    hover:opacity-80
                    rounded-full
                ">
                                                        Sedang Berlangsung
                                                    </button>

                                                    <button type="button" data-status="Selesai" class="
                    block
                    w-full
                    text-center
                    px-5
                    py-3
                    bg-[#CFF7D3]
                    text-[#14AE5C]
                    hover:opacity-80
                    rounded-full
                ">
                                                        Selesai
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

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

                            Tidak ada reservasi hari ini.

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
            gap-4
        ">

                        <?php while (
                            $item =
                            mysqli_fetch_assoc(
                                $result
                            )
                        ): ?>

                            <div class="
                    border
                    border-gray-300
                    rounded-[20px]
                    p-5
                    bg-white
                    flex
                    flex-col
                    gap-4
                ">

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
                                        <?= htmlspecialchars(
                                            $item['kode_reservasi']
                                        ) ?>
                                    </p>

                                </div>


                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Nama
                                    </p>

                                    <p class="
                            font-medium
                        ">
                                        <?= htmlspecialchars(
                                            $item['nama']
                                        ) ?>
                                    </p>

                                </div>


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


                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                        ">
                                        Sesi
                                    </p>

                                    <p>

                                        <?= htmlspecialchars(
                                            $item['sesi']
                                        ) ?>

                                        (

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

                                        )

                                    </p>

                                </div>


                                <div>

                                    <p class="
                            text-xs
                            text-gray-500
                            mb-2
                        ">
                                        Status
                                    </p>

                                    <?php

                                    $statusConfig = match ($item['status']) {

                                        'Belum Ambil Kunci' => [
                                            'bg' => 'bg-[#FDD3D0]',
                                            'text' => 'text-[#EC221F]'
                                        ],

                                        'Sedang Berlangsung' => [
                                            'bg' => 'bg-[#FFF1C2]',
                                            'text' => 'text-[#BF6A02]'
                                        ],

                                        'Selesai' => [
                                            'bg' => 'bg-[#CFF7D3]',
                                            'text' => 'text-[#14AE5C]'
                                        ]
                                    };
                                    ?>

                                    <form method="POST">

                                        <input type="hidden" name="reservasi_id" value="<?= $item['id'] ?>">

                                        <input type="hidden" name="ubah_status" value="1">

                                        <input type="hidden" name="status" value="<?= $item['status'] ?>">

                                        <div class="relative status-dropdown z-999">

                                            <button type="button" class="dropdown-trigger
                w-full
                flex
                items-center
                justify-between
                px-5
                py-3
                rounded-full
                <?= $statusConfig['bg'] ?>
                <?= $statusConfig['text'] ?>
            ">

                                                <span>
                                                    <?= $item['status'] ?>
                                                </span>

                                                <i data-lucide="chevron-down" class="w-5 h-5"></i>

                                            </button>

                                            <div class="
                hidden
                absolute
                left-0
                top-full
                mt-2
                w-full
                p-3
                bg-white
                border
                border-gray-200
                rounded-xl
                overflow-hidden
                z-9999
                shadow-lg
                dropdown-menu
            ">
                                                <div class="flex flex-col gap-3">
                                                    <button type="button" data-status="Belum Ambil Kunci" class="
                    block
                    w-full
                    text-left
                    px-5
                    py-3
                    bg-[#FDD3D0]
                    text-[#EC221F]
                    rounded-full
                ">
                                                        Belum Ambil Kunci
                                                    </button>

                                                    <button type="button" data-status="Sedang Berlangsung" class="
                    block
                    w-full
                    text-left
                    px-5
                    py-3
                    bg-[#FFF1C2]
                    text-[#BF6A02]
                    rounded-full
                ">
                                                        Sedang Berlangsung
                                                    </button>

                                                    <button type="button" data-status="Selesai" class="
                    block
                    w-full
                    text-left
                    px-5
                    py-3
                    bg-[#CFF7D3]
                    text-[#14AE5C]
                    rounded-full
                ">
                                                        Selesai
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

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

                        Tidak ada reservasi hari ini.

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</section>