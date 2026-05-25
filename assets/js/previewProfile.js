const previewImage =
    document.getElementById(
        'previewImage'
    );

const fotoInput =
    document.getElementById(
        'fotoProfileInput'
    );

const cropModal =
    document.getElementById(
        'cropModal'
    );

const cropImage =
    document.getElementById(
        'cropImage'
    );

const saveCrop =
    document.getElementById(
        'saveCrop'
    );

const cancelCrop =
    document.getElementById(
        'cancelCrop'
    );

const submitFoto =
    document.getElementById(
        'submitFoto'
    );

const uploadButton =
    document.getElementById(
        'uploadButton'
    );

let cropper;


uploadButton.addEventListener(
    'click',
    () => {

        fotoInput.click();

    }
);


// PILIH FILE
fotoInput.addEventListener(
    'change',
    (e) => {

        const file =
            e.target.files[0];

        if (!file) return;

        const imageURL =
            URL.createObjectURL(file);

        cropImage.src =
            imageURL;

        cropModal.classList.remove(
            'hidden'
        );

        cropModal.classList.add(
            'flex'
        );

        // DESTROY
        if (cropper) {

            cropper.destroy();

        }

        cropImage.onload = () => {
                cropper =
    new Cropper(
        cropImage,
        {

            aspectRatio: 1,

            viewMode: 1,

            autoCropArea: 1,

            responsive: true,

            movable: true,

            zoomable: true,

            scalable: false,

            cropBoxMovable: true,

            cropBoxResizable: true,

        }
);

        };

    }
);


// SAVE CROP
saveCrop.addEventListener(
    'click',
    () => {

        const canvas =
            cropper.getCroppedCanvas({

                width: 500,

                height: 500,

            });

        // PREVIEW
        previewImage.src =
            canvas.toDataURL();

        // BLOB
        canvas.toBlob((blob) => {

            const file =
                new File(
                    [blob],
                    'profile.png',
                    {
                        type: 'image/png'
                    }
                );

            const dataTransfer =
                new DataTransfer();

            dataTransfer.items.add(file);

            fotoInput.files =
                dataTransfer.files;

            // CLOSE MODAL
            cropModal.classList.add(
                'hidden'
            );

            cropModal.classList.remove(
                'flex'
            );

            // AUTO SUBMIT
            submitFoto.click();

        });

    }
);


// CANCEL
cancelCrop.addEventListener(
    'click',
    () => {

        cropModal.classList.add(
            'hidden'
        );

        cropModal.classList.remove(
            'flex'
        );

        cropper.destroy();

    }
);

