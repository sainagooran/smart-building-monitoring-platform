<?php

session_start();

require_once "../config/database.php";

header("Content-Type: application/json");


if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "User is not logged in"
    ]);

    exit;
}


$userId = (int) $_SESSION["user_id"];


/* Get profile */

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $sql = "SELECT
                id,
                name,
                email,
                phone,
                address,
                profile_image
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

        $user = $result->fetch_assoc();

        echo json_encode([
            "success" => true,
            "data" => $user
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
    }


    $stmt->close();

    exit;
}


/* Update profile */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $password = $_POST["password"] ?? "";

    $profileImagePath = null;


    if ($name === "" || $email === "") {

        echo json_encode([
            "success" => false,
            "message" => "Name and email are required"
        ]);

        exit;
    }


    /* Upload profile image */

    if (
        isset($_FILES["profile_image"]) &&
        $_FILES["profile_image"]["error"] !== UPLOAD_ERR_NO_FILE
    ) {

        $profileImage = $_FILES["profile_image"];


     if ($profileImage["error"] !== UPLOAD_ERR_OK) {

    if ($profileImage["error"] === UPLOAD_ERR_INI_SIZE) {

        echo json_encode([
            "success" => false,
            "message" => "The selected image is too large. Please choose an image smaller than 2 MB."
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "The profile image could not be uploaded. Please try another image."
        ]);

    }

    exit;
}

        $allowedExtensions = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];


        $fileExtension = strtolower(
            pathinfo(
                $profileImage["name"],
                PATHINFO_EXTENSION
            )
        );


        if (!in_array($fileExtension, $allowedExtensions)) {

            echo json_encode([
                "success" => false,
                "message" => "Invalid image format"
            ]);

            exit;
        }


        if ($profileImage["size"] > 2 * 1024 * 1024) {

            echo json_encode([
                "success" => false,
                "message" => "Image size must be less than 2 MB"
            ]);

            exit;
        }


        $uploadDirectory = "../uploads/profile/";


        if (!is_dir($uploadDirectory)) {

            mkdir(
                $uploadDirectory,
                0777,
                true
            );
        }


        $fileName = uniqid(
            "profile_",
            true
        ) . "." . $fileExtension;


        $uploadPath = $uploadDirectory . $fileName;


        if (!move_uploaded_file(
            $profileImage["tmp_name"],
            $uploadPath
        )) {

            echo json_encode([
                "success" => false,
                "message" => "Failed to save profile image"
            ]);

            exit;
        }


        $profileImagePath =
            "uploads/profile/" . $fileName;
    }


    /* Update profile with new password */

    if ($password !== "") {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );


        if ($profileImagePath !== null) {

            $sql = "UPDATE users
                    SET name = ?,
                        email = ?,
                        phone = ?,
                        address = ?,
                        password = ?,
                        profile_image = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssssi",
                $name,
                $email,
                $phone,
                $address,
                $hashedPassword,
                $profileImagePath,
                $userId
            );

        } else {

            $sql = "UPDATE users
                    SET name = ?,
                        email = ?,
                        phone = ?,
                        address = ?,
                        password = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "sssssi",
                $name,
                $email,
                $phone,
                $address,
                $hashedPassword,
                $userId
            );
        }

    } else {

        /* Update profile without changing password */

        if ($profileImagePath !== null) {

            $sql = "UPDATE users
                    SET name = ?,
                        email = ?,
                        phone = ?,
                        address = ?,
                        profile_image = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "sssssi",
                $name,
                $email,
                $phone,
                $address,
                $profileImagePath,
                $userId
            );

        } else {

            $sql = "UPDATE users
                    SET name = ?,
                        email = ?,
                        phone = ?,
                        address = ?
                    WHERE id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssi",
                $name,
                $email,
                $phone,
                $address,
                $userId
            );
        }
    }


    if ($stmt->execute()) {

        $_SESSION["user_name"] = $name;
        $_SESSION["user_email"] = $email;


        echo json_encode([
            "success" => true,
            "message" => "Profile updated successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to update profile"
        ]);
    }


    $stmt->close();

    exit;
}


echo json_encode([
    "success" => false,
    "message" => "Invalid request"
]);

?>