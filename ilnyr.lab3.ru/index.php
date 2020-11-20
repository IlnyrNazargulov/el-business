<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Создание заявки</title>
</head>

<body>
    <?php

$successSend = false;
//поля
$firstName = "";
$secondName = "";
$patronymic = "";
$phone = "";
$hotelName = "";
$hotelImg = "";
$hotelLink = "";

//текста ошибок
$firstNameError = "";
$secondNameError = "";
$patronymicError = "";
$phoneError = "";
$hotelError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //имя
    if (empty($_POST["firstName"])) {
        $firstNameError = "Имя обязательно";
    } elseif (!preg_match("/^[а-яА-Я ]+$/u", $_POST["firstName"])) {
        $firstNameError = "Допускается только кириллица";
    } else {
        $firstName = test_input($_POST["firstName"]);
    }
    //фамилия
    if (empty($_POST["secondName"])) {
        $secondNameError = "Фамилия обязательна";
    } elseif (!preg_match("/^[а-яА-Я ]+$/u", $_POST["secondName"])) {
        $secondNameError = "Допускается только кириллица";
    } else {
        $secondName = htmlspecialchars($_POST["secondName"]);
    }
    //отчество
    if (!empty($_POST["patronymic"])) {
        if (!preg_match("/^[а-яА-Я ]+$/u", $_POST["patronymic"])) {
            $patronymicError = "Допускается только кириллица";
        } else {
            $patronymic = htmlspecialchars($_POST["patronymic"]);
        }
    }
    if (empty($_POST["phone"])) {
        $phoneError = "Телефон обязателен";
    } elseif (!preg_match("/^8-[0-9]{3}-[0-9]{3}.[0-9]{2}.[0-9]{2}.$/", $_POST["phone"])) {
        $phoneError = "Номер телефона не соответсвует маске";

    } else {
        $phone = htmlspecialchars($_POST["phone"]);
    }
    if (empty($_POST["hotel"])) {
        $hotelError = "Выбор отеля обязателен";
    } else {
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
        $hotel = test_input($_POST["hotel"]);
    }
    if (empty($firstNameError) && empty($secondNameError)
        && empty($patronymicError) && empty($phoneError)
        && empty($phoneError)) {
        $successSend = true;
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
    <div class="form">
        <h2 class="formHeader">Создать заявку на бронирование</h2>
        <form method="post" action="
    <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="formField">
                <p>Фамилия</p>
                <input type="text" name="secondName" />
                <span class="error"> * <?php echo $secondNameError; ?>
            </div>
            <div class="formField">
                <p>Имя</p>
                <input type="text" name="firstName" />
                <span class="error"> * <?php echo $firstNameError; ?>
            </div>
            <div class="formField">
                <p>Отчество</p>
                <input type="text" name="patronymic" />
                <?php echo $patronymicError; ?>
            </div>
            <div class="formField">
                <p>Телефон</p>
                <input type="text" name="phone" placeholder="8-XXX-XXX.XX.XX." />
                <span class="error"> * <?php echo $phoneError; ?>
            </div>
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
    </div>
    <?php
if ($successSend) {
    $textForFile = "Полное имя: $secondName $firstName $patronymic\nТелефон: $phone\nНазвание отеля: $hotelName\nСсылка на отель: $hotelLink";

    $file = "uploads/info.txt";
    $saved_file = fopen($file, 'w+');
    fwrite($saved_file, $textForFile);
    fclose($saved_file);

    $message = "<div class = \"successForm\">
            <h2>Заявка создана</h2>
            <p>На имя: $secondName $firstName $patronymic</p>
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