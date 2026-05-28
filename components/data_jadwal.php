<?php

include __DIR__ . '/../config/config.php';

$today =
    new DateTime();

$endDate =
    (clone $today)
        ->modify('+13 days');


// ambil semua data lab 
$queryLabs = mysqli_query(

    $conn,

    "SELECT *
    FROM labs
    ORDER BY nama_lab ASC"

);


// simpan lab
$labs = [];

while (

    $lab =
    mysqli_fetch_assoc(
        $queryLabs
    )

) {

    $labs[] = $lab;

}

$labsData = [];


// loop lab
foreach (

    $labs as $lab

) {

    $lab_id =
        $lab['id'];


    // loop 14 hari
    $current =
        clone $today;


    while (

        $current
        <=
        $endDate

    ) {

        $tanggal =
            $current->format(
                'Y-m-d'
            );


        // ambil data jadwal nonaktif
        $stmtNonaktif =
            mysqli_prepare(

                $conn,

                "SELECT id
                FROM jadwal_nonaktif
                WHERE

                lab_id = ?
                AND tanggal = ?"

            );

        mysqli_stmt_bind_param(

            $stmtNonaktif,

            "is",

            $lab_id,
            $tanggal

        );

        mysqli_stmt_execute(
            $stmtNonaktif
        );

        $nonaktif =
            mysqli_stmt_get_result(
                $stmtNonaktif
            );

        $isNonaktif =
            mysqli_num_rows(
                $nonaktif
            ) > 0;


        // ambil data jadwal
        $stmtJadwal =
            mysqli_prepare(

                $conn,

                "SELECT *
                FROM jadwal
                WHERE

                lab_id = ?
                AND tanggal = ?

                ORDER BY jam_mulai ASC"

            );

        mysqli_stmt_bind_param(

            $stmtJadwal,

            "is",

            $lab_id,
            $tanggal

        );

        mysqli_stmt_execute(
            $stmtJadwal
        );

        $resultJadwal =
            mysqli_stmt_get_result(
                $stmtJadwal
            );


        $jadwal = [];


        while (

            $item =
            mysqli_fetch_assoc(
                $resultJadwal
            )

        ) {

            $status =
                'Tersedia';


            // status lab
            if (
                $lab['status']
                == 'Perbaikan'
            ) {

                $status =
                    'Perbaikan';

            } elseif (
                $lab['status']
                == 'Non-aktif'
            ) {

                $status =
                    'Non-aktif';

            } elseif (
                $isNonaktif
            ) {

                $status =
                    'Nonaktif Hari Ini';

            } else {

                // ambil data reservasi
                $stmtReservasi =
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

                    $stmtReservasi,

                    "i",

                    $item['id']

                );

                mysqli_stmt_execute(
                    $stmtReservasi
                );

                $reservasi =
                    mysqli_stmt_get_result(
                        $stmtReservasi
                    );


                if (
                    mysqli_num_rows(
                        $reservasi
                    ) > 0
                ) {

                    $status =
                        'Dipakai';

                }

            }


            $jadwal[] = [

                'sesi' =>
                    $item['sesi'],

                'jam' =>

                    substr(
                        $item['jam_mulai'],
                        0,
                        5
                    )

                    .

                    ' - '

                    .

                    substr(
                        $item['jam_selesai'],
                        0,
                        5
                    ),

                'status' =>
                    $status

            ];

        }

        $isFull = false;
        $isPartial = false;


        if (
            count($jadwal) > 0
        ) {

            $tersedia = 0;


            foreach (
                $jadwal as $j
            ) {

                if (
                    $j['status']
                    == 'Tersedia'
                ) {

                    $tersedia++;

                }

            }


            // cek jadwal apakah penuh
            if (
                $tersedia == 0
            ) {

                $isFull = true;

            }

            // kalau masih tersedia
            else {

                $isPartial = true;

            }

        }


        // render table
        ob_start();

        include __DIR__ .
            '/status_lab_table.php';

        $table =
            ob_get_clean();


        // data tabel
        $labsData[] = [

            'lab_id' =>
                $lab_id,

            'tanggal' =>
                $tanggal,

            'nama_lab' =>
                $lab['nama_lab'],

            'lokasi' =>

                str_replace(

                    [
                        'Gedung ',
                        ' UPNVJT'
                    ],

                    '',

                    $lab['lokasi']

                ),

            'jadwal' =>
                $jadwal,

            'is_full' =>
                $isFull,

            'is_partial' =>
                $isPartial,

            'table' =>
                $table

        ];

        $current->modify(
            '+1 day'
        );

    }

}
?>