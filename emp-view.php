<?php

include 'connect-db.php';
if (isset($_POST['empno'])) {
    $empno = $_POST['empno'];
    $output = '';
    $sql = "SELECT e.empno, e.name, e.gender, e.dateOfBirth, year(curdate())-year(e.dateOfBirth) AS age,"
            . " e.address, e.picture, d.name AS department, s.sal, e.incentive, s.sal+e.incentive AS total"
            . ", e.language FROM emp e JOIN dept d ON e.dno=d.dno JOIN salary s ON e.grade=s.grade"
            . " WHERE e.empno='$empno' ";

    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<p style="text-align: center">';
        $output .= '<img src="images/' . $row['picture'] . ' " alt="ຮູບພະນັກງານ" width="150px" height="200px"  class="img-thumbnail">';
        $output .= ' </p>';
        $output .= "<br>ລະຫັດພະນັກງານ: " . $row['empno'];
        $output .= "<br>ຊື່ ແລະ ນາມສະກຸນ: " . $row['name'];
        $output .= "<br>ເພດ: " . $row['gender'];
        $output .= "<br>ວັນ, ເດືອນ, ປີເກີດ: " . date('d / m / Y', strtotime($row['dateOfBirth']));
        $output .= "<br>ອາຍຸ: " . $row['age'] . " ປີ";
        $output .= "<br>ທີ່ຢູ່: " . $row['address'];
        $output .= "<br>ພະແນກ: " . $row['department'];
        $output .= "<br>ເງິນເດືອນ: " . number_format($row['sal']) . " ກີບ";
        $output .= "<br>ເງິນອຸດໜູນ: " . number_format($row['incentive']) . " ກີບ";
        $output .= "<br>ລາຍຮັບລວມ: " . number_format($row['total']) . " ກີບ";
        $output .= "<br>ພາສາຕ່າງປະເທດ: " . $row['language'];
    }

    echo $output;
}