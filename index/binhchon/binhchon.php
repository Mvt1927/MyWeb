<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>BÌNH CHỌN</p>
    <div id="binhchon">
        <form id="form1" name="form1" method="get" action="xulybinhchon.php"><?php
                    require_once("./config.php");
                    $s="select * from binhchon where idbinhchon=1";
                    $kq=mysqli_query($conn,$s);
                    $row=mysqli_fetch_array($kq)
                ?>
            <?php echo $row['motarutgon'];?><br />
            <p>
            <?php
                    $s="select * from phuongan where idbinhchon=1";
                    $kq=mysqli_query($conn,$s);
                    $i=0;
                    while($row=mysqli_fetch_array($kq))
                    {
                ?>
                <label>
                    <input id="radio" type="radio" value="<?php echo $row['idphuongan'];?>" name="idphuongan"
                        <?php if($i==0) {echo" checked='checked' "; $i++;} ?> />
                </label>
                <?php echo $row['mota'];?><br /><?php }?></p>
            <p>
                <label>
                    <input id="button" type="submit" value="Xem kết quả" name="Submit" />
                </label>
            </p>
        </form>
    </div>


</body>

</html>
