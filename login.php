<?php
session_start(); // Начало сессии

if (isset($_SESSION['user_id'])) {
    // Если пользователь уже авторизован, перенаправляем на главную страницу
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка формы после отправки
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подключение к базе данных (замените данными для вашей БД)
    $servername = "yp";
    $db_username = "root";
    $db_password = "";
    $dbname = "BD";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Запрос к базе данных для проверки логина и пароля
    $sql = "SELECT user_id, email, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Пароль верный, устанавливаем сессию и перенаправляем на главную страницу
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: profile.php");
            exit;
        } else {
            $error = "Неверный пароль";
        }
    } else {
        $error = "Пользователь не найден";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
<header>
<?php
        // Подключение к базе данных
        $servername = "yp";
        $username = "root";
        $password = "";
        $dbname = "BD";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $conn->connect_error);
        }
        $conn->close();
        ?>
        <div class="logo">
            <img src="../IMG/logo.png" alt="Логотип">
        </div>
        <nav>
            <a href="index.php">Главная</a>
            <a href="profile.php">Профиль</a>
        </nav>
    </header>
    <h1 class="text-line">Авторизация</h1>
    <div class="line"></div>
    <!-- Форма для ввода логина и пароля -->
    <form method="post">
        <label for="email">Почта:</label>
        <input type="text" name="email" id="username" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Войти</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <!-- Ссылка для регистрации, если нужно -->
    <p>Еще не зарегистрированы? <a href="registration.php">Зарегистрируйтесь</a></p>

    <section id="contacts">
        <?php
        // Вывод контактной информации
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $conn->connect_error);
        }

        $sql = "SELECT address, work_hours, phone, email, social_media_links FROM contacts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p>Адрес: " . $row["address"] . "</p>";
            echo "<p>Режим работы: " . $row["work_hours"] . "</p>";
            echo "<p>Телефон: " . $row["phone"] . "</p>";
            echo "<p>E-mail: " . $row["email"] . "</p>";
            echo "<p>Ссылки на социальные сети: " . $row["social_media_links"] . "</p>";
        }

        $conn->close();
        ?>
    </section>
</body>
</html>