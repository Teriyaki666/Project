<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>кИно</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
        }
        body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('../IMG/phone.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        opacity: 0.9;
        z-index: -1;
        background-color: rgb(3, 7, 32); /* Используем rgba для правильной установки альфа-канала цвета */
        background-blend-mode: overlay;
    }
        header {
            background-color: rgb(0,25,40);
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 6px 9px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: flex-end;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            color: white;
            background-color: black;
        }

        .logo img {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

        .hero {
            background-image: url('../IMG/bg.jpg'); /* Замените на путь к вашей картинке */
            background-size: cover;
            background-position: center;
            font-size: 40px;
            color: white;
            text-align: center;
            padding-top: 100px;
            padding-bottom: 100px;
        }

        .quote {
            padding: 60px;
            box-sizing: border-box;
            margin: 100px auto ;
            width: 70%;
            background-color: transparent;
            border-radius: 15px;
        }
        .quote p {
            text-align: right;
        }

   
        .container {
            color: white;
    width: 1000px;
    margin: 20px auto;
}

.movie {
    border-radius: 8px;
    margin: 30px;
    padding: 10px;
    background-color: transparent; /* Прозрачный фон */
    display: flex;
}

.movie img {
    width: 200px; /* Уменьшенный размер изображения */
    border-radius: 4px;
    margin-right: 10px;
}

.movie-details {
    flex-grow: 1;
    margin-left: 50px;
}

h2 {
    margin-top: 0;
    margin-bottom: 5px;
}

.sessions {
    display: flex;
    flex-wrap: nowrap;
    margin-top: 30px;
}

.session {
    text-decoration: none;
    border-radius: 8px;
    margin: 0 10px;
    padding-left: 20px;
    padding-right: 20px;
    text-align: center;
    background-color: rgb(228,26,105);
    color: white;
}
.session_div {
    margin-top: 5px;
    margin-bottom: 5px;
}

       h3 {
           margin: 10px 0;
        }


        .comments {
            text-align: center;
            margin: 20px 0;
        }

        .comment {
            width: 60%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            background-color: #fff;
        }
        .text-line {
            color: white;
            text-align: center;
            margin-top: 70px;
            margin-bottom: 70px;
        }
        .line {
            margin: 0 auto 60px;
            width: 90%;
            border-bottom: 1px solid gray;
        }
        /* Контакты */
section#contacts {
    margin-top: 170px;
    background-color: black;
    color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
}

section#contacts p {
    font-size: 16px;
    margin: 10px 0;
}

/* Ссылки на социальные сети */
section#contacts a {
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
    font-size: 24px;
}

/* Анимация при наведении на соцсети */
section#contacts a:hover {
    transform: scale(1.2);
}
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../IMG/logo.png" alt="Логотип">
        </div>
        <nav>
            <a href="index.php">Главная</a>
            <a href="profile.php">Профиль</a>
        </nav>
    </header>
    <div class="hero">
        <div class="quote">
            <h2>Ничто так не расслабляет после работы, как хороший фильм</h2>
            <p></p>
        </div>
    </div>
<h1 class="text-line">Расписание сеансов</h1>
<div class="line"></div>

<div class="container">
        <?php
            // Подключение к базе данных
            $mysqli = new mysqli("yp", "root", "", "BD");

           
         // Проверка соединения
         if ($mysqli->connect_error) {
            die("Ошибка подключения: " . $mysqli->connect_error);
        }

        // Запрос для получения списка фильмов и сеансов
        $query = "SELECT m.title AS movie_title, m.image_url, s.session_time, s.price
                  FROM Movies m 
                  LEFT JOIN Sessions s ON m.movie_id = s.movie_id
                  ORDER BY m.title, s.session_time";

        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            $currentMovie = null;

            while ($row = $result->fetch_assoc()) {
                if ($row['movie_title'] != $currentMovie) {
                    // Закрытие блока сеансов предыдущего фильма
                    if ($currentMovie !== null) {
                        echo '</div>'; // Закрытие блока .sessions
                        echo '</div>'; // Закрытие блока .movie-details
                        echo '</div>'; // Закрытие блока .movie
                    }

                    // Начало нового фильма
                    echo '<div class="movie">';
                    echo '<img src="' . $row['image_url'] . '" alt="' . $row['movie_title'] . '">';
                    echo '<div class="movie-details">';
                    echo '<h2>' . $row['movie_title'] . '</h2>';
                    // Информация о сеансах
                    echo '<div class="sessions">';
                    $currentMovie = $row['movie_title'];
                }

                // Информация о сеансе
                echo '<a href="booking.php" class="session">';
                echo '<div class="session_div">' . date('H:i', strtotime($row['session_time'])) . '</div>';
                echo '<div class="session_div">' . $row['price'] . '</div>';
                echo '</a>';
            }

            // Закрытие блока сеансов последнего фильма
            echo '</div>'; // Закрытие блока .sessions
            // Закрытие блока .movie-details
            echo '</div>';
            // Закрытие блока .movie
            echo '</div>';
        } else {
            echo "Нет доступных фильмов.";
        }

        // Закрытие соединения
        $mysqli->close();
    ?>
</div>
    <h1 class="text-line">Отзывы</h1>
    <div class="line"></div>

    <section id="comments">
    <?php
    // Вывод 5 случайных отзывов из базы данных
    $conn =  new mysqli("yp", "root", "", "BD");

    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $sql = "SELECT text, user_name FROM reviews ORDER BY RAND() LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p class='user-name'>Отзыв от " . $row["user_name"] . ":</p>";
            echo "<p class='review-text'>" . $row["text"] . "</p>";
            echo "</div>";
        }
    }

    $conn->close();
    ?>
</section>

<section id="contacts">
        <?php
        // Вывод контактной информации
        $conn =  new mysqli("yp", "root", "", "BD");

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