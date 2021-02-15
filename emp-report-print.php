<?php include 'connect-db.php'; ?>
    <?php include_once 'check-login.php';
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
            table {
                border:collapse;
                    
            }
            td,th{
                border:1px #000 solid;
                height: 35px;
            }
        </style>
    </head>

    <body onload="window.print()">
      
        <div class="contrainer" >
            <div style="text-align: center;">
                <img src="images/meow.jpg" width="200px" alt="logo"><br>
    ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>
    ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ<br>
    -------------<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>-------------
    </div>
    <div class="row">
    <div class="col-md-8">
    ຊື່ບໍລິສັດ...............<br>
    ທີ່ຢູ່..................<br>
    ເບີໂທ.................<br>
    </div>
    <div class="col-md-4">
     ເລກທີ......./...........................<br>
     ທີ່ ນະຄອນຫຼວງວຽງຈັນ, ວັນທີ..................<br>
    </div>
    </div>
            <table  style="width:100%" >
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
            <div class="row">
                <div class="col-md-4" style="text-align: center; font-weight: bold">ລາຍເຊັນ1</div>
                <div class="col-md-4" style="text-align: center; font-weight: bold">ລາຍເຊັນ2</div>
                <div class="col-md-4" style="text-align: center; font-weight: bold">ລາຍເຊັນ3</div>
                
                
                
            </div>
            
            
        </div>
    </body>
    </html>
    
    