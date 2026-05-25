
document.querySelectorAll('.toggle-password').forEach(button => {

    button.addEventListener('click', function () {

        const input = this.parentElement.querySelector('.password-input');

        const eyeOpen = this.querySelector('.eye-open');

        const eyeClose = this.querySelector('.eye-close');

        if (input.type === 'password') {

            input.type = 'text';

            eyeOpen.classList.add('hidden');

            eyeClose.classList.remove('hidden');

        } else {

            input.type = 'password';

            eyeOpen.classList.remove('hidden');

            eyeClose.classList.add('hidden');

        }

    });

});
