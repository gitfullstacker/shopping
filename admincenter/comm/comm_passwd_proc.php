<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
	Fnc_Preloading()		// @@@@@@ 페이지 호출 시 프리로딩 이미지 출력
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"");
	$str_opasswd = Fnc_Om_Conv_Default($_REQUEST[str_opasswd],"");
	$str_passwd1 = Fnc_Om_Conv_Default($_REQUEST[str_passwd1],"");
	$str_passwd2 = Fnc_Om_Conv_Default($_REQUEST[str_passwd2],"");
	
	
	switch($RetrieveFlag){
     	case "PUPDATE" :
     	
			$SQL_QUERY =	" SELECT CM.STR_USERID FROM ".$Tname."comm_member AS CM WHERE CM.STR_USERID='$arr_Auth[0]' AND CM.STR_PASSWD=password('$str_opasswd') ";

			$rel=mysql_query($SQL_QUERY);
			$rcd_cnt=mysql_num_rows($rel);
		
			if(!$rcd_cnt){ ?>
				<script language=javascript>
					{
						alert("기존 비밀번호가 일치하지 않습니다.");
					}
				</script>
				
				<?
				break;
				exit;
			} else {
			
				$SQL_QUERY = " UPDATE ".$Tname."comm_member SET STR_PASSWD=password('$str_passwd1') WHERE STR_USERID='$arr_Auth[0]' ";
				$result=mysql_query($SQL_QUERY);

				?>
				<script language="javascript">
					alert("정상적으로 변경되었습니다.");
					parent.parent.closeLayer();
				</script>
				<?
				break;
				exit;				
			}

     	
     }
	
?>

