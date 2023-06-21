<?
    /* ============================================================================== */
    /* =   PAGE : 결제 결과 출력 PAGE                                               = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 요청 결과값을 출력하는 페이지입니다.                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : https://kcp.co.kr/technique.requestcode.do 			        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2023   NHN KCP Inc.   All Rights Reserverd.                   = */
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

    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   지불 결과                                                                = */
    /* = -------------------------------------------------------------------------- = */
    // 결과 코드
    $res_cd           = $_POST[ "res_cd"         ];      // 결과 코드
    $res_msg          = $_POST[ "res_msg"        ];      // 결과 메시지
    /* = -------------------------------------------------------------------------- = */
    // 주문 정보
    $ordr_idxx        = $_POST[ "ordr_idxx"      ];      // 주문번호
    $good_name        = $_POST[ "good_name"      ];      // 상품명
    $good_mny         = $_POST[ "good_mny"       ];      // 결제 금액
    $buyr_name        = $_POST[ "buyr_name"      ];      // 구매자명
    /* = -------------------------------------------------------------------------- = */
    // 신용카드
    $card_cd          = $_POST[ "card_cd"        ];      // 카드 코드
    $card_name        = $_POST[ "card_name"      ];      // 카드명
    $batch_key        = $_POST[ "batch_key"      ];      // 배치 인증키
    /* = -------------------------------------------------------------------------- = */
    /* 기타 파라메터 추가 부분 - Start - */
    $param_opt_1     = $_POST[ "param_opt_1"    ];       // 기타 파라메터 추가 부분
    $param_opt_2     = $_POST[ "param_opt_2"    ];       // 기타 파라메터 추가 부분
    $param_opt_3     = $_POST[ "param_opt_3"    ];       // 기타 파라메터 추가 부분
    /* 기타 파라메터 추가 부분 - End -   */
    /* ============================================================================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>*** NHN KCP [AX-HUB Version] ***</title>
<meta name="viewport" content="width=device-width, user-scalable=1.0, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>
<script type="text/javascript">
  var controlCss = "css/style_mobile.css";
  var isMobile = {
    Android: function() {
      return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
      return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
      return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
      return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
      return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
      return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
  };

  if( isMobile.any() )
    document.getElementById("cssLink").setAttribute("href", controlCss);
</script>
</head>
<body>
<form name="cancel" method="post">
<div id="sample_wrap">
    <!--타이틀-->
    <h1>[결과출력] <span>이 페이지는 결제 결과를 출력하는 샘플(예시) 페이지입니다.</span></h1>
    <!--//타이틀-->
    <div class="sample">
    <!--상단문구-->
    <p>
        요청 결과를 출력하는 페이지 입니다.<br />
        요청이 정상적으로 처리된 경우 결과코드(res_cd)값이 0000으로 표시됩니다.
    </p>
    <!--//상단문구-->

<?
    /* ============================================================================== */
    /* =   결제 결과 코드 및 메시지 출력(결과페이지에 반드시 출력해주시기 바랍니다.)= */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 정상 : res_cd값이 0000으로 설정됩니다.                              = */
    /* =   결제 실패 : res_cd값이 0000이외의 값으로 설정됩니다.                     = */
    /* = -------------------------------------------------------------------------- = */
?>
        <h2>&sdot; 처리 결과</h2>
        <table class="tbl" cellpadding="0" cellspacing="0">
            <!-- 결과 코드 -->
            <tr>
              <th>결과 코드</th>
              <td><?=$res_cd?></td>
            </tr>
                  <!-- 결과 메시지 -->
            <tr>
              <th>결과 메세지</th>
              <td><?=$res_msg?></td>
            </tr>
        </table>
<?
    /* ============================================================================== */
    /* =   1. 정상 결제시 결제 결과 출력 ( res_cd값이 0000인 경우)                  = */
    /* = -------------------------------------------------------------------------- = */
        if ( $res_cd == "0000" )
        {
?>
            <h2>&sdot; 주문 정보</h2>
            <table class="tbl" cellpadding="0" cellspacing="0">
                <!-- 주문번호 -->
                <tr>
                    <th>주문번호</th>
                    <td><?=$ordr_idxx?></td>
                </tr>
                <!-- 주문자명 -->
                <tr>
                    <th>주문자명</th>
                    <td><?=$buyr_name?></td>
                </tr>
                </table>

                <h2>&sdot; 정기 과금 정보</h2>
                <table class="tbl" cellpadding="0" cellspacing="0">
                <!-- 결제 카드 -->
                <tr>
                    <th>인증카드코드</th>
                    <td><?=$card_cd?></td>
                </tr>
                <!-- 결제 카드명 -->
                <tr>
                    <th>인증카드명</th>
                    <td><?=$card_name?></td>
                </tr>
                <!-- 배치키 -->
                <tr>
                    <th>배치키</th>
                    <td><?=$batch_key?></td>
                </tr>
            </table>
<?
        }
?>
                <!-- 처음으로 이미지 버튼 -->
                <tr>
                <div class="btnset">
                <a href="../index.html" class="home">처음으로</a>
                </div>
                </tr>
              </tr>
            </div>
        <div class="footer">
                Copyright (c) NHN KCP INC. All Rights reserved.
        </div>
    </div>
  </body>
</html>