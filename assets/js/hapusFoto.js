const hapusFotoButton =
    document.getElementById(
        'hapusFotoButton'
    );

const hapusModal =
    document.getElementById(
        'hapusModal'
    );

const batalHapus =
    document.getElementById(
        'batalHapus'
    );

const confirmHapus =
    document.getElementById(
        'confirmHapus'
    );

if (
    hapusFotoButton &&
    hapusModal &&
    batalHapus &&
    confirmHapus
) {

    // buka modal hapus
    hapusFotoButton.addEventListener(
        'click',
        () => {

            hapusModal.classList.remove(
                'hidden'
            );

            hapusModal.classList.add(
                'flex'
            );

        }
    );


    // tutup modal
    batalHapus.addEventListener(
        'click',
        () => {

            hapusModal.classList.add(
                'hidden'
            );

            hapusModal.classList.remove(
                'flex'
            );

        }
    );


    // konfirmasi hapus
    confirmHapus.addEventListener(
        'click',
        () => {

            previewImage.src =
                'assets/images/profile-default.png?t=' +
                new Date().getTime();

            document.getElementById(
                'submitHapusFoto'
            ).click();

        }
    );

}