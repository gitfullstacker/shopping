<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?
	fnc_Login_Chk();
	
	$RetrieveFlag = Fnc_Om_Conv_Default($_REQUEST[RetrieveFlag],"INSERT");
	$str_no = Fnc_Om_Conv_Default($_REQUEST[str_no],"");
	
	If ($RetrieveFlag=="UPDATE") {

		$SQL_QUERY =	" SELECT
						A.*
					FROM "
						.$Tname."comm_member_qna AS A
					WHERE
						A.INT_NUMBER='$str_no' AND A.STR_USERID='".$arr_Auth[0]."' ";

		$arr_Rlt_Data=mysql_query($SQL_QUERY);
		if (!$arr_Rlt_Data) {
    		echo 'Could not run query: ' . mysql_error();
    		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ABLANC</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<link type="text/css" rel="stylesheet" href="../css/style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script language="javascript" src="../js/common_gnb.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
	  $( function() {
		// run the currently selected effect
		function runEffect() {
		  // get effect type from
		  var selectedEffect = $( "#effectTypes" ).val();
	 
		  // Most effect types need no options passed by default
		  var options = {};
		  // some effects have required parameters
		  if ( selectedEffect === "scale" ) {
			options = { percent: 50 };
		  } else if ( selectedEffect === "size" ) {
			options = { to: { width: 200, height: 60 } };
		  }
	 
		  // Run the effect
		  $( "#search_menu" ).toggle( selectedEffect, options, 500 );
			$(".search_close").click(function(){
				$("#search_menu").hide();
			});
		};
	 
		// Set effect from select menu value
		$( "#button" ).on( "click", function() {
		  runEffect();
		});
	  } );
	</script>
	<script type="text/javascript" src="../js/jquery.sumoselect.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
			window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
		});
	</script>
	<script language="javascript" src="/pub/js/CommScript.js"></script>
	<script language="javascript" src="js/my_qna_pop.js"></script>
</head>
<body style="overflow-x:hidden;overflow-y:hidden;">
	
	<div class="pop_w w550">
		<h1>문의하기</h1>
		<a href="javascript:parent.closeLayer();" class="pop_close"><img src="../images/common/btn_pop_close.png" alt="" /></a>
		
		<form id="frm" name="frm" target="_self" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
		<input type="hidden" name="str_no" value="<?=$str_no?>">
		<input type="hidden" name="str_dimage1" value="<?=$arr_Data['STR_IMAGE1']?>">
		
		<div class="pop_con">
			<div class="t_cover02">
				<table class="t_type01">
					<colgroup>
						<col style="width:120px;" />
					</colgroup>
					<tbody>
						<tr>
							<th>문의내용</th>
							<td class="left"><textarea name="str_cont" id="str_cont" cols="30" rows="10" class="texta texta_h108 w325"><?=$arr_Data['STR_CONT']?></textarea></td>
						</tr>
						<tr>
							<th>파일첨부</th>
							<td class="left"><span class="pop_file"><input type="file" class="inp01 w215" name="str_Image1" onChange="uploadImageCheck(this)"  id="demo-1" /></span></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="center mt25">
				<a href="javascript:Save_Click();" class="btn btn_ylw btn_ml f_bd w170">문의하기 <?if ($RetrieveFlag=="INSERT"){?>등록<?}else{?>수정<?}?></a>
				<a href="javascript:parent.closeLayer();" class="btn btn_bk btn_ml f_bd w170">취소</a>
			</div>
		</div>
		
		</form>
		
	</div>
	<script type="text/javascript" src="/js/custominputfile.min.js"></script>
	<script type="text/javascript">
		$('#demo-1').custominputfile({
			theme: 'blue-grey',
			//icon : 'fa fa-upload'
		});
		$('#demo-2').custominputfile({
			theme: 'red',
			icon : 'fa fa-file'
		});
	</script>
</body>
</html>