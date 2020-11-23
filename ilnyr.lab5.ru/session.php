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

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$firstName = test_input($_POST["firstName"]);
$secondName = test_input($_POST["secondName"]);
$patronymic = test_input($_POST["patronymic"]);
$phone = test_input($_POST["phone"]);
if (empty($firstName) || empty($secondName) || empty($patronymic) || empty($phone)) {
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>Error</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        background-color: <?php echo $_COOKIE['color'];
        ?>;
    }
    </style>
</head>

<body>
    <div>
        <div class="form">
            <p class="formField">Одно из полей не заполнено</p>
            <a class="formField" href="/session-data.php">Назад к заполнению</a>
        </div>
    </div>
</body>

</html>
<?php
exit;
} else {
    $_SESSION['firstName'] = $firstName;
    $_SESSION['secondName'] = $secondName;
    $_SESSION['patronymic'] = $patronymic;
    $_SESSION['phone'] = $phone;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Успешный вход</title>
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
        <p class="formField">Данные записаны в сессионный массив</p>
        <a class="formField" href="/page.php">Перейти на страницу с бронированием</a>
        <br>
        <a class="formField" href='/index.php'>Вернуться на главную</a>
    </div>
</body>

</html>