<?php

$page = 'riwayat_reservasi';

include __DIR__ .
    '/../config/config.php';

include __DIR__ .
    '/../middleware/auth.php';


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


// delete pending
if (

    isset($_POST['hapus_pending'])

) {

    $reservasi_id =
        $_POST['reservasi_id'];


    $stmtDelete =
        mysqli_prepare(

            $conn,

            "DELETE FROM reservasi

            WHERE

            id = ?
            AND user_id = ?
            AND status = 'Pending'"

        );

    mysqli_stmt_bind_param(

        $stmtDelete,

        "ii",

        $reservasi_id,
        $_SESSION['user_id']

    );

    $success =
        mysqli_stmt_execute(
            $stmtDelete
        );


    if ($success) {

        $_SESSION['success'] =
            'Reservasi berhasil dibatalkan';

    } else {

        $_SESSION['error'] =
            'Terjadi kesalahan';

    }

}


// batalkan disetujui
if (

    isset($_POST['batalkan_disetujui'])

) {

    $reservasi_id =
        $_POST['reservasi_id'];

    $alasan =
        trim(
            $_POST['alasan']
        );


    if (

        empty($alasan)

    ) {

        $_SESSION['error'] =
            'Alasan wajib diisi';

    } else {

        $stmtCancel =
            mysqli_prepare(

                $conn,

                "UPDATE reservasi

                SET

                status = 'Dibatalkan',
                alasan_pembatalan = ?

                WHERE

                id = ?
                AND user_id = ?
                AND status = 'Disetujui'"

            );

        mysqli_stmt_bind_param(

            $stmtCancel,

            "sii",

            $alasan,
            $reservasi_id,
            $_SESSION['user_id']

        );

        $success =
            mysqli_stmt_execute(
                $stmtCancel
            );


        if ($success) {

            $_SESSION['success'] =
                'Reservasi berhasil dibatalkan';

        } else {

            $_SESSION['error'] =
                'Terjadi kesalahan';

        }

    }

}


$user_id =
    $_SESSION['user_id'];


//total data
$stmtCount =
    mysqli_prepare(

        $conn,

        "SELECT COUNT(*) as total

        FROM reservasi

        WHERE user_id = ?"

    );

mysqli_stmt_bind_param(

    $stmtCount,

    "i",

    $user_id

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

            labs.nama_lab,

            jadwal.tanggal,
            jadwal.jam_mulai,
            jadwal.jam_selesai

        FROM reservasi

        JOIN jadwal
        ON reservasi.jadwal_id = jadwal.id

        JOIN labs
        ON jadwal.lab_id = labs.id

        WHERE reservasi.user_id = ?

        ORDER BY jadwal.tanggal DESC

        LIMIT ? OFFSET ?"

    );

