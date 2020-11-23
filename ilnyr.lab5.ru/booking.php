<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Создание заявки</title>
    <style>
    body {
        background-color: <?php echo $_COOKIE['color'];
        ?>;
    }
    </style>
</head>

<body>
    <?php
session_start();
$actual_link = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']
. explode('?', $_SERVER['REQUEST_URI'], 2)[0];
if (isset($_SESSION['statistic'])) {
    $statistic = $_SESSION['statistic'];
    if (array_key_exists($actual_link, $statistic)) {
        $statistic[$actual_link] = $statistic[$actual_link] + 1;
    } else {
        $statistic[$actual_link] = 1;
    }
    $_SESSION['statistic'] = $statistic;
} else {
    $statistic = array();
    $statistic[$actual_link] = 1;
    $_SESSION['statistic'] = $statistic;
}
$hotelName = "";
$hotelImg = "";
$hotelLink = "";
$successSend = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST["hotel"]) {
        case 'hotel1':
            $hotelName = 'Antusa Design Hotel & Spa';
            $hotelImg = 'hotel1.jpg';
            $hotelLink = 'https://www.tripadvisor.ru/Hotel_Review-g293974-d18845927-Reviews-Antusa_Design_Hotel_Spa-Istanbul.html';
            break;
        case 'hotel2':
            $hotelName = 'Boss Hotel Sultanahmet';
            $hotelImg = 'hotel2.jpg';
            $hotelLink = 'https://www.booking.com/hotel/tr/boss-sultanahmet.ru.html';
            break;
        case 'hotel3':
            $hotelName = 'Apple Tree Hotel';
            $hotelImg = 'hotel3.jpg';
            $hotelLink = 'https://www.booking.com/hotel/tr/apple-tree-istanbul.ru.html';
            break;
        case 'hotel4':
            $hotelName = 'Glamour Hotel Istanbul Sirkeci';
            $hotelImg = 'hotel4.jpg';
            $hotelLink = 'https://www.booking.com/hotel/tr/glamour.ru.html';
            break;
        case 'hotel5':
            $hotelName = 'Dosso Dossi Hotels & Spa Downtown';
            $hotelImg = 'hotel5.jpg';
            $hotelLink = 'https://www.booking.com/hotel/tr/dosso-dossi-hotels-downtown.ru.html';
            break;
    }
    $successSend = true;
}
?>
    <div class="form">
        <h2 class="formHeader">Создать заявку на бронирование</h2>
        <form method="post" action="
    <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="formField">
                <p>Отель</p>
                <select name="hotel">
                    <option value="hotel1">Antusa Design Hotel & Spa</option>
                    <option value="hotel2">Boss Hotel Sultanahmet</option>
                    <option value="hotel3">Apple Tree Hotel</option>
                    <option value="hotel4">Glamour Hotel Istanbul Sirkeci</option>
                    <option value="hotel5">Dosso Dossi Hotels & Spa Downtown</option>
                </select>
            </div>
            <input class="button" type="submit" name="submit" value="Отправить" />
        </form>

        <form method="post" action="upload.php" name="upload" enctype="multipart/form-data">
            <div class="formField">
                <p>Укажите файл для загрузки</p>
            </div>
            <input class="button" type="file" name="uploadFile">
            <br>
            <input class="button" type="submit" value="Загрузить">
        </form>
        <a class="formField" href='index.php'>Вернуться на главную</a>

    </div>
    <?php
if ($successSend) {
    $fullName = $_SESSION['secondName'] . ' ' . $_SESSION['firstName'] . ' ' . $_SESSION['patronymic'];
    $phone = $_SESSION['phone'];
    $textForFile = "Полное имя: $fullName\nТелефон: $phone\nНазвание отеля: $hotelName\nСсылка на отель: $hotelLink";

    $file = "uploads/info.txt";
    $saved_file = fopen($file, 'w+');
    fwrite($saved_file, $textForFile);
    fclose($saved_file);

    $message = "<div class = \"successForm\">
            <h2>Заявка создана</h2>
            <p>На имя: $fullName</p>
            <p>Номер телефона: $phone</p>
            <p>Отель: $hotelName</p>
            <p>Фотография вашего отеля</p>
            <img src='img/$hotelImg' alt=''>
            <a href='$hotelLink'>Ссылка на ваш отель</a>
            <a href=\"text-to-file.php?text=$textForFile\">Загрузить информацию в файл</a>
            </div>";
    echo $message;
}
?>
</body>


</html>