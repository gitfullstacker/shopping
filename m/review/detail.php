<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
<script language="javascript" src="js/common.js"></script>

<?php
$int_review = Fnc_Om_Conv_Default($_REQUEST['int_review'], '');

$SQL_QUERY = 'UPDATE ' . $Tname . 'comm_review SET INT_VIEW=INT_VIEW + 1 WHERE INT_NUMBER=' . $int_review;
mysql_query($SQL_QUERY);

$SQL_QUERY = 'SELECT
                    A.*,B.STR_SDATE,B.STR_EDATE,C.STR_GOODNAME,C.STR_IMAGE1 AS PRODUCT_IMAGE,C.INT_TYPE,C.INT_PRICE,D.STR_CODE AS STR_BRAND, (SELECT COUNT(E.STR_USERID) FROM ' . $Tname . 'comm_review_like AS E WHERE E.INT_REVIEW=A.INT_NUMBER) AS INT_LIKE
                FROM 
                    ' . $Tname . 'comm_review AS A
                LEFT JOIN
                    ' . $Tname . 'comm_goods_cart AS B
                ON
                    A.STR_CART=B.INT_NUMBER
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master AS C
                ON
                    A.STR_GOODCODE=C.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code AS D
                ON
                    C.INT_BRAND=D.INT_NUMBER
                WHERE
                    A.INT_NUMBER=' . $int_review;

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<!-- Body -->
<div class="main-body">
    <div class="review-detail">
        <div class="product-detail">
            <div class="image">
                <img src="/admincenter/files/good/<?= $arr_Data['PRODUCT_IMAGE'] ?>" alt="">
            </div>
            <div class="information">
                <div class="w-[25px] h-[14px] flex justify-center items-center bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                    <p class="font-normal text-[8px] leading-[8px] text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
                </div>
                <div class="brand"><?= $arr_Data['STR_BRAND'] ?></div>
                <div class="title"><?= $arr_Data['STR_GOODNAME'] ?></div>
                <div class="score"><?= str_repeat('★', $arr_Data['INT_STAR']) ?></div>
            </div>
        </div>
        <div class="spliter"></div>
        <div class="flex flex-col gap-1 items-center w-full">
            <img class="<?= $arr_Data['STR_IMAGE1'] ? 'flex' : 'hidden' ?>" src="/admincenter/files/boad/2/<?= $arr_Data['STR_IMAGE1'] ?>" alt="">
            <img class="<?= $arr_Data['STR_IMAGE2'] ? 'flex' : 'hidden' ?>" src="/admincenter/files/boad/2/<?= $arr_Data['STR_IMAGE2'] ?>" alt="">
            <img class="<?= $arr_Data['STR_IMAGE3'] ? 'flex' : 'hidden' ?>" src="/admincenter/files/boad/2/<?= $arr_Data['STR_IMAGE3'] ?>" alt="">
        </div>
        <div class="content pb-20">
            <div class="top-section">
                <div class="left-section">
                    <p class="name"><?= substr($arr_Data['STR_USERID'], 0, 3) ?>***</p>
                    <p class="date"><?= date('Y/m/d', strtotime($arr_Data['DTM_EDIT_DATE'])) ?></p>
                </div>
                <button class="like-btn" onclick="setLike(<?= $arr_Data['INT_NUMBER'] ?>)">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.00156 4.61921C0.996567 4.56168 1.00358 4.50374 1.02217 4.44907C1.04076 4.39439 1.0705 4.34418 1.10952 4.30161C1.14855 4.25904 1.19599 4.22505 1.24885 4.20179C1.3017 4.17854 1.35882 4.16652 1.41656 4.1665H2.21219C2.32269 4.1665 2.42867 4.2104 2.50681 4.28854C2.58495 4.36668 2.62885 4.47266 2.62885 4.58317V8.5415C2.62885 8.65201 2.58495 8.75799 2.50681 8.83613C2.42867 8.91427 2.32269 8.95817 2.21219 8.95817H1.76094C1.65665 8.9582 1.55615 8.91911 1.47927 8.84864C1.4024 8.77817 1.35475 8.68144 1.34573 8.57754L1.00156 4.61921ZM3.87885 4.45296C3.87885 4.27879 3.98719 4.12296 4.14448 4.04879C4.48802 3.88671 5.07323 3.56109 5.33719 3.12088C5.6774 2.55338 5.74156 1.52817 5.75198 1.29338C5.75344 1.26046 5.7526 1.22754 5.75698 1.19504C5.81344 0.788169 6.59865 1.26338 6.89969 1.76588C7.06323 2.03838 7.08406 2.3965 7.06698 2.67629C7.04844 2.97546 6.96073 3.26442 6.87469 3.5515L6.69135 4.16338H8.95323C9.0176 4.16337 9.08111 4.17829 9.13875 4.20695C9.1964 4.23561 9.24662 4.27723 9.28547 4.32856C9.32433 4.37989 9.35076 4.43953 9.3627 4.50279C9.37463 4.56605 9.37175 4.63121 9.35427 4.69317L8.23552 8.65484C8.21082 8.74221 8.15826 8.81913 8.08583 8.87388C8.0134 8.92864 7.92507 8.95823 7.83427 8.95817H4.29552C4.18501 8.95817 4.07903 8.91427 4.00089 8.83613C3.92275 8.75799 3.87885 8.65201 3.87885 8.5415V4.45296Z" stroke="#666666" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span id="like_count_<?= $arr_Data['INT_NUMBER'] ?>"><?= $arr_Data['INT_LIKE'] ?></span>
                </button>
            </div>
            <p class="description"><?= strip_tags($arr_Data['STR_CONTENT']) ?></p>
        </div>
    </div>
</div>