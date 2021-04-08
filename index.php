<?php
define('FILE_PATH', 'data/matches.csv');
$matches = [];

$handle = fopen(FILE_PATH, 'r');
$header = fgetcsv($handle, 1000);
while ($line = fgetcsv($handle, 1000)){
    $matches[] = array_combine($header, $line);
}

require('views/vue.php');