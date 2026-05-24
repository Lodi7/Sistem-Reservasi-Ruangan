<section class="mt-30 px-5 sm:px-15 md:px-25">
    <div class="flex gap-4 flex-col">
        <div class="flex xl:flex-row xl:items-end justify-between gap-4 flex-col ">
            <div class="flex flex-col gap-4">
                <h1 class="text-4xl md:text-5xl xl:text-6xl font-bold">
                    Status Lab Terkini
                </h1>
                <P class="text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed max-w-184.5">
                    Cek jadwal lab, informasi status slot diperbarui secara otomatis setiap saat, membantu Anda
                    menemukan
                    waktu
                    terbaik untuk reservasi fasilitas laboratorium.
                </P>
            </div>
            <a href="index.php?page=informasi_lab" class="
    bg-[#FF925C] text-white rounded-full font-semibold

    text-sm sm:text-base md:text-lg lg:text-xl

    px-5 sm:px-6 md:px-7 lg:px-8.5
    py-2 sm:py-2.5 md:py-3

    flex gap-2 sm:gap-3 items-center
    w-fit

    hover:opacity-80 transition duration-300
">
                <span>Lihat Selengkapnya</span>

                <svg class="w-4 sm:w-5" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">

                    <path
                        d="M0.999725 6.53972L-0.000107106 6.55806L0.0365763 8.55772L1.03641 8.53938L1.01807 7.53955L0.999725 6.53972ZM17.7346 7.94011C18.1179 7.54249 18.1063 6.90943 17.7087 6.52614L11.229 0.279975C10.8314 -0.103321 10.1984 -0.0917078 9.81507 0.305914C9.43178 0.703535 9.44339 1.33659 9.84101 1.71989L15.6007 7.27204L10.0485 13.0317C9.66523 13.4293 9.67684 14.0624 10.0745 14.4457C10.4721 14.829 11.1051 14.8174 11.4884 14.4197L17.7346 7.94011ZM1.01807 7.53955L1.03641 8.53938L17.033 8.24593L17.0146 7.2461L16.9963 6.24626L0.999725 6.53972L1.01807 7.53955Z"
                        fill="white" />
                </svg>
            </a>
        </div>
        <div class="flex flex-col lg:flex-row justify-center items-center gap-11.25">
            <input type="text" id="statusReservasiTerkini" hidden>
            <div class="
    bg-white
    rounded-3xl
    border
    border-gray-300
    overflow-hidden
    w-full
">

                <div id="sessionWrapper" class="
            transition-all
            duration-500
            opacity-100
        ">

                    <div class="
            grid grid-cols-2
            bg-[#FF925C]
            p-5
            text-white
            items-center
        ">

                        <div id="TglHariIni"
                            class="font-semibold pl-5 md:pl-10 lg:pl-15 text-lg md:text-xl lg:text-2xl">
                        </div>

                        <div id="NamaLab"
                            class="text-right font-light pr-5 md:pr-10 lg:pr-15 text-[12px] md:text-sm lg:text-base">
                        </div>

                    </div>

                    <div id="sessionContainer"></div>

                </div>

            </div>
        </div>
    </div>
</section>