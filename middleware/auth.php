<?php

if (!isset($_SESSION['is_login'])) {

    echo "
<script>

    window.location.href =
    'index.php?page=login';

</script>
";
    exit;

}