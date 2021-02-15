<?php include 'connect-db.php'; ?>
    <?php include_once 'menu.php';
    include_once 'laokip-read.php';
    $department = "";
    $where ="";
    if(isset($_GET['department'])){
        $department = $_GET['department'];
        $where = empty($department)? "" :"WHERE d.dno = '$department' ";
        // ຂະຫຍາຍແຖວທີ່7
        // if(empty($department)){
        //     $where = "";
        // }else {
        //     $where = "where d.dno = '$department' ";
        // }
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ລະບົບຈັດການຂໍ້ມູນພະນັກງານ</title>
        <link rel="icon" type="images/jpg" href="images/icon_logo.jpg">

        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/popper.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/sweetalert.min.js" type="text/javascript"></script>
        <style>
            body {
                font-family: "Noto Sans Lao";
            }
        </style>
    </head>

    <body>
        <div class="container-fluid" style="margin-top: 15px">
            <div class="alert alert-success alert-dismissible" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>ລາຍງານຂໍ້ມູນພະນັກງານ</strong>
            </div>
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3 offset-md-2" style="text-align:right">
                    <label for="" id="department">ເລືອກພິມລາຍງານຕາມພະແນກ</label>
                    </div>
                    <div class="col-md-4">
                    <select name="department" id="department" class="form-control" onchange="form.submit()">
                    <option value="all">---ເລືອກພະແນກ---</option>
                    <?php
                    $sql = "SELECT dno,name FROM dept ";
                    $result = mysqli_query($link , $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <option value="<?=$row['dno']?>"<?php if($row['dno'] == @$department) echo"selected";?>><?=$row['name']?></option>
                        <?php
                    }
                    ?>
                    </select>
                    </div>
                </div>
            </form>
            <p class="d-flex justify-content-end">
                <a href="emp-report-print.php?department=<?=$department?>" class="btn btn-info" target="_blank"><i class="fas fa-print"></i>ພິມລາຍງານ</a>
            </p>

            <table id="example" class="table table-hover table-bordered" style="width:100%">
                <thead style="background-color: bisque; text-align: center">
                    <tr>
                        <th>ລະຫັດ</th>
                        <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                        <th>ເພດ</th>
                        <th>ພະແນກ</th>
                        <th>ເງີນເດືອນ</th>
                        <th>ເງີນອຸດໜູນ</th>
                        <th>ລາຍຮັບທັງໝົດ</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    $sql = "SELECT e.empno, e.name, e.gender, d.name AS department, s.sal, e.incentive, s.sal + e.incentive AS total 
                    FROM emp e JOIN salary s ON e.grade = s.grade JOIN dept d ON e.dno = d.dno $where
                    ORDER BY department ASC, total DESC";
                    $result = mysqli_query($link, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        //ສະແດງຊື່ຂອງພະແນກແລະເງີນເດືອນບວກເງີນອຸດໜຸນ
                        if(strcmp($department, $row['department']) !== 0){
                            $department = $row['department'];
                            $sql1 = "SELECT sum(s.sal + e.incentive) FROM emp e JOIN dept d ON e.dno=d.dno 
                            JOIN salary s ON e.grade = s.grade WHERE d.name='$department' ";

                            $result1 = mysqli_query($link , $sql1);
                            $row1 = mysqli_fetch_array($result1);
                            echo"<tr>";
                            echo"<td colspan= '6' style='background:beige; font weight:bolder'>";
                            echo "$department: ", LakLao($row1[0]);
                            echo "</td>";
                            echo "<td style='background:beige; font-weight:bolder; text-align:right;color:blue'>";
                            echo number_format($row1[0]);
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                    <tr>
                <td class="text-center"><?= $row['empno'] ?></td>
                <td class="text-center"><?= $row['name'] ?></td>
                <td class="text-center"><?= $row['gender'] ?></td>
                <td class="text-center"><?= $row['department'] ?></td>
                <td class="text-center"><?= number_format($row['sal']) ?></td>
                <td class="text-center"><?= number_format($row['incentive']) ?></td>
                <td class="text-center"><?= number_format($row['total']) ?></td>
            </tr>
            <?php
            }
            ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
    
    