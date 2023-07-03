<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<body>
    <?php
    //**************************************************************************************************************
    //NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED

    //서비스명 :  체크플러스 - 안심본인인증 서비스
    //페이지명 :  체크플러스 - 결과 페이지

    //보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다.
    //인증 후 결과값이 null로 나오는 부분은 관리담당자에게 문의 바랍니다.	
    //**************************************************************************************************************

    session_start();

    $enc_data = $_REQUEST["EncodeData"];        // 암호화된 결과 데이타
    $param_r1 = $_REQUEST["param_r1"];
    $param_r2 = $_REQUEST["param_r2"];
    $param_r3 = $_REQUEST["param_r3"];

    //////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if (preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {
        echo "입력 값 확인이 필요합니다 : " . $match[0];
        exit;
    } // 문자열 점검 추가. 
    if (base64_encode(base64_decode($enc_data)) != $enc_data) {
        echo "입력 값 확인이 필요합니다";
        exit;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

    $str_result = "0";

    if ($enc_data != "") {

        $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;        // 암호화된 결과 데이터의 복호화
        echo "[plaindata]  " . $plaindata . "<br>";

        if ($plaindata == -1) {
            $returnMsg  = "암/복호화 시스템 오류";
        } else if ($plaindata == -4) {
            $returnMsg  = "복호화 처리 오류";
        } else if ($plaindata == -5) {
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        } else if ($plaindata == -6) {
            $returnMsg  = "복호화 데이터 오류";
        } else if ($plaindata == -9) {
            $returnMsg  = "입력값 오류";
        } else if ($plaindata == -12) {
            $returnMsg  = "사이트 비밀번호 오류";
        } else {
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;    // 암호화된 결과 데이터 검증 (복호화한 시간획득)

            $requestnumber = GetValue($plaindata, "REQ_SEQ");
            $responsenumber = GetValue($plaindata, "RES_SEQ");
            $authtype = GetValue($plaindata, "AUTH_TYPE");
            $name = GetValue($plaindata, "NAME");
            //$name = GetValue($plaindata , "UTF8_NAME"); //charset utf8 사용시 주석 해제 후 사용
            $birthdate = GetValue($plaindata, "BIRTHDATE");
            $gender = GetValue($plaindata, "GENDER");
            $nationalinfo = GetValue($plaindata, "NATIONALINFO");    //내/외국인정보(사용자 매뉴얼 참조)
            $dupinfo = GetValue($plaindata, "DI");
            $conninfo = GetValue($plaindata, "CI");
            $mobileno = GetValue($plaindata, "MOBILE_NO");
            $mobileco = GetValue($plaindata, "MOBILE_CO");

            $str_result = "1";

            if (strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0) {
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
                $mobileno = "";
                $mobileco = "";
            }
        }
    }
    ?>

    <?
    function GetValue($str, $name)
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while ($pos1 <= strlen($str)) {
            $pos2 = strpos($str, ":", $pos1);
            $len = substr($str, $pos1, $pos2 - $pos1);
            $key = substr($str, $pos2 + 1, $len);
            $pos1 = $pos2 + $len + 1;
            if ($key == $name) {
                $pos2 = strpos($str, ":", $pos1);
                $len = substr($str, $pos1, $pos2 - $pos1);
                $value = substr($str, $pos2 + 1, $len);
                return $value;
            } else {
                // 다르면 스킵한다.
                $pos2 = strpos($str, ":", $pos1);
                $len = substr($str, $pos1, $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }
        }
    }

    function addHyphen($num)
    {
        return preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $num);
    }


    if ($str_result == "1") {
        $name = iconv("EUC-KR", "UTF-8", $name) ? iconv("EUC-KR", "UTF-8", $name) : $name;

        if ($param_r1 == "") {
            $Sql_Query =    " SELECT A.STR_USERID FROM `" . $Tname . "comm_member` AS A WHERE STR_HP='" . addHyphen($mobileno) . "' ";
            $arr_Data = mysql_query($Sql_Query);
            $arr_Data_Cnt = mysql_num_rows($arr_Data);

            if ($arr_Data_Cnt) {
    ?>
                <script language="javascript">
                    alert("핸드폰이 이미 등록되어 있습니다.");
                    window.close();
                </script>
        <?
                exit;
            }
        }

        $_SESSION['USERJ_CERT'] = "M";
        $_SESSION['USERJ_NAME'] = $name;
        $_SESSION['USERJ_HP'] = addHyphen($mobileno);
        $_SESSION['USERJ_BIRTH'] = $birthdate;
        $_SESSION['USERJ_SEX'] = $gender;
        ?>

        <script language="javascript">
            console.log('<?= addHyphen($mobileno) ?>' + ' ' + '<?= $birthdate ?>')
            // window.close();
            if (<?= $param_r1 == '' ? 'true' : 'false' ?>) {
                window.opener.setVerifyPhoneNumber('<?= addHyphen($mobileno) ?>', '<?= $birthdate ?>');
            } else {
                window.opener.setVerifyPhoneNumber('<?= addHyphen($mobileno) ?>', '<?= $param_r1 ?>');
            }
        </script>
    <?
        exit;
    } else {
        echo "<script lanuage='javascript'>alert('" . $returnMsg . "');self.close();</script>";
        exit;
    }
    exit;
    ?>
</body>

</html>