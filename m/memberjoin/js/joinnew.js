function Save_Click() {
   if (ValidChk()==false) return;

   //document.frm.target = "_self";
   fnPopup();
   //document.frm.action = "join02.php";
   //document.frm.submit();
}
function ValidChk()   {
   var f = document.frm;

   if(f.str_agree1.checked==false || f.str_agree2.checked==false || f.str_agree3.checked==false || f.str_agree4.checked==false){
          alert("\n개인정보처리방침에 동의하셔야 합니다.");
        return false;
      }
   return true;
}

window.name ="Parent_window";

//   function fnPopup(){
//      window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
//      document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
//      document.form_chk.target = "popupChk";
//      document.form_chk.submit();
//   }

function fnPopup(){
//      document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
//      document.form_chk.submit();

   var enc_data = document.form_chk.EncodeData.value;
   window.open('nice.php?enc_data='+enc_data, 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
}

function Save_Click2() {
   fnPopup2();
}

function fnPopup2(){
   window.open('aa.php', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
}
function fnc_submit() {
   document.frm.submit();

}




