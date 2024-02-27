<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the database connection
    if ($conn->connect_error) {
        echo "<script>alert('Ошибка подключения к базе данных.');</script>";
        exit();
    }

    // Get the user's discount card value
    $sql = "SELECT discount_card FROM users WHERE ID = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentDiscountCardValue = $row['discount_card'];

        if ($currentDiscountCardValue == 0) {
            // Update the discount card value to 1 if it's not already issued
            $updateSql = "UPDATE users SET discount_card = 1 WHERE ID = $user_id";
            if ($conn->query($updateSql) === TRUE) {
                echo "<script>alert('Скидочная карта успешно оформлена.');</script>";
            } else {
                echo "<script>alert('Ошибка при оформлении скидочной карты: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Скидочная карта уже оформлена.');</script>";
        }
    } else {
        echo "<script>alert('Пользователь не найден.');</script>";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/favicon.png" type="image/x-icon" />
    <title>Скидочная карта</title>
</head>
<body>
    <div class="content_discount_card">
        <div class="info_discount_card">
            <h1 class="title_discount_card">Хотите самые выгодные предложения?</h1>
            <img class="money3d" src="img/3dicons.svg" alt="" width="25%">    
        </div>
        <form method="post">
            <button type="submit" class="open_discount_card">Оформить карту</button>
        </form>
    </div>
</body>
</html>
