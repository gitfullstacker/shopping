<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<?   
	header("Content-Type: text/html; charset=UTF-8"); 
?>
<?
if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) Error("외부에서는 다운로드 받으실수 없습니다."); 
// 다운로드 방식을 구한다. 
$file_dir  = urldecode($_GET['file_dir']); 

$filename  = urldecode($_GET['filename']);
$filename = iconv("UTF-8","EUC-KR",$filename) ? iconv("UTF-8","EUC-KR",$filename) : $filename;



$ext = array_pop(explode(".", $filename)); 

if ($ext=="avi" || $ext=="asf")         $file_type = "video/x-msvideo"; 
else if ($ext=="mpg" || $ext=="mpeg")   $file_type = "video/mpeg"; 
else if ($ext=="jpg" || $ext=="jpeg")   $file_type = "image/jpeg"; 
else if ($ext=="gif")                   $file_type = "image/gif"; 
else if ($ext=="png")                   $file_type = "image/png"; 
else if ($ext=="txt")                   $file_type = "text/plain"; 
else if ($ext=="zip")                   $file_type = "application/x-zip-compressed"; 

// 실제로 다운로드 받는다. 
$ret = download_file( $filename, $filename, "../..".$file_dir, $file_type); 


if( $ret == 1 ) Error("지정하신 파일이 없습니다."); 
if( $ret == 2 ) Error("접근불가능 파일입니다. 정상 접근 하시기 바랍니다.");
?>
