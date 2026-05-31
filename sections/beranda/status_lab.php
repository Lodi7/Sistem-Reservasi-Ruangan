<?php

include __DIR__ . '/../../config/config.php';

$tanggal =
    date('Y-m-d');

$queryLabs = mysqli_query(

    $conn,

    "SELECT *
    FROM labs"

);


$labsData = [];

while (

    $lab =
    mysqli_fetch_assoc($queryLabs)

) {

    $lab_id =
        $lab['id'];

    // jadwal non aktif
    $stmtNonaktif = mysqli_prepare(

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


    // Ambil jadwal
    $stmtJadwal = mysqli_prepare(

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


    // Loop sesi
    while (

        $item =
        mysqli_fetch_assoc(
            $resultJadwal
        )

    ) {

        $status =
            'Tersedia';

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

            // Cek reservasi
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


    // render table
    ob_start();

    include __DIR__ .
        '/../../components/status_lab_table.php';

    $table =
        ob_get_clean();


    // data lab
    $labsData[] = [

        'nama' =>
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

        'table' =>
            $table

    ];

}

?>
<section class="
        mt-30 px-5 sm:px-15 xl:px-25
    ">
    <div class="flex gap-10 flex-col">
        <div class=" flex xl:flex-row xl:items-end justify-between gap-4 flex-col">
            <div class="flex flex-col gap-4">

                <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold" data-aos="fade-up">
                    Status Lab Terkini
                </h1>

                <p class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed max-w-3xl" data-aos="fade-up"
                    data-aos-delay="200">
                    Cek jadwal lab, informasi status slot diperbarui secara otomatis setiap saat, membantu Anda
                    menemukan waktu terbaik untuk reservasi fasilitas laboratorium.
                </p>
            </div>
            <div data-aos="fade-left" data-aos-delay="300">
                <a href="index.php?page=jadwal_lab" class="
    bg-[#FF925C] text-white rounded-full font-semibold

    text-sm sm:text-base md:text-lg lg:text-xl

    px-5 sm:px-6 md:px-7 lg:px-8.5
    py-2 sm:py-2.5 md:py-3

    flex gap-2 sm:gap-3 items-center
    w-fit

    hover:opacity-80 transition duration-300
">
                    <span>Lihat Selengkapnya</span>

                    <svg class="w-4 sm:w-5" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M0.999725 6.53972L-0.000107106 6.55806L0.0365763 8.55772L1.03641 8.53938L1.01807 7.53955L0.999725 6.53972ZM17.7346 7.94011C18.1179 7.54249 18.1063 6.90943 17.7087 6.52614L11.229 0.279975C10.8314 -0.103321 10.1984 -0.0917078 9.81507 0.305914C9.43178 0.703535 9.44339 1.33659 9.84101 1.71989L15.6007 7.27204L10.0485 13.0317C9.66523 13.4293 9.67684 14.0624 10.0745 14.4457C10.4721 14.829 11.1051 14.8174 11.4884 14.4197L17.7346 7.94011ZM1.01807 7.53955L1.03641 8.53938L17.033 8.24593L17.0146 7.2461L16.9963 6.24626L0.999725 6.53972L1.01807 7.53955Z"
                            fill="white" />
                    </svg>
                </a>
            </div>
        </div>


        <!-- content -->
        <div class="flex flex-col lg:flex-row justify-center items-center gap-11.5">
            <div data-aos="fade-right" data-aos-delay="100">
                <div id="calendar"></div>
            </div>
            <div data-aos="fade-left" data-aos-delay="50">
                <!-- tabel -->
                <div id="statusLabCard" class="
                border
                border-gray-300
                rounded-[10px]
                overflow-hidden
                bg-white
                shadow-md
    w-full
    lg:min-w-75
    lg:max-w-120
    xl:max-w-200
            ">

                    <!-- header tabel -->
                    <div class="
    bg-[#FF925C]
    text-white
    px-2
    md:px-8
    py-5
    flex
    items-center
    justify-between
    transition-opacity
    duration-500
    ease-in-out
">

                        <!-- tanggal -->
                        <h2 id="statusLabDate" class="
                    text-base
                    sm:text-lg
            lg:text-xl
            xl:text-2xl
            font-medium
            whitespace-nowrap
             transition-opacity
            duration-500
            ease-in-out
        ">

                            Loading...

                        </h2>


                        <!-- nama lab -->

                        <div class="flex flex-col min-w-0 gap-1 pl-1">

                            <p id="statusLabTitle" class="
                    text-sm    
                    sm:text-base
                    md:text-lg
                    leading-none
                    truncate
                    text-right
                    overflow-hidden
                ">

                            </p>

                            <p id="statusLabLocation" class="
                    text-[12px]
                    md:text-sm
                    opacity-80
                    truncate
                    text-right
                ">

                            </p>

                        </div>

                    </div>


                    <!-- table -->
                    <div id="statusLabTable">

                    </div>

                </div>
            </div>
        </div>
    </div>

</section>