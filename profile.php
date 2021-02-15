<?php
session_start();
include_once 'connect-db.php';
//ຮັບຄ່າຈາກຟອມເມື່ອກົດປຸ່ມ btnRegister
if (isset($_POST['btnRegister'])){
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];
    
//    echo "1 $name 2 $tel 3 $username 4 $password 5 $conpassword";
    //ກວດສອບບັນຊີເຂົ້າໃຊ້
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0){
        $error_username = "ບັນຊີເຂົ້າໃຊ້ຖືກນຳໃຊ້ແລ້ວ";
    }
    //ລະຫັດຜ່ານ ແລະ ລະຫັດຢືນຢັນກົງກັນ ຫຼື ບໍ່
    if($password!==$conpassword){
        $error_password = "ລະຫັດຜ່ານ ແລະ ລະຫັດຜ່ານຢືນຢັນ ບໍ່ກົງກັນ";
    }
     //ເພີ່ມຂໍ້ມູນລົງຖານຂໍ້ມູນ
     if (empty($error_username) && empty($error_password)){
         $password = md5($password);
         $sql = "INSERT INTO user VALUES('', '$name', '$tel', '$username', '$password')";
         $result = mysqli_query($link, $sql);
         if ($result){
             //ສ້າງ session 
             $_SESSION['username'] = $username;
             $_SESSION['password'] = $password;
             header("Location: profile.php");
         } else {
            echo mysqli_error($link);
         }
     }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ລະບົບຈັດການຂໍ້ມູນພະນັກງານ</title>
        <link rel="icon" type="image/jpg" href="images/icon_logo.jpg">
        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/popper.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>

        <style>
            body{
                font-family: Phetsarath OT, Saysettha OT;
                /*
                background: url(images/brackground.jpg);
                */
                background: ghostwhite;
                background-size: cover;
            }

            @media(min-width: 768px) {
                .field-label-responsive {
                    padding-top: .5rem;
                    text-align: right;
                }
            }
        </style>

    </head>
    <body>
        <?php include 'menu.php'; ?>
        <div class="container-fluid">
            <?php
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM user WHERE username ='$username' " ;
            $result = mysqli_query ($link, $sql);
            $row = mysqli_fetch_array($result);
            
            echo "<h4>ສະບາຍດີ $row[1] </h4>";
            ?>
        </div>
        
</body>

</html>