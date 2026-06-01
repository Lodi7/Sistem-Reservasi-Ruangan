<?php
$page = 'manajemen_operasional';

include __DIR__ . '/../../config/config.php';

if (

    isset($_POST['tambah_lab'])

) {

    $namaLab =
        trim(
            $_POST['nama_lab']
        );

    $kapasitas =
        (int) $_POST['kapasitas'];

    $luas =
        (int) $_POST['luas'];

    $lokasi =
        trim(
            $_POST['lokasi']
        );

    $status =
        trim(
            $_POST['status']
        );
    $kategori =
        trim(
            $_POST['kategori']
        );
    $fasilitas =
        trim(
            $_POST['fasilitas']
        );

    $deskripsi =
        trim(
            $_POST['deskripsi']
        );

    $jamBuka =
        $_POST['jam_buka'];

    $jamTutup =
        $_POST['jam_tutup'];

    if (
        strtotime($jamBuka) < strtotime('07:00:00')
        ||
        strtotime($jamBuka) > strtotime('08:00:00')
    ) {

        $_SESSION['error'] =
            'Jam buka harus antara 07:00 - 08:00 WIB';

        header('Location: ?page=manajemen_operasional');
        exit;
    }

    if (
        strtotime($jamTutup) < strtotime('15:00:00')
        ||
        strtotime($jamTutup) > strtotime('16:00:00')
    ) {

        $_SESSION['error'] =
            'Jam tutup harus antara 15:00 - 16:00 WIB';

        header('Location: ?page=manajemen_operasional');
        exit;
    }

    if (
        strtotime($jamBuka) >= strtotime($jamTutup)
    ) {

        $_SESSION['error'] =
            'Jam buka harus lebih kecil dari jam tutup';

        header('Location: ?page=manajemen_operasional');
        exit;
    }

    // Generate Kode Lab
    $kata =
        preg_split(
            '/\s+/',
            $namaLab
        );

    if (

        count($kata) == 2

        &&

        strtolower($kata[0]) === 'lab'

    ) {

        $kodeLab =
            strtoupper(
                $kata[1]
            );

    } else {

        $kodeLab = '';

        foreach (

            $kata
            as $item

        ) {

            $kodeLab .=
                strtoupper(
                    substr(
                        $item,
                        0,
                        1
                    )
                );

        }

    }
    // Generate Slug
    $slug =
        strtolower(

            preg_replace(

                '/[^a-z0-9]+/i',

                '-',

                trim(
                    $namaLab
                )

            )

        );

    $gambarPath = '';

    if (

        isset($_FILES['gambar'])

        &&

        $_FILES['gambar']['error'] === 0

    ) {

        $namaFile =
            basename(
                $_FILES['gambar']['name']
            );

        $folder =
            __DIR__ .
            '/../../assets/images/uploads/labs/';

        if (

            !is_dir(
                $folder
            )

        ) {

            mkdir(

                $folder,

                0777,

                true

            );

        }

        move_uploaded_file(

            $_FILES['gambar']['tmp_name'],

            $folder .
            $namaFile

        );

        $gambarPath =
            'assets/images/uploads/labs/' .
            $namaFile;

    }

    // tambah lab
    $stmtTambah =
        mysqli_prepare(

            $conn,

            "INSERT INTO labs (

                nama_lab,
                kode_lab,
                kategori,
                lokasi,
                luas,
                kapasitas,
                fasilitas,
                deskripsi,
                gambar,
                jam_buka,
                jam_tutup,
                status,
                slug

            )

            VALUES (

                ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?

            )"

        );

    mysqli_stmt_bind_param(

        $stmtTambah,

        "ssssiisssssss",

        $namaLab,
        $kodeLab,
        $kategori,
        $lokasi,
        $luas,
        $kapasitas,
        $fasilitas,
        $deskripsi,
        $gambarPath,
        $jamBuka,
        $jamTutup,
        $status,
        $slug

    );

    if (mysqli_stmt_execute($stmtTambah)) {

        require_once __DIR__ . '/../../scripts/generate_jadwal.php';

        $_SESSION['success'] =
            'Lab berhasil ditambahkan';

    } else {

        $_SESSION['error'] =
            'Gagal menambahkan lab: ' .
            mysqli_stmt_error($stmtTambah);
    }

    header('Location: ?page=manajemen_operasional');
    exit;

}

