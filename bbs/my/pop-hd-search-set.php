
<div class="layer-popup" id="pop-hd-search-set">
	<!--<span class="pop-closer">팝업닫기</span>-->
	<div class="popContainer">
		<div class="pop-inner" style="<?=G5_IS_MOBILE?'padding:30px 20px':'width:800px;padding:45px';?>">
			<span class="pop-closer">팝업닫기</span>
			
			<fieldset id="hd-search-set">
				<div class="fs20 noto600 mb20">찾으시는 내용이 있으신가요?</div>
				<legend>사이트 내 전체검색</legend>
				<form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
				<input type="hidden" name="sfl" value="wr_subject||wr_content||wr_tag||wr_1||wr_2||wr_3">
				<input type="hidden" name="sop" value="and">
				<?php if($group['gr_use_layout']) echo '<input type="hidden" name="gr_id" value="'.$group['gr_id'].'">'; ?>
					<div class="inputContainer">
						<input type="text" name="stx" id="hdSchStx" class="span" maxlength="30" placeholder="검색어를 입력해주세요">					
						<button type="submit" id="sch_submit" value="검색">검색</button>
					</div>
					<?php if($config['cf_search_keyword']) {
						echo '<div class="reco-keyword mt30">';
						echo '<span class="title">추천 검색어</span>';
						echo '<ul>';
						$cf_search_keyword = explode(",",$config['cf_search_keyword']);
						for($k=0; $k<count($cf_search_keyword); $k++) {
							echo '<li><span class="keyword">'.$cf_search_keyword[$k].'</span></li>';
						}					
						echo '</ul>';
						echo '</div>';
					} ?>
				</form>
				<script>
				function fsearchbox_submit(f) {
					if (f.stx.value.length < 2) {
						alert("검색어는 두글자 이상 입력하십시오.");
						f.stx.select();
						f.stx.focus();
						return false;
					}
					var cnt = 0;
					for (var i=0; i<f.stx.value.length; i++) {
						if (f.stx.value.charAt(i) == ' ')
							cnt++;
					}
					if (cnt > 1) {
						alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
						f.stx.select();
						f.stx.focus();
						return false;
					}
					return true;
				}
				$('.reco-keyword .keyword').click(function() {
					let gourl = '<?=G5_BBS_URL?>/search.php?sfl=wr_subject%7C%7Cwr_content%7C%7Cwr_tag%7C%7Cwr_1%7C%7Cwr_2%7C%7Cwr_3&sop=and&stx=' + $(this).text();
					window.location.href = gourl;
				});
				</script>
			</fieldset>
			<?php if($is_admin == 'super') echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_adm_config&title=기본설정" class="btnSetting popWin" style="position:absolute;bottom:25px;left:25px;" data-width="1100" data-height="460" data-top="60" data-left="0" data-area=".reco-keyword">기본설정</a>'; ?>
		</div>		
	</div>
	<div class="pop-bg"></div>
</div>