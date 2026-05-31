<div id="modalEditLab" class="
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
        rounded-[30px]
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
                    Edit Lab
                </h2>

                <button type="button" id="btnTutupEdit" class="
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
                <input type="hidden" name="id" id="edit_id">
                <!-- Nama Lab -->
                <div>

                    <label class="text-sm font-medium">
                        1. Nama Lab
                    </label>

                    <input type="text" name="nama_lab" id="edit_nama_lab" class="
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

                        <input type="number" name="kapasitas" id="edit_kapasitas" class="
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

                        <input type="number" name="luas" id="edit_luas" placeholder="m²" class="
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

                        <input type="text" name="lokasi" id="edit_lokasi" class="
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

                        <button type="button" id="editStatusTrigger" class="
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

                            <span id="editStatusLabel" class="
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

                        <input type="hidden" name="status" id="editStatusValue" value="Tersedia">

                        <div id="editStatusDropdown" class="
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

                        <input type="text" name="kategori" id="edit_kategori" placeholder="Lab Fasilkom" class="
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

                        <input type="text" name="fasilitas" id="edit_fasilitas"
                            placeholder="30 Komputer,2 AC,1 Proyektor" class="
                                w-full
                                border
                                border-[#D6D6D6]
                                rounded-xl
                                px-4
                                py-2.5
                                mt-2
                            ">

                        <p class="text-xs text-gray-400 mt-1">
                            Pisahkan dengan koma (,)
                        </p>

                    </div>

                </div>
                <!-- Deskripsi -->
                <div>

                    <label class="text-sm font-medium">
                        8. Deskripsi
                    </label>

                    <textarea name="deskripsi" maxlength="500" rows="3" id="edit_deskripsi" class="
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

                        <input type="time" name="jam_buka" id="edit_jam_buka" class="
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                ">

                        <input type="time" name="jam_tutup" id="edit_jam_tutup" class="
                    border
                    border-[#D6D6D6]
                    rounded-xl
                    px-4
                    py-2.5
                ">

                    </div>

                </div>

                <div>

                    <img id="preview_gambar" src="" class="
                            w-full
                            h-40
                            object-cover
                            rounded-xl
                            mb-3
                        ">

                </div>
                <!-- Upload -->
                <div>

                    <label class="text-sm font-medium">
                        10. Upload File
                    </label>

                    <input type="file" name="gambar" accept="image/*" class="
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

                    <button type="submit" name="edit_lab" class="
            flex-1

            bg-[#FDD3D0]

            text-[#444444]

            font-medium

            py-3

            rounded-full

            hover:opacity-80

            transition

            cursor-pointer
        ">

                        Simpan Perubahan

                    </button>

                    <button type="button" id="btnBatalEdit" class="
            flex-1

            border

            border-[#FDD3D0]

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