<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.php");

    exit;
}


require_once "../config/database.php";


$userId = (int) $_SESSION["user_id"];

$userName = $_SESSION["user_name"];

$userEmail = $_SESSION["user_email"];

$userInitial = strtoupper(
    substr($userName, 0, 1)
);

$profileImage = null;


/* Get profile image */

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
        Profile | Smart Building
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
                    class="nav-item active"
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

                    <?php if (!empty($profileImage)): ?>

                        <img
                            src="../<?php echo htmlspecialchars($profileImage); ?>"
                            alt="Profile Picture"
                        >

                    <?php else: ?>

                        <?php echo htmlspecialchars($userInitial); ?>

                    <?php endif; ?>

                </div>


                <div class="user-info">

                    <strong>
                        <?php echo htmlspecialchars($userName); ?>
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
                                    alt="Profile Picture"
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


            <!-- Profile Content -->

            <section class="dashboard">

                <div class="page-header">

                    <div>

                        <h1>
                            Profile
                        </h1>

                        <p>
                            Manage your personal account information.
                        </p>

                    </div>

                </div>


                <div class="profile-card">


                    <!-- Profile Photo -->

                    <div class="profile-header">

                        <div class="profile-avatar-large">

                            <?php if (!empty($profileImage)): ?>

                                <img
                                    src="../<?php echo htmlspecialchars($profileImage); ?>"
                                    alt="Profile Picture"
                                >

                            <?php else: ?>

                                <?php echo htmlspecialchars($userInitial); ?>

                            <?php endif; ?>

                        </div>


                        <div class="profile-photo-info">

                            <strong>
                                Profile Picture
                            </strong>

                            <p>
                                Add a profile picture to personalize your account.
                            </p>


                            <label
                                for="profile-image"
                                class="profile-photo-btn"
                            >
                                Upload Photo
                            </label>


                            <input
                                type="file"
                                id="profile-image"
                                accept="image/jpeg,image/png,image/webp"
                                style="display: none;"
                            >

                        </div>

                    </div>


                    <!-- Profile Form -->

                    <div class="profile-form">


                        <div class="profile-form-group">

                            <label for="profile-name">
                                Full Name
                            </label>

                            <input
                                type="text"
                                id="profile-name"
                                value="<?php echo htmlspecialchars($userName); ?>"
                            >

                        </div>


                        <div class="profile-form-group">

                            <label for="profile-email">
                                Email
                            </label>

                            <input
                                type="email"
                                id="profile-email"
                                value="<?php echo htmlspecialchars($userEmail); ?>"
                            >

                        </div>


                        <div class="profile-form-group">

                            <label for="profile-password">
                                Password
                            </label>


                            <div class="password-field">

                                <input
                                    type="password"
                                    id="profile-password"
                                    placeholder="Enter new password"
                                >


                                <button
                                    type="button"
                                    class="password-toggle"
                                    id="profile-password-toggle"
                                    aria-label="Show password"
                                >

                                    <i data-lucide="eye"></i>

                                </button>

                            </div>

                        </div>


                        <div class="profile-form-group">

                            <label for="profile-phone">
                                Phone
                            </label>

                            <input
                                type="text"
                                id="profile-phone"
                                placeholder="Optional"
                            >

                        </div>


                        <div class="profile-form-group">

                            <label for="profile-address">
                                Home Address
                            </label>

                            <input
                                type="text"
                                id="profile-address"
                                placeholder="Optional"
                            >

                        </div>

                    </div>


                    <!-- Save -->

                    <div class="profile-actions">

                        <button
                            type="button"
                            class="save-settings-btn"
                        >
                            Save Changes
                        </button>

                    </div>


                    <!-- Account -->

                    <div class="profile-account">

                        <div class="profile-account-info">

                            <h2>
                                Account
                            </h2>

                            <p>
                                Sign out from your Smart Building account.
                            </p>

                        </div>


                        <a
                            href="../logout.php"
                            class="logout-btn"
                        >
                            Log Out
                        </a>

                    </div>


                </div>

            </section>

        </main>

    </div>


    <script>

    document.addEventListener("DOMContentLoaded", function() {

        lucide.createIcons();


        var nameInput =
            document.getElementById("profile-name");


        var emailInput =
            document.getElementById("profile-email");


        var phoneInput =
            document.getElementById("profile-phone");


        var addressInput =
            document.getElementById("profile-address");


        var passwordInput =
            document.getElementById("profile-password");


        var passwordToggle =
            document.getElementById("profile-password-toggle");


        var profileImageInput =
            document.getElementById("profile-image");


        var saveButton =
            document.querySelector(".save-settings-btn");


        /* Load profile */

        fetch("../api/profile.php")

            .then(function(response) {

                return response.json();

            })

            .then(function(result) {

                if (result.success) {

                    nameInput.value =
                        result.data.name || "";

                    emailInput.value =
                        result.data.email || "";

                    phoneInput.value =
                        result.data.phone || "";

                    addressInput.value =
                        result.data.address || "";

                } else {

                    console.error(
                        result.message
                    );

                }

            })

            .catch(function(error) {

                console.error(
                    "Profile loading error:",
                    error
                );

            });


        /* Password toggle */

        passwordToggle.addEventListener(
            "click",
            function() {

                if (
                    passwordInput.type ===
                    "password"
                ) {

                    passwordInput.type =
                        "text";

                    passwordToggle.innerHTML =
                        '<i data-lucide="eye-off"></i>';

                    passwordToggle.setAttribute(
                        "aria-label",
                        "Hide password"
                    );

                } else {

                    passwordInput.type =
                        "password";

                    passwordToggle.innerHTML =
                        '<i data-lucide="eye"></i>';

                    passwordToggle.setAttribute(
                        "aria-label",
                        "Show password"
                    );

                }

                lucide.createIcons();

            }
        );


        /* Save profile */

        saveButton.addEventListener(
            "click",
            function() {

                var formData =
                    new FormData();


                formData.append(
                    "name",
                    nameInput.value
                );


                formData.append(
                    "email",
                    emailInput.value
                );


                formData.append(
                    "phone",
                    phoneInput.value
                );


                formData.append(
                    "address",
                    addressInput.value
                );


                formData.append(
                    "password",
                    passwordInput.value
                );


                if (
                    profileImageInput.files.length > 0
                ) {

                    formData.append(
                        "profile_image",
                        profileImageInput.files[0]
                    );

                }


                fetch(
                    "../api/profile.php",
                    {
                        method: "POST",
                        body: formData
                    }
                )

                .then(function(response) {

                    return response.json();

                })

                .then(function(result) {

                    if (result.success) {

                        alert(
                            "Profile updated successfully"
                        );

                        window.location.reload();

                    } else {

                        alert(
                            result.message
                        );

                    }

                })

                .catch(function(error) {

                    console.error(
                        "Save profile error:",
                        error
                    );

                    alert(
                        "Failed to update profile"
                    );

                });

            }
        );


        /* Live date and time */

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

    });

    </script>

</body>

</html>