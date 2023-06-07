<?php
session_start();
if (!isset($_SESSION['state_login'])) {
    header("location:login.php");
    exit();
}