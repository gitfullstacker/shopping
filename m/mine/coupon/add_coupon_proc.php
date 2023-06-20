<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?php
$str_num = Fnc_Om_Conv_Default($_REQUEST['str_num'], "");

$SQL_QUERY =    'SELECT 
                    A.*
                FROM 
                    ' . $Tname . 'comm_stamp_prod A
                WHERE 
                    A.STR_NUM="' . $str_num . '"';

$result = mysql_query($SQL_QUERY);
$coupon_info = mysql_fetch_assoc($result);

if ($coupon_info) {
    $SQL_QUERY =    'SELECT 
                        COUNT(A.INT_NUMBER) AS COUPON_NUM
                    FROM 
                        ' . $Tname . 'comm_member_stamp A
                    WHERE 
                        A.INT_STAMP=' . $coupon_info['INT_PROD'] . '
                        AND A.STR_USERID="' . $arr_Auth[0] . '"';

    $result = mysql_query($SQL_QUERY);
    $member_coupon = mysql_fetch_assoc($result);

    if ($member_coupon['COUPON_NUM'] > 0) {
?>
        <script>
            alert('이미 받은 쿠폰입니다.');
            document.location.href = 'index.php';
        </script>
    <?php
    } else {
        $SQL_QUERY = 'INSERT INTO `' . $Tname . 'comm_member_stamp` (STR_USERID, INT_STAMP, DTM_INDATE, DTM_SDATE, DTM_EDATE) VALUES ("' . $arr_Auth[0] . '", ' . $coupon_info['INT_PROD'] . ', "' . date("Y-m-d H:i:s") . '", "' . date("Y-m-d H:i:s") . '", "' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+' . $coupon_info['INT_MONTHS'] . ' months')) . '") ';
        mysql_query($SQL_QUERY);

    ?>
        <script>
            alert('해당 쿠폰을 발급받았습니다.');
            document.location.href = 'index.php';
        </script>
    <?php
    }
} else {
    ?>
    <script>
        alert('해당 쿠폰이 존재하지 않습니다.');
        document.location.href = 'index.php';
    </script>
<?php
}
?>