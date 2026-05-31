<?php
$page = 'dashboard';

include __DIR__ . '/../../config/config.php';

// hitung pending
$qPending =
    mysqli_query(

        $conn,

        "SELECT COUNT(*) total
        FROM reservasi
        WHERE status = 'Pending'"

    );

$pending =
    mysqli_fetch_assoc(
        $qPending
    )['total'];


// hitung disetujui
$qDisetujui =
    mysqli_query(

        $conn,

        "SELECT COUNT(*) total
        FROM reservasi
        WHERE status IN (
            'Disetujui',
            'Selesai',
            'Belum Ambil Kunci',
            'Sedang Berlangsung',
            'Tidak Hadir'
        )"
    );

$disetujui =
    mysqli_fetch_assoc(
        $qDisetujui
    )['total'];


// hitung ditolak
$qDitolak =
    mysqli_query(

        $conn,

        "SELECT COUNT(*) total
        FROM reservasi
        WHERE status IN (
            'Ditolak',
            'Dibatalkan'
        )"

    );

$ditolak =
    mysqli_fetch_assoc(
        $qDitolak
    )['total'];

// tampilkan reservasi pending
$qReservasi =
    mysqli_query(

        $conn,

        "SELECT

            reservasi.id,

            users.nama,

            jadwal.tanggal,

            labs.nama_lab,

            reservasi.status

        FROM reservasi

        JOIN users
        ON reservasi.user_id = users.id

        JOIN jadwal
        ON reservasi.jadwal_id = jadwal.id

        JOIN labs
        ON jadwal.lab_id = labs.id

        WHERE reservasi.status = 'Pending'

        ORDER BY reservasi.created_at DESC

        LIMIT 5"

    );

$stats = [

    [
        'title' => 'Pending',
        'value' => $pending,
        'text' => 'text-[#BF6A02]',
        'border' => 'border-[#FFF1C2]',
        'background' => 'bg-[#FFF1C2]'
    ],

    [
        'title' => 'Disetujui',
        'value' => $disetujui,
        'text' => 'text-[#14AE5C]',
        'border' => 'border-[#CFF7D3]',
        'background' => 'bg-[#CFF7D3]'
    ],

    [
        'title' => 'Ditolak',
        'value' => $ditolak,
        'text' => 'text-[#EC221F]',
        'border' => 'border-[#FDD3D0]',
        'background' => 'bg-[#FDD3D0]'
    ]

];

?>

<section class="mt-20 px-5 sm:px-15 md:px-25 min-h-screen py-10">
    <div class="
        flex
        flex-col
        gap-2
        mb-10
    ">

        <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold">
            Dashboard Admin
        </h1>

        <p class="text-sm
                sm:text-base
                lg:text-lg
            text-gray-500
        ">
            Selamat Datang,
            <?= htmlspecialchars(
                $_SESSION['nama']
            ) ?>!
        </p>

    </div>


    <!-- card statistik -->
    <div class="
    grid
    md:grid-cols-3
    gap-6
    mb-10
">

        <?php foreach (

            $stats
            as $stat

        ):

            $title =
                $stat['title'];

            $value =
                $stat['value'];

            $textColor =
                $stat['text'];

            $borderColor =
                $stat['border'];

            $backgroundBorder =
                $stat['background'];

            include __DIR__ .
                '/../../components/card_statistik.php';

        endforeach; ?>

    </div>

    <h2 class="font-medium text-2xl sm:text-3xl lg:text-[40px] mb-10">Tabel Permohonan</h2>

    <!-- tabel -->
    <div class="
    border
    border-gray-300
    rounded-[30px]
    overflow-hidden
    bg-white
">

        <!-- Desktop -->
        <div class="hidden md:block">

            <!-- HEADER -->
            <div class="
            grid
            grid-cols-4
            bg-[#FF925C]
            text-white
            font-medium
        ">

                <div class="py-5 text-center text-2xl">
                    Nama
                </div>

                <div class="py-5 text-center text-2xl">
                    Tanggal
                </div>

                <div class="py-5 text-center text-2xl">
                    Lab
                </div>

                <div class="py-5 text-center text-2xl">
                    Status
                </div>

            </div>


            <!-- BODY -->
            <div class="
            divide-y
            divide-gray-300
            text-center
        ">
                <?php if (
                    mysqli_num_rows($qReservasi) > 0
                ): ?>
                    <?php mysqli_data_seek($qReservasi, 0); ?>
                    <?php while (
                        $row =
                        mysqli_fetch_assoc(
                            $qReservasi
                        )
                    ): ?>

                        <div class="
                    grid
                    grid-cols-4
                ">

                            <div class="
                        py-5
                        px-4
                        border-r
                        border-gray-300
                        flex
                        items-center
                        justify-center
                    ">
                                <?= htmlspecialchars($row['nama']) ?>
                            </div>

                            <div class="
                        py-5
                        px-4
                        border-r
                        border-gray-300
                        flex
                        items-center
                        justify-center
                    ">
                                <?= date(
                                    'd F Y',
                                    strtotime($row['tanggal'])
                                ) ?>
                            </div>

                            <div class="
                        py-5
                        px-4
                        border-r
                        border-gray-300
                        flex
                        items-center
                        justify-center
                    ">
                                <?= htmlspecialchars(
                                    $row['nama_lab']
                                ) ?>
                            </div>

                            <div class="
                        flex
                        items-center
                        justify-center
                    ">
                                <span class="
                            px-5
                            py-2
                            rounded-full
                            bg-[#FFF1CC]
                            text-[#D18B1F]
                            font-medium
                        ">
                                    <?= $row['status'] ?>
                                </span>
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

                        Tidak ada permohonan terbaru.

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- Mobile -->
        <div class="
        md:hidden
        divide-y
        divide-gray-300
    ">

            <?php if (
                mysqli_num_rows($qReservasi) > 0
            ): ?>
                <?php mysqli_data_seek($qReservasi, 0); ?>

                <?php while (
                    $row =
                    mysqli_fetch_assoc(
                        $qReservasi
                    )
                ): ?>

                    <div class="
                p-5
                flex
                flex-col
                gap-3
            ">

                        <div>
                            <p class="text-xs text-gray-500">
                                Nama
                            </p>

                            <p class="font-medium">
                                <?= htmlspecialchars(
                                    $row['nama']
                                ) ?>
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Tanggal
                            </p>

                            <p>
                                <?= date(
                                    'd F Y',
                                    strtotime(
                                        $row['tanggal']
                                    )
                                ) ?>
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Laboratorium
                            </p>

                            <p>
                                <?= htmlspecialchars(
                                    $row['nama_lab']
                                ) ?>
                            </p>
                        </div>


                        <div>
                            <span class="
                        px-4
                        py-2
                        rounded-full
                        bg-[#FFF1CC]
                        text-[#D18B1F]
                        text-sm
                        font-medium
                    ">
                                <?= $row['status'] ?>
                            </span>
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

                    Tidak ada permohonan terbaru.

                </div>

            <?php endif; ?>
        </div>

    </div>

</section>