mysqli_stmt_bind_param(

    $stmt,

    "iii",

    $user_id,
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


<section class="mt-30 px-4 sm:px-6 lg:px-25 min-h-screen">

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

            <p class="
                text-gray-500
                text-sm
                sm:text-base
                lg:text-lg
            ">
                Daftar riwayat reservasi Lab Anda.
            </p>

        </div>


        <!-- tabel -->
        <div class="
            border
            border-gray-300
            rounded-[10px]
            overflow-hidden
            bg-white
            shadow-md
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
                                == 'Pending'
                            ) {

                                $statusClass =
                                    'bg-[#FFF1C2] text-[#BF6A02]';

                            } elseif (
                                $item['status']
                                == 'Disetujui'
                            ) {

                                $statusClass =
                                    'bg-[#CFF7D3] text-[#14AE5C]';

                            }

                            ?>


                            <div class="
                                grid
                                grid-cols-5
                                items-stretch
                            ">

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


                                <!-- status -->
                                <div class="
                                    py-6
                                    px-4
                                    border-r
                                    border-gray-300
                                ">

                                    <div class="
                                        flex
                                        justify-center
                                        items-center
                                    ">

                                        <span class="
                                            px-4
                                            py-2
                                            rounded-full
                                            font-medium
                                            text-center
                                            w-full
                                            <?= $statusClass ?>
                                        ">

                                            <?= $item['status'] ?>

                                        </span>

                                    </div>

                                </div>


                                <!-- aksi -->
                                <div class="
                                    py-6
                                    px-4
                                ">

                                    <div class="
                                        flex
                                        justify-center
                                        items-center
                                        gap-3
                                    ">

                                        <?php if (
                                            $item['status']
                                            == 'Pending'
                                        ): ?>

                                            <button onclick="openDeleteModal(<?= $item['id'] ?>)" class="
                                                px-6
                                                py-2
                                                rounded-full
                                                bg-[#FDD3D0]
                                                font-medium
                                                hover:opacity-80
                                                cursor-pointer
                                            ">

                                                Batalkan

                                            </button>

                                        <?php elseif (
                                            $item['status']
                                            == 'Disetujui'
                                        ): ?>

                                            <button data-code="<?= $item['kode_reservasi'] ?>" data-date="<?= date(
                                                  'd F Y',
                                                  strtotime($item['tanggal'])
                                              ) ?>" data-time="<?= substr(
                                                   $item['jam_mulai'],
                                                   0,
                                                   5
                                               ) ?>

    -

    <?= substr(
                        $item['jam_selesai'],
                        0,
                        5
                    ) ?>" onclick="
        openCodeModal(this)
    " class="
                                                w-11
                                                h-11
                                                rounded-full
                                                bg-[#D9F8DB]
                                                flex
                                                items-center
                                                justify-center
                                                hover:opacity-80
                                                cursor-pointer
                                            ">

                                                <i data-lucide="file-text" class="text-[#14AE5C]"></i>

                                            </button>

                                            <button onclick="
                                                                openCancelModal(
                                                                    <?= $item['id'] ?>
                                                                )
                                                            " class="
                                                w-11
                                                h-11
                                                rounded-full
                                                bg-[#FFD6D6]
                                                flex
                                                items-center
                                                justify-center
                                                hover:opacity-80
                                                cursor-pointer
                                            ">

                                                <i data-lucide="x" class="text-[#900B09]"></i>

                                            </button>

                                        <?php else: ?>

                                            <span class="
                                                px-6
                                                py-2
                                                rounded-full
                                                border
                                                border-[#FDD3D0]
                                                text-[#900B09]
                                                font-medium
                                            ">

                                                Dibatalkan

                                            </span>

                                        <?php endif; ?>

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

                            Belum ada riwayat reservasi.

                        </div>

                    <?php endif; ?>

                </div>

            </div>


            <!-- mobile -->
            <div class="md:hidden">

                <?php
                mysqli_data_seek($result, 0);
                ?>

                <?php if (
                    mysqli_num_rows($result)
                    > 0
                ): ?>

                    <div class="
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
                                $item['status']
                                == 'Pending'
                            ) {

                                $statusClass =
                                    'bg-[#FFF1C2] text-[#BF6A02]';

                            } elseif (
                                $item['status']
                                == 'Disetujui'
                            ) {

                                $statusClass =
                                    'bg-[#CFF7D3] text-[#14AE5C]';

                            }

                            ?>


                            <div class="
                                p-5
                                flex
                                flex-col
                                gap-5
                            ">

                                <!-- top -->
                                <div class="
                                    flex
                                    justify-between
                                    items-start
                                    gap-4
                                ">

                                    <div class="
                                        flex
                                        flex-col
                                        gap-1
                                        min-w-0
                                    ">

                                        <h2 class="
                                            font-bold
                                            text-lg
                                            wrap-break-word
                                        ">

                                            <?= htmlspecialchars(
                                                $item['nama_lab']
                                            ) ?>

                                        </h2>

                                        <p class="
                                            text-sm
                                            text-gray-500
                                        ">

                                            <?= date(

                                                'd F Y',

                                                strtotime(
                                                    $item['tanggal']
                                                )

                                            ) ?>

                                        </p>

                                    </div>


                                    <span class="
                                        px-4
                                        py-2
                                        rounded-full
                                        text-sm
                                        font-medium
                                        whitespace-nowrap
                                        <?= $statusClass ?>
                                    ">

                                        <?= $item['status'] ?>

                                    </span>

                                </div>


                                <!-- jam -->
                                <div class="
                                    text-sm
                                    text-gray-600
                                ">

                                    Jam:

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
                                    flex
                                    justify-end
                                    gap-3
                                    flex-wrap
                                ">

                                    <?php if (
                                        $item['status']
                                        == 'Pending'
                                    ): ?>

                                        <button onclick="openDeleteModal(<?= $item['id'] ?>)" class="
                                            px-5
                                            py-2
                                            rounded-full
                                            bg-[#FDD3D0]
                                            text-sm
                                            font-medium
                                        ">

                                            Batalkan

                                        </button>

                                    <?php elseif (
                                        $item['status']
                                        == 'Disetujui'
                                    ): ?>

                                        <button data-code="<?= $item['kode_reservasi'] ?>" data-date="<?= date(
                                              'd F Y',
                                              strtotime($item['tanggal'])
                                          ) ?>" data-time="<?= substr(
                                               $item['jam_mulai'],
                                               0,
                                               5
                                           ) ?>

                                                    -

                                                    <?= substr(
                                                        $item['jam_selesai'],
                                                        0,
                                                        5
                                                    ) ?>" onclick="
                                                        openCodeModal(this)
                                                    " class="
                                            w-10
                                            h-10
                                            rounded-full
                                            bg-[#CFF7D3]
                                            flex
                                            items-center
                                            justify-center
                                        ">

                                            <i data-lucide="file-text" class="text-[#14AE5C]"></i>

                                        </button>

                                        <button class="
                                            w-10
                                            h-10
                                            rounded-full
                                            bg-[#FDD3D0]
                                            flex
                                            items-center
                                            justify-center
                                        " onclick="
                                                    openCancelModal(
                                                        <?= $item['id'] ?>
                                                    )
                                                ">

                                            <i data-lucide="x" class="text-[#900B09]"></i>

                                        </button>

                                    <?php else: ?>

                                        <span class="
                                            px-5
                                            py-2
                                            rounded-full
                                            border
                                            border-[#FDD3D0]
                                            text-[#900B09]
                                            text-sm
                                            font-medium
                                        ">

                                            Dibatalkan

                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endwhile; ?>

                    </div>

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

    </div>

</section>

<!-- modal kode reservasi -->
<div id="codeModal" class="
        fixed
        inset-0
        bg-black/40
        hidden
        items-center
        justify-center
        z-50
        px-3
        md:px-5
    ">

    <div class="
        bg-white
        rounded-[35px]
        w-full
        max-w-260
        p-5
        md:p-10
        relative
    ">

        <button onclick="
                closeCodeModal()
            " class="
                absolute
                right-8
                top-6
                text-4xl
                cursor-pointer
            ">

            <i data-lucide="x"></i>

        </button>


        <div class="
            flex
            flex-col
            items-center
            text-center
            gap-5
        ">

            <h1 id="modalCode" class="
                    text-4xl
                    md:text-5xl
                    xl:text-6xl
                    font-bold
                ">
            </h1>


            <p id="modalDate" class="
                    text-xl
                    lg:text-2xl
                    font-medium
                ">

            </p>

            <p class="font-light lg:text-2xl text-xl text-[#767676] text-center">Berikan kode ini ke staf TU untuk
                mengambil kunci
                lab dan jangan
                lupa kembalikan kuncinya!</p>

        </div>

    </div>

</div>



<!-- modal hapus (batalkan waktu pending) -->
<div id="deleteModal" class="
        fixed
        inset-0
        bg-black/40
        hidden
        items-center
        justify-center
        z-50
        px-3
        md:px-5
    ">

    <div class="
        bg-white
        rounded-[35px]
        w-full
        max-w-260
        p-4
        md:p-8
    ">

        <form method="POST">

            <input type="hidden" name="reservasi_id" id="deleteReservasiId">


            <div class="
                flex
                flex-col
                items-center
                text-center
                gap-8
                md:gap-10
            ">

                <h1 class="
                    text-4xl
                    md:text-5xl
                    xl:text-6xl
                    font-bold
                ">
                    Batalkan Ajuan
                </h1>


                <p class="
                    text-lg
                    md:text-xl
                    xl:text-2xl
                    text-gray-500
                    text-center
                ">
                    Pembatalan Ajuan Reservasi akan menghapus entri ajuan dalam Riwayat Reservasi kamu. Tindakan ini
                    tidak dapat dibatalkan. Apakah kamu yakin ingin melanjutkan pembatalan ajuan reservasi ini?
                </p>


                <div class="
                    flex
                    gap-4
                    w-full
                ">


                    <button type="submit" name="hapus_pending" class="
                            flex-1
                            bg-[#FDD3D0]
                            rounded-full
                            py-2
                            hover:bg-[#fd9790]
                            cursor-pointer
                        ">

                        Iya

                    </button>

                    <button type="button" onclick="
                            closeDeleteModal()
                        " class="
                            flex-1
                            border-2
                            border-gray-300
                            hover:bg-gray-300
                            rounded-full
                            py-2
                            cursor-pointer
                        ">

                        Tidak

                    </button>


                </div>

            </div>

        </form>

    </div>

</div>



<!-- modal batalakn setelah disetujui -->
<div id="cancelModal" class="
        fixed
        inset-0
        bg-black/40
        hidden
        items-center
        justify-center
        z-50
        px-3
        md:px-5
    ">

    <div class="
        bg-white
        rounded-[35px]
        w-full
        max-w-260
        p-5
        md:p-10
    ">

        <form method="POST" class="
                flex
                flex-col
                gap-6
            ">

            <input type="hidden" name="reservasi_id" id="cancelReservasiId">


            <h1 class="
                    text-4xl
                    md:text-5xl
                    xl:text-6xl
                    font-bold
                    text-center
            ">
                Batalkan Reservasi
            </h1>
            <div class="flex flex-col gap-2">
                <label class="text-lg md:text-xl lg:text-3xl">Alasan<span class="text-[#EC221F]">*</span></label>
                <textarea name="alasan" required rows="1" placeholder="Isi alasan pembatalan" class="
                    border
                    border-gray-300
                    rounded-2xl
                    p-5
                    shadow-lg
                    resize-none
                "></textarea>
            </div>

            <p class="
                text-center
                text-gray-500
            ">
                Apakah anda yakin ingin
                membatalkan reservasi ini?
            </p>


            <div class="
                flex
                gap-4
            ">

                <button type="button" onclick="
                        closeCancelModal()
                    " class="
                        flex-1
                        border
                        border-gray-300
                        hover:bg-gray-300
                        rounded-full
                        py-2
                        cursor-pointer
                    ">

                    Kembali

                </button>


                <button type="submit" name="batalkan_disetujui" class="
                        flex-1
                        bg-[#FDD3D0]
                        rounded-full
                        py-2
                        hover:opacity-80
                        cursor-point
                    ">

                    Konfirmasi

                </button>

            </div>

        </form>

    </div>

</div>