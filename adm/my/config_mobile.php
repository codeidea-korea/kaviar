<?php
$sub_menu = "110700";
include_once('./_common.php');
//include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '모바일 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$cfm_top_bg = explode("|",$config_mobile['cfm_top_bg']);
$cfm_menu_top_bg = explode("|",$config_mobile['cfm_menu_top_bg']);
$cfm_menu_color = explode("|",$config_mobile['cfm_menu_color']);
?>

<form name="adm_form" id="adm_form" method="post" onsubmit="return adm_form_submit(this);" autocomplete="off">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
	
	<h2 class="mybox-title">모바일 관리</h2>
    <div class="tbl_frm01 tbl_wrap">
		<div class="local_desc02 local_desc">
			<p>모바일 메뉴 및 버튼 스타일 등을 별도로 설정할 수 있습니다.</p>
		</div>
        <table>
			<colgroup>
				<col width="150">
				<col>
			</colgroup>
			<tbody>			
				<tr>
					<th scope="row"><label>모바일 메뉴 위치</label></th>
					<td>
						<select id="cfm_top_layout" name="cfm_top_layout">
							<?php echo option_selected('0', $config_mobile['cfm_top_layout'], "왼쪽"); ?>
							<?php echo option_selected('1', $config_mobile['cfm_top_layout'], "오른쪽"); ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>헤더(상단) 배경색</label></th>
					<td>
						<input type="text" name="cfm_top_bg[0]" value="<?=get_text($cfm_top_bg[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
						<input type="checkbox" name="cfm_top_bg[1]" value="1" <?=$cfm_top_bg[1]?'checked':'';?> data-label="흰색로고 사용" data-class="ml25">
					</td>
				</tr>
				<tr>
					<th scope="row"><label>메뉴열림시 상단 배경색</label></th>
					<td>
						<div class="flex flex-middle gap20">
							<input type="text" name="cfm_menu_top_bg[0]" value="<?=$cfm_menu_top_bg[0]?$cfm_menu_top_bg[0]:$cf_default_style[1]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">	
							<input type="text" name="cfm_menu_top_bg[1]" value="<?=$cfm_menu_top_bg[1]?$cfm_menu_top_bg[1]:$cf_default_style[2]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
							<span class="help-block">* 값이 없으면 사이트 기본컬러, 서브컬러가 기본이 됩니다</span>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>메뉴열림시 배경색</label></th>
					<td>
						<input type="text" name="cfm_menu_bg" value="<?=get_text($config_mobile['cfm_menu_bg'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">						
					</td>
				</tr>
				<tr>
					<th scope="row"><label>메뉴 폰트컬러</label></th>
					<td>
						<input type="text" name="cfm_menu_color[0]" value="<?=get_text($cfm_menu_color[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
						<input type="text" name="cfm_menu_color[1]" value="<?=$cfm_menu_color[1]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="활성화 메뉴 컬러" data-class="ml30"></label>
					</td>
				</tr>
			</tbody>

        </table>
    </div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f)
{
    f.action = "./config_mobile_update.php";
    return true;
}
</script>



<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>