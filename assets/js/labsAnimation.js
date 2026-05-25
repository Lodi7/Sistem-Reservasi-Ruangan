let currentIndex = 0;

async function refreshLabs() {

    const container =
        document.getElementById('labsAnimation');

    if (!container) return;

    currentIndex++;

    const response = await fetch(
        `components/render_card_labs.php?start=${currentIndex}`
    );

    const html = await response.text();

    container.classList.add(
        'opacity-0',
        'scale-95'
    );

    setTimeout(() => {

        container.innerHTML = html;

        container.classList.remove(
            'opacity-0',
            'scale-95'
        );

    }, 500);
}

setInterval(refreshLabs, 10000); // refresh 10 detik