// edit lab
if (isset($_POST['edit_lab'])) {

    $id =
        (int) $_POST['id'];

    $namaLab =
        trim(
            $_POST['nama_lab']
        );

    $kapasitas =
        (int) $_POST['kapasitas'];

    $luas =
        (int) $_POST['luas'];

    $lokasi =
        trim(
            $_POST['lokasi']
        );

    $status =
        trim(
            $_POST['status']
        );
    $kategori =
        trim(
            $_POST['kategori']
        );
    $fasilitas =
        trim(
            $_POST['fasilitas']
        );

    $deskripsi =
        trim(
            $_POST['deskripsi']
        );

    $jamBuka =
        $_POST['jam_buka'];

    $jamTutup =
        $_POST['jam_tutup'];


    if (
        strtotime($jamBuka) < strtotime('07:00:00')
        ||
        strtotime($jamBuka) > strtotime('08:00:00')
    ) {

        $_SESSION['error'] =
            'Jam buka harus antara 07:00 - 08:00 WIB';

        header('Location: ?page=manajemen_operasional');
        exit;
    }

    if (
        strtotime($jamTutup) < strtotime('15:00:00')
        ||
        strtotime($jamTutup) > strtotime('16:00:00')
    ) {

        $_SESSION['error'] =
            'Jam tutup harus antara 15:00 - 16:00 WIB';

        header('Location: ?page=manajemen_operasional');
        exit;
    }

    if (
        strtotime($jamBuka) >= strtotime($jamTutup)
    ) {

        $_SESSION['error'] =
            'Jam buka harus lebih kecil dari jam tutup';

        header('Location: ?page=manajemen_operasional');
        exit;
    }

    $stmt = mysqli_prepare(

        $conn,

        "SELECT
        jam_buka,
        jam_tutup

    FROM labs

    WHERE id = ?"

    );

    mysqli_stmt_bind_param(

        $stmt,

        "i",

        $id

    );

    mysqli_stmt_execute($stmt);

    $labLama =
        mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt)
        );

    $jamBerubah =

        $labLama['jam_buka'] !== $jamBuka

        ||

        $labLama['jam_tutup'] !== $jamTutup;

    if ($jamBerubah) {

        $stmt = mysqli_prepare(

            $conn,

            "SELECT COUNT(*) total

        FROM reservasi r

        INNER JOIN jadwal j
            ON r.jadwal_id = j.id

        WHERE

        j.lab_id = ?

        AND j.tanggal >= CURDATE()

        AND r.status IN (

            'Pending',
            'Disetujui',
            'Belum Ambil Kunci',
            'Sedang Berlangsung'

        )"

        );

        mysqli_stmt_bind_param(

            $stmt,

            "i",

            $id

        );

        mysqli_stmt_execute($stmt);

        $total =
            mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt)
            )['total'];

        if ($total > 0) {

            $_SESSION['error'] =
                'Jam operasional tidak dapat diubah karena masih ada reservasi aktif.';

            header(
                'Location: ?page=manajemen_operasional'
            );

            exit;
        }
    }

    // Generate Kode Lab

    $kata =
        preg_split(
            '/\s+/',
            $namaLab
        );

    if (

        count($kata) == 2

        &&

        strtolower($kata[0]) === 'lab'

    ) {

        $kodeLab =
            strtoupper(
                $kata[1]
            );

    } else {

        $kodeLab = '';

        foreach (

            $kata
            as $item

        ) {

            $kodeLab .=
                strtoupper(
                    substr(
                        $item,
                        0,
                        1
                    )
                );

        }

    }



    // Generate Slug


    $slug =
        strtolower(

            preg_replace(

                '/[^a-z0-9]+/i',

                '-',

                trim(
                    $namaLab
                )

            )

        );



    // Ambil gambar lama


    $stmt =
        mysqli_prepare(

            $conn,

            "SELECT gambar

            FROM labs

            WHERE id = ?"

        );

    mysqli_stmt_bind_param(

        $stmt,

        "i",

        $id

    );

    mysqli_stmt_execute(
        $stmt
    );

    $result =
        mysqli_stmt_get_result(
            $stmt
        );

    $labLama =
        mysqli_fetch_assoc(
            $result
        );

    $gambarPath =
        $labLama['gambar'];


    // Upload gambar baru

    if (

        isset($_FILES['gambar'])

        &&

        $_FILES['gambar']['error'] === 0

    ) {

        $namaFile =
            basename(
                $_FILES['gambar']['name']
            );

        $folder =
            __DIR__ .
            '/../../assets/images/uploads/labs/';

        move_uploaded_file(

            $_FILES['gambar']['tmp_name'],

            $folder .
            $namaFile

        );

        $gambarPath =
            'assets/images/uploads/labs/' .
            $namaFile;

    }

    // Update Database

    $stmtUpdate =
        mysqli_prepare(

            $conn,

            "UPDATE labs

            SET

                nama_lab = ?,
                kode_lab = ?,
                kategori = ?,
                lokasi = ?,
                luas = ?,
                kapasitas = ?,
                fasilitas = ?,
                deskripsi = ?,
                gambar = ?,
                jam_buka = ?,
                jam_tutup = ?,
                status = ?,
                slug = ?

            WHERE id = ?"

        );

    mysqli_stmt_bind_param(

        $stmtUpdate,

        "ssssiisssssssi",

        $namaLab,
        $kodeLab,
        $kategori,
        $lokasi,
        $luas,
        $kapasitas,
        $fasilitas,
        $deskripsi,
        $gambarPath,
        $jamBuka,
        $jamTutup,
        $status,
        $slug,
        $id

    );

    if (mysqli_stmt_execute($stmtUpdate)) {

        if ($jamBerubah) {

            $stmt = mysqli_prepare(

                $conn,

                "DELETE
        FROM jadwal

        WHERE

        lab_id = ?

        AND tanggal >= CURDATE()"

            );

            mysqli_stmt_bind_param(

                $stmt,

                "i",

                $id

            );

            mysqli_stmt_execute($stmt);

            unset($_SESSION['generate_checked']);

            require_once __DIR__ . '/../../scripts/generate_jadwal.php';
        }

        $_SESSION['success'] = 'Lab berhasil diperbarui';

    } else {

        $_SESSION['error'] = 'Gagal memperbarui lab: ' . mysqli_stmt_error($stmtUpdate);
    }

    header('Location: ?page=manajemen_operasional');
    exit;
}

