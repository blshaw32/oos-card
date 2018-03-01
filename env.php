<?php
$user = 'root';
$password = 'root';
$db = 'card';
$host = 'localhost';
$port = 3307;

$link = mysql_connect(
    "$host:$port",
    $user,
    $password
);
$db_selected = mysql_select_db(
    $db,
    $link
);

?>