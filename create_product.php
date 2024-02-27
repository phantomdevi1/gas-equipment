<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Добавление товара\категории</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="img/favicon.png" type="image/x-icon" />
</head>

<body>
    <?php
    session_start();
    if ($_SESSION['admin_status'] == 0) {
        header("Location: profile.php");
        exit;
    }
    include 'config.php';

    if (!$conn) {
        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }

    $category_name_query = "SELECT ID, category_name FROM category";
    $result = mysqli_query($conn, $category_name_query);

    ?>

    <header class="header_index">
        <img src="img/logo.svg" alt="" />
        <h1 class="heading_text">ДОБАВЛЕНИЕ</h1>
        <div class="toolbar">
            <a href="index.html">ГЛАВНАЯ</a>
            <a href="catalog.php">КАТАЛОГ</a>
            <a href="basket.php">КОРЗИНА</a>
            <a href="reviews.php">ОТЗЫВЫ</a>
            <a href="profile.php" class="last">ПРОФИЛЬ</a>
        </div>
    </header>

    <div class="content_create_product">
        <div class="add_product">
            <h2>Добавление товара</h2>
            <p>Добавьте фото:</p>
            <form action="" method="post" class="add_product_form" enctype="multipart/form-data" id="form1">
                <input type="file" name="product_image" class="add_img" accept="image/*">
                <input type="text" placeholder="Имя товара" name="name_product" class="add_product_name" />
                <select name="category" id="" class="choose_category">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $categoryId = $row['ID'];
                        $categoryName = $row['category_name'];
                        echo "<option value='$categoryId'>$categoryName</option>";
                    }
                    ?>
                </select>
                <input type="number" name="quantity_product" class="add_product_price" id="" placeholder="Количество товара на складе">
                <input type="number" placeholder="Стоимость товара за шт." name="add_price" class="add_product_price" />
                <textarea id="" cols="30" rows="10" name="description_product" class="add_description_product"
                    placeholder="Описание товара"></textarea>
                <input type="submit" name="submit_product" value="Добавить товар" class="add_product_btn" />
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_product'])) {
            $targetDir = "img/product/";
            $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
            $imagePath = $targetFile;
            $productName = $_POST['name_product'];
            $productCategory = $_POST['category'];
            $productQuantity = $_POST['quantity_product'];
            $productPrice = $_POST['add_price'];
            $productDescription = $_POST['description_product'];

            // Проверка на пустые поля
            if (empty($productName) || empty($productCategory) || empty($productQuantity) || empty($productPrice) || empty($productDescription) || empty($imagePath)) {
                echo "<script>alert('Пожалуйста, заполните все поля.')</script>";
            } else {
                $sql = "INSERT INTO product (name, description, price, image, category, quantity_warehouse) VALUES ('$productName', '$productDescription', '$productPrice', '$imagePath', '$productCategory', '$productQuantity')";

                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Товар успешно добавлен в базу данных.')</script>";
                } else {
                    echo "<script>alert('Ошибка: ' . $sql . mysqli_error($conn)')</script>";
                }
            }
        }
        ?>

        <div class="add_category">
            <h2>Добавление категории</h2>
            <form action="" method="post" class="add_product_form" id="form2">
                <input type="text" placeholder="Название категории" name="name_category" class="add_product_name" />
                <input type="submit" name="submit_category" value="Добавить категорию" class="add_product_btn" />
            </form>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_category'])) {
            $categoryName = $_POST['name_category'];

            // Проверка на пустое поле
            if (empty($categoryName)) {
                echo "<script>alert('Пожалуйста, заполните поле названия категории.')</script>";
            } else {
                $sql = "INSERT INTO category (category_name) VALUES ('$categoryName')";

                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Категория успешно добавлена в базу данных.')</script>";
                } else {
                    echo "<script>alert('Ошибка: ' . $sql . mysqli_error($conn)')</script>";
                }
            }
        }
        ?>
    </div>

</body>

</html>

