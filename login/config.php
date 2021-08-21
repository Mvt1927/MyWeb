<?php
$hostname = 'localhost:3306';
$username = 'root';
$password = '1927';
$dbname = "myweb";
$cookie_name = 'siteAuth';
$cookie_time = (3600);
if (!$conn = mysqli_connect($hostname, $username, $password, $dbname)) {
    die('cannot connect');
    exit();
}
return [
    'v3' => [
      'site' => 'Your_site_key',
      'secret' => 'Your_secret_key',
    ],
    'v2' =>[
      'site' => 'Your_site_key',
      'secret' => 'Your_secret_key',
    ]
  ];
?>
