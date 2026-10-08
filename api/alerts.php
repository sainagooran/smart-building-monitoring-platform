<?php

session_start();

require_once "../config/database.php";

header("Content-Type: application/json");


/* Check login */

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "User is not logged in"
    ]);

    exit;
}


/* Get alerts */

$sql = "SELECT *
        FROM alerts
        ORDER BY created_at DESC";

$result = $conn->query($sql);

$alerts = [];

while ($row = $result->fetch_assoc()) {

    $alerts[] = $row;
}

echo json_encode($alerts);

?>