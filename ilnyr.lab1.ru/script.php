<?php

$fullName=$_POST['fullName'];
$email=$_POST['email'];
$cardNumber=$_POST['cardNumber'];
$cvc=$_POST['cvc'];
$hotel=$_POST['hotel'];
$stars=$_POST['stars'];
$nightNumber=$_POST['nightNumber'];
$additions=!empty($_POST['additions']) ? $_POST['additions'] : null;

if (empty($fullName)
    or empty($email)
    or empty($cardNumber)
    or empty($cvc)
    or empty($hotel)
    or empty($nightNumber)) {
    header('Location: error_page.html');
}

switch ($hotel) {
    case 'hotel1':
        $hotelName='Antusa Design Hotel & Spa';
        $hotelImg='hotel1.jpg';
        $hotelLink='https://www.tripadvisor.ru/Hotel_Review-g293974-d18845927-Reviews-Antusa_Design_Hotel_Spa-Istanbul.html';
        break;
    case 'hotel2':
        $hotelName='Boss Hotel Sultanahmet';
        $hotelImg='hotel2.jpg';
        $hotelLink='https://www.booking.com/hotel/tr/boss-sultanahmet.ru.html';
        break;
    case 'hotel3':
        $hotelName='Apple Tree Hotel';
        $hotelImg='hotel3.jpg';
        $hotelLink='https://www.booking.com/hotel/tr/apple-tree-istanbul.ru.html';
        break;
    case 'hotel4':
        $hotelName='Glamour Hotel Istanbul Sirkeci';
        $hotelImg='hotel4.jpg';
        $hotelLink='https://www.booking.com/hotel/tr/glamour.ru.html';
        break;
    case 'hotel5':
        $hotelName='Dosso Dossi Hotels & Spa Downtown';
        $hotelImg='hotel5.jpg';
        $hotelLink='https://www.booking.com/hotel/tr/dosso-dossi-hotels-downtown.ru.html';
        break;
}

$totalSumma = 1000 * $stars * $nightNumber;
$greeting = "Здравсвуйте <b>$fullName</b>. 
    На ваш email <b>$email</b> выслана смс с кодом подверждения.";
$cardInfo = "С вашей <b>$cardNumber</b> карты списано: <b>$totalSumma</b>.
    <br>Данная сумма высчитана по формуле $nightNumber(кол дней) * $stars(звезд) * 1000.";

$additionsCount = count($additions);

$additionalInfo = "";

for ($i=0; $i < $additionsCount; $i++) {
    if ($additions[$i]=='add1') {
        $additionalInfo=$additionalInfo.'<p>Вы сможете посетить все спа процедуры выбранного отеля.</p>';
    }
    if ($additions[$i]=='add2') {
        $additionalInfo=$additionalInfo.'<p>Каждый день вы обеспечены лучшим завтраком.</p>';
    }
    if ($additions[$i]=='add3') {
        $additionalInfo=$additionalInfo.'<p>Вам доступен обед на котором вас ждут лучшие блюда с всего мира.</p>';
    }
    if ($additions[$i]=='add4') {
        $additionalInfo=$additionalInfo.'<p>В вашу бронь будет включен ужин.</p>';
    }
}

$result="<html> <html lang='ru'> 
            <head>
                <meta charset='UTF-8'>
                <title>Бронирование прошло успешно</title>
                <link rel='stylesheet' type='text/css' href='booking_style.css' />
            </head>
            <body>
            <div class='defaultElement'>
            <p>$greeting</p>
            <p>$cardInfo</p>
            </div>
            <div class='defaultElement'>
                <p>Вы выбрали $hotelName.</p>
                <p>Фотография вашего отеля</p>
                <img src='img/$hotelImg' alt=''>
                <a href='$hotelLink'>Ссылка на ваш отель</a>
            </div>
            <div class='defaultElement'>
            <p>Информация по доп услугам:</p>
            $additionalInfo
            </div>
            </body>
            </html>";
echo $result;
