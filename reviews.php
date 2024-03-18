<?php
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
}
include 'config.php';
$reviews_query = "SELECT * FROM reviews";
$reviews_result = mysqli_query($conn, $reviews_query);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($user_id)) {
      $rating = $_POST['rating'];
      $review_text = $_POST['review_text'];

      include 'config.php';

      if ($conn) {
          $sql = "SELECT user_name FROM users WHERE ID = $user_id";
          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $username = $row['user_name'];

              // Запись отзыва в таблицу reviews
              $insert_review_query = "INSERT INTO reviews (username, rating, review_text) VALUES ('$username', $rating, '$review_text')";
              if (mysqli_query($conn, $insert_review_query)) {
                  echo '<script>alert("Отзыв успешно добавлен!");</script>';
                  header('refresh:1;');
                  
              } else {
                  echo "Ошибка: " . $insert_review_query . "<br>" . mysqli_error($conn);
              }
          }
      } else {
          echo "Ошибка: " . mysqli_connect_error();
      }
      mysqli_close($conn);
  } else {
      echo '<script>alert("Необходимо авторизоваться, чтобы оставить отзыв!");</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Отзывы</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="img/favicon.png" type="image/x-icon" />
</head>
<body>
<header class="header_index">
  <img src="img/logo.svg" alt="">
  <h1 class="heading_text">ОТЗЫВЫ</h1>
  <div class="toolbar">
        <a href="index.html">ГЛАВНАЯ</a>
        <a href="catalog.php">КАТАЛОГ</a>
        <a href="basket.php">КОРЗИНА</a>
        <a href="reviews.php">ОТЗЫВЫ</a>        
        <a href="profile.php" class="last">ПРОФИЛЬ</a>
      </div>
</header>

<div class="content_reviews">
  <?php
  if ($reviews_result && mysqli_num_rows($reviews_result) > 0) {
      while ($row = mysqli_fetch_assoc($reviews_result)) {
          $username = $row['username'];
          $rating = $row['rating'];
          $review_text = $row['review_text'];
  ?>
  <div class="rewiews_block">
    <div class="name_block">
      <span class="name_name_block"><?php echo $username; ?></span>
      <span class="estimation_name_block"><img src="img/star.svg" alt=""><?php echo $rating; ?>/5</span>
    </div>
    <p class="rewiew_text"><?php echo $review_text; ?></p>
  </div>
  <?php
      }
  }
  ?>
</div>

<form method="post" action="">
<div class="write_rewiew">
  
    <p class="title_write_rewiew">Написать отзыв</p>
    <div class="write_rewiew_estimation">
      <p>Выберите оценку:</p>
      <select name="rating" id="ratingList">
        <option value="5">5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="2">2</option>
        <option value="1">1</option>
      </select>
    </div>
    <textarea class="input_rewiew" name="review_text" id="reviewText" cols="30" rows="10" maxlength="300" placeholder="Напишите свой отзыв"></textarea>
    <input class="submit_rewiew" type="submit" value="Опубликовать">
  
</div>
</form>

</body>
</html>
