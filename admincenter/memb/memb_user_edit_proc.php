<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	Fnc_Acc_Admin();
?>
<?
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");

	$str_userid = Fnc_Om_Conv_Default($_REQUEST[str_userid],"");
	$str_menu_level = Fnc_Om_Conv_Default($_REQUEST[str_menu_level],"00");
	$str_modpass = Fnc_Om_Conv_Default($_REQUEST[str_modpass],"N");
	$str_opasswd = Fnc_Om_Conv_Default($_REQUEST[str_opasswd],"");
	$str_passwd = Fnc_Om_Conv_Default($_REQUEST[str_passwd1],"");
	$str_name = Fnc_Om_Conv_Default($_REQUEST[str_name],"");
	$str_telep = Fnc_Om_Conv_Default($_REQUEST[str_telep1],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_telep2],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_telep3],"");
	$str_hp = Fnc_Om_Conv_Default($_REQUEST[str_hp1],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_hp2],"")."-".Fnc_Om_Conv_Default($_REQUEST[str_hp3],"");
	$str_post = Fnc_Om_Conv_Default($_REQUEST[str_post],"");
	$str_addr1 = Fnc_Om_Conv_Default($_REQUEST[str_addr1],"");
	$str_addr2 = Fnc_Om_Conv_Default($_REQUEST[str_addr2],"");
	$str_email = Fnc_Om_Conv_Default($_REQUEST[str_email],"");
	$str_tuserid = Fnc_Om_Conv_Default($_REQUEST[str_tuserid],"");
	$str_mail_f = Fnc_Om_Conv_Default($_REQUEST[str_mail_f],"N");
	$str_sms_f = Fnc_Om_Conv_Default($_REQUEST[str_sms_f],"N");
	$str_service = Fnc_Om_Conv_Default($_REQUEST[str_service],"Y");
	$str_escecode = Fnc_Om_Conv_Default($_REQUEST[str_escecode],"");
	$str_drcontents = Fnc_Om_Conv_Default($_REQUEST[str_drcontents],"");
	
	$str_spost = Fnc_Om_Conv_Default($_REQUEST[str_spost],"");
	$str_saddr1 = Fnc_Om_Conv_Default($_REQUEST[str_saddr1],"");
	$str_saddr2 = Fnc_Om_Conv_Default($_REQUEST[str_saddr2],"");
	$str_splace1 = Fnc_Om_Conv_Default($_REQUEST[str_splace1],"");
	$str_splace2 = Fnc_Om_Conv_Default($_REQUEST[str_splace2],"");
	$str_birth = str_replace("-","",Fnc_Om_Conv_Default($_REQUEST[str_birth],""));
	$str_sex = Fnc_Om_Conv_Default($_REQUEST[str_sex],"");

	$chkItem1 = Fnc_Om_Conv_Default($_REQUEST[chkItem1],"");

	switch($RetrieveFlag){
     	case "INSERT" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "STR_USERID";
			$arr_Column_Name[1]		= "INT_GUBUN";
			$arr_Column_Name[2]		= "STR_MENU_LEVEL";
			$arr_Column_Name[3]		= "STR_PASSWD";
			$arr_Column_Name[4]		= "STR_NAME";
			$arr_Column_Name[5]		= "STR_TELEP";
			$arr_Column_Name[6]		= "STR_HP";
			$arr_Column_Name[7]		= "STR_POST";
			$arr_Column_Name[8]		= "STR_ADDR1";
			$arr_Column_Name[9]		= "STR_ADDR2";
			$arr_Column_Name[10]		= "STR_EMAIL";
			$arr_Column_Name[11]		= "STR_MAIL_F";
			$arr_Column_Name[12]		= "STR_SMS_F";
			$arr_Column_Name[13]		= "STR_TUSERID";
			$arr_Column_Name[14]		= "DTM_INDATE";
			$arr_Column_Name[15]		= "DTM_ACDATE";
			$arr_Column_Name[16]		= "INT_LOGIN";
			$arr_Column_Name[17]		= "STR_SERVICE";
			$arr_Column_Name[18]		= "STR_ESCECODE";
			$arr_Column_Name[19]		= "STR_DRCONTENTS";
			$arr_Column_Name[20]		= "STR_SPOST";
			$arr_Column_Name[21]		= "STR_SADDR1";
			$arr_Column_Name[22]		= "STR_SADDR2";
			$arr_Column_Name[23]		= "STR_SPLACE1";
			$arr_Column_Name[24]		= "STR_SPLACE2";
			$arr_Column_Name[25]		= "STR_BIRTH";
			$arr_Column_Name[26]		= "STR_SEX";
			
			$arr_Set_Data[0]		= $str_userid;
			$arr_Set_Data[1]		= $int_gubun;
			$arr_Set_Data[2]		= $str_menu_level;
			$arr_Set_Data[3]		= $str_passwd;
			$arr_Set_Data[4]		= $str_name;
			$arr_Set_Data[5]		= $str_telep;
			$arr_Set_Data[6]		= $str_hp;
			$arr_Set_Data[7]		= $str_post;
			$arr_Set_Data[8]		= $str_addr1;
			$arr_Set_Data[9]		= $str_addr2;			
			$arr_Set_Data[10]		= $str_email;
			$arr_Set_Data[11]		= $str_mail_f;
			$arr_Set_Data[12]		= $str_sms_f;
			$arr_Set_Data[13]		= $str_tuserid;
			$arr_Set_Data[14]		= date("Y-m-d H:i:s");
			$arr_Set_Data[15]		= date("Y-m-d H:i:s");
			$arr_Set_Data[16]		= "0";
			$arr_Set_Data[17]		= $str_service;
			$arr_Set_Data[18]		= $str_escecode;
			$arr_Set_Data[19]		= $str_drcontents;
			$arr_Set_Data[20]		= $str_spost;
			$arr_Set_Data[21]		= $str_saddr1;
			$arr_Set_Data[22]		= $str_saddr2;
			$arr_Set_Data[23]		= $str_splace1;
			$arr_Set_Data[24]		= $str_splace2;
			$arr_Set_Data[25]		= $str_birth;
			$arr_Set_Data[26]		= $str_sex;

			$arr_Sub1 = "";
			$arr_Sub2 = "";
			
			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub1 .=  ",";
					$arr_Sub2 .=  ",";
				}
				$arr_Sub1 .=  $arr_Column_Name[$int_I];
				$arr_Sub2 .=  "'" . $arr_Set_Data[$int_I] . "'";

			}
			
			$Sql_Query = "INSERT INTO `".$Tname."comm_member` (".$arr_Sub1.") VALUES (".$arr_Sub2.") ";
			mysql_query($Sql_Query);
			
			$Sql_Query = "UPDATE `".$Tname."comm_member` SET STR_PASSWD=password('$str_passwd') WHERE STR_USERID='$str_userid' ";
			mysql_query($Sql_Query);

			?>
			<script language="javascript">
				window.location.href="memb_user_edit.php?RetrieveFlag=UPDATE&page=1&str_no=<?=$str_userid?>";
			</script>
			<?
			exit;
			break;

		case "UPDATE" :

			$arr_Set_Data= Array();
			$arr_Column_Name = Array();
			
			$arr_Column_Name[0]		= "INT_GUBUN";
			$arr_Column_Name[1]		= "STR_NAME";
			$arr_Column_Name[2]		= "STR_TELEP";
			$arr_Column_Name[3]		= "STR_HP";
			$arr_Column_Name[4]		= "STR_POST";
			$arr_Column_Name[5]		= "STR_ADDR1";
			$arr_Column_Name[6]		= "STR_ADDR2";
			$arr_Column_Name[7]		= "STR_EMAIL";
			$arr_Column_Name[8]		= "STR_MAIL_F";
			$arr_Column_Name[9]		= "STR_SMS_F";
			$arr_Column_Name[10]		= "STR_TUSERID";
			$arr_Column_Name[11]		= "DTM_ACDATE";
			$arr_Column_Name[12]		= "STR_SERVICE";
			$arr_Column_Name[13]		= "STR_ESCECODE";
			$arr_Column_Name[14]		= "STR_DRCONTENTS";
			$arr_Column_Name[15]		= "STR_SPOST";
			$arr_Column_Name[16]		= "STR_SADDR1";
			$arr_Column_Name[17]		= "STR_SADDR2";
			$arr_Column_Name[18]		= "STR_SPLACE1";
			$arr_Column_Name[19]		= "STR_SPLACE2";
			$arr_Column_Name[20]		= "STR_BIRTH";
			$arr_Column_Name[21]		= "STR_SEX";
			
			$arr_Set_Data[0]		= $int_gubun;
			$arr_Set_Data[1]		= $str_name;
			$arr_Set_Data[2]		= $str_telep;
			$arr_Set_Data[3]		= $str_hp;
			$arr_Set_Data[4]		= $str_post;
			$arr_Set_Data[5]		= $str_addr1;
			$arr_Set_Data[6]		= $str_addr2;			
			$arr_Set_Data[7]		= $str_email;
			$arr_Set_Data[8]		= $str_mail_f;
			$arr_Set_Data[9]		= $str_sms_f;
			$arr_Set_Data[10]		= $str_tuserid;
			$arr_Set_Data[11]		= date("Y-m-d H:i:s");
			$arr_Set_Data[12]		= $str_service;
			$arr_Set_Data[13]		= $str_escecode;
			$arr_Set_Data[14]		= $str_drcontents;
			$arr_Set_Data[15]		= $str_spost;
			$arr_Set_Data[16]		= $str_saddr1;
			$arr_Set_Data[17]		= $str_saddr2;
			$arr_Set_Data[18]		= $str_splace1;
			$arr_Set_Data[19]		= $str_splace2;
			$arr_Set_Data[20]		= $str_birth;
			$arr_Set_Data[21]		= $str_sex;

			$arr_Sub = "";

			for($int_I=0;$int_I<count($arr_Column_Name);$int_I++) {

				If  ($int_I != 0) {
					$arr_Sub .=  ",";
				}
				$arr_Sub .=  $arr_Column_Name[$int_I]. "=" . "'" . $arr_Set_Data[$int_I] . "' ";
 
			}

			$Sql_Query = "UPDATE `".$Tname."comm_member` SET ";
			$Sql_Query .= $arr_Sub;
			$Sql_Query .= " WHERE STR_USERID='".$str_userid."' ";
			mysql_query($Sql_Query);
			
			If ($str_modpass[0] == "Y") {
				$Sql_Query = "UPDATE `".$Tname."comm_member` SET STR_PASSWD=password('$str_passwd') WHERE STR_USERID='$str_userid' ";
				mysql_query($Sql_Query);
			}
			
			If ($str_service == "E") {
				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_alarm WHERE STR_USERID='$str_userid' ";
				mysql_query($SQL_QUERY);
			}
			?>
			<script language="javascript">
				window.location.href="memb_user_edit.php?RetrieveFlag=UPDATE&page=<?=$page?>&str_no=<?=$str_userid?>";
			</script>
			<?
			exit;
			break;

		case "ADELETE" :

			for($i=0;$i<count($chkItem1);$i++) {

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_alarm WHERE STR_USERID='$chkItem1[$i]' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_stamp WHERE STR_USERID='$chkItem1[$i]' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member_like WHERE STR_USERID='$chkItem1[$i]' ";
				mysql_query($SQL_QUERY);

				$SQL_QUERY =	"DELETE FROM ".$Tname."comm_member WHERE STR_USERID='$chkItem1[$i]' ";
				mysql_query($SQL_QUERY);
			}
			?>
			<script language="javascript">
				window.location.href="memb_user_list.php";
			</script>
			<?
			exit;
			break;

		case "SERVICE" :

			$SQL_QUERY =	"UPDATE ".$Tname."comm_member SET STR_SERVICE='$str_service' WHERE STR_USERID='$STR_USERID' ";
			mysql_query($SQL_QUERY);

			break;

     	case "IDCHECK" :

     		If ($str_userid!="") {

				$SQL_QUERY = "select * from ".$Tname."comm_member where str_userid='$str_userid' ";

				$arr_Id_Data=mysql_query($SQL_QUERY);
				$rcd_cnt=mysql_num_rows($arr_Id_Data);

				if($rcd_cnt){?>
					<input type=text name=str_userid value="<?=$str_userid?>" maxlength="12" onKeyUp="fnc_idcheck()"> <font class=small color=6d6d6d>아이디 중복! / <a href="javascript:fnc_idchk('1');"><b>중복체크</b></font>
					<input type="hidden" name="str_userid_chk" value="0">
				<?}else{?>
					<b><?=$str_userid?></b>
					<input type=hidden name=str_userid value="<?=$str_userid?>"> <font class=small color=6d6d6d>아이디 사용가능! / <a href="javascript:fnc_idchk('2');"><b>다른아이디로찾기</b></font>
					<input type="hidden" name="str_userid_chk" value="1">
				<?}

			}else{?>
				<input type=text name=str_userid value="" maxlength="12" onKeyUp="fnc_idcheck()"> <font class=small color=6d6d6d>영문입력 / <a href="javascript:fnc_idchk('1');"><b>중복체크</b></font>
				<input type="hidden" name="str_userid_chk" value="0">
			<?}

			break;
	}

?>
