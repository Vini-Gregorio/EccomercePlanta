<?php
session_start();
if (empty($_SESSION['user_id'])) {
    $current = basename($_SERVER['SCRIPT_NAME']);
    header('Location: login.php?return=' . urlencode($current));
    exit;
}