if (isset($_POST['hapus_lab'])) {

    $id = (int) $_POST['id'];

    // cek reservasi aktif
    $stmt = mysqli_prepare(
        $conn,
        "SELECT COUNT(*) total
         FROM reservasi r
         INNER JOIN jadwal j
            ON r.jadwal_id = j.id
         WHERE j.lab_id = ?
         AND r.status IN (
            'Pending',
            'Disetujui',
            'Belum Ambil Kunci',
            'Sedang Berlangsung'
         )"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $total =
        mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt)
        )['total'];

    if ($total > 0) {

        $_SESSION['error'] =
            'Lab tidak dapat dihapus karena masih memiliki reservasi aktif.';

        header(
            'Location: ?page=manajemen_operasional'
        );

        exit;
    }

    mysqli_begin_transaction($conn);

    try {

        // ambil gambar
        $stmt = mysqli_prepare(
            $conn,
            "SELECT gambar
             FROM labs
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        $lab =
            mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt)
            );

        // hapus seluruh reservasi lab
        $stmt = mysqli_prepare(
            $conn,
            "DELETE r
             FROM reservasi r
             INNER JOIN jadwal j
                ON r.jadwal_id = j.id
             WHERE j.lab_id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        // hapus jadwal nonaktif
        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM jadwal_nonaktif
             WHERE lab_id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        // hapus jadwal
        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM jadwal
             WHERE lab_id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        // hapus lab
        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM labs
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);

        // hapus gambar
        if (
            !empty($lab['gambar']) &&
            file_exists(__DIR__ . '/../../' . $lab['gambar'])
        ) {
            unlink(__DIR__ . '/../../' . $lab['gambar']);
        }

        $_SESSION['success'] =
            'Lab berhasil dihapus permanen';

    } catch (Throwable $e) {

        mysqli_rollback($conn);

        $_SESSION['error'] =
            'Gagal menghapus lab';
    }

    header(
        'Location: ?page=manajemen_operasional'
    );

    exit;
}

