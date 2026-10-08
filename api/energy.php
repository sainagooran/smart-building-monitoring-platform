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


/* Get energy data */

$sql = "SELECT *
        FROM energy_data
        ORDER BY recorded_at DESC";

$result = $conn->query($sql);

$energyData = [];

while ($row = $result->fetch_assoc()) {

    $energyData[] = $row;
}

echo json_encode($energyData);

?>