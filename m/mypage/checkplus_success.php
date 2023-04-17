<?include_once $_SERVER[DOCUMENT_ROOT] . "/pub/inc/comm.php";?>
<?php
    //**************************************************************************************************************
    //NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //서비스명 :  체크플러스 - 안심본인인증 서비스
    //페이지명 :  체크플러스 - 결과 페이지
    
    //보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 
    //**************************************************************************************************************
    
	session_start();
	
    $enc_data = $_POST["EncodeData"];		// 암호화된 결과 데이타
    $sReserved1 = $_POST['param_r1'];		
		$sReserved2 = $_POST['param_r2'];
		$sReserved3 = $_POST['param_r3'];

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가. 
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved1, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved2, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved3, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	$str_result="0";
		
    if ($enc_data != "") {

        $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
        //echo "[plaindata]  " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
        }else{
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
        
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $responsenumber = GetValue($plaindata , "RES_SEQ");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
            $name = GetValue($plaindata , "NAME");
            $birthdate = GetValue($plaindata , "BIRTHDATE");
            $gender = GetValue($plaindata , "GENDER");
            $nationalinfo = GetValue($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
            $hp = GetValue($plaindata , "MOBILE_NO");
//            $dupinfo = GetValue($plaindata , "DI");
//            $conninfo = GetValue($plaindata , "CI");

			$str_result="1";

            if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0)
            {
            	echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
                $requestnumber = "";
                $responsenumber = "";
                $authtype = "";
                $name = "";
            		$birthdate = "";
            		$gender = "";
            		$nationalinfo = "";
            		$dupinfo = "";
            		$conninfo = "";
            }
        }
    }
?>

<?
    function GetValue($str , $name)
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // 다르면 스킵한다.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }
    
	function addHyphen($num){
	
	  return preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $num);
	
	}
    
    if ($str_result=="1") {
    	$name = iconv("EUC-KR","UTF-8",$name) ? iconv("EUC-KR","UTF-8",$name) : $name;
    	
		$SQL_QUERY =	" SELECT
						UR.*
					FROM "
						.$Tname."comm_member AS UR
					WHERE
						UR.STR_USERID='$arr_Auth[0]' ";
	
		$arr_Rlt_Data=mysql_query($SQL_QUERY);
	
		if (!$arr_Rlt_Data) {
	  		echo 'Could not run query: ' . mysql_error();
	  		exit;
		}
		$arr_Data = mysql_fetch_assoc($arr_Rlt_Data);
    	
    	if ($arr_Data['STR_CERT']=="M") { //인증회원일때

			$Sql_Query =	" SELECT A.STR_USERID FROM `".$Tname."comm_member` AS A WHERE STR_USERID='".$arr_Auth[0]."' AND STR_HP='".addHyphen($hp)."' ";
			$arr_Data=mysql_query($Sql_Query);
			$arr_Data_Cnt=mysql_num_rows($arr_Data);    	

			if ($arr_Data_Cnt) {
				?>
		    	<script language="javascript">
					alert("기존 핸드폰번호와 동일한 핸드폰번호 입니다.");
		    		self.close();
		    	</script>
				<?
				exit;
			} else {
			
				$SQL_QUERY = " UPDATE ".$Tname."comm_member SET STR_HP='".addHyphen($hp)."',STR_CERT='M' WHERE STR_USERID='$arr_Auth[0]' ";
				mysql_query($SQL_QUERY);
				?>
		    	<script language="javascript">
					alert("인증되었습니다.");
					opener.document.frm.submit();
		    		self.close();
		    	</script>
				<?
				exit;

			}
    	
    	
    	} else { //비인증회원일때

			$Sql_Query =	" SELECT A.STR_USERID FROM `".$Tname."comm_member` AS A WHERE STR_USERID<>'".$arr_Auth[0]."' AND STR_HP='".addHyphen($hp)."' ";
			$arr_Data=mysql_query($Sql_Query);
			$arr_Data_Cnt=mysql_num_rows($arr_Data);    	

			if ($arr_Data_Cnt) {
				?>
		    	<script language="javascript">
					alert("동일한 핸드폰번호가 다른 회원으로 등록되어 있습니다.");
		    		self.close();
		    	</script>
				<?
				exit;
			} else {
			
				$SQL_QUERY = " UPDATE ".$Tname."comm_member SET STR_HP='".addHyphen($hp)."',STR_CERT='M' WHERE STR_USERID='$arr_Auth[0]' ";
				mysql_query($SQL_QUERY);
				?>
		    	<script language="javascript">
					alert("인증되었습니다.");
					opener.document.frm.submit();
		    		self.close();
		    	</script>
				<?
				exit;

			}
    	
    	}
    	exit;
    } else {
    	echo "<script lanuage='javascript'>alert('<?=$returnMsg?>');self.close();</script>";
    	exit;
    }
    
    
    exit;
?>

<html>
<head>
    <title>NICE평가정보 - CheckPlus 본인인증 테스트</title>
</head>
<body>
    <center>
    <p><p><p><p>
    본인인증이 완료 되었습니다.<br>
    <table border=1>
        <tr>
            <td>복호화한 시간</td>
            <td><?= $ciphertime ?> (YYMMDDHHMMSS)</td>
        </tr>
        <tr>
            <td>요청 번호</td>
            <td><?= $requestnumber ?></td>
        </tr>            
        <tr>
            <td>나신평응답 번호</td>
            <td><?= $responsenumber ?></td>
        </tr>            
        <tr>
            <td>인증수단</td>
            <td><?= $authtype ?></td>
        </tr>
                <tr>
            <td>성명</td>
            <?$name = iconv("EUC-KR","UTF-8",$name) ? iconv("EUC-KR","UTF-8",$name) : $name;?>
            <td><?= $name ?></td>
        </tr>
                <tr>
            <td>핸드폰</td>
            <td><?= $hp?></td>
        </tr>
                <tr>
            <td>생년월일</td>
            <td><?= $birthdate ?></td>
        </tr>
                <tr>
            <td>성별</td>
            <td><?= $gender ?></td>
        </tr>
                <tr>
            <td>내/외국인정보</td>
            <td><?= $nationalinfo ?></td>
        </tr>
                <tr>
            <td>DI(64 byte)</td>
            <td><?= $dupinfo ?></td>
        </tr>
                <tr>
            <td>CI(88 byte)</td>
            <td><?= $conninfo ?></td>
        </tr>
        <tr>
          <td>RESERVED1</td>
          <td><?= $sReserved1 ?></td>
	      </tr>
	      <tr>
	          <td>RESERVED2</td>
	          <td><?= $sReserved2 ?></td>
	      </tr>
	      <tr>
	          <td>RESERVED3</td>
	          <td><?= $sReserved3 ?></td>
	      </tr>
    </table>
    </center>
</body>
</html>
