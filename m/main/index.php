<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<?
$str_Ini_Group_Table = "@01";
$str_Board_Icon_Img = "/pub/img/board/";
$Sql_Query =	" SELECT
					A.BD_SEQ,
					A.CONF_SEQ,
					A.BD_ID_KEY,
					A.BD_IDX,
					A.BD_ORDER,
					A.BD_LEVEL,
					A.MEM_CODE,
					A.MEM_ID,
					A.BD_W_NAME,
					A.BD_W_EMAIL,
					A.BD_TITLE,
					A.BD_CONT,
					A.BD_OPEN_YN,
					A.BD_REG_DATE,
					A.BD_DEL_YN,
					A.BD_VIEW_CNT,
					A.BD_GOOD_CNT,
					A.BD_BAD_CNT,
					IFNULL(A.BD_MEMO_CNT, 0) AS BD_MEMO_CNT,
					IFNULL(C.IMG_SEQ, 0) AS IMG_SEQ,
					IFNULL(C.IMG_ID_KEY, '') AS IMG_ID_KEY,
					IFNULL(C.IMG_TITLE, '') AS IMG_TITLE,
					IFNULL(C.IMG_CONT, '') AS IMG_CONT,
					IFNULL(C.IMG_F_WIDTH, 0) AS IMG_F_WIDTH,
					IFNULL(C.IMG_F_HEIGHT, 0) AS IMG_F_HEIGHT,
					IFNULL(D.FILE_SEQ, 0) AS FILE_SEQ
				FROM `"
	. $Tname . "b_bd_data" . $str_Ini_Group_Table . "` AS A
					LEFT JOIN `"
	. $Tname . "b_img_data" . $str_Ini_Group_Table . "` AS C
					ON
					A.CONF_SEQ=C.CONF_SEQ
					AND
					A.BD_SEQ=C.BD_SEQ
					AND
					C.IMG_ALIGN=1
					LEFT JOIN `"
	. $Tname . "b_file_data" . $str_Ini_Group_Table . "` AS D
					ON
					A.CONF_SEQ=D.CONF_SEQ
					AND
					A.BD_SEQ=D.BD_SEQ
					AND
					D.FILE_ALIGN=1
				WHERE ";
$Sql_Query .= " A.CONF_SEQ=3 AND ";
$Sql_Query .= " A.BD_ID_KEY IS NOT NULL ";
$Sql_Query .= " ORDER BY
								BD_ORDER DESC ";
$Sql_Query .= "limit 3";

$arr_Get_Data5 = mysql_query($Sql_Query);
if (!$arr_Get_Data5) {
	error("QUERY_ERROR");
	exit;
}
$arr_Get_Data_Cnt5 = mysql_num_rows($arr_Get_Data5);
?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<!-- Slider -->
<div class="m_visual">
	<div class="swiper-container1">
		<div class="swiper-wrapper">
			<?
			$SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='6' order by a.int_number asc ";

			$arr_Bann_Data = mysql_query($SQL_QUERY);
			$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
			?>
			<?
			for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
			?>
				<? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
					<div class="swiper-slide">
						<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
							<a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
							<? } ?>
							<img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
							<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
							</a>
						<? } ?>
					</div>
				<? } ?>
			<?
			}
			?>
		</div>
		<!-- Add Pagination -->
		<div class="swiper-pagination"></div>
		<!-- Add Arrows -->
	</div>
	<script>
		var swiper = new Swiper('.swiper-container1', {
			effect: 'fade',
			pagination: '.swiper-pagination',
			paginationClickable: true,
			spaceBetween: 0,
			centeredSlides: true,
			autoplay: 2500,
			autoplayDisableOnInteraction: false,
			loop: true
		});
	</script>
</div>

<!-- Sub menu -->
<div class="sub-menu">
	<a href="#" class="menu-item">
		<img src="../images/menu_item1.png" alt="menu_item1" />
		<p class="item-title">이용안내</p>
	</a>
	<a href="#" class="menu-item">
		<img src="../images/menu_item2.png" alt="menu_item2" />
		<p class="item-title">신규혜택</p>
	</a>
	<a href="#" class="menu-item">
		<img src="../images/menu_item3.png" alt="menu_item3" />
		<p class="item-title">리뷰</p>
	</a>
	<a href="#" class="menu-item">
		<img src="../images/menu_item4.png" alt="menu_item4" />
		<p class="item-title">기획전</p>
	</a>
</div>

