<?php
$host = "localhost";
$user = "root"; // Ваше имя пользователя по умолчанию
$pass = ""; // Ваш пароль по умолчанию
$database = "gas_equipment";

// Создаем подключение
$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>
