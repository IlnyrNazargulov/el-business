<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Данные пользователя</title>
    <style>
    body {
        background-color: <?php echo $_COOKIE['color'];
        ?>;
    }
    </style>
</head>
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
?>

<body>
    <div class="form">
        <?php
echo "<h2 class='formHeader'>Здравсвуйте " . $_COOKIE['nickName'] . "</h2>";
?>
        <h2 class="formHeader">Введите ваши данные</h2>
        <form method="post" action="session.php">
            <div class="formField">
                <p>Фамилия</p>
                <input type="text" name="secondName" />
            </div>
            <div class="formField">
                <p>Имя</p>
                <input type="text" name="firstName" />
            </div>
            <div class="formField">
                <p>Отчество</p>
                <input type="text" name="patronymic" />
            </div>
            <div class="formField">
                <p>Телефон</p>
                <input type="text" name="phone" placeholder="8-XXX-XXX.XX.XX." />
            </div>
            <input class="button" type="submit" name="submit" value="Ввести данные" />
            <a href='index.php'>Вернуться на главную</a>
        </form>
    </div>
</body>

</html>