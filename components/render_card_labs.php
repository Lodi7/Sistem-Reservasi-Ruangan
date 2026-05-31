<?php

session_start();
include __DIR__ . "/../config/config.php";

$query = mysqli_query(
    $conn,
    "SELECT *
    FROM labs
    ORDER BY RAND()
    LIMIT 3"
);

while (
    $lab = mysqli_fetch_assoc($query)
) {

    $id = $lab['id'];
    $nama =
        $lab['nama_lab'];

    $gambar =
        $lab['gambar'];

    $status =
        $lab['status'];

    $kategori =
        $lab['kategori'];

    $luas =
        $lab['luas'];

    $kapasitas =
        $lab['kapasitas'];

    $lokasi =
        str_replace(

            [
                'Gedung ',
                ' UPNVJT'
            ],

            '',

            $lab['lokasi']

        );

    $jam_buka =
        substr(
            $lab['jam_buka'],
            0,
            5
        );

    $jam_tutup =
        substr(
            $lab['jam_tutup'],
            0,
            5
        );

    $fasilitas_raw =
        explode(
            ",",
            $lab['fasilitas']
        );

    $fasilitas =
        array_slice(
            $fasilitas_raw,
            0,
            3
        );

    $fasilitas =
        array_map(

            function ($item) {

                $item = preg_replace(
                    '/^\d+\s*/',
                    '',
                    trim($item)
                );

                return $item;

            },

            $fasilitas

        );

    $slug = $lab['slug'];

    include __DIR__ .
        "/card_lab.php";

}