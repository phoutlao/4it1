<?php

// ຕົວເລກເປັນຕົວໜັງສື (ລາວ)
function LakLao($laoKip) {
    @list($laoKip, $laoK) = explode('.', $laoKip);
    $laoK = substr($laoK . '00', 0, 2);
    $laoNum = array('', 'ໜຶ່ງ', 'ສອງ', 'ສາມ', 'ສີ່', 'ຫ້າ', 'ຫົກ', 'ເຈັດ', 'ແປດ', 'ເກົ້າ');
    $unitLak = array('ກີບ', 'ສິບ', 'ຮ້ອຍ', 'ພັນ', 'ໜື່ນ', 'ແສນ', 'ລ້ານ', 'ສິບ', 'ຮ້ອຍ', 'ພັນ', 'ໜື່ນ', 'ແສນ', 'ລ້ານ');
    $unitK = array('ກີບ', 'ສິບ');
    $LAK = '';
    $j = 0;
    for ($i = strlen($laoKip) - 1; $i >= 0; $i--, $j++) {
        $num = $laoKip[$i];
        $tnum = $laoNum[$num];
        $unit = $unitLak[$j];
        switch (true) {
            case $j == 0 && $num == 1 && strlen($laoKip) > 1:
                $tnum = 'ເອັດ';
                break;
            case $j == 1 && $num == 1:
                $tnum = '';
                break;
            case $j == 1 && $num == 2:
                $tnum = 'ຊາວ';
                break;
            case $j == 6 && $num == 1 && strlen($laoKip) > 7:
                $tnum = 'ເອັດ';
                break;
            case $j == 7 && $num == 1:
                $tnum = '';
                break;
            case $j == 7 && $num == 2:
                $tnum = 'ຊາວ';
                break;
            case $j != 0 && $j != 6 && $num == 0:
                $unit = '';
                break;
        }
        $S = $tnum . $unit;
        $LAK = $S . $LAK;
    }
    if ($laoK == '00') {
        $LK = 'ຖ້ວນ';
    } else {
        $j = 0;
        $comma = ' ແລະ ສູນຈຸດ';
        $LK = '';
        for ($i = strlen($laoK) - 1; $i >= 0; $i--, $j++) {
            $num = $laoK[$i];
            $tnum = $laoNum[$num];
            $unit = $unitK[$j];
            switch (true) {
                case $j == 0 && $num == 1 && strlen($laoK) > 1:
                    $tnum = 'ເອັດ';
                    break;
                case $j == 1 && $num == 1:
                    $tnum = '';
                    break;
                case $j == 1 && $num == 2:
                    $tnum = 'ຊາວ';
                    break;
                case $j != 0 && $j != 6 && $num == 0:
                    $unit = '';
                    break;
            }
            $S = $tnum . $unit;

            $LK = $S . $LK;
        }
    }

    $numberword = str_replace("ຊາວສິບ", "ຊາວ", $LAK . @$comma . $LK);

    return $numberword;
}
