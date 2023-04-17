<!--
	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 공백검사함수
		입력값 : sVal[검사할데이터값]
		출력값 : blnFlag[true:공백아님, false:공백]
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fncCheckBlank(sVal)
	{
		var bln_Flag = false;
		var strBlank = sVal.replace(/\r\n/, " ");
		var regEmptyChk = /\S/;
		bln_Flag = regEmptyChk.test(strBlank);
		return bln_Flag;
	}

	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 숫자검사함수
		입력값 : sVal[검사할데이터값]
		출력값 : blnFlag[true:숫자, false:숫자아님]
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fncCheckDigit(sVal)
	{
		var bln_Flag = false;
		var regDigitChk = /[^0-9]/;
		bln_Flag = (regDigitChk.test(sVal)==true)? false : true;
		return bln_Flag;
	}

	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 경고 메시지 출력 후 포커스 이동 함수
		입력값 : oForm[폼이름]
				oView[출력할HTML객체]
				sAlt[경고메시지문자]
		출력값 : oView==null => 경고창 띄운 후 오류 폼에 선택포커스
				oView!=null => 출력할 HTML 객체에 경고 출력 후 오류 폼에 선택포커스		
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fncFocusAlert(oForm, oView, sAlt)
	{
		if(typeof(oView)=="object" && oView!=null)
			oView.innerHTML = "<font color='red'>* " + sAlt + "</font>";
		else
			alert(sAlt);
		oForm.select();
		return false;
	}

	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 모든 레이어 숨김 함수
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fnc_Off_Layer()
	{
		var int_Layer_Cnt = document.all.length;
		for(var i=0; i<int_Layer_Cnt; i++)
		{
			if(document.all[i].style.visibility=="visible")
			{
				document.all[i].style.zIndex=0;
				document.all[i].style.visibility="hidden";
			}
		}
	}

	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 날짜 형식 검사 및 유효 년/월/일 확인 함수
		입력값 : dForm[날짜형식의데이터]			예) 2004-08-02
		출력값 : blnFlag[true:날짜형식에맞음, false:날짜형식이아님]
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fncRightDate(dForm)
	{
		var blnFlag = false;

		var dateToday = new Date();
		var dateCurYear = dateToday.getYear();
		var dateCurMonth = dateToday.getMonth()+1;
		var dateCurDay = dateToday.getDate();
		dateCurMonth = (dateCurMonth<10)? "0"+dateCurMonth : dateCurMonth;
		dateCurDay = (dateCurDay<10)? "0"+dateCurDay : dateCurDay;

		var regDate = /\d{4}-\d{2}-\d{2}/;
		if(!regDate.test(dForm.value))
		{
			objAlert(dForm, null, "날짜 형식에 맞지 않습니다.\n\n입력예 : "+dateCurYear+"-"+dateCurMonth+"-"+dateCurDay);
			return blnFlag;
		}

		/*년, 월, 일 유효성 검사 로직 시작*/
		var regDate = new RegExp("([0-9]{4})-([0-9]{2})-([0-9]{2})","ig");
		var arrPDate = regDate.exec(dForm.value);

		if(RegExp.$1<1950 || RegExp.$1>3000)
		{
			fncFocusAlert(dForm, null, "년도 범위는 1950~2999년 까지 입력 가능합니다.")
			return blnFlag;
		}
		if(RegExp.$2<1 || RegExp.$2>12)
		{
			fncFocusAlert(dForm, null, "월 범위는 01~12월 까지 입력 가능합니다.");
			return blnFlag;
		}

		var show_date = new Date (RegExp.$1,RegExp.$2-1,1);
		var begin_day = new Date (show_date.getYear(),show_date.getMonth(),1);
		var begin_day_date = begin_day.getDay();
		var end_day = new Date (show_date.getYear(),show_date.getMonth()+1,1);
		var count_day = (end_day - begin_day)/1000/60/60/24;

		if(RegExp.$3<1 || RegExp.$3>count_day)
		{
			fncFocusAlert(dForm, null, RegExp.$1+"년 "+RegExp.$2+" 월은 01~"+count_day+"일 까지 입니다.");
			return blnFlag;
		}
		/*년, 월, 일 검사 프로그램 종료*/
		blnFlag = true;
		return blnFlag;
	}

	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		기능 : 날짜형식의 데이터를 숫자형 데이터로 변환
		입력값 : sVal[날짜형식의데이터]				예) 2004-08-02
		출력값 : int_Rtn_Val[변환된숫자형데이터]	예) 20040802
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fncDateConvInt(sVal)
	{
		var int_Rtn_Val = 0;
		var regDate = new RegExp("([0-9]{4})-([0-9]{2})-([0-9]{2})","ig");
		var arrDate = regDate.exec(sVal);
		int_Rtn_Val = parseInt(RegExp.$1 + RegExp.$2 + RegExp.$3);
		return int_Rtn_Val;
	}

	/* ++++++++++++++++++++++++++++++++++++++ *\
		기능설명 : 이메일 유효성 검사 함수
		입력값 : pr_Val[이메일데이터]
		출력값 : bln_Flag[true : 이메일맞음, false : 이메일아님]
	\* ++++++++++++++++++++++++++++++++++++++ */
	function fnc_Email_Conf(pr_Val)
	{
		var bln_Flag = false;
		var reg_Email_Chk = /^[_a-zA-Z0-9]+([-+.][_a-zA-Z0-9]+)*@[_a-zA-Z0-9]+([-.][_a-zA-Z0-9]+)*\.[_a-zA-Z0-9]+([-.][_a-zA-Z0-9]+)*$/;
		bln_Flag = reg_Email_Chk.test(pr_Val);
		return bln_Flag;
	}

	/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *\
		제작자 : 김진규(p7227kjg@dreamwiz.com)
		제작일 : 2002-10-23
		기능설명 : 입력한 Byte 알아내는 스크립트

		입력값 :	 oForm[입력폼객체]		예) document.forms[name].elements[name]
				 oView[출력할객체]		예) document.all[name]
				 iLen[입력제한바이트수]

		반환값 : oView==null => byteChk[입력한바이트수 & 이를출력할HTML태그]
				oView!=null => byteChk[입력한바이트수]

		사용예 : 입력 Byte 실시간 출력 - onkeyup="fncChkByte(object{입력폼객체}, object[|null]{출력할객체}, integer{바이트수});"
				저장시 입력값 검사 후 반환 - var intByte = fncChkByte(object{입력폼객체}, object[|null]{출력할객체}, integer{바이트수});
	\* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	function fncChkByte(oForm, oView, iLen)
	{
		var strVal = oForm.value;
		var byteChk = 0;

		for(var i=0; i<strVal.length+1; i++)
		{
			if(escape(strVal.charAt(i)).length>4)
			{
				byteChk += 2;
			}
			else
			{
				byteChk += 1;
			}
		}
		byteChk = byteChk - 1;

		if(typeof(oView)=="object" && oView!=null)
		{
			if(byteChk>iLen)
				oView.innerHTML = "<font color='red'>"+byteChk+"</font>";
			else
				oView.innerHTML = byteChk;
		}
		else{ return byteChk; }
	}
//-->
















