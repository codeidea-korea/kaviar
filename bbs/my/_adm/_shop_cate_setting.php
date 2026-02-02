<?php
if (!defined('_GNUBOARD_')) exit;
$shopCates = get_shop_category_array(true);
$i = 0;
foreach($shopCates as $_shopCate) {
	if( empty($_shopCate) ) continue;
	$shopCate[$i] = $_shopCate['text'];
	$i++;
}
?>

<div style="position:absolute;top:15px;right:30px;"><a href="<?=G5_ADMIN_URL?>/shop_admin/categorylist.php" class="_btn/sm/blue" target="_blank">상품 분류 관리</a></div>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_cate_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label100">			
		<div class="form-list">
			<div class="formCon">
				<ul class="fileImgSet" style="--img-size:80px">
					<?php
					echo '<li class="img_li flex flex-middle">';
						echo '<div class="relative">';
							echo '<input type="file" name="ca_all_img" class="myfile">';
							echo '<div class="upImg">';
							$all_img_path = G5_DATA_PATH.'/shop_cate/ca_all_img';
							if(file_exists($all_img_path)) {
								$ca_all_thumb = thumbnail('ca_all_img', G5_DATA_PATH.'/shop_cate/', G5_DATA_PATH.'/shop_cate/', 100, '', 1, 1, 'center');								
								$ca_all_img = '<img src="'.G5_DATA_URL.'/shop_cate/'.$ca_all_thumb.'">';
							}
							echo $ca_all_img;
							echo '</div>';
							if($ca_all_img) echo '<input type="checkbox" name="del_ca_all_img" value="1">';
						echo '</div>';					
						echo '<span class="bold">전체</span>';
					echo '</li>';

					for ($i=0; $i<count($shopCates); $i++) {						
						echo '<li class="img_li flex flex-middle">';
							echo '<input type="hidden" name="ca_id_up['.$i.']" value="'.$shopCate[$i]['ca_id'].'">';
							echo '<div class="relative">';
								echo '<input type="file" name="ca_img'.$i.'" class="myfile">';
								echo '<div class="upImg">';
								$img_path[$i] = G5_DATA_PATH.'/shop_cate/'.$shopCate[$i]['ca_id'];
								if(file_exists($img_path[$i])) {
									$ca_thumb[$i] = thumbnail($shopCate[$i]['ca_id'], G5_DATA_PATH.'/shop_cate/', G5_DATA_PATH.'/shop_cate/', 100, '', 1, 1, 'center');								
									$ca_img[$i] = '<img src="'.G5_DATA_URL.'/shop_cate/'.$ca_thumb[$i].'">';
								}
								echo $ca_img[$i];
								echo '</div>';
								if($ca_img[$i]) echo '<input type="checkbox" name="del_ca_img['.$i.']" value="1">';
							echo '</div>';						
							echo '<span class="bold">'.$shopCate[$i]['ca_name'].'</span>';
						echo '</li>';
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</section>

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>

</script>