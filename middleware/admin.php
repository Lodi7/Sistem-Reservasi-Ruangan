<?php

if (!isset($_SESSION['is_login'])) {

    header("Location: ../index.php?page=login");
    exit;

}

if ($_SESSION['role'] !== 'admin') {

    include __DIR__ . '/../pages/404.php';
    exit;

}