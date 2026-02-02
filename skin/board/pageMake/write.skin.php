<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if(!$is_admin) alert("관리자라면 로그인해주세요.", G5_BBS_URL.'/login.php');
include_once($board_skin_path.'/lib/pagemake.write.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/style.css').'">',3);

$sel_li_id = explode(",",$write['latest_sel_li_id']);

if ($w == '') {
	$write['wr_width'] = 100;
    $write['latest_count'] = 6;
	$write['latest_gall_itemspace'] = 60;
}
$bo_admin = G5_URL.'/adm/board_form.php?w=u&bo_table='.$bo_table;
?>

<?php if($is_bo_title) echo $bo_title; ?>

<section id="bo_w" style="width:100%;">

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" >
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="file_type" value="img">
	<input type="hidden" name="update_url" value="list">
	<input type="hidden" name="wr_tag" value="<?=$write['wr_tag']?>">
	<input type="hidden" name="latest_sel_li_id" value="<?=$write['latest_sel_li_id']?>" id="latest_sel_li_id">
	<input type="hidden" name="gall_cols_default" value="<?=$write['gall_cols_default']?>" id="gall_cols_default">
	<input type="hidden" name="bl_width" value="<?=$write['bl_width']?>">
	<input type="hidden" name="latest_option" value="<?=$write['latest_option']?>">
	<input type="hidden" name="latest_mobile_option" value="<?=$write['latest_mobile_option']?>">
	<input type="hidden" name="wr_1" value="<?=$write['wr_1']?>">
	<input type="hidden" name="wr_2" value="<?=$write['wr_2']?>">
	<input type="hidden" name="wr_3" value="<?=$write['wr_3']?>">
	<input type="hidden" name="wr_4" value="<?=$write['wr_4']?>">
	<input type="hidden" name="wr_5" value="<?=$write['wr_5']?>">
	<input type="hidden" name="wr_6" value="<?=$write['wr_6']?>">
	<input type="hidden" name="wr_7" value="<?=$write['wr_7']?>">
	<input type="hidden" name="wr_8" value="<?=$write['wr_8']?>">
	<input type="hidden" name="wr_9" value="<?=$write['wr_9']?>">
	<input type="hidden" name="wr_10" value="<?=$write['wr_10']?>">
	<input type="hidden" name="update_redirect_url" value="list">
	<?=$option_hidden?>
	
    <div class="wr-wrap label140">
        <?=$wr_guest?>
		
		<?php if($wr_use || $wr_include) echo '<div class="wr-group">'.$wr_use.$wr_include.'</div>'; ?>

		<div class="wr-group">
			<div class="wr-list">
				<div class="wr-list-label"><label>블럭명</label></div>
				<div class="wr-list-con">
					<?php if($wr_category) {
						echo '<select name="ca_name" id="ca_name" '.$wr_category_required.' class="selectpicker '.$wr_category_required.'" data-label="분류" data-class="labelColor-lightGray mr10" data-style="selectColor-lightGray">';
						echo option_selected("",  $ca_name, "- 분류 없음 -");
						echo $category_option;
						echo '</select>';
					} ?>
					<input type="text" name="bl_name" value="<?=$write['bl_name']?>" id="bl_name" class="w-300" placeholder="블럭명을 입력해주세요">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label"><label>블럭 레이아웃</label></div>
				<div class="wr-list-con">
					<select name="wr_subject" value="<?php echo $write['wr_subject'] ?>" id="wr_subject" class="selectpicker select-img n4 w-140 mr20">
						<?php
						echo option_selected_my("layout-basic",  $write['wr_subject'], "layout-basic", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-basic.gif")."' alt='기본형'><span class='skin_name'>기본형</span>\"");
						echo option_selected_my("layout-top",  $write['wr_subject'], "layout-top", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-top.gif")."' alt='상단미디어형'><span class='skin_name'>상단미디어형</span>\"");
						echo option_selected_my("layout-bg",  $write['wr_subject'], "layout-bg", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-bg.gif")."' alt='배경이미지형'><span class='skin_name'>배경이미지형</span>\"");
						echo option_selected_my("layout-bigBanner",  $write['wr_subject'], "layout-bigBanner", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-bigBanner.gif")."' alt='빅배너 슬라이드형'><span class='skin_name'>빅배너 슬라이드형</span>\"");
						echo option_selected_my("layout-rt",  $write['wr_subject'], "layout-rt", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-rt.gif")."' alt='우미디어형'><span class='skin_name'>우미디어형</span>\"");
						echo option_selected_my("layout-lt",  $write['wr_subject'], "layout-lt", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-lt.gif")."' alt='좌미디어형'><span class='skin_name'>좌미디어형</span>\"");											
						echo option_selected_my("layout-mix",  $write['wr_subject'], "layout-mix", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-mix.gif")."' alt='믹스 입력형'><span class='skin_name'>믹스 입력형</span>\"");
						?>
					</select>
					<span id="bl-height">
						<input type="text" name="bl_height" value="<?=$write['bl_height']?get_text($write['bl_height']):''?>" class="span70" placeholder="" data-label="블럭 높이" data-label-inline="PX" maxlength="4">
						<input type="text" name="bl_height_mobile" value="<?=$write['bl_height_mobile']?get_text($write['bl_height_mobile']):''?>" class="span70" placeholder="" data-label="모바일 블럭 높이" data-label-inline="PX" maxlength="4">
					</span>
					<label id="check-parallax" class="ml20 bold"><input type="checkbox" id="bl_parallax" name="bl_parallax" value="1" <?php if($write['bl_parallax']) echo 'checked'; ?>>스크롤 모션효과 적용</label>
					<input type="text" name="bl_background" value="<?=get_text($write['bl_background'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="블럭 배경색" data-class="ml20">
				</div>
			</div>
		</div>
		
		<div id="default-form">
			<div class="wr-group" style="border:1px solid var(--green)">

				<div class="wr-list">
					<div class="wr-list-label"><label>게시물 불러오기</label></div>
					<div class="wr-list-con flex gap20">
						<label id="latestTable" class="labelInput">
							<span class="label label-table">게시판</span>
							<?php
							if($is_admin == 'group') $myGroup = $board['gr_id'];
							echo get_bo_subject_select('latest_table', $write['latest_table'], 'class="selectpicker"', $myGroup);
							?>
						</label>
						<div id="latestOrderOption">
							<label class="labelInput">
								<select name="latest_order_option" value="<?php echo $write['latest_order_option'] ?>" id="latest_order_option" class="min120">
									<?php
									echo option_selected_my("",  $write['latest_order_option'], "기본", ' data-content="기본 조건" ');
									echo option_selected_my("detail",  $write['latest_order_option'], "상세 조건", 'data-content="상세 조건 <small>(분류, 태그)</small>" ');
									echo option_selected("list_of_select",  $write['latest_order_option'], "직접선택");						
									?>
								</select>
								<span id="btn_list_of_select" class="<?=$write['latest_sel_li_id']?'active':''?>" style="<?=$write['latest_order_option']!='list_of_select'?'display:none':''?>"><?=$write['latest_sel_li_id']?'<span class="count">'.count($sel_li_id).'개</span>':''?></span>
							</label>
							<div id="listCount" class="flex flex-middle ml20" style="<?=$write['latest_order_option']!='list_of_select'?'display:none':''?>">
								<input type="text" name="latest_count" value="<?=$write['latest_count']?$write['latest_count']:''?>" id="latest_count" class="w-60" size="2" placeholder="" data-class="mr10" data-label="목록수" data-label-inline="개">
								<input type="text" name="latest_mobile_count" value="<?php if($write['latest_mobile_count']) echo $write['latest_mobile_count'];?>" id="latest_mobile_count" class="w-60" size="2" placeholder="<?php if(!$write['latest_mobile_count']) echo $write['latest_count'] ?>" data-label="모바일" data-label-inline="개">
							</div>
						</div>
					</div>
				</div>

				<div id="latestOrder" class="wr-list" style="<?=$write['latest_order_option']!='detail'?'display:none':''?>">
					<div class="wr-list-label"><label>불러오기 조건</label></div>
					<div class="wr-list-con flex">			
						<label id="latestCate" class="labelInput mr10" style="<?=!$write['latest_table']?'display:none':''?>"><span class="label">카테고리 조건</span><input type="text" name="latest_order_cate" value="<?=$write['latest_order_cate']?>" id="latest_order_cate" class="w-320" placeholder="다수일 경우 ,로 구분"></label>
						<label id="latestTag" class="labelInput flex1"  style="<?=!$write['latest_table']?'display:none':''?>"><span class="label">태그 조건</span><input type="text" name="wr_tag" value="<?=$tag_val?>" id="wr_tag" placeholder="불러올, 태그를, 입력해, 주세요"></label>
					</div>
				</div>

				<div id="skinContainer" class="wr-list" style="<?=!$write['latest_table']||$write['latest_table']=='SQUARE'?'display:none':''?>">
					<div class="wr-list-label"><label>블럭 스킨</label></div>
					<div class="wr-list-con flex flex-top">
						<div id="latestSkinContainer"><?php echo get_latestSkin_select('latest', 'latest_skin', 'latest_skin', $write['latest_skin'], 'class="selectpicker select-img w-260 mr15" data-id="latestSkin" data-size="5" data-label="스킨선택"', true, $write['wr_subject']);  //pagaMake ,z_ , @ 는 제외?></div>
						<div id="latestTypeContainer"></div>
						<div id="add_table" style="display:none"><?=get_bo_subject_select('wr_10', $write['wr_10'], 'class="selectpicker" data-label="게시판 추가" ')?></div>
					</div>
				</div>
				<div id="gallCols" class="wr-list" style="<?=!$write['latest_table']||!$write['latest_skin']||strpos($write['latest_type'], '_grid') !== false?'display:none':''?>">
					<div class="wr-list-label"><label>가로 수<small>(한줄)</small></label></div>
					<div class="wr-list-con">
						<?php
						echo '<select name="latest_gall_cols" value="'.$write['latest_gall_cols'].'" id="latest_gall_cols" class="selectpicker mr20">';
						echo option_selected_my("",  $write['latest_gall_cols'], "기본값", "data-content='기본값 <small>(".$write['gall_cols_default'].")</small>'");
						echo option_selected_my("1",  $write['latest_gall_cols'], "1", "data-content='1 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("1.5",  $write['latest_gall_cols'], "1.5", "data-content='1.5 <small>개씩</small>'");
						echo option_selected_my("2",  $write['latest_gall_cols'], "2", "data-content='2 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("2.5",  $write['latest_gall_cols'], "2.5", "data-content='2.5 <small>개씩</small>'");
						echo option_selected_my("3",  $write['latest_gall_cols'], "3", "data-content='3 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("3.5",  $write['latest_gall_cols'], "3.5", "data-content='3.5 <small>개씩</small>'");
						echo option_selected_my("4",  $write['latest_gall_cols'], "4", "data-content='4 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("4.5",  $write['latest_gall_cols'], "4.5", "data-content='4.5 <small>개씩</small>'");
						echo option_selected_my("5",  $write['latest_gall_cols'], "5", "data-content='5 <small>개씩</small>'");	
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("5.5",  $write['latest_gall_cols'], "5.5", "data-content='5.5 <small>개씩</small>'");
						echo '</select>';
						echo '<select name="latest_gall_mobile_cols" value="'.$write['latest_gall_mobile_cols'].'" id="latest_gall_mobile_cols" class="selectpicker" data-label="모바일">';
						echo option_selected_my("",  $write['latest_gall_mobile_cols'], "기본값", "data-content='기본값 <small>(2)</small>'");
						echo option_selected_my("1",  $write['latest_gall_mobile_cols'], "1", "data-content='1 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("1.5",  $write['latest_gall_mobile_cols'], "1.5", "data-content='1.5 <small>개씩</small>'");
						echo option_selected_my("2",  $write['latest_gall_mobile_cols'], "2", "data-content='2 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("2.5",  $write['latest_gall_mobile_cols'], "2.5", "data-content='2.5 <small>개씩</small>'");
						echo option_selected_my("3",  $write['latest_gall_mobile_cols'], "3", "data-content='3 <small>개씩</small>'");
						if($write['latest_type'] == '_gall_slide') echo option_selected_my("3.5",  $write['latest_gall_mobile_cols'], "3.5", "data-content='3.5 <small>개씩</small>'");
						echo '</select>';
						?>	
					</div>
				</div>

				<div id="gallGutter" class="wr-list" style="<?=!$write['latest_table']||!$write['latest_skin']?'display:none':''?>">
					<div class="wr-list-label"><label>리스트 간격</label></div>
					<div class="wr-list-con">
						<input type="text" name="latest_gall_itemspace" value="<?=$write['latest_gall_itemspace']?>" id="latest_gall_itemspace" class="w-60" size="2" placeholder="60" data-label="간격" data-label-inline="PX">
					</div>
				</div>

			</div>

			<div class="wr-group">
				<?=$wr_gall_file?>				
				<?=$wr_video?>
			</div>
		</div>		

		<div id="mix-form" style="display:none">
			<div class="wr-group" style="background:#fffae0;background:#def2ff;">
				<div class="tcenter fs14">저장 후 (블럭 외쪽 하단)에 편집 아이콘 → <i class="icon_btnSetting"></i> 을 눌러 <span class="bold color-red">믹스형 타입을 편집</span>할 수 있습니다.</div>
			</div>	
		</div>

		<div class="wr-list">
			<div class="wr-list-con">
				<textarea name="bl_title" id="bl_title" class="w-full autosize label" style="min-height:40px;" placeholder="제목 &lt;sub&gt;보조문구&lt;/sub&gt;" data-label="블럭 제목"><?=$write['bl_title']?></textarea>				
				<label class="labelColor-hidden small" title="버튼 컬러">
					<input type="text" name="bl_title_color" value="<?=get_text($write['bl_title_color'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				</label>
			</div>
		</div>		

		<div class="wr-list wr_content <?=$wrEditorClass?>">
			<div class="wr-list-con">
				<div class="wrConBox">
					<?php if($is_admin) {
						echo '<ul class="wrConTabs">';
						echo '<li class="active" data-target="pcCon" title="PC">내용</li>';
						echo '<li class="" data-target="mobileCon" title="모바일">모바일 내용</li>';
						echo '</ul>';
					} ?>
					<div class="tabEditor pcCon active">
						<?php
						if($write_min || $write_max) echo '<p id="char_count_desc">이 게시판은 최소 <strong>'.$write_min.'</strong>글자 이상, 최대 <strong>'.$write_max.'</strong>글자 이하까지 글을 쓰실 수 있습니다.</p>';
						echo $editor_html;
						if($write_min || $write_max) echo '<div id="char_count_wrp"><span id="char_count"></span>글자</div>';
						?>
					</div>
					<div class="tabEditor mobileCon"><?=$editor_mobile_html?></div>
				</div>
				<label class="labelColor-hidden small" title="버튼 컬러">
					<input type="text" name="wr_content_color" value="<?=get_text($write['wr_content_color'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				</label>
			</div>
		</div>

		<?=$wr_btn?>

		<div class="wr-list">
			<div class="wr-list-label"><label>콘텐츠 정렬</label></div>
			<div class="wr-list-con">
				<?php
				$bl_text_align = explode("|", $write['bl_text_align']);
				echo '<select name="bl_text_align[0]" value="'.$bl_text_align[0].'" id="bl_text_align" class="selectpicker">';
				echo option_selected_my("",  $bl_text_align[0], "기본값", "data-content='기본 <small>(왼쪽정렬)</small>'");
				echo option_selected("center",  $bl_text_align[0], "가운데 정렬");
				echo option_selected("right",  $bl_text_align[0], "오른쪽 정렬");
				echo '</select>';

				echo '<span id="con_flex_align" class="ml15"><select name="bl_text_align[1]" value="'.$bl_text_align[1].'" class="selectpicker select-img">';
				echo option_selected_my("",  $bl_text_align[1], "", "data-content=\"<img src='".get_url($board_skin_url."/img/flex-start.gif")."'>\"");
				echo option_selected_my("flex-center",  $bl_text_align[1], "", "data-content=\"<img src='".get_url($board_skin_url."/img/flex-center.gif")."'>\"");
				echo option_selected_my("flex-end",  $bl_text_align[1], "", "data-content=\"<img src='".get_url($board_skin_url."/img/flex-end.gif")."'>\"");
				echo '</select></span>';
				?>	
			</div>
		</div>
		
		<?=$we_captcha?>
		
    </div>
	
    <div class="bo_btnSet">
		<?php if($is_delete) echo $deleteCode; ?>
		<button type="submit" accesskey="s" class="btn_submit">저장</button>
        <a href="./board.php?bo_table=<?=$bo_table.$qstr?>" class="btn_cancel">취소</a>
    </div>

	<div class="bo_btnSet inline-fixed">
        <button type="submit" accesskey="s" class="btn_submit">저장</button>
        <a href="./board.php?bo_table=<?=$bo_table.$qstr?>" class="btn_cancel">취소</a>
    </div>

    </form>

</section>


<div id="addScript"></div>
<script>
function layoutChange(layout) {
	return layout == 'layout-bg' || layout == 'layout-bigBanner' ? $('#bl-height, #check-parallax').show() : $('#bl-height, #check-parallax').hide(),
		layout == 'layout-bg' ? $('#add_table').show() : $('#add_table').hide(),
		layout == 'layout-mix' ? $('#default-form').addClass('hide') : $('#default-form').removeClass('hide'),
		layout == 'layout-mix' ? $('#mix-form').show() : $('#mix-form').hide(),
		latestSkin_push(layout);
}

function latestSkin_push(layout) {	
	let latest_skin = $("#latest_skin").val();
	$.post("<?=$board_skin_url?>/_ajax_latest_skin.php",{push:'push', layout:layout, latest_skin:latest_skin, board_skin_path:'<?=$board_skin_path?>'}, function(data) {
		$("#latestSkinContainer").html(data);
		$('#latestSkinContainer select').selectpicker('refresh');
		let boSkin = $('#latest_table').find("option:selected").attr("data-table-skin"),
			useCate = $('#latest_table').find("option:selected").attr("data-use-cate"),
			useTag = $('#latest_table').find("option:selected").attr("data-use-tag");
		tableChange($('#latest_table').val(), boSkin, useCate, useTag);
	});
}

function tableChange(table, boSkin, useCate, useTag) {
	let table_label = $('#latestTable').find('.label-table');
	if(table) {
		$('#skinContainer').show();
		if(boSkin == 'SQUARE') {
			$(table_label).html('스퀘어').removeClass('label-link');  //게시판 바로가기 링크 삭제
			$('#latestOrderOption, #listCount, #latestSkinContainer').hide().removeClass('flex flex-middle');
			$('#latestOrder').show();
			orderOptionChange('detail', 0, 1); //불러오기 조건(태그조건) 활성화
			latestSkinChange(boSkin); //스킨 타입 활성화

		} else {			
			$(table_label).html('<a href="<?=G5_BBS_URL?>/board.php?bo_table=' + table + '" target="_blank">바로가기</a>').addClass('label-link'); //게시판 선택시 바로가기 링크 추가			
			$('#latestOrderOption, #listCount, #latestSkinContainer').show().addClass('flex flex-middle');
			useCate == '1' || useTag == '1' ? $('#latest_order_option option[value*="detail"]').show() : $('#latest_order_option option[value="detail"]').hide().prop('selected',false);
			$('#latest_order_option').selectpicker('refresh');
			orderOptionChange($('#latest_order_option').val(), useCate, useTag); //불러오기 조건 활성화
			latestSkinChange($('#latest_skin').val()); //스킨 타입 활성화
		}
		$('#latest_skin').change(function (){
			latestSkinChange($(this).val()); //스킨 타입 활성화
		});
	} else {		
		$(table_label).html('게시판').removeClass('label-link');
		$('#latestOrderOption, #latestOrder, #skinContainer, #latestSkinContainer, #listCount, #gallCols, #gallGutter').hide().removeClass('flex flex-middle');
	}
}

function orderOptionChange(orderOption, useCate, useTag) {
	let table = $('#latest_table').val(),
		btn_list_of_select = $('#latestOrderOption').find('#btn_list_of_select');
	orderOption == 'list_of_select' ? btn_list_of_select.show() : btn_list_of_select.hide();
	orderOption == 'list_of_select' ? $('#listCount').hide() : $('#listCount').show();
	if(orderOption == 'detail') {
		useCate == '1' || useTag == '1' ? $('#latestOrder').show() : $('#latestOrder').hide();		
		useCate == '1' ? $('#latestCate').show() : $('#latestCate').hide();
		useTag == '1' ? $('#latestTag').show() : $('#latestTag').hide();
	} else {
		$('#latestOrder').hide().removeClass('flex flex-middle');
	}
}

function latestSkinChange(latestSkin) {	
	let table = latestSkin == 'SQUARE' ? $('#latest_table').val() : '',
		skinName = latestSkin.replace('theme/', '').replace('seperate/', '');
	<?=$write['latest_type'] ? 'let latest_type = "'.$write['latest_type'].'";' : 'let latest_type = $("#latest_type").val();'?>
	$.post("<?=$board_skin_url?>/_ajax_latest_type.php",{push:'push', table:table, skin:skinName, board_skin_url:"<?=$board_skin_url?>", latest_type:latest_type, latest_list_style:"<?=$write['latest_list_style']?>"}, function(data) {
		$("#latestTypeContainer").html(data);
		$('#latestTypeContainer select, #latest_gall_cols').selectpicker('refresh');
		$("#latest_type").change(function (){
			latestTypeChange($(this).val(), $("#latest_table").val());
		});
	});
}

function latestTypeChange(latestTypeVal, latest_table) {
	var skin = $('#latest_skin').val();
	$.post("<?=$board_skin_url?>/_ajax_latest_type.php",{push:'', skin:skin, latest_type:latestTypeVal}, function(data) {
		$("#addScript").html(data);
		$('#latest_gall_cols').selectpicker('refresh');
	});
}


///////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
	let layout = $('#wr_subject'),
		latest_table = $('#latest_table'),
		boSkin = latest_table.find("option:selected").attr("data-table-skin"),
		useCate = latest_table.find("option:selected").attr("data-use-cate"),
		useTag = latest_table.find("option:selected").attr("data-use-tag"),
		latest_skin = $('#latest_skin');
	
	//블럭 레이아웃 선택시
	layoutChange(layout.val());
	layout.change(function (){
		layoutChange($(this).val());		
	});
	
	//불러오기 게시판 선택시
	tableChange(latest_table.val(), boSkin, useCate, useTag);
	latest_table.change(function (){
		let boSkin = $(this).find("option:selected").attr("data-table-skin"),
			useCate = $(this).find("option:selected").attr("data-use-cate"),
			useTag = $(this).find("option:selected").attr("data-use-tag");		
		return $(this).val() ? latest_skin.attr("required", true) : latest_skin.attr("required", false),
			tableChange($(this).val(), boSkin, useCate, useTag);
	});
	
	//불러오기 조건(기본조건, 상세조건, 직접선택) 선택시
	$('#latest_order_option').change(function (){
		let useCate = $('#latest_table').find("option:selected").attr("data-use-cate"),
			useTag = $('#latest_table').find("option:selected").attr("data-use-tag");
		orderOptionChange($(this).val(), useCate, useTag)
	});

	//불러오기조건 - 직접선택시 팝업링크
	$('#btn_list_of_select').click(function() {
		var table= $('#latest_table').val(),
			sel_li_id = $('#latest_sel_li_id').val(),
			href = '<?=G5_BBS_URL?>/my/_adm/?pn=_list_of_select&title=' + table + ' 게시물 선택&bo_table=' + table + '&sel_li_id=' + sel_li_id;
		window.open(href,'','width=1450,height=860,top=60,left=30,scrollbars=yes,toolbar=no,menubar=no,location=no,statusbar=no,status=no,resizable=yes');
		event.preventDefault();
	});
});
</script>


<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});

<?php } ?>
function html_auto_br(obj)
{
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f)
{
	var use_cate = $('#latest_table').find("option:selected").attr("data-use-cate");
	var use_tag = $('#latest_table').find("option:selected").attr("data-use-tag");

	if(use_cate != '1') $('#latest_order_cate').val('');
	if(use_tag != '1') $('#wr_tag').val('');


	<?php //echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
	var wr_content_editor_data = oEditors.getById['wr_content'].getIR(); 
	oEditors.getById['wr_content'].exec('UPDATE_CONTENTS_FIELD', []);  
	if(jQuery.inArray(document.getElementById('wr_content').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<div><br></div>','<p></p>','<br>','']) != -1){ 
		document.getElementById('wr_content').value='&nbsp;'; 
		wr_content_editor_data = '&nbsp;' 
	} 
	if (!wr_content_editor_data || jQuery.inArray(wr_content_editor_data.toLowerCase(), ['<p><br></p>','<p></p>','<br>']) != -1) { 
		alert("내용을 입력해 주십시오."); 
		oEditors.getById['wr_content'].exec('FOCUS'); 
		return false; 
	}

	<?php //echo $editor_mobile_html; ?>
	var wr_content_mobile_editor_data = oEditors.getById['wr_content_mobile'].getIR(); 
	oEditors.getById['wr_content_mobile'].exec('UPDATE_CONTENTS_FIELD', []);  
	if(jQuery.inArray(document.getElementById('wr_content_mobile').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<div><br></div>','<p></p>','<br>','']) != -1){ 
		document.getElementById('wr_content_mobile').value='&nbsp;'; 
		wr_content_mobile_editor_data = '&nbsp;' 
	} 
	if (!wr_content_mobile_editor_data || jQuery.inArray(wr_content_mobile_editor_data.toLowerCase(), ['<p><br></p>','<p></p>','<br>']) != -1) { 
		alert("내용을 입력해 주십시오."); 
		oEditors.getById['wr_content_mobile'].exec('FOCUS'); 
		return false; 
	}

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
			"content": f.wr_content.value
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(data, textStatus) {
			subject = data.subject;
			content = data.content;
		}
	});

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>