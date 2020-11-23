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
if (isset($_POST["submit_exit"])) {
    session_unset();
    session_destroy();
}
if (!isset($_SESSION['firstName']) && !isset($_SESSION["secondName"]) &&
    !isset($_SESSION['patronymic']) && !isset($_SESSION["phone"])) {
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>Session error</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        background-color: <?php echo $_COOKIE['color'];
        ?>;
    }
    </style>
</head>

<body>
    <div class="form">
        <p class="formField">Сессия пуста</p><br>
        <a class="formField" href="/">Вернуться на главную страницу</a>
    </div>
</body>

</html>
<?php
session_start();
    session_unset();
    session_destroy();
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Страница с данными пользователя</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        background-color: <?php echo $_COOKIE['color'];
        ?>;
    }
    </style>
</head>

<body>
    <div class="form">
        <?php
echo "<h2 class='formHeader'>Здравсвуйте " . $_COOKIE['nickName'] . "</h2>";
?>
        <p class="formField">Данные из массива сессии о пользователе:</p>
        <p class="formField">ФИО:
            <?php echo $_SESSION['secondName'] . ' ' . $_SESSION['firstName'] . ' ' . $_SESSION['patronymic']; ?>
        </p>
        <p class="formField">Номер телефона: <?php echo $_SESSION['phone']; ?> </p>
        <form class="formField" action="booking.php" method="GET">
            <input type="submit" name="booking" value="Создать заявку на бронирование">
        </form>
        <form class="formField" action="page.php" method="POST">
            <input type="submit" name="submit_exit" value="Удалить данные сессии">
        </form>
        <a class="formField" href='index.php'>Вернуться на главную</a>
    </div>
</body>

</html>