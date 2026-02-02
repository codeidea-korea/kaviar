
<div class="optionInfo">
	<div class="html-flex">
		<div class="title-option-group">
			<?=$htmlOption_fontStyle?><br>
			<?=$htmlOption_titleSize?><?=$span20?><?=get_htmlOption_color('제목컬러', 'subjectColor', $subjectColor)?><br>	
			<?=$htmlOption_titleDeco?>
		</div>
	</div>
	<?php
	if($tmp_board['bo_use_category']) echo '<b class="tag skinOption boss">카테고리 표기</b>';
	?>
</div>