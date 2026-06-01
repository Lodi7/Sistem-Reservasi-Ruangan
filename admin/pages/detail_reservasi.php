<?php

include __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/mailer.php';

// cek ada id tidak
if (

    !isset($_GET['id'])

) {

    header('Location: ?page=kelola_permohonan');
    exit;
}

$reservasiId =
    (int) $_GET['id'];
$from =
    $_GET['from']
    ?? 'dashboard';

$allowedPages = [
    'dashboard',
    'riwayat_reservasi',
    'riwayat_permohonan',
    'kelola_permohonan'

];

if (

    !in_array(
        $from,
        $allowedPages
    )

) {

    $from =
        'dashboard';
}

$page = $from;

// terima reservasi
if (

    isset($_POST['terima'])

) {

    kirimEmail(

        $data['email'],

        'Reservasi Disetujui',

        "

    <h2>Reservasi Disetujui</h2>

    <p>
        Halo {$data['nama']},
    </p>

    <p>

        Permohonan reservasi Anda telah disetujui.

    </p>

    <p>

        <b>Lab:</b>
        {$data['nama_lab']}

        <br>

        <b>Tanggal:</b>
        " . date(
            'd F Y',
            strtotime(
                $data['tanggal']
            )
        ) . "

        <br>

        <b>Sesi:</b>
        {$data['sesi']}

    </p>

    <p>
        Terima kasih.
    </p>

    "

    );

    $stmtApprove =
        mysqli_prepare(

            $conn,

            "UPDATE reservasi

            SET status = 'Disetujui'

            WHERE id = ?
            AND status = 'Pending'"

        );

    mysqli_stmt_bind_param(

        $stmtApprove,

        "i",

        $reservasiId

    );

    mysqli_stmt_execute(
        $stmtApprove
    );

    header("Location: ?page=kelola_permohonan");
    exit;
}

// tolak reservasi
if (

    isset($_POST['tolak'])

) {

    kirimEmail(

        $data['email'],

        'Status Reservasi Anda',

        "

    <h2>Status Reservasi</h2>

    <p>
        Halo {$data['nama']},
    </p>

    <p>

        Mohon maaf,

        permohonan reservasi Anda untuk

        <b>{$data['nama_lab']}</b>

        belum dapat disetujui.

    </p>

    <p>

        Silakan melakukan pengajuan kembali pada jadwal lain apabila diperlukan.

    </p>

    <p>
        Terima kasih.
    </p>

    "

    );

    $stmtReject =
        mysqli_prepare(

            $conn,

            "UPDATE reservasi

            SET status = 'Ditolak'

            WHERE id = ?
            AND status = 'Pending'"

        );

    mysqli_stmt_bind_param(

        $stmtReject,

        "i",

        $reservasiId

    );

    mysqli_stmt_execute(
        $stmtReject
    );

    header("Location: ?page=kelola_permohonan");
    exit;
}

// ambil data detail reservasi
$stmt =
    mysqli_prepare(

        $conn,

        "SELECT

            reservasi.id,
            reservasi.kontak,
            reservasi.dosen_penanggung_jawab,
            reservasi.keperluan,
            reservasi.berkas,
            reservasi.status,
            reservasi.alasan_pembatalan,

            users.nama,
            users.email,

            labs.nama_lab,

            jadwal.tanggal,
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

        WHERE reservasi.id = ?"

    );

mysqli_stmt_bind_param(

    $stmt,

    "i",

    $reservasiId

);

mysqli_stmt_execute(
    $stmt
);

$result =
    mysqli_stmt_get_result(
        $stmt
    );

$data =
    mysqli_fetch_assoc(
        $result
    );

if (!$data) {

    header("Location: ?page=kelola_permohonan");

    exit;
}

?>

<section class="
    mt-20
    px-5
    md:px-15
    py-10
