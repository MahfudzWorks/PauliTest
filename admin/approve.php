<?php
require '../config/database.php';

$id = (int) $_GET['id'];

mysqli_query($conn, "
    UPDATE test_results 
    SET is_paid = 1 
    WHERE id = $id
");

echo json_encode(["success" => true]);
