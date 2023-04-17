<? 
function SMail($From,$Mail_from_name,$To,$Subject,$Text) { 
$Headers .= "Content-Type: text/html; charset=UTF-8"; 
$fp = popen("/home/bin/sendmail -t -f $From","w"); // 주의하실 부분 if(!$fp) return false; 
fputs($fp,"from: =?utf-8?B?".base64_encode($Mail_from_name)."?=  <$From> 
"); // from 과 : 은 붙여주세요 => from: 
fputs($fp, "to: <$To> 
"); 
fputs($fp, "subject: $Subject 
"); 
fputs($fp, "$Headers 
"); 
fputs($fp, "$Text"); 
fputs($fp, " 
"); 
pclose($fp); 
return true; 
} 


$mail_from = "LEMONKENYA@lemonkenya.cafe24.com"; // 보내는 사람메일주소 
$mail_to = "joilya@hanmail.net"; // 받는사람 메일주소 
$mail_from_name = "폼메일 예제"; // 보내는 사람 이름 
$subject = \'=?UTF-8?B?\'.base64_encode("폼메일 예제").\'?=\'; 
$contents = 
" 
<html> 
<body><br><br> 
<table border=1 cellpadding=5 align=center> 
<tr align=center bgcolor=#C0E0FF>! ;<td>카페24 호스팅 폼메일 예제</td></! tr> < br /><tr align=center bgcolor=#E0F0FF height=100>이 테이블이 보이면, HTML 형식메일입니다.</td></tr> 
</table> 
</body> 
</html> 

"; 

SMail($mail_from,$mail_from_name, $mail_to,$subject,$contents); 
echo "Sendmail mail()"; 
?> 
