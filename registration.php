<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Регистрация</title>
  </head>
  <body>
  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usermail = $_POST["user_email"];
    $userphone = $_POST["user_phone"];
    $username = $_POST["user_name"];
    $userpass = $_POST["user_password"];

    include 'config.php';

    // Проверка соединения
    if (!$conn) {
        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM users WHERE user_name = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Пользователь с таким именем уже зарегистрирован.");</script>';
    } else {
        $accessstatus = 0;
        $discountcard = 0;
        $query = "INSERT INTO users (user_email, user_phone, user_name, user_password, access_status, discount_card) VALUES ('$usermail', '$userphone', '$username', '$userpass', '$accessstatus', '$discountcard')";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Вы зарегистрированы");</script>';
        } else {
            echo '<script>alert("Ошибка регистрации");</script>';
        }
    }
    mysqli_close($conn);
}
?>


    <header class="header_index">
    <img src="img/logo.svg" alt="">
      <h1 class="heading_text">РЕГИСТРАЦИЯ</h1>
      <div class="toolbar">
        <a href="index.html">ГЛАВНАЯ</a>
        <a href="catalog.php">КАТАЛОГ</a>
        <a href="basket.php">КОРЗИНА</a>
        <a href="reviews.php">ОТЗЫВЫ</a>        
        <a href="profile.php" class="last">ПРОФИЛЬ</a>
      </div>
    </header>
    <form action="" method="POST">
    <div id="section_registration" class="content">
      <div class="registration_block">
        <img src="img/logo_auth.svg" alt="" />
        <p>Регистрация</p>
        
          <input class="input_text" type="text" name="user_email" placeholder="Введите вашу почту"/>
          <input class="input_text" type="text" name="user_phone" placeholder="Введите ваш номер телефона"/>
          <input class="input_text" type="text" name="user_name" placeholder="Введите ваше имя"/>
          <input class="input_text" type="password" name="user_password" placeholder="Введите ваш пароль" id="passwordInputReg"/>
          <span class="span_check_password">
          <input class="check_password" type="checkbox" id="showPasswordReg" />
          <label for="showPasswordReg">Показать пароль</label>
        </span>
          <!-- Кнопка для отправки формы -->
          <input class="registration_btn" type="submit" name="submit" value="Зарегистрироваться">
        </form>

        <span class="input_account"
          >Уже есть аккаунт?<a href="auth.php#section_auth">Войти</a></span
        >
      </div>
    </div>

    <script>
      const passwordInput = document.getElementById("passwordInputReg");
      const showPasswordCheckbox = document.getElementById("showPasswordReg");

      showPasswordCheckbox.addEventListener("change", function () {
        passwordInput.type = this.checked ? "text" : "password";
      });
    </script>
  </body>
</html>