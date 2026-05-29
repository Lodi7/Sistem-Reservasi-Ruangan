<?php

$page = 'ajukan_reservasi';

include __DIR__ .
    '/../config/config.php';

// submit
if (

    isset($_POST['ajukan'])

) {

    // user
    $user_id =
        $_SESSION['user_id'];


    // lab id
    $lab_id =
        $_POST['lab_id']
        ?? '';

    $tanggal =
        $_POST['tanggal']
        ?? '';

    $sesi =
        $_POST['sesi']
        ?? '';

    $dosen =
        trim(
            $_POST['dosen']
            ?? ''
        );

    $kontak =
        trim(
            $_POST['kontak']
            ?? ''
        );

    $keperluan =
        trim(
            $_POST['keperluan']
            ?? ''
        );


    // validasi
    if (

        empty($lab_id)
        ||

        empty($tanggal)
        ||

        empty($sesi)
        ||

        empty($dosen)
        ||

        empty($kontak)
        ||

        empty($keperluan)

    ) {

        $_SESSION['error'] =
            'Semua field wajib diisi';

    } else {

        // ambil jadwal dan kode lab
        $stmtJadwal =
            mysqli_prepare(

                $conn,

                "SELECT

                    jadwal.*,
                    labs.kode_lab

                FROM jadwal

                JOIN labs
                ON jadwal.lab_id = labs.id

                WHERE

                jadwal.lab_id = ?
                AND jadwal.tanggal = ?
                AND jadwal.sesi = ?

                LIMIT 1"

            );

        mysqli_stmt_bind_param(

            $stmtJadwal,

            "iss",

            $lab_id,
            $tanggal,
            $sesi

        );

        mysqli_stmt_execute(
            $stmtJadwal
        );

        $resultJadwal =
            mysqli_stmt_get_result(
                $stmtJadwal
            );


        // tidak ada jadwal
        if (

            mysqli_num_rows(
                $resultJadwal
            ) == 0

        ) {

            $_SESSION['error'] =
                'Jadwal tidak ditemukan';

        } else {

            $jadwal =
                mysqli_fetch_assoc(
                    $resultJadwal
                );


            // cek reservasi
            $stmtCheck =
                mysqli_prepare(

                    $conn,

                    "SELECT id

                    FROM reservasi

                    WHERE

                    jadwal_id = ?

                    AND status IN (

                        'Pending',
                        'Disetujui',
                        'Belum Ambil Kunci',
                        'Sedang Berlangsung'

                    )"

                );

            mysqli_stmt_bind_param(

                $stmtCheck,

                "i",

                $jadwal['id']

            );

            mysqli_stmt_execute(
                $stmtCheck
            );

            $resultCheck =
                mysqli_stmt_get_result(
                    $stmtCheck
                );


            // sudah dipakai
            if (

                mysqli_num_rows(
                    $resultCheck
                ) > 0

            ) {

                $_SESSION['error'] =
                    'Sesi sudah dipakai';

            } else {

                $nama_file = null;


                // upload file
                if (

                    isset($_FILES['berkas'])

                    &&

                    $_FILES['berkas']['error']
                    == 0

                ) {

                    $tmp =
                        $_FILES['berkas']['tmp_name'];

                    $original =
                        $_FILES['berkas']['name'];

                    $ext =
                        strtolower(

                            pathinfo(

                                $original,
                                PATHINFO_EXTENSION

                            )

                        );


                    // format file
                    $allowed = [

                        'pdf',
                        'doc',
                        'docx',
                        'png',
                        'jpg',
                        'jpeg'

                    ];

                    if (

                        !in_array(
                            $ext,
                            $allowed
                        )

                    ) {

                        $_SESSION['error'] =
                            'Format file tidak didukung';

                    } else {

                        // nama file
                        $nama_file =
                            time()
                            .
                            '-'
                            .
                            uniqid()
                            .
                            '.'
                            .
                            $ext;


                        // upload 
                        move_uploaded_file(

                            $tmp,

                            __DIR__
                            .
                            '/../assets/files/uploads/'
                            .
                            $nama_file

                        );

                    }

                }

                if (

                    !isset($_SESSION['error'])

                ) {

                    // insert database 
                    $stmtInsert =
                        mysqli_prepare(

                            $conn,

                            "INSERT INTO reservasi (

                                user_id,
                                jadwal_id,
                                dosen_penanggung_jawab,
                                kontak,
                                keperluan,
                                berkas,
                                status

                            )

                            VALUES (

                                ?, ?, ?, ?, ?, ?, 'Pending'

                            )"

                        );

                    mysqli_stmt_bind_param(

                        $stmtInsert,

                        "iissss",

                        $user_id,
                        $jadwal['id'],
                        $dosen,
                        $kontak,
                        $keperluan,
                        $nama_file

                    );

                    $success =
                        mysqli_stmt_execute(
                            $stmtInsert
                        );


                    if ($success) {

                        // id reservasi
                        $reservasi_id =
                            mysqli_insert_id(
                                $conn
                            );


                        // kode reservasi
                        $kode_reservasi =

                            $jadwal['kode_lab']
                            .
                            '-'
                            .
                            $reservasi_id;


                        // update kode
                        $stmtKode =
                            mysqli_prepare(

                                $conn,

                                "UPDATE reservasi

                                SET kode_reservasi = ?

                                WHERE id = ?"

                            );

                        mysqli_stmt_bind_param(

                            $stmtKode,

                            "si",

                            $kode_reservasi,
                            $reservasi_id

                        );

                        mysqli_stmt_execute(
                            $stmtKode
                        );


                        $_SESSION['success'] =
                            'Reservasi berhasil diajukan';

                        header("Location: index.php?page=riwayat_reservasi");

                        exit;

                    }

                    $_SESSION['error'] =
                        'Terjadi kesalahan';

                }

            }

        }

    }

}

