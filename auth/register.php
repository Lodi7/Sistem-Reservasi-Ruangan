<?php
$page = 'register';

include __DIR__ . '/../config/config.php';

$error = "";

$query_prodi = mysqli_query(
    $conn,
    "SELECT * FROM program_studi"
);

if (isset($_POST['register'])) {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $status = trim($_POST['status']);
    $npm = trim($_POST['npm']);
    $program_studi_id = trim($_POST['program_studi_id']);

    if (
        empty($nama) ||
        empty($email) ||
        empty($npm) ||
        empty($program_studi_id) ||
        empty($password) ||
        empty($confirm_password) ||
        empty($status)
    ) {

        $error = "Semua input wajib diisi";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid";

    } elseif (
        $password != $confirm_password
    ) {
        $error = "Konfirmasi password tidak sama";
    } elseif ($status == "mahasiswa") {

        if (!str_ends_with($email, "@student.upnjatim.ac.id")) {

            $error = "Email mahasiswa harus menggunakan @student.upnjatim.ac.id";

        } elseif (explode("@", $email)[0] != $npm) {

            $error = "Email mahasiswa harus menggunakan NPM";

        } else {

            $stmt = mysqli_prepare(
                $conn,
                "SELECT * FROM program_studi
                WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $program_studi_id
            );

            mysqli_stmt_execute($stmt);

            $result_prodi = mysqli_stmt_get_result($stmt);

            $prodi = mysqli_fetch_assoc($result_prodi);

            $kode_npm = substr($npm, 4, 2);

            if (
                $kode_npm !=
                $prodi['kode_prodi']
            ) {

                $error = "NPM tidak sesuai program studi";

            }

        }

    } elseif ($status == 'dosen') {
        if (str_ends_with($email, '@student.upnjatim.ac.id')) {
            $error = "Email dosen tidak boleh menggunakan email mahasiswa";
        } elseif (!str_ends_with($email, '@upnjatim.ac.id')) {
            $error = "Email dosen harus menggunakan @upnjatim.ac.id";
        }
    }

    if (empty($error)) {

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id FROM users
            WHERE email = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {

            $error = "Email sudah digunakan";

        } else {

            $password_hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $role = "user";

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users
                (
                    nama,
                    email,
                    password,
                    role,
                    status,
                    npm,
                    program_studi_id
                )

                VALUES (?, ?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssi",
                $nama,
                $email,
                $password_hash,
                $role,
                $status,
                $npm,
                $program_studi_id
            );

            $query = mysqli_stmt_execute($stmt);

            if ($query) {

                header("Location: index.php?page=login");

                exit;

            } else {

                $error = "Register gagal";

            }

        }

    }

}
?>

