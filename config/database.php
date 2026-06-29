<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "paulitest";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal");
}
