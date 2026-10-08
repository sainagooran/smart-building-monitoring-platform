<?php

session_start();

require_once "config/database.php";

$message = "";
$messageType = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";


    $sql = "SELECT *
            FROM users
            WHERE email = ?";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "s",
        $email
    );


    $stmt->execute();


    $result = $stmt->get_result();


    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();


        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] =
                $user["id"];

            $_SESSION["user_name"] =
                $user["name"];

            $_SESSION["user_email"] =
                $user["email"];


            header("Location: index.php");

            exit;

        } else {

            $message =
                "Invalid password.";

            $messageType =
                "error";

        }

    } else {

        $message =
            "User not found.";

        $messageType =
            "error";

    }


    $stmt->close();
}

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
        Smart Building - Sign in
    </title>


    <link
        rel="stylesheet"
        href="assets/css/login.css"
    >

</head>


<body>


    <main class="login-page">


        <section class="login-image">

            <img
                src="assets/images/building.jpg"
                alt="Smart Building"
            >


            <div class="image-overlay">

                <div class="building-text">

                    <div class="small-label">
                        SMART BUILDING
                    </div>

                    <h1>
                        Monitor your building
                        intelligently.
                    </h1>

                    <p>
                        Manage energy, devices,
                        temperature and alerts
                        from one place.
                    </p>

                </div>

            </div>

        </section>



        <section class="login-panel">


            <div class="login-content">


                <div class="house-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M3 10.5L12 3l9 7.5"
                        />

                        <path
                            d="M5 9.5V21h14V9.5"
                        />

                        <path
                            d="M9 21v-6h6v6"
                        />

                    </svg>

                </div>


                <div class="login-heading">

                    <h2>
                        Welcome back
                    </h2>

                    <p>
                        Sign in to your
                        smart building dashboard.
                    </p>

                </div>



                <?php

                if ($message !== "") {

                    echo
                        '<div class="message ' .
                        $messageType .
                        '">' .
                        htmlspecialchars($message) .
                        '</div>';

                }

                ?>



                <form
                    method="POST"
                    class="login-form"
                >


                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            autocomplete="username"
                            placeholder="Enter your email"
                            required
                        >

                    </div>



                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>


                        <div class="password-wrapper">

    <input
        type="password"
        id="password"
        name="password"
        autocomplete="current-password"
        placeholder="Enter your password"
        required
    >

    <button
        type="button"
        class="password-toggle"
        onclick="togglePassword()"
        aria-label="Show password"
    >
        👁
    </button>

</div>

                    </div>



                    <button
                        type="submit"
                        class="login-button"
                    >
                        Sign in
                    </button>


                </form>



                <div class="login-footer">

                  Don't have an account?

                    <a href="signup.php">
                       Sign up
                    </a>

                 </div>


            </div>


        </section>


    </main>
  <script>

function togglePassword() {

    var passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

    } else {

        passwordInput.type = "password";

    }
}

</script>

</body>

</html>