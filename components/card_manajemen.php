<div class="
    border
    border-[#D6D6D6]
    rounded-3xl
    py-6.25
    px-5.5
    flex
    flex-col
    md:flex-row
    gap-4
">

    <img src="../<?= htmlspecialchars($lab['gambar']) ?>" alt="<?= htmlspecialchars($lab['nama_lab']) ?>" class="
            w-full
            md:w-60
            lg:w-87.25
            h-30
            md:h-48.75
            object-cover
            rounded-[20px]
            shrink-0
        ">

    <div class="
        flex-1
        flex
        flex-col
        gap-3
    ">

        <div class="
            flex
            flex-col
            sm:flex-row
            justify-between
            items-center
            gap-2
        ">

            <h2 class="
                text-xl
                md:text-2xl
                lg:text-3xl
                font-bold
                wrap-break-word
            ">

                <?= htmlspecialchars($lab['nama_lab']) ?>

            </h2>

            <?php

            $statusClass = [

                'Tersedia' =>
                    'bg-[#CFF7D3] text-[#307445]',

                'Perbaikan' =>
                    'bg-[#FFF1C2] text-[#BF6A02]',

                'Non-aktif' =>
                    'bg-[#FDD3D0] text-[#EE3835]'

            ];

            ?>

            <span class="
                px-4
                py-2
                rounded-xl
                text-xs
                font-medium
                w-fit
                text-center
                <?= $statusClass[$lab['status']] ?>
            ">

                <?= htmlspecialchars($lab['status']) ?>

            </span>

        </div>

        <div class="
            flex
            flex-col
            gap-2
            text-sm
            mt-5
            lg:mt-7.5
        ">

            <div class="
                flex
                items-center
                gap-3
            ">

                <i data-lucide="users" class="lg:w-5 lg:h-5 w-4 h-4"></i>

                <span class="font-bold text-base lg:text-xl ">

                    Kapasitas

                </span>

                <span class="text-xs md:text-base lg:text-xl">

                    <?= $lab['kapasitas'] ?>

                    Orang

                </span>

            </div>

            <div class="
                flex
                items-center
                gap-3
            ">

                <i data-lucide="map-pin" class="lg:w-5 lg:h-5 w-4 h-4"></i>

                <span class="font-bold text-base lg:text-xl">

                    Lokasi

                </span>

                <span class="text-xs md:text-base lg:text-xl">

                    <?= htmlspecialchars($lab['lokasi']) ?>

                </span>

            </div>

        </div>

        <div class="
            flex
            flex-col
            sm:flex-row
            justify-end
            gap-2
            mt-auto
        ">

            <button type="button" data-modal-edit data-id="<?= $lab['id'] ?>"
                data-nama="<?= htmlspecialchars($lab['nama_lab']) ?>" data-kapasitas="<?= $lab['kapasitas'] ?>"
                data-kategori="<?= $lab['kategori'] ?>" data-luas="<?= $lab['luas'] ?>"
                data-lokasi="<?= htmlspecialchars($lab['lokasi']) ?>" data-status="<?= $lab['status'] ?>"
                data-fasilitas="<?= htmlspecialchars($lab['fasilitas']) ?>"
                data-deskripsi="<?= htmlspecialchars($lab['deskripsi']) ?>" data-jam-buka="<?= $lab['jam_buka'] ?>"
                data-jam-tutup="<?= $lab['jam_tutup'] ?>" data-gambar="../<?= htmlspecialchars($lab['gambar']) ?>"
                class="
                    bg-[#0088FF]
                    text-white
                    px-5
                    py-2
                    rounded-full
                    text-sm
                    font-medium
                    cursor-pointer
                    flex
                    items-center
                    gap-2
                    hover:opacity-70
                ">

                <i data-lucide="pen-line" class="w-3.5 h-3.5"></i>
                <p>Edit</p>

            </button>

            <button type="button" data-modal-delete data-id="<?= $lab['id'] ?>"
                data-nama="<?= htmlspecialchars($lab['nama_lab']) ?>" class="
                    bg-[#FDD3D0]
                    text-[#FF5858]
                    px-5
                    py-2
                    rounded-full
                    text-sm
                    font-medium
                    cursor-pointer
                    flex
                    items-center
                    gap-2
                    hover:opacity-70
                ">

                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <p>Hapus</p>

            </button>

        </div>

    </div>

</div>