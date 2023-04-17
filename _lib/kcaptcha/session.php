<?php
session_start();
class MY_Kcaptcha {

	function session() {
	require('kcaptcha.php');
	require('kcaptcha_config.php');

	$captcha = new Kcaptcha();

	while(true) {
		$keystring = '';
		for ($i=0; $i<$length; $i++) {
			$keystring .= $allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
		}
		if (!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $keystring)) break;
	}

	$_SESSION['captcha_keystring'] = $keystring;

	$captcha->setKeyString($_SESSION['captcha_keystring']);
	echo md5($captcha->getKeyString());
	}
}
$k = new MY_Kcaptcha();
$k->session();
?>