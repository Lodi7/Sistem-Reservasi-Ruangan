<?php

if (!isset($_SESSION['is_login'])) {

    header("Location: index.php?page=login");
    exit;

}