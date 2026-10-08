<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");

    exit;
}

require_once "../config/database.php";


$userId = (int) $_SESSION["user_id"];

$userName = $_SESSION["user_name"];

$userInitial = strtoupper(
    substr($userName, 0, 1)
);

$profileImage = null;


$sql = "SELECT profile_image
        FROM users
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $userId
);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows > 0) {

    $userData = $result->fetch_assoc();

    $profileImage = $userData["profile_image"];

}


$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Devices | Smart Building Monitoring Platform
    </title>

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>

    <div class="app">


        <!-- Sidebar -->

        <aside class="sidebar">


            <div class="logo">

                <i
                    data-lucide="building-2"
                    class="building-logo"
                ></i>

                <h2>
                    SMART BUILDING
                </h2>

                <span>
                    Monitoring Platform
                </span>

            </div>


            <nav class="sidebar-nav">


                <a
                    href="../index.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ▣
                    </span>

                    Dashboard

                </a>


                <a
                    href="devices.php"
                    class="nav-item active"
                >

                    <span class="nav-icon">
                        ◈
                    </span>

                    Devices

                </a>


                <a
                    href="energy.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ◉
                    </span>

                    Energy

                </a>


                <a
                    href="alerts.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        !
                    </span>

                    Alerts

                </a>


                <a
                    href="settings.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ⚙
                    </span>

                    Settings

                </a>


                <a
                    href="profile.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ●
                    </span>

                    Profile

                </a>


            </nav>


            <div class="sidebar-flower">

                <img
                    src="../assets/images/flower.jpg"
                    alt="Flower"
                >

            </div>


            <div class="user-profile">


                <div class="user-avatar">

                    <?php if (!empty($profileImage)) { ?>

                        <img
                            src="../<?php echo htmlspecialchars($profileImage); ?>"
                            alt="Profile Picture"
                        >

                    <?php } else { ?>

                        <?php
                        echo htmlspecialchars($userInitial);
                        ?>

                    <?php } ?>

                </div>


                <div class="user-info">

                    <strong>

                        <?php
                        echo htmlspecialchars($userName);
                        ?>

                    </strong>

                    <span>
                        Administrator
                    </span>

                </div>


            </div>


        </aside>


        <!-- Main Content -->

        <main class="main-content">


            <!-- Top Bar -->

            <header class="topbar">


                <div class="search-box">

                    <i data-lucide="search"></i>

                    <input
                        type="text"
                        placeholder="Search devices, rooms, or keywords..."
                    >

                </div>


                <div class="topbar-user">


                    <div class="current-time">

                        <strong id="current-time">
                            00:00
                        </strong>

                        <span id="current-date">
                            Loading...
                        </span>

                    </div>


                    <div class="topbar-profile">


                        <div class="user-avatar">

                            <?php if (!empty($profileImage)) { ?>

                                <img
                                    src="../<?php echo htmlspecialchars($profileImage); ?>"
                                    alt="Profile Picture"
                                >

                            <?php } else { ?>

                                <?php
                                echo htmlspecialchars($userInitial);
                                ?>

                            <?php } ?>

                        </div>


                        <span>

                            <?php
                            echo htmlspecialchars($userName);
                            ?>

                        </span>


                    </div>


                </div>


            </header>


            <!-- Devices Page -->

            <section class="dashboard">


                <div class="building-image">

                    <img
                        src="../assets/images/building.jpg"
                        alt="Building"
                    >

                </div>


                <div class="page-header">


                    <div>

                        <h1>
                            Devices
                        </h1>

                        <p>
                            Monitor and manage connected building devices.
                        </p>

                    </div>


                    <div class="building-status">

                        <strong>
                            Total Devices
                        </strong>

                        <span>
                            16 Devices
                        </span>

                    </div>


                </div>


                <!-- Device Management -->

                <section class="device-management">


                    <!-- Device Summary -->

                    <div class="device-summary">


                        <div class="device-summary-card">

                            <span>
                                Total Devices
                            </span>

                            <strong id="total-devices">
                                16
                            </strong>

                        </div>


                        <div class="device-summary-card">

                            <span>
                                Online
                            </span>

                            <strong id="online-devices">
                                14
                            </strong>

                        </div>


                        <div class="device-summary-card">

                            <span>
                                Offline
                            </span>

                            <strong id="offline-devices">
                                1
                            </strong>

                        </div>


                        <div class="device-summary-card">

                            <span>
                                Warning
                            </span>

                            <strong id="warning-devices">
                                1
                            </strong>

                        </div>


                    </div>


                    <!-- Device Controls -->

                    <div class="device-controls">


                        <div class="device-search">

                            <input
                                type="text"
                                placeholder="Search devices..."
                            >

                        </div>


                        <div class="device-filter">

                            <select>

                                <option>
                                    All Devices
                                </option>

                                <option>
                                    Online
                                </option>

                                <option>
                                    Offline
                                </option>

                                <option>
                                    Warning
                                </option>

                            </select>

                        </div>


                        <button class="add-device-btn">
                            + Add Device
                        </button>


                    </div>


                    <!-- Add Device Form -->

                    <div class="add-device-form">


                        <div class="form-header">

                            <div>

                                <h2 class="form-title">
                                    Add New Device
                                </h2>

                                <p>
                                    Add a new device to the building monitoring system.
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            <div class="form-group">

                                <label for="device-name">
                                    Device Name
                                </label>

                                <input
                                    type="text"
                                    id="device-name"
                                    placeholder="e.g. HVAC-02"
                                >

                            </div>


                            <div class="form-group">

                                <label for="device-type">
                                    Device Type
                                </label>

                                <select id="device-type">

                                    <option value="">
                                        Select device type
                                    </option>

                                    <option value="HVAC">
                                        HVAC
                                    </option>

                                    <option value="Lighting">
                                        Lighting
                                    </option>

                                    <option value="Temperature">
                                        Temperature
                                    </option>

                                    <option value="Energy Meter">
                                        Energy Meter
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label for="device-location">
                                    Location
                                </label>

                                <select id="device-location">

                                    <option value="">
                                        Select location
                                    </option>

                                    <option value="Floor 1">
                                        Floor 1
                                    </option>

                                    <option value="Floor 2">
                                        Floor 2
                                    </option>

                                    <option value="Floor 3">
                                        Floor 3
                                    </option>

                                    <option value="Floor 4">
                                        Floor 4
                                    </option>

                                    <option value="Floor 5">
                                        Floor 5
                                    </option>

                                    <option value="Floor 6">
                                        Floor 6
                                    </option>

                                </select>

                            </div>


                            <div class="form-group">

                                <label for="device-status">
                                    Status
                                </label>

                                <select id="device-status">

                                    <option value="Online">
                                        Online
                                    </option>

                                    <option value="Offline">
                                        Offline
                                    </option>

                                    <option value="Warning">
                                        Warning
                                    </option>

                                </select>

                            </div>


                        </div>


                        <div class="form-actions">

                            <button
                                type="button"
                                class="cancel-device-btn"
                            >
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="save-device-btn"
                            >
                                Add Device
                            </button>

                        </div>


                    </div>


                    <!-- Device Table -->

                    <div class="device-management-card">


                        <div class="device-management-header">

                            <div>

                                <h2>
                                    Connected Devices
                                </h2>

                                <p>
                                    Monitor the current status of building devices.
                                </p>

                            </div>

                        </div>


                        <div class="device-table-wrapper">


                            <table class="device-table">


                                <thead>

                                    <tr>

                                        <th>
                                            Device
                                        </th>

                                        <th>
                                            Type
                                        </th>

                                        <th>
                                            Location
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Last Update
                                        </th>

                                        <th>
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    <tr>

                                        <td>
                                            <strong>
                                                HVAC-01
                                            </strong>
                                        </td>

                                        <td>
                                            HVAC
                                        </td>

                                        <td>
                                            Floor 1
                                        </td>

                                        <td>
                                            <span class="status online">
                                                Online
                                            </span>
                                        </td>

                                        <td>
                                            2 min ago
                                        </td>

                                        <td>

                                            <button
                                                class="view-device-btn"
                                                type="button"
                                            >
                                                View Details
                                            </button>

                                            <button
                                                class="edit-device-btn"
                                                type="button"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                class="delete-device-btn"
                                                type="button"
                                            >
                                                Delete
                                            </button>

                                        </td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>
                                                LIGHT-04
                                            </strong>
                                        </td>

                                        <td>
                                            Lighting
                                        </td>

                                        <td>
                                            Floor 2
                                        </td>

                                        <td>
                                            <span class="status online">
                                                Online
                                            </span>
                                        </td>

                                        <td>
                                            5 min ago
                                        </td>

                                        <td>

                                            <button
                                                class="view-device-btn"
                                                type="button"
                                            >
                                                View Details
                                            </button>

                                            <button
                                                class="edit-device-btn"
                                                type="button"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                class="delete-device-btn"
                                                type="button"
                                            >
                                                Delete
                                            </button>

                                        </td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>
                                                TEMP-07
                                            </strong>
                                        </td>

                                        <td>
                                            Temperature
                                        </td>

                                        <td>
                                            Floor 3
                                        </td>

                                        <td>
                                            <span class="status warning">
                                                Warning
                                            </span>
                                        </td>

                                        <td>
                                            8 min ago
                                        </td>

                                        <td>

                                            <button
                                                class="view-device-btn"
                                                type="button"
                                            >
                                                View Details
                                            </button>

                                            <button
                                                class="edit-device-btn"
                                                type="button"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                class="delete-device-btn"
                                                type="button"
                                            >
                                                Delete
                                            </button>

                                        </td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>
                                                ENERGY-02
                                            </strong>
                                        </td>

                                        <td>
                                            Energy Meter
                                        </td>

                                        <td>
                                            Floor 1
                                        </td>

                                        <td>
                                            <span class="status online">
                                                Online
                                            </span>
                                        </td>

                                        <td>
                                            1 min ago
                                        </td>

                                        <td>

                                            <button
                                                class="view-device-btn"
                                                type="button"
                                            >
                                                View Details
                                            </button>

                                            <button
                                                class="edit-device-btn"
                                                type="button"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                class="delete-device-btn"
                                                type="button"
                                            >
                                                Delete
                                            </button>

                                        </td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>
                                                LIGHT-09
                                            </strong>
                                        </td>

                                        <td>
                                            Lighting
                                        </td>

                                        <td>
                                            Floor 4
                                        </td>

                                        <td>
                                            <span class="status offline">
                                                Offline
                                            </span>
                                        </td>

                                        <td>
                                            24 min ago
                                        </td>

                                        <td>

                                            <button
                                                class="view-device-btn"
                                                type="button"
                                            >
                                                View Details
                                            </button>

                                            <button
                                                class="edit-device-btn"
                                                type="button"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                class="delete-device-btn"
                                                type="button"
                                            >
                                                Delete
                                            </button>

                                        </td>

                                    </tr>


                                </tbody>


                            </table>


                        </div>


                    </div>


                </section>


            </section>


        </main>


    </div>


    <!-- Device Details Modal -->

    <div
        class="device-modal"
        id="device-modal"
    >


        <div class="device-modal-content">


            <div class="device-modal-header">


                <div>

                    <h2>
                        Device Details
                    </h2>

                    <p>
                        Detailed information about this device.
                    </p>

                </div>


                <button
                    type="button"
                    class="close-device-modal"
                >
                    ×
                </button>


            </div>


            <div class="device-details">


                <div class="device-detail-item">

                    <span>
                        Device Name
                    </span>

                    <strong id="detail-name">
                        -
                    </strong>

                </div>


                <div class="device-detail-item">

                    <span>
                        Device Type
                    </span>

                    <strong id="detail-type">
                        -
                    </strong>

                </div>


                <div class="device-detail-item">

                    <span>
                        Location
                    </span>

                    <strong id="detail-location">
                        -
                    </strong>

                </div>


                <div class="device-detail-item">

                    <span>
                        Status
                    </span>

                    <strong id="detail-status">
                        -
                    </strong>

                </div>


                <div class="device-detail-item">

                    <span>
                        Last Update
                    </span>

                    <strong id="detail-update">
                        -
                    </strong>

                </div>


            </div>


        </div>


    </div>


    <script src="../assets/js/devices.js"></script>


    <script>

    lucide.createIcons();


    function updateDateTime() {

        var now = new Date();

        var hours =
            String(
                now.getHours()
            ).padStart(
                2,
                "0"
            );

        var minutes =
            String(
                now.getMinutes()
            ).padStart(
                2,
                "0"
            );

        var date =
            now.toLocaleDateString(
                "en-US",
                {
                    weekday: "long",
                    month: "long",
                    day: "numeric"
                }
            );

        document.getElementById(
            "current-time"
        ).textContent =
            hours + ":" + minutes;

        document.getElementById(
            "current-date"
        ).textContent =
            date;

    }


    updateDateTime();


    setInterval(
        updateDateTime,
        1000
    );

    </script>
    <script>

    var searchInput = document.querySelector(".search-box input");

    searchInput.addEventListener("input", function () {

        var searchText = this.value.toLowerCase().trim();

        var searchableItems = document.querySelectorAll(
            ".stat-card, .chart-card, .building-overview, .device-card, .alerts-card"
        );

        searchableItems.forEach(function (item) {

            var itemText = item.textContent.toLowerCase();

            if (searchText === "" || itemText.includes(searchText)) {

                item.style.display = "";

            } else {

                item.style.display = "none";
            }

        });

    });

</script>


</body>

</html>