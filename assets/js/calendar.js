flatpickr("#statusReservasiTerkini", {
    inline: true,
    defaultDate: "today",
    enable: [new Date()],
        onChange: function(selectedDates, dateStr) {

        getSessions(dateStr);

    },

    onDayCreate: function(dObj, dStr, fp, dayElem) {

        const today = new Date();
        today.setHours(0,0,0,0);

        const dayDate = new Date(dayElem.dateObj);
        dayDate.setHours(0,0,0,0);

        if(dayDate < today) {
            dayElem.classList.add("before-today");
        }

        if(dayDate > today) {
            dayElem.classList.add("after-today");
        }

    }
});

const tanggal = new Date();

document.getElementById("TglHariIni")
.innerHTML =
tanggal.toLocaleDateString("id-ID", {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric"
});

getSessions(
    flatpickr.formatDate(
        new Date(),
        "Y-m-d"
    )
);
    const labs = [

        "Lab PPSTI",

        "Lab SCR",

        "Lab Solusi",
        "Lab Rekayasa dan Bisnis Digital",
        "Lab MSI",
        "Lab Sains Data",
        "Lab INSYDE"

    ];

    let currentLab = 0;
    // =========================
    // FETCH SESSION
    // =========================

    async function getSessions(
        tanggal,
        lab
    ) {

        const response = await fetch(

            `api/get_sessions.php?tanggal=${tanggal}&lab=${lab}`

        );

        const bookedSessions =
            await response.json();

        renderSessions(bookedSessions);

    }

    // =========================
    // RENDER SESSION
    // =========================

    function renderSessions(bookedSessions) {

        const sessions = [

            {
                sesi: 1,
                waktu: "07.00 - 09.30"
            },

            {
                sesi: 2,
                waktu: "09.30 - 12.00"
            },

            {
                sesi: 3,
                waktu: "13.00 - 15.30"
            }

        ];

        let html = "";

        sessions.forEach(session => {

            const dipakai =
                bookedSessions.includes(
                    session.sesi
                );

            html += `

                <div class="
                    grid grid-cols-3
                    place-items-center
                    p-5
                    border-t
                    border-gray-200
                ">

                    <div>
                        Sesi ${session.sesi}
                    </div>

                    <div>
                        ${session.waktu}
                    </div>

                    <div>

                        ${
                            dipakai

                            ?

                            `
                                <span class="
                                    bg-[#FDD3D0]
                                    text-[#EC221F]
                                    px-4 py-2
                                    rounded-full
                                ">
                                    Dipakai
                                </span>
                            `

                            :

                            `
                                <span class="
                                    bg-[#CFF7D3]
                                    text-[#14AE5C]
                                    px-4 py-2
                                    rounded-full
                                ">
                                    Tersedia
                                </span>
                            `
                        }

                    </div>

                </div>

            `;

        });

        document.getElementById(
            "sessionContainer"
        ).innerHTML = html;

    }

    // =========================
    // START
    // =========================

async function rotateLab() {

    const wrapper =
        document.getElementById(
            "sessionWrapper"
        );

    // Fade out
    wrapper.classList.remove(
        "opacity-100"
    );

    wrapper.classList.add(
        "opacity-0"
    );

    setTimeout(async () => {

        const lab = labs[currentLab];

        document.getElementById(
            "NamaLab"
        ).innerHTML = lab;

        await getSessions(

            flatpickr.formatDate(
                new Date(),
                "Y-m-d"
            ),

            lab

        );

        // Fade in
        wrapper.classList.remove(
            "opacity-0"
        );

        wrapper.classList.add(
            "opacity-100"
        );

        currentLab++;

        if(currentLab >= labs.length) {

            currentLab = 0;

        }

    }, 300);

}

rotateLab();

setInterval(() => {

    rotateLab();

}, 5000);