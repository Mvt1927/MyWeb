<?php
$hostname = 'localhost:3306';
$username = 'root';
$password = '1927';
$dbname = "binhchon";
$cookie_name = 'siteAuth';
$cookie_time = (3600 * 24 * 30);
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (mysqli_connect_errno()!==0) {
    die('cannot connect');
    exit();
}
?>
