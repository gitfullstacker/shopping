<?include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php";?>
<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php"; ?>

		<div id="container">
			
			<div class="sub_container">
				<div class="contents_w">
					<p class="nav_a">HOME   >   MEDICUM</p>
				</div>
				<div class="sub_visual s_v01 mt20"></div>
				<div class="contents_w">
					<p class="mt30">총 54 개의 가방이 있습니다.</p>
					<div class="item_list mt20">
						<ul>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="detail.php"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="detail.php">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">GET</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">CHANGE</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">GET</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">CHANGE</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">GET</a></p>
							</li>
							<li>
								<p class="rented"><a href="#;" class="btn btn_rented"><i class="icn"></i>RENTED</a></p>
								<p class="zzim_icn"><img src="../images/main/icn_zzim_off.png" alt="" /> 15</p>
								<p class="item_img"><a href="#;"><img src="../images/main/ex01.jpg" data-alt-src="../images/main/ex01_on.jpg" alt="city vs. nature" /></a></p>
								<dl>
									<dt><a href="#;">GUCCI</a></dt>
									<dd>가죽 탑 핸들백</dd>
									<dd>22 x 13 x 6cm</dd>
								</dl>
								<p class="mt15"><a href="#;" class="btn btn_get">CHANGE</a></p>
							</li>
						</ul>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
					
							$(".item_img img").hover(function() {
								var temp = $(this).attr("src");
								$(this).attr("src", $(this).attr("data-alt-src"));
								$(this).attr("data-alt-src", temp);
							});
						})
					</script>
					
					
					
					
				</div>
			</div>
			

		</div>

<? require_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php"; ?>
