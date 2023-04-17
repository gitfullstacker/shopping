<? 
$mail_from = "LEMONKENYA@lemonkenya.cafe24.com"; // 보내는 사람메일주소 
$from_name = "폼메일 예제"; // 보내는사람 이름 
$mail_to = "joilya@nate.com"; // 받는사람 메일주소 


$Headers = "from: =?utf-8?B?".base64_encode($from_name)."?= <$mail_from>n"; // from 과 : 은 붙여주세요 => from: 
$Headers .= "Content-Type: text/html;"; 

$subject = \'=?UTF-8?B?\'.base64_encode("?! ??메일 예제 - mail").\'?=\'; 


$contents = 
" 
<html> 
<body><br><br> 
<table border=1 cellpadding=5 align=center> 
<tr align=center bgcolor=#C0E0FF><td>카페24 호스팅 폼메일 예제</td></tr> 
<tr align=center bgcolor=#E0F0FF height=100>이 테이블이 보이면, HTML 형식메일입니다.</td></tr> 
</table> 
</body> 
</html> 
"; 

mail($mail_to,$subject,$contents,$Headers); 
echo "PHP mail()"; 
?> 
