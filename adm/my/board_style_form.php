<?php
if (!defined('_GNUBOARD_')) exit;

$title_style = explode("|",$bo_style['title_style']);
$btn_write_style = explode("|",$bo_style['btn_write_style']);
$btn_pager_style = explode("|",$bo_style['btn_pager_style']);

$bo_title_root = '';
if($title_style[1]) $bo_title_root .= '--font-size:'.$title_style[1].'px;';
if($title_style[2]) $bo_title_root .= '--font-color:'.$title_style[2].';';
if($title_style[3]) $bo_title_root .= 'margin-bottom:'.$title_style[3].'px;';

$bo_btnSet_root = '';
if($btn_write_style[0]) $bo_btnSet_root .= '--font-size:'.$btn_write_style[0].'px;';
if($btn_write_style[1]) $bo_btnSet_root .= '--btn-width:'.$btn_write_style[1].'px;';
if($btn_write_style[2]) $bo_btnSet_root .= '--btn-height:'.$btn_write_style[2].'px;';
if($btn_write_style[3]) $bo_btnSet_root .= '--btnColor:'.$btn_write_style[3].';';
if($btn_write_style[4]) $bo_btnSet_root .= '--btnColor-hover:'.$btn_write_style[4].';';

$pg_wrap_root = '';
if($btn_pager_style[0]) $pg_wrap_root .= '--btn-size:'.$btn_pager_style[0].'px;';
if($btn_pager_style[1]) $pg_wrap_root .= '--btn-gap:'.$btn_pager_style[1].'px;';
if($btn_pager_style[1]!='' && $btn_pager_style[1]==0) $pg_wrap_root .=  '--btn-gap:'.$btn_pager_style[1].'px;';
if($btn_pager_style[2]) $pg_wrap_root .= '--btn-radius:'.$btn_pager_style[2].'px;';
if($btn_pager_style[3]) $pg_wrap_root .= '--btnColor-active:'.$btn_pager_style[3].';';
?>


<style>
<?php
$cf_default_style = explode("|",$config['cf_default_style']);
if($cf_default_style[1]) echo '.boStyle-preview{--mainColor:'.$cf_default_style[1].';}';
if($cf_default_style[2]) echo '.boStyle-preview{--subColor:'.$cf_default_style[2].';}';
?>
</style>

<section class="mybox blue">
    <h2 class="mybox-title">게시판 기본 스타일 변경</h2>
    <div class="formContainer label150">
		<div class="form-list">
            <div class="form-label"><label>사용여부</label></div>
            <div class="formCon"><input type="checkbox" id="use_bo_style" name="use_bo_style" value="1" <?php if($bo_style['use_bo_style']) echo 'checked'; ?> data-label="변경 스타일 사용"></div>
        </div>
		<div class="form-list">
            <div class="form-label flex-top"><label>게시판 타이틀</label></div>
            <div class="formCon">
				<div class="flex gap20">
					<?php $title_style[0]=$title_style[0]?$title_style[0]:'noto600';?>
					<select name="title_style[0]" class="selectpicker font-family" data-target="#bo_title" data-label="폰트">
						<?php
						for($i=0; $i<count($_title_font_name); $i++) {
							echo option_selected_my($_title_font_family[$i], $title_style[0], $_title_font_name[$i], "data-content='<span class=\"fs17 ".$_title_font_family[$i]."\">".$_title_font_name[$i]."</span>'");
						}
						?>						
					</select>
					<input type="text" name="title_style[1]" value="<?=$title_style[1]?>" class="span36 font-size" size="2" placeholder="46" data-target="#bo_title" data-label="폰트 사이즈" data-label-inline="PX">					
					<input type="text" name="title_style[2]" value="<?=$title_style[2]?>" class="colorpicker textColor" data-label="폰트 컬러" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-target="#bo_title">
					<input type="text" name="title_style[3]" value="<?=$title_style[3]?>" class="span65 margin-bottom" size="2" data-target="#bo_title" data-label="하단 여백" data-label-inline="PX">
				</div>
            </div>
        </div>
		<div class="form-list">
            <div class="form-label flex-top"><label>글쓰기 버튼</label></div>
            <div class="formCon">
				<div class="flex gap15">
					<select name="btn_write_style[0]" class="selectpicker font-size" data-target=".bo_btnSet" data-label="폰트 사이즈">
						<?php
						echo option_selected('', $btn_write_style[0], "- 기본 -");
						for($i=11; $i<24; $i++) {
							echo option_selected_my($i, $btn_write_style[0], $i);
						}
						?>
					</select>
					<input type="text" name="btn_write_style[1]" value="<?=$btn_write_style[1]?>" class="span36 width" size="2" data-target=".bo_btnSet" data-label="가로사이즈" data-label-inline="PX">
					<input type="text" name="btn_write_style[2]" value="<?=$btn_write_style[2]?>" class="span36 height" size="2" data-target=".bo_btnSet" data-label="높이" data-label-inline="PX">
					<input type="text" name="btn_write_style[3]" value="<?=$btn_write_style[3]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-target=".bo_btnSet" data-label="기본컬러">
					<input type="text" name="btn_write_style[4]" value="<?=$btn_write_style[4]?>" class="colorpicker btnColor-hover" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-target=".bo_btnSet" data-label="호버 컬러">
				</div>
            </div>
        </div>
		<div class="form-list">
            <div class="form-label flex-top"><label>페이지 번호</label></div>
            <div class="formCon">
				<div class="flex gap10">
					<input type="text" name="btn_pager_style[0]" value="<?=$btn_pager_style[0]?>" class="span36 pager-size" size="2" data-target=".pg_wrap" data-label="사이즈" data-label-inline="PX">
					<input type="text" name="btn_pager_style[1]" value="<?=$btn_pager_style[1]?>" class="span36 pager-space" size="2" data-target=".pg_wrap" data-label="간격" data-label-inline="PX">
					<input type="text" name="btn_pager_style[2]" value="<?=$btn_pager_style[2]?>" class="span36 paser-round" size="2" data-target=".pg_wrap" data-label="라운딩" data-label-inline="PX">
					<input type="text" name="btn_pager_style[3]" value="<?=$btn_pager_style[3]?>" class="colorpicker btnColor-active" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-target=".pg_wrap" data-label="활성화 컬러">
				</div>
            </div>
        </div>
    </div>

	<div class="boStyle-preview">
		<div id="bo_title" class="<?=$title_style[0]?>" style="<?=$bo_title_root?>"><a href="#">게시판 제목</a></div>
		<div class="conbox">Contents</div>
		<div class="bo_btnSet" style="<?=$bo_btnSet_root?>">
			<span class="btn_write wide">글쓰기</span>
		</div>
		<nav class="pg_wrap<?=$btn_pager_style[1] !='' && $btn_pager_style[1]=='0'?' gap0':''?>" style="<?=$pg_wrap_root?>">
			<span class="pg">
				<a href="#" class="pg_page pg_start">처음</a>
				<a href="#" class="pg_page pg_prev">이전</a>
				<strong class="pg_current">1</strong>
				<a href="#" class="pg_page">2</a>
				<a href="#" class="pg_page">3</a>
				<a href="#" class="pg_page">4</a>
				<a href="#" class="pg_page">5</a>
				<a href="#" class="pg_page">6</a>
				<a href="#" class="pg_page">7</a>
				<a href="#" class="pg_page">8</a>
				<a href="#" class="pg_page">9</a>
				<a href="#" class="pg_page">10</a>
				<a href="#" class="pg_page pg_next">다음</a>
				<a href="#" class="pg_page pg_end">맨끝</a>
			</span>
		</nav>
	</div>

