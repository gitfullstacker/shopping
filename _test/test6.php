<?
				$day = "2017-05-22";
				$lastnum = date("Y-m-d", strtotime($day."-1day"));
				
				$last1=date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastnum))."1day"));
				
				if ($last1 <= date("Y-m-d")) {
					$last1 = date("Y-m-d");
				}
				
				echo $last1;
?>