<?php
setlocale(LC_TIME, "fr_BE");
define('TODAY', strftime('%e %B %G'));
define('FORMAT_DATE', strftime('%Y-%m-%d'));
define('DB_PATH', $_SERVER['DOCUMENT_ROOT'] . '/data/scores.sqlite');
