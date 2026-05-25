const slides =
    document.querySelectorAll('.hero-slide')

const indicators =
    document.querySelectorAll('.indicator')

const nextBtn =
    document.getElementById('nextBtn')

const prevBtn =
    document.getElementById('prevBtn')


// CEK ELEMENT ADA
if (
    slides.length > 0 &&
    indicators.length > 0 &&
    nextBtn &&
    prevBtn
) {

    let currentSlide = 0

    function showSlide(index) {

        // SLIDE
        slides.forEach(slide => {

            slide.classList.remove('opacity-100')
            slide.classList.add('opacity-0')

        })

        slides[index].classList.remove('opacity-0')
        slides[index].classList.add('opacity-100')


        // INDICATOR
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


    // NEXT
    nextBtn.addEventListener('click', () => {

        currentSlide++

        if (
            currentSlide >= slides.length
        ) {

            currentSlide = 0

        }

        showSlide(currentSlide)

    })


    // PREV
    prevBtn.addEventListener('click', () => {

        currentSlide--

        if (currentSlide < 0) {

            currentSlide =
                slides.length - 1

        }

        showSlide(currentSlide)

    })


    // CLICK INDICATOR
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


    // AUTO SLIDE
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