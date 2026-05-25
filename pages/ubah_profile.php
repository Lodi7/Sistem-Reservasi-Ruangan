<?php
$page = 'ubah_profile';

include __DIR__ . "/../config/config.php";

include __DIR__ . "/../middleware/auth.php";

$error = "";

// AMBIL DATA USER
$stmt = mysqli_prepare(
    $conn,
    "SELECT users.*, program_studi.nama_prodi
    FROM users

    LEFT JOIN program_studi
    ON users.program_studi_id =
    program_studi.id

    WHERE users.id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $_SESSION['user_id']
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);


// =========================
// HAPUS FOTO
// =========================

if (isset($_POST['hapus_foto'])) {

    // HAPUS FILE LAMA
    if (
        !empty($user['foto_profile']) &&
        file_exists($user['foto_profile'])
    ) {

        unlink($user['foto_profile']);

    }

    // UPDATE DATABASE
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
        SET foto_profile = NULL
        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $user['id']
    );

    $query = mysqli_stmt_execute($stmt);

    if ($query) {

        unset($_SESSION['foto_profile']);

        echo "
        <script>

            alert(
                'Foto profile berhasil dihapus'
            );

            window.location.href =
            '?page=ubah_profile';

        </script>
        ";

        exit;

    }

}


// =========================
// UPLOAD FOTO
// =========================

if (isset($_POST['upload_foto'])) {

    if (
        isset($_FILES['foto_profile']) &&
        $_FILES['foto_profile']['error'] == 0
    ) {

        $file =
            $_FILES['foto_profile'];

        $nama_file =
            $file['name'];

        $tmp_file =
            $file['tmp_name'];

        $size =
            $file['size'];

        // EXTENSION
        $extension = strtolower(

            pathinfo(
                $nama_file,
                PATHINFO_EXTENSION
            )

        );

        // FORMAT VALID
        $allowed = [

            'jpg',
            'jpeg',
            'png'

        ];

        if (
            !in_array(
                $extension,
                $allowed
            )
        ) {

            $error =
                "Format gambar tidak valid";

        }

        // MAX 2MB
        elseif ($size > 2000000) {

            $error =
                "Ukuran gambar maksimal 2MB";

        } else {

            // FOLDER
            if (
                !file_exists(
                    "assets/images/profile"
                )
            ) {

                mkdir(
                    "assets/images/profile",
                    0777,
                    true
                );

            }

            // HAPUS FOTO LAMA
            if (
                !empty($user['foto_profile']) &&
                file_exists($user['foto_profile'])
            ) {

                unlink($user['foto_profile']);

            }

            // NAMA BARU
            $new_name =

                time() .
                "_" .
                uniqid() .
                "." .
                $extension;

            // PATH
            $upload_path =

                "assets/images/profile/" .
                $new_name;

            // UPLOAD
            if (

                move_uploaded_file(
                    $tmp_file,
                    $upload_path
                )

            ) {

                // UPDATE DATABASE
                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE users
                    SET foto_profile = ?
                    WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "si",
                    $upload_path,
                    $user['id']
                );

                $query =
                    mysqli_stmt_execute($stmt);

                if ($query) {

                    $_SESSION['foto_profile'] =
                        $upload_path;

                    echo "
                    <script>

                        window.location.href =
                        '?page=ubah_profile';

                    </script>
                    ";

                    exit;

                }

            }

        }

    }

}
?>

<section class="min-h-screen py-20 px-10 mt-18">

    <div class="max-w-7xl mx-auto flex flex-col gap-10">

        <h1 class="text-5xl font-bold text-center">

            Profil Saya

        </h1>

        <?php if (!empty($error)): ?>

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-start">

            <!-- FOTO PROFILE -->
            <div class="flex flex-col items-center gap-8">

                <form method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-5">

                    <!-- IMAGE -->
                    <img id="previewImage" src="<?= !empty($user['foto_profile'])
                        ? $user['foto_profile']
                        : 'assets/images/profile-default.png'; ?>" alt="Profile"
                        class="w-70 h-70 rounded-full object-cover border border-gray-300 cursor-pointer hover:opacity-80 transition">

                    <!-- INPUT FILE -->
                    <input type="file" name="foto_profile" accept=".jpg,.jpeg,.png" class="hidden"
                        id="fotoProfileInput">

                    <!-- BUTTON -->
                    <div class="flex gap-4">

                        <button type="submit" name="hapus_foto"
                            class="border border-red-400 text-red-500 px-10 py-3 rounded-full font-semibold hover:bg-red-50 transition">

                            Hapus Foto

                        </button>

                    </div>

                    <!-- AUTO SUBMIT -->
                    <button type="submit" name="upload_foto" id="submitFoto" class="hidden">

                    </button>

                </form>

            </div>

            <!-- DATA PROFILE -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="flex flex-col gap-2">

                    <label class="text-2xl font-medium">

                        Nama

                    </label>

                    <input type="text" value="<?= $user['nama']; ?>" readonly
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-100 outline-none">

                </div>

                <div class="flex flex-col gap-2">

                    <label class="text-2xl font-medium">

                        NPM / NIP

                    </label>

                    <input type="text" value="<?= $user['npm']; ?>" readonly
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-100 outline-none">

                </div>

                <div class="flex flex-col gap-2">

                    <label class="text-2xl font-medium">

                        Status

                    </label>

                    <input type="text" value="<?= ucfirst($user['status']); ?>" readonly
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-100 outline-none">

                </div>

                <div class="flex flex-col gap-2">

                    <label class="text-2xl font-medium">

                        Program Studi

                    </label>

                    <input type="text" value="<?= $user['nama_prodi']; ?>" readonly
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-100 outline-none">

                </div>

                <div class="flex flex-col gap-2 md:col-span-2">

                    <label class="text-2xl font-medium">

                        Email

                    </label>

                    <input type="email" value="<?= $user['email']; ?>" readonly
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-100 outline-none">

                </div>

            </div>

        </div>

    </div>

</section>


<!-- MODAL CROPPER -->
<div id="cropModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-3xl flex flex-col gap-5 max-w-xl w-full">

        <div class="w-full h-125 overflow-hidden">

            <img id="cropImage" class="block max-w-full">

        </div>

        <div class="flex justify-end gap-4">

            <button type="button" id="cancelCrop" class="px-6 py-3 border rounded-full">

                Batal

            </button>

            <button type="button" id="saveCrop" class="bg-[#FF925C] text-white px-6 py-3 rounded-full">

                Simpan

            </button>

        </div>

    </div>

</div>