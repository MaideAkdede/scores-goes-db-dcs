<?php
setlocale(LC_TIME, "fr_BE");
define('FORMAT_DATE', strftime('%Y-%m-%d'));
define('DB_PATH', $_SERVER['DOCUMENT_ROOT'] . '/data/scores.sqlite');
define('TODAY', (\Carbon\Carbon::now('Europe/Brussels')->locale('fr_BE')->isoFormat('dddd D MMMM YYYY')));

$data = [];
$view = 'vue.php';
