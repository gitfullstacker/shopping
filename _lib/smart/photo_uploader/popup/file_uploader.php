<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?php
// default redirection
$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

// SUCCESSFUL
if(bSuccessUpload) {
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];
	
	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("jpg", "png", "bmp", "gif");
	
	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		$uploadDir = '../../../../admincenter/files/upload/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}
		
		$randomFileName = getRandomFileName($name);
        $newPath = $uploadDir . urlencode($randomFileName);
		
		@move_uploaded_file($tmp_name, $newPath);
		
		$url .= "&bNewLine=true";
		$url .= "&sFileName=".urlencode(urlencode($randomFileName));
		$url .= "&sFileURL=".$gbl_Om_Url."/admincenter/files/upload/".urlencode(urlencode($randomFileName));
	}
}
// FAILED
else {
	$url .= '&errstr=error';
}
	
header('Location: '. $url);
?>