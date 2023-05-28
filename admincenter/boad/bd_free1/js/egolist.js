function Set_Best_Click(seq) {
	$.ajax({
		url: "/admincenter/boad/bd_free1/set_best_review.php",
		data: {
			seq: seq
		},
		success: function(resultString) {
			result = JSON.parse(resultString);
            if (result['status'] == 200) {
                $("#best_btn_" + seq).html(result['data'] == 0 ? '적용' : '해제');
            }
		}
	});
}

function Set_Hide_Click(seq) {
	$.ajax({
		url: "/admincenter/boad/bd_free1/set_hide_review.php",
		data: {
			seq: seq
		},
		success: function(resultString) {
			result = JSON.parse(resultString);
            if (result['status'] == 200) {
                $("#hide_btn_" + seq).html(result['data'] == 0 ? '적용' : '해제');
            }
		}
	});
}