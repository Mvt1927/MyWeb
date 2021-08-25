<?php session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['burl']="/MyWeb/index/binhchon/ui/binhchon.php";
	header('Location: /MyWeb/ui/login.php');
    exit;
}
require_once("config.php");
if (!isset($_SESSION['socauhoi'])&& isset($_SESSION['array_idcauhoi'])) {
	header('Location: binhchon.php');
    exit;
}
$socauhoi = $_SESSION['socauhoi'];
$array_idcauhoi = $_SESSION['array_idcauhoi'];
echo $socauhoi;
?><br><?php
        for ($i = 1; $i < $socauhoi + 1; $i++) {
            $string_radio = "idphuongan" . $array_idcauhoi[$i];
            if (isset($_GET[$string_radio])) {
                echo " cau " . $i . " chon " . $_GET[$string_radio] . "<br>";
                $idcauhoi = $array_idcauhoi[$i];
                $idphuongan = $_GET[$string_radio];
                $sql = "UPDATE `myweb`.`phuongan` SET `solanchon` = `solanchon` + 1 WHERE (`idcauhoi` = '$idcauhoi' AND `idphuongan` = '$idphuongan');";
                if (mysqli_query($conn, $sql))
                    echo "thanh cong <br>";
                else echo "That bai! <br>";
            } else echo " cau " . $i . " chua chon ";
        }
        header('location:ketquabinhchon.php');
        ?>