<?include_once $_SERVER['DOCUMENT_ROOT'] . "/kcp/cfg/site_bconf_inc.php";?>
    
    <input type="hidden" name="ordr_idxx" value="" />
    <input type="hidden" name="buyr_name" value="<?=$arr_Auth[2]?>"/>
    <input type="hidden" name="kcpgroup_id" value="A7EPQ1001835" />
    
    
    <input type="hidden" name="req_tx"         value="pay"/>
    <input type="hidden" name="site_cd"        value="<?=$g_conf_site_cd   ?>" />

    <!-- 결제 방법 : 인증키 요청(AUTH:CARD) -->
    <input type='hidden' name='pay_method'     value='AUTH:CARD'>

    <!-- 인증 방식 : 공인인증(BCERT) -->
    <input type='hidden' name='card_cert_type' value='BATCH'>

    <!-- 필수 항목 : PULGIN 설정 정보 변경하지 마세요 -->
    <input type='hidden' name='module_type'    value='01'>

    <!-- 필수 항목 : PLUGIN에서 값을 설정하는 부분으로 반드시 포함되어야 합니다. ※수정하지 마십시오.-->
    <input type='hidden' name='res_cd'         value=''>
    <input type='hidden' name='res_msg'        value=''>
    <input type='hidden' name='trace_no'       value=''>
    <input type='hidden' name='enc_info'       value=''>
    <input type='hidden' name='enc_data'       value=''>
    <input type='hidden' name='tran_cd'        value=''>

    <!-- 배치키 발급시 주민번호 입력을 결제창 안에서 진행 -->
    <input type='hidden' name='batch_soc'      value='Y'>

    <!-- 상품제공기간 설정 -->
    <input type='hidden' name='good_expr' value='2:1m'>
    
    
	<div class="center mt45" id="display_pay_button" style="display:block">
		<!--<a href="javascript:jsf__pay(this.form);" class="btn btn_l btn_bk w w270 f_bd">결제하기</a>//-->
		<input name="" type="button" value="결제하기" onclick="jsf__pay(this.form);"  class="btn btn_l btn_bk w w270 f_bd"/>
	</div>
    <div id="display_setup_message" style="display:none">
       <p class="txt">
       결제를 계속 하시려면 상단의 노란색 표시줄을 클릭 하시거나 <a href="https://pay.kcp.co.kr/plugin_new/file/KCPPayUXSetup.exe"><span>[수동설치]</span></a>를 눌러
       Payplus Plug-in을 설치하시기 바랍니다.
       [수동설치]를 눌러 설치하신 경우 새로고침(F5)키를 눌러 진행하시기 바랍니다.
       </p>
     </div>

	</form>					
	
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
		function m_Completepayment( FormOrJson, closeEvent ) 
        {
            var frm = document.frm; 
         
            /********************************************************************/
            /* FormOrJson은 가맹점 임의 활용 금지                               */
            /* frm 값에 FormOrJson 값이 설정 됨 frm 값으로 활용 하셔야 됩니다.  */
            /* FormOrJson 값을 활용 하시려면 기술지원팀으로 문의바랍니다.       */
            /********************************************************************/
            GetField( frm, FormOrJson ); 

            
            if( frm.res_cd.value == "0000" )
            {
			    //alert("결제 승인 요청 전,\n\n반드시 결제창에서 고객님이 결제 인증 완료 후\n\n리턴 받은 ordr_chk 와 업체 측 주문정보를\n\n다시 한번 검증 후 결제 승인 요청하시기 바랍니다."); //업체 연동 시 필수 확인 사항.
                /*
                    가맹점 리턴값 처리 영역
                */
             
                frm.submit(); 
            }
            else
            {
                alert( "[" + frm.res_cd.value + "] " + frm.res_msg.value );
                
                closeEvent();
            }
        }
</script>
<script type="text/javascript" src="<?=$g_conf_js_url ?>"></script>

    <script type="text/javascript">
        /* 플러그인 설치(확인) */
        kcpTx_install();      

        /* Payplus Plug-in 실행 */
        function jsf__pay( form )
        {
            try
            {	
            	document.frm.action ="inc_info1_proc.php";
                KCP_Pay_Execute( form ); 
            }
            catch (e)
            {
                /* IE 에서 결제 정상종료시 throw로 스크립트 종료 */ 
            }
        }             



        function jsf__chk( form )
        {
            if ( form.buyr_name.value == "" )
            {
                alert("요청자 이름을 정확히 입력해 주시기 바랍니다.");
                form.buyr_name.focus();
                return false;
            }
            else if ( form.kcpgroup_id.value.length = "" )
            {
                alert("그룹 아이디를 정확히 입력해 주시기 바랍니다.");
                form.kcpgroup_id.focus();
                return false;
            }
            else
            {
                return true;
            }
        }

        // 주문번호 생성 예제
        function init_orderid()
        {
            var today = new Date();
            var year  = today.getFullYear();
            var month = today.getMonth()+ 1;
            var date  = today.getDate();
            var time  = today.getTime();

            if(parseInt(month) < 10) { month = "0" + month; }
            if(parseInt(date) < 10) { date = "0" + date; }

            var vOrderID = year + "" + month + "" + date + "" + time;

            document.frm.ordr_idxx.value = vOrderID;

            setTimeout("init_pay_button();",300);
        }

        /* onLoad 이벤트 시 Payplus Plug-in이 실행되도록 구성하시려면 다음의 구문을 onLoad 이벤트에 넣어주시기 바랍니다. */
        function onload_pay()
        {
             if( jsf__pay(document.frm) )
                document.frm.submit();
        }

    </script>
                     
    <script language="javascript">init_orderid();</script>