">

    <h1 class="
        text-center
        text-4xl
        md:text-5xl
        font-bold
        mb-5
    ">

        Detail Reservasi

    </h1>


    <div class="
        grid
        md:grid-cols-3
        gap-5
    ">

        <!-- Nama -->
        <div>

            <label class="
                text-sm
                md:text-base
            ">
                Nama
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
            ">

                <?= htmlspecialchars(
                    $data['nama']
                ) ?>

            </div>

        </div>


        <!-- Kontak -->
        <div>

            <label>
                Kontak
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
            ">

                <?= htmlspecialchars(
                    $data['kontak']
                ) ?>

            </div>

        </div>


        <!-- Dosen -->
        <div>

            <label>
                Dosen Penanggung Jawab
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
            ">

                <?= htmlspecialchars(
                    $data['dosen_penanggung_jawab']
                ) ?>

            </div>

        </div>


        <!-- Lab -->
        <div>

            <label>
                Lab
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
            ">

                <?= htmlspecialchars(
                    $data['nama_lab']
                ) ?>

            </div>

        </div>


        <!-- Tanggal -->
        <div>

            <label>
                Tanggal
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
            ">

                <?= date(

                    'd F Y',

                    strtotime(
                        $data['tanggal']
                    )

                ) ?>

            </div>

        </div>


        <!-- Sesi -->
        <div>

            <label>
                Sesi
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
                whitespace-nowrap
            ">
                <?= htmlspecialchars(
                    $data['sesi']
                ) ?>
                (
                <?= substr(
                    $data['jam_mulai'],
                    0,
                    5
                ) ?>

                -

                <?= substr(
                    $data['jam_selesai'],
                    0,
                    5
                ) ?>
                )
            </div>

        </div>

    </div>


    <div class="
        grid
        lg:grid-cols-2
        gap-5
        mt-5
    ">

        <!-- Keperluan -->
        <div>

            <label>
                Keperluan
            </label>

            <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                p-5
                min-h-20
                lg:min-h-50
            ">

                <?= nl2br(
                    htmlspecialchars(
                        $data['keperluan']
                    )
                ) ?>

            </div>

        </div>

        <div class="grid md:grid-rows-2">
            <!-- Berkas -->
            <div>

                <label>
                    Upload Berkas
                </label>

                <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                px-5
                py-3
            ">

                    <?php if (

                        !empty(
                        $data['berkas']
                    )

                    ): ?>

                        <a href="../<?= htmlspecialchars($data['berkas']) ?>" target="_blank" rel="noopener noreferrer"
                            class="
                            text-blue-600
                            underline
                        ">

                            Lihat Berkas

                        </a>

                    <?php else: ?>

                        Tidak ada

                    <?php endif; ?>

                </div>

            </div>
            <?php if ($data['status'] == 'Dibatalkan'): ?>
                <!-- Alasan Pembatalan -->
                <div>

                    <label>
                        Alasan Pembatalan
                    </label>

                    <div class="
                mt-2
                border
                border-gray-300
                rounded-2xl
                p-5
                min-h-20
            ">

                        <?= nl2br(
                            htmlspecialchars(
                                $data['alasan_pembatalan']
                            )
                        ) ?>

                    </div>

                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if ($data['status'] == 'Pending'): ?>
        <form method="POST" class="
        flex
        justify-end
        gap-7.5
        lg:gap-5
        mt-10
        flex-wrap
    ">

            <a href="?page=<?= $from ?>" class="
                px-10
                py-3
                rounded-full
                border
                border-[#FFD991]
                text-[#BF6A02]
                hover:bg-[#FFD991]
            ">

                Kembali

            </a>


            <button type="submit" name="tolak" class="
                px-10
                py-3
                rounded-full
                bg-[#FDD3D0]
                text-[#EC221F]
                cursor-pointer
                hover:opacity-70
            ">

                Tolak

            </button>


            <button type="submit" name="terima" class="
                px-10
                py-3
                rounded-full
                bg-[#CFF7D3]
                text-[#14AE5C]
                cursor-pointer
                hover:opacity-70
            ">

                Terima

            </button>

        </form>
    <?php else: ?>
        <div class="
        flex
        justify-end
        mt-10
    ">

            <a href="?page=<?= $from ?>" class="
                px-10
                py-3
                rounded-full
                border
                border-[#FFD991]
                text-[#BF6A02]
                hover:bg-[#FFD991]
            ">

                Kembali

            </a>
        </div>

    <?php endif; ?>

</section>