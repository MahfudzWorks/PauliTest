<?php

require '../config/database.php';
session_start();

$id = (int) $_SESSION['participant_id'];

$query = mysqli_query($conn, "
SELECT is_paid, correct, wrong, blank, score
FROM test_results
WHERE participant_id = $id
ORDER BY id DESC
LIMIT 1
");

$data = mysqli_fetch_assoc($query);

echo json_encode($data);
