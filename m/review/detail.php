<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />
<script language="javascript" src="js/common.js"></script>

<?php
$bd_seq = Fnc_Om_Conv_Default($_REQUEST['bd_seq'], '');

$SQL_QUERY = 'UPDATE `' . $Tname . 'b_bd_data@01` SET BD_VIEW_CNT=BD_VIEW_CNT + 1 WHERE BD_SEQ=' . $bd_seq;
mysql_query($SQL_QUERY);

$SQL_QUERY =    'SELECT 
                    A.BD_SEQ,
                    A.CONF_SEQ,
                    A.MEM_ID,
                    A.BD_CONT,
                    A.BD_REG_DATE,
                    A.BD_ITEM2,
                    IFNULL(B.IMG_F_NAME, "") AS IMG_F_NAME,
                    C.STR_GOODNAME,
                    C.STR_IMAGE1,
                    C.INT_DISCOUNT,
                    C.INT_PRICE,
                    C.INT_TYPE,
                    D.STR_CODE,
                    (SELECT COUNT(STR_USERID) FROM `' . $Tname . 'comm_review_like` A1 WHERE A1.BD_SEQ=A.BD_SEQ) AS COUNT_LIKE
                FROM 
                    `' . $Tname . 'b_bd_data@01` A
                LEFT JOIN
                    `' . $Tname . 'b_img_data@01` B
                ON
                    A.CONF_SEQ=B.CONF_SEQ
                    AND
                    A.BD_SEQ=B.BD_SEQ
                    AND
                    B.IMG_ALIGN=1
                LEFT JOIN
                    ' . $Tname . 'comm_goods_master C
                ON
                    A.BD_ITEM1=C.STR_GOODCODE
                LEFT JOIN
                    ' . $Tname . 'comm_com_code D
                ON
                    C.INT_BRAND=D.INT_NUMBER
                WHERE 
                    A.BD_SEQ=' . $bd_seq;

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
                <img src="/admincenter/files/good/<?= $arr_Data['STR_IMAGE1'] ?>" onerror="this.style.display = 'none'" alt="">
            </div>
            <div class="information">
                <div class="w-[25px] h-[14px] flex justify-center items-center bg-[<?= ($arr_Data['INT_TYPE'] == 1 ? '#EEAC4C' : ($arr_Data['INT_TYPE'] == 2 ? '#00402F' : '#7E6B5A'))  ?>]">
                    <p class="font-normal text-[8px] leading-[8px] text-white"><?= ($arr_Data['INT_TYPE'] == 1 ? '구독' : ($arr_Data['INT_TYPE'] == 2 ? '렌트' : '빈티지'))  ?></p>
                </div>
                <div class="brand"><?= $arr_Data['STR_CODE'] ?></div>
                <div class="title"><?= $arr_Data['STR_GOODNAME'] ?></div>
                <div class="score"><?= str_repeat('★', $arr_Data['BD_ITEM2']) ?></div>
            </div>
        </div>
        <div class="spliter"></div>
        <div class="flex flex-col gap-1 items-center w-full">
            <?php
            $SQL_QUERY =    'SELECT 
                                IFNULL(B.IMG_F_NAME, "") AS IMG_F_NAME
                            FROM 
                                `' . $Tname . 'b_bd_data@01` A
                            LEFT JOIN
                                `' . $Tname . 'b_img_data@01` B
                            ON
                                A.CONF_SEQ=B.CONF_SEQ
                                AND
                                A.BD_SEQ=B.BD_SEQ
                            WHERE 
                                A.BD_SEQ=' . $bd_seq;

            $review_img_list_result = mysql_query($SQL_QUERY);

            while ($row = mysql_fetch_assoc($review_img_list_result)) {
            ?>
                <img class="w-full" src="/admincenter/files/boad/2/<?= $row['IMG_F_NAME'] ?>" onerror="this.style.display = 'none'" alt="">
            <?php
            }
            ?>
        </div>
        <div class="content pb-20">
            <div class="top-section">
                <div class="left-section">
                    <p class="name"><?= substr($arr_Data['MEM_ID'], 0, 3) ?>***</p>
                    <p class="date"><?= date('Y/m/d', strtotime($arr_Data['BD_REG_DATE'])) ?></p>
                </div>
                <button class="like-btn" onclick="setLike(<?= $arr_Data['BD_SEQ'] ?>)">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.00156 4.61921C0.996567 4.56168 1.00358 4.50374 1.02217 4.44907C1.04076 4.39439 1.0705 4.34418 1.10952 4.30161C1.14855 4.25904 1.19599 4.22505 1.24885 4.20179C1.3017 4.17854 1.35882 4.16652 1.41656 4.1665H2.21219C2.32269 4.1665 2.42867 4.2104 2.50681 4.28854C2.58495 4.36668 2.62885 4.47266 2.62885 4.58317V8.5415C2.62885 8.65201 2.58495 8.75799 2.50681 8.83613C2.42867 8.91427 2.32269 8.95817 2.21219 8.95817H1.76094C1.65665 8.9582 1.55615 8.91911 1.47927 8.84864C1.4024 8.77817 1.35475 8.68144 1.34573 8.57754L1.00156 4.61921ZM3.87885 4.45296C3.87885 4.27879 3.98719 4.12296 4.14448 4.04879C4.48802 3.88671 5.07323 3.56109 5.33719 3.12088C5.6774 2.55338 5.74156 1.52817 5.75198 1.29338C5.75344 1.26046 5.7526 1.22754 5.75698 1.19504C5.81344 0.788169 6.59865 1.26338 6.89969 1.76588C7.06323 2.03838 7.08406 2.3965 7.06698 2.67629C7.04844 2.97546 6.96073 3.26442 6.87469 3.5515L6.69135 4.16338H8.95323C9.0176 4.16337 9.08111 4.17829 9.13875 4.20695C9.1964 4.23561 9.24662 4.27723 9.28547 4.32856C9.32433 4.37989 9.35076 4.43953 9.3627 4.50279C9.37463 4.56605 9.37175 4.63121 9.35427 4.69317L8.23552 8.65484C8.21082 8.74221 8.15826 8.81913 8.08583 8.87388C8.0134 8.92864 7.92507 8.95823 7.83427 8.95817H4.29552C4.18501 8.95817 4.07903 8.91427 4.00089 8.83613C3.92275 8.75799 3.87885 8.65201 3.87885 8.5415V4.45296Z" stroke="#666666" stroke-width="0.833333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span id="like_count_<?= $arr_Data['BD_SEQ'] ?>"><?= $arr_Data['COUNT_LIKE'] ?></span>
                </button>
            </div>
            <p class="description"><?= strip_tags($arr_Data['BD_CONT']) ?></p>
        </div>
    </div>
</div>