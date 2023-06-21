<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>

<?php
$per_page = 5;
$page = $_GET['page'] ?: 1;
$offset = ($page - 1) * $per_page;
$last_page = 0;
$start_page = 1;
$end_page = 1;

$SQL_QUERY = 'SELECT 
                    COUNT(A.INT_NUMBER)
                FROM 
                    ' . $Tname . 'comm_member_qna A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_LEVEL=0';

$result = mysql_query($SQL_QUERY);

if (!$result) {
    error("QUERY_ERROR");
    exit;
}

$total_record = mysql_result($result, 0, 0);
$last_page = ceil($total_record / $per_page);
$start_page = max(1, $page - 2);
$end_page = min($start_page + 4, $last_page);

$SQL_QUERY =    'SELECT 
                    A.*, (SELECT COUNT(INT_NUMBER) FROM ' . $Tname . 'comm_member_qna B WHERE B.INT_IDX=A.INT_NUMBER AND B.INT_LEVEL=1) AS NUM_ANS
                FROM 
                    ' . $Tname . 'comm_member_qna A
                WHERE 
                    A.STR_USERID="' . $arr_Auth[0] . '"
                    AND A.INT_LEVEL=0
                ORDER BY A.DTM_INDATE DESC
                LIMIT ' . $per_page . '
                OFFSET ' . $offset;

$qna_list_result = mysql_query($SQL_QUERY);

if ($end_page > 0) {
    $result = '<div class="flex flex-col gap-[15px] w-full">';
    while ($row = mysql_fetch_assoc($qna_list_result)) {
        $type_name = '기타문의';

        switch ($row['INT_TYPE']) {
            case 1:
                $type_name = '교환';
                break;
            case 2:
                $type_name = '환불';
                break;
            case 3:
                $type_name = '취소(출하전 취소)';
                break;
            case 4:
                $type_name = '배송';
                break;
            case 5:
                $type_name = '불량/AS';
                break;
            case 6:
                $type_name = '주문/결제';
                break;
            case 7:
                $type_name = '상품/재입고';
                break;
            case 8:
                $type_name = '적립금';
                break;
            case 9:
                $type_name = '회원 관련';
                break;
            case 10:
                $type_name = '기타 문의';
                break;
            case 11:
                $type_name = '신고';
                break;
        }

        $result .= '
            <a href="detail.php?int_number=' . $row['INT_NUMBER'] . '" class="flex justify-between items-center gap-4 pb-[15px] border-b-[0.5px] border-[#E0E0E0]">
                <div class="flex-1 flex flex-col gap-1.5">
                    <p class="font-normal text-[10px] leading-[11px] text-[#999999]">' . date('Y.m.d', strtotime($row['DTM_INDATE'])) . '</p>
                    <p class="font-bold text-xs leading-[14px] text-[#666666]">[' . $type_name . ']</p>
                    <p class="font-bold text-xs leading-[14px] text-[#666666] line-clamp-1">' . $row['STR_TITLE'] . '</p>
                </div>
                <p class="font-bold text-xs leading-[14px] text-' . ($row['NUM_ANS'] > 0 ? 'black' : '[#999999]') . '">' . ($row['NUM_ANS'] > 0 ? '답변완료' : '답변대기') . '</p>
            </a>';
    }
    $result .= '</div>';

    // Pagination
    $result .= '
        <div class="mt-[30px] flex gap-[23px] justify-center items-center">
            <button type="button" onclick="searchQna(' . (($page - 1) < 0 ? '0' : $page - 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.7191 15.6874L6.80358 16.4055L0.682153 8.59663L6.78563 0.787764L7.7191 1.46992L2.11827 8.59663L7.7191 15.6874Z" fill="black" />
                </svg>
            </button>
            <div class="flex gap-[9.6px] items-center">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        $result .= '
            <button type="button" class="flex justify-center items-center w-[25.28px] h-[25.28px] border border-solid border-[#DDDDDD] ' . ($i == $page ? 'bg-black' : 'bg-white') . '" onclick="searchQna(' . $i . ')">
                <p class="font-bold text-xs leading-[14px] text-center ' . ($i == $page ? 'text-white' : 'text-black') . '">' . $i . '</p>
            </button>';
    }
    $result .= '
            </div>
            <button type="button" onclick="searchQna(' . (($page + 1) > $last_page ? $last_page : $page + 1) . ')">
                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.280895 15.6874L1.19642 16.4055L7.31785 8.59663L1.21437 0.787764L0.280895 1.46992L5.88173 8.59663L0.280895 15.6874Z" fill="black" />
                </svg>
            </button>
        </div>';
} else {
    $result = '
        <div class="flex flex-col gap-5 items-center pt-[55px] pb-[70px]">
            <svg width="74" height="72" viewBox="0 0 74 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M37.0326 0C16.6184 0 0 14.5353 0 32.4035C0 50.2718 16.6184 64.8071 37.0326 64.8071C40.852 64.8027 44.6525 64.2731 48.3276 63.2332L61.127 71.3804C61.4764 71.6046 61.8797 71.7306 62.2946 71.7454C62.7095 71.7602 63.1207 71.663 63.4852 71.4642C63.8496 71.2654 64.1539 70.9723 64.3661 70.6155C64.5783 70.2587 64.6907 69.8513 64.6914 69.4362V53.8593C67.5874 51.0811 69.8985 47.7517 71.4884 44.0669C73.0784 40.3822 73.9152 36.4166 73.9495 32.4035C74.0653 14.5353 57.4469 0 37.0326 0ZM60.8492 51.1745C60.6165 51.3903 60.4307 51.6516 60.3033 51.9423C60.1759 52.233 60.1096 52.5467 60.1086 52.8641V65.2237L49.9709 58.7661C49.6881 58.5874 49.3699 58.4721 49.0383 58.4281C48.7067 58.3842 48.3694 58.4126 48.0498 58.5116C44.4825 59.6195 40.7681 60.1814 37.0326 60.178C19.1644 60.178 4.62908 47.7258 4.62908 32.4035C4.62908 17.0813 19.1644 4.62908 37.0326 4.62908C54.9009 4.62908 69.4362 17.0813 69.4362 32.4035C69.3834 35.9565 68.5929 39.4598 67.1147 42.6911C65.6365 45.9224 63.5029 48.8113 60.8492 51.1745Z" fill="#D9D9D9"/>
            </svg>
            <p class="font-bold text-[15px] leading-[17px] text-[#666666]">문의 내역이 없습니다..</p>
        </div>';
}

echo $result;

?>