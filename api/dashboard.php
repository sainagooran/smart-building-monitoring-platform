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


/* Get device statistics */

$deviceSql = "SELECT
                COUNT(*) AS total_devices,
                SUM(status = 'online') AS online_devices,
                SUM(status = 'warning') AS warning_devices,
                SUM(status = 'offline') AS offline_devices
              FROM devices
              WHERE building_id = 1";

$deviceResult = $conn->query($deviceSql);


/* Get latest energy data */

$energySql = "SELECT
                energy_consumption,
                power_demand
              FROM energy_data
              WHERE building_id = 1
              ORDER BY recorded_at DESC
              LIMIT 1";

$energyResult = $conn->query($energySql);


/* Get alert statistics */

$alertSql = "SELECT
                COUNT(*) AS total_alerts,
                SUM(type = 'Critical') AS critical_alerts,
                SUM(type = 'Warning') AS warning_alerts,
                SUM(type = 'Information') AS information_alerts
             FROM alerts
             WHERE building_id = 1
             AND is_resolved = 0";

$alertResult = $conn->query($alertSql);


if ($deviceResult && $energyResult && $alertResult) {

    $devices = $deviceResult->fetch_assoc();

    $energy = $energyResult->fetch_assoc();

    $alerts = $alertResult->fetch_assoc();


    echo json_encode([
        "success" => true,

        "data" => [
            "devices" => $devices,
            "energy" => $energy,
            "alerts" => $alerts
        ]
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Failed to load dashboard data"
    ]);

}

?>