<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$shop_page = sql_fetch(" select * from {$g5['g5_shop_page_table']} where pn_id='".$bl_cate."'");

$where = ' where ';
$sql_search = '';

if ($bl_use){	
	if($bl_use != 'all') {
		$sql_search .= " $where bl_use = '$bl_use' ";
		$qstr .= "&amp;bl_use=$bl_use";
		$where = ' and ';
	}
} else {
	$sql_search .= " $where (bl_use = '' || bl_use = 'pc' || bl_use = 'mobile') ";
	$qstr .= "&amp;bl_use='' ";
	$where = ' and ';
}

if ($bl_cate) {
	$sql_search .= " $where bl_cate = '$bl_cate' ";
	$qstr .= "&amp;bl_cate=$bl_cate";
	$where = ' and ';
}

$sql_common = " from {$g5['g5_shop_block_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 50;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by bl_order < 0, bl_order = 0, bl_order, bl_id limit $from_record, {$rows} ";
$result = sql_query($sql);
?>

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
//<![CDATA[
$(function() {
    $("#sortable").sortable({
        start: function(event, ui) {
			$(this).children('li.ui-sortable-helper').css({'z-index':'99'});
        },
        stop: function(event, ui) {
			$(this).children('li').css({'z-index':''});
			reorder();
        }
    });    
    //$( "#sortable" ).sortable({});
    $( "#sortable" ).disableSelection();
});
function reorder() {
    $(".frm_bl_ul > li").each(function(i) {
		$(this).find(".bl_order").val(i + 1);
    });
}
//]]>
</script>

<?php if($title == '쇼핑몰 페이지 관리') { ?>
<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_page_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data" style="margin-bottom:40px;">
<input type='hidden' name="pn_id" value="<?=$bl_cate?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
<div class="formContainer" style="position:absolute;top:8px;left:200px">
	<div class="form-list p6" style="background:rgba(0,0,0,0.06);border-radius:6px;">
		<div class="formCon">
			<input type="text" name="pn_subject" value="<?=$shop_page['pn_subject']?>" class="w-250" placeholder="페이지명을 입력해 주세요." data-label="페이지명">
			<input type="submit"value="적용하기" class="btn_submit _btn/sm/green/rd4" accesskey="s">
		</div>
	</div>
</div>
</form>
<?php } ?>

