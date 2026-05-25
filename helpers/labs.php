<?php
function getLabs($conn)
{
    $query = mysqli_query(
        $conn,
        "SELECT * FROM labs"
    );

    $labs = [];

    while ($lab = mysqli_fetch_assoc($query)) {

        $lab['lokasi_short'] = str_replace(
            ['Gedung ', ' UPNVJT'],
            '',
            $lab['lokasi']
        );

        $lab['jam_buka_format'] = date(
            'H:i',
            strtotime($lab['jam_buka'])
        );

        $lab['jam_tutup_format'] = date(
            'H:i',
            strtotime($lab['jam_tutup'])
        );

        $fasilitas = explode(
            ',',
            $lab['fasilitas']
        );

        $fasilitas = array_map(function ($item) {

            $nama = preg_replace(
                '/[0-9]+/',
                '',
                $item
            );

            return trim($nama);

        }, $fasilitas);

        $lab['fasilitas_short'] = array_slice(
            $fasilitas,
            0,
            3
        );

        $lab['fasilitas_full'] = $fasilitas;

        $labs[] = $lab;
    }

    return $labs;
}