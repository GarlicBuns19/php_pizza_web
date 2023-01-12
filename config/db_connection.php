<?php
// Connecting to Mysql using
// MySQLi = mysql inproved or PDO = php data object
$conn = mysqli_connect('localhost', 'pizza_manger', 'test123', 'php_pizza');

// check connection
if (!$conn) {
    echo 'Connection error:' . mysqli_connect_error();
}
?>
