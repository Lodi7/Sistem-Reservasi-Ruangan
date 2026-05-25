<?php

include __DIR__ . "/../config/config.php";

$user = null;

if (isset($_SESSION['is_login'])) {

    $id = $_SESSION['user_id'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users
        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

} ?>

<nav class="bg-white border-b border-gray-400 fixed top-0 w-full h-18 z-50">

    <div class="max-w-7xl lg:max-w-full px-6 lg:px-20 lg:py-2.25 py-3.5 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <img src="assets/images/logo-labhub.svg" class="h-10" alt="LabHub Logo">
            <h1 class="text-xl font-bold">LabHub</h1>
        </div>

        <!-- Hamburger -->
        <button data-target="#mobileMenu" class="menuButton lg:hidden inline-flex items-center justify-center">

            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

            </svg>

        </button>

        <!-- Menu -->
        <ul id="mobileMenu" class="
                hidden
                lg:flex
                flex-col
                lg:flex-row
                items-start
                lg:items-center
                gap-5
                lg:gap-8

                absolute
                lg:static

                top-18
                left-0

                w-full
                lg:w-auto

                bg-white
                lg:bg-transparent

                px-6
                py-6
                lg:p-0

                border-b
                lg:border-0
                border-gray-300">

            <?php if (isset($_SESSION['is_login'])): ?>

                <li class="w-full lg:hidden border-b pb-2 mb-1 border-gray-200">

                    <div class="flex items-center gap-3">

                        <img src="<?= !empty($user['foto_profile'])
                            ? $user['foto_profile']
                            : 'assets/images/profile-default.png'; ?>"
                            class="w-10 h-10 rounded-full border border-gray-300 object-cover">

                        <h2 class="font-semibold text-gray-700">
                            <?= $user['nama']; ?>
                        </h2>

                    </div>

                </li>

            <?php endif; ?>



            <li>
                <a href="index.php?page=beranda" class="<?= $page === 'beranda'
                    ? 'text-[#FF925C] font-medium'
                    : 'hover:text-[#FF925C]' ?>">

                    Beranda

                </a>
            </li>

            <li>
                <a href="index.php?page=tentang_kami" class="<?= $page === 'tentang_kami'
                    ? 'text-[#FF925C] font-medium'
                    : 'hover:text-[#FF925C]' ?>">

                    Tentang Kami

                </a>
            </li>

            <li>
                <a href="index.php?page=informasi_lab" class="<?= $page === 'informasi_lab'
                    ? 'text-[#FF925C] font-medium'
                    : 'hover:text-[#FF925C]' ?>">

                    Informasi Lab
                </a>
            </li>

            <!-- Dropdown -->
            <li class="relative w-full lg:w-auto">

                <button data-target="#reservasiMenu" class="dropdownButton flex items-center justify-between w-full lg:w-auto gap-2
        <?= in_array($page, [
            'ajukan_reservasi',
            'jadwal_lab',
            'riwayat_reservasi'
        ])
            ? 'text-[#FF925C] font-medium'
            : 'hover:text-[#FF925C]' ?>">

                    Reservasi

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />

                    </svg>

                </button>

                <!-- Dropdown Menu -->
                <div id="reservasiMenu" class="
            hidden
            lg:absolute
            lg:top-10
            lg:right-0

            mt-3
            lg:mt-0

            bg-white
            lg:shadow-lg
            shadow-[0_0_20px_rgba(0,0,0,0.2)]
            lg:border
            lg:rounded-md

            w-full
            lg:w-52

            p-2
        ">

                    <!-- AJUKAN RESERVASI -->
                    <a href="index.php?page=ajukan_reservasi" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'ajukan_reservasi'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                        Ajukan Reservasi

                    </a>

                    <!-- JADWAL LAB -->
                    <a href="index.php?page=jadwal_lab" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'jadwal_lab'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                        Jadwal Lab

                    </a>

                    <!-- RIWAYAT -->
                    <a href="index.php?page=riwayat_reservasi" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'riwayat_reservasi'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                        Riwayat Reservasi

                    </a>

                </div>

            </li>

            <!-- Mobile Button -->
            <li class="w-full lg:hidden">

                <?php if (isset($_SESSION['is_login'])): ?>
                    <div class="relative w-full lg:w-auto">

                        <button data-target="#profileMobile" class="dropdownButton flex items-center justify-between w-full lg:w-auto gap-2 <?= in_array($page, [
                            'ubah_profile',
                            'ubah_password',
                            'logout'
                        ])
                            ? 'text-[#FF925C] font-medium'
                            : 'hover:text-[#FF925C]' ?>">
                            Profile
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />

                            </svg>

                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileMobile" class="
            hidden
            lg:absolute
            lg:top-13
            lg:right-0

            mt-3
            lg:mt-0

            bg-white
            lg:shadow-lg
            shadow-[0_0_20px_rgba(0,0,0,0.2)]
            lg:border
            lg:rounded-md

            w-full
            lg:w-52

            p-2
        ">

                            <!-- ubah profile -->
                            <a href="index.php?page=ubah_profile" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'ubah_profile'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                                Ubah Profile

                            </a>

                            <!-- Ubah Password -->
                            <a href="index.php?page=ubah_password" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'ubah_password'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                                Ubah Password

                            </a>
                            <div class="flex items-center text-black hover:text-red-500 hover:bg-gray-100 cursor-pointer">
                                <!-- Logout -->
                                <a href="index.php?page=logout" class="
                block
                px-4
                py-2
                rounded-lg
                    w-full
            ">

                                    Logout
                                </a><i data-lucide="log-out" class="w-5 h-auto ml-auto mr-4"></i>
                            </div>

                        </div>

                    <?php else: ?>

                        <div class="flex flex-col gap-3 mt-2">

                            <a href="index.php?page=login"
                                class="bg-[#FF925C] text-base md:text-lg px-5 py-2 md:py-3 text-white rounded-full text-center hover:opacity-80 transition duration-300">

                                Masuk

                            </a>

                            <a href="index.php?page=register"
                                class="bg-white border border-[#FF925C] hover:bg-[#FF925C] hover:text-white transition duration-300 text-base md:text-lg px-5 py-2 md:py-3 text-black rounded-full text-center">

                                Daftar

                            </a>

                        </div>

                    <?php endif; ?>

            </li>

        </ul>

        <!-- Desktop Button -->
        <div class="hidden lg:flex items-center gap-2.5 py-0.75">

            <?php if (isset($_SESSION['is_login'])): ?>

                <!-- Dropdown -->
                <div class="relative w-full lg:w-auto">

                    <button data-target="#profile"
                        class="dropdownButton flex items-center justify-between w-full lg:w-auto gap-2 cursor-pointer">
                        <img src="<?= !empty($user['foto_profile'])
                            ? $user['foto_profile']
                            : 'assets/images/profile-default.png'; ?>"
                            class="w-12 h-12 rounded-full border border-gray-300 hover:opacity-80 transition">
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profile" class="
            hidden
            lg:absolute
            lg:top-13
            lg:right-0

            mt-3
            lg:mt-0

            bg-white
            lg:shadow-lg
            shadow-[0_0_20px_rgba(0,0,0,0.2)]
            lg:border
            lg:rounded-md

            w-full
            lg:w-52

            p-2
        ">

                        <!-- ubah profile -->
                        <a href="index.php?page=ubah_profile" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'ubah_profile'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                            Ubah Profile

                        </a>

                        <!-- Ubah Password -->
                        <a href="index.php?page=ubah_password" class="
                block
                px-4
                py-2
                rounded-lg

                <?= $page === 'ubah_password'
                    ? 'bg-[#FF925C] text-white'
                    : 'hover:bg-gray-100' ?>
            ">

                            Ubah Password

                        </a>
                        <div class="flex items-center text-black hover:text-red-500 hover:bg-gray-100 cursor-pointer">
                            <!-- Logout -->
                            <a href="index.php?page=logout" class="
                block
                px-4
                py-2
                rounded-lg
                w-full
            ">

                                Logout
                            </a><i data-lucide="log-out" class="w-5 h-auto ml-auto mr-4"></i>
                        </div>

                    </div>

                <?php else: ?>

                    <a href="index.php?page=login"
                        class="bg-[#FF925C] text-base px-5 py-3 text-white rounded-3xl text-center hover:opacity-80 transition duration-300">

                        Masuk

                    </a>

                    <a href="index.php?page=register"
                        class="bg-white border border-[#FF925C] hover:bg-[#FF925C] hover:text-white transition duration-300 text-base px-5 py-3 text-black rounded-3xl text-center">

                        Daftar

                    </a>

                <?php endif; ?>

            </div>

        </div>

</nav>