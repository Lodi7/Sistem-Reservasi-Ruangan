// Modal Tambah Lab
const btnTambahLab = document.getElementById('btnTambahLab');
const modalTambahLab = document.getElementById('modalTambahLab');
const btnTutupTambah = document.getElementById('btnTutupTambah');
const btnBatalTambah = document.getElementById('btnBatalTambah');

if (modalTambahLab) {

    btnTambahLab?.addEventListener('click', () => {
        modalTambahLab.classList.remove('hidden');
    });

    btnTutupTambah?.addEventListener('click', () => {
        modalTambahLab.classList.add('hidden');
    });

    btnBatalTambah?.addEventListener('click', () => {
        modalTambahLab.classList.add('hidden');
    });

}

// Modal Edit
const modalEditLab = document.getElementById('modalEditLab');

if (modalEditLab) {

    document
        .querySelectorAll('[data-modal-edit]')
        .forEach(btn => {

            btn.addEventListener('click', () => {

                const editId = document.getElementById('edit_id');
                const editNamaLab = document.getElementById('edit_nama_lab');
                const editKapasitas = document.getElementById('edit_kapasitas');
                const editLuas = document.getElementById('edit_luas');
                const editLokasi = document.getElementById('edit_lokasi');
                const editStatusValue = document.getElementById('editStatusValue');
                const editStatusLabel = document.getElementById('editStatusLabel');
                const editFasilitas = document.getElementById('edit_fasilitas');
                const editDeskripsi = document.getElementById('edit_deskripsi');
                const editJamBuka = document.getElementById('edit_jam_buka');
                const editJamTutup = document.getElementById('edit_jam_tutup');
                const previewGambar = document.getElementById('preview_gambar');

                if (
                    !editId ||
                    !editNamaLab ||
                    !editKapasitas ||
                    !editLuas ||
                    !editLokasi ||
                    !editStatusValue ||
                    !editStatusLabel ||
                    !editFasilitas ||
                    !editDeskripsi ||
                    !editJamBuka ||
                    !editJamTutup
                ) {
                    return;
                }

                editId.value = btn.dataset.id || '';
                editNamaLab.value = btn.dataset.nama || '';
                editKapasitas.value = btn.dataset.kapasitas || '';
                editLuas.value = btn.dataset.luas || '';
                editLokasi.value = btn.dataset.lokasi || '';

                const status = btn.dataset.status || '';

                editStatusValue.value = status;
                editStatusLabel.textContent = status;

                const warna = {
                    'Tersedia': 'bg-[#CFF7D3] text-[#307445]',
                    'Perbaikan': 'bg-[#FFF1C2] text-[#BF6A02]',
                    'Non-aktif': 'bg-[#FDD3D0] text-[#EE3835]'
                };

                editStatusLabel.className =
                    `px-4 py-1 rounded-xl text-sm ${warna[status] || ''}`;

                editFasilitas.value = btn.dataset.fasilitas || '';
                editDeskripsi.value = btn.dataset.deskripsi || '';
                editJamBuka.value = btn.dataset.jamBuka || '';
                editJamTutup.value = btn.dataset.jamTutup || '';

                if (previewGambar) {
                    previewGambar.src = btn.dataset.gambar || '';
                }

                modalEditLab.classList.remove('hidden');

            });

        });

    const btnTutupEdit = document.getElementById('btnTutupEdit');
    const btnBatalEdit = document.getElementById('btnBatalEdit');

    btnTutupEdit?.addEventListener('click', () => {
        modalEditLab.classList.add('hidden');
    });

    btnBatalEdit?.addEventListener('click', () => {
        modalEditLab.classList.add('hidden');
    });

}

// Dropdown Status Tambah
const statusTrigger = document.getElementById('statusTrigger');
const statusDropdown = document.getElementById('statusDropdown');
const statusLabel = document.getElementById('statusLabel');
const statusValue = document.getElementById('statusValue');

if (
    statusTrigger &&
    statusDropdown &&
    statusLabel &&
    statusValue
) {

    const statusColors = {
        'Tersedia': 'bg-[#CFF7D3] text-[#307445]',
        'Perbaikan': 'bg-[#FFF1C2] text-[#BF6A02]',
        'Non-aktif': 'bg-[#FDD3D0] text-[#EE3835]'
    };

    statusTrigger.addEventListener('click', () => {
        statusDropdown.classList.toggle('hidden');
    });

    document
        .querySelectorAll('.status-option')
        .forEach(item => {

            item.addEventListener('click', () => {

                const status = item.dataset.value;

                statusValue.value = status;
                statusLabel.textContent = status;

                statusLabel.className = `
                    px-4
                    py-1
                    rounded-xl
                    text-sm
                    font-medium
                    ${statusColors[status] || ''}
                `;

                statusDropdown.classList.add('hidden');

            });

        });

    document.addEventListener('click', (e) => {

        if (
            !statusTrigger.contains(e.target) &&
            !statusDropdown.contains(e.target)
        ) {
            statusDropdown.classList.add('hidden');
        }

    });

}

// Dropdown Status Edit
const editStatusTrigger = document.getElementById('editStatusTrigger');
const editStatusDropdown = document.getElementById('editStatusDropdown');
const editStatusLabel = document.getElementById('editStatusLabel');
const editStatusValue = document.getElementById('editStatusValue');

if (
    editStatusTrigger &&
    editStatusDropdown &&
    editStatusLabel &&
    editStatusValue
) {

    editStatusTrigger.addEventListener('click', () => {
        editStatusDropdown.classList.toggle('hidden');
    });

    document
        .querySelectorAll('#editStatusDropdown .status-option')
        .forEach(item => {

            item.addEventListener('click', () => {

                const status = item.dataset.value;

                editStatusValue.value = status;
                editStatusLabel.textContent = status;

                const warna = {
                    'Tersedia': 'bg-[#CFF7D3] text-[#307445]',
                    'Perbaikan': 'bg-[#FFF1C2] text-[#BF6A02]',
                    'Non-aktif': 'bg-[#FDD3D0] text-[#EE3835]'
                };

                editStatusLabel.className =
                    `px-4 py-1 rounded-xl text-sm ${warna[status] || ''}`;

                editStatusDropdown.classList.add('hidden');

            });

        });

}

// Modal Delete
const modalDeleteLab = document.getElementById('modalDeleteLab');
const deleteId = document.getElementById('delete_id');
const deleteMessage = document.getElementById('deleteMessage');

if (modalDeleteLab && deleteId && deleteMessage) {

    document
        .querySelectorAll('[data-modal-delete]')
        .forEach(btn => {

            btn.addEventListener('click', () => {

                deleteId.value = btn.dataset.id || '';

                deleteMessage.innerHTML = `
                    Hapus lab akan menghapus entri
                    <b>${btn.dataset.nama}</b>
                    dalam LabHub.

                    Tindakan ini tidak dapat dibatalkan.

                    Apakah kamu yakin ingin melanjutkan
                    Hapus Lab
                    <b>${btn.dataset.nama}</b>?
                `;

                modalDeleteLab.classList.remove('hidden');

            });

        });

    document
        .getElementById('btnTutupDelete')
        ?.addEventListener('click', () => {
            modalDeleteLab.classList.add('hidden');
        });

    document
        .getElementById('btnBatalDelete')
        ?.addEventListener('click', () => {
            modalDeleteLab.classList.add('hidden');
        });

}