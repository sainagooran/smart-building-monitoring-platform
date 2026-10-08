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


/* Update building settings */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $timezone = trim($_POST["timezone"] ?? "");


    if ($name === "" || $location === "" || $timezone === "") {

        echo json_encode([
            "success" => false,
            "message" => "All building fields are required"
        ]);

        exit;
    }


    $sql = "UPDATE buildings
            SET name = ?, location = ?, timezone = ?
            WHERE id = 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sss",
        $name,
        $location,
        $timezone
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Settings updated successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to update settings"
        ]);
    }


    $stmt->close();

    exit;
}


/* Get building settings */

$sql = "SELECT id, name, location, timezone
        FROM buildings
        WHERE id = 1";

$result = $conn->query($sql);


if ($result && $result->num_rows > 0) {

    $building = $result->fetch_assoc();

    echo json_encode([
        "success" => true,
        "data" => $building
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Building not found"
    ]);
}

?>