<?php

$page = 'detail_reservasi';

include __DIR__ . '/../../config/config.php';

// cek ada id tidak
if (

    !isset($_GET['id'])

) {

    header('Location: ?page=kelola_permohonann');
    exit;
}

$reservasiId =
    (int) $_GET['id'];

// terima reservasi
if (

    isset($_POST['terima'])

) {

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

            users.nama,

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
        md:grid-cols-2
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

                    <a href="<?= $data['berkas'] ?>" target="_blank" class="
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

    </div>


    <form method="POST" class="
        flex
        justify-end
        gap-7.5
        lg:gap-5
        mt-10
        flex-wrap
    ">

        <a href="?page=kelola_permohonan" class="
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

</section>