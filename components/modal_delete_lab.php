<div id="modalDeleteLab" class="
        hidden
        fixed
        inset-0
        bg-black/50
        z-50
    ">

    <div class="
        min-h-screen
        flex
        items-center
        justify-center
        p-5
    ">

        <div class="
            bg-white
            rounded-[30px]
            w-full
            max-w-4xl
            p-6
            md:p-8
        ">

            <div class="relative mb-8">

                <h2 class="
                    text-3xl
                    md:text-5xl
                    font-bold
                    text-center
                ">

                    Hapus Lab

                </h2>

                <button type="button" id="btnTutupDelete" class="
                        absolute
                        top-0
                        right-0
                        text-3xl
                        cursor-pointer
                    ">

                    &times;

                </button>

            </div>

            <p id="deleteMessage" class="
                    text-center
                    text-gray-500
                    max-w-3xl
                    mx-auto
                    mb-10
                ">

                Hapus lab ...

            </p>

            <form method="POST">

                <input type="hidden" name="id" id="delete_id">

                <div class="
                    flex
                    flex-col
                    md:flex-row
                    gap-3
                ">

                    <button type="submit" name="hapus_lab" class="
                            flex-1
                            py-3
                            rounded-full
                            bg-[#FDD3D0]
                            hover:opacity-80
                            transition
                            cursor-pointer
                        ">

                        Iya

                    </button>

                    <button type="button" id="btnBatalDelete" class="
                            flex-1
                            py-3
                            rounded-full
                            border
                            border-[#FDD3D0]
                            hover:bg-gray-50
                            transition
                            cursor-pointer
                        ">

                        Tidak

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>