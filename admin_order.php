<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header_index">
        <img src="img/logo.svg" alt=""/>
        <h1 class="heading_text">ЗАКАЗЫ</h1>
        <div class="toolbar">
            <a href="index.html">ГЛАВНАЯ</a>
            <a href="catalog.php">КАТАЛОГ</a>
            <a href="basket.php">КОРЗИНА</a>
            <a href="reviews.php">ОТЗЫВЫ</a>        
            <a href="profile.php" class="last">ПРОФИЛЬ</a>
        </div>
    </header>
    <div class="content_order">
        <center>
            <form method="post" class="status_admin_order">
                <select class="select_status" name="order_status">
                    <option value="Все заказы">Все заказы</option>
                    <option value="В обработке">В обработке</option>
                    <option value="В сборке">В сборке</option>
                    <option value="В доставке">В доставке</option>
                    <option value="Готов к выдаче">Готов к выдаче</option>
                    <option value="Выдан">Выдан</option>
                </select>
                <button type="submit" name="show_orders" class="show_order_btn">Показать</button>
            </form>

        </center>

        <?php
include 'config.php';
session_start();
$selected_status = 'Все заказы';
if (isset($_POST['show_orders'])) {
    $selected_status = $_POST['order_status'];
    if($selected_status == 'Все заказы'){
        $query = "SELECT * FROM orders ORDER BY order_date DESC";
    }
    else{
     $query = "SELECT * FROM orders WHERE status = '$selected_status' ORDER BY order_date DESC";   
    }    
    $result = mysqli_query($conn, $query);
    
    $query_t = "SELECT COUNT(*) FROM `orders` WHERE status = '$selected_status';";
    $result_t = mysqli_query($conn, $query_t);

    $query_three = "SELECT COUNT(*) FROM `orders`";
    $result_three = mysqli_query($conn, $query_three);

    if($selected_status == 'Все заказы'){
        if ($result_three) {        
            $row = mysqli_fetch_assoc($result_three);
            $count_order_status = $row['COUNT(*)'];
        }
    }
    else{
      if ($result_t) {        
        $row = mysqli_fetch_assoc($result_t);
        $count_order_status = $row['COUNT(*)'];
    }  
    }
    

    echo "<p class='status_order_input'>$selected_status: $count_order_status</p>";
    while ($row = mysqli_fetch_assoc($result)) {
        $order_date = date('d.m.Y H:i', strtotime($row['order_date']));
        $status = $row['status'];
        $total_price = $row['full_price'];

        $order_id = $row['order_id'];
        $query_user = "SELECT user_name, user_phone, user_email FROM users
        WHERE ID = (SELECT user_id FROM orders WHERE order_id = $order_id)";
        $result_user = mysqli_query($conn, $query_user);
        $user_row = mysqli_fetch_assoc($result_user);
        $username = $user_row['user_name'];
        $user_phone = $user_row['user_phone'];
        $user_email = $user_row['user_email'];

        

        $query_items = "SELECT order_items.*, product.*
        FROM order_items
        INNER JOIN product ON order_items.product_id = product.ID
        WHERE order_items.order_id = $order_id";
        $result_items = mysqli_query($conn, $query_items);
        $result_items = mysqli_query($conn, $query_items);                
        
        
        echo '<div class="card_order">';
        echo '<div class="info_card_order">';
        echo '<div><p>' . $order_date . '</p></div>';
        echo '<div><p>Номер заказа:</p><span>' . $order_id . '</span></div>';
        echo '<div><p>Заказчик:</p><span  class="adminorder_customer" onclick="showCustomerInfo(\'' . $username . '\', \'' . $order_id . '\', \'' . $user_phone . '\', \'' . $user_email . '\')">' . $username . '</span></div>';
        echo '<div><p>Статус:</p><span>' . $status . '</span></div>';
        echo '<div><p>Общая стоимость:</p><span>' . $total_price . ' ₽</span></div>';
        while ($item_row = mysqli_fetch_assoc($result_items)) {
            $product_name = $item_row['name'];
            $product_image = $item_row['image'];
            $item_quantity = $item_row['quantity'];
            echo '<div><p>Товар:</p><span>' . $product_name . ' (x' . $item_quantity . ')</span></div>';
        }
        
        
        
        echo "<form method='post' class='status_change'>";
        echo "<input type='hidden' name='order_id' value='$order_id'>";
        echo "<button type='submit' name='in_delivery' class='in_delivery_btn'>В доставке</button>";
        echo "<button type='submit' name='in_assembly' class='in_assembly_btn'>В сборке</button>";
        echo "<button type='submit' name='delivered' class='deliverd_btn'>Готов к выдаче</button>";
        echo "<button type='submit' name='given' class='given_btn'>Выдан</button>";
        echo "</form>";
        echo '</div>';
        echo '<div class="img_card_order">';
        echo '<img src="' . $product_image . '" alt="" width="293px">';
        echo '</div>';
        echo '</div>';
    }
}

// Обработка действий
if (isset($_POST['in_delivery'])) {
    $order_id = $_POST['order_id'];
    $update_query = "UPDATE orders SET status = 'В доставке' WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);
}

if (isset($_POST['in_assembly'])) {
    $order_id = $_POST['order_id'];
    $update_query = "UPDATE orders SET status = 'В сборке' WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);
}

if (isset($_POST['delivered'])) {
    $order_id = $_POST['order_id'];
    $update_query = "UPDATE orders SET status = 'Готов к выдаче' WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);
}
if (isset($_POST['given'])) {
    $order_id = $_POST['order_id'];
    $update_query = "UPDATE orders SET status = 'Выдан' WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);
}

mysqli_close($conn);
?>
    </div>

    <script>
          function showCustomerInfo(username, order_id, user_phone, user_email) {
            // Вывод информации о заказчике в alert
            alert(`Имя заказчика: ${username}\nНомер телефона: ${user_phone}\nEmail: ${user_email}\nНомер заказа: ${order_id}`);
            // Дополнительная логика, если необходимо
        }
    </script>
</body>
</html>
