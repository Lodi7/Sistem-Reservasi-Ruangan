<?php

include __DIR__ . "/auth.php";

if ($_SESSION['role'] != 'admin') {

    include __DIR__ . "/../pages/404.php";
    exit;

}