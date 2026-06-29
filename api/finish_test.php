<?php

header('Content-Type: application/json');

require '../config/database.php';
require '../includes/session.php';

if (!isset($_SESSION['participant_id'])) {

  echo json_encode([
    "success" => false,
    "message" => "Session tidak ditemukan."
  ]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {

  echo json_encode([
    "success" => false,
    "message" => "Data kosong."
  ]);
  exit;
}

if (!isset($_SESSION['numbers'])) {

  echo json_encode([
    "success" => false,
    "message" => "Data soal tidak ditemukan."
  ]);
  exit;
}

$numbers = $_SESSION['numbers'];

$answers = $data['answers'];

$correct = 0;
$wrong = 0;
$blank = 0;

$cols = count($numbers);
$rows = count($numbers[0]);

for ($c = 0; $c < $cols; $c++) {

  for ($r = 1; $r < $rows; $r++) {

    // Jawaban benar
    $trueAnswer = ($numbers[$c][$r - 1] + $numbers[$c][$r]) % 10;

    $userAnswer = trim($answers[$c][$r]);

    if ($userAnswer === "") {

      $blank++;
      continue;
    }

    if ((int)$userAnswer === $trueAnswer) {

      $correct++;
    } else {

      $wrong++;
    }
  }
}

$totalQuestions = ($rows - 1) * $cols;
$answered = $correct + $wrong;

$score = 0;

if ($answered > 0) {

  $score = round(($correct / $answered) * 100, 2);
}

$stmt = mysqli_prepare($conn, "
INSERT INTO test_results
(
participant_id,
total_questions,
answered,
correct,
wrong,
blank,
score
)
VALUES
(?,?,?,?,?,?,?)
");

if (!$stmt) {

  echo json_encode([
    "success" => false,
    "message" => mysqli_error($conn)
  ]);

  exit;
}

mysqli_stmt_bind_param(
  $stmt,
  "iiiiiid",
  $_SESSION['participant_id'],
  $totalQuestions,
  $answered,
  $correct,
  $wrong,
  $blank,
  $score
);

if (!mysqli_stmt_execute($stmt)) {

  echo json_encode([
    "success" => false,
    "message" => mysqli_stmt_error($stmt)
  ]);

  exit;
}

// OPTIONAL:
// update status peserta

mysqli_query(
  $conn,
  "UPDATE participants
    SET status='Selesai',
        finished_at = NOW()
    WHERE id=" . $_SESSION['participant_id']
);

echo json_encode([

  "success" => true,

  "correct" => $correct,

  "wrong" => $wrong,

  "blank" => $blank,

  "answered" => $answered,

  "total" => $totalQuestions,

  "score" => $score

]);
