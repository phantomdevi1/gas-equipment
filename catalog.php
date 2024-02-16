<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: auth.php");
    exit();
}

include 'config.php';

if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$category_query = "SELECT `ID`, `category_name` FROM `category`";
$result = mysqli_query($conn, $category_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Каталог</title>
</head>

<body>
    <header class="header_index">
        <img src="img/logo.svg" alt="">
        <h1 class="heading_text">КАТАЛОГ</h1>
        <div class="toolbar">
            <a href="index.html">ГЛАВНАЯ</a>
            <a href="catalog.php">КАТАЛОГ</a>
            <a href="basket.php">КОРЗИНА</a>
            <a href="reviews.php">ОТЗЫВЫ</a>
            <a href="profile.php" class="last">ПРОФИЛЬ</a>
        </div>
    </header>

    <div class="content_catalog">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $categoryID = $row['ID'];
            $categoryName = $row['category_name'];

            echo "<div class='cart_catalog' >
                    <a href='category.php?id=$categoryID'>
                        <p>$categoryName</p>
                    </a>
                </div>";
        }
        ?>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>