<div class="con_width">
	<div class="main_tit2"><span>NEW</span></div>
	<ul class="new_list">
		<?
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
							A.INT_SORT DESC";

		$arr_Data = mysql_query($SQL_QUERY);
		$arr_Data_Cnt = mysql_num_rows($arr_Data);
		?>
		<? $sBuy = fnc_buy_info(); ?>
		<?
		for ($int_J = 0; $int_J < $arr_Data_Cnt; $int_J++) {
		?>
			<? $sRent = fnc_cart_info(mysql_result($arr_Data, $int_J, str_goodcode)); ?>
			<li>
				<? if ($sRent == 0) { ?>
					<span class="rented">RENTED</span>
				<? } ?>
				<p class="zzim_icn"><img src="../images/icn_zzim_on.png" alt="" /> <?= mysql_result($arr_Data, $int_J, likecnt) ?></p>
				<a href="/m/category/detail.php?Txt_bcode=<?= mysql_result($arr_Data, $int_J, str_bcode) ?>&str_no=<?= mysql_result($arr_Data, $int_J, str_goodcode) ?>">
					<p><? if (mysql_result($arr_Data, $int_J, str_image1) != "") { ?><img src="/admincenter/files/good/<?= mysql_result($arr_Data, $int_J, str_image1) ?>" border="0"><? } ?></p>
					<dl>
						<dt><?= mysql_result($arr_Data, $int_J, str_code) ?></dt>
						<dd><?= mysql_result($arr_Data, $int_J, str_egoodname) ?></dd>
					</dl>
				</a>
			</li>
		<?
		}
		?>

	</ul>
	<p><a href="/m/category/list.php" class="btn btn_readmore">MORE BAGS <i class="icn"></i></a></p>
	<div class="banner_line2 mt50"></div>
	<div class="main_tit">
		<span>BRAND</span>
	</div>
	<div class="m_brand">
		<ul>
			<?
			$SQL_QUERY = "select a.* from " . $Tname . "comm_com_code a where a.str_service='Y' and a.int_gubun='2' order by a.int_number asc ";

			$arr_Bann_Data = mysql_query($SQL_QUERY);
			$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
			?>
			<?
			for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
			?>
				<li><a href="/m/search/search.php?Txt_brand[]=<?= mysql_result($arr_Bann_Data, $int_J, int_number) ?>"><span><? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?><img src="/admincenter/files/com/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" /><? } ?></span></a></li>
			<?
			}
			?>
		</ul>
	</div>

</div>
<div class="banner_line2 mt50">
	<?
	$SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='4' order by a.int_number asc ";

	$arr_Bann_Data = mysql_query($SQL_QUERY);
	$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
	?>
	<?
	for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
	?>
		<? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
			<p>
				<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					<a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
					<? } ?>
					<img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
					<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					</a>
				<? } ?>
			</p>
		<? } ?>
	<?
	}
	?>
</div>
<div class="con_width" style="padding-bottom: 30px;">
	<?
	$SQL_QUERY = "select a.* from " . $Tname . "comm_banner a where a.str_service='Y' and a.int_gubun='5' order by a.int_number asc ";

	$arr_Bann_Data = mysql_query($SQL_QUERY);
	$arr_Bann_Data_Cnt = mysql_num_rows($arr_Bann_Data);
	?>
	<?
	for ($int_J = 0; $int_J < $arr_Bann_Data_Cnt; $int_J++) {
	?>
		<? if (mysql_result($arr_Bann_Data, $int_J, str_image1) != "") { ?>
			<p class="m_service">
				<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					<a href="<?= mysql_result($arr_Bann_Data, $int_J, str_url1) ?>" <? if (mysql_result($arr_Bann_Data, $int_J, str_target1) == "2") { ?> target="_blank" <? } ?>>
					<? } ?>
					<img src="/admincenter/files/bann/<?= mysql_result($arr_Bann_Data, $int_J, str_image1) ?>" alt="" />
					<? if (mysql_result($arr_Bann_Data, $int_J, str_url1) != "") { ?>
					</a>
				<? } ?>
			</p>
		<? } ?>
	<?
	}
	?>


	<div class="modal__wrapper is-hidden js-example-modal-1">
		<div class="modal__double js-modal__double">
			<div class="modal__content">
				<a href="#" class="modal__close js-modal__close"></a>
				<div class="contents_bx">
					<p style="height:315px;overflow-y:scroll;border:1px solid #ccc;"><img src="../images/membership_guide_mobile02.gif" alt="멤버십 이용 가이드" /></p>
					<p class="center mt10"><a href="/m/mypage/membership.php" class="btn btn_bk btn_s">멤버십 등록하러 가기</a></p>
				</div>
			</div>
		</div>
	</div>

	<link rel="stylesheet" href="/m/css/simplePop.css">

	<script src="/m/js/simplePopup.js"></script>
	<script type="text/javascript">
		$(function() {

			$('.js-open-modal').each(function() {

				var modalClass = $(this).data('what');
				var $modal = $('.' + modalClass);
				var $this = $(this);


				var code = $modal.html();
				var textarea = $this.parents('.example__item').append('<div class="example__code"><textarea></textarea></div>').find('textarea');
				textarea.val(code);

				$this.on('click', function() {
					$modal.simplePop();
				});

			});

		});
	</script>
</div>
<div class="main_banner">
	<a href="https://www.instagram.com/ablanc_lookbook/?hl=ko"><img src="../images/instagram.jpg" /></a>
	<a href="/m/cscenter/lookbook1.php"><img src="../images/lookbook.jpg" style="padding-top:10px;" /><a>
			<a href="/m/cscenter/guideyong.php"><img src="../images/introduce.jpg" style="padding-top:10px; padding-bottom:10px;" /></a>
</div>

<div>
	<a href="/m/cscenter/guideyong.php"><img src="../images/helper1.jpg" /></a>
</div>

<div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/deliveryyong.php"><img src="../images/helper2.jpg" /></a>
	</div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/updateyong.php"><img src="../images/helper3.jpg" /></a>
	</div>
</div>
<div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/faq.php"><img src="../images/helper4.jpg" /></a>
	</div>
	<div style="width:50%; float:left;">
		<a href="/m/cscenter/csyong.php"><img src="../images/helper5.jpg" /></a>
	</div>
</div>


<div>
	<a href="/m/cscenter/guideyong.php"><img src="../images/bottom_banner.jpg" alt="멤버십 이용 가이드" /></a>

</div>


<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>