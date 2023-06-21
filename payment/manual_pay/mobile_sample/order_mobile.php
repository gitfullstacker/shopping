<?
    /* ============================================================================== */
    /* =   PAGE : 결제 요청 PAGE                                             = */
    /* = -------------------------------------------------------------------------- = */
    /* =   아래의 ※ 필수, ※ 옵션 부분과 매뉴얼을 참조하셔서 연동을   = */
    /* =   진행하여 주시기 바랍니다.                                         = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   환경 설정 파일 Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php 파일을 수정하시기 바랍니다.    = */
    /* = -------------------------------------------------------------------------- = */

     include "../cfg/site_conf_inc.php";       // 환경설정 파일 include

?>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>
<?
    /* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */
    $req_tx          = $_POST[ "req_tx"         ]; // 요청 종류         
    $res_cd          = $_POST[ "res_cd"         ]; // 응답 코드         
    $tran_cd         = $_POST[ "tran_cd"        ]; // 트랜잭션 코드     
    $ordr_idxx       = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호   
    $good_name       = $_POST[ "good_name"      ]; // 상품명            
    $good_mny        = $_POST[ "good_mny"       ]; // 결제 총금액       
    $buyr_name       = $_POST[ "buyr_name"      ]; // 주문자명          
    $buyr_tel1       = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호   
    $buyr_tel2       = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
    $buyr_mail       = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소
    $use_pay_method  = $_POST[ "use_pay_method" ]; // 결제 방법          
	$enc_info        = $_POST[ "enc_info"       ]; // 암호화 정보       
    $enc_data        = $_POST[ "enc_data"       ]; // 암호화 데이터     
    $cash_yn         = $_POST[ "cash_yn"        ];
    $cash_tr_code    = $_POST[ "cash_tr_code"   ];
    /* 기타 파라메터 추가 부분 - Start - */
    $param_opt_1    = $_POST[ "param_opt_1"     ]; // 기타 파라메터 추가 부분
    $param_opt_2    = $_POST[ "param_opt_2"     ]; // 기타 파라메터 추가 부분
    $param_opt_3    = $_POST[ "param_opt_3"     ]; // 기타 파라메터 추가 부분
    /* 기타 파라메터 추가 부분 - End -   */

  $tablet_size     = "1.0"; // 화면 사이즈 고정
  $url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
  <title>가맹점 결제 샘플페이지</title>
  
  <!-- 공통: font preload -->
  <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Regular.woff" type="font/woff" as="font" crossorigin>
  <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Medium.woff" type="font/woff" as="font" crossorigin>
  <link rel="preload" href="https://cdn.kcp.co.kr/font/NotoSansCJKkr-Bold.woff" type="font/woff" as="font" crossorigin>
  <!-- //공통: font preload -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi">  
  <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
  <meta http-equiv="Pragma" content="no-cache"> 
  <meta http-equiv="Expires" content="-1">
  <link href="../static/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>

 <!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="js/approval_key.js"></script>

<script type="text/javascript">
       /* 주문번호 생성 예제 */
      function init_orderid()
      {
        var today = new Date();
        var year  = today.getFullYear();
        var month = today.getMonth() + 1;
        var date  = today.getDate();
        var time  = today.getTime();

        if (parseInt(month) < 10)
          month = "0" + month;

        if (parseInt(date) < 10)
          date  = "0" + date;

        var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;
        var ipgm_date  = year + "" + month + "" + date;

        document.order_info.ordr_idxx.value = order_idxx;
        document.order_info.ipgm_date.value = ipgm_date;
      }

       /* kcp web 결제창 호츨 (변경불가) */
      function call_pay_form()
      {
        var v_frm = document.order_info;
        
        v_frm.action = PayUrl;

        if (v_frm.Ret_URL.value == "")
        {
          /* Ret_URL값은 현 페이지의 URL 입니다. */
          alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
          return false;
        }
        else
        {
          v_frm.submit();
        }
      }

       /* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청 (변경불가) */
      function chk_pay()
      {
        self.name = "tar_opener";
        var pay_form = document.pay_form;

        if (pay_form.res_cd.value == "3001" )
        {
          alert("사용자가 취소하였습니다.");
          pay_form.res_cd.value = "";
        }

        if (pay_form.enc_info.value)
          pay_form.submit();
      }

      function jsf__chk_type()
      {
        if ( document.order_info.ActionResult.value == "card" )
        {
          document.order_info.pay_method.value = "CARD";
        }
        else if ( document.order_info.ActionResult.value == "acnt" )
        {
          document.order_info.pay_method.value = "BANK";
        }
        else if ( document.order_info.ActionResult.value == "vcnt" )
        {
          document.order_info.pay_method.value = "VCNT";
        }
        else if ( document.order_info.ActionResult.value == "mobx" )
        {
          document.order_info.pay_method.value = "MOBX";
        }
        else if ( document.order_info.ActionResult.value == "ocb" )
        {
          document.order_info.pay_method.value = "TPNT";
          document.order_info.van_code.value = "SCSK";
        }
        else if ( document.order_info.ActionResult.value == "tpnt" )
        {
          document.order_info.pay_method.value = "TPNT";
          document.order_info.van_code.value = "SCWB";
        }
        else if ( document.order_info.ActionResult.value == "scbl" )
        {
          document.order_info.pay_method.value = "GIFT";
          document.order_info.van_code.value = "SCBL";
        }
        else if ( document.order_info.ActionResult.value == "sccl" )
        {
          document.order_info.pay_method.value = "GIFT";
          document.order_info.van_code.value = "SCCL";
        }
        else if ( document.order_info.ActionResult.value == "schm" )
        {
          document.order_info.pay_method.value = "GIFT";
          document.order_info.van_code.value = "SCHM";
        }
      }
