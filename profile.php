<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Профиль</title>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php#section_auth");
    exit;
}

$user_id = $_SESSION['user_id'];

include 'config.php';

if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$query = "SELECT user_name, user_email, user_phone, access_status, discount_card FROM users WHERE ID = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['user_name'];
    $user_email = $row['user_email'];
    $user_phone = $row['user_phone'];
    $admin_status = $row['access_status'];
    $discount_card_status = $row['discount_card'] == 1 ? 'активна' : 'не активна';
    $_SESSION['admin_status'] = $row['access_status'];
} else {
    // Handle the case where user data is not found
}

// Функция для выхода из профиля
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: auth.php");
    exit;
}

// Обработка оформления скидочной карты
if (isset($_POST['add_discount_card'])) {
    $sql = "SELECT discount_card FROM users WHERE ID = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentDiscountCardValue = $row['discount_card'];       

        if ($currentDiscountCardValue == 0) {
            // Update the discount card value to 1 if it's not already issued
            $updateSql = "UPDATE users SET discount_card = 1 WHERE ID = $user_id";
            if ($conn->query($updateSql) === TRUE) {
                // Обновляем статус после оформления карты
                $discount_card_status = 'активна';
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
}

$query_admins = "SELECT COUNT(*) FROM `users` WHERE access_status = 1;";
$result = mysqli_query($conn, $query_admins);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $admin_count = $row['COUNT(*)'];
}

$query_orders = "SELECT COUNT(*) FROM `orders` WHERE status = 'В обработке';";
$result = mysqli_query($conn, $query_orders);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $orders_count = $row['COUNT(*)'];
}

$query_users = "SELECT COUNT(*) FROM `users` WHERE access_status != 1;";
$result = mysqli_query($conn, $query_users);
if($result){
    $row = mysqli_fetch_assoc($result);
    $users_count = $row['COUNT(*)'];    
}

$query_all_orders = "SELECT COUNT(*) FROM `orders`;";
$result = mysqli_query($conn, $query_all_orders);
if($result){
    $row = mysqli_fetch_assoc($result);
    $all_orders_count = $row['COUNT(*)'];
}

mysqli_close($conn);
?>

<header class="header_index">
    <img src="img/logo.svg" alt="">
    <h1 class="heading_text">ПРОФИЛЬ</h1>
    <div class="toolbar">
        <a href="index.html">ГЛАВНАЯ</a>
        <a href="catalog.php">КАТАЛОГ</a>
        <a href="basket.php">КОРЗИНА</a>
        <a href="reviews.php">ОТЗЫВЫ</a>        
        <a href="profile.php" class="last">ПРОФИЛЬ</a>
      </div>
</header>

<div class="content_profile" id="profile_block">
    <div class="profile_block_left">
        <?
        if($admin_status == 1){
            $avatar = "img/admin_avatar.png";
        }
        else{
            $avatar = "img/default_ava.svg";
        }
        ?>
        <img src="<?= $avatar ?>" alt="Аватарка" class="ava_img" width="90%" max-width="250px">
        <p class="name_profile"><?php echo $user_name; ?></p>
        <form method="post">
            <button class="exit_profile" name="logout">Выйти</button>
        </form>
         
        
        <?
        if($admin_status == 1){
            echo "<div class='admin_block'>";
            echo "<p>Новые заказы:  $orders_count </p>";
            echo "<p>Клиенты: $users_count </p>";
            echo "<p>Администраторы: $admin_count </p>";
            echo "<p>Всего заказов: $all_orders_count </p>";
            echo "</div>";

        }
        else {
            echo "<img class='img_profile_card' src='img/discount_cart.svg'>";
            echo "<p class='status_discount_card'>" . $discount_card_status . "</p>";
            echo "<form action='' method='post'>";
            echo "<button class='add_discount_card' name='add_discount_card' " . ($discount_card_status == 'активна' ? "style='display:none;'" : "") . ">Оформить</button>";
            echo "</form>";
        }
        ?>
    </div>
    <div class="profile_block_right">
        <p class="title_info_profile">Информация</p>
        <hr>
        <div class="user_info">
            <div class="usermail">
                <p>Почта</p>
                <span class="usermail_email"><?php echo $user_email; ?></span>
            </div>
            <div class="usernumber">
                <p>Телефон</p>
                <span class="usernumber_phone"><?php echo $user_phone; ?></span>
            </div>
        </div>
        <div class="user_order">
            <?
            if($admin_status == 1){
                echo "<p class='title_info_profile'>Заказы и товары</p>";
            }
            else{
                echo "<p class='title_info_profile'>Заказы</p>";
            }
            ?>
            <hr>
            <div class="order_profile">  
                                         
                <?
            if($admin_status == 1){
                echo "<a href='admin_order.php'><img src='img/order_admin_icon.svg' width='90%'></a>";
                echo "<a href='create_product.php'><img src='img/add_tovar_icon.svg' width='90%'></a>";
                echo "<a href='edit_product.php'><img src='img/edit_tovar_icon.svg' width='90%'></a>";
                echo "<a href='product_accounting.php'><img src='img/accounting_product.svg' width='90%'></a>";
            }
            else{
                echo "<a href='orders.php'><img src='img/actual_order.svg' alt='заказы' class='profile_user_order' width='90%'></a>";
            }            
            ?>                 
            </div>
            
        </div>
    </div>
</div>
</body>
</html>
