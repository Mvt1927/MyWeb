<?php
session_start();
$_SESSION['burl'] = "";
$_SESSION['socauhoi'] = "";
$_SESSION['array_idcauhoi'] = array();
if (!isset($_SESSION['username'])||$_SESSION['username']=="") {
    $_SESSION['burl'] = "/MyWeb/index/binhchon/ui/binhchon.php";
    header('Location: /MyWeb/ui/login.php');
    exit;
}
$user_or_email = $_SESSION['username'];
require_once("config.php");
$sql = "SELECT `name` FROM `myweb`.`member` where `user`= '$user_or_email' or `email` = '$user_or_email';";
$rs = mysqli_query($conn, $sql);
$kq = mysqli_fetch_array($rs);
$name="dangnhap";
if (isset($kq['name'])) {
    $name = $kq['name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans" rel="stylesheet">
    <link rel="stylesheet" href="../css/binhchon.css">
    <title>Binh Chon</title>
</head>

<body>
    <header>
        <div class="thanh_tren">
            <div class="btn-menu">
                <div class="container" id="container">
                    <span class="span_menu" onclick="Menu()">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </span>
                </div>
            </div>
            <div class="khung_logo">
                <center>
                    <img src="../img/logoWhite.png" class="logo">
                </center>
            </div>
            <div class="khung_user">
                <center>
                    <p class="user"><?php echo $name?></p>
                </center>
            </div>
        </div>
    </header>
    <div id="khung_menu" class="khung_menu">
        <div id="menu" class="menu"></div>
    </div>
    <div id="khung_body" class="khung_body">
        <div class="body">
            <form id="form1" name="form1" method="get" action="xulybinhchon.php">
                <?php
                require_once("config.php");
                $sql = "select * from binhchon where idbinhchon=1";
                $kq = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($kq)
                ?>
                <h1 class="ten_binh_chon"><?php echo $row['tenbinhchon']; ?></h1><br>
                <?php
                $sql = "select * from cauhoi where idbinhchon=1";
                $kq1 = mysqli_query($conn, $sql);
                $i = 0;
                $idcauhoi = 0;
                while ($row = mysqli_fetch_array($kq1)) {
                    $i++
                ?>
                    <h2 class="cau_hoi"><?php echo $i . ". " . $row['motacauhoi']; ?></h2>
                    <div class="khung_phuong_an">
                        <?php $idcauhoi = $row['idcauhoi'];
                        $sql = "select * from `myweb`.phuongan where idbinhchon=1 and idcauhoi = $idcauhoi";
                        $array_idcauhoi[$i] = $idcauhoi;
                        $kq2 = mysqli_query($conn, $sql);
                        if ($kq2) {
                            while ($row2 = mysqli_fetch_array($kq2)) {
                        ?><label>
                                    <input id="radio" type="radio" value="<?php echo $row2['idphuongan']; ?>" name="idphuongan<?php echo $idcauhoi ?>">
                                    <?php echo $row2["motaphuongan"] ?><br><br>
                                </label>
                        <?php }
                        }
                        ?>
                    </div>
                    <br><?php }
                    $_SESSION['socauhoi'] = $i;
                    $_SESSION['array_idcauhoi'] = $array_idcauhoi ?>
                <div class="khung_btn_save">
                    <center>
                        <button type="submit" name="submit" id="btn_save" class="btn_save">Xem kết quả</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/binhchon.js"></script>
</body>

</html>