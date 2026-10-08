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
        Energy | Smart Building
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
                    class="nav-item active"
                >

                    <span class="nav-icon">
                        ◈
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


            <!-- Energy Content -->

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
                            Energy
                        </h1>

                        <p>
                            Monitor building energy consumption and usage trends.
                        </p>

                    </div>


                </div>


                <!-- Energy Summary -->

                <div class="stats-grid">


                    <div class="stat-card">

                        <span>
                            Today's Consumption
                        </span>

                        <strong>
                            38.4 kWh
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Peak Demand
                        </span>

                        <strong>
                            6.8 kW
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Average Usage
                        </span>

                        <strong>
                            4.2 kWh
                        </strong>

                    </div>


                    <div class="stat-card">

                        <span>
                            Estimated Cost
                        </span>

                        <strong>
                            $7.82
                        </strong>

                    </div>


                </div>


                <!-- Energy Chart -->

                <div class="chart-card">


                    <h2>
                        Energy Consumption
                    </h2>


                    <div class="chart-placeholder">

                        <canvas id="energyChart"></canvas>

                    </div>


                </div>


            </section>


        </main>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../assets/js/energy.js"></script>


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