<form name="_adm_shop_bl_bundle" id="_adm_shop_bl_bundle" action="<?=$_adm_update_url?>/_shop_block_list_bundle_update.php" onsubmit="return _adm_shop_bl_bundle_submit(this);" method="post">
<input type='hidden' name='chk' value='<?=$total_count?>'>
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
<section id="" class="">	
	
	<div id="shop_block_tabs">
		<ul>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_block&bl_cate=<?=$bl_cate?>&title=쇼핑몰 메인페이지&bl_use=all" class="tab<?=$bl_use=='all'?' active':''?>">전체 블럭</a></li>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_block&bl_cate=<?=$bl_cate?>&title=쇼핑몰 메인페이지" class="tab<?=!$bl_use?' active':''?>">공개</a></li>
			<?php if($bl_cate=='index') { ?>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_block&bl_cate=<?=$bl_cate?>&title=쇼핑몰 메인페이지&bl_use=admin" class="tab<?=$bl_use=='admin'?' active':''?>">관리자 확인용</a></li>
			<?php } ?>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_block&bl_cate=<?=$bl_cate?>&title=쇼핑몰 메인페이지&bl_use=none" class="tab<?=$bl_use=='none'?' active':''?>">비공개</a></li>			
		</ul>
		<?php if($bl_use=='admin') echo '<span class="_btn/black/sm/rd4 view_admin_index ml20">관리자용 메인화면 보기</span>'; ?>
		<div class="ml-auto flex flex-middle">
			<label class="checkbox-label"><input type="checkbox" name="all_order_reset" value="1" id="all_order_reset">순서 초기화</label>
			<input type="submit" name="btn_submit" value="불럭 순서+이름 저장" class="btn_submit btn" onclick="document.pressed='bundle'" accesskey="s">
		</div>
	</div>

	<ul class="frm_bl_ul" id="sortable">
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bl_img1[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_1';
			if(file_exists($bl_img1[$i])) {				
				$thumb1[$i] = thumbnail('bl'.$row['bl_id'].'_1', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 130, '', 1, 1, 'center');
				$bl_thumb1[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$thumb1[$i].'" style="border-radius:3px;">';
			}
			
			$bl_icon1[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon1';
			$bl_icon1_thumb[$i] = '';
			if(file_exists($bl_icon1[$i])) {				
				$icon1[$i] = thumbnail('bl'.$row['bl_id'].'_icon1', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon1_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon1[$i].'" style="border:0;">';
			}
			$bl_icon2[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon2';
			$bl_icon2_thumb[$i] = '';
			if(file_exists($bl_icon2[$i])) {				
				$icon2[$i] = thumbnail('bl'.$row['bl_id'].'_icon2', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon2_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon2[$i].'" style="border:0;">';
			}
			$bl_icon3[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon3';
			$bl_icon3_thumb[$i] = '';
			if(file_exists($bl_icon3[$i])) {				
				$icon3[$i] = thumbnail('bl'.$row['bl_id'].'_icon3', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon3_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon3[$i].'" style="border:0;">';
			}
			$bl_icon4[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon4';
			$bl_icon4_thumb[$i] = '';
			if(file_exists($bl_icon4[$i])) {				
				$icon4[$i] = thumbnail('bl'.$row['bl_id'].'_icon4', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon4_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon4[$i].'" style="border:0;">';
			}
			$bl_icon5[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon5';
			$bl_icon5_thumb[$i] = '';
			if(file_exists($bl_icon5[$i])) {				
				$icon5[$i] = thumbnail('bl'.$row['bl_id'].'_icon5', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon5_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon5[$i].'" style="border:0;">';
			}
			$bl_icon6[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon6';
			$bl_icon6_thumb[$i] = '';
			if(file_exists($bl_icon6[$i])) {				
				$icon6[$i] = thumbnail('bl'.$row['bl_id'].'_icon6', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon6_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon6[$i].'" style="border:0;">';
			}
			$bl_icon7[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon7';
			$bl_icon7_thumb[$i] = '';
			if(file_exists($bl_icon7[$i])) {				
				$icon7[$i] = thumbnail('bl'.$row['bl_id'].'_icon7', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon7_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon7[$i].'" style="border:0;">';
			}
			$bl_icon8[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon8';
			$bl_icon8_thumb[$i] = '';
			if(file_exists($bl_icon8[$i])) {				
				$icon8[$i] = thumbnail('bl'.$row['bl_id'].'_icon8', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon8_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon8[$i].'" style="border:0;">';
			}
			$bl_icon9[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon9';
			$bl_icon9_thumb[$i] = '';
			if(file_exists($bl_icon9[$i])) {				
				$icon9[$i] = thumbnail('bl'.$row['bl_id'].'_icon9', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon9_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon9[$i].'" style="border:0;">';
			}
			$bl_icon10[$i] = G5_DATA_PATH.'/shop_block/bl'.$row['bl_id'].'_icon10';
			$bl_icon10_thumb[$i] = '';
			if(file_exists($bl_icon10[$i])) {				
				$icon10[$i] = thumbnail('bl'.$row['bl_id'].'_icon10', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 36, '', 1, 1, 'center');
				$bl_icon10_thumb[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$icon10[$i].'" style="border:0;">';
			}

			$select_use_style[$i] = '';
			if($row['bl_use']=='none') $select_use_style[$i] = 'selectColor-gray-light';
			if($row['bl_use']=='admin') $select_use_style[$i] = 'selectColor-black';			
			
			if($row['bl_type'] == 'banner' || $row['bl_type'] == 'item' || $row['bl_type'] == 'itemuse') {
				$order_count[$i] = '0';
				if(strpos($row['items_order_option'], 'list_of_select') !== false) {
					$order_count[$i] = '직접선택';
				} else {
					$order_count[$i] = $row['items_count'] ? $row['items_count'].'개' : '2개'; //미입력시 기본 5개
				}
			}
			
			$bl_padding[$i] = explode("|", $row['bl_padding']);
			$items_skin[$i] = explode("|", $row['items_skin']);
			


			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			echo '<li class="'.($row['bl_use']?'use-'.$row['bl_use']:'').'" data-bl-id="'.$row['bl_id'].'">';
				echo '<div class="labelCheck edit-mode"><label class="labelCheck"><input type="checkbox" name="chk_bl_id[]" value="'.$row['bl_id'].'" id="chkbl_id_'.$i.'"></label></div>';
				echo '<div class="list_inner flex flex-middle gap20">';
					echo '<input type="hidden" name="bl_id_up['.$i.']" value="'.$row['bl_id'].'">';
					echo '<input type="text" name="bl_order['.$i.']" value="'.$row['bl_order'].'" class="bl_order tcenter" placeholder="">';

					echo '<div class="bl_name_input'.(!$row['bl_name']?' empty':'').'"><input type="text" name="bl_name['.$i.']" value="'.$row['bl_name'].'" placeholder="블럭이름"><span class="dom"></span></div>';

					echo '<div class="select_bl_use">';
						echo '<select name="bl_use['.$i.']" value="'.$row['bl_use'].'" id="bl_use['.$i.']" class="bl_use selectpicker" data-bl-id="'.$row['bl_id'].'" data-style="'.$select_use_style[$i].'">';
						echo option_selected_my("",  $row['bl_use'], "전체 공개", "data-content='<span class=\"icon_check\">전체 공개</span>'");
						echo option_selected_my("pc",  $row['bl_use'], "pc", "data-content='<span class=\"icon_none\">pc</span>'");
						echo option_selected_my("mobile",  $row['bl_use'], "mobile", "data-content='<span class=\"icon_none\">모바일</span>'");
						echo option_selected_my("none",  $row['bl_use'], "비공개", "data-content='<span class=\"icon_none\">비공개</span>'");
						echo option_selected_my("admin",  $row['bl_use'], "관리자 확인용", "data-content='<span class=\"icon_admin\">관리자 확인용</span>'");
						echo '</select>';						
					echo '</div>';
			
					echo '<div class="flex column flex-start gap10">';
						if($row['bl_title']) {
							$bl_title_arr[$i] = explode(PHP_EOL, $row['bl_title']);
							$bl_title[$i] = '';
							for($t=0; $t<2; $t++) {
								//$bl_title[$i] .= $t==0 ? $bl_title_arr[$i][0] : '<span class="color-gray fw500 ml5">...</span>';
								$bl_title[$i] .= $t==0 ? $bl_title_arr[$i][0] : '<span class="color-gray fw500 fs11 ml10">'.cut_str($bl_title_arr[$i][$t], 15, '…').'</span>';
							}
							echo '<div class="bl_title">'.$bl_title[$i].'</div>';
						}
						echo '<div class="flex flex-middle gap25">';
							
							if($bl_padding[$i][0] || $bl_padding[$i][0] === '0') $bl_p_t[$i] = '<span class="bl_p_t">'.$bl_padding[$i][0].'</span>';
							if($bl_padding[$i][1] || $bl_padding[$i][1] === '0') $bl_p_b[$i] = '<span class="bl_p_b">'.$bl_padding[$i][1].'</span>';
							if($bl_padding[$i][2] || $bl_padding[$i][2] === '0') $bl_p_lr[$i] = '<span class="bl_p_t">'.$bl_padding[$i][2].'</span><span class="bl_p_b">'.$bl_padding[$i][2].'</span>';

							if($row['bl_type']) {
								echo '<div class="bl_type '.$row['bl_type'].'">';
									if($row['bl_type'] == 'banner') echo '배너 출력';
									if($row['bl_type'] == 'item') echo '상품 출력';
									if($row['bl_type'] == 'itemuse') echo '상품후기 출력';
									if($row['bl_type'] == 'banner' || $row['bl_type'] == 'item' || $row['bl_type'] == 'itemuse') {
										$bl_type_sub[$i] = $order_count[$i];
										if($row['items_cols']) $bl_type_sub[$i] .= 'ㆍ'.$row['items_cols'].'개씩';
										if($row['items_gap']) $bl_type_sub[$i] .= 'ㆍ'.$row['items_gap'].'px';
										$bl_type_sub[$i] = '<sub class="color-yellow-light">'.$bl_type_sub[$i].'</sub>';
										echo $bl_type_sub[$i];
									}									
									if($row['bl_type'] == 'shopCate') {
										echo '상품 카테고리 출력';
										if($row['items_order_option']) echo '<sub class="color-yellow-light">'.$row['items_order_option'].'</sub>';
									}
									if($row['bl_type'] == 'link') {
										echo '바로가기 (아이콘) 링크';
										if($row['items_cols']) echo '<sub class="color-yellow-light">'.$row['items_cols'].'개씩</sub>';
									}
									if($row['bl_type'] == 'mix') {
										echo 'MIX';
										echo '<sub class="color-yellow-light">'.$row['mix_type'].'</sub>';										
									}
									echo $bl_p_t[$i].$bl_p_b[$i].$bl_p_lr[$i];
								echo '</div>';

								if(($row['bl_type']=='item'||$row['bl_type']=='itemuse') && $items_skin[$i][0]) echo '<img src="'.$_adm_url.'/img/shop/'.$items_skin[$i][0].'.gif">';
							}
							if($row['bl_video_src']) echo '<div class="bl_video">동영상'.$bl_p_t[$i].$bl_p_b[$i].$bl_p_lr[$i].'</div>';
							if($bl_thumb1[$i]) echo $bl_thumb1[$i];
							
							if($row['bl_type'] == 'link') {
								echo $bl_icon1_thumb[$i];
								echo $bl_icon2_thumb[$i];
								echo $bl_icon3_thumb[$i];
								echo $bl_icon4_thumb[$i];
								echo $bl_icon5_thumb[$i];
								echo $bl_icon6_thumb[$i];
								echo $bl_icon7_thumb[$i];
								echo $bl_icon8_thumb[$i];
								echo $bl_icon9_thumb[$i];
								echo $bl_icon10_thumb[$i];
							}
							
							if($row['bl_type'] == 'mix') {
								$mix_img_path[$i] = G5_THEME_PATH.'/skin/shop/basic/mix_type/'.$row['mix_type'].'/thumb.gif';
								$mix_img_url[$i] = str_replace(G5_PATH, G5_URL, $mix_img_path[$i]);
								echo '<img src="'.get_url($mix_img_url[$i]).'">';
							}

							$inc_shop_block[$i] = G5_HTML_PATH.'/_shop_block/_section_'.$row['bl_id'].'.php';
							if(file_exists($inc_shop_block[$i])) {
								echo '<div class="layout-box column gap5 w-55">';
									echo '<div class="itemContainer">';										
										echo '<span class="item h-22 active">HTML</span>';
										echo '<p class="text">html/_shop_block/<span>_section_'.$row['bl_id'].'.php</span></p>';
									echo '</div>';
								echo '</div>';
							}
							
						echo '</div>';
						
					echo '</div>';

			
					echo '<div class="ml-auto inline-flex flex-middle gap5">';						
						echo '<a href="'.$_adm_url.'/?pn=_shop_block_form&bl_cate='.$bl_cate.'&title=블럭 수정&w=u&amp;bl_id='.$row['bl_id'].($bl_use?'&bl_use='.$bl_use:'').'" class="_btn/mini/blue/rd4">수정</a>';
						//echo '<a href="'.$_adm_url.'/?pn=_shop_block_move&bl_cate='.$bl_cate.'&title=블럭 복사&w=u&amp;bl_id='.$row['bl_id'].($bl_use?'&bl_use='.$bl_use:'').'" class="_btn/mini/green/rd4 popWin" data-width="400" data-height="500" data-top="60" data-left="0">복사</a>';
						echo '<a href="'.$_adm_url.'/_shop_block_form_update.php?w=d&bl_cate='.$bl_cate.'&amp;bl_id='.$row['bl_id'].($bl_use?'&bl_use='.$bl_use:'').'" onclick="return delete_confirm(this);" class="_btn/mini/gray/rd4">삭제</a>';
					echo '</div>';

			
				echo '</div>';
			echo '</li>';
		}
		if($i==0) echo '<li class="empty_li">등록된 블럭이 없습니다.</li>';
		?>
	</ul>
	
	
	
	<?php echo get_paging(10, $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?tab=1&pn=".$pn."&$qstr&amp;page="); ?>
</section>

<?php
/*echo '<div class="bl_adm_set">';
	echo '<span class="btnEditMode">EDIT-MODE</span>';
	echo '<ul class="ul-edit-mode">';
		if(number_format($total_count) > 0) {
			echo '<li class="edit-mode"><label class="btnChkall"><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"><span>전체선택</span></label></li>';
			echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택삭제" class="del" onclick="document.pressed=this.value"></li>';
			echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>';
		}
	echo '</ul>';
echo '</div>';*/
?>

<div class="_adm_btnSet">
	 <a href="<?=$_adm_url?>/?pn=_shop_block_form&bl_cate=<?=$bl_cate?>&title=블럭 추가<?=$_GET['bl_use']?'&bl_use='.$_GET['bl_use']:''?>" class="add_block" data-resize="1400,860">블럭 추가</a>
</div>
</form>

<script>
function input_autosize(el) {
	var val = $(el).val();
	$(el).next('.dom').text(val);
}
$(document).ready(function(){
	$('.bl_name_input input').each(function() {
		input_autosize($(this));
	});
});
$('.bl_name_input input').on('keydown', function(e){
	input_autosize($(this));    
});

$('.frm_bl_ul li').hover(function() {
	var bl_id = $(this).attr('data-bl-id');
	var offset = opener.$('#section-'+bl_id).offset();	
	opener.$('#section-'+bl_id).addClass('hover-marker');
	opener.$('html').animate({scrollTop : offset.top - 60}, 400);
}, function(){
	var bl_id = $(this).attr('data-bl-id');
	opener.$('#section-'+bl_id).removeClass('hover-marker');	
});

/*$('.frm_bl_ul li').click(function() {
	var bl_id = $(this).attr('data-bl-id');
	var offset = opener.$('#section-'+bl_id).offset();
	opener.$('html').animate({scrollTop : offset.top - 60}, 500);
});*/

$('.bl_use').change(function (){
	var bl_use = $(this).val(),
		bl_id = $(this).attr('data-bl-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_shop_block_list_use_update.php",{bl_use:bl_use, bl_id:bl_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});

$('.add_block').click(function() {
	let resize = $(this).attr('data-resize').split(',');	
	if(resize) {
		window.resizeTo(resize[0], resize[1]);
	}
});

$('.btnEditMode').click(function() {
	$(this).toggleClass('on');
	$('.ul-edit-mode, .edit-mode').toggleClass('on');
});

function delete_confirm(el) {
	if(!confirm('삭제하시면 복구할수 없습니다. \n정말로 삭제하시겠습니까??')){
		return false;
	}
}

$('.view_admin_index').click(function() {
	opener.document.location.href='<?=G5_SHOP_URL?>?pn=_view_adm';
});



function _adm_shop_bl_bundle_submit(f){

	if(document.pressed != "bundle") {
		var chk_count = 0;

		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_bl_id[]" && f.elements[i].checked)
				chk_count++;
		}

		if (!chk_count) {
			alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
			return false;
		}

		if(document.pressed == "선택복사") {
			select_copy("copy");
			return false;
		}
	}

	return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
   var f = document._adm_shop_bl_bundle; 
   var sub_win = window.open("", "cate", "left=50, top=50, width=400, height=480, scrollbars=1"); 
   
   f.action = g5_bbs_url+"/my/_adm/?pn=_shop_block_move&bl_cate=<?=bl_cate?>&title=블럭 복사";
   f.submit();
}

function all_checked(sw) {
    var f = document._adm_shop_bl_bundle;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bl_id[]")
            f.elements[i].checked = sw;
    }
}
</script>