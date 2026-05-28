const labSelect =
    document.getElementById(
        'labSelect'
    );

const tanggal =
    document.getElementById(
        'tanggal'
    );

const jadwalDate =
    document.getElementById(
        'jadwalDate'
    );

const jadwalLab =
    document.getElementById(
        'jadwalLab'
    );

const jadwalLocation =
    document.getElementById(
        'jadwalLocation'
    );

const jadwalTable =
    document.getElementById(
        'jadwalTable'
    );

if (

    labSelect &&
    tanggal &&
    jadwalDate &&
    jadwalLab &&
    jadwalLocation &&
    jadwalTable

) {

    // default lab
    let selectedLab =
        labSelect.value;


    // default tanggal
    const today =
        flatpickr.formatDate(
            new Date(),
            "Y-m-d"
        );

    let selectedDate =
        today;


    // flatpickr
    const calendar =
        flatpickr(
            "#tanggal",
            {

                minDate:
                    "today",

                maxDate:
                    new Date().fp_incr(13),

                defaultDate:
                    today,

                dateFormat:
                    "Y-m-d",

                disableMobile:
                    true,


                // custom warna tanggal
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


                    // penuh
                    if (
                        data.is_full
                    ) {

                        dayElem.classList.add(
                            'full-date'
                        );

                    }


                    // tersedia
                    else if (
                        data.is_partial
                    ) {

                        dayElem.classList.add(
                            'partial-date'
                        );

                    }

                },


                // ganti tanggal
                onChange: (

                    selectedDates,
                    dateStr

                ) => {

                    selectedDate =
                        dateStr;

                    renderTable();

                }

            }
        );


    // pilih lab
    labSelect.addEventListener(
        'change',
        () => {

            selectedLab =
                labSelect.value;


            // redraw kalender
            calendar.redraw();


            renderTable();

        }
    );


    // render tabel
    function renderTable() {

        const data =
            getJadwal(
                selectedLab,
                selectedDate
            );


        // tidak ada data
        if (!data) {

            jadwalTable.innerHTML =
                `
                    <div class="
                        py-15
                        text-center
                        text-xl
                    ">
                        Jadwal tidak ditemukan
                    </div>
                `;

            return;

        }


        // header tabel
        jadwalDate.textContent =
            new Date(
                data.tanggal
            ).toLocaleDateString(
                'id-ID',
                {

                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'

                }
            );

        jadwalLab.textContent =
            data.nama_lab;

        jadwalLocation.textContent =
            data.lokasi;


        // tabel
        jadwalTable.innerHTML =
            data.table;

    }


    // load
    renderTable();

}