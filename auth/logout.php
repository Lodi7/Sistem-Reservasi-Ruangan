<?php

session_start();

session_destroy();
setcookie(
    "remember_email",
    "",
    time() - 3600,
    "/"
);

echo "
<script>

    window.location.href =
    'index.php?page=beranda';

</script>
";