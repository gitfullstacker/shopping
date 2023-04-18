</form>	
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/kcp/cfg/site_mbconf_inc.php";?>
<?
    /* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */
    $req_tx          = $_POST[ "req_tx"         ]; // 요청 종류         
    $res_cd          = $_POST[ "res_cd"         ]; // 응답 코드         
    $tran_cd         = $_POST[ "tran_cd"        ]; // 트랜잭션 코드     
    $ordr_idxx       = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호   
    $buyr_name       = $_POST[ "buyr_name"      ]; // 주문자명          
    $enc_info        = $_POST[ "enc_info"       ]; // 암호화 정보       
    $enc_data        = $_POST[ "enc_data"       ]; // 암호화 데이터     
    /* 기타 파라메터 추가 부분 - Start - */
    $param_opt_1    = $_POST[ "param_opt_1"     ]; // 기타 파라메터 추가 부분
    $param_opt_2    = $_POST[ "param_opt_2"     ]; // 기타 파라메터 추가 부분
    $param_opt_3    = $_POST[ "param_opt_3"     ]; // 기타 파라메터 추가 부분
    /* 기타 파라메터 추가 부분 - End -   */

  $tablet_size     = "1.0"; // 화면 사이즈 고정
  $url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]."?int_gubun=".$int_gubun;
?>
<meta name="viewport" content="width=device-width, user-scalable=<?=$tablet_size?>, initial-scale=<?=$tablet_size?>, maximum-scale=<?=$tablet_size?>, minimum-scale=<?=$tablet_size?>">

<link href="/kcp/mo/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>

<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="/kcp/mo/js/approval_key.js"></script>
<script type="text/javascript">

    var controlCss = "/kcp/mo/css/style_mobile.css";
    var isMobile = {
        Android: function()
        {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function()
        {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function()
        {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function()
        {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function()
        {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function()
        {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    if( isMobile.any() )
    {
        document.getElementById("cssLink").setAttribute("href", controlCss);
    }
</script>
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
        {
            month = "0" + month;
        }

        if (parseInt(date) < 10)
        {
            date  = "0" + date;
        }

        var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;

        document.order_info.ordr_idxx.value = order_idxx;
    }

    /* kcp web 결제창 호츨 (변경불가) */
    function call_pay_form()
    {
        var v_frm = document.order_info;

        document.getElementById("mm").style.display = "none";
        document.getElementById("layer_all").style.display  = "block";

        v_frm.target = "frm_all";
        v_frm.action = PayUrl;

	 	if(v_frm.encoding_trans == undefined)     {         
	 		v_frm.action = PayUrl;     
	 	}     else     {         
			if(v_frm.encoding_trans.value == "UTF-8")         {             
				v_frm.action = PayUrl.substring(0,PayUrl.lastIndexOf("/")) + "/jsp/encodingFilter/encodingFilter.jsp";             
				v_frm.PayUrl.value = PayUrl;         
			}         else         {          
				v_frm.action = PayUrl;         
			}     
	 	}   

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
        
        document.getElementById("mm").style.display = "block";
        document.getElementById("layer_all").style.display  = "none";

        if (pay_form.enc_info.value)
        {
            pay_form.submit();
        }
    }
</script>
<div id="mm">
<form name="order_info" method="post">
<input type="hidden" name="ordr_idxx" value="">
<input type="hidden" name="buyr_name" value="<?=$arr_Auth[2]?>">
<input type="hidden" name="kcp_group_id" value="A7EPQ1001835">
<input type="hidden" name="good_mny" value="<?=$arr_Data['INT_PRICE1']?>">
<input type="hidden" name="good_name" value="정기권">
<input type="hidden" name="int_gubun" value="<?=$int_gubun?>">

	
	<div class="mt15" id="display_pay_button" style="display:block"><a href="#" onclick="Save_Click();" class="btn btn_ylw btn_ml f_bd w100p">신청/등록하기</a></div>
	
<!-- 공통정보 -->
<input type="hidden" name="req_tx"          value="pay">                           <!-- 요청 구분 -->
<input type="hidden" name="shop_name"       value="<?=$g_conf_site_name ?>">       <!-- 사이트 이름 --> 
<input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd   ?>">       <!-- 사이트 키 -->
<input type="hidden" name="currency"        value="410"/>                          <!-- 통화 코드 -->
<input type="hidden" name="eng_flag"        value="N"/>                            <!-- 한 / 영 -->
<input type="hidden" name='kcp_cert_flag'   value="N"/>
<input type="hidden" name="kcp_bath_info_view"     value="Y"> 

<!-- 결제등록 키 -->
<input type="hidden" name="approval_key"    id="approval">
<!-- 인증시 필요한 파라미터(변경불가)-->
<input type="hidden" name="escw_used"       value="N">
<input type="hidden" name="pay_method"      value="AUTH">
<input type="hidden" name="ActionResult"    value="batch">
<!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
<input type="hidden" name="Ret_URL"         value="<?=$url?>">
<!-- 화면 크기조정 -->
<input type="hidden" name="tablet_size"     value="<?=$tablet_size?>">

<!-- 추가 파라미터 ( 가맹점에서 별도의 값전달시 param_opt 를 사용하여 값 전달 ) -->
<input type="hidden" name="param_opt_1"     value="">
<input type="hidden" name="param_opt_2"     value="">
<input type="hidden" name="param_opt_3"     value="">

<!-- 결제 정보 등록시 응답 타입 ( 필드가 없거나 값이 '' 일경우 TEXT, 값이 XML 또는 JSON 지원 -->
<input type="hidden" name="response_type"  value="TEXT"/>
<input type="hidden" name="encoding_trans" value="UTF-8"/>
<input type="hidden" name="PayUrl"   id="PayUrl"   value=""/>
<input type="hidden" name="traceNo"  id="traceNo"  value=""/>


</form>		
</div>

<!-- 스마트폰에서 KCP 결제창을 레이어 형태로 구현-->
<div id="layer_all" style="position:absolute; left:0px; top:0px; width:100%;height:600px; border:0px;background-color:#ffffff; z-index:1000000000000000000000; display:none;">
    <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:center">
        <tr height="100%" width="100%">
            <td>
                <iframe name="frm_all" frameborder="0" marginheight="0" marginwidth="0" border="0" width="100%" height="100%" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>
<form name="pay_form" method="post" action="inc_info1_proc.php">
    <input type="hidden" name="req_tx"         value="<?=$req_tx?>">               <!-- 요청 구분          -->
    <input type="hidden" name="res_cd"         value="<?=$res_cd?>">               <!-- 결과 코드          -->
    <input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">              <!-- 트랜잭션 코드      -->
    <input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">            <!-- 주문번호           -->
    <input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">            <!-- 주문자명           -->
    <input type="hidden" name="enc_info"       value="<?=$enc_info?>">
    <input type="hidden" name="enc_data"       value="<?=$enc_data?>">

    <!-- 추가 파라미터 -->
    <input type="hidden" name="param_opt_1"	   value="<?=$param_opt_1?>">
    <input type="hidden" name="param_opt_2"	   value="<?=$param_opt_2?>">
    <input type="hidden" name="param_opt_3"	   value="<?=$param_opt_3?>">
</form>
<script language="javascript">init_orderid();chk_pay();</script>
