<?php

include __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/mailer.php';

// Pending -> Ditolak (Jika jam mulai reservasi sudah lewat)
$qPending =
    mysqli_query(

        $conn,

        "SELECT

            users.nama,
            users.email,

            labs.nama_lab,

            jadwal.tanggal,
            jadwal.jam_mulai

        FROM reservasi

        JOIN users
        ON reservasi.user_id = users.id

        JOIN jadwal
        ON reservasi.jadwal_id = jadwal.id

        JOIN labs
        ON jadwal.lab_id = labs.id

        WHERE

            reservasi.status = 'Pending'

            AND

            CONCAT(

                jadwal.tanggal,
                ' ',
                jadwal.jam_mulai

            ) < NOW()"

    );

while (

    $row =
    mysqli_fetch_assoc(
        $qPending
    )

) {

    kirimEmail(

        $row['email'],

        'Status Reservasi Anda',

        "

        <h2>Status Reservasi</h2>

        <p>
            Halo {$row['nama']},
        </p>

        <p>

            Permohonan reservasi Anda untuk

            <b>{$row['nama_lab']}</b>

            tidak dapat diproses karena waktu reservasi yang diajukan sudah terlewati.

        </p>

        <p>

            Silakan melakukan pengajuan reservasi kembali apabila masih diperlukan disesi lainnya.

        </p>

        <p>
            Terima kasih.
        </p>

        "

    );

}

mysqli_query(

    $conn,

    "UPDATE reservasi

    JOIN jadwal
    ON reservasi.jadwal_id = jadwal.id

    SET reservasi.status = 'Ditolak'

    WHERE

        reservasi.status = 'Pending'

        AND

        CONCAT(

            jadwal.tanggal,
            ' ',
            jadwal.jam_mulai

        ) < NOW()"

);

// Disetujui -> Pengingat H-1
$qPengingatH1 = mysqli_query(

    $conn,

    "SELECT

        reservasi.id,

        users.nama,
        users.email,

        reservasi.kode_reservasi,

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

    WHERE

        reservasi.status = 'Disetujui'

        AND

        reservasi.email_h1_dikirim IS NULL

        AND

        jadwal.tanggal = DATE_ADD(CURDATE(), INTERVAL 1 DAY)"

);

while (

    $row =
    mysqli_fetch_assoc(
        $qPengingatH1
    )

) {

    $isiEmail = "

        <h2>Pengingat Reservasi</h2>

        <p>
            Halo {$row['nama']},
        </p>

        <p>

            Reservasi Anda dijadwalkan berlangsung besok.

        </p>

        <p>

            <b>Lab:</b>
            {$row['nama_lab']}

            <br>

            <b>Tanggal:</b>
            {$row['tanggal']}

            <br>

            <b>Sesi:</b>
            {$row['jam_mulai']}
            -
            {$row['jam_selesai']}

            <br>

            <b>Kode Reservasi:</b>
            {$row['kode_reservasi']}

        </p>

        <p>

            Mohon hadir tepat waktu dan melakukan pengambilan kunci beberapa menit sebelum sesi dimulai.

        </p>

        <p>
            Terima kasih.
        </p>

    ";

    $berhasil = kirimEmail(

        $row['email'],

        'Pengingat Reservasi Besok',

        $isiEmail

    );

    if ($berhasil) {

        $id = (int) $row['id'];

        mysqli_query(

            $conn,

            "UPDATE reservasi

            SET email_h1_dikirim = NOW()

            WHERE id = $id"

        );

    }

}

// Disetujui -> Belum Ambil Kunci (Otomatis berubah Saat hari reservasi tiba)
$qPengingat =
    mysqli_query(

        $conn,

        "SELECT

            users.nama,
            users.email,

            reservasi.kode_reservasi,

            labs.nama_lab,

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

            reservasi.status = 'Disetujui'

            AND

            jadwal.tanggal = CURDATE()"

    );

while (

    $row =
    mysqli_fetch_assoc(
        $qPengingat
    )

) {

    kirimEmail(

        $row['email'],

        'Pengingat Reservasi Hari Ini',

        "

        <h2>Pengingat Reservasi</h2>

        <p>
            Halo {$row['nama']},
        </p>

        <p>

            Reservasi Anda dijadwalkan berlangsung hari ini.

        </p>

        <p>

            <b>Lab:</b>
            {$row['nama_lab']}

            <br>

            <b>Sesi:</b>
            {$row['jam_mulai']}
            -
            {$row['jam_selesai']}

            <br>

            <b>Kode Reservasi:</b>
            {$row['kode_reservasi']}

        </p>

        <p>

            Mohon untuk melakukan pengambilan kunci beberapa menit sebelum sesi dimulai.

        </p>

        <p>
            Terima kasih.
        </p>

        "

    );

}

mysqli_query(

    $conn,

    "UPDATE reservasi

    JOIN jadwal
    ON reservasi.jadwal_id = jadwal.id

    SET reservasi.status = 'Belum Ambil Kunci'

    WHERE

        reservasi.status = 'Disetujui'

        AND

        jadwal.tanggal = CURDATE()"

);


// Belum Ambil Kunci -> Tidak Hadir (Jika Hari Sudah Lewat)
mysqli_query(

    $conn,

    "UPDATE reservasi

    JOIN jadwal
    ON reservasi.jadwal_id = jadwal.id

    SET reservasi.status = 'Tidak Hadir'

    WHERE

        reservasi.status = 'Belum Ambil Kunci'

        AND

        CONCAT(

            jadwal.tanggal,
            ' ',
            jadwal.jam_selesai

        ) < NOW()"

);

// Sedang Berlangsung -> Selesai (Jika Admin lupa merubah ke selesai dan sudah lewat hari ini)
mysqli_query(

    $conn,

    "UPDATE reservasi

    JOIN jadwal
    ON reservasi.jadwal_id = jadwal.id

    SET reservasi.status = 'Selesai'

    WHERE

        reservasi.status = 'Sedang Berlangsung'

        AND

        jadwal.tanggal < CURDATE()"

);