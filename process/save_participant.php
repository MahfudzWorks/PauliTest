<?php

require '../includes/session.php';
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  header("Location: ../pages/biodata.php");
  exit;
}

$fullname  = trim($_POST['fullname']);
$age        = (int) $_POST['age'];
$gender     = trim($_POST['gender']);
$education  = trim($_POST['education']);
$email      = trim($_POST['email']);

if (
  empty($fullname) ||
  empty($age) ||
  empty($gender) ||
  empty($education)
) {
  die("Data belum lengkap.");
}

// cek email jika diisi
if (!empty($email)) {

  $check = mysqli_prepare($conn, "SELECT id FROM participants WHERE email=?");
  mysqli_stmt_bind_param($check, "s", $email);
  mysqli_stmt_execute($check);
  mysqli_stmt_store_result($check);

  if (mysqli_stmt_num_rows($check) > 0) {
    die("Email sudah pernah digunakan.");
  }
}

// membuat kode peserta
$unique_code = "PAULI-" . strtoupper(substr(md5(uniqid()), 0, 8));

// simpan peserta
$stmt = mysqli_prepare($conn, "INSERT INTO participants
(unique_code, fullname, gender, age, education, email)
VALUES (?,?,?,?,?,?)");

mysqli_stmt_bind_param(
  $stmt,
  "sssiss",
  $unique_code,
  $fullname,
  $gender,
  $age,
  $education,
  $email
);

if (!mysqli_stmt_execute($stmt)) {
  die("Gagal menyimpan peserta.");
}

$participant_id = mysqli_insert_id($conn);

// membuat session token
$session_token = bin2hex(random_bytes(32));

// simpan session database
$stmt2 = mysqli_prepare($conn, "INSERT INTO test_sessions
(participant_id, session_token, ip_address, user_agent)
VALUES (?,?,?,?)");

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

mysqli_stmt_bind_param(
  $stmt2,
  "isss",
  $participant_id,
  $session_token,
  $ip,
  $user_agent
);

mysqli_stmt_execute($stmt2);

// buat session php
$_SESSION['participant_id'] = $participant_id;
$_SESSION['participant_code'] = $unique_code;
$_SESSION['session_token'] = $session_token;

// redirect
header("Location: ../pages/instruction.php");
exit;
