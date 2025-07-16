<?php

// Instead of 'localhost' try:
//$db_host = "localhost";
$db_host ="localhost";
$db_user ="root";
$db_password ="";
$db_name ="users";

try {

    $db = new PDO("mysql:host={$db_host};db_name={$db_name}", $db_user,$db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";


}
catch(PDOException $e) {
    echo $e->getMessage();
    echo "Connection failed: " . $e->getMessage();
}


?>
