<?php
$sub_menu = "300930";
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '테스트 게시글 콘텐츠 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="tmpCon" id="tmpCon" method="post" onsubmit="return tmpCon_submit(this);" autocomplete="off" action="./tmpCon_update.php" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
    <ul class="tmp_img_set">
		<?php for($i=1; $i<=10; $i++) { ?>
		<li>
			<?php
			$tmp_img_path[$i] = G5_DATA_PATH.'/tmp/temp'.$i.'.jpg';
			$tmp_img_url[$i] = G5_DATA_URL.'/tmp/temp'.$i.'.jpg';
			$tmp_img[$i] = file_exists($tmp_img_path[$i]) ? '<img src="'.get_url($tmp_img_url[$i]).'"><label><input type="checkbox" name="del_tmp_img['.$i.']" value="1">삭제</label>' : '';
			echo '<input type="file" name="tmp_img'.$i.'" class="myfile">';
			echo '<div class="upImg">'.$tmp_img[$i].'</div>';
			echo '<div class="mt10">';
			echo '<input type="text" name="tmp_subject'.$i.'" value="'.$tmpCon['tmp_subject'.$i].'" class="span" placeholder="제목">';
			echo '<textarea name="tmp_content'.$i.'" class="mt10" style="min-height:100px" placeholder="내용">'.$tmpCon['tmp_content'.$i].'</textarea>';
			echo '</div>';
			?>
		</li>
		<?php } ?>
    </ul>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<script>
function tmpCon_submit(f) {

    return true;
}
</script>



<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>