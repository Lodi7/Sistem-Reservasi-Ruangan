function getJadwal(
    labId,
    tanggal
) {

    return jadwalLabsData.find(

        item =>

            item.lab_id == labId
            &&
            item.tanggal == tanggal

    );

}


function getSesiTersedia(
    labId,
    tanggal
) {

    const data =
        getJadwal(
            labId,
            tanggal
        );


    if (!data) {

        return [];

    }


    return data.jadwal.filter(

        item =>

            item.status ==
            'Tersedia'

    );

}