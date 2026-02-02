<style>
<?php if(!G5_IS_MOBILE) { //pc전용 ?>
#_footerContainer{padding:50px 0;background:#F6F6F6;color:#757575;}
#_footerContainer .inner{display:flex;gap:50px;}
#_footerContainer .inner .ftCon01{font-size:14px;display:flex;flex-direction:column;gap:15px;}
#_footerContainer .inner .ftCon01 h4{font-size:20px;font-weight:700;}
#_footerContainer .inner .ftCon01 ul{display:flex;flex-direction:column;gap:15px;}
#_footerContainer .inner .ftCon01 ul li{display:flex;align-items:center;gap:20px;font-size:13px;}
#_footerContainer .inner .ftCon01 ul li .label{font-size:14px;height:43px;width:183px;display:flex;align-items:center;justify-content:center;border:1px solid #757575;background:transparent;}
#_footerContainer .inner .ftCon02{margin-left:auto;display:flex;flex-direction:column;gap:15px;}
#_footerContainer .inner .ftCon02 .ft02_li01{display:flex;align-items:center;gap:20px;}
#_footerContainer .inner .ftCon02 .snsCon{display:flex;align-items:center;gap:20px;}
#_footerCopyrights{background:rgba(235, 230, 225,0.4);height:55px;display:flex;align-items:center;justify-content:center;}
<?php } else { //mobile전용 ?>
#_footerContainer{padding:42px 0;background:#F6F6F6;color:#757575;font-size:12px;}
#_footerContainer h4{font-size:13px;font-weight:600;}
#_footerContainer ul{display:flex;gap:10px;flex-wrap:wrap;}
#_footerContainer ul li{display:flex;align-items:center;gap:20px;font-size:13px;}
#_footerContainer ul li .label{font-size:14px;height:43px;width:183px;display:flex;align-items:center;justify-content:center;border:1px solid #757575;background:transparent;}
#_footerContainer .snsCon{display:flex;align-items:center;gap:20px;}
#_footerCopyrights{background:rgba(235, 230, 225,0.5);height:55px;display:flex;align-items:center;justify-content:center;}
<?php } ?>
</style>

