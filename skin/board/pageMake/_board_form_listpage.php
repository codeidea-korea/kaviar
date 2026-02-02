<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<?=$bo_inc_info?>

<form name="_adm_form" id="_adm_form" action="<?=G5_BBS_URL?>/my/_adm/_board_form_listpage_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="bo_skin" value="<?=$board['bo_skin']?>" id="bo_skin">
<input type="hidden" name="bo_category_label" value="플로팅 메뉴">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
	
<section class="mybox blue">
	<div class="formContainer label140">
		<div class="form-list">
			<div class="form-label"><label>블록 사이즈 관련</label></div>
			<div class="formCon flex gap15">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="bo_padding_left_right" value="<?=$board['bo_padding_left_right']?>" class="span60" id="bo_padding_left_right" size="4" data-label="블록 콘텐츠 좌우여백" data-label-inline="PX">
				<?php } else { ?>
				<input type="hidden" name="bo_padding_left_right" value="<?=$board['bo_padding_left_right']?>">
				<?php } ?>
				<input type="text" name="bo_mobile_padding" value="<?=$board['bo_mobile_padding']?>" class="span60" id="bo_mobile_padding" size="4" data-label="모바일 여백" data-label-inline="PX">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="bo_table_width" value="<?=$board['bo_table_width']?$board['bo_table_width']:''?>" class="percent" id="bo_table_width" size="4" data-percent-max="100" data-label="블록모음 최대사이즈" data-label-inline="PX">
				<span class="help-block ml10">*사이즈가 100이하인 개별 블록들은 블록모음 안에 속합니다.</span>
				<?php } else { ?>
				<input type="hidden" name="bo_table_width" value="<?=$board['bo_table_width']?$board['bo_table_width']:''?>">
				<?php } ?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>텝메뉴 스킨</label></div>
			<div class="formCon">
				<select id="bo_cate_skin" name="bo_cate_skin">
					<?=option_selected('', $board['bo_cate_skin'], "플로팅 탭메뉴(하단)")?>
					<?=option_selected('top-tabs', $board['bo_cate_skin'], "상단 탭메뉴")?>							
				</select>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>플로팅 메뉴</label></div>
			<div class="formCon flex">
				<input type="text" name="bo_category_list" value="<?=get_text($board['bo_category_list'])?>" id="bo_category_list" class="frm_input flex1" placeholder="메뉴와 메뉴 사이는 | 로 구분하세요.">
				<input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" class="" <?=$board['bo_use_category']?'checked':''?> data-label="사용">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>플로팅 메뉴 색상</label></div>
			<div class="formCon">
				<input type="text" name="bo_background" value="<?=$board['bo_background']?>" class="colorpicker" id="bo_background" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
			</div>
		</div>
	</div>
</section>	

<section class="mybox blue blue-bg">
	<h2 class="mybox-title toggle">상세 옵션</h2>
	<div class="formContainer label140">
		<div class="form-list">
			<div class="form-label"><label>블록 타이틀 폰트</label></div>
			<div class="formCon">
				<?php $bo_option[0]=$bo_option[0]?$bo_option[0]:'noto600';?>
				<select name="bo_option[0]" class="selectpicker font-family" data-target="#bo_title" data-label="폰트">
					<?=option_selected_my('noto100', $bo_option[0], "본고딕 100", "data-content='<span class=\"fs14 noto100\">본고딕 100</span>'")?>
					<?=option_selected_my('noto200', $bo_option[0], "본고딕 200", "data-content='<span class=\"fs14 noto200\">본고딕 200</span>'")?>
					<?=option_selected_my('noto300', $bo_option[0], "본고딕 300", "data-content='<span class=\"fs14 noto300\">본고딕 300</span>'")?>
					<?=option_selected_my('noto400', $bo_option[0], "본고딕 400", "data-content='<span class=\"fs14 noto400\">본고딕 400</span>'")?>
					<?=option_selected_my('noto500', $bo_option[0], "본고딕 500", "data-content='<span class=\"fs14 noto500\">본고딕 500</span>'")?>
					<?=option_selected_my('noto600', $bo_option[0], "본고딕 600", "data-content='<span class=\"fs14 noto600\">본고딕 600</span>'")?>
					<?=option_selected_my('noto700', $bo_option[0], "본고딕 700", "data-content='<span class=\"fs14 noto700\">본고딕 700</span>'")?>
					<?=option_selected_my('blackGothic', $bo_option[0], "검은고딕", "data-content='<span class=\"fs21 blackGothic\">검은고딕</span>'")?>
					<?=option_selected_my('dohyeon', $bo_option[0], "도현체", "data-content='<span class=\"fs17 dohyeon\">도현체</span>'")?>
					<?=option_selected_my('malgunGothic200', $bo_option[0], "맑은고딕 Light", "data-content='<span class=\"fs14 malgunGothic200\">맑은고딕 Light</span>'")?>
					<?=option_selected_my('malgunGothic400', $bo_option[0], "맑은고딕 Normal", "data-content='<span class=\"fs14 malgunGothic400\">맑은고딕 Normal</span>'")?>
					<?=option_selected_my('malgunGothic600', $bo_option[0], "맑은고딕 Bold", "data-content='<span class=\"fs14 malgunGothic600\">맑은고딕 Bold</span>'")?>
					<?=option_selected_my('nanumSR300', $bo_option[0], "나눔스퀘어라운드 light", "data-content='<span class=\"fs14 nanumSR300\">나눔스퀘어라운드 light</span>'")?>
					<?=option_selected_my('nanumSR400', $bo_option[0], "나눔스퀘어라운드 Regular", "data-content='<span class=\"fs14 nanumSR400\">나눔스퀘어라운드 Regular</span>'")?>
					<?=option_selected_my('nanumSR700', $bo_option[0], "나눔스퀘어라운드 bold", "data-content='<span class=\"fs14 nanumSR700\">나눔스퀘어라운드 bold</span>'")?>
					<?=option_selected_my('nanumSR800', $bo_option[0], "나눔스퀘어라운드 ExtraBold", "data-content='<span class=\"fs14 nanumSR800\">나눔스퀘어라운드 ExtraBold</span>'")?>					
					<?=option_selected_my('nanum', $bo_option[0], "나눔고딕 보통", "data-content='<span class=\"fs14 nanum\">나눔고딕 보통</span>'")?>
					<?=option_selected_my('nanum-bold', $bo_option[0], "나눔고딕 볼드", "data-content='<span class=\"fs14 nanum-bold\">나눔고딕 볼드</span>'")?>
				</select>
			</div>
		</div>
	</div>
</section>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>