<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Вход</title>
    <style>
    body {
        background-color: <?php echo $_COOKIE['color'];
        ?>;
    }
    </style>
</head>
<?php

if (isset($_POST["entry"])) {
    setcookie('nickName', $_POST["nickName"]);
    setcookie('color', $_POST["color"]);
    header('Location: session-data.php');
}

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
        <h2 class="formHeader">Вход</h2>
        <form method="post" action="index.php">
            <div class="formField">
                <p>Ваш никнейм</p>
                <input type="text" name="nickName" />
            </div>
            <div class="formField">
                <p>Ваш любимый цвет</p>
                <select name="color">
                    <option value="darkgray">Серый</option>
                    <option value="beige">Бежевый</option>
                    <option value="deepskyblue">Бирюзовый</option>
                    <option value="seagreen">Зеленый</option>
                    <option value="gold">Золотой</option>
                </select>
            </div>
            <input class="button" type="submit" name="entry" value="Войти" />
        </form>
    </div>
    <div class="history">
        <p>История ваших посещений</p>
        <?php
foreach ($_SESSION['statistic'] as $item => $item_count) {
    echo "<p>URL: " . $item . ", Количество раз: " . $item_count . "</p>";
}
?>
    </div>
</body>

</html>