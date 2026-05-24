<?php

if (!isset($_SESSION['is_login'])) {

    header("Location: ?page=login");
    exit;

}