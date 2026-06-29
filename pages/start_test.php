<?php

require '../includes/session.php';
require '../config/database.php';

if (!isset($_SESSION['participant_id'])) {
  header("Location: home.php");
  exit;
}

$id = (int) $_SESSION['participant_id'];

// Ambil status peserta
$result = mysqli_query($conn, "SELECT status FROM participants WHERE id = $id");
$participant = mysqli_fetch_assoc($result);

if (!$participant) {
  die("Peserta tidak ditemukan.");
}

// Jika sudah selesai, tidak boleh masuk lagi
if ($participant['status'] === 'Selesai') {
  die("
        <div style='
            font-family:Arial;
            text-align:center;
            margin-top:80px'>
            <h2>Anda sudah menyelesaikan tes.</h2>
            <p>Tes hanya dapat dikerjakan satu kali.</p>
        </div>
    ");
}

// Jika soal belum dibuat
if (!isset($_SESSION['numbers'])) {

  $ROWS = 100;
  $COLS = 20;

  $numbers = [];

  for ($c = 0; $c < $COLS; $c++) {

    for ($r = 0; $r < $ROWS; $r++) {

      $numbers[$c][$r] = rand(0, 9);
    }
  }

  $_SESSION['numbers'] = $numbers;

  // Update status menjadi Sedang
  mysqli_query(
    $conn,
    "UPDATE participants
         SET status = 'Sedang',
             started_at = NOW()
         WHERE id = $id"
  );
}

header("Location: test.php");
exit;
