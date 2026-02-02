<?php
if (!defined('_GNUBOARD_')) exit;


$theme = get_theme_dir_my($_theme_type = 'community');
if($config['cf_theme'] && in_array($config['cf_theme'], $theme))
    array_unshift($theme, $config['cf_theme']);
$theme = array_values(array_unique($theme));
$total_count = count($theme);

//쇼핑몰 테마 정의
$theme_shop = get_theme_dir_my($_theme_type = 'shop');
if($config['cf_theme'] && in_array($config['cf_theme'], $theme_shop))
    array_unshift($theme_shop, $config['cf_theme']);
$theme_shop = array_values(array_unique($theme_shop));
$total_shop_count = count($theme_shop);

// 설정된 테마가 존재하지 않는다면 cf_theme 초기화
/*if($config['cf_theme'] && ( !in_array($config['cf_theme'], $theme) && !in_array($config['cf_theme'], $theme_shop) ))
    sql_query(" update {$g5['config_table']} set cf_theme = '' ");*/
?>

<script src="<?php echo G5_ADMIN_URL; ?>/theme.js"></script>

<section class="">
	<div class="local_wr">
		<span class="btn_ov01"><span class="ov_txt">커뮤니티 테마</span><span class="ov_num">  <?php echo number_format($total_count); ?></span></span>
	</div>

	<?php
	//커뮤니티 테마
	if($total_count > 0) {
		echo '<ul class="theme_list">';
		for($i=0; $i<$total_count; $i++) {
			$info = get_theme_info($theme[$i]);
			$name = get_text($info['theme_name']);
			$screenshot = $info['screenshot'] ? '<img src="'.$info['screenshot'].'" alt="'.$name.'">' : '<img src="'.G5_ADMIN_URL.'/img/theme_img.jpg" alt="">';

			if($config['cf_theme'] == $theme[$i]) {
				$btn_active = '<span class="theme_sl theme_sl_use">사용중</span><button type="button" class="theme_sl theme_deactive" data-theme="'.$theme[$i].'" '.'data-name="'.$name.'">사용안함</button>';
			} else {
				$tconfig = get_theme_config_value($theme[$i], 'set_default_skin');
				$set_default_skin = $tconfig['set_default_skin'] ? 'true' : 'false';
				$btn_active = '<button type="button" class="theme_sl theme_active" data-theme="'.$theme[$i].'" '.'data-name="'.$name.'" data-set_default_skin="'.$set_default_skin.'">테마적용</button>';
			}
			echo '<li class="'.($config['cf_theme'] == $theme[$i]?'active':'').'">';
			echo '<div class="con">';
			echo '<div class="thumb-header"><span class="theme_name">'.$theme[$i].($config['cf_theme'] == $theme[$i]?'<sub>(사용중인 테마)</sub>':'').'</span></div>';
			echo '<div class="thumb">'.$screenshot.'</div>';		
			echo '</div>';
			echo '<div class="btnSet">'.$btn_active.'</div>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		echo '<p class="no_theme">설치된 테마가 없습니다.</p>';
	}
	?>
</section>

<section class="mt40">
	<div class="local_wr">
		<span class="btn_ov01"><span class="ov_txt">쇼핑몰 테마</span><span class="ov_num">  <?php echo number_format($total_shop_count); ?></span></span>
	</div>

	<?php
	//쇼핑몰 테마
	if($total_shop_count > 0) {
		echo '<ul class="theme_list shop">';
		for($i=0; $i<$total_shop_count; $i++) {
			$shop_info = get_theme_info($theme_shop[$i]);
			$shop_name = get_text($shop_info['theme_name']);
			$shop_screenshot = $shop_info['screenshot'] ? '<img src="'.$shop_info['screenshot'].'" alt="'.$shop_name.'">' : '<img src="'.G5_ADMIN_URL.'/img/theme_img.jpg" alt="">';

			if($config['cf_theme'] == $theme_shop[$i]) {
				$btn_active = '<span class="theme_sl theme_sl_use">사용중</span><button type="button" class="theme_sl theme_deactive" data-theme="'.$theme_shop[$i].'" '.'data-name="'.$shop_name.'">사용안함</button>';
			} else {
				$tconfig = get_theme_config_value($theme_shop[$i], 'set_default_skin');
				$set_default_skin = $tconfig['set_default_skin'] ? 'true' : 'false';
				$btn_active = '<button type="button" class="theme_sl theme_active" data-theme="'.$theme_shop[$i].'" '.'data-name="'.$shop_name.'" data-set_default_skin="'.$set_default_skin.'">테마적용</button>';
			}
			echo '<li class="'.($config['cf_theme'] == $theme_shop[$i]?'active':'').'">';
			echo '<div class="con">';
			echo '<div class="thumb-header"><span class="theme_name">'.$theme_shop[$i].($config['cf_theme'] == $theme_shop[$i]?'<sub>(사용중인 테마)</sub>':'').'</span></div>';
			echo '<div class="thumb">'.$shop_screenshot.'</div>';		
			echo '</div>';
			echo '<div class="btnSet">'.$btn_active.'</div>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		echo '<p class="no_theme">설치된 테마가 없습니다.</p>';
	}
	?>
</section>



<?php
include_once ('./admin.tail.php');