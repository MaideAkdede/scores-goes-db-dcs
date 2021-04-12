<?php
function getConnection():PDO
{
    try {
        $connection = new PDO('sqlite:' . DB_PATH);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    return $connection;
}
