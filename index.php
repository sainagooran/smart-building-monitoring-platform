<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit;
}


require_once "config/database.php";


$userId = (int) $_SESSION["user_id"];

$userName = $_SESSION["user_name"];

$userEmail = $_SESSION["user_email"];

$userInitial = strtoupper(substr($userName, 0, 1));

$profileImage = null;


/* Get profile image */

$sql = "SELECT profile_image FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $userId
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    $profileImage = $user["profile_image"];
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Building Monitoring Platform</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>

    <div class="app">

        <!-- Sidebar -->
        <aside class="sidebar">

           <div class="logo">

    <i data-lucide="building-2" class="building-logo"></i>

    <div class="logo-text">
        <h2>SMART BUILDING</h2>

        <span>Monitoring Platform</span>
    </div>

</div>

            <nav class="sidebar-nav">

                <a href="index.php" class="nav-item active">
                    <span class="nav-icon">▣</span>
                    Dashboard
                </a>

                <a href="pages/devices.php" class="nav-item">
                    <span class="nav-icon">◈</span>
                    Devices
                </a>

                <a href="pages/energy.php" class="nav-item">
                    <span class="nav-icon">◉</span>
                    Energy
                </a>

                <a href="pages/alerts.php" class="nav-item">
                    <span class="nav-icon">!</span>
                    Alerts
                </a>

                <a href="pages/settings.php" class="nav-item">
                    <span class="nav-icon">⚙</span>
                    Settings
                </a>

                <a href="pages/profile.php" class="nav-item">
                    <span class="nav-icon">●</span>
                    Profile
                </a>

            </nav>

            <div class="sidebar-flower">
                <img src="assets/images/flower.jpg" alt="Flower">
            </div>

            <div class="user-profile">

                <div class="user-avatar">

                    <?php if (!empty($profileImage)): ?>

                        <img
                            src="<?php echo htmlspecialchars($profileImage); ?>"
                            alt="Profile"
                        >

                    <?php else: ?>

                        <?php echo htmlspecialchars($userInitial); ?>

                    <?php endif; ?>

                </div>

                <div class="user-info">

                    <strong>
                        <?php echo htmlspecialchars($userName); ?>
                    </strong>

                    <span>Administrator</span>

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

                            <?php if (!empty($profileImage)): ?>

                                <img
                                    src="<?php echo htmlspecialchars($profileImage); ?>"
                                    alt="Profile"
                                >

                            <?php else: ?>

                                <?php echo htmlspecialchars($userInitial); ?>

                            <?php endif; ?>

                        </div>

                        <span>
                            <?php echo htmlspecialchars($userName); ?>
                        </span>

                    </div>

                </div>

            </header>


            <!-- Dashboard Content -->
            <section class="dashboard">

                <div class="building-image">

                    <img
                        src="assets/images/building.jpg"
                        alt="Building"
                    >

                </div>

                <!-- Page Header -->
                <div class="page-header">

                    <div>

                        <h1>
                            Welcome back,
                            <?php echo htmlspecialchars($userName); ?>
                        </h1>

                        <p>
                            Here's what's happening in your building today.
                        </p>

                    </div>

                    <div class="building-status">

                        <strong>Building Status</strong>

                        <span>
                            All Systems Operational
                        </span>

                    </div>

                </div>


                <!-- KPI Cards -->
                <section class="stats-grid">

                    <div class="stat-card">

                        <span>
                            Energy Consumption
                        </span>

                        <strong id="energy-consumption">
                            38.4 kWh
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Temperature
                        </span>

                        <strong id="temperature-value">
                            22.8 °C
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Active Devices
                        </span>

                        <strong id="active-devices">
                            14 / 16
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Alerts
                        </span>

                        <strong id="alerts-count">
                            3
                        </strong>

                    </div>

                </section>


                <!-- Charts -->
                <section class="charts-grid">

                    <div class="chart-card">

                        <h2>
                            Energy Consumption
                        </h2>

                        <div class="chart-placeholder">
                            Chart
                        </div>

                    </div>


                    <div class="chart-card">

                        <h2>
                            Temperature Trend
                        </h2>

                        <div class="chart-placeholder">
                            Chart
                        </div>

                    </div>

                </section>


                <!-- Building Overview -->
                <section class="building-overview">

                    <div class="overview-header">

                        <h2>Building Overview</h2>

                        <span>Main Building</span>

                    </div>

                    <div class="overview-grid">

                        <div class="overview-item">

                            <span>Total Area</span>

                            <strong>12,500 m²</strong>

                        </div>

                        <div class="overview-item">

                            <span>Floors</span>

                            <strong>6</strong>

                        </div>

                        <div class="overview-item">

                            <span>Total Devices</span>

                            <strong>16</strong>

                        </div>

                        <div class="overview-item">

                            <span>Active Devices</span>

                            <strong>14</strong>

                        </div>

                    </div>

                </section>


                <!-- Bottom Section -->
                <section class="bottom-grid">

                    <!-- Device Overview -->
                    <div class="device-card">

                        <h2>
                            Device Overview
                        </h2>

                        <div class="device-table-wrapper">

                            <table class="device-table">

                                <thead>

                                    <tr>

                                        <th>Device</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Last Update</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td>
                                            <strong>HVAC-01</strong>
                                        </td>

                                        <td>HVAC</td>

                                        <td>Floor 1</td>

                                        <td>

                                            <span class="status online">
                                                Online
                                            </span>

                                        </td>

                                        <td>2 min ago</td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>LIGHT-04</strong>
                                        </td>

                                        <td>Lighting</td>

                                        <td>Floor 2</td>

                                        <td>

                                            <span class="status online">
                                                Online
                                            </span>

                                        </td>

                                        <td>5 min ago</td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>TEMP-07</strong>
                                        </td>

                                        <td>Temperature</td>

                                        <td>Floor 3</td>

                                        <td>

                                            <span class="status warning">
                                                Warning
                                            </span>

                                        </td>

                                        <td>8 min ago</td>

                                    </tr>


                                    <tr>

                                        <td>
                                            <strong>ENERGY-02</strong>
                                        </td>

                                        <td>Energy Meter</td>

                                        <td>Floor 1</td>

                                        <td>

                                            <span class="status online">
                                                Online
                                            </span>

                                        </td>

                                        <td>1 min ago</td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    <!-- Recent Alerts -->
                    <div class="alerts-card">

                        <h2>
                            Recent Alerts
                        </h2>

                        <div class="alerts-list">

                            <div class="alert-item">

                                <div class="alert-icon critical">
                                    !
                                </div>

                                <div class="alert-content">

                                    <strong>High Temperature</strong>

                                    <span>
                                        Temperature sensor exceeded normal range
                                    </span>

                                    <small>
                                        TEMP-07 · 8 min ago
                                    </small>

                                </div>

                            </div>


                            <div class="alert-item">

                                <div class="alert-icon warning">
                                    !
                                </div>

                                <div class="alert-content">

                                    <strong>Device Offline</strong>

                                    <span>
                                        Lighting controller stopped responding
                                    </span>

                                    <small>
                                        LIGHT-09 · 24 min ago
                                    </small>

                                </div>

                            </div>


                            <div class="alert-item">

                                <div class="alert-icon info">
                                    i
                                </div>

                                <div class="alert-content">

                                    <strong>Energy Usage Increased</strong>

                                    <span>
                                        Energy consumption is higher than usual
                                    </span>

                                    <small>
                                        ENERGY-02 · 41 min ago
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </section>

        </main>

    </div>


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Project JavaScript -->
    <script src="assets/js/dashboard.js"></script>

    <script>
        lucide.createIcons();
    </script>

    <script>

        function updateDateTime() {

            var now = new Date();

            var hours = String(now.getHours()).padStart(2, "0");
            var minutes = String(now.getMinutes()).padStart(2, "0");

            var date = now.toLocaleDateString("en-US", {
                weekday: "long",
                month: "long",
                day: "numeric"
            });

            document.getElementById("current-time").textContent =
                hours + ":" + minutes;

            document.getElementById("current-date").textContent =
                date;
        }


        updateDateTime();

        setInterval(updateDateTime, 1000);

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