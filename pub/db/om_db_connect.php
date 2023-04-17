<?
	$connect=mysql_connect('localhost', 'ablanccompany', 'Ablancadmin1!') or die( "Unable to connect to SQL server");
	mysql_select_db("ablanccompany",$connect) or die( "Unable to select database");
	mysql_query("set names 'utf8'");
?>
