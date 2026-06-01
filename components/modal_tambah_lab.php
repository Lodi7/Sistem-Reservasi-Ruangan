<div id="modalTambahLab" class="
        hidden
        fixed
        inset-0
        bg-black/50
        z-50
        p-5
    ">
    <div class="flex items-center justify-center w-full h-full">
        <div class="
        bg-white
        rounded-[10px]
        md:rounded-[30px]
        w-full
        max-w-4xl
        max-h-[90vh]
        overflow-y-auto
        p-6
        md:p-8
    ">

            <div class="
            mb-8
            relative
        ">

                <h2 class="
                text-2xl
                md:text-4xl
                font-bold
                text-center
            ">
                    Tambah Lab
                </h2>

                <button type="button" id="btnTutupTambah" class="
                    text-3xl
                    cursor-pointer
                    absolute
                    top-0
                    right-0
                ">
                    &times;
                </button>

            </div>

            <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">

                <!-- Nama Lab -->
                <div>

                    <label class="text-sm font-medium">
                        1. Nama Lab
                    </label>

                    <input type="text" placeholder="Lab ABC" name="nama_lab" class="
                w-full
                border
                border-[#D6D6D6]
                rounded-xl
                px-4
                py-2.5
                mt-2
            ">

                </div>

                <!-- Kapasitas & Luas -->
                <div class="grid md:grid-cols-2 gap-4">

                    <div>

                        <label class="text-sm font-medium">
                            2. Kapasitas
                        </label>

                        <input type="number" placeholder="20" name="kapasitas" class="
                    w-full
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                    mt-2
                ">

                    </div>

                    <div>

                        <label class="text-sm font-medium">
                            3. Luas
                        </label>

                        <input type="number" name="luas" placeholder="m²" class="
                    w-full
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                    mt-2
                ">

                    </div>

                </div>

                <!-- Lokasi & Status -->
                <div class="grid md:grid-cols-2 gap-4">

                    <div>

                        <label class="text-sm font-medium">
                            4. Lokasi
                        </label>

                        <input type="text" placeholder="Gedung FIK-II" name="lokasi" class="
                    w-full
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                    mt-2
                ">

                    </div>

                    <div class="relative">

                        <label class="text-sm font-medium">
                            5. Status
                        </label>

                        <button type="button" id="statusTrigger" class="
                    w-full
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                    mt-2

                    flex
                    items-center
                    justify-between
                ">

                            <span id="statusLabel" class="
                        px-4
                        py-1
                        rounded-xl
                        text-sm
                        bg-[#CFF7D3]
                        text-[#307445]
                    ">

                                Tersedia

                            </span>

                            <i data-lucide="chevron-down" class="w-4 h-4"></i>

                        </button>

                        <input type="hidden" name="status" id="statusValue" value="Tersedia">

                        <div id="statusDropdown" class="
                    hidden
                    absolute
                    top-full
                    left-0
                    right-0
                    mt-2
                    bg-white
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    shadow-lg
                    z-50
                ">
                            <div class="
                            flex
                            flex-col
                            gap-2
                            p-3
                        ">
                                <button type="button" data-value="Tersedia" class="
                        status-option
                        px-4
                        py-2
                        rounded-xl
                        text-left

                        bg-[#CFF7D3]
                        text-[#307445]
                    ">
                                    Tersedia
                                </button>

                                <button type="button" data-value="Perbaikan" class="
                        status-option
                        px-4
                        py-2
                        rounded-xl
                        text-left

                        bg-[#FFF1C2]
                        text-[#BF6A02]
                    ">
                                    Perbaikan
                                </button>

                                <button type="button" data-value="Non-aktif" class="
                        status-option
                        px-4
                        py-2
                        rounded-xl
                        text-left

                        bg-[#FDD3D0]
                        text-[#EE3835]
                    ">
                                    Non-aktif
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Kategori & Fasilitas -->
                <div class="grid md:grid-cols-2 gap-4">

                    <div>

                        <label class="text-sm font-medium">
                            6. Kategori
                        </label>

                        <input type="text" name="kategori" placeholder="Lab Fasilkom" class="
                                w-full
                                border
                                border-[#D6D6D6]
                                rounded-xl
                                px-4
                                py-2.5
                                mt-2
                            ">

                    </div>

                    <div>

                        <label class="text-sm font-medium">
                            7. Fasilitas
                        </label>

                        <input type="text" name="fasilitas" placeholder="30 Komputer,2 AC,1 Proyektor" class="
                                w-full
                                border
                                border-[#D6D6D6]
                                rounded-xl
                                px-4
                                py-2.5
                                mt-2
                            ">

                    </div>

                </div>

                <!-- Deskripsi -->
                <div>

                    <label class="text-sm font-medium">
                        8. Deskripsi
                    </label>

                    <textarea name="deskripsi" maxlength="500" rows="3" class="
                w-full
                border
                border-[#D6D6D6]
                rounded-xl
                px-4
                py-2.5
                mt-2
                resize-none
            "></textarea>

                </div>

                <!-- Jam Operasional -->
                <div>

                    <label class="text-sm font-medium">
                        9. Jam Operasional
                    </label>

                    <div class="grid md:grid-cols-2 gap-4 mt-2">
                        <input type="time" name="jam_buka" class="
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                ">

                        <input type="time" name="jam_tutup" class="
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                ">

                    </div>
                    <p class="text-xs text-amber-600 mt-1">
                        * Jam buka diperbolehkan 07:00-08:00 dan jam tutup 15:00-16:00.
                    </p>
                </div>

                <!-- Upload -->
                <div>

                    <label class="text-sm font-medium">
                        10. Upload File
                    </label>

                    <input type="file" placeholder=".jpg, .jpeg, .png" name="gambar" accept="image/*" class="
                w-full
                border
                border-[#D6D6D6]
                rounded-xl
                px-4
                py-2.5
                mt-2
            ">

                </div>
                <div class="
    flex
    flex-col-reverse
    md:flex-row
    gap-3
    mt-4
">

                    <button type="submit" name="tambah_lab" class="
            flex-1

            bg-[#FFD8E4]

            text-[#444444]

            font-medium

            py-3

            rounded-full

            hover:opacity-80

            transition

            cursor-pointer
        ">

                        Tambah Lab

                    </button>

                    <button type="button" id="btnBatalTambah" class="
            flex-1

            border

            border-[#FFD8E4]

            text-[#444444]

            font-medium

            py-3

            rounded-full

            hover:bg-gray-50

            transition

            cursor-pointer
        ">

                        Batalkan

                    </button>

                </div>
            </form>
        </div>
    </div>
</div>