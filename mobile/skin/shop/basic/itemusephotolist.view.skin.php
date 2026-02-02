<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$add_headfile_skin = true;
include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);
?>
<?php
	$is_use = sql_fetch("select * from `g5_shop_item_use` where is_id = '$is_id' ");
	
	$dirfile = G5_URL.'/data/member_review/';
	$photo = explode(",",$is_use['is_file']);
	
	$is_name = mb_substr($is_use['is_name'], 0, -2).'**';
?>
<div id="itemusephotoview">
    <h1 id="pop_title">사진 후기</h1>
	<div id="itemusephotoview_container">
		<div id="imgCon">
			<?php
			echo '<div id="use_pvi_big">';
			echo '<img src="'.$dirfile.$photo[0].'" style="width:325px !important;height:325px;">';
			
				for($i=1; $i<=3; $i++) {
					//echo get_it_image($photo[0], 325, get_it_height(325)); //임시 이미지입니다	
					echo '<img src="'.$dirfile.$photo[$i].'" style="width:325px !important;height:325px;">';
				}
			
			echo '</div>';
			echo '<ul id="use_pvi_thumb">';
			for($i=0; $i<count($photo); $i++) {
				//echo '<li class="popup_item_image img_thumb">'.get_it_image($it_id, 57,57).'</li>'; //임시 이미지입니다	
				echo '<li class="popup_item_image img_thumb"><img src="'.$dirfile.$photo[$i].'" style="width:57px !important;height:57px;"></li>';
			}
			echo '</ul>';
			?>
		</div>
		<div id="txtCon">
			<div id="tctop">
				<span class="name"><?=$is_name?></span>
				<div class="grade fs16" data-score="<?=$is_use['is_score']?>">
					<span class="star"></span>
				</div>
			</div>
			<div id="useCon">
				<div class="head">
					<span class="subject"><?=$is_use['is_subject']?></span>
					<span class="date"><?=date("Y-m-d",strtotime($is_use['is_time']))?></span>
				</div>
				<div class="con">
					<?=$is_use['is_content']?>
				</div>
			</div>
		</div>		
	</div>
	<div class="btnSet">
		<a href="<?=$itemusephotolist_href?>" class="_btn/lg/line/tranparent w-200">목록보기</a>
	</div>
	<button type="button" onclick="window.close();" class="btn_close">창닫기</button>
</div>

<script>
$(function(){
    // 후기이미지 첫번째
    $("#use_pvi_big img:first").addClass("visible");

    // 후기이미지 (썸네일에 마우스 오버시)
    $("#use_pvi_thumb img").bind("mouseover focus", function(){
        var idx = $("#use_pvi_thumb img").index($(this));
        $("#use_pvi_big img.visible").removeClass("visible");
        $("#use_pvi_big img:eq("+idx+")").addClass("visible");
    });
});
</script>