<?php

include __DIR__ . "/../config/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$error = "";

if (isset($_POST['kirim'])) {

    $email = trim($_POST['email']);

    // VALIDASI INPUT
    if (empty($email)) {

        $error = "Email wajib diisi";

    }

    // VALIDASI FORMAT EMAIL
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid";

    } else {

        // CEK EMAIL
        $stmt = mysqli_prepare(
            $conn,
            "SELECT * FROM users
            WHERE email = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_assoc($result);

        // Email gk ada
        if (!$user) {

            $error = "Email tidak ditemukan";

        } else {

            // Generate OTP
            $otp = rand(100000, 999999);

            // Generate Token
            $token = bin2hex(
                random_bytes(32)
            );

            // Exp 10 menit
            $expired = date(
                "Y-m-d H:i:s",
                strtotime("+10 minutes")
            );

            // update database
            $stmt = mysqli_prepare(
                $conn,
                "UPDATE users
                SET
                    reset_otp = ?,
                    reset_otp_expired = ?,
                    reset_token = ?
                WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sssi",
                $otp,
                $expired,
                $token,
                $user['id']
            );

            mysqli_stmt_execute($stmt);

            try {

                // PHPMailer
                $mail = new PHPMailer(true);

                $mail->isSMTP();

                $mail->Host =
                    'smtp.gmail.com';

                $mail->SMTPAuth = true;

                $mail->Username =
                    $_ENV['MAIL_USERNAME'];

                $mail->Password =
                    $_ENV['MAIL_PASSWORD'];

                $mail->SMTPSecure = 'tls';

                $mail->Port = 587;

                // PENGIRIM
                $mail->setFrom(
                    $_ENV['MAIL_USERNAME'],
                    'LabHub'
                );

                // PENERIMA
                $mail->addAddress($email);

                // EMAIL HTML
                $mail->isHTML(true);

                // SUBJECT
                $mail->Subject =
                    'Kode OTP Reset Password';

                // BODY EMAIL
                $mail->Body = "
                    <div
                        style='
                            font-family:sans-serif;
                            padding:20px;
                        '
                    >

                        <h2>
                            Reset Password LabHub
                        </h2>

                        <p>
                            Berikut kode OTP Anda:
                        </p>

                        <h1
                            style='
                                letter-spacing:5px;
                                color:#FF925C;
                            '
                        >
                            $otp
                        </h1>

                        <p>
                            OTP berlaku selama
                            10 menit.
                        </p>

                    </div>
                ";

                // KIRIM EMAIL
                $mail->send();

                echo "
<script>

    window.location.href =
    'index.php?page=verifikasi_otp&token=$token';

</script>
";

                exit;

            } catch (Exception $e) {

                $error =
                    "Gagal mengirim OTP";

            }

        }

    }

}
?>

<section class="min-h-screen flex flex-col md:items-center justify-center py-20">

    <div
        class="flex flex-col px-5 sm:px-10 md:px-20 py-12.5 gap-5 max-w-150.5 items-center rounded-[50px] md:shadow-2xl md:shadow-[#787878]/20">

        <h2 class="font-bold text-3xl sm:text-4xl md:text-5xl">
            Cari Akun Anda
        </h2>

        <p class="text-sm md:text-base">
            Masukkan email akun Anda
        </p>

        <?php if (!empty($error)): ?>

            <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <form method="POST" class="w-full flex flex-col gap-7">

            <div class="relative">

                <label class="absolute -top-2 left-5 bg-white px-2 text-[12px] text-[#AFB1B6] font-medium">

                    Email

                </label>

                <input type="email" name="email" placeholder="Masukkan Email" autocomplete="email"
                    class="w-full border border-[#AFB1B6] placeholder:text-[#AFB1B6] rounded-lg p-4 text-base text-gray-600">

            </div>

            <button type="submit" name="kirim"
                class="font-medium text-center bg-[#FF925C] py-2.5 rounded-full shadow-lg shadow-black/20 text-white hover:opacity-70 transition duration-300 cursor-pointer">
                Kirim OTP
            </button>

        </form>

    </div>

</section>