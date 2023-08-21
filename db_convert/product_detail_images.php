<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
// Set a higher maximum execution time (e.g., 600 seconds)
set_time_limit(60000);

$SQL_QUERY =    'SELECT 
                    A.*
                FROM 
                    `' . $Tname . 'comm_goods_master` A
                WHERE 
                    A.STR_CONTENTS LIKE \'%http://ablanccompany.cafe24.com%\'';

$good_list_result = mysql_query($SQL_QUERY);

while ($row = mysql_fetch_assoc($good_list_result)) {
    $SQL_QUERY = 'UPDATE ' . $Tname . 'comm_goods_master SET STR_CONTENTS=REPLACE(STR_CONTENTS, \'http://ablanccompany.cafe24.com\', \'https://ablanc.co.kr\') WHERE STR_GOODCODE=\'' . $row['STR_GOODCODE'] . '\'';
    mysql_query($SQL_QUERY);
}

echo "Image converted successfully!";
?>