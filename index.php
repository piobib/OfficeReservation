<?php
ob_start();
session_start();
$ROOT = "/OfficeReservation";

require_once 'config/connect.php';
include_once("WEB-INF/static/header.php");
if (isset($_GET['id'])) {
    if ($_GET['id'] === 'rezerwacja-miejsca') {
        include('WEB-INF/reservations.php');
    } else if ($_GET['id'] === 'lista-miejsc') {
        include('WEB-INF/places.php');
    } else {
        include_once("WEB-INF/mainPage.php");
    }
}
if (!isset($_GET['id'])) {
    include_once("WEB-INF/mainPage.php");
}
include_once("WEB-INF/static/footer.php");