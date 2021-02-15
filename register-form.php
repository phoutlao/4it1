



<?php
session_start();
include_once 'connect-db.php';

if (isset($_POST['btnRegister'])) {
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conpassword = $_POST['conpassword'];

//    echo "1 $name 2 $tel 3 $username 4 $password 5 $conpassword";

    $sql = "SELECT * FROM user WHERE username = 'username' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $error_username = "ບັນຊີເຂົ້າໃຊ້ຖືກນຳໃຊ້ແລ້ວ";
    }

    if ($password !== $conpassword) {
        $error_password = "ລະຫັດຜ່ານ ແລະ ລະຫັດຢືນຢັນບໍ່ກົງກັນ";
    }
    
    if(empty($error_username)&&empty($error_password)){
        $password = md5($password);
       $sql = "INSERT INTO user VALUES('', '$name', '$tel', '$username', '$password')";
        $result = mysqli_query($link, $sql);
        if ($result) {
            // sarng session
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header("Location: profile.php");
        }else{
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
            <br>
            <form id=registration_form class="form-horizontal"  action="" method="POST">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <h5 style="text-align: center; color: blue; font-weight: bold">ລົງທະບຽນຜູ້ເຂົ້າໃຊ້ໃໝ່</h5>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="name">ຊື່</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control"  name="name" value="<?php $username?>" placeholder="ກະລຸນາປ້ອນຊື່ຂອງທ່ານ" required  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!--ສະແດງ error name -->
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="tel">ເບີໂທລະສັບ</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-phone"></i></div>
                                <input type="tel" class="form-control"  name="tel" value="<?php $tel?>" placeholder="ກະລຸນາປ້ອນເບີຕິດຕໍ່" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!--ສະແດງ error telphone -->
                            </span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="username">ບັນຊີເຂົ້າໃຊ້</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                                <input class="form-control" type="text"  name="username" value="" placeholder="ກະລຸນາປ້ອນບັນຊີເຂົ້າໃຊ້" required  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!--  <!--ສະແດງ ບັນຊີເຂົ້າໃຊ້ບໍ່ຖືກຕ້ອງ  -->
                                
<?php= @$error_username?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="password">ລະຫັດຜ່ານ</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-danger">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                                <input type="password"class="form-control"  name="password"   placeholder="ປ້ອນລະຫັດຜ່ານ" required  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!-- ລະຫັດບໍ່ກົງກັນ  -->
<?php= @$error_password?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 field-label-responsive">
                        <label for="conpassword">ຢືນຢັນລະຫັດຜ່ານ</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                <div class="input-group-addon" style="width: 2.6rem">
                                    <i class="fa fa-key"></i><i class="fa fa-key"></i>
                                </div>
                                <input type="password" class="form-control"  name="conpassword" placeholder="ປ້ອນລະຫັດຜ່ານຄືນອີກຄັ້ງ" required  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!-- ລະຫັດບໍ່ກົງກັນ  -->
                                <span id="error_conpassword"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="margin-left: 40px">
                        <button type="submit" id="btnRegister" name="btnRegister" class="btn btn-success"><i class="fa fa-user-plus"></i> ລົງທະບຽນ</button>
                        &nbsp;
                        <button type="reset" id="reset_form" class="btn btn-danger"><i class="fas fa-ban"></i> ຍົກເລີກ</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
