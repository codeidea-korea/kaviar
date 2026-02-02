<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$shop_banner_category = explode('|', $default['shop_banner_category']);
$shop_banner_category_str = '';
for($i=0; $i<count($shop_banner_category); $i++) {
	if($shop_banner_category[$i]) $shop_banner_category_str .= '<li><a href="'.$_adm_url.'/?'.($tab?'tab=1&':'').'pn=_shop_banner&bn_position=basic&bn_cate='.$shop_banner_category[$i].'" class="'.($bn_cate==$shop_banner_category[$i]?' active':'').'">'.$shop_banner_category[$i].'</a></li>';
}
if($shop_banner_category_str) $shop_banner_category_str = '<ul class="sub-tab-ul">'.$shop_banner_category_str.'</ul>';

$bn_position = (isset($_GET['bn_position'])) ? $_GET['bn_position'] : '';
$bn_device = (isset($_GET['bn_device']) && in_array($_GET['bn_device'], array('pc', 'mobile'))) ? $_GET['bn_device'] : 'both';
$bn_time = (isset($_GET['bn_time']) && in_array($_GET['bn_time'], array('ing', 'end'))) ? $_GET['bn_time'] : '';

$where = ' where ';
$sql_search = '';

if ( $bn_position ){
	if($bn_position == 'basic') {
		$sql_search .= " $where bn_position = '' ";
	} else {
		$sql_search .= " $where bn_position = '$bn_position' ";
	}
    $where = ' and ';
    $qstr .= "&amp;bn_position=$bn_position";
}

if ( $bn_cate ){
	$sql_search .= " and bn_cate = '$bn_cate' ";
    $qstr .= "&amp;bn_cate=$bn_cate";
}

if ( $bn_device && $bn_device !== 'both' ){
    $sql_search .= " $where bn_device = '$bn_device' ";
    $where = ' and ';
    $qstr .= "&amp;bn_device=$bn_device";
}

if ( $bn_time ){
    $sql_search .= ($bn_time === 'ing') ? " $where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time " : " $where bn_end_time < '".G5_TIME_YMDHIS."' ";
    $where = ' and ';
    $qstr .= "&amp;bn_time=$bn_time";
}