<?php if(!G5_IS_MOBILE) { //pc전용 ?>
<div id="_footerContainer" style="padding:35px">
	<div class="max-width inner">
		<div class="ftCon01">
			<h4>고객센터</h4>
			<h4>02-6670-3672</h4>
			<p>
				평일 10:00~17:00 (점심시간 12:30~13:30)<br>
				주말, 공휴일 휴무
			</p>			
			<ul>
				<!-- <li>
					<a href="http://pf.kakao.com/_xdExdFs" target="_blank" class="label">카카오 문의</a>
					<p>월~금  오전10시~오후5시(점심시간 12:30~13:30)<br>주말,공휴일 휴무</p>
				</li> -->
				<li>
					<a href="https://kaviar.co.kr/bbs/board.php?bo_table=11_inquiry"  class="label">1:1문의</a>
					<p>상품/주문 문의 및 대량 주문 문의 시 1:1문의로 접수 해주세요.</p>
				</li>
				<li>
					<span class="label">반품주소</span>
					<p>경기도 안성시 일죽면 주천리 73 1층 동안성 풀필먼트(캐비아)</p>
				</li>
			</ul>
		</div>
		<div class="ftCon02">
			<ul class="ft02_li01">
				<li><a href="<?=get_pretty_url('intro')?>">캐비아 소개</a></li>
				<li><a href="<?=get_pretty_url('info')?>">이용안내</a></li>
				<li><a href="<?=get_pretty_url('terms')?>">이용약관</a></li>
				<li><a href="<?=get_pretty_url('privacy_policy')?>">개인정보처리방침</a></li>
			</ul>
			<div>
				<h6>BANKING</h6>
				신한은행&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;140-013-020014 주식회사 캐비아
			</div>
			<div>
				<h6>커뮤니티</h6>
				<ul class="ft02_li01">
					<li><a href="<?=get_pretty_url('notice')?>">공지사항</a></li>
					<li><a href="<?=get_pretty_url('shop_faq')?>">자주묻는 질문</a></li>
					<li><a href="<?=shop_short_url_my('event')?>">이벤트</a></li>
					<li><a href="<?=G5_SHOP_URL.'/myitemuselist.php'?>">리뷰</a></li>
				</ul>
			</div>
			<div class="snsCon">
				<a href="https://www.instagram.com/kaviar_official/?igshid=543mvtlpql9k" target="_blank" class="insta"><img src="<?=G5_THIS_URL?>/img/insta.png"></a>
				<a href="https://www.youtube.com/channel/UCdjiFygX13EDkMQhCZQuy0w" target="_blank" class="youtube"><img src="<?=G5_THIS_URL?>/img/youtube.png"></a>
				<!-- <a href="#" class="facebook"><img src="<?=G5_THIS_URL?>/img/facebook.png"></a> -->
				<a href="https://blog.naver.com/kaviar_in8" target="_blank" class="naverblog"><img src="<?=G5_THIS_URL?>/img/naverblog.png"></a>
			</div>
			
			<p class="mt10"><img src="<?=G5_THIS_URL?>/img/footer_logo.png"></p>
			<p style="line-height:1.8em;">
				상호명 : 캐비아 ㅣ 대표자 : 박영식ㅣ사업자등록번호 : 185-81-01880 <a href="https://www.ftc.go.kr/bizCommPop.do?wrkr_no=1858101880&apv_perm_no=" target="_blank">[사업자정보확인]</a><br>
				통신판매업신고번호 : 제2020-서울강남-00369호<br>
				사업장 소재지 : 서울 강남구 언주로 833(신사동)<br>
				개인정보보호책임자 : 김재태 / jtkim@kaviar.kr
			</p>
		</div>	
	</div>	
</div>
<?php } else { //mobile전용 ?>
<style>
.notClickedIcon:before {
  content: "▼"; /* 눌리지 않은 상태 아이콘 */
}

.clickedIcon:before {
  content: "▲"; /* 눌린 상태 아이콘 */
}

</style>
<div id="_footerContainer" style="padding:25px">
	<ul>
		<li><a href="<?=get_pretty_url('intro')?>">캐비아 소개</a></li>
		<li><a href="<?=get_pretty_url('info')?>">이용안내</a></li>
		<li><a href="<?=get_pretty_url('terms')?>">이용약관</a></li>
		<li><a href="<?=get_pretty_url('privacy_policy')?>">개인정보처리방침</a></li>
		<li><a href="<?=get_pretty_url('11_inquiry')?>">1:1문의하기</a></li>
	</ul>
	<p class="mt20"><img src="<?=G5_THIS_URL?>/img/footer_logo.png"></p>
	<div style="padding-top:20px;font-weight:bold;font-size:14px;" id="toggleButton">캐비아 사업자정보 <span class="clickedIcon" id="icon"></span></div>
	<div id="myDiv" style="display:none">
		<p class="mt15" style="line-height:1.8em;">
			상호명 : 캐비아 ㅣ 대표자 : 박영식<br>
			사업자등록번호 : 185-81-01880 <a href="https://www.ftc.go.kr/bizCommPop.do?wrkr_no=1858101880&apv_perm_no=" target="_blank">[사업자정보확인]</a><br>
			통신판매업신고번호 : 제2020-서울강남-00369호<br>
			사업장 소재지 : 서울 강남구 언주로 833(신사동)<br>
			개인정보보호책임자 : 김재태 / jtkim@kaviar.kr
		</p>
		<h4 class="mt30">고객센터 : 02-6670-3672</h4>
		<p class="mt15">
			평일 10:00~17:00 (점심시간 13:00~14:00)<br>
			주말, 공휴일 휴무
		</p>
		<p class="mt15">
			대량주문 문의  : <b>02-6670-3672</b>
		</p>
		<h4 class="mt30">BANKING</h4>
		<p>신한은행&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;140-013-020014 주식회사 캐비아</p>
	</div>
		<h4 class="mt25">커뮤니티</h4>
		<div class="snsCon mt10">
			<a href="https://www.instagram.com/kaviar_official/?igshid=543mvtlpql9k" target="_blank" class="insta"><img src="<?=G5_THIS_URL?>/img/insta.png"></a>
			<a href="https://www.youtube.com/channel/UCdjiFygX13EDkMQhCZQuy0w" target="_blank" class="youtube"><img src="<?=G5_THIS_URL?>/img/youtube.png"></a>
			<!-- <a href="#" class="facebook"><img src="<?=G5_THIS_URL?>/img/facebook.png"></a> -->
			<a href="https://blog.naver.com/kaviar_in8" target="_blank" class="naverblog"><img src="<?=G5_THIS_URL?>/img/naverblog.png"></a>
		</div>	
	
</div>
<?php } ?>
<script>
document.getElementById("toggleButton").addEventListener("click", function() {
  var div = document.getElementById("myDiv");
  var icon = document.getElementById("icon");
  div.classList.toggle("visible");

  if (div.style.display === "none") {
    div.style.display = "block"; // 보이게 설정
    icon.classList.remove("clickedIcon");
    icon.classList.add("notClickedIcon"); // 아이콘 변경
  } else {
    div.style.display = "none"; // 숨김 설정
    icon.classList.remove("notClickedIcon");
    icon.classList.add("clickedIcon"); // 아이콘 변경
  }
});

</script>
<div id="_footerCopyrights">
	<div class="max-width tcenter">
		Copyright © 캐비아. All Rights Reserved.
	</div>
</div>
