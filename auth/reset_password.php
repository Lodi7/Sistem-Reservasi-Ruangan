<?php

include __DIR__ . "/../config/config.php";


$error = "";
$success = "";

$token = $_GET['token'] ?? '';

// TOKEN KOSONG
if (empty($token)) {

    die("Token tidak valid");

}

// AMBIL USER
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM users
    WHERE reset_token = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $token
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

// SUBMIT RESET PASSWORD
if (isset($_POST['reset'])) {

    $password = trim($_POST['password']);

    $confirm_password =
        trim($_POST['confirm_password']);

    // VALIDASI INPUT
    if (
        empty($password) ||
        empty($confirm_password)
    ) {

        $error = "Semua input wajib diisi";

    }

    // PASSWORD TIDAK SAMA
    elseif (
        $password !=
        $confirm_password
    ) {

        $error =
            "Konfirmasi password tidak sama";

    } else {

        // HASH PASSWORD
        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // UPDATE PASSWORD
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE users
            SET
                password = ?,
                reset_otp = NULL,
                reset_otp_expired = NULL,
                reset_token = NULL
            WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $password_hash,
            $user['id']
        );

        $query = mysqli_stmt_execute($stmt);

        if ($query) {

            $success =
                "Password berhasil diubah";

            echo "
<script>

    setTimeout(() => {

        window.location.href =
        'index.php?page=login';

    }, 2000);

</script>
";

        } else {

            $error =
                "Gagal reset password";

        }

    }

}
?>

<section class="min-h-screen h-screen flex flex-col md:items-center justify-center py-20">

    <div
        class="flex flex-col px-5 sm:px-10 md:px-20 py-12.5 gap-5 max-w-150.5 items-center rounded-[50px] md:shadow-2xl md:shadow-[#787878]/20">

        <h2 class="font-bold text-3xl sm:text-4xl md:text-5xl ">
            Reset Password
        </h2>

        <p class="text-sm md:text-base ">
            Masukkan password baru Anda
        </p>

        <?php if (!empty($error)): ?>

            <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <?php if (!empty($success)): ?>

            <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                <?= $success; ?>

            </div>

        <?php endif; ?>

        <form method="POST" class="w-full flex flex-col gap-7">

            <div class="relative">

                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">

                    Password Baru

                </label>

                <input type="password" name="password" placeholder="Masukkan Password Baru" autocomplete="new-password"
                    class="password-input w-full border border-[#AFB1B6] placeholder:text-[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
                <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer ">
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

                <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru"
                    autocomplete="new-password"
                    class="password-input w-full border border-[#AFB1B6] placeholder:text-[#AFB1B6] rounded-lg p-4 text-base text-gray-600">
                <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer ">
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

            <button type="submit" name="reset"
                class="font-medium text-center bg-[#FF925C] py-2.5 rounded-full shadow-lg shadow-black/20 text-white hover:opacity-70 transition duration-300 cursor-pointer">

                Reset Password

            </button>

        </form>

    </div>

</section>