$sql_common = " from {$g5['g5_shop_banner_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30; //$config['cf_page_rows']
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
//<![CDATA[
$(function() {
    $("#sortable").sortable({
        start: function(event, ui) {
        },
        stop: function(event, ui) {
			reorder();
        }
    });    
    //$( "#sortable" ).sortable({});
    $( "#sortable" ).disableSelection();
});
function reorder() {
    $(".frm_bl_ul > li").each(function(i) {
		$(this).find(".bn_order").val(i + 1);
    });
}
//]]>
</script>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_banner_list_bundle_update.php" onsubmit="return _adm_form_submit(this);" method="post">
<input type='hidden' name='chk' value='<?=$total_count?>'>
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section id="" class="">

	<div id="shop_banner_tabs"<?=$tab?' class="tabtab"':''?>>
		<ul class="">
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner" class="tab<?=!$bn_position?' active':''?>">전체 배너</a></li>
		</ul>
		<ul>
			<li class="sub-tab-hover">
				<a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=basic" class="tab<?=$bn_position=='basic'?' active':''?>">블럭용<?=$bn_cate?' ('.$bn_cate.')':''?></a>
				<?=$shop_banner_category_str?>
				<?='<a href="'.G5_BBS_URL.'/my/_adm/?pn=_shop_banner_category&title=쇼핑몰 배너 분류관리" class="btnSetting popWin" data-width="700" data-height="320" data-top="60" data-left="0" style="">쇼핑몰 배너 분류관리</a>';?>
			</li>
		</ul>
		<ul>			
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=메인 팝업" class="tab<?=$bn_position=='메인 팝업'?' active':''?>">메인 팝업</a></li>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=상단 띠배너" class="tab<?=$bn_position=='상단 띠배너'?' active':''?>">상단 띠배너</a></li>
			<?php if($default['shop_layout'] == 'outside-right') { ?>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=사이드 배너" class="tab<?=$bn_position=='사이드 배너'?' active':''?>">사이드 배너</a></li>
			<?php } ?>
		</ul>
		<ul>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=로그인 페이지" class="tab<?=$bn_position=='로그인 페이지'?' active':''?>">로그인 페이지</a></li>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=장바구니" class="tab<?=$bn_position=='장바구니'?' active':''?>">장바구니</a></li>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=마이페이지" class="tab<?=$bn_position=='마이페이지'?' active':''?>">마이페이지</a></li>
			<li><a href="<?=$_adm_url?>/?<?=$tab?'tab=1&':''?>pn=_shop_banner&bn_position=상품상세" class="tab<?=$bn_position=='상품상세'?' active':''?>">상품상세</a></li>
		</ul>
		<div class="ml-auto flex flex-middle gap15">
			<label class="checkbox-label"><input type="checkbox" name="all_order_reset" value="1" id="all_order_reset">모든 순서 초기화</label>
			<input type="submit" value="순서 변경하기" class="btn_submit btn ml-auto" accesskey="s">
		</div>
	</div>

	<?php if($bn_position == '상단 띠배너') { ?>
	<div class="formContainer mb15 -mt10" style="">
		<div class="form-list" style="padding:0;">
			<div class="formCon">
				<input type="text" name="bn_closer_color" value="<?=$default['bn_closer_color']?>" id="bn_closer_color" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" data-label="닫기버튼 컬러" placeholder="#">
				<span id="bn_closer_color_change" class="_btn/sm/green/rd4">적용하기</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<ul class="frm_bl_ul" id="sortable">
		<?php
		$sql = " select * from {$g5['g5_shop_banner_table']} $sql_search order by bn_order, bn_id desc limit $from_record, $rows  ";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
			$bn_img = "";
			if(file_exists($bimg)) {
				$banner_thumb = thumbnail($row['bn_id'], G5_DATA_PATH.'/banner/', G5_DATA_PATH.'/banner/', 180, '', 1, 1, 'center');								
				$bn_img .= '<img src="'.G5_DATA_URL.'/banner/'.$banner_thumb.'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']).'"'.($row['bn_alt']?' title="'.$row['bn_alt'].'"':'').'>';
			}
			$bn_begin_time = substr($row['bn_begin_time'], 2, 14);
			$bn_end_time = substr($row['bn_end_time'], 2, 14);			

			echo '<li class="piece-2'.($row['bn_off']?' no-use':'').'" data-bn-id="'.$row['bn_id'].'">';
			echo '<div class="list_inner p15">';
			echo get_live_msg($bn_begin_time, $bn_end_time);
			
			echo '<input type="hidden" name="bn_id_up['.$i.']" value="'.$row['bn_id'].'">';
			echo '<input type="text" name="bn_order['.$i.']" value="'.$row['bn_order'].'" id="wr_order['.$i.']" class="bn_order tcenter" placeholder="">';
			echo '<div class="flex flex-middle gap30">';
			echo $bn_img;
			echo '<div class="inline-flex column gap5 mb-auto flex1">';
			echo '<div class="flex flex-middle flex-wrap gap10">';
			$select_bn_position_style[$i] = '';
			if($row['bn_position']=='메인 팝업') $select_bn_position_style[$i] = ' data-style="selectColor-green"';
			if($row['bn_position']=='상단 띠배너') $select_bn_position_style[$i] = ' data-style="selectColor-pink-light"';
			if($row['bn_position']=='사이드 배너') $select_bn_position_style[$i] = ' data-style="selectColor-pink-light"';
			if($row['bn_position']=='로그인 페이지' || $row['bn_position']=='마이페이지') $select_bn_position_style[$i] = ' data-style="selectColor-yellow"';
			if($row['bn_position']=='상품상세') $select_bn_position_style[$i] = ' data-style="selectColor-red"';
			echo '<select name="bn_position['.$i.']" value="'.$row['bn_position'].'" class="bn_position selectpicker" data-bn-id="'.$row['bn_id'].'" data-label="출력위치"'.$select_bn_position_style[$i].'>';
			echo option_selected("",  $row['bn_position'], "블럭용");
			echo option_selected("메인 팝업",  $row['bn_position'], "메인 팝업");
			echo option_selected("상단 띠배너",  $row['bn_position'], "상단 띠배너");
			if($default['shop_layout'] == 'outside-right') echo option_selected("사이드 배너",  $row['bn_position'], "사이드 배너");
			echo option_selected("로그인 페이지",  $row['bn_position'], "로그인 페이지");
			echo option_selected("마이페이지",  $row['bn_position'], "마이페이지");
			echo option_selected("상품상세",  $row['bn_position'], "상품상세");
			echo '</select>';
			
			if(!$row['bn_position'] && $default['shop_banner_category']) {
				echo '<select name="bn_cate['.$i.']" value="'.$row['bn_cate'].'" class="bn_cate selectpicker" data-bn-id="'.$row['bn_id'].'" data-label="배너분류"'.($row['bn_cate']?' data-style="selectColor-gray"':'').'>';
				echo option_selected("",  $row['bn_cate'], "분류 없음");
				for($i=0; $i<count($shop_banner_category); $i++) {
					echo option_selected($shop_banner_category[$i],  $row['bn_cate'], $shop_banner_category[$i]);
				}
				echo '</select>';
			}
			if($row['bn_position']=='상단 띠배너') {
				echo '<select name="bn_location['.$i.']" value="'.$row['bn_location'].'" class="bn_location selectpicker" data-bn-id="'.$row['bn_id'].'" data-label="출력할 페이지"'.($row['bn_location']?' data-style="selectColor-gray"':'').'>';
				echo option_selected("",  $row['bn_location'], "메인페이지만 출력");
				echo option_selected("all",  $row['bn_location'], "모든페이지 출력");
				echo '</select>';
			}
			echo '</div>';
			echo '<span class="color-gray mt5">게시일 : <b class="color-black">'.($bn_begin_time=='00-00-00 00:00'?'없음':$bn_begin_time).'</b></span>';
			echo '<span class="color-gray">종료일 : <b class="color-black">'.($bn_end_time=='00-00-00 00:00'?'없음':$bn_end_time).'</b></span>';
			echo '</div>';
			
			echo '<div class="ml-auto flex flex-middle gap5" style="position:absolute;bottom:15px;right:15px;">';
			echo '<a href="'.$_adm_url.'/?pn=_shop_banner_form&title=쇼핑몰 배너 수정&is_tab='.$tab.'&w=u&amp;bn_id='.$row['bn_id'].($bn_position?'&bn_position='.$bn_position:'').($bn_cate?'&bn_cate='.$bn_cate:'').'" class="_btn/mini/blue/rd4">수정</a>';
			echo '<span onclick="_del_banner(\''.$_adm_url.'/_shop_banner_form_update.php?w=d&amp;bn_id='.$row['bn_id'].'\');" class="_btn/mini/gray/rd4 _del_banner">삭제</span>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</li>';
		}
		if ($i == 0) echo '<li class="empty_li">등록된 배너가 없습니다.</li>';
		?>
	</ul>

	<?php echo get_paging(10, $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?tab=1&pn=".$pn."&$qstr&amp;page="); ?>

</section>

<div class="_adm_btnSet">
	<a href="<?=$_adm_url?>/?pn=_shop_banner_form&title=쇼핑몰 배너 등록&is_tab=<?=$tab?><?=$bn_position?'&bn_position='.$bn_position:''?><?=$bn_cate?'&bn_cate='.$bn_cate:''?>" class="_btn/black/md add_banner rd5">배너추가</a>
</div>
</form>

<script>
$('.bn_position').change(function (){
	var bn_position = $(this).val(),
		bn_id = $(this).attr('data-bn-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_shop_banner_list_position_update.php",{bn_position:bn_position, bn_id:bn_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
$('.bn_cate').change(function (){
	var bn_cate = $(this).val(),
		bn_id = $(this).attr('data-bn-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_shop_banner_list_category_update.php",{bn_cate:bn_cate, bn_id:bn_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
$('.bn_location').change(function (){
	var bn_location = $(this).val(),
		bn_id = $(this).attr('data-bn-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_shop_banner_list_location_update.php",{bn_location:bn_location, bn_id:bn_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
$('#bn_closer_color_change').click(function (){
	var bn_closer_color = $('#bn_closer_color').val();
	$.post("<?=G5_BBS_URL?>/my/_adm/_shop_banner_closer_color_update.php",{bn_closer_color:bn_closer_color}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});


function _del_banner(url){
  if (confirm("정말 삭제하시겠습니까??") == true){    //확인
	  //alert(url);
      document.location = url;
  } else {
      return;
  }
}



</script>