<?php

require_once "config/database.php";

$message = "";
$messageType = "";

$name = "";
$email = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $confirmPassword = $_POST["confirm_password"] ?? "";


  if ($name === "" || $email === "" || $password === "") {

    $message = "Please fill in all fields.";
    $messageType = "error";

} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $message = "Please enter a valid email address.";
    $messageType = "error";

} elseif ($password !== $confirmPassword) {

        $message = "Passwords do not match.";
        $messageType = "error";

    } else {

        $checkSql = "SELECT id FROM users WHERE email = ?";

        $checkStmt = $conn->prepare($checkSql);

        $checkStmt->bind_param(
            "s",
            $email
        );

        $checkStmt->execute();

        $checkResult = $checkStmt->get_result();


        if ($checkResult->num_rows > 0) {

            $message = "An account with this email already exists.";
            $messageType = "error";

        } else {

            $buildingId = 1;
            $role = "user";

            $sql = "INSERT INTO users
                    (building_id, name, email, password, role)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "issss",
                $buildingId,
                $name,
                $email,
               $hashedPassword,
                $role
            );


           if ($stmt->execute()) {

    header("Location: login.php");

    exit;

} else {

                $message = "Failed to create account.";
                $messageType = "error";
            }

            $stmt->close();
        }

        $checkStmt->close();
    }
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
        Smart Building - Sign up
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
                        Create your account.
                    </h1>

                    <p>
                        Start monitoring your
                        smart building from one place.
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
                        Create account
                    </h2>

                    <p>
                        Create your smart building account.
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
                 autocomplete="off"
                >


                    <div class="form-group">

                        <label for="name">
                            Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter your name"
                            value="<?php echo htmlspecialchars($name); ?>"
                            required
                        >

                    </div>



                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            value="<?php echo htmlspecialchars($email); ?>"
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
        autocomplete="new-password"
        placeholder="Create a password"
        required
    >

    <button
        type="button"
        class="password-toggle"
        onclick="togglePassword('password')"
        aria-label="Show password"
    >
        👁
    </button>

</div>

                    </div>



                    <div class="form-group">

                        <label for="confirm_password">
                            Confirm Password
                        </label>

                        <div class="password-wrapper">

    <input
        type="password"
        id="confirm_password"
        name="confirm_password"
        autocomplete="new-password"
        placeholder="Confirm your password"
        required
    >

    <button
        type="button"
        class="password-toggle"
        onclick="togglePassword('confirm_password')"
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
                        Create account
                    </button>


                </form>



                <div class="login-footer">

                    Already have an account?

                    <a href="login.php">
                        Sign in
                    </a>

                </div>


            </div>


        </section>


    </main>

<script>

function togglePassword(id) {

    var passwordInput = document.getElementById(id);

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

    } else {

        passwordInput.type = "password";

    }
}

</script>
</body>

</html>