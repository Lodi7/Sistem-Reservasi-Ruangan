// MOBILE MENU
document.querySelectorAll('.menuButton').forEach((button) => {

    button.addEventListener('click', () => {

        const target = document.querySelector(
            button.dataset.target
        )

        target.classList.toggle('hidden')

    })

})


// DROPDOWN
document.querySelectorAll('.dropdownButton').forEach((button) => {

    button.addEventListener('click', (e) => {

        e.stopPropagation()

        const menu = document.querySelector(
            button.dataset.target
        )

        menu.classList.toggle('hidden')

    })

})


// CLOSE ALL DROPDOWN
document.addEventListener('click', () => {

    document.querySelectorAll('.dropdownMenu').forEach((menu) => {

        menu.classList.add('hidden')

    })

})