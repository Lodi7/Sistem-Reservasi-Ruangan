    const codeModal =
        document.getElementById(
            'codeModal'
        );

    const deleteModal =
        document.getElementById(
            'deleteModal'
        );

    const cancelModal =
        document.getElementById(
            'cancelModal'
        );


    // open modal kode reservasi
function openCodeModal(button) {

    const code =
        button.dataset.code;

    const date =
        button.dataset.date;

    const time =
        button.dataset.time;


    document.getElementById(
        'modalCode'
    ).textContent =
        code;

    document.getElementById(
        'modalDate'
    ).textContent =
        `${date}, ${time}`;


    codeModal.classList.remove(
        'hidden'
    );

    codeModal.classList.add(
        'flex'
    );

}

    function closeCodeModal() {

        codeModal.classList.add(
            'hidden'
        );

        codeModal.classList.remove(
            'flex'
        );

    }


    // hapus modal reservasi
    function openDeleteModal(id) {

        document.getElementById(
            'deleteReservasiId'
        ).value = id;

        deleteModal.classList.remove(
            'hidden'
        );

        deleteModal.classList.add(
            'flex'
        );

    }


    function closeDeleteModal() {

        deleteModal.classList.add(
            'hidden'
        );

        deleteModal.classList.remove(
            'flex'
        );

    }


    // batalkan reservasi modal
    function openCancelModal(id) {

        document.getElementById(
            'cancelReservasiId'
        ).value = id;

        cancelModal.classList.remove(
            'hidden'
        );

        cancelModal.classList.add(
            'flex'
        );

    }


    function closeCancelModal() {

        cancelModal.classList.add(
            'hidden'
        );

        cancelModal.classList.remove(
            'flex'
        );

    }
