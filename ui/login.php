<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Login</title>
</head>
<body>
    <?php
    require_once('../vendor/google/recaptcha/src/autoload.php');
    require_once("../config.php");
    $siteKey = '';
    $secret = '';
    $_SESSION['temppass2'] = "";
    $_SESSION['tempuser2'] = "";
    $noti = "";
    $snoti = "";
    $np = "";
    $nu = "";
    if ($siteKey == '' && is_readable('../config.php')) {
        $config = include '../config.php';
        $siteKey = $config['v2']['site'];
        $secret = $config['v2']['secret'];
    }
    if (!empty($_SESSION['username'])) {
        if (isset($_SESSION['password'])) {
            $usr = $_SESSION['username'];
            $hash = $_SESSION['password'];
            $sql = "SELECT * FROM member WHERE user ='$usr' AND pass='$hash'";
            $query1 = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query1) > 0) {
                if (isset($_SESSION['burl'])) {
                    header('location:'.$_SESSION['burl']);
                }
                header('location:index.php');
            }
        }
    }
    if (isset($_POST["submit"])) {
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        }
        $user = $_POST["user"];
        $password = $_POST["password"];
        $user = strip_tags($user);
        $user = addslashes($user);
        $password = strip_tags($password);
        $password = addslashes($password);
        $a_check = ((isset($_POST['checkbox']) != 0) ? 1 : "");
        if ($a_check == 1) {
            $_SESSION['a_check'] = "checked";
        } else {
            $_SESSION['a_check'] = "";
        };
        if ($user == "") {
            $_SESSION['tempuser'] = $user;
            $noti = "Your username cannot be blank!";
            $nu = "error";
            $snoti = "noti";
        } else {
            $_SESSION['tempuser'] = $user;
            if ($password == "") {
                $noti = "Your password cannot be blank!";
                $np = "error";
                $snoti = "noti";
            } else {
                if (!$captcha) {
                    $noti = "Please confirm captcha!";
                    $snoti = "noti";
                } elseif ($resp->isSuccess()) {
                    $sql = "SELECT * FROM `myweb`.`member` WHERE `user` ='$user' or `email` ='$user'  AND `pass`='$password'";
                    $query = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($query) == 0) {
                        $_SESSION['temppass'] = "";
                        $noti = "Username or password is incorrect!";
                        $snoti = "noti";
                    } else {
                        $f_user = $user;
                        $f_pass = $password;
                        if ($a_check == 1) {
                            setcookie($cookie_name, 'usr=' . $f_user . '&hash=' . $f_pass, time() + $cookie_time);
                            $_SESSION['password'] = $password;
                        } else $_SESSION['password'] = "";
                        $noti = "";
                        $snoti = "";
                        $_SESSION['username'] = $user;
                        if ($_SESSION['burl']!="") {
                            header('location:'.$_SESSION['burl']);
                            exit;
                        }
                        header('Location: index.php');
                        exit;
                    }
                } else {
                    $errors = $resp->getErrorCodes();
                }
            }
        }
    }
    ?>
    <div id="khung_ngoai" class="khung_ngoai <?php echo "$snoti " ?>">
        <div class="khung_sign">
            <div class="khung_singin">
                <h4 class="text signin">Sign in</h4>
            </div>
            <div class="khung_singup">
                <button id="btn_signup" class="btn_singup" onclick="location.href='register.php'">
                    Sign up
                </button>
            </div>
        </div>
        <form id="login_form" action="login.php" method="POST">
            <div class="khung_user">
                <p id="label_user" class="<?php echo $nu ?>">Your user name or email</p>
                <input id="input_user" name="user" class="input <?php echo $nu ?>" placeholder="User name or email" type="user" value="<?php if (isset($_SESSION['tempuser'])) { echo $_SESSION['tempuser']; }  ?>">
            </div>
            <div class="khung_pass">
                <p id="label_pass" class="label_pass <?php echo $np ?>">Your password</p>
                <a id="text_forgot" class="text forgot" href="#">Forgot?</a>
                <input id="input_pass" name="password" class="input <?php echo $np ?>" placeholder="******" type="password" value="<?php if (isset($_SESSION['temppass'])) { echo $_SESSION['temppass'];} ?>">
            </div>
            <div class="khung_check_save">
                <label class="khung_label_save">
                    <input name="checkbox" id="checkbox" type="checkbox" <?php if (isset($_SESSION['a_check'])) { echo $_SESSION['a_check'];}?>>
                    Save password
                </label>
            </div>
            <div id="g-recaptcha" class="g-recaptcha" data-sitekey="<?php echo $siteKey ?>"></div>
            <div class="khung_login">
                <button type="submit" name="submit" id="btn_login" class="btn_login">
                    Login
                </button>
            </div>
        </form>
        <div id="khung_noti" class="khung_noti error">
            <p id="label_noti_error"><?php echo $noti ?></p>
        </div>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>