<?php
require '../config/database.php';

$query = mysqli_query($conn, "
    SELECT tr.id, p.fullname, tr.created_at, tr.is_paid
    FROM test_results tr
    JOIN participants p ON p.id = tr.participant_id
    ORDER BY tr.id DESC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);
