<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?

$page = $_GET['page'];

$SQL_QUERY = "SELECT 
A.*,
(SELECT B.STR_BCODE FROM " . $Tname . "comm_goods_master_category B WHERE A.STR_GOODCODE=B.STR_GOODCODE LIMIT 1) AS STR_BCODE,
(SELECT IFNULL(COUNT(Z.STR_USERID),0) AS CNT FROM " . $Tname . "comm_member_like Z WHERE Z.STR_GOODCODE=A.STR_GOODCODE) AS LIKECNT, 
(SELECT IFNULL(COUNT(D.STR_USERID),0) AS CNT FROM " . $Tname . "comm_goods_cart D WHERE D.STR_GOODCODE=A.STR_GOODCODE AND D.STR_USERID='" . $arr_Auth[0] . "' AND D.INT_STATE IN ('4')) AS CARTCNT,
E.STR_CODE
FROM 
" . $Tname . "comm_goods_master A
LEFT JOIN
" . $Tname . "comm_com_code E
ON
A.INT_BRAND=E.INT_NUMBER
WHERE 
A.STR_GOODCODE IS NOT NULL 
AND 
(A.STR_SERVICE='Y' OR A.STR_SERVICE='R') 
AND 
A.STR_MMYN='Y' 
ORDER BY 
A.INT_SORT DESC 
LIMIT 16
OFFSET " . $page;

$arr_Data = mysql_query($SQL_QUERY);
$arr_Data_Cnt = mysql_num_rows($arr_Data);

$result = '';
for ($int_J = 0; $int_J < $arr_Data_Cnt; $int_J++) {
    $result .= '
        <a href="detail/index.php" class="global-product-item">
            <div class="relative flex justify-center items-center w-[176px] h-[176px] p-2.5 bg-[#F9F9F9] rounded-md">
                <img class="w-full" src="/admincenter/files/good/' . mysql_result($arr_Data, $int_J, str_image1) . '" alt="rent">
                <div class="absolute top-2 left-2 w-[25px] h-[25px] flex justify-center items-center bg-[#00402F]">
                    <p class="font-extrabold text-[9px] leading-[10px] text-white">20%</p>
                </div>
            </div>
            <p class="brand w-full">' . mysql_result($arr_Data, $int_J, str_code) . '</p>
            <p class="title w-full">' . mysql_result($arr_Data, $int_J, str_goodname) . '</p>
            <div class="price-section w-full">
                <p class="current-price">일 ' . number_format(mysql_result($arr_Data, $int_J, int_price)) . '원</p>
                <p class="origin-price">' . number_format(mysql_result($arr_Data, $int_J, int_price)) . '원</p>
            </div>
        </a>
    ';
}

echo $result;

?>