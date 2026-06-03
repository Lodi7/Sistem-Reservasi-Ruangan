const reservasiLab =
    document.getElementById(
        'reservasiLab'
    );

const reservasiTanggal =
    document.getElementById(
        'reservasiTanggal'
    );

const sesiContainer =
document.querySelector(
    '.sesiContainer'
)

const summaryLab =
    document.getElementById(
        'summaryLab'
    );

const summaryTanggal =
    document.getElementById(
        'summaryTanggal'
    );

const summarySesi =
    document.getElementById(
        'summarySesi'
    );

const reservasiForm =
    document.getElementById(
        'reservasiForm'
    );

const tanggalInput =
    document.getElementById(
        'tanggalInput'
    );

if (

    reservasiLab &&
    reservasiTanggal &&
    sesiContainer

) {

    // default
    let selectedLab =
        reservasiLab.value;

    let selectedDate =
        flatpickr.formatDate(
            new Date(),
            "Y-m-d"
        );


    // update ringkasan
    function updateSummary() {

        const selectedOption =
            reservasiLab.options[
                reservasiLab.selectedIndex
            ];


        summaryLab.textContent =
            selectedOption.textContent;


        summaryTanggal.textContent =
            new Date(
                selectedDate
            ).toLocaleDateString(
                'id-ID',
                {

                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'

                }
            );

    tanggalInput.value =
        selectedDate;

    }


    // render sesi
    function renderSesi() {

        const data =
            getJadwal(
                selectedLab,
                selectedDate
            );


        sesiContainer.innerHTML =
            '';


        // tidak ada data
        if (!data) {

            sesiContainer.innerHTML =
                `
                    <div class="
                        text-center
                        py-10
                    ">
                        Jadwal tidak ditemukan
                    </div>
                `;

            return;

        }


        // loop sesi
        data.jadwal.forEach(
            item => {

                const disabled =
                    item.status !=
                    'Tersedia';


                let statusClass =
                    'bg-[#CFF7D3] text-[#14AE5C]';

                if (
                    item.status ==
                    'Dipakai'
                ) {

                    statusClass =
                        'bg-[#FDD3D0] text-[#EC221F]';

                }


                // Perbaikan
                else if (
                    item.status ==
                    'Perbaikan'
                ) {

                    statusClass =
                        'bg-[#FFF1C2] text-[#BF6A02]';

                }


                // non aktif
                else if (

                    item.status ==
                    'Non-aktif'

                    ||

                    item.status ==
                    'Non-aktif'

                ) {

                    statusClass =
                        'bg-gray-200 text-gray-700';

                }


                sesiContainer.innerHTML +=
                    `
                        <label class="
                            relative
                            border
                            border-gray-300
                            rounded-2xl
                            p-5
                            flex
                            justify-between
                            items-center
                            ${disabled
                                ? 'opacity-60 cursor-not-allowed'
                                : 'cursor-pointer hover:border-black'}
                        ">

                            <div class="
                                flex
                                flex-col
                                gap-2
                                items-start
                            ">

                                <p class="
                                    text-lg
                                    font-semibold
                                ">
                                    ${item.sesi}
                                </p>

                                <p class="
                                    text-sm
                                    text-gray-500
                                ">
                                    ${item.jam}
                                </p>

                                <span class="
                                    absolute
                                    top-4
                                    right-4
                                    w-fit
                                    px-4
                                    py-1.5
                                    rounded-full
                                    text-sm
                                    font-medium
                                    ${statusClass}
                                ">

                                    ${item.status}

                                </span>

                            </div>


                            <input
                                type="radio"
                                name="sesi"

                                value="${item.sesi}"
                                data-jam="${item.jam}"

                                ${disabled
                                    ? 'disabled'
                                    : ''}

                                class="
                                    absolute
                                    bottom-5
                                    right-5
                                    w-5
                                    h-5
                                ">
                        </label>
                    `;
            }
        );


        // select sesi
        document
            .querySelectorAll(
                'input[name="sesi"]'
            )

            .forEach(
                radio => {

                    radio.addEventListener(
                        'change',
                        () => {

                            summarySesi.textContent =
                                `${radio.value} (${radio.dataset.jam})`;

                        }
                    );

                }
            );

    }


    // flatpickr
    const calendar =
        flatpickr(
            "#reservasiTanggal",
            {

                inline: true,

                minDate:
                    "today",

                maxDate:
                    new Date().fp_incr(13),

                defaultDate:
                    "today",

                dateFormat:
                    "Y-m-d",

                disableMobile:
                    true,


                // warna tanggal
                onDayCreate: (

                    dObj,
                    dStr,
                    fp,
                    dayElem

                ) => {

                    const date =
                        flatpickr.formatDate(
                            dayElem.dateObj,
                            "Y-m-d"
                        );


                    dayElem.classList.remove(
                        'full-date'
                    );

                    dayElem.classList.remove(
                        'partial-date'
                    );


                    const data =
                        jadwalLabsData.find(

                            item =>

                                item.lab_id ==
                                selectedLab

                                &&

                                item.tanggal ==
                                date

                        );


                    // tidak ada data
                    if (!data) {

                        return;

                    }


                    // warna tanggal jadwal penuh
                    if (
                        data.is_full
                    ) {

                        dayElem.classList.add(
                            'full-date'
                        );

                    }


                    // warna tanggal tersedia
                    else if (
                        data.is_partial
                    ) {

                        dayElem.classList.add(
                            'partial-date'
                        );

                    }

                },

                onChange: (

                    selectedDates,
                    dateStr

                ) => {

                    selectedDate =
                        dateStr;

                    updateSummary();

                    renderSesi();

                }

            }
        );


    // ganti lab
    reservasiLab.addEventListener(
        'change',
        () => {

            selectedLab =
                reservasiLab.value;

            calendar.redraw();

            updateSummary();

            renderSesi();

        }
    );


    // load ringkasan
    updateSummary();

    renderSesi();

}


// validasi form
if (reservasiForm) {

    reservasiForm.addEventListener(
        'submit',
        (e) => {

            // cek sesi
            const sesi =
                document.querySelector(
                    'input[name="sesi"]:checked'
                );


            // belum pilih sesi
            if (!sesi) {

                e.preventDefault();

                alert(
                    'Pilih sesi terlebih dahulu'
                );

                return;

            }


            // ambil input
            const dosen =
                document.querySelector(
                    'input[placeholder="XXXXXXXX"]'
                );

            const kontak =
                document.querySelector(
                    'input[placeholder="08xxxxxxxxxx"]'
                );

            const keperluan =
                document.querySelector(
                    'textarea'
                );


            // dosen kosong
            if (
                dosen.value.trim() == ''
            ) {

                e.preventDefault();

                alert(
                    'Nama dosen wajib diisi'
                );

                dosen.focus();

                return;

            }


            // kontak kosong
            if (
                kontak.value.trim() == ''
            ) {

                e.preventDefault();

                alert(
                    'Kontak wajib diisi'
                );

                kontak.focus();

                return;

            }


            // keperluan kosong
            if (
                keperluan.value.trim() == ''
            ) {

                e.preventDefault();

                alert(
                    'Keperluan wajib diisi'
                );

                keperluan.focus();

                return;

            }

        }
    );

}