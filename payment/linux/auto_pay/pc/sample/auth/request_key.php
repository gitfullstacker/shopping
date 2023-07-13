<?
/* ============================================================================== */
/* =   PAGE : 인증 요청 PAGE                                                    = */
/* = -------------------------------------------------------------------------- = */
/* =   신용카드 자동결제 인증을 요청 하는 페이지입니다.                         = */
/* = -------------------------------------------------------------------------- = */
/* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
/* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do                    = */
/* = -------------------------------------------------------------------------- = */
/* =   Copyright (c)  2021   KCP Inc.   All Rights Reserverd.                   = */
/* ============================================================================== */

/* ============================================================================== */
/* =   환경 설정 파일 Include                                                   = */
/* = -------------------------------------------------------------------------- = */
/* =   ※ 주의 ※                                                               = */
/* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
/* = -------------------------------------------------------------------------- = */

function convertEncode($string)
{
    if (mb_detect_encoding($string, 'UTF-8', true) !== false) {
        return iconv('UTF-8', 'EUC-KR', $string);
    } else {
        return $string;
    }
}
?>

<? include "../../cfg/site_conf_inc.php"; ?>

<?
/* = -------------------------------------------------------------------------- = */
/* =   환경 설정 파일 Include End                                               = */
/* ============================================================================== */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

    <script type="text/javascript">
        /****************************************************************/
        /* m_Completepayment  설명                                      */
        /****************************************************************/
        /* 인증완료시 재귀 함수                                         */
        /* 해당 함수명은 절대 변경하면 안됩니다.                        */
        /* 해당 함수의 위치는 payplus.js 보다먼저 선언되어여 합니다.    */
        /* Web 방식의 경우 리턴 값이 form 으로 넘어옴                   */
        /* EXE 방식의 경우 리턴 값이 json 으로 넘어옴                   */
        /****************************************************************/
        function m_Completepayment(FormOrJson, closeEvent) {
            var frm = document.formOrder;

            /********************************************************************/
            /* FormOrJson은 가맹점 임의 활용 금지                               */
            /* frm 값에 FormOrJson 값이 설정 됨 frm 값으로 활용 하셔야 됩니다.  */
            /* FormOrJson 값을 활용 하시려면 기술지원팀으로 문의바랍니다.       */
            /********************************************************************/
            GetField(frm, FormOrJson);


            if (frm.res_cd.value == "0000") {
                /*
                    가맹점 리턴값 처리 영역
                */

                frm.submit();
            } else {
                alert("[" + frm.res_cd.value + "] " + frm.res_msg.value);

                closeEvent();

                window.location.href = "/m/mine/payment/index.php";
            }
        }
    </script>

    <?
    /* ============================================================================== */
    /* =   Javascript source Include                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php 파일을 수정하시기 바랍니다.    = */
    /* = -------------------------------------------------------------------------- = */
    ?>
    <script type="text/javascript" src="<?= $g_conf_js_url ?>"></script>
    <?
    /* = -------------------------------------------------------------------------- = */
    /* =   Javascript source Include END                                            = */
    /* ============================================================================== */
    ?>
    <script type="text/javascript">
        /* Payplus.js 실행 */
        function jsf__pay(form) {
            try {
                KCP_Pay_Execute(form);
            } catch (e) {
                /* IE 에서 결제 정상종료시 throw로 스크립트 종료 */
            }
        }

        /* 주문번호 생성 예제 */
        function init_orderid() {
            var today = new Date();
            var year = today.getFullYear();
            var month = today.getMonth() + 1;
            var date = today.getDate();
            var time = today.getTime();

            if (parseInt(month) < 10) {
                month = "0" + month;
            }

            if (parseInt(date) < 10) {
                date = "0" + date;
            }

            var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;

            document.formOrder.ordr_idxx.value = order_idxx;
        }
    </script>
</head>