// hitung lab aktif
$qTersedia =
    mysqli_query(

        $conn,

        "SELECT COUNT(*) total
        FROM labs
        WHERE status = 'Tersedia'"

    );

$tersedia =
    mysqli_fetch_assoc(
        $qTersedia
    )['total'];


// hitung Perbaikan
$qPerbaikan =
    mysqli_query(

        $conn,

        "SELECT COUNT(*) total
        FROM labs
        WHERE status = 'Perbaikan'"
    );

$perbaikan =
    mysqli_fetch_assoc(
        $qPerbaikan
    )['total'];


// hitung non aktif
$qNonAktif =
    mysqli_query(

        $conn,

        "SELECT COUNT(*) total
        FROM labs
        WHERE status = 'Non-aktif'"

    );

$nonAktif =
    mysqli_fetch_assoc(
        $qNonAktif
    )['total'];

$stats = [

    [
        'title' => 'Total Lab Aktif',
        'value' => $tersedia,
        'text' => 'text-[#14AE5C]',
        'border' => 'border-[#CFF7D3]',
        'background' => 'bg-[#CFF7D3]'
    ],

    [
        'title' => 'Perlu Perbaikan',
        'value' => $perbaikan,
        'text' => 'text-[#BF6A02]',
        'border' => 'border-[#FFF1C2]',
        'background' => 'bg-[#FFF1C2]'
    ],

    [
        'title' => 'Lab Non-aktif',
        'value' => $nonAktif,
        'text' => 'text-[#EC221F]',
        'border' => 'border-[#FDD3D0]',
        'background' => 'bg-[#FDD3D0]'
    ]

];

// ambil data lab
$stmtLabs =
    mysqli_prepare(

        $conn,

        "SELECT *

        FROM labs

        ORDER BY id DESC"

    );

mysqli_stmt_execute(
    $stmtLabs
);

$resultLabs =
    mysqli_stmt_get_result(
        $stmtLabs
    );

?>

<section class="mt-20 px-5 sm:px-15 lg:px-25 min-h-screen py-10">
    <?php if (isset($_SESSION['success'])): ?>

        <div class="
        mb-5
        bg-green-100
        text-green-700
        border
        border-green-300
        p-4
        rounded-xl
    ">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>

        <div class="
        mb-5
        bg-red-100
        text-red-700
        border
        border-red-300
        p-4
        rounded-xl
    ">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>
    <div class="
        flex
        flex-col
        gap-2
        mb-5
    ">

        <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold">
            Manajemen Operasional Lab
        </h1>

    </div>


    <!-- card statistik -->
    <div class="
    grid
    md:grid-cols-4
    gap-5
    xl:gap-17.5
    mb-5
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
        <button id="btnTambahLab" class="text-center text-sm  bg-white rounded-[20px] border-2 shadow p-5 border-black flex justify-center
        lg:text-lg gap-2 items-center cursor-pointer hover:bg-gray-100">
            <i data-lucide="plus" class=""></i>
            <p>Tambah Lab Baru</p>
        </button>

    </div>

    <h2 class="font-medium text-2xl sm:text-3xl lg:text-[36px] mb-5">Daftar Laboratorium</h2>

    <div class="
    flex
    flex-col
    gap-5
    md:gap-7.5
">

        <?php if (
            mysqli_num_rows(
                $resultLabs
            ) > 0
        ): ?>

            <?php while (

                $lab =
                mysqli_fetch_assoc(
                    $resultLabs
                )

            ): ?>

                <?php

                include __DIR__ .
                    '/../../components/card_manajemen.php';

                ?>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="
            border
            border-gray-300
            rounded-[20px]
            p-10
            text-center
            text-gray-500
        ">

                Belum ada laboratorium.

            </div>

        <?php endif; ?>

    </div>

</section>

<!-- modal -->
<?php include __DIR__ . '/../../components/modal_tambah_lab.php'; ?>
<?php include __DIR__ . '/../../components/modal_edit_lab.php'; ?>
<?php include __DIR__ . '/../../components/modal_delete_lab.php'; ?>