<?php
require('vendor/autoload.php');

require('configs/config.php');
require('utils/dbaccess.php');
require('utils/standings.php');

require('./controllers/page.php');
require('./controllers/team.php');
require('./controllers/match.php');


$pdo = getConnection();

$route = require('utils/router.php');

//require('./controllers/' . $route['controller-file'] . '.php');

$data = call_user_func($route['callback'], $pdo);

extract($data, EXTR_OVERWRITE);

require('views/' . $view);