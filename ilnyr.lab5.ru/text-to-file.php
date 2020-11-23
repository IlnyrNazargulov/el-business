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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $textForFile = $_GET["text"];
    $file = "uploads/info.txt";
    $saved_file = fopen($file, 'w+');
    fwrite($saved_file, $textForFile);
    fclose($saved_file);

    $perms = '<p class="formField">Права на файл ' . $file . ': ' . fileperms($file) . '</p>';

    $result = "<html> <html lang='ru'>
            <head>
                <meta charset='UTF-8'>
                <title>Файл успешно сохранен</title>
                <link rel=\"stylesheet\" href=\"style.css\">
                <style>
                body {
                    background-color:" . $_COOKIE['color'] . ";

                }
                </style>
            </head>
            <body>
                <div class=\"result\">
                    <p class='formField'>Скачать файл можно по ссылке</p>
                    <a class='formField' href='download.php'>Файл</a>
                    $perms
                    <a class='formField' href='index.php'>Вернуться к заполнению</a>
                </div>
            </div>
            </body>
            </html>";
    echo $result;
}