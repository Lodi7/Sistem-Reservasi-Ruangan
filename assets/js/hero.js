const slides =
    document.querySelectorAll('.hero-slide')

const indicators =
    document.querySelectorAll('.indicator')

const nextBtn =
    document.getElementById('nextBtn')

const prevBtn =
    document.getElementById('prevBtn')

if (
    slides.length > 0 &&
    indicators.length > 0 &&
    nextBtn &&
    prevBtn
) {

    let currentSlide = 0

    function showSlide(index) {

        // slide
        slides.forEach(slide => {

            slide.classList.remove('opacity-100')
            slide.classList.add('opacity-0')

        })

        slides[index].classList.remove('opacity-0')
        slides[index].classList.add('opacity-100')


        // indicator
        indicators.forEach(indicator => {

            indicator.classList.remove(
                'w-12',
                'bg-white'
            )

            indicator.classList.add(
                'w-3',
                'bg-white/50'
            )

        })

        indicators[index].classList.remove(
            'w-3',
            'bg-white/50'
        )

        indicators[index].classList.add(
            'w-12',
            'bg-white'
        )

    }


    // next
    nextBtn.addEventListener('click', () => {

        currentSlide++

        if (
            currentSlide >= slides.length
        ) {

            currentSlide = 0

        }

        showSlide(currentSlide)

    })


    // prev
    prevBtn.addEventListener('click', () => {

        currentSlide--

        if (currentSlide < 0) {

            currentSlide =
                slides.length - 1

        }

        showSlide(currentSlide)

    })


    // click indicator
    indicators.forEach(
        (indicator, index) => {

            indicator.addEventListener(
                'click',
                () => {

                    currentSlide = index

                    showSlide(currentSlide)

                }
            )

        }
    )


    // slide auto pindah
    setInterval(() => {

        currentSlide++

        if (
            currentSlide >= slides.length
        ) {

            currentSlide = 0

        }

        showSlide(currentSlide)

    }, 5000)

}