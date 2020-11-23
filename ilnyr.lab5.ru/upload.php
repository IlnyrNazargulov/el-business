<html>

<head>
    <title>Загрузка файла</title>
</head>
<style>
body {
    background: #eaede8;
    color #000000;
    background-size: 100%;
}
</style>

<body>
    <div>
        <p>
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

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
$uploadOk = 1;
$uploaderror = $_FILES["uploadFile"]["name"];
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (empty($uploaderror)) {
    echo "Файл не был выбран.";
    $uploadOk = 0;
} else {
    if (file_exists($target_file)) {
        echo "Извините, файл уже существует.";
        $uploadOk = 0;
    }

    if ($_FILES["uploadFile"]["size"] < 5242880) {
        echo "Извините, ваш файл слишком маленький.\n";
        $uploadOk = 0;
    }
    if ($_FILES["uploadFile"]["size"] > 10485760) {
        echo "Извините, ваш файл слишком большой.\n";
        $uploadOk = 0;
    }
    if ($imageFileType != "7z") {
        echo "Извините, разрешено только файлы 7z.\n";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo " <br> Ваш файл не был загружен. <br>Загрузите другой файл.";

    } else {
        if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
            echo "Файл " . basename($_FILES["uploadFile"]["name"]) . " был загружен. Можете загрузить ещё. ";
        } else {
            echo "К сожалению, произошла ошибка при загрузке файла.";
        }
    }
}
?>
        <form action="upload.php" method="post" name="upload" enctype="multipart/form-data">
            <input type="file" name="uploadFile" style="margin-bottom:20px">
            <input type="submit" value="Загрузить" name="button">
            <a href='index.php'>Вернуться к заполнению</a>
        </form>
        </p>
    </div>
</body>

</html>