<section class="min-h-screen flex flex-col md:items-center justify-center mt-5 py-20">
    <div
        class="flex flex-col px-5 sm:px-10 md:px-20 py-12.5 gap-5 max-w-150.5 items-center rounded-[50px] md:shadow-[0_0_15px_rgba(0,0,0,0.15)] md:shadow-[#787878]/20">
        <h2 class="font-bold text-3xl sm:text-4xl md:text-5xl ">
            Daftar Akun
        </h2>
        <p class="text-sm md:text-base ">
            Siilahkan daftar akun untuk bisa melakukan reservasi lab
        </p>
        <?php if (!empty($error)): ?>

            <div class="w-full bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg text-center">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <form method="POST" class="w-full flex flex-col gap-7">
            <div class="relative">
                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">
                    Nama
                </label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap" required
                    class="w-full border border-[#AFB1B6] placeholder:[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
            </div>
            <div class="relative">
                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">
                    Email
                </label>
                <input type="email" name="email" placeholder="Masukkan Email UPN" required
                    class="w-full border border-[#AFB1B6] placeholder:[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
            </div>
            <div class="relative">
                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">
                    NPM/NIP
                </label>
                <input type="text" name="npm" placeholder="Masukkan NPM/NIP" required
                    class="w-full border border-[#AFB1B6] placeholder:[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
            </div>
            <div class="relative">

                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">
                    Program Studi
                </label>

                <select name="program_studi_id"
                    class="appearance-none w-full border border-[#AFB1B6] rounded-lg p-4 pr-12 text-base text-gray-600 outline-none bg-white">

                    <option value="">
                        Pilih Program Studi
                    </option>

                    <?php while ($prodi = mysqli_fetch_assoc($query_prodi)): ?>

                        <option value="<?= $prodi['id']; ?>">

                            <?= $prodi['nama_prodi']; ?>

                        </option>

                    <?php endwhile; ?>

                </select>

                <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none">
                </i>

            </div>
            <div class="relative">
                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">
                    Password
                </label>
                <input type="password" name="password" placeholder="Masukkan Password" autocomplete="new-password"
                    required
                    class="password-input w-full border border-[#AFB1B6] placeholder:[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
                <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer">
                    <svg width="34" height="25" viewBox="0 0 34 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="eye-close hidden size-6">
                        <path
                            d="M25.37 18.4401C22.9613 19.7431 20.0283 20.465 17 20.5001C7.13636 20.5001 1.5 12.5001 1.5 12.5001C3.25275 10.182 5.68378 8.15675 8.63 6.56015M14.0409 4.74015C15.0108 4.57903 16.0039 4.49849 17 4.50015C26.8636 4.50015 32.5 12.5001 32.5 12.5001C31.6447 13.6358 30.6246 14.7049 29.4564 15.6901M19.9873 14.6201C19.6003 14.9149 19.1336 15.1513 18.615 15.3153C18.0965 15.4792 17.5367 15.5674 16.9691 15.5745C16.4015 15.5816 15.8377 15.5075 15.3114 15.3566C14.785 15.2058 14.3068 14.9812 13.9054 14.6963C13.504 14.4114 13.1876 14.0721 12.9749 13.6985C12.7623 13.325 12.6579 12.9249 12.6679 12.5221C12.678 12.1192 12.8022 11.722 13.0332 11.354C13.2643 10.986 13.5974 10.6548 14.0127 10.3801"
                            stroke="#AAAAAA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.5 1.50012L32.5 23.5001" stroke="#AAAAAA" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg width="34" height="25" viewBox="0 0 34 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="eye-open size-6">
                        <path
                            d="M1.5 12.5C1.5 12.5 7.13636 1.5 17 1.5C26.8636 1.5 32.5 12.5 32.5 12.5C32.5 12.5 26.8636 23.5 17 23.5C7.13636 23.5 1.5 12.5 1.5 12.5Z"
                            stroke="#AAAAAA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M16.9997 16.625C19.3344 16.625 21.227 14.7782 21.227 12.5C21.227 10.2218 19.3344 8.375 16.9997 8.375C14.6651 8.375 12.7725 10.2218 12.7725 12.5C12.7725 14.7782 14.6651 16.625 16.9997 16.625Z"
                            stroke="#AAAAAA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="relative">
                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">
                    Konfirmasi Password
                </label>
                <input type="password" name="confirm_password" placeholder="Masukkan Password"
                    autocomplete="new-password" required
                    class="password-input w-full border border-[#AFB1B6] placeholder:[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
                <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer">
                    <svg width="34" height="25" viewBox="0 0 34 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="eye-close hidden size-6">
                        <path
                            d="M25.37 18.4401C22.9613 19.7431 20.0283 20.465 17 20.5001C7.13636 20.5001 1.5 12.5001 1.5 12.5001C3.25275 10.182 5.68378 8.15675 8.63 6.56015M14.0409 4.74015C15.0108 4.57903 16.0039 4.49849 17 4.50015C26.8636 4.50015 32.5 12.5001 32.5 12.5001C31.6447 13.6358 30.6246 14.7049 29.4564 15.6901M19.9873 14.6201C19.6003 14.9149 19.1336 15.1513 18.615 15.3153C18.0965 15.4792 17.5367 15.5674 16.9691 15.5745C16.4015 15.5816 15.8377 15.5075 15.3114 15.3566C14.785 15.2058 14.3068 14.9812 13.9054 14.6963C13.504 14.4114 13.1876 14.0721 12.9749 13.6985C12.7623 13.325 12.6579 12.9249 12.6679 12.5221C12.678 12.1192 12.8022 11.722 13.0332 11.354C13.2643 10.986 13.5974 10.6548 14.0127 10.3801"
                            stroke="#AAAAAA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.5 1.50012L32.5 23.5001" stroke="#AAAAAA" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg width="34" height="25" viewBox="0 0 34 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="eye-open size-6">
                        <path
                            d="M1.5 12.5C1.5 12.5 7.13636 1.5 17 1.5C26.8636 1.5 32.5 12.5 32.5 12.5C32.5 12.5 26.8636 23.5 17 23.5C7.13636 23.5 1.5 12.5 1.5 12.5Z"
                            stroke="#AAAAAA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M16.9997 16.625C19.3344 16.625 21.227 14.7782 21.227 12.5C21.227 10.2218 19.3344 8.375 16.9997 8.375C14.6651 8.375 12.7725 10.2218 12.7725 12.5C12.7725 14.7782 14.6651 16.625 16.9997 16.625Z"
                            stroke="#AAAAAA" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-row gap-5 text-[#767676] items-center">
                <label class="flex gap-1 items-center ">
                    <input type="radio" name="status" value="mahasiswa" class="w-4 h-4 cursor-pointer" required>
                    Mahasiswa
                </label>
                <label class="flex gap-1 items-center ">
                    <input type="radio" name="status" value="dosen" class="w-4 h-4 cursor-pointer"> Dosen
                </label>
            </div>

            <button type="submit" name="register"
                class="font-medium text-center bg-[#FF925C] py-2.5 rounded-full shadow-lg shadow-black/20 text-white">
                Daftar
            </button>
        </form>
    </div>
</section>