include __DIR__ .
    '/../components/data_jadwal.php';

?>


<section class="mt-20 px-5 sm:px-15 md:px-25">
    <div class="flex flex-col items-center justify-center text-center max-w-full gap-6.25 py-10">
        <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold">
            Form Reservasi
        </h1>

        <!-- error -->
        <?php if (
            isset($_SESSION['error'])
        ): ?>

            <div class="
                    bg-[#FFD6D6]
                    text-[#F04D23]
                    px-5
                    py-4
                    rounded-2xl
                    font-medium
                    w-full
                ">

                <?= $_SESSION['error'] ?>

            </div>

            <?php
            unset(
                $_SESSION['error']
            );
            ?>

        <?php endif; ?>



        <form id="reservasiForm" method="POST" enctype="multipart/form-data" class="
    grid
    grid-cols-1
    xl:grid-cols-3
    gap-6
    w-full
    items-start
">

            <!-- input kolom 1 -->
            <div class="flex flex-col gap-6">

                <!-- pilih lab -->
                <div class="flex flex-col gap-2 items-start">

                    <label class="
                text-lg
                font-semibold
            ">
                        Pilih Lab
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative w-full">

                        <select id="reservasiLab" name="lab_id" required class="
                        w-full
                        border
                        border-gray-300
                        rounded-2xl
                        px-5
                        py-4
                        appearance-none
                        text-sm    
                        sm:text-base    
                        text-gray-600
                    ">

                            <?php foreach ($labs as $lab): ?>

                                <option value="<?= $lab['id'] ?>">

                                    <?= htmlspecialchars($lab['nama_lab']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                        <i data-lucide="chevron-down" class="
                        absolute
                        right-5
                        top-1/2
                        -translate-y-1/2
                        pointer-events-none
                        text-gray-400
                    "></i>

                    </div>

                </div>


                <!-- kalender -->
                <div class="
            bg-white
            flex
            flex-col
            gap-2
            items-start
        ">

                    <label class="
                text-xl
                font-semibold
            ">
                        Pilih Tanggal
                        <span class="text-red-500">*</span>
                    </label>

                    <div id="reservasiTanggal"></div>

                    <input type="hidden" name="tanggal" id="tanggalInput">

                    <!-- arti warna -->
                    <div class="
                flex
                flex-wrap
                gap-5
                mt-2
                
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

                </div>

            </div>


            <!-- input kolom 2 -->
            <div class="flex flex-col gap-6">

                <!-- dosen -->
                <div class="flex flex-col gap-2 items-start">

                    <label class="
                text-lg
                font-semibold
            ">
                        Dosen Penanggung Jawab
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="dosen" required placeholder="XXXXXXXX" class="
                    w-full
                    border
                    border-gray-300
                    rounded-2xl
                    text-sm
                    sm:text-base
                    px-5
                    py-4
                    text-gray-700
                ">

                </div>


                <!-- sesi -->
                <div class="
            bg-white
            border
            border-gray-200
            rounded-[28px]
            p-6
            flex
            flex-col
            gap-5
            shadow-sm
            h-full
            items-start
        ">

                    <label class="
                text-xl
                font-semibold
            ">
                        Pilih Sesi
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="
                sesiContainer
                flex
                flex-col
                gap-5
                w-full
            ">

                    </div>

                </div>

            </div>


            <!-- input kolom 3 -->
            <div class="
        flex
        flex-col
        gap-6
        h-full
    ">

                <!-- kontak -->
                <div class="flex flex-col gap-2 items-start">

                    <label class="
                text-lg
                font-semibold
            ">
                        Kontak
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="kontak" required placeholder="08xxxxxxxxxx" class="
                    w-full
                    border
                    border-gray-300
                    rounded-2xl
                    text-sm
                    sm:text-base
                    px-5
                    py-4
                    text-gray-700
                ">

                </div>


                <!-- keperluan -->
                <div class="
            flex
            flex-col
            gap-2
            items-start
        ">

                    <label class="
                text-lg
                font-semibold
            ">
                        Keperluan
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea name="keperluan" required placeholder="Isi Keperluan" class="
                    w-full
                    min-h-40
                    md:min-h-55
                    xl:min-h-95
                    border
                    border-gray-300
                    rounded-2xl
                    text-sm
                    sm:text-base
                    px-5
                    py-4
                    resize-none
                    text-gray-700
                "></textarea>

                </div>


                <!-- upload -->
                <div class="
            flex
            flex-col
            gap-2
            items-start
        ">

                    <label class="
                text-lg
                font-semibold
            ">
                        Upload Berkas <span class="font-light">(Opsional)</span>
                    </label>

                    <input type="file" name="berkas" class="
                    w-full
                    border
                    border-gray-300
                    rounded-2xl
                    px-5
                    py-3
                    text-gray-500
                ">

                </div>


            </div>


            <!-- ringkasan -->
            <div class="
        bg-white
        border
        border-gray-200
        rounded-3xl
        p-4
        gap-4
        shadow-sm
        xl:col-span-2
    ">
                <h1 class="text-2xl font-bold flex items-start">Ringkasan Reservasi</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 ">
                    <!-- lab -->
                    <div class="
            flex
            gap-2
        "> <i data-lucide="building"></i>
                        <div class="flex flex-col gap-1 items-start">
                            <span class="text-lg font-medium">
                                Lab
                            </span>
                            <p id="summaryLab" class="text-sm"></p>
                        </div>

                    </div>


                    <!-- tanggal -->
                    <div class="
            flex
            gap-2
        "> <i data-lucide="calendar-days"></i>
                        <div class="flex flex-col gap-1 items-start">
                            <span class="text-lg font-medium">
                                Tanggal
                            </span>

                            <p id="summaryTanggal" class="text-sm"></p>
                        </div>

                    </div>


                    <!-- sesi -->
                    <div class="flex gap-2">
                        <i data-lucide="clock-3"></i>
                        <div class="flex flex-col gap-1 items-start">
                            <span class="text-lg font-medium">
                                Sesi
                            </span>

                            <p id="summarySesi" class="text-sm">
                                -
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- submit -->
            <button type="submit" name="ajukan" class="
                mt-auto
                bg-[#FF925C]
                hover:bg-[#ff7d3c]
                text-white
                rounded-full
                py-4
                w-full
                font-semibold
                text-lg
                transition
                cursor-pointer
            ">

                Ajukan Reservasi

            </button>

        </form>
    </div>
</section>