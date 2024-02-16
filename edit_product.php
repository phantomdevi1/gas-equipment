<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товаров</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  include 'config.php';
  session_start();
  if ($_SESSION['admin_status'] == 0) {
    header("Location: profile.php");
    exit;
  }

  $category_name_query = "SELECT ID, category_name FROM category";
  $result_categories = mysqli_query($conn, $category_name_query);
  ?>

    <header class="header_index">
        <img src="img/logo.svg" alt=""/>
        <h1 class="heading_text">Редактирование товаров</h1>
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
          <form method="post" class="select_filter_product">
            <select name="sort_order" id="" class="sort_order">
              <option value="date">По дате</option>
              <option value="asc">А-Я</option>
              <option value="desc">Я-А</option>
            </select>
            <select name="category_filter" id="" class="category_filter">
                <?php                
                while ($row = mysqli_fetch_assoc($result_categories)) {
                    $categoryId = $row['ID'];
                    $categoryName = $row['category_name'];
                    echo "<option value='$categoryId'>$categoryName</option>";                    
                }              
                ?>
            </select>
            <button type="submit" name="show_products" class="show_products">Показать</button>
          </form>
          
        </center>

        <?php  
        if (isset($_POST['show_products'])) {
            // Получаем параметры для фильтрации
            $sort_order = $_POST['sort_order'];
            $category_filter = $_POST['category_filter'];

            // Формируем запрос с учетом фильтров
            $query = "SELECT * FROM product";

            if (!empty($category_filter)) {
                $query .= " WHERE category = $category_filter";
            }

            $query .= " ORDER BY ";

            switch ($sort_order) {
                case 'date':
                    $query .= "ID DESC";
                    break;
                case 'asc':
                    $query .= "name ASC";
                    break;
                case 'desc':
                    $query .= "name DESC";
                    break;
                default:
                    $query .= "ID DESC";
                    break;
            }

            $result_products = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result_products)) {
                $productId = $row['ID'];
                $productName = $row['name'];
                $productDescription = $row['description'];
                $productPrice = $row['price'];
                $productImage = $row['image'];
                $productCategory = $row['category'];                
        ?>

        
            <form method="post" class="edit_product_card">
            <div class="edit_product_card-img">
                    <img src="<?php echo $productImage; ?>" alt="">
          </div>
            <div class="information_product_edit">
              <div class="info_product_block">
                <input class="productname_input" name="product_name" type="text" value="<?php echo $productName; ?>">
                <div class=""><input class="cost_input" type="number" name="cost" id="" value="<?php echo $productPrice; ?>"><span class="currency">₽/шт</span></div>   
                <select name="category" id="">
                    <?php
                    $result_categories = mysqli_query($conn, $category_name_query);
                    while ($category_row = mysqli_fetch_assoc($result_categories)) {
                        $categoryId = $category_row['ID'];
                        $categoryName = $category_row['category_name'];
                        $selected = ($categoryId == $productCategory) ? "selected" : "";
                        echo "<option value='$categoryId' $selected>$categoryName</option>";
                    }
                    ?>
                </select>         
                <textarea class="description_input" name="description" id="" cols="30" rows="10"><?php echo $productDescription; ?></textarea>
                </div>
                </div>
                <div class="control_block">
                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                <button type="submit" name="delete_product" class="delete_product_btn"></button>
                <button type="submit" name="save_changes" class="save_product_btn"></button>
                </div>
            </form>
          
        </div>

        <?php
            } // Завершение цикла while
        } // Завершение проверки наличия POST-запроса
        ?>

    </div>
</body>
</html>

<?php
// Обработка действий после отображения товаров

if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $delete_product_query = "DELETE FROM product WHERE ID = $product_id";
    if (mysqli_query($conn, $delete_product_query)) {
        echo "<script>alert('Товар удален.')</script>";
    } else {
        echo "<script>alert('Ошибка: ' . mysqli_error($conn))</script>";
    }
}

if (isset($_POST['save_changes'])) {
    $product_id = $_POST['product_id'];
    $new_product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $new_product_price = $_POST['cost'];
    $new_product_category = $_POST['category'];
    $new_product_description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_product = "UPDATE `product` SET `name`='$new_product_name', `description`='$new_product_description', `price`='$new_product_price', `category`='$new_product_category' WHERE `ID` = $product_id"; 
    if (mysqli_query($conn, $update_product)) {
      echo "<script>alert('Товар изменен.')</script>";
  } else {
      echo "<script>alert('Ошибка: ' . mysqli_error($conn))</script>";
  }
}
?>
