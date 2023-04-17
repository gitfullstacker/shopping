<?php
	session_start();
    set_time_limit(0);
    ini_set("post_max_size", '10M');
    ini_set("upload_max_filesize", '10M');

	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	include ROOT.'/module/upLoad_.class.php';

	$upload = new upLoad_();	

	if(!function_exists('mime_content_type')) {
		function mime_content_type($filename) {

			$mime_types = array(

				'txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',

				// images
				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',

				// archives
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',

				// audio/video
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',

				// adobe
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',

				// ms office
				'doc' => 'application/msword',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',

				// open office
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			);

			$ext = strtolower(array_pop(explode('.',$filename)));
			if (array_key_exists($ext, $mime_types)) {
				return $mime_types[$ext];
			}
			elseif (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $filename);
				finfo_close($finfo);
				return $mimetype;
			}
			else {
				return 'application/octet-stream';
			}
		}
	}

	$upload_dir = ROOT.'/admincenter/files/_files/'.$_POST['file_type'].'/';
	$ext        = strtolower(substr(strrchr($_FILES['Filedata']['name'], "."), 1));
	//$filename   = date('YmdHis').rand(100000,999999).'.'.$ext;
	$filename   = date('Hi').rand(100000,999999).'.'.$ext;

	if (move_uploaded_file($_FILES['Filedata']["tmp_name"], $upload_dir.$filename))
	{
		@chmod($upload_dir.$filename, 0666);

		if ($_POST['file_type'] == "image") {
			// 게시판 가로 사이즈 맞게 600px 이상 자동 조절
			/*
			$imgSize = @getimagesize($upload_dir.$filename);
			if ($imgSize[0] > 600) { 
				$zoomWidth = 600;
				$upload->imageResize($upload_dir.$filename, $upload_dir.$filename, $zoomWidth, '', 100, $notCrop);
			}
			*/

			$resize_dir = ROOT.'/admincenter/files/_files/resize/';
			
			$zoomWidth = 120;
			$resizeFileName = $resize_dir.$filename;							// 썸네일 저장 화일명
			$upload->imageResize($upload_dir.$filename, $resizeFileName, $zoomWidth, '', 100, $notCrop);
			$attachurl_resize = '/admincenter/files/_files/resize/'.$filename;
		}

		$attachurl = '/admincenter/files/_files/'.$_POST['file_type'].'/'.$filename;


        // embed되는 플래시의 사이즈를 구함
		if ($_POST['file_type']=='flash')
		{
			$size = getimagesize($upload_dir.$filename);
			$filename = $filename.'|'.$size[0].'|'.$size[1];
		}

		echo $filename;
    }
?>