</script>
</head>

<body onload="jsf__chk_type();init_orderid();chk_pay();">
<div class="wrap">

<!-- 주문정보 입력 form : order_info -->
<form name="order_info" method="post" action="pp_cli_hub.php" >

<?
    /* ============================================================================== */
    /* =   1. 주문 정보 입력                                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
                <!-- header -->
                <div class="header">
                    <a href="../index.html" class="btn-back"><span>뒤로가기</span></a>
                    <h1 class="title">주문/결제 SAMPLE</h1>
                </div>
                <!-- //header -->
                <!-- contents -->
                <div id="skipCont" class="contents">
                    <p class="txt-type-1">이 페이지는 결제를 요청하는 샘플 페이지입니다.</p>
                    <p class="txt-type-2">소스 수정 시 [※ 필수] 또는 [※ 옵션] 표시가 포함된 문장은 가맹점의 상황에 맞게 적절히 수정 적용하시기 바랍니다.</p>
                    <!-- 주문내역 -->
                    <h2 class="title-type-3">주문내역</h2>
                    <ul class="list-type-1">
                        <!-- 주문번호(ordr_idxx) -->
                        <li>
                            <div class="left"><p class="title">주문번호</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <input type="text" name="ordr_idxx" value="" maxlength="40" />
                                    <a href="#none" class="btn-clear"></a>
                                </div>
                            </div>
                        </li>
                        <!-- 상품명(good_name) -->
                        <li>
                            <div class="left"><p class="title">상품명</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <input type="text" name="good_name" value="운동화" />
                                    <a href="#none" class="btn-clear"></a>
                                </div>
                            </div>
                        </li>
                        <!-- 결제금액(good_mny) - ※ 필수 : 값 설정시 ,(콤마)를 제외한 숫자만 입력하여 주십시오. -->
                        <li>
                            <div class="left"><p class="title">상품금액</p></div>
                            <div class="right">
                                <div class="ipt-type-1 gap-2 pc-wd-2">
                                    <input type="text" name="good_mny" value="1004" maxlength="9" />
                                    <a href="#none" class="btn-clear"></a>
                                <span class="txt-price">원</span>
                            </div>
                            </div>
                        </li>
                    </ul>
                    <div class="line-type-1"></div>
                    <!-- 주문정보 -->
                    <h2 class="title-type-3">주문정보</h2>
                    <ul class="list-type-1">
                        <!-- 주문자명(buyr_name) -->
                        <li>
                            <div class="left"><p class="title">주문자명</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <input type="text" name="buyr_name" value="홍길동" />
                                    <a href="#none" class="btn-clear"></a>
                                </div>
                            </div>
                        </li>
                        <!-- 주문자 연락처1(buyr_tel1) -->
                        <li>
                            <div class="left"><p class="title">전화번호</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <input type="text" name="buyr_tel1" value="02-0000-0000" />
                                    <a href="#none" class="btn-clear"></a>
                                </div>
                            </div>
                        </li>
                        <!-- 휴대폰번호(buyr_tel2) -->
                        <li>
                            <div class="left"><p class="title">휴대폰번호</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <input type="text" name="buyr_tel2" value="010-0000-0000" />
                                    <a href="#none" class="btn-clear"></a>
                                </div>
                            </div>
                        </li>
                        <!-- 주문자 E-mail(buyr_mail) -->
                        <li>
                            <div class="left"><p class="title">이메일</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <input type="text" name="buyr_mail" value="test@test.co.kr" />
                                    <a href="#none" class="btn-clear"></a>
                                </div>
                            </div>
                        </li>
                    </ul> 
                    <div class="line-type-1"></div>
<?
        /* ============================================================================== */
        /* =   결제 수단 정보 설정                                                             = */
        /* = -------------------------------------------------------------------------- = */
        /* =   결제에 필요한 결제 수단 정보를 설정합니다.                                               = */
        /* =                                                                            = */
        /* =  신용카드 : CARD, 계좌이체 : BANK, 가상계좌 : VCNT = */
        /* =  포인트   : TPNT, 휴대폰   : MOBX, 상품권   : GIFT = */
        /* =                                                                            = */
        /* =  위와 같이 설정한 경우 표준웹에서 설정한 결제수단이 표시됩니다.                                    = */
		/* =                                                                            = */
        /* = ※ 필수                                                                      = */
        /* =  KCP에 신청된 결제수단으로만 결제가 가능합니다.                                             = */
        /* = -------------------------------------------------------------------------- = */
?>
                    <h2 class="title-type-3">결제수단</h2>
                    <ul class="list-type-1">
                        <!-- 결제수단 -->
                        <li>
                            <div class="left"><p class="title">결제수단</p></div>
                            <div class="right">
                                <div class="ipt-type-1 pc-wd-2">
                                    <select name="ActionResult" onchange="jsf__chk_type();" style="width:100%;height:35px;">
                                        <option value="" selected>선택하십시오</option>
                                        <option value="card">신용카드</option>
                                        <option value="acnt">계좌이체</option>
                                        <option value="vcnt">가상계좌</option>
                                        <option value="mobx">휴대폰</option>
                                        <option value="ocb">OK캐쉬백</option>
                                        <option value="tpnt">복지포인트</option>
                                        <option value="scbl">도서상품권</option>
                                        <option value="sccl">문화상품권</option>
                                        <option value="schm">해피머니</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                    </ul> 
                    <Div Class="Line-Type-1"></Div>
                        <ul class="list-btn-2">
                            <li class="pc-only-show"><a href="../index.html" class="btn-type-3 pc-wd-2">뒤로</a></li>
                            <li><a href="#none" onclick="kcp_AJAX();" class="btn-type-2 pc-wd-3">결제요청</a></li>
                        </ul>
                    </div>
                    <!-- //contents -->
                
                    <!-- footer -->
                    <div class="grid-footer">
                        <div class="inner">
                            <div class="footer">
                                ⓒ NHN KCP Corp.
                            </div>
                        </div>
                    </div>
                    <!--//footer-->
                
                                        
      <!-- 공통: js -->
      <script type="text/javascript" src="../static/js/jquery-1.12.4.min.js"></script>
      <script type="text/javascript" src="../static/js/front.js"></script>
      <!-- //공통: js -->  
      

      <!-- 공통정보 -->
      <input type="hidden" name="req_tx"          value="pay">                           <!-- 요청 구분 -->
      <input type="hidden" name="shop_name"       value="<?= $g_conf_site_name ?>">       <!-- 사이트 이름 --> 
      <input type="hidden" name="site_cd"         value="<?= $g_conf_site_cd   ?>">       <!-- 사이트 키 -->
      <input type="hidden" name="currency"        value="410"/>                          <!-- 통화 코드 -->
      <!-- 결제등록 키 -->
      <input type="hidden" name="approval_key"    id="approval">
      <!-- 인증시 필요한 파라미터(변경불가)-->
      <input type="hidden" name="escw_used"       value="N">
      <input type="hidden" name="pay_method"      value="">
      <input type="hidden" name="van_code"        value="">
      <!-- 신용카드 설정 -->
      <input type="hidden" name="quotaopt"        value="12"/>                           <!-- 최대 할부개월수 -->
      <!-- 가상계좌 설정 -->
      <input type="hidden" name="ipgm_date"       value=""/>

      <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
      <input type="hidden" name="Ret_URL"         value="<?= $url ?>">
      <!-- 화면 크기조정 -->
      <input type="hidden" name="tablet_size"     value="<?= $tablet_size?>">

      <!-- 추가 파라미터 ( 가맹점에서 별도의 값전달시 param_opt 를 사용하여 값 전달 ) -->
      <input type="hidden" name="param_opt_1"     value="">
      <input type="hidden" name="param_opt_2"     value="">
      <input type="hidden" name="param_opt_3"     value="">

      <!-- 결제 정보 등록시 응답 타입 ( 필드가 없거나 값이 '' 일경우 TEXT, 값이 XML 또는 JSON 지원 -->
      <input type="hidden" name="response_type"  value="TEXT"/>
      <input type="hidden" name="PayUrl"   id="PayUrl"   value=""/>
      <input type="hidden" name="traceNo"  id="traceNo"  value=""/>

<?
    /* ============================================================================== */
    /* =   옵션 정보                                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 옵션 - 결제에 필요한 추가 옵션 정보를 입력 및 설정합니다.             = */
    /* = -------------------------------------------------------------------------- = */
    /* 카드사 리스트 설정
    예) 비씨카드와 신한카드 사용 설정시
    <input type="hidden" name='used_card'    value="CCBC:CCLG">

    /*  무이자 옵션
            ※ 설정할부    (가맹점 관리자 페이지에 설정 된 무이자 설정을 따른다)                             - "" 로 설정
            ※ 일반할부    (KCP 이벤트 이외에 설정 된 모든 무이자 설정을 무시한다)                           - "N" 로 설정
            ※ 무이자 할부 (가맹점 관리자 페이지에 설정 된 무이자 이벤트 중 원하는 무이자 설정을 세팅한다)   - "Y" 로 설정
    <input type="hidden" name="kcp_noint"       value=""/> */

    /*  무이자 설정
            ※ 주의 1 : 할부는 결제금액이 50,000 원 이상일 경우에만 가능
            ※ 주의 2 : 무이자 설정값은 무이자 옵션이 Y일 경우에만 결제 창에 적용
            예) BC 2,3,6개월, 국민 3,6개월, 삼성 6,9개월 무이자 : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04
    <input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09"/> */

    /* KCP는 과세상품과 비과세상품을 동시에 판매하는 업체들의 결제관리에 대한 편의성을 제공해드리고자, 
        복합과세 전용 사이트코드를 지원해 드리며 총 금액에 대해 복합과세 처리가 가능하도록 제공하고 있습니다
        복합과세 전용 사이트 코드로 계약하신 가맹점에만 해당이 됩니다
        상품별이 아니라 금액으로 구분하여 요청하셔야 합니다
        총결제 금액은 과세금액 + 부과세 + 비과세금액의 합과 같아야 합니다. 
        (good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny)
    
        <input type="hidden" name="tax_flag"       value="TG03">  <!-- 변경불가	   -->
        <input type="hidden" name="comm_tax_mny"   value=""    >  <!-- 과세금액	   --> 
        <input type="hidden" name="comm_vat_mny"   value=""    >  <!-- 부가세	   -->
        <input type="hidden" name="comm_free_mny"  value=""    >  <!-- 비과세 금액 --> */
	
	/* 결제창 한국어/영어 설정 옵션 (Y : 영어)
	    <input type="hidden" name="eng_flag"        value="Y"/> */
		  
	/* 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다. 상품권 결제 시 반드시 입력하시기 바랍니다.
        <input type="hidden" name="shop_user_id"    value=""/> */
		
    /* 복지포인트 결제시 가맹점에 할당되어진 코드 값을 입력해야합니다.
        <input type="hidden" name="pt_memcorp_cd"   value=""/> */
		
    /* 결제창 현금영수증 노출 설정 옵션 (Y : 노출)
        <input type="hidden" name="disp_tax_yn"     value="Y"/> */
    /* = -------------------------------------------------------------------------- = */
    /* =   옵션 정보 END                                                            = */
    /* ============================================================================== */
?>

</form>
</div>
<form name="pay_form" method="post" action="pp_cli_hub.php">
    <input type="hidden" name="req_tx"         value="<?=$req_tx?>">               <!-- 요청 구분          -->
    <input type="hidden" name="res_cd"         value="<?=$res_cd?>">               <!-- 결과 코드          -->
    <input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">              <!-- 트랜잭션 코드      -->
    <input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">            <!-- 주문번호           -->
    <input type="hidden" name="good_mny"       value="<?=$good_mny?>">             <!-- 휴대폰 결제금액    -->
    <input type="hidden" name="good_name"      value="<?=$good_name?>">            <!-- 상품명             -->
    <input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">            <!-- 주문자명           -->
    <input type="hidden" name="buyr_tel1"      value="<?=$buyr_tel1?>">            <!-- 주문자 전화번호    -->
    <input type="hidden" name="buyr_tel2"      value="<?=$buyr_tel2?>">            <!-- 주문자 휴대폰번호  -->
    <input type="hidden" name="buyr_mail"      value="<?=$buyr_mail?>">            <!-- 주문자 E-mail      -->
    <input type="hidden" name="cash_yn"		   value="<?=$cash_yn?>">              <!-- 현금영수증 등록여부-->
    <input type="hidden" name="enc_info"       value="<?=$enc_info?>">
    <input type="hidden" name="enc_data"       value="<?=$enc_data?>">
    <input type="hidden" name="use_pay_method" value="<?=$use_pay_method?>">
    <input type="hidden" name="cash_tr_code"   value="<?=$cash_tr_code?>">

    <!-- 추가 파라미터 -->
    <input type="hidden" name="param_opt_1"	   value="<?=$param_opt_1?>">
    <input type="hidden" name="param_opt_2"	   value="<?=$param_opt_2?>">
    <input type="hidden" name="param_opt_3"	   value="<?=$param_opt_3?>">
</form>
</body>
</html>
