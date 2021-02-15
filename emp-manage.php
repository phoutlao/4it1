<?php
include_once 'check-login.php';
include 'connect-db.php';
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
        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>

        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/popper.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>

        <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
        <script src="js/sweetalert.min.js" type="text/javascript"></script>

        <style>
            body{
                font-family: Phetsarath OT, Saysettha OT;
            }
        </style>
    </head>
    <body>
        <?php include_once 'menu.php'; ?>
        <div class="container-fluid" style="margin-top: 15px">
            <div class="alert alert-success alert-dismissible" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>ຈັດການຂໍ້ມູນພະນັກງານ</strong>
            </div>
            <p class="d-flex justify-content-end">
                <a href="emp-add.php" class="btn btn-info"><i class="fas fa-plus-circle"></i> ເພີ່ມຂໍ້ມູນ</a>
            </p>

            <div class="table-responsive">
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead style="background-color: beige; text-align: center">
                        <tr>
                            <th>ລະຫັດ</th>
                            <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                            <th>ເພດ</th>
                            <th>ພະແນກ</th>
                            <th>ອ໋ອບຊັນ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT e.empno, e.name, e.gender, d.name AS department FROM  emp e JOIN dept d ON e.dno = d.dno";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td style="text-align: center"><?= $row['empno'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td style="text-align: center"><?= $row['gender'] ?></td>
                                <td><?= $row['department'] ?></td>
                                <td style="width: 80px; text-align: center">
                                    <a  href="#"  onclick="viewdata(<?php echo "'" . $row['empno'] . "'"; ?>)" data-toggle="tooltip" data-placement="top" title="ລາຍລະອຽດ"> <i class="fas fa-eye"></i> </a>
                                    <a href="emp-edit.php?empno=<?= $row['empno'] ?>" data-toggle="tooltip" data-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-edit" style="color: green"></i></a>
                                    <a href="#" onclick="deletedata(<?php echo "'" . $row['empno'] . "'"; ?>)" data-toggle="tooltip" data-placement="left" title="ລືບ"><i class="fas fa-trash-alt" style="color: red"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title">ລາຍລະອຽດຂໍ້ມູນພະນັກງານ</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="employee_detail">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ປິດ</button>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });

    /*ສະແດງລາຍລະອຽດ ກົດທີ່ class="view_data"*/
    function viewdata(id) {
        $.ajax({
            url: "emp-view.php",
            method: "post",
            data: {empno: id},
            success: function(data) {

                $('#employee_detail').html(data);
                $('#myModal').modal("show");
            }
        });
    }
    /*ສິ້ນສຸດສະແດງລາຍລະອຽດ*/

    //ສ້າງຟັງຊັນແຈ້ງເຕືອນລືບຂໍ້ມູນ
    function deletedata(id) {
        swal({
            title: "ເຈົ້າຕ້ອງການລືບແທ້ ຫຼື ບໍ?",
            text: "ຂໍ້ມູນລຫັດ " + id + ", ເມື່ອລືບຈະບໍ່ສາມາດກູ້ຂໍ້ມູນຄືນໄດ້!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "emp-delete.php",
                            method: "post",
                            data: {empno: id},
                            success: function(data) {
                                swal("ຂໍ້ມູນຖືກລືບສໍາເລັດແລ້ວ!", {
                                    icon: "success"
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 2000); //2000 = 2ວິນາທີ
                            }
                        });

                    } else {
                        //swal("ຂໍ້ມູນຂອງເຈົ້າຍັງປອດໄພ!");
                    }
                });
    }


</script>


