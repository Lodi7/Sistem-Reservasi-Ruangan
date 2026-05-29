<?php

session_start();

session_destroy();
setcookie(
    "remember_email",
    "",
    time() - 3600,
    "/"
);
header("Location: index.php?page=beranda");
