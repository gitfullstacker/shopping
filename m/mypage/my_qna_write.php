<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	fnc_MLogin_Chk();
	
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<title>ABLANC</title>
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<link rel="shortcut icon" type="image/x-icon" href="/images/common/favicon.png" />


	<link href="../css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/swiper.min.css">
	<script src="../js/swiper.min.js"></script>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<!-- jquery.mobilemenu -->
	<link href="../css/jquery.mobilemenu.css" type="text/css" rel="stylesheet" />
	<script src="../js/jquery.mobilemenu.js" type="text/javascript"></script>
	<script src="../js/main.js" type="text/javascript"></script>
	
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
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
		};
	 
		// Set effect from select menu value
		$( "#button" ).on( "click", function() {
		  runEffect();
		});
	  } );
	</script>
	<script language="javascript" src="/pub/js/CommScript.js"></script>
	<script language="javascript" src="js/my_qna_write.js"></script>
</head>

<body>
	<div class="pop_w">
	
		<form id="frm" name="frm" target="_self" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="RetrieveFlag" value="<?=$RetrieveFlag?>">
		<input type="hidden" name="str_no" value="<?=$str_no?>">
		<input type="hidden" name="str_dimage1" value="<?=$arr_Data['STR_IMAGE1']?>">
	
		<h1>문의하기</h1>
		<p class="pop_close"><a href="javascript:parent.closeLayer();"><img src="../images/btn_pop_close.png" alt="" /></a></p>
		<div class="pop_con">
			<div class="t_cover01 mt10">
				<table class="t_type">
					<colgroup>
						<col style="width:25%;" />
						<col style="width:75%;" />
					</colgroup>
					<tbody>
						<tr>
							<th>문의내용</th>
							<td><textarea name="str_cont" id="str_cont" cols="30" rows="10" class="tarea tarea_h50"><?=$arr_Data['STR_CONT']?></textarea></td>
						</tr>
						<tr>
							<th>파일첨부</th>
							<td>
								<p class="file_bx">
									<input type="file" class="inp w100p" name="str_Image1" onChange="uploadImageCheck(this)"  id="demo-1" />
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="btn_w mt15">
				<a href="javascript:Save_Click();" class="btn btn_m btn_ylw f_bd w35p">문의하기 <?if ($RetrieveFlag=="INSERT"){?>등록<?}else{?>수정<?}?></a>
				<a href="javascript:parent.closeLayer();" class="btn btn_m btn_bk f_bd w35p">취소</a>
			</div>
		</div>
		
		</form>
		
	</div>
</body>
</html>

<link rel="styleSheet" href="/css/sumoselect.css">
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