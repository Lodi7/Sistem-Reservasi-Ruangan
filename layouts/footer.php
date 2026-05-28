<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    lucide.createIcons();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script>

    const labsData =
        <?= json_encode(
            $labsData ?? []
        ) ?>; //yang makek statusLabHero.js

</script>
<script>

    const jadwalLabsData =
        <?= json_encode(
            $labsData ?? []
        ) ?>;

</script>
<script src="assets/js/utils/jadwalLabs.js"></script>
<script src="assets/js/jadwalLab.js"></script>
<script src="assets/js/ajukanReservasi.js"></script>
<script src="assets/js/riwayat.js"></script>
<script src="../assets/js/navbar.js"></script>
<script src="../assets/js/hero.js"></script>
<script src="../assets/js/button.js"></script>
<script src="../assets/js/previewProfile.js"></script>
<script src="../assets/js/hapusFoto.js"></script>
<script src="../assets/js/cardLabsHero.js"></script>
<script src="../assets/js/statusLabHero.js"></script>
</body>

</html>