<body onload="init_orderid();jsf__pay(document.formOrder);">

    <div id="sample_wrap">

        <form name="formOrder" method="post" action="pp_cli_hub.php" style="display: none;">

            <h1>[신용카드 정기과금] <span> 신용카드 정기과금 인증요청 샘플 페이지</span></h1>
            <!-- 상단 문구 -->
            <div class="sample">
                <p>이 페이지는 요청자의 신원정보와 신용카드 정보를 입력하여, 신용카드의 인증을 요청하는 페이지입니다.</br>
                    요청자의 신원정보인 주민등록 번호와 카드사에 등록된 신원정보의 일치여부까지 인증된 경우, 과금을 신청 할 수 있는 인증키가 리턴됩니다.</br></br>
                    리턴된 인증키로 결제요청 페이지를 통해 정기과금 결제를 요청 할 수 있습니다.</p>
                <!-- 상단 테이블 End -->

                <!-- 인증 정보 타이틀 -->
                <h2>&sdot; 인증 정보</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">

                    <!-- 주문 번호 -->
                    <tr>
                        <th>주문 번호</th>
                        <td><input type="text" name="ordr_idxx" class="w200" value="" maxlength="40" /></td>
                    </tr>
                    <!-- 주문자 이름 -->
                    <tr>
                        <th>주문자명</th>
                        <td><input type="text" name="buyr_name" class="w100" value="<?= convertEncode($_POST['buyr_name']) ?>" /></td>
                    </tr>
                    <!-- 그룹아이디 : 테스트 결제시 설정 값 으로 설정, 리얼 결제시 관리자 생성 그룹아이디 입력 -->
                    <tr>
                        <th>그룹 아이디</th>
                        <td><input type="text" name="kcpgroup_id" value="BA0011000348" class="w100" /></td>
                    </tr>
                </table>

                <!-- 결제 요청/처음으로 이미지 -->
                <div class="btnset" id="display_pay_button" style="display:block">
                    <input name="" type="button" class="submit" value="인증요청" onclick="jsf__pay(this.form);" />
                    <a href="../index.html" class="home">처음으로</a>
                </div>

            </div>
            <div class="footer">
                Copyright (c) KCP INC. All Rights reserved.
            </div>

            <!-- 필수 항목 : 요청구분 -->
            <input type="hidden" name="req_tx" value="pay" />
            <input type="hidden" name="site_cd" value="<?= $g_conf_site_cd   ?>" />
            <input type="hidden" name="site_name" value="<?= $g_conf_site_name ?>" />

            <!-- 결제 방법 : 인증키 요청(AUTH:CARD) -->
            <input type='hidden' name='pay_method' value='AUTH:CARD'>

            <!-- 인증 방식 : 공인인증(BCERT) -->
            <input type='hidden' name='card_cert_type' value='BATCH'>

            <!-- 필수 항목 : PULGIN 설정 정보 변경하지 마세요 -->
            <input type='hidden' name='module_type' value='01'>

            <!-- 필수 항목 : PLUGIN에서 값을 설정하는 부분으로 반드시 포함되어야 합니다. ※수정하지 마십시오.-->
            <input type='hidden' name='res_cd' value=''>
            <input type='hidden' name='res_msg' value=''>
            <input type='hidden' name='trace_no' value=''>
            <input type='hidden' name='enc_info' value=''>
            <input type='hidden' name='enc_data' value=''>
            <input type='hidden' name='tran_cd' value=''>

            <!-- 배치키 발급시 주민번호 입력을 결제창 안에서 진행 -->
            <input type='hidden' name='batch_soc' value='Y'>

            <!-- 상품제공기간 설정 -->
            <input type='hidden' name='good_expr' value='2:1m'>


            <!-- 주민번호 S / 사업자번호 C 픽스 여부 -->
            <!-- <input type='hidden' name='batch_soc_choice' value='' /> -->

            <!-- 배치키 발급시 카드번호 리턴 여부 설정 -->
            <!-- Y : 1234-4567-****-8910 형식, L : 8910 형식(카드번호 끝 4자리) -->
            <input type='hidden' name='batch_cardno_return_yn' value='Y'>

            <!-- batch_cardno_return_yn 설정시 결제창에서 리턴 -->
            <input type='hidden' name='card_mask_no' value=''>

        </form>
    </div>
</body>

</html>