</section>

<script>
$(document).ready(function(){
	$('input').bind("keyup", function(event) {
		var thisValue = $(this).val();
		var thisColor = $(this).attr('data-swatches');
		var target = $($(this).attr('data-target'));

		if( $(this).hasClass('font-size') ) 
			if(thisValue) target.get(0).style.setProperty("--font-size",thisValue+"px"); else target.get(0).style.setProperty("--font-size",'');

		if( $(this).hasClass('width') )
			if(thisValue) target.get(0).style.setProperty("--btn-width",thisValue+"px"); else target.get(0).style.setProperty("--btn-width",'');

		if( $(this).hasClass('height') )
			if(thisValue) target.get(0).style.setProperty("--btn-height",thisValue+"px"); else target.get(0).style.setProperty("--btn-height",'');

		if( $(this).hasClass('margin-bottom') )
			if(thisValue) target.css({"margin-bottom":thisValue+"px"}); else target.css("margin-bottom","");

		if( $(this).hasClass('pager-size') )
			if(thisValue) target.get(0).style.setProperty("--btn-size",thisValue+"px"); else target.get(0).style.setProperty("--btn-size",'');

		if( $(this).hasClass('pager-space') ) {
			if(thisValue) {
				if(thisValue == '0') {
					target.addClass('gap0');
				} else {
					target.removeClass('gap0');
				}
				if(thisValue) target.get(0).style.setProperty("--btn-gap",thisValue+"px"); else target.get(0).style.setProperty("--btn-gap",'');
			} else {
				target.removeClass('gap0');
				target.get(0).style.setProperty("--btn-gap",'');
			}
		}
		if( $(this).hasClass('paser-round') )
			if(thisValue) target.get(0).style.setProperty("--btn-radius",thisValue+"px"); else target.get(0).style.setProperty("--btn-radius",'');
	});

	$('input.colorpicker').change(function (){
		var thisValue = $(this).val();
		var target = $($(this).attr('data-target'));

		if( $(this).hasClass('textColor') ) {
			if(thisValue) target.get(0).style.setProperty("--font-color",thisValue); else target.get(0).style.setProperty("--font-color",'');
		} else {
			if( $(this).hasClass('btnColor') )
				if(thisValue) target.get(0).style.setProperty("--btnColor",thisValue); else target.get(0).style.setProperty("--btnColor",'');
			
			if( $(this).hasClass('btnColor-hover') )
				if(thisValue) target.get(0).style.setProperty("--btnColor-hover",thisValue); else target.get(0).style.setProperty("--btnColor-hover",'');

			if( $(this).hasClass('btnColor-active') )
				if(thisValue) target.get(0).style.setProperty("--btnColor-active",thisValue); else target.get(0).style.setProperty("--btnColor-active",'');
		}
	});

	$('select').change(function (){
		var thisValue = $(this).val();
		var target = $($(this).attr('data-target'));
		if( $(this).hasClass('font-family') ) {
			target.attr('class', '');
			if(thisValue) target.addClass(thisValue);
		}
		if( $(this).hasClass('font-size') ) {
			if(thisValue) target.get(0).style.setProperty("--font-size",thisValue+"px"); else target.get(0).style.setProperty("--font-size",'');
		}
	});

});
</script>