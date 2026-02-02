<?php
//이곳에 작성한 HTML은 쇼핑몰 블럭 ID78에 출력합니다.
//이미지 경로 - $html_img_url
?>


<style>
#_todayview{display:none;}
</style>

<script>
$(document).ready(function(){
	let block_height = $('#section-<?=$bl_id?>').height();
	$('#_todayview').css({'top':block_height + 65}).show();
});
</script>