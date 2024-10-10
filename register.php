<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = ""; // Пароль для базы данных (по умолчанию пустой для локальных серверов)
$dbname = "users_db";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных с формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Проверка на совпадение паролей
    if ($password === $confirm_password) {
        // Хеширование пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL-запрос для вставки данных
        $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            header("Location: login.html"); // Редирект на страницу входа
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Passwords do not match.";
    }
}

$conn->close();
?>
