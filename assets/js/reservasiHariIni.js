document.addEventListener('DOMContentLoaded', () => {

    const dropdowns = document.querySelectorAll('.status-dropdown');

    if (!dropdowns.length) return;

    dropdowns.forEach(dropdown => {

        const trigger = dropdown.querySelector('.dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu');

        if (!trigger || !menu) return;

        trigger.addEventListener('click', (e) => {

            e.stopPropagation();

            // reset semua dropdown
            document.querySelectorAll('.status-dropdown').forEach(d => {
                d.style.zIndex = '1';
            });

            document.querySelectorAll('.dropdown-menu').forEach(otherMenu => {

                if (otherMenu !== menu) {
                    otherMenu.classList.add('hidden');
                }

            });

            // dropdown yang aktif jadi paling depan
            dropdown.style.position = 'relative';
            dropdown.style.zIndex = '99999';

            menu.classList.toggle('hidden');

        });

        menu.querySelectorAll('[data-status]').forEach(item => {

            item.addEventListener('click', () => {

                const form = dropdown.closest('form');

                if (!form) return;

                const input = form.querySelector(
                    'input[name="status"]'
                );

                if (!input) return;

                input.value = item.dataset.status;

                form.submit();

            });

        });

    });

    document.addEventListener('click', () => {

        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });

        document.querySelectorAll('.status-dropdown').forEach(d => {
            d.style.zIndex = '1';
        });

    });

});