<?php
	session_start();
	error_reporting (E_ALL);
	require('kcaptcha.php');
	$captcha = new Kcaptcha();

	$captcha->setKeyString($_SESSION['captcha_keystring']);
	$captcha->getKeyString();
	$captcha->image();
?>