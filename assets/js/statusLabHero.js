const dateText =
    document.getElementById(
        'statusLabDate'
    );

const title =
    document.getElementById(
        'statusLabTitle'
    );

const locationText =
    document.getElementById(
        'statusLabLocation'
    );

const table =
    document.getElementById(
        'statusLabTable'
    );

const calendar =
    document.getElementById(
        'calendar'
    );

const card =
    document.getElementById(
        'statusLabCard'
    );

if (

    dateText &&
    title &&
    locationText &&
    table &&
    calendar &&
    card

) {

    // data lab dari script yg di footer
    const labs =
        labsData;


    let currentIndex = 0;


    // library flatpickr
    flatpickr(
        "#calendar",
        {

            inline: true,

            defaultDate:
                "today",

            enable: [
                "today"
            ],

            disableMobile: true

        }
    );

    function renderLab() {

        if (
            labs.length == 0
        ) {

            return;

        }


        const lab =
            labs[currentIndex];


        // animasi keluar
        gsap.to(
            card,
            {

                opacity: 0,
                scale: 0.97,
                filter: "blur(8px)",

                duration: 1,

                ease: "power2.out",

                onComplete: () => {

                    // update data
                    dateText.textContent =
                        new Date().toLocaleDateString(
                            'id-ID',
                            {

                                weekday: 'long',
                                day: 'numeric',
                                month: 'long'

                            }
                        );

                    title.textContent =
                        lab.nama;

                    locationText.textContent =
                        lab.lokasi;

                    table.innerHTML =
                        lab.table;


                    // animasi masuk
                    gsap.to(
                        card,
                        {

                            opacity: 1,
                            scale: 1,
                            filter: "blur(0px)",

                            duration: 1,

                            ease: "power3.out"

                        }
                    );

                }

            }
        );

    }


    // auto 
    setInterval(() => {

        if (
            labs.length == 0
        ) {

            return;

        }

        currentIndex++;

        if (

            currentIndex
            >=
            labs.length

        ) {

            currentIndex = 0;

        }

        renderLab();

    }, 5000);

    gsap.set(
        card,
        {

            opacity: 1,
            scale: 1,
            filter: "blur(0px)"

        }
    );

    renderLab();

}