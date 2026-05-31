const labsContainer =
    document.getElementById(
        'labsContainer'
    );

if (labsContainer) {

    let currentIndex = 0;

    async function refreshLabs() {

        currentIndex++;

        const response =
            await fetch(
                `components/render_card_labs.php?index=${currentIndex}`
            );

        const html =
            await response.text();

        labsContainer.classList.add(
            'opacity-0'
        );

        setTimeout(() => {

            labsContainer.innerHTML =
                html;

            AOS.refreshHard();    

            labsContainer.classList.remove(
                'opacity-0'
            );

        }, 500);

    }

    refreshLabs();

    setInterval(() => {

        refreshLabs();

    }, 5000);

}