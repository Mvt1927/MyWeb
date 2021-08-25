<?php
session_start();
$_SESSION['burl'] = "";
$socauhoi = 0;
if (isset($_SESSION['socauhoi'])) {
    $socauhoi = $_SESSION['socauhoi'];
}
$array_idcauhoi = array();
if (isset($_SESSION['array_idcauhoi'])) {
    $array_idcauhoi = $_SESSION['array_idcauhoi'];
} 
if (!isset($_SESSION['username'])||$_SESSION['username']=="") {
    $_SESSION['burl'] = "/MyWeb/index/binhchon/ui/ketquabinhchon.php";
    $name = "<a href='/MyWeb/ui/login.php'>Đăng Nhập</a>";
} else {
    $user_or_email = $_SESSION['username'];
    require_once("config.php");
    $sql = "SELECT `name` FROM `myweb`.`member` where `user`= '$user_or_email' or `email` = '$user_or_email';";
    $rs = mysqli_query($conn, $sql);
    $kq = mysqli_fetch_array($rs);
    $name=$kq['name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans" rel="stylesheet">
    <link rel="stylesheet" href="../css/binhchon.css">
    <title>Document</title>
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
            <?php
            require_once("config.php");
            $sql = "select * from binhchon where idbinhchon=1";
            $kq = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($kq)
            ?>
            <h1 class="ten_binh_chon"><?php echo $row['tenbinhchon']; ?></h1><br>
            <?php for ($i = 1; $i < $socauhoi + 1; $i++) {
                $idcauhoi = $array_idcauhoi[$i]; ?>
                <center>
                    <table width="450" border="1" cellpadding="4" style="border-collapse:collapse; ">
                        <?php
                        $sql = "select * from cauhoi where idcauhoi=$idcauhoi";
                        $kq = mysqli_query($conn, $sql);
                        if ($d = mysqli_fetch_array($kq)) {
                            $mota = $d["motacauhoi"];
                        }
                        $sql = "select sum(solanchon) from phuongan where idbinhchon=1 and idcauhoi=$idcauhoi";
                        $kq = mysqli_query($conn, $sql);
                        if ($d = mysqli_fetch_array($kq))
                            $tongsobinhchon = $d["sum(solanchon)"];
                        ?>
                        <tr>
                            <td colspan="3" bgcolor="#66CCFF" align="center"><?php echo $mota; ?></td>
                        </tr>
                        <?php
                        $sql = "select * from phuongan where idbinhchon=1 and idcauhoi=$idcauhoi";
                        $kq = mysqli_query($conn, $sql);
                        while ($d = mysqli_fetch_array($kq)) {
                            $rong = ($d["solanchon"] / $tongsobinhchon) * 150;
                            $phantram = ($d["solanchon"] / $tongsobinhchon) * 100;
                        ?>
                            <tr>
                                <td width="150"><?php echo $d["motaphuongan"]; ?></td>
                                <td width="150">
                                    <table width="150">
                                        <tr>
                                            <td width="<?php echo $rong; ?>" bgcolor="#FF0000"></td>
                                            <td><?php echo round($phantram, 2); ?>%</td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="150">Số lần chọn: <?php echo $d["solanchon"]; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Tổng số lần chọn: <?php echo $tongsobinhchon; ?></td>
                        </tr>
                    </table>
                </center>
                <br><br>
            <?php } ?>
        </div>
    </div>
    <script src="../js/binhchon.js"></script>
</body>

</html>