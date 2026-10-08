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
        Alerts | Smart Building
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
                        ⌂
                    </span>

                    Dashboard

                </a>


                <a
                    href="devices.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ▣
                    </span>

                    Devices

                </a>


                <a
                    href="energy.php"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ◈
                    </span>

                    Energy

                </a>


                <a
                    href="alerts.php"
                    class="nav-item active"
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


            <!-- Alerts Content -->

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
                            Alerts
                        </h1>

                        <p>
                            Review and manage building system alerts.
                        </p>

                    </div>


                </div>


                <div class="stats-grid">


                    <div class="stat-card">

                        <span>
                            Total Alerts
                        </span>

                        <strong id="total-alerts">
                            3
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Critical
                        </span>

                        <strong id="critical-alerts">
                            1
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Warning
                        </span>

                        <strong id="warning-alerts">
                            1
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Information
                        </span>

                        <strong id="information-alerts">
                            1
                        </strong>

                    </div>


                </div>


                <div class="device-controls alert-controls">


                    <div class="device-search">

                        <input
                            type="text"
                            id="alert-search"
                            placeholder="Search alerts..."
                        >

                    </div>


                    <div class="device-filter">

                        <select id="alert-filter">

                            <option value="All">
                                All Alerts
                            </option>

                            <option value="Critical">
                                Critical
                            </option>

                            <option value="Warning">
                                Warning
                            </option>

                            <option value="Information">
                                Information
                            </option>

                        </select>

                    </div>


                </div>


                <div class="device-management-card">


                    <div class="device-management-header">

                        <h2>
                            Recent Alerts
                        </h2>

                        <p>
                            Latest events reported by the building monitoring system.
                        </p>

                    </div>


                    <div class="alerts-list alerts-page-list">


                        <div
                            class="alert-item"
                            data-type="Critical"
                        >

                            <div class="alert-icon critical">
                                !
                            </div>

                            <div class="alert-content">

                                <strong>
                                    High Energy Consumption
                                </strong>

                                <span>
                                    Energy usage exceeded the expected level in Floor 2.
                                </span>

                                <small>
                                    10 minutes ago
                                </small>

                            </div>

                        </div>


                        <div
                            class="alert-item"
                            data-type="Warning"
                        >

                            <div class="alert-icon warning">
                                !
                            </div>

                            <div class="alert-content">

                                <strong>
                                    Temperature Warning
                                </strong>

                                <span>
                                    Temperature sensor TEMP-07 reported an unusual value.
                                </span>

                                <small>
                                    24 minutes ago
                                </small>

                            </div>

                        </div>


                        <div
                            class="alert-item"
                            data-type="Information"
                        >

                            <div class="alert-icon info">
                                i
                            </div>

                            <div class="alert-content">

                                <strong>
                                    Device Connected
                                </strong>

                                <span>
                                    LIGHT-09 has successfully connected to the system.
                                </span>

                                <small>
                                    38 minutes ago
                                </small>

                            </div>

                        </div>


                    </div>


                </div>


            </section>


        </main>


    </div>


    <script src="../assets/js/alerts.js"></script>


    <script>

    lucide.createIcons();


    function updateDateTime() {

        var now =
            new Date();


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