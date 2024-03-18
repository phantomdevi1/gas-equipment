<?php
session_start();


    if (isset($_GET['id'])) {
        $category_id = $_GET['id'];
        include 'config.php';

        $sql = "SELECT * FROM category WHERE ID = $category_id";
        $result = mysqli_query($conn, $sql);
    } else {
        echo "Категория не выбрана";
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Категория</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="img/favicon.png" type="image/x-icon" />
</head>

<body>
    <header class="header_index">
        <img src="img/logo.svg" alt="">
        <h1 class="heading_text_category">
            <?php
            if (isset($result)) {
                $row = mysqli_fetch_assoc($result);
                $category_name = $row['category_name'];
                echo $category_name;
            } else {
                echo "Категория не выбрана";
            }
            ?>
        </h1>
        <div class="toolbar">
            <a href="index.html">ГЛАВНАЯ</a>
            <a href="catalog.php">КАТАЛОГ</a>
            <a href="basket.php">КОРЗИНА</a>
            <a href="reviews.php">ОТЗЫВЫ</a>
            <a href="profile.php" class="last">ПРОФИЛЬ</a>
        </div>
    </header>
    <div class="content_category">
        <?php
        $sql = "SELECT * FROM product WHERE category = $category_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="block_category">';
                echo '<img src="' . $row['image'] . '" alt="" />';
                echo '<span class="block_category_count">' . $row['price'] . ' ₽/шт</span>';
                echo '<span class="block_category_name">' . $row['name'] . '</span>';

                if (!empty($row['description'])) {
                    echo '<span class="block_category_description">' . $row['description'] . '</span>';
                }

                echo '<a href="#" class="read-more-link">Читать далее</a>';
                echo '<span class="category_quantity_warehouse">Наличие: ' . $row["quantity_warehouse"] . '</span>  ';
                ?>
                <form method="POST" action="">
                    <span>Количество:</span><input class="quantity_category" type="number" value="1" min="1"
                        max="<?php echo $row['quantity_warehouse']; ?>" name="quantity_category">
                    <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
                    <button type="submit" class="block_category_btn" name="add_to_cart">Добавить в корзину</button>
                </form>

                <?php
                echo '</div>';
            }
        } else {
            echo "Нет продуктов в выбранной категории";
        }

        if (isset($_POST['add_to_cart'])) {
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
              
            $product_id = $_POST['product_id'];
            $quantity_category = isset($_POST['quantity_category']) ? intval($_POST['quantity_category']) : 1;

            // Проверка наличия товара на складе
            $check_quantity_sql = "SELECT quantity_warehouse FROM product WHERE ID = $product_id";
            $check_quantity_result = mysqli_query($conn, $check_quantity_sql);

            if ($check_quantity_result && mysqli_num_rows($check_quantity_result) > 0) {
                $row = mysqli_fetch_assoc($check_quantity_result);
                $available_quantity = $row['quantity_warehouse'];

                if ($quantity_category > $available_quantity) {
                    echo "<script>alert('Недостаточно товара на складе.');</script>";
                } else {
                    // Добавление в корзину
                    $insert_sql = "INSERT INTO cart (user_id, product_id, quantity, date_added) VALUES ($user_id, $product_id, $quantity_category, NOW())";
                    mysqli_query($conn, $insert_sql);

                    // Уменьшение количества товара на складе
                    $update_quantity_sql = "UPDATE product SET quantity_warehouse = quantity_warehouse - $quantity_category WHERE ID = $product_id";
                    mysqli_query($conn, $update_quantity_sql);

                    echo "<script>alert('Товар добавлен в корзину!');</script>";
                }
            } else {
                echo "<script>alert('Ошибка при проверке наличия товара на складе.');</script>";
            }
        }
        else{
            echo "<script>alert('Для добавления товаров в корзину необходимо авторизоваться');</script>";
        }
    }
        ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var descriptions = document.querySelectorAll('.block_category_description');

            descriptions.forEach(function (description) {
                var readMoreLink = description.nextElementSibling;

                if (description.offsetHeight < description.scrollHeight) {
                    readMoreLink.classList.add('active');

                    readMoreLink.addEventListener('click', function (event) {
                        event.preventDefault();
                        description.style.maxHeight = 'none';
                        readMoreLink.style.display = 'none';
                    });
                }
            });
        });
    </script>
</body>

</html>
