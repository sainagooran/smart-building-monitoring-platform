<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");

    exit;
}


require_once "../config/database.php";


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

    <title>Settings | Smart Building</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>

    <div class="app">

        <!-- SIDEBAR -->

        <aside class="sidebar">

            <div class="logo">

                <i data-lucide="building-2" class="building-logo"></i>

                <h2>SMART BUILDING</h2>

                <span>Monitoring Platform</span>

            </div>


            <nav class="sidebar-nav">

                <a href="../index.php" class="nav-item">

                    <span class="nav-icon">▣</span>

                    Dashboard

                </a>


                <a href="devices.php" class="nav-item">

                    <span class="nav-icon">◈</span>

                    Devices

                </a>


                <a href="energy.php" class="nav-item">

                    <span class="nav-icon">◉</span>

                    Energy

                </a>


                <a href="alerts.php" class="nav-item">

                    <span class="nav-icon">!</span>

                    Alerts

                </a>


                <a href="settings.php" class="nav-item active">

                    <span class="nav-icon">⚙</span>

                    Settings

                </a>


                <a href="profile.php" class="nav-item">

                    <span class="nav-icon">●</span>

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

                    <?php if (!empty($profileImage)): ?>

                        <img
                            src="../<?php echo htmlspecialchars($profileImage); ?>"
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


        <!-- MAIN CONTENT -->

        <main class="main-content">

            <header
                class="topbar"
                style="justify-content: flex-end;"
            >

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
                                    src="../<?php echo htmlspecialchars($profileImage); ?>"
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


            <!-- SETTINGS CONTENT -->

            <section class="dashboard">

                <div class="page-header">

                    <div>

                        <h1>Settings</h1>

                        <p>
                            Manage building monitoring system preferences.
                        </p>

                    </div>

                </div>


                <div class="settings-grid">


                    <!-- General Settings -->

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <h2>
                                General Settings
                            </h2>

                            <p>
                                Basic information about the building.
                            </p>

                        </div>


                        <div class="settings-form">

                            <div class="settings-group">

                                <label for="building-name">
                                    Building Name
                                </label>

                                <input
                                    type="text"
                                    id="building-name"
                                    value="Smart Building"
                                >

                            </div>


                            <div class="settings-group">

                                <label for="building-location">
                                    Location
                                </label>

                                <input
                                    type="text"
                                    id="building-location"
                                    value="Main Building"
                                >

                            </div>


                            <div class="settings-group">

                                <label for="timezone">
                                    Timezone
                                </label>

                                <select id="timezone">

                                    <option>
                                        UTC +03:30
                                    </option>

                                    <option>
                                        UTC +03:00
                                    </option>

                                    <option>
                                        UTC +02:00
                                    </option>

                                    <option>
                                        UTC +01:00
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- Notification Settings -->

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <h2>
                                Notifications
                            </h2>

                            <p>
                                Control how system alerts are handled.
                            </p>

                        </div>


                        <div class="settings-options">

                            <div class="settings-option">

                                <div>

                                    <strong>
                                        Critical Alerts
                                    </strong>

                                    <span>
                                        Receive notifications for critical events.
                                    </span>

                                </div>


                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>


                            <div class="settings-option">

                                <div>

                                    <strong>
                                        Warning Alerts
                                    </strong>

                                    <span>
                                        Receive notifications for warning events.
                                    </span>

                                </div>


                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>


                            <div class="settings-option">

                                <div>

                                    <strong>
                                        Device Status
                                    </strong>

                                    <span>
                                        Notify when a device goes offline.
                                    </span>

                                </div>


                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>

                        </div>

                    </div>


                    <!-- System Settings -->

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <h2>
                                System Preferences
                            </h2>

                            <p>
                                Configure general dashboard behavior.
                            </p>

                        </div>


                        <div class="settings-options">

                            <div class="settings-option">

                                <div>

                                    <strong>
                                        Automatic Refresh
                                    </strong>

                                    <span>
                                        Refresh monitoring data automatically.
                                    </span>

                                </div>


                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>


                            <div class="settings-option">

                                <div>

                                    <strong>
                                        Compact Dashboard
                                    </strong>

                                    <span>
                                        Use a more compact dashboard layout.
                                    </span>

                                </div>


                                <label class="switch">

                                    <input
                                        type="checkbox"
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>

                        </div>

                    </div>


                    <!-- Save -->

                    <div class="settings-actions">

                        <button
                            type="button"
                            class="save-settings-btn"
                        >
                            Save Changes
                        </button>

                    </div>


                </div>

            </section>

        </main>

    </div>


    <script src="../assets/js/settings.js"></script>


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

</body>

</html>