<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined('_SHOP_')) {
    $pop_division = 'comm';
} else {
    $pop_division = 'shop';
}

$sql = " select * from {$g5['new_win_table']}
          where '".G5_TIME_YMDHIS."' between nw_begin_time and nw_end_time
            and nw_device IN ( 'both', 'mobile' ) and nw_division IN ( 'both', '".$pop_division."' )
          order by nw_id asc ";
$result = sql_query($sql, false);
?>


<div id="hd_pop">
	<h2 class="sound_only">팝업레이어 알림</h2>
	<?php
	for ($i=0; $nw=sql_fetch_array($result); $i++) {
		// 이미 체크 되었다면 Continue
		if (isset($_COOKIE["hd_pops_{$nw['nw_id']}"]) && $_COOKIE["hd_pops_{$nw['nw_id']}"])
			continue;

		echo '<div id="hd_pops_'.$nw['nw_id'].'" class="hd_pops">';
		echo '<div class="hd_pops_con">';
		echo '<button class="hd_pops_close hd_pops_'.$nw['nw_id'].'">닫기</button>';
		echo conv_content($nw['nw_content'], 1);			
		echo '</div>';

		echo '<div class="hd_pops_footer">';
		echo '<button class="hd_pops_reject hd_pops_'.$nw['nw_id'].' '.$nw['nw_disable_hours'].'">다시보지 않기</button>';		
		echo '</div>';
		echo '<div class="hd_pops_bg"></div>';
		echo '</div>';
		echo '<script>$("body, html").css("overflow", "hidden");</script>';
		
	}
	if ($i == 0) echo '<span class="sound_only">팝업레이어 알림이 없습니다.</span>';
	?>
</div>

<script>
$(function() {
    $(".hd_pops_reject").click(function() {
        var id = $(this).attr('class').split(' ');
        var ck_name = id[1];
        var exp_time = parseInt(id[2]);
        $("#"+id[1]).css("display", "none");
		$('body, html').css('overflow', '');
        set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
    });
    $('.hd_pops_close').click(function() {
        var idb = $(this).attr('class').split(' ');
        $('#'+idb[1]).css('display','none');
		$('body, html').css('overflow', '');
    });
});
</script>
<!-- } 팝업레이어 끝 -->