<?php

require '../includes/session.php';
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  header("Location: ../pages/biodata.php");
  exit;
}

$fullname   = trim($_POST['fullname']);
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
  $_SESSION['error'] = "Data belum lengkap.";
  header("Location: ../pages/biodata.php");
  exit;
}

/*
|--------------------------------------------------------------------------
| Cek Nama
|--------------------------------------------------------------------------
*/

$checkName = mysqli_prepare($conn, "SELECT id FROM participants WHERE fullname = ?");
mysqli_stmt_bind_param($checkName, "s", $fullname);
mysqli_stmt_execute($checkName);
mysqli_stmt_store_result($checkName);

if (mysqli_stmt_num_rows($checkName) > 0) {

  $_SESSION['error'] = "Nama peserta sudah terdaftar.";

  header("Location: ../pages/biodata.php");
  exit;
}

/*
|--------------------------------------------------------------------------
| Cek Email
|--------------------------------------------------------------------------
*/

if (!empty($email)) {

  $checkEmail = mysqli_prepare($conn, "SELECT id FROM participants WHERE email = ?");
  mysqli_stmt_bind_param($checkEmail, "s", $email);
  mysqli_stmt_execute($checkEmail);
  mysqli_stmt_store_result($checkEmail);

  if (mysqli_stmt_num_rows($checkEmail) > 0) {

    $_SESSION['error'] = "Email sudah pernah digunakan.";

    header("Location: ../pages/biodata.php");
    exit;
  }
}

/*
|--------------------------------------------------------------------------
| Membuat kode peserta
|--------------------------------------------------------------------------
*/

$unique_code = "PAULI-" . strtoupper(substr(md5(uniqid()), 0, 8));

/*
|--------------------------------------------------------------------------
| Simpan peserta
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare($conn, "
INSERT INTO participants
(unique_code, fullname, gender, age, education, email)
VALUES (?,?,?,?,?,?)
");

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

  $_SESSION['error'] = "Gagal menyimpan data peserta.";

  header("Location: ../pages/biodata.php");
  exit;
}

$participant_id = mysqli_insert_id($conn);

/*
|--------------------------------------------------------------------------
| Session Test
|--------------------------------------------------------------------------
*/

$session_token = bin2hex(random_bytes(32));

$stmt2 = mysqli_prepare($conn, "
INSERT INTO test_sessions
(participant_id, session_token, ip_address, user_agent)
VALUES (?,?,?,?)
");

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

/*
|--------------------------------------------------------------------------
| Session PHP
|--------------------------------------------------------------------------
*/

$_SESSION['participant_id'] = $participant_id;
$_SESSION['participant_code'] = $unique_code;
$_SESSION['session_token'] = $session_token;

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: ../pages/instruction.php");
exit;
