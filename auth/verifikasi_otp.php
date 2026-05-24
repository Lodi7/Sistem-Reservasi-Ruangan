<?php

include __DIR__ . "/../config/config.php";

$error = "";

// AMBIL TOKEN
$token = $_GET['token'] ?? '';

if (empty($token)) {

    die("Token tidak valid");

}

// CEK USER
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

// SUBMIT OTP
if (isset($_POST['verifikasi'])) {

    $otp = trim($_POST['otp']);

    // VALIDASI INPUT
    if (empty($otp)) {

        $error = "OTP wajib diisi";

    }

    // OTP SALAH
    elseif ($otp != $user['reset_otp']) {

        $error = "OTP tidak valid";

    }

    // OTP EXPIRED
    elseif (
        strtotime(
            $user['reset_otp_expired']
        ) < time()
    ) {

        $error = "OTP sudah expired";

    } else {
        echo "
<script>

    window.location.href =
    'index.php?page=reset_password&token=$token';

</script>
";

        exit;

    }

}
?>

<section class="min-h-screen flex flex-col md:items-center justify-center py-20">

    <div
        class="flex flex-col px-5 sm:px-10 md:px-20 py-12.5 gap-5 max-w-150.5 items-center rounded-[50px] md:shadow-2xl md:shadow-[#787878]/20">

        <h2 class="font-bold text-3xl sm:text-4xl md:text-5xl">
            Verifikasi OTP
        </h2>

        <p class="text-sm md:text-base">
            Masukkan kode OTP yang dikirim
            ke email Anda
        </p>

        <?php if (!empty($error)): ?>

            <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <form method="POST" class="w-full flex flex-col gap-7">

            <div class="relative">

                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">

                    OTP

                </label>

                <input type="text" name="otp" placeholder="Masukkan OTP" maxlength="6"
                    class="w-full border border-[#AFB1B6] placeholder:text-[#AFB1B6] rounded-lg p-4 text-base text-gray-600">

            </div>

            <button type="submit" name="verifikasi"
                class="font-medium text-center bg-[#FF925C] py-2.5 rounded-full shadow-lg shadow-black/20 text-white hover:opacity-70 transition duration-300 cursor-pointer">

                Verifikasi OTP

            </button>

        </form>

    </div>

</section>