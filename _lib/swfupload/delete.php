<?php
    session_start();
    set_time_limit(0);

	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	include ROOT.'/module/DB_.class.php';

	$dbCon = &new DB_;

	$row = $dbCon->selectDAO("bo_attachurl, bo_attachurl_resize", "bbs_editor_file", array("idx"=>$_GET['idx'], "bo_no"=>$_GET['bo_no']));
	if ($row['bo_attachurl'])
	{
		@unlink(ROOT.$row['bo_attachurl']);
		@unlink(ROOT.$row['bo_attachurl_resize']);
		$dbCon->deleteDAO("bbs_editor_file", array("idx"=>$_GET['idx'], "bo_no"=>$_GET['bo_no']), "1");
	}
?>