<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header_index">
        <img src="img/logo.svg" alt=""/>
        <h1 class="heading_text">МОИ ЗАКАЗЫ</h1>
        <div class="toolbar">
        <a href="index.html">ГЛАВНАЯ</a>
        <a href="catalog.php">КАТАЛОГ</a>
        <a href="basket.php">КОРЗИНА</a>
        <a href="reviews.php">ОТЗЫВЫ</a>        
        <a href="profile.php" class="last">ПРОФИЛЬ</a>
      </div>
    </header>
    <div class="content_order">
        <?php
        include 'config.php';
        session_start();
        $user_id = $_SESSION['user_id']; // Получаем ID пользователя из сессии
        $query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
        $result = mysqli_query($conn, $query);

       // Перебор результатов запроса
        while ($row = mysqli_fetch_assoc($result)) {
          $order_date = date('d.m.Y H:i', strtotime($row['order_date']));
          $status = $row['status'];
          $total_price = $row['full_price'];

          $order_id = $row['order_id'];
          $query_items = "SELECT * FROM order_items INNER JOIN product ON order_items.product_id = product.ID WHERE order_items.order_id = $order_id";
          $result_items = mysqli_query($conn, $query_items);

          // Выводим данные
          echo '<div class="card_order">';
          echo '<div class="info_card_order">';
          echo '<div><p>' . $order_date . '</p></div>';
          echo '<div><p>Номер заказа:</p><span>' . $order_id . '</span></div>';
          echo '<div><p>Статус:</p><span>' . $status . '</span></div>';
          echo '<div><p>Общая стоимость:</p><span>' . $total_price . ' ₽</span></div>';
          
          // Выводим данные из order_items
          while ($item_row = mysqli_fetch_assoc($result_items)) {
              $product_name = $item_row['name'];
              $product_image = $item_row['image'];
              $item_quantity = $item_row['quantity'];
              
              // Выводим название товара с количеством
              echo '<div><p>Товар:</p><span>' . $product_name . ' (x' . $item_quantity . ')</span></div>';
          }

          echo '</div>';
          echo '<div class="img_card_order">';
          echo '<img src="' . $product_image . '" alt="" width="293px">';
          echo '</div>';
          echo '</div>';
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
