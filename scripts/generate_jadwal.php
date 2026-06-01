<?php

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

    $lab_id = $lab['id'];

    $jamBuka = strtotime($lab['jam_buka']);
    $jamTutup = strtotime($lab['jam_tutup']);

    $jamIstirahatMulai = strtotime('12:00:00');
    $jamIstirahatSelesai = strtotime('13:00:00');

    $durasiPagi =
        $jamIstirahatMulai - $jamBuka;

    $durasiSesiPagi =
        floor($durasiPagi / 2);

    $sesi1Selesai =
        $jamBuka + $durasiSesiPagi;

    $sesi = [

        [
            'nama' => 'Sesi 1',
            'mulai' => date('H:i:s', $jamBuka),
            'selesai' => date('H:i:s', $sesi1Selesai)
        ],

        [
            'nama' => 'Sesi 2',
            'mulai' => date('H:i:s', $sesi1Selesai),
            'selesai' => '12:00:00'
        ],

        [
            'nama' => 'Sesi 3',
            'mulai' => '13:00:00',
            'selesai' => date('H:i:s', $jamTutup)
        ]

    ];


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