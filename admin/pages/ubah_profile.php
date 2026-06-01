<?php
$page = 'ubah_profile';

include __DIR__ . "/../../config/config.php";

$error = "";

// ambil data
$userId =
    $_SESSION['user_id'];

$upload_dir = __DIR__ . '/../../assets/images/uploads/profile/';

$stmt =
    mysqli_prepare(

        $conn,

        "SELECT

            nama,
            email,
            foto_profile

        FROM users

        WHERE id = ?"

    );

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $userId
);

mysqli_stmt_execute(
    $stmt
);

$result =
    mysqli_stmt_get_result(
        $stmt
    );

$user =
    mysqli_fetch_assoc(
        $result
    );

// Hapus Foto

if (isset($_POST['hapus_foto'])) {

    // Hapus file lama
    if (
        !empty($user['foto_profile']) &&
        file_exists($user['foto_profile'])
    ) {

        unlink($user['foto_profile']);

    }

    // Update 
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
        SET foto_profile = NULL
        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $userId
    );

    $query = mysqli_stmt_execute($stmt);

    if ($query) {

        unset($_SESSION['foto_profile']);
        $user['foto_profile'] = null;
        header("Location: ?page=ubah_profile");

        exit;

    }

}

// upload foto

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

        // extension
        $extension = strtolower(

            pathinfo(
                $nama_file,
                PATHINFO_EXTENSION
            )

        );

        // format valid
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

        // max size 
        elseif ($size > 2000000) {

            $error =
                "Ukuran gambar maksimal 2MB";

        } else {

            // folder uploads
            if (
                !file_exists($upload_dir)
            ) {

                mkdir(
                    $upload_dir,
                    0777,
                    true
                );

            }

            // hapus foto
            if (
                !empty($user['foto_profile']) &&
                file_exists($user['foto_profile'])
            ) {

                unlink($user['foto_profile']);

            }

            // nama baru
            $new_name =

                time() .
                "_" .
                uniqid() .
                "." .
                $extension;

            // path foto
            $upload_path = $upload_dir . $new_name;
            $db_path = "assets/images/uploads/profile/" . $new_name;


            // upload
            if (

                move_uploaded_file(
                    $tmp_file,
                    $upload_path
                )

            ) {

                // update database
                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE users
                    SET foto_profile = ?
                    WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "si",
                    $db_path,
                    $userId
                );

                $query =
                    mysqli_stmt_execute($stmt);

                if ($query) {

                    $_SESSION['foto_profile'] =
                        $db_path;

                    header("Location: ?page=ubah_profile");

                    exit;

                }

            }

        }

    }

}
?>

<section class="min-h-screen py-10 px-5 xl:px-10 mt-18">

    <div class="max-w-7xl mx-auto flex flex-col gap-10">

        <h1 class="text-5xl font-bold text-center">

            Ubah Profil

        </h1>

        <?php if (!empty($error)): ?>

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-5 xl:gap-20 items-start">

            <!-- foto profile -->
            <div class="flex flex-col items-center gap-8">

                <form method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-5">

                    <!-- image -->
                    <img id="previewImage" src="<?= !empty($user['foto_profile'])
                        ? '../' . $user['foto_profile']
                        : '../assets/images/profile-default.png'; ?>" alt="Profile"
                        class="w-70 h-70 lg:h-91.25 lg:w-91.25 rounded-full object-cover border border-gray-300 hover:opacity-80 transition">
                    <button type="button" id="uploadButton"
                        class="bg-[#FF925C] text-white font-medium px-5 py-3 rounded-full hover:opacity-70 transition text-base sm:text-xl lg:text-2xl shadow-xl cursor-pointer">

                        Upload Foto

                    </button>
                    <!-- input foto -->
                    <input type="file" name="foto_profile" accept=".jpg,.jpeg,.png" class="hidden"
                        id="fotoProfileInput">

                    <!-- button -->
                    <div class="flex gap-4">

                        <?php if (!empty($user['foto_profile'])): ?>

                            <button type="button" name="hapus_foto" id="hapusFotoButton"
                                class="border border-red-400 text-red-400 px-5 py-3 rounded-full font-medium hover:bg-red-50 transition text-base sm:text-xl lg:text-2xl shadow-xl cursor-pointer">

                                Hapus Foto

                            </button>

                        <?php endif; ?>

                    </div>

                    <!-- auto submit -->
                    <button type="submit" name="upload_foto" id="submitFoto" class="hidden">

                    </button>

                </form>

                <!-- Form Hapus Foto -->
                <form method="POST" id="hapusFotoForm" class="hidden">

                    <button type="submit" name="hapus_foto" id="submitHapusFoto">

                    </button>

                </form>

            </div>

            <!-- Data Profile -->
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4 xl:gap-8">

                <div class="flex flex-col gap-2">

                    <label class="text-2xl font-medium">

                        Nama

                    </label>

                    <input type="text" value="<?= $user['nama']; ?>" readonly
                        class="w-full border-2 border-gray-400 rounded-2xl px-5 py-3.5 bg-white shadow-md shadow-[#AFB1B6] outline-none">

                </div>

                <div class="flex flex-col gap-2">

                    <label class="text-2xl font-medium">

                        Email

                    </label>

                    <input type="email" value="<?= $user['email']; ?>" readonly
                        class="w-full border-2 border-gray-400 rounded-2xl px-5 py-3.5 bg-white shadow-md shadow-[#AFB1B6] outline-none">

                </div>

            </div>

        </div>

    </div>

    <!-- Konfirmasi Hapus -->
    <div id="hapusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white rounded-3xl p-8 max-w-md w-full flex flex-col gap-6">

            <div class="flex flex-col gap-2">

                <h2 class="text-3xl font-bold">

                    Hapus Foto?

                </h2>

                <p class="text-gray-500">

                    Foto profile akan dihapus permanen.

                </p>

            </div>

            <div class="flex justify-end gap-4">

                <button type="button" id="batalHapus" class="px-6 py-3 border rounded-full cursor-pointer">

                    Batal

                </button>

                <button type="button" id="confirmHapus"
                    class="bg-red-500 text-white px-6 py-3 rounded-full cursor-pointer hover:opacity-70">

                    Hapus

                </button>

            </div>

        </div>

    </div>

</section>


<!-- modal cropper foto -->
<div id="cropModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-3xl flex flex-col gap-5 max-w-xl w-full">

        <div class="w-full h-125 overflow-hidden">

            <img id="cropImage" class="block max-w-full">

        </div>

        <div class="flex justify-end gap-4">

            <button type="button" id="cancelCrop" class="px-5 cursor-pointer py-3 border rounded-full hover:opacity-90">

                Batal

            </button>

            <button type="button" id="saveCrop"
                class="bg-[#FF925C] cursor-pointer hover:opacity-70 text-white px-5 py-3 rounded-full">

                Simpan

            </button>

        </div>

    </div>

</div>