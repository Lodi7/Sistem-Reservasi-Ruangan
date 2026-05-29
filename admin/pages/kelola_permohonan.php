<?php

$page = 'kelola_permohonan';

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

// setujui reservasi    
if (

    isset($_POST['setujui_reservasi'])

) {

    $reservasi_id =
        (int) $_POST['reservasi_id'];

    $stmtApprove =
        mysqli_prepare(

            $conn,

            "UPDATE reservasi

            SET status = 'Disetujui'

            WHERE id = ?"

        );

    mysqli_stmt_bind_param(

        $stmtApprove,

        "i",

        $reservasi_id

    );

    mysqli_stmt_execute(
        $stmtApprove
    );

    header("Location: ?page=kelola_permohonan");
    exit;
}

// tolak reservasi
if (

    isset($_POST['tolak_reservasi'])

) {

    $reservasi_id =
        (int) $_POST['reservasi_id'];

    $stmtReject =
        mysqli_prepare(

            $conn,

            "UPDATE reservasi

            SET status = 'Ditolak'

            WHERE id = ?"

        );

    mysqli_stmt_bind_param(

        $stmtReject,

        "i",

        $reservasi_id

    );

    mysqli_stmt_execute(
        $stmtReject
    );

    header("Location: ?page=kelola_permohonan");
    exit;
}

$stmtCount =
    mysqli_prepare(

        $conn,

        "SELECT COUNT(*) as total

        FROM reservasi

        WHERE status = 'Pending'"

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

        WHERE reservasi.status = 'Pending'

        ORDER BY reservasi.id DESC

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
        <h1 class="
                text-3xl
                sm:text-4xl
                md:text-5xl
                xl:text-6xl
                font-bold
                text-center
            ">
            Kelola Permohonan
        </h1>


        <!-- tabel -->
        <div class="
            md:border
            md:border-gray-300
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
                    grid-cols-5
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
                            <div class="
                                grid
                                grid-cols-5
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

                                <!-- aksi -->
                                <div class="
                                    py-6
                                    px-4
                                    flex
                                    justify-center
                                    items-center
                                ">

                                    <div class="
                                        flex
                                        justify-center
                                        items-center
                                        gap-3
                                    ">

                                        <form method="POST">

                                            <input type="hidden" name="reservasi_id" value="<?= $item['id'] ?>">

                                            <button type="submit" name="setujui_reservasi" class="
                                                    w-8
                                                    h-8
                                                    lg:w-11
                                                    lg:h-11
                                                    rounded-full
                                                    bg-[#CFF7D3]
                                                    flex
                                                    items-center
                                                    justify-center
                                                    cursor-pointer
                                                    hover:opacity-70
                                                ">

                                                <i data-lucide="check" class="
                                                        text-[#14AE5C]
                                                    ">
                                                </i>

                                            </button>

                                        </form>


                                        <form method="POST">

                                            <input type="hidden" name="reservasi_id" value="<?= $item['id'] ?>">

                                            <button type="submit" name="tolak_reservasi" class="
                                                        w-8
                                                        h-8
                                                        lg:w-11
                                                        lg:h-11
                                                        rounded-full
                                                        bg-[#FDD3D0]
                                                        flex
                                                        items-center
                                                        justify-center
                                                        cursor-pointer
                                                        hover:opacity-70
                                                    ">

                                                <i data-lucide="x" class="
                                                            text-[#EC221F]
                                                        ">
                                                </i>

                                            </button>

                                        </form>


                                        <a href="?page=detail_reservasi&id=<?= $item['id'] ?>" class="
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

                            </div>

                        <?php endwhile; ?>


                    <?php else: ?>


                        <div class="
                            py-20
                            text-center
                            text-gray-500
                            text-lg
                        ">

                            Belum ada permohonan reservasi.

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

                                <!-- nama -->
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


                                <!-- aksi -->
                                <div class="
                        flex
                        justify-end
                        gap-3
                    ">

                                    <form method="POST">

                                        <input type="hidden" name="reservasi_id" value="<?= $item['id'] ?>">

                                        <button type="submit" name="setujui_reservasi" class="
                                    w-8
                                    h-8
                                    rounded-full
                                    bg-[#CFF7D3]
                                    flex
                                    items-center
                                    justify-center
                                ">

                                            <i data-lucide="check" class="
                                        text-[#14AE5C]
                                    ">
                                            </i>

                                        </button>

                                    </form>


                                    <form method="POST">

                                        <input type="hidden" name="reservasi_id" value="<?= $item['id'] ?>">

                                        <button type="submit" name="tolak_reservasi" class="
                                    w-8
                                    h-8
                                    rounded-full
                                    bg-[#FDD3D0]
                                    flex
                                    items-center
                                    justify-center
                                ">

                                            <i data-lucide="x" class="
                                        text-[#EC221F]
                                    ">
                                            </i>

                                        </button>

                                    </form>


                                    <a href="?page=detail_reservasi&id=<?= $item['id'] ?>" class="
                                w-8
                                h-8
                                rounded-full
                                bg-[#FFF1C2]
                                flex
                                items-center
                                justify-center
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

                        Belum ada permohonan reservasi.

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</section>