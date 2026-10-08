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


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["action"]) && $_POST["action"] === "update") {

        $id = (int) ($_POST["id"] ?? 0);
        $name = $_POST["name"] ?? "";
        $type = $_POST["type"] ?? "";
        $location = $_POST["location"] ?? "";
        $status = $_POST["status"] ?? "Online";
        $last_update = $_POST["last_update"] ?? date("Y-m-d H:i:s");

        $sql = "UPDATE devices
                SET name = ?, type = ?, location = ?, status = ?, last_update = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssssi",
            $name,
            $type,
            $location,
            $status,
            $last_update,
            $id
        );

        if ($stmt->execute()) {

            echo json_encode([
                "success" => true,
                "message" => "Device updated successfully"
            ]);

        } else {

            echo json_encode([
                "success" => false,
                "message" => "Failed to update device"
            ]);
        }

        $stmt->close();

    } else {

        $name = $_POST["name"] ?? "";
        $type = $_POST["type"] ?? "";
        $location = $_POST["location"] ?? "";
        $status = $_POST["status"] ?? "Online";
        $last_update = $_POST["last_update"] ?? date("Y-m-d H:i:s");

        $building_id = 1;

        $sql = "INSERT INTO devices
                (building_id, name, type, location, status, last_update)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "isssss",
            $building_id,
            $name,
            $type,
            $location,
            $status,
            $last_update
        );

        if ($stmt->execute()) {

            echo json_encode([
                "success" => true,
                "message" => "Device added successfully",
                "id" => $stmt->insert_id
            ]);

        } else {

            echo json_encode([
                "success" => false,
                "message" => "Failed to add device"
            ]);
        }

        $stmt->close();
    }


} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {

    parse_str(
        file_get_contents("php://input"),
        $_DELETE
    );

    $id = (int) ($_DELETE["id"] ?? 0);

    $sql = "DELETE FROM devices WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Device deleted successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete device"
        ]);
    }

    $stmt->close();


} elseif (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    $sql = "SELECT *
            FROM devices
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $device = $result->fetch_assoc();

        echo json_encode($device);

    } else {

        echo json_encode([
            "message" => "Device not found"
        ]);
    }

    $stmt->close();


} else {

    $sql = "SELECT * FROM devices";

    $result = $conn->query($sql);

    $devices = [];

    while ($row = $result->fetch_assoc()) {

        $devices[] = $row;
    }

    echo json_encode($devices);
}

?>