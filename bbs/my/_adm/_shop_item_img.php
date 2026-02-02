<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_BBS_PATH.'/my/_adm/_shop_item.lib.php');
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_item_img_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="it_id" value="<?=$_GET['it_id']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label100">			
		<div class="form-list">
			<div class="formCon">
				<ul class="fileImgSet" style="--img-size:120px">
					<?php for($i=1; $i<=10; $i++) {
						echo '<li class="img_li">';
							echo '<input type="file" name="it_img'.$i.'" id="it_img'.$i.'" class="myfile">';
							echo '<div class="upImg">';
							$it_img = G5_DATA_PATH.'/item/'.$it['it_img'.$i];
							$it_img_url = G5_DATA_URL.'/item/'.$it['it_img'.$i];
							$it_img_exists = run_replace('shop_item_image_exists', (is_file($it_img) && file_exists($it_img)), $it, $i);
							if($it_img_exists) {
								$it_width = 200;
								$it_height = get_it_height($it_width);	
								$thumb = get_it_thumbnail($it['it_img'.$i], $it_width, $it_height);
								echo $thumb;
							}
							echo '</div>';
							if($it_img_exists) echo '<input type="checkbox" name="it_img'.$i.'_del" id="it_img'.$i.'_del" value="1" data-label="파일삭제">';
							if($it_img_exists) echo '<a href="'.$it_img_url.'" class="view_ori_img" target="_blank">원본보기</a>';
						echo '</li>';
					} ?>
				</ul>
			</div>
		</div>
	</div>
</section>



<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>