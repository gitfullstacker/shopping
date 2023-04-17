<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_gubun = Fnc_Om_Conv_Default($_REQUEST[str_gubun],"1");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	$conf_bd_path = Fnc_Om_Conv_Default($_REQUEST[conf_bd_path],"");
	$conf_title = Fnc_Om_Conv_Default($_REQUEST[conf_title],"");
	$conf_width = Fnc_Om_Conv_Default($_REQUEST[conf_width],"");
	$conf_att_url = Fnc_Om_Conv_Default($_REQUEST[conf_att_url],"");
	$conf_reply_yn = Fnc_Om_Conv_Default($_REQUEST[conf_reply_yn],"0");
	$conf_memo_yn = Fnc_Om_Conv_Default($_REQUEST[conf_memo_yn],"0");
	$conf_att_yn = Fnc_Om_Conv_Default($_REQUEST[conf_att_yn],"0");
	$conf_img_preview = Fnc_Om_Conv_Default($_REQUEST[conf_img_preview],"0");
	$conf_limit_size = Fnc_Om_Conv_Default($_REQUEST[conf_limit_size],"10");
	$conf_deny_file = Fnc_Om_Conv_Default($_REQUEST[conf_deny_file],"");
	$conf_list_cnt = Fnc_Om_Conv_Default($_REQUEST[conf_list_cnt],"10");
	$conf_page_cnt = Fnc_Om_Conv_Default($_REQUEST[conf_page_cnt],"10");
	$conf_deny_char = Fnc_Om_Conv_Default($_REQUEST[conf_deny_char],"");
	$conf_top_html = Fnc_Om_Conv_Default($_REQUEST[conf_top_html],"");
	$conf_mid_html = Fnc_Om_Conv_Default($_REQUEST[conf_mid_html],"");
	$conf_btm_html = Fnc_Om_Conv_Default($_REQUEST[conf_btm_html],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch ($str_gubun){
		case "1" : $conf_type="0";$conf_view="1";break;
		case "2" : $conf_type="2";$conf_view="3";break;
		case "3" : $conf_type="4";$conf_view="3";break;
	}

	$conf_icon_url="/pub/img/";
	$conf_auth="0" ;
	$conf_img_width="150";
	$conf_album_list_type="1";
	$conf_group_code="";
	$mem_code="";
	$mem_id="";


	switch($RetrieveFlag){
     	case "INSERT" :

			$SQL_QUERY = "select ifnull(max(a.conf_seq),0)+1 as lastnumber from ";
						$SQL_QUERY .= $Tname;
						$SQL_QUERY .= "b_conf_bd a ";

			$arr_max_Data=mysql_query($SQL_QUERY);
			$lastnumber = mysql_result($arr_max_Data,0,lastnumber) ;

			$conf_bd_path=$conf_bd_path.$lastnumber."/egolist.php?bd=".$lastnumber;

			$SQL_QUERY = "INSERT INTO ".$Tname."b_conf_bd (";
					$SQL_QUERY .= " 	CONF_SEQ ,CONF_TB_NAME ,CONF_TITLE ,CONF_WIDTH ,CONF_TYPE
												,CONF_ATT_URL ,CONF_ICON_URL ,CONF_AUTH ,CONF_VIEW ,CONF_REPLY_YN
												,CONF_MEMO_YN ,CONF_ATT_YN ,CONF_LIMIT_SIZE ,CONF_DENY_FILE ,CONF_IMG_WIDTH
												,CONF_ALBUM_LIST_TYPE ,CONF_IMG_PREVIEW ,CONF_LIST_CNT ,CONF_PAGE_CNT ,CONF_GROUP_CODE
												,MEM_CODE ,MEM_ID ,CONF_TOP_HTML ,CONF_MID_HTML ,CONF_BTM_HTML
												,CONF_DENY_CHAR ,CONF_BD_PATH ,CONF_REG_DATE
											) VALUES (
												'$lastnumber','".$Tname."B_BD_DATA@01','$conf_title','$conf_width','$conf_type'
												,'$conf_att_url','$conf_icon_url','$conf_auth','$conf_view','$conf_reply_yn'
												,'$conf_memo_yn','$conf_att_yn','$conf_limit_size','$conf_deny_file','$conf_img_width'
												,'$conf_album_list_type','$conf_img_preview','$conf_list_cnt','$conf_page_cnt','$conf_group_code'
												,'$mem_code' ,'$mem_id','$conf_top_html','$conf_mid_html','$conf_btm_html'
												,'$conf_deny_char','$conf_bd_path','".date("Y-m-d H:i:s")."'
											)";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="boad_board_edit.php?RetrieveFlag=UPDATE&page=1&str_no=<?=$lastnumber?>&str_gubun=<?=$str_gubun?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$SQL_QUERY = " UPDATE ".$Tname."b_conf_bd SET ";
								$SQL_QUERY .= "CONF_TB_NAME='".$Tname."B_BD_DATA@01'
									,CONF_TITLE='$conf_title'
									,CONF_WIDTH='$conf_width'
									,CONF_TYPE='$conf_type'
									,CONF_ATT_URL='$conf_att_url'
									,CONF_ICON_URL='$conf_icon_url'
									,CONF_AUTH='$conf_auth'
									,CONF_VIEW='$conf_view'
									,CONF_REPLY_YN='$conf_reply_yn'
									,CONF_MEMO_YN='$conf_memo_yn'
									,CONF_ATT_YN='$conf_att_yn'
									,CONF_LIMIT_SIZE='$conf_limit_size'
									,CONF_DENY_FILE='$conf_deny_file'
									,CONF_IMG_WIDTH='$conf_img_width'
									,CONF_ALBUM_LIST_TYPE='$conf_album_list_type'
									,CONF_IMG_PREVIEW='$conf_img_preview'
									,CONF_LIST_CNT='$conf_list_cnt'
									,CONF_PAGE_CNT='$conf_page_cnt'
									,CONF_GROUP_CODE='$conf_group_code'
									,MEM_CODE='$mem_code'
									,MEM_ID='$mem_id'
									,CONF_TOP_HTML='$conf_top_html'
									,CONF_MID_HTML='$conf_mid_html'
									,CONF_BTM_HTML='$conf_btm_html'
									,CONF_DENY_CHAR='$conf_deny_char'
									,CONF_BD_PATH='$conf_bd_path'
								WHERE
									CONF_SEQ='$str_no' ";

			$result=mysql_query($SQL_QUERY);

			?>
			<script language="javascript">
				window.location.href="boad_board_edit.php?RetrieveFlag=UPDATE&page=<?=$page?>&str_no=<?=$str_no?>&str_gubun=<?=$str_gubun?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."b_admin_bd WHERE CONF_SEQ='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."b_conf_bd WHERE CONF_SEQ='$chkItem1[$i]' ";
				$result=mysql_query($SQL_QUERY);
			}
			?>
			<script language="javascript">
				window.location.href="boad_board_list.php?str_gubun=<?=$str_gubun?>";
			</script>
			<?
			exit;
			break;

		case "ADMINLOADING" :

			$SQL_QUERY =	" SELECT
							UR.STR_USERID,
							UR.INT_GUBUN,
							UR.STR_MENU_LEVEL,
							UR.STR_PASSWD,
							UR.STR_NAME,
							UR.STR_JUMINNO,
							UR.STR_HP,
							UR.STR_POST,
							UR.STR_SIDO,
							UR.STR_SIGUN,
							UR.STR_DONGLEE,
							UR.STR_ADDRESS,
							UR.STR_TELEP,
							UR.STR_FAX,
							UR.STR_EMAIL,
							UR.DTM_INDATE,
							UR.DTM_ACDATE,
							UR.INT_LOGIN,
							UR.STR_SERVICE,
							UR.STR_CERTCODE
						FROM "
							.$Tname."b_admin_bd AD, "
							.$Tname."comm_member UR
						WHERE
							AD.MEM_ID = UR.STR_USERID
							AND
							AD.CONF_SEQ = '$str_no'
							AND
							UR.INT_GUBUN<=90
						ORDER BY
							AD.ADMIN_SEQ ASC";

				$arr_Admin_Data=mysql_query($SQL_QUERY);
			?>
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr><td class=rnd colspan=12></td></tr>
				<tr class=rndbg>
					<th>번호</th>
					<th>이름</th>
					<th>아이디</th>
					<th>회원구분</th>
					<th>핸드폰</th>
					<th>전화번호</th>
					<th>방문수</th>
					<th>가입일</th>
					<th>최종로그인</th>
					<th>승인</th>
					<th>삭제</th>
				</tr>
				<tr><td class=rnd colspan=12></td></tr>
				<col width=5% align=center>
				<col width=11% align=center>
				<col width=11% align=center>
				<col width=11% align=center>
				<col width=11% align=center>
				<col width=10% align=center>
				<col width=5% align=center>
				<col width=12% align=center>
				<col width=16% align=center>
				<col width=4% align=center>
				<col width=4% align=center>
				<?$count=0;?>
				<?while($row=mysql_fetch_array($arr_Admin_Data)){?>
				<tr height=30 align="center">
					<td><font class=ver81 color=616161><?=count+1?></font></td>
					<td><span id="navig" name="navig" m_id="admin" m_no="1"><font color=0074BA><b><?=$row[STR_NAME]?></b></font></span></td>
					<td><span id="navig" name="navig" m_id="admin" m_no="1"><font class=ver81 color=0074BA><b><?=$row[STR_USERID]?></b></font></span></td>
					<td><?switch ($row[INT_GUBUN]) {?><?case "1" :?>일반회원<?break;?><?case "10" :?>직원회원<?break;?><?}?></td>
					<td align=center><?=$row[STR_HP]?></td>
					<td align=center><?=$row[STR_TELEP]?></td>
					<td><font class=ver81 color=616161><?=$row[INT_LOGIN]?></font></td>
					<td><font class=ver81 color=616161><?=$row[DTM_INDATE]?></font></td>
					<td><font class=ver81 color=616161><font color=#7070B8><?=$row[DTM_ACDATE]?></font></font></td>
					<td><font class=small color=616161><?switch ($row[STR_SERVICE]) {?><?case "Y" :?>승인<?break;?><?case "N" :?>미승인<?break;?><?case "E" :?>탈퇴<?break;?><?}?></font></td>
					<td><a href="javascript:fuc_set('boad_admin_list_proc.php?RetrieveFlag=DELETE&str_no=<?=$str_no?>&str_userid=<?=$row[STR_USERID]?>','_Proc');"><img src="/admincenter/img/i_del.gif"></a></td>
				</tr>
				<tr><td colspan=12 class=rndline></td></tr>
				<?$count++;?>
				<?}?>
			</table>
			<?
     }

?>