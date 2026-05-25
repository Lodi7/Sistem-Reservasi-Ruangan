<?php

if (!isset($labs)) {

    include __DIR__ . '/../config/config.php';

    include __DIR__ . '/../helpers/labs.php';

    $labs = getLabs($conn);
}

if (isset($_GET['start'])) {

    $start = (int) $_GET['start'];

    $total = count($labs);

    $result = [];

    for ($i = 0; $i < 3; $i++) {

        $index = ($start + $i) % $total;

        $result[] = $labs[$index];
    }

    $labs = $result;
}

?>

<?php foreach ($labs as $lab): ?>

    <?php

    $gambar = $lab['gambar'];

    $status = $lab['status'];

    $nama = $lab['nama_lab'];

    $kategori = $lab['kategori'];

    $luas = $lab['luas'];

    $kapasitas = $lab['kapasitas'];

    $lokasi = $lab['lokasi_short'];

    $jam_buka = $lab['jam_buka_format'];

    $jam_tutup = $lab['jam_tutup_format'];

    $fasilitas = $lab['fasilitas_short'];

    include __DIR__ . '/card_lab.php';

    ?>

<?php endforeach; ?>