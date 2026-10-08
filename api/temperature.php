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


/* Get temperature data */

$sql = "SELECT
            temperature,
            recorded_at
        FROM temperature_data
        WHERE building_id = 1
        ORDER BY recorded_at ASC";


$result = $conn->query($sql);

$temperatureData = [];


while ($row = $result->fetch_assoc()) {

    $temperatureData[] = $row;
}


echo json_encode([
    "success" => true,
    "data" => $temperatureData
]);

?>