<?php

// sesi
$sesi = [

    [
        'nama' => 'Sesi 1',
        'mulai' => '07:00:00',
        'selesai' => '09:30:00'
    ],

    [
        'nama' => 'Sesi 2',
        'mulai' => '09:30:00',
        'selesai' => '12:00:00'
    ],

    [
        'nama' => 'Sesi 3',
        'mulai' => '13:00:00',
        'selesai' => '15:30:00'
    ]

];

$targetTanggal =
    date(
        'Y-m-d',
        strtotime('+14 days')
    );


// ambil data semua lab
$queryLabs = mysqli_query(

    $conn,

    "SELECT *
    FROM labs"

);


// loop lab
while (

    $lab =
    mysqli_fetch_assoc($queryLabs)

) {

    $lab_id =
        $lab['id'];


    // ambil tanggal terakhir 
    $queryLast = mysqli_query(

        $conn,

        "SELECT tanggal
        FROM jadwal
        WHERE lab_id = $lab_id
        ORDER BY tanggal DESC
        LIMIT 1"

    );

    $last =
        mysqli_fetch_assoc(
            $queryLast
        );


    // cek belum ada jadwal
    if (!$last) {

        $currentTanggal =
            date('Y-m-d');

    } else {

        $currentTanggal =
            date(

                'Y-m-d',

                strtotime(
                    $last['tanggal'] .
                    ' +1 day'
                )

            );

    }


    // loop tgl
    while (

        strtotime($currentTanggal)
        <=
        strtotime($targetTanggal)

    ) {

        // hari sabtu dan minggu gk pakai
        // $hari =
        //     date(
        //         'N',
        //         strtotime($currentTanggal)
        //     );

        // if (

        //     $hari != 6 &&
        //     $hari != 7

        // ) {

        // loop sesi
        foreach (

            $sesi
            as $item

        ) {

            // cek duplikat
            $check = mysqli_prepare(

                $conn,

                "SELECT id
                    FROM jadwal
                    WHERE

                    lab_id = ?
                    AND tanggal = ?
                    AND sesi = ?"

            );

            mysqli_stmt_bind_param(

                $check,

                "iss",

                $lab_id,
                $currentTanggal,
                $item['nama']

            );

            mysqli_stmt_execute($check);

            $result =
                mysqli_stmt_get_result(
                    $check
                );

            if (

                mysqli_num_rows(
                    $result
                ) == 0

            ) {

                $stmt = mysqli_prepare(

                    $conn,

                    "INSERT INTO jadwal (

                            lab_id,
                            tanggal,
                            sesi,
                            jam_mulai,
                            jam_selesai

                        )

                        VALUES (?, ?, ?, ?, ?)"

                );

                mysqli_stmt_bind_param(

                    $stmt,

                    "issss",

                    $lab_id,
                    $currentTanggal,
                    $item['nama'],
                    $item['mulai'],
                    $item['selesai']

                );

                mysqli_stmt_execute($stmt);

            }

        }

        // }


        // hari berikutnya
        $currentTanggal =
            date(

                'Y-m-d',

                strtotime(
                    $currentTanggal .
                    ' +1 day'
                )

            );

    }

}