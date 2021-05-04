<?php

$routes = require('./configs/routes.php');

$method = $_SERVER['REQUEST_METHOD']; // return GET ou POST
$methodName = '_'.$method; //return _GET ou _POST
$action = $$methodName['action'] ?? '';
$resource = $$methodName['resource'] ?? '';

$route = array_filter($routes, function ($r) use ($method, $action, $resource){
    return $r['method'] === $method
        && $r['action'] === $action
        && $r['resource'] === $resource;
});

if(!$route){
    header('Location : index.php');
    exit();
}

return reset($route);