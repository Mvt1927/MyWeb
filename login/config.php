<?php
$hostname = 'localhost:<Your_sql_post>';
$username = 'Your_sql_user';
$password = 'Your_sql_pass';
$dbname = "Your_database_name";
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
