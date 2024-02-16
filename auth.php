<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Авторизация</title>
  </head>
  <body>
    <header class="header_index">
    <img src="img/logo.svg" alt="">
      <h1 class="heading_text">АВТОРИЗАЦИЯ</h1>
      <div class="toolbar">
        <a href="index.html">ГЛАВНАЯ</a>
        <a href="catalog.php">КАТАЛОГ</a>
        <a href="basket.php">КОРЗИНА</a>
        <a href="reviews.php">ОТЗЫВЫ</a>        
        <a href="profile.php" class="last">ПРОФИЛЬ</a>
      </div>
    </header>

    <div id="section_auth" class="content">
    <form action="" method="POST">
      <div class="auth_block">        
        <img src="img/logo_auth.svg" alt="" />
        <p>Вход</p>
        <input
          class="input_text"
          type="text"
          name="username"
          placeholder="Введите вашу почту"
        />
        <input
          class="input_text"
          type="password"
          name="password"
          id="passwordInput"
          placeholder="Введите ваш пароль"
        />
        <span class="span_check_password">
          <input class="check_password" type="checkbox" id="showPassword" />
          <label for="showPassword">Показать пароль</label>
        </span>
        <input class="auth_btn" type="submit" name="submit" value="Войти">
        <a href="registration.php#section_registration">Зарегистрироваться</a>
      </div>
      </form>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   

  include 'config.php';

    if (!$conn)
    {
      die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }
    $login = $_POST['username'];
    $pass = $_POST['password'];    
    $query = "SELECT * FROM users WHERE user_email = '$login' AND user_password = '$pass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0)
    {
      $row = mysqli_fetch_assoc($result);
      session_start(); 
      $_SESSION['user_id'] = $row['ID'];
      header("Location: profile.php#profile_block"); 
      exit;
    }  
    else 
    {
      echo '<script>alert("Неверный логин или пароль");</script>';
    }
  mysqli_close($conn);
  }
?>
    
    <script>
      const passwordInput = document.getElementById("passwordInput");
      const showPasswordCheckbox = document.getElementById("showPassword");

      showPasswordCheckbox.addEventListener("change", function () {
        passwordInput.type = this.checked ? "text" : "password";
      });
    </script>
  </body>
</html>
