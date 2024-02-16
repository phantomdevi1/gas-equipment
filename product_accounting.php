<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Учёт товара</title>
    <style>
        .red { color: red; }
        .yellow { color: yellow; }
        .green { color: green; }
    </style>
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

// Получаем данные из таблицы товаров
$product_query = "SELECT 
        p.ID,
        p.name,
        p.quantity_warehouse,
          SUM(oi.quantity) AS total_sold,
          SUM(CASE WHEN o.order_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) THEN oi.quantity ELSE 0 END) AS monthly_sold
        FROM 
        product p
          LEFT JOIN 
        order_items oi ON p.ID = oi.product_id
          LEFT JOIN 
        orders o ON oi.order_id = o.order_id
          GROUP BY 
        p.ID;
";

$result = mysqli_query($conn, $product_query);

if (!$result) {
    die("Ошибка запроса: " . mysqli_error($conn));
} ?>

<header class="header_index">
    <img src="img/logo.svg" alt="">
    <h1 class="heading_text">Учёт товара</h1>
    <div class="toolbar">
        <a href="index.html">ГЛАВНАЯ</a>
        <a href="catalog.php">КАТАЛОГ</a>
        <a href="basket.php">КОРЗИНА</a>
        <a href="reviews.php">ОТЗЫВЫ</a>        
        <a href="profile.php" class="last">ПРОФИЛЬ</a>
    </div>
</header>

<div class="content_profile">
    <form method="post">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Имя товара</th>
                <th>Количество на складе</th>
                <th>Продано всего</th>
                <th>Продано за месяц</th>
                <th>Количество (редактируемо)</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              $productId = $row['ID'];
              $productName = $row['name'];
              $quantityWarehouse = $row['quantity_warehouse'];
              $totalSold = $row['total_sold'];
              $monthlySold = $row['monthly_sold'];
          
              // Определение цвета в зависимости от количества на складе
              $colorClass = ($quantityWarehouse == 0) ? 'red' : (($quantityWarehouse <= 10) ? 'yellow' : 'green');
          ?>
          <tr>
              <td><?php echo $productId; ?></td>
              <td><?php echo $productName; ?></td>
              <td class="<?php echo $colorClass; ?>"><?php echo $quantityWarehouse; ?></td>
              <td><?php echo $totalSold; ?></td>
              <td><?php echo $monthlySold; ?></td>
              <td>
                  <input type="number" name="quantity_<?php echo $productId; ?>" value="<?php echo $quantityWarehouse; ?>" />
              </td>
          </tr>
          <?php
          }
          
          ?>
        </table>
        <button type="submit" name="save_changes">Сохранить</button>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity_') === 0) {
            $productId = str_replace('quantity_', '', $key);
            $newQuantity = (int)$value;

            // Добавьте проверку на допустимые значения и обновите базу данных
            $update_query = "UPDATE product SET quantity_warehouse = $newQuantity WHERE ID = $productId";
            mysqli_query($conn, $update_query);
        }
    }
}
?>
</body>
</html>
