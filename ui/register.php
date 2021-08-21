<?php
session_start();
$_SESSION['temp_name_register'] = "";
$_SESSION['temp_user_register'] = "";
$_SESSION['temp_email_register'] = "";
$_SESSION['temp_pass_register'] = "";
$_SESSION['temp_repass_register'] = "";
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
    <link href="../css/register.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Login</title>
</head>

<body>
    <?php
    require_once('../vendor/google/recaptcha/src/autoload.php');
    require_once("../login/config.php");
    $siteKey = '';
    $secret = '';
    $noti = "";
    $snoti = "";
    $np = "";
    $nu = "";
    $nrp = "";
    $nn = "";
    $ne = "";
    if ($siteKey == '' && is_readable('../login/config.php')) {
        $config = include '../login/config.php';
        $siteKey = $config['v2']['site'];
        $secret = $config['v2']['secret'];
    }
    if (isset($_POST["submit"])) {
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        }
        $name = $_POST["name"];
        $user = $_POST["user"];
        $password = $_POST["password"];
        $repassword = $_POST["repassword"];
        $email = $_POST["email"];
        $name = strip_tags($name);
        $name = addslashes($name);
        $user = strip_tags($user);
        $user = addslashes($user);
        $password = strip_tags($password);
        $password = addslashes($password);
        $repassword = strip_tags($repassword);
        $repassword = addslashes($repassword);
        $email = strip_tags($email);
        $email = addslashes($email);
        $_SESSION['temp_name_register'] = $name;
        $_SESSION['temp_user_register'] = $user;
        $_SESSION['temp_email_register'] = $email;
        $_SESSION['temp_pass_register'] = $password;
        $_SESSION['temp_repass_register'] = $repassword;
        if ($name == "") {
            $noti = "Your name cannot be blank!";
            $nn = "error";
            $snoti = "noti";
        } else {
            if ($user == "") {
                $_SESSION['temp_user_register'] = $user;
                $noti = "Your username cannot be blank!";
                $nu = "error";
                $snoti = "noti";
            } else {
                if ($email == "") {
                    $noti = "Your email cannot be blank!";
                    $ne = "error";
                    $snoti = "noti";
                } else {
                    if ($password == "") {
                        $noti = "Your password cannot be blank!";
                        $np = "error";
                        $snoti = "noti";
                    } else {
                        if ($repassword == "") {
                            $noti = "Re-enter password you cannot leave it blank!";
                            $nrp = "error";
                            $snoti = "noti";
                        } else {
                            if ($repassword != $password) {
                                $_SESSION['temp_repass_register'] = "";
                                $noti = "Re-enter password and password do not match!";
                                $nrp = "error";
                                $np = "error";
                                $snoti = "noti";
                            } else {
                                if (!$captcha) {
                                    $noti = "Please confirm captcha!";
                                    $snoti = "noti";
                                } elseif ($resp->isSuccess()) {
                                    $sql = "SELECT * FROM member WHERE user ='$user'";
                                    $query = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($query) == 0) {
                                        $sql = "SELECT * FROM member WHERE email ='$email'";
                                        $query = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($query) == 0) {
                                            $sql = "INSERT INTO `myweb`.`member` (`name`, `user`, `email`, `pass`) VALUES ('$name', '$user','$email', '$password');";
                                            $query = mysqli_query($conn, $sql);
                                            $_SESSION['temppass'] = $password;
                                            $_SESSION['tempuser'] = $user;
                                            header('location:login.php');
                                        } else {
                                            $noti = "Email already used";
                                            $ne = "error";
                                            $_SESSION['temp_pass_register'] = "";
                                            $_SESSION['temp_repass_register'] = "";
                                            $snoti = "noti";
                                        }
                                    } else {
                                        $noti = "Username already used";
                                        $nu = "error";
                                        $_SESSION['temp_pass_register'] = "";
                                        $_SESSION['temp_repass_register'] = "";
                                        $snoti = "noti";
                                    }
                                } else {
                                    $errors = $resp->getErrorCodes();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    ?>

    <div id="khung_ngoai" class="khung_ngoai <?php echo $snoti ?>">
        <div class="khung_sign">
            <div class="khung_singup">
                <h4 class="text signup">Sign up</h4>
            </div>
            <div class="khung_singin">
                <button id="btn_signin" class="btn_singin" onclick="location.href='login.php'">
                    Sign in
                </button>
            </div>
        </div>
        <form id="login_form" action="register.php" method="POST">
            <div class="khung_name">
                <p id="label_name" class="<?php echo $nn ?>">Your name</p>
                <input id="input_name" name="name" class="input <?php echo $nn ?>" placeholder="Your name" type="name" value="<?php if (isset($_SESSION['temp_name_register'])) {
                                                                                                                                    echo $_SESSION['temp_name_register'];
                                                                                                                                } ?>">
            </div>
            <div class="khung_user">
                <p id="label_user" class="<?php echo $nu ?>">Your user name</p>
                <input id="input_user" name="user" class="input <?php echo $nu ?>" placeholder="User name" type="user" value="<?php if (isset($_SESSION['temp_user_register'])) {
                                                                                                                                    echo $_SESSION['temp_user_register'];
                                                                                                                                } ?>">
            </div>
            <div class="khung_email">
                <p id="label_email" class="<?php echo $ne ?>">Your email</p>
                <input id="input_email" name="email" class="input <?php echo $ne ?>" placeholder="Your email" type="email" value="<?php if (isset($_SESSION['temp_email_register'])) {
                                                                                                                                        echo $_SESSION['temp_email_register'];
                                                                                                                                    } ?>">
            </div>
            <div class="khung_pass">
                <p id="label_pass" class=" <?php echo $np ?>">Your password</p>
                <input id="input_pass" name="password" class="input <?php echo $np ?>" placeholder="******" type="password" value="<?php if (isset($_SESSION['temp_pass_register'])) {
                                                                                                                                        echo $_SESSION['temp_pass_register'];
                                                                                                                                    } ?>">
            </div>
            <div class="khung_repass">
                <p id="label_repass" class=" <?php echo $nrp ?>">Re-enter your password</p>
                <input id="input_repass" name="repassword" class="input <?php echo $nrp ?>" placeholder="******" type="password" value="<?php if (isset($_SESSION['temp_repass_register'])) {
                                                                                                                                            echo $_SESSION['temp_repass_register'];
                                                                                                                                        } ?>">
            </div>
            <div id="g-recaptcha" class="g-recaptcha" data-sitekey="<?php echo $siteKey ?>"></div>
            <div class="khung_register">
                <button type="submit" name="submit" id="btn_register" class="btn_register">Register Now</button>
            </div>
        </form>
        <div class="khung_noti error">
            <p id="label_noti_error"><?php echo $noti ?></p>
        </div>
    </div>
    <script src="../js/register.js"></script>
</body>

</html>