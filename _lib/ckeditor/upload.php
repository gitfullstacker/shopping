<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?
	$CKEditorFuncNum=$_REQUEST[CKEditorFuncNum];
	$str_dimage1 = Fnc_Om_Conv_Default($_REQUEST[upload],"");
	$str_image1=$_FILES['upload']['tmp_name'];
	$str_image1_name=$_FILES['upload']['name'];
	$str_image1_type=$_FILES['upload']['type'];
	
	if ($str_image1_type == "image/gif"||$str_image1_type == "image/jpeg"||$str_image1_type == "image/jpg"||$str_image1_type == "image/png"||$str_image1_type == "image/pjpeg") {
	
		$str_Img_Tag = "/admincenter/files/editer/";
	
		$str_Add_Tag = $_SERVER[DOCUMENT_ROOT].$str_Img_Tag;
		
		$str_Temp=Fnc_Om_File_Save($str_image1,$str_image1_name,$str_dimage1,0,0,"",$str_Add_Tag);
	
		if ($str_Temp[0] == "0") {
			?>
			<script language="javascript">
				alert("업로드에 실패하셨습니다.");
				history.back();
			</script>
			<?
			exit;
		} else {
			?>
			<script language="javascript">
				alert("업로드에 성공하셨습니다.");
			</script>
			<?
		}
		$arr_Temp=$str_Temp[1];
		$str_dimage1=$arr_Temp[0];
	
	} else {
			?>
			<script language="javascript">
				alert("업로드에 실패하셨습니다.");
				history.back();
			</script>
			<?
			exit;		
	}
?>
<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction('<?=$CKEditorFuncNum?>', 'http://<?=$_SERVER["HTTP_HOST"].$str_Img_Tag.$str_dimage1?>');</script>;