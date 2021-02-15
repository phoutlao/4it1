<?php
include_once 'check-login.php';
include_once 'connect-db.php';
//ຮັບຄ່າຈາກຟອມຖ້າມີການກົດປຸ່ມຊື່ btnAdd
if (isset($_POST['btnAdd'])) {
    $empno = $_POST['empno'];
    $empname = $_POST['empname'];
    $gender = $_POST['gender'];
    $date_birth = $_POST['date_birth'];
    $address = $_POST['address'];
    //ຮັບຂໍ້ມູນປະເພດໄຟລ໌
    $file_image = $_FILES['file_image']['name'];
    $file_tmp = $_FILES['file_image']['tmp_name'];

    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $incentive = str_replace(",", "", $_POST['incentive']); //ຮັບຄ່າມາແລ້ວຕັດເຄື່ອງໝາຍຈຸດອອກ
    $language = implode(",", $_POST['language']); //ລວມອາເຣໃຫ້ເປັນຂໍ້ຄວາມຂັ້ນກັນດ້ວຍເຄື່ອງໝາຍຈຸດ
    //ທົດສອບຄ່າທີ່ຮັບມາຈາກຟອມ
//    echo "1.$empno<br>2.$empname<br>3.$gender<br>4.$date_birth<br>5.$address<br>6.$file_image<br>"
//    . "7.$department<br>8.$salary<br>9.$incentive<br>10.$language";
    //ກວດສອບລະຫັດ
    $sql = "SELECT empno FROM emp WHERE empno = '$empno' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ລະຫັດຖືກນໍາໃຊ້ແລ້ວ", "warning") </script>';
    } else {
        $file_image = round(round(microtime(TRUE))) . $file_image;
        move_uploaded_file($file_tmp, "images/" . $file_image);

        $sql = "INSERT INTO emp VALUES('$empno', '$empname', '$gender', '$date_birth', '$address', "
                . " '$file_image', '$department', '$salary', '$incentive', '$language' )";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $message = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
            $empno = $empname = $gender = $date_birth = $address = $file_image = $department = $salary = $incentive = $language = "";
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
        <script src="js/jquery.priceformat.min.js" type="text/javascript"></script>
        <script src="js/sweetalert.min.js" type="text/javascript"></script>

        <style>
            body{
                font-family: Phetsarath OT, Saysettha OT;
            }
            /*ສໍາລັບອັບໂຫຼດໄຟລ໌*/
            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }

            #img-upload{
                width: 150px;
                height: 185px;
                margin-bottom: 20px;
            }
        </style>

    </head>
    <body>
        <?php include_once 'menu.php'; ?>
        <div class="container-fluid" style="margin-top: 15px">
            <?= @$message ?>
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <span class="d-flex justify-content-end">
                        <a href="emp-manage.php" class="btn btn-secondary"><i class="far fa-address-card"></i> ສະແດງຂໍ້ມູນ</a>
                    </span>
                    <div class="card" style="border-color: blue">
                        <div class="card-header bg-info text-white">
                            <h5><b>ຟອມປ້ອນຂໍ້ມູນພະນັກງານ</b></h5>
                        </div>
                        <div class="card-body" style="background-color: #e9ecef">
                            <form action="" method="post"  enctype="multipart/form-data" role="form">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- 1, ລະຫັດພະນັກງານ -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="empno">ລະຫັດພະນັກງານ</label>
                                                    <input class="form-control" type="text" id="empno" name="empno" value="<?= @$empno ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" required="">
                                                    <!--ສະແດງຂໍ້ຜິດພາດເມືອລະຫັດຖືກນໍາໃຊ້ແລ້ວ -->
                                                    <span id="availability"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- 2, ຊື່ພະນັກງານ -->
                                                <div class="form-group">
                                                    <label for="empname">ຊື່ພະນັກງານ</label>
                                                    <input class="form-control" type="text" id="empname" name="empname" value="<?= @$empname ?>" placeholder="ກະລຸນາປ້ອນຊື່ພະນັກງານ" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- 3, ເພດ -->
                                                <fieldset class="form-group">
                                                    <p>ເພດ</p>

                                                    <div class="form-check-inline">
                                                        <label  class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="gender" value="ຊ" <?php if (@$gender == "" || @$gender == "ຊ") echo 'checked'; ?>> ຊາຍ
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label  class="form-check-label">
                                                            <input type="radio" class="form-check-input"  name="gender" value="ຍ" <?php if (@$gender == "ຍ") echo 'checked'; ?>> ຍິງ
                                                        </label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <!--ວັນເດືອນປີເກີດ-->
                                            <div class="col-md-6">
                                                <div class = "form-group">
                                                    <label for = "date_birth">ວັນ, ເດືອນ, ປີເກີດ:</label>
                                                    <input type = "date" class = "form-control" id = "date_birth" name = "date_birth" value = "<?= @$date_birth ?>" required = "">
                                                </div>
                                            </div>
                                            <!--ທີ່ຢູ່-->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="address">ທີ່ຢູ່:</label>
                                                    <textarea class="form-control" id="address" name="address" rows="4"><?= @$address ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--ໃສຮູບພາບ-->
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="text-align: center">
                                                    <img id='img-upload'/>
                                                    <div id="temp_img">
                                                        <img src="images/avatar_img.png" alt="" width="150px" height="180px"/>
                                                    </div>
                                                    <!--ເລືອກຮູບພາບ-->
                                                    <br>
                                                    <div class = "input-group">
                                                        <span class = "input-group-btn">
                                                            <span class = "btn btn-info btn-file">
                                                                ເລືອກຮູບ(4x6)<input type = "file" id = "imgInp" name = "file_image"  accept = "image/*">
                                                            </span>
                                                        </span>
                                                        <input type = "text"  class = "form-control" readonly >
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ຊື່ພະແນກ -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="deparment">ພະແນກ</label>
                                                    <select class="form-control" id="deparment" name="department" required="true">
                                                        <option value="">----ເລືອກພະແນກ-----</option>
                                                        <?php
                                                        $sql = "SELECT dno, name FROM dept";
                                                        $result = mysqli_query($link, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                            <option value="<?= $row['dno'] ?>"  <?php if (@$department == $row['dno']) echo 'selected'; ?>  ><?= $row['name'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ຂັ້ນເງິນເດືອນ -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="salary">ຂັ້ນເງິນເດືອນ</label>
                                            <select class="form-control" id="salary" name="salary"  required="true">
                                                <option value="">----ເລືອກຂັ້ນເງິນເດືອນ-----</option>
                                                <?php
                                                $sql = "SELECT grade, sal FROM salary";
                                                $result = mysqli_query($link, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <option value="<?= $row['grade'] ?>"  <?php if (@$salary == $row['grade']) echo 'selected'; ?>  ><?php echo $row['grade'] . ") " . number_format($row['sal']); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- 6, ເງິນອຸດໜູນ -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="incentive">ເງິນອຸດໜູນ</label>
                                            <input class="form-control" type="text" id="incentive" name="incentive" value="<?= @$incentive ?>" placeholder="ປ້ອນເງິນອຸດໜູນ" min="0">
                                        </div>
                                    </div>
                                    <!--ພາສາຕ່າງປະເທດ -->
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <p>ພາສາຕ່າງປະເທດ</p>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="language[]" value="ອັງກິດ" <?php if (strpos(@$language, "ອັງກິດ") !== FALSE) echo 'checked'; ?> >ອັງກິດ
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="language[]" value="ຈີນ" <?php if (strpos(@$language, "ຈີນ") !== FALSE) echo 'checked'; ?> >ຈີນ
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="language[]" value="ຫວຽດນາມ" <?php if (@strpos($language, "ຫວຽດນາມ") !== FALSE) echo 'checked'; ?> >ຫວຽດນາມ
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="language[]" value="ຝຣັ່ງ" <?php if (strpos(@$language, "ຝຣັ່ງ") !== FALSE) echo 'checked'; ?> >ຝຣັ່ງ
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="language[]" value="ອື່ນໆ..." <?php if (strpos(@$language, "ອື່ນໆ...") !== FALSE) echo 'checked'; ?> >ອື່ນໆ...
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <!--ປຸ່ມຕ່າງ-->
                                    <div class="col-md-12" style="text-align: center">
                                        <input type="submit" id="btnAdd" name="btnAdd" value="ເພີ້ມຂໍ້ມູນ" class="btn btn-primary" style="width: 100px; border-radius: 20px">
                                        &nbsp;&nbsp;
                                        <input type="reset"  value="ຍົກເລີກ" class="btn btn-warning" style="width: 100px; border-radius: 20px">
                                        &nbsp;&nbsp;
                                        <button onclick="window.location.reload(true)" class="btn btn-success" style="width: 100px; border-radius: 20px;">ໂຫຼດຄືນໃໝ່</button>
                                        <p></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </body>
</html>


<script type="text/javascript">
    $(document).ready(function() {
        /*ເລືອກຮູບພາບ*/
        $('#img-upload').hide();
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
            $('#temp_img').hide(); /*ໃຫ້ເຊືອງເມືອເລືອກຮູບ*/
            $('#img-upload').show();
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                    log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
        /*ສິ້ນສຸດເລືອກຮູບ*/

        /*ແຍກຈຸດຫຼັກພັນ ....*/
        $('#incentive').priceFormat({
            prefix: '',
            thounsandsSeparator: ',',
            centsLimit: 0
        });
    });
</script>

