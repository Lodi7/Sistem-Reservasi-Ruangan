<?php

header('Content-Type: application/json');

$dummyData = [

    "2026-05-24" => [

        "Lab PPSTI" => [1],

        "Lab SCR" => [2, 3],

        "Lab Solusi" => [],
        "Lab Rekayasa dan Bisnis Digital" => [2],
        "Lab MSI" => [3],
        "Lab Sains Data" => [1],
        "Lab INSYDE" => []

    ]

];

$tanggal = $_GET['tanggal'] ?? '';

$lab = $_GET['lab'] ?? '';

echo json_encode(

    $dummyData[$tanggal][$lab] ?? []

);