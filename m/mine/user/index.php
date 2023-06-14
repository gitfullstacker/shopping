<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
fnc_MLogin_Chk();
?>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php";
?>

<?
$SQL_QUERY =	" SELECT
					UR.*
				FROM "
	. $Tname . "comm_member AS UR
				WHERE
					UR.STR_USERID='$arr_Auth[0]' ";

$arr_Rlt_Data = mysql_query($SQL_QUERY);

if (!$arr_Rlt_Data) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
?>

<div class="flex flex-col w-full">
	<!-- 상단정보 -->
	<div class="flex flex-col bg-[#F5F5F5]">
		<div class="flex gap-[15px] px-[14px] py-[21px] border-b border-[#E0E0E0]">
			<div class="flex justify-center items-center w-[60px] h-[60px] bg-[#D9D9D9] rounded-full">
				<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13 13C11.2125 13 9.68229 12.3635 8.40938 11.0906C7.13646 9.81771 6.5 8.2875 6.5 6.5C6.5 4.7125 7.13646 3.18229 8.40938 1.90938C9.68229 0.636459 11.2125 0 13 0C14.7875 0 16.3177 0.636459 17.5906 1.90938C18.8635 3.18229 19.5 4.7125 19.5 6.5C19.5 8.2875 18.8635 9.81771 17.5906 11.0906C16.3177 12.3635 14.7875 13 13 13ZM0 26V21.45C0 20.5292 0.23725 19.6825 0.71175 18.9101C1.18517 18.1388 1.81458 17.55 2.6 17.1438C4.27917 16.3042 5.98542 15.6742 7.71875 15.2539C9.45208 14.8346 11.2125 14.625 13 14.625C14.7875 14.625 16.5479 14.8346 18.2812 15.2539C20.0146 15.6742 21.7208 16.3042 23.4 17.1438C24.1854 17.55 24.8148 18.1388 25.2882 18.9101C25.7628 19.6825 26 20.5292 26 21.45V26H0Z" fill="white" />
				</svg>
			</div>
			<div class="grow flex flex-col gap-[5px] items-start justify-center">
				<p class="font-extrabold text-lg leading-5 text-black"><b><?= $arr_Data['STR_NAME'] ?></b> 님</p>
				<p class="font-bold text-xs leading-[14px] text-black"><?= $arr_Data['STR_USERID'] ?></p>
			</div>
			<div class="flex flex-col gap-[5px]">
				<a href="/m/memberjoin/logout.php" class="flex justify-center items-center w-16 h-[29px] bg-white border border-solid border-[#DDDDDD] rounded-full">
					<p class="font-medium text-xs leading-[14px] flex items-center text-center text-[#666666]">로그아웃</p>
				</a>
				<a href="grade.php" class="flex justify-center items-center w-16 h-[29px] bg-white border border-solid border-[#DDDDDD] rounded-full">
					<p class="font-medium text-xs leading-[14px] flex items-center text-center text-[#666666]">등급혜택</p>
				</a>
			</div>
		</div>
		<div class="flex px-[14px] py-[15px] border-b border-[#E0E0E0]">
			<p class="font-semibold text-xs leading-[14px] text-[#666666]"><?= $arr_Auth[10] == 'B' ? '[BLACK]: 블랙 등급 혜택 제공' : '[GREEN]: 그린 등급 혜택 제공' ?></p>
		</div>
		<div class="grid grid-cols-2 divide-x divide-[#E0E0E0] border-b border-[#E0E0E0]">
			<div class="flex flex-col gap-[5px] px-[14px] py-[19px]">
				<p class="font-semibold text-xs leading-[14px] text-[#666666]">나의 적립금</p>
				<p class="font-extrabold text-lg leading-5 text-black"><?= number_format($arr_Data['INT_MILEAGE']) ?></p>
			</div>
			<div class="flex flex-col gap-[5px] px-[14px] py-[19px]">
				<?php
				$SQL_QUERY =    'SELECT
									COUNT(A.INT_NUMBER) AS NUM
								FROM 
									' . $Tname . 'comm_member_stamp A
								WHERE 
									A.STR_USED="N"
									AND A.STR_USERID="' . $arr_Auth[0] . '"
									AND A.DTM_SDATE <= "' . date("Y-m-d H:i:s") . '"
									AND A.DTM_EDATE >= "' . date("Y-m-d H:i:s") . '"';

				$arr_Rlt_Data = mysql_query($SQL_QUERY);
				$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
				?>
				<p class="font-semibold text-xs leading-[14px] text-[#666666]">사용가능한 쿠폰</p>
				<p class="font-extrabold text-lg leading-5 text-black"><?= $arr_Data['NUM'] ?></p>
			</div>
		</div>
	</div>

	<!-- 주문/배송현황 -->
	<div class="mt-[30px] flex flex-col gap-[14px] px-[14px]">
		<p class="font-extrabold text-lg leading-5 text-black">주문/배송현황</p>
		<div class="flex flex-row items-center justify-between bg-[#F5F5F5] px-4 py-3">
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=1
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">주문접수</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=2
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">상품준비</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=3
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">배송중</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=4
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">배송완료</p>
            </div>
            <div>
                <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345622 0.0593668 0.207373 0.1781C0.0691242 0.296834 -4.76837e-07 0.435356 -4.76837e-07 0.593668C-4.76837e-07 0.751979 0.0691242 0.890501 0.207373 1.00923L4.27189 4.5L0.207373 7.99077C0.078341 8.10158 0.0138245 8.23805 0.0138245 8.40016C0.0138245 8.56259 0.0829487 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
                </svg>
            </div>
            <div class="flex flex-col gap-[5px] items-center">
                <?php
                $SQL_QUERY =    'SELECT
                                    COUNT(A.INT_NUMBER) AS NUM
                                FROM 
                                    ' . $Tname . 'comm_goods_cart A
                                WHERE 
                                    A.INT_STATE=10
                                    AND A.STR_USERID="' . $arr_Auth[0] . '"';

                $arr_Rlt_Data = mysql_query($SQL_QUERY);

                if (!$arr_Rlt_Data) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                $arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
                ?>
                <p class="font-bold text-[25px] leading-7 text-center text-black"><?= $arr_Data['NUM'] ?></p>
                <p class="font-semibold text-xs leading-[14px] text-center text-[#666666]">반납</p>
            </div>
        </div>
	</div>

	<!-- 구분 -->
	<hr class="mt-[30px] mb-[15px] border-t border-[#E0E0E0]" />

	<!-- 쇼핑 정보 -->
	<div class="flex flex-col px-[14px] w-full">
		<p class="font-extrabold text-lg leading-5 text-black">쇼핑 정보</p>
		<hr class="mt-[14px] border-t-[0.5px] border-[#E0E0E0]" />
		<!-- 렌트/구매 내역 -->
		<a href="/m/mine/order/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">렌트/구매 내역</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 멤버십 관리 -->
		<a href="/m/mine/membership/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">멤버십 관리</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 에이블랑 결제관리 -->
		<a href="/m/mine/payment/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">에이블랑 결제관리</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
	</div>

	<!-- 구분 -->
	<hr class="mt-[30px] mb-[15px] border-t border-[#E0E0E0]" />

	<!-- 관심 정보 -->
	<div class="flex flex-col px-[14px] w-full">
		<p class="font-extrabold text-lg leading-5 text-black">관심 정보</p>
		<hr class="mt-[14px] border-t-[0.5px] border-[#E0E0E0]" />
		<!-- 입고 알림 내역/찜한 상품 -->
		<a href="/m/mine/favorite/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">입고 알림 내역/찜한 상품</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 최근 본 상품 -->
		<a href="/m/mine/seen/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">최근 본 상품</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
	</div>

	<!-- 구분 -->
	<hr class="mt-[30px] mb-[15px] border-t border-[#E0E0E0]" />

	<!-- 회원 정보 -->
	<div class="flex flex-col px-[14px] w-full">
		<p class="font-extrabold text-lg leading-5 text-black">회원 정보</p>
		<hr class="mt-[14px] border-t-[0.5px] border-[#E0E0E0]" />
		<!-- 회원정보 수정 -->
		<a href="/m/memberjoin/edit.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">회원정보 수정</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 나의 리뷰 -->
		<a href="/m/mine/review/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">나의 리뷰</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 적립금 현황 -->
		<a href="/m/mine/reserve/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">적립금 현황</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 쿠폰 현황 -->
		<a href="/m/mine/coupon/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">쿠폰 현황</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
	</div>

	<!-- 구분 -->
	<hr class="mt-[30px] mb-[15px] border-t border-[#E0E0E0]" />

	<!-- 고객센터 -->
	<div class="flex flex-col px-[14px] w-full">
		<p class="font-extrabold text-lg leading-5 text-black">고객센터</p>
		<hr class="mt-[14px] border-t-[0.5px] border-[#E0E0E0]" />
		<!-- 공지사항 -->
		<a href="/m/mine/notification/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">공지사항</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 1:1문의 -->
		<a href="/m/mine/question/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">1:1문의</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
		<!-- 자주 묻는 질문(FAQ) -->
		<a href="/m/faq/index.php" class="flex flex-row justify-between items-center px-[5px] py-2.5 border-b-[0.5px] border-[#E0E0E0]">
			<p class="font-medium text-xs leading-[140%] text-[#666666]">자주 묻는 질문(FAQ)</p>
			<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.18894 8.8219L5.84793 4.83245C5.90323 4.78496 5.9423 4.73351 5.96516 4.6781C5.98839 4.62269 6 4.56332 6 4.5C6 4.43668 5.98839 4.37731 5.96516 4.3219C5.9423 4.26649 5.90323 4.21504 5.84793 4.16755L1.18894 0.166227C1.05991 0.0554089 0.898617 0 0.705069 0C0.51152 0 0.345623 0.0593668 0.207374 0.1781C0.0691247 0.296834 0 0.435356 0 0.593668C0 0.751979 0.0691247 0.890501 0.207374 1.00923L4.27189 4.5L0.207374 7.99077C0.078341 8.10158 0.0138249 8.23805 0.0138249 8.40016C0.0138249 8.56259 0.0829492 8.70317 0.221198 8.8219C0.359447 8.94063 0.520737 9 0.705069 9C0.8894 9 1.05069 8.94063 1.18894 8.8219Z" fill="#333333" />
			</svg>
		</a>
	</div>

	<!-- CUSTOMER CENTER -->
	<div class="mt-[30px] flex flex-col w-full px-[14px] py-[30px] bg-[#F5F5F5]">
		<p class="font-extrabold text-lg leading-5 text-black">CUSTOMER CENTER</p>
		<p class="mt-[14px] font-bold text-xs leading-[14px] text-black">CS NUMBER : 02-6013-0616</p>
		<p class="mt-[5px] font-bold text-xs leading-[14px] text-black">톡톡문의 : @빈느</p>
		<p class="mt-[15px] font-medium text-[10px] leading-[11px] text-[#999999]">※ 운영시간: 평일 09:00 ~ 17:30 (점심시간 12:00~13:00) / 주말 및 공휴일 휴무</p>
	</div>
</div>

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php";
?>


<script language="javascript" src="js/user_info.js"></script>

<link rel="styleSheet" href="/css/sumoselect.css">
<script type="text/javascript" src="/js/custominputfile.min.js"></script>
<script type="text/javascript">
	$('#demo-1').custominputfile({
		theme: 'blue-grey',
		//icon : 'fa fa-upload'
	});
	$('#demo-2').custominputfile({
		theme: 'red',
		icon: 'fa fa-file'
	});
</script>