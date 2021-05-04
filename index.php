<?php
require('vendor/autoload.php');

require('configs/config.php');
require('utils/dbaccess.php');

$route = require('utils/router.php');

require('./controllers/'.$route['controller-file'].'.php');

$data = call_user_func($route['callback'], getConnection());

extract($data, EXTR_OVERWRITE);

require($view);