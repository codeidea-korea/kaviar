<?php
if (!defined('_GNUBOARD_')) exit;

$shop_banner_category = explode('|', $default['shop_banner_category']);
$shop_banner_category_str = '';
for($i=0; $i<count($shop_banner_category); $i++) {
	if($shop_banner_category[$i]) $shop_banner_category_str .= '<li><a href="./bannerlist.php?page='.$page.'&bn_position=basic&bn_cate='.$shop_banner_category[$i].'" class="'.($bn_cate==$shop_banner_category[$i]?' active':'').'">'.$shop_banner_category[$i].'</a></li>';
}
if($shop_banner_category_str) $shop_banner_category_str = '<ul class="sub-tab-ul">'.$shop_banner_category_str.'</ul>';
?>

<div id="topTabs">
	<div class="tabs-group">
		<a href="./bannerlist.php" class="tab<?=!$bn_position?' active':''?>">전체 배너</a>
	</div>
	<div class="tabs-group sub-tab-hover">
		<div><a href="./bannerlist.php?page=<?=$page?>&bn_position=basic" class="tab<?=$bn_position=='basic'?' active':''?>">블럭용<?=$bn_cate?' ('.$bn_cate.')':''?></a></div>
		<?=$shop_banner_category_str?>
		<?php echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_shop_banner_category&title=쇼핑몰 배너 분류관리" class="btnSetting popWin" data-width="700" data-height="320" data-top="60" data-left="0" style="">쇼핑몰 배너 분류관리</a>';?>
	</div>
	<div class="tabs-group">
		<a href="./bannerlist.php?page=<?=$page?>&bn_position=메인 팝업" class="tab<?=$bn_position=='메인 팝업'?' active':''?>">메인 팝업</a>
	</div>
	<div class="tabs-group">
		<a href="./bannerlist.php?page=<?=$page?>&bn_position=사이드 배너" class="tab<?=$bn_position=='사이드 배너'?' active':''?>">사이드 배너</a>
	</div>
	<div class="tabs-group">
		<a href="./bannerlist.php?page=<?=$page?>&bn_position=로그인 페이지" class="tab<?=$bn_position=='로그인 페이지'?' active':''?>">로그인 페이지</a>
	</div>
	<div class="tabs-group">
		<a href="./bannerlist.php?page=<?=$page?>&bn_position=마이페이지" class="tab<?=$bn_position=='마이페이지'?' active':''?>">마이페이지</a>
	</div>
	<div id="listCount">등록된 배너 <b class="ml5"><?=$total_count?></b>개</span></div>
</div>

<div class="local_ov01 local_ov">

    <form name="flist" class="local_sch01 local_sch">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
	<input type="hidden" name="bn_position" value="<?=$bn_position?>">

    <label for="bn_position" class="sound_only">검색</label>

    <select name="bn_device" id="bn_device">
        <option value="both"<?php echo get_selected($bn_device, 'both', true); ?>>PC와 모바일</option>
        <option value="pc"<?php echo get_selected($bn_device, 'pc'); ?>>PC</option>
        <option value="mobile"<?php echo get_selected($bn_device, 'mobile'); ?>>모바일</option>
    </select>

    <select name="bn_time" id="bn_time">
        <option value=""<?php echo get_selected($bn_time, '', true); ?>>배너 시간 전체</option>
        <option value="ing"<?php echo get_selected($bn_time, 'ing'); ?>>진행중인 배너</option>
        <option value="end"<?php echo get_selected($bn_time, 'end'); ?>>종료된 배너</option>
    </select>

    <input type="submit" value="검색" class="btn_submit">

    </form>

</div>

<div class="btn_fixed_top">
    <a href="./bannerform.php<?=$_GET['bn_position']?'?bn_position='.$_GET['bn_position']:''?>" class="btn_01 btn">배너추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="th_id">ID</th>		
		<th scope="col" id="th_img">이미지</th>
		<th scope="col">복사기록</th>
        <th scope="col" id="th_dvc">접속기기</th>
        <th scope="col" id="th_loc">위치 - 분류</th>
        <th scope="col" id="th_st">시작일시</th>
        <th scope="col" id="th_end">종료일시</th>
        <th scope="col" id="th_odr">출력순서</th>
        <th scope="col" id="th_hit">조회</th>
        <th scope="col" id="th_mng">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select * from {$g5['g5_shop_banner_table']} $sql_search
          order by bn_order, bn_id desc
          limit $from_record, $rows  ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 테두리 있는지
        $bn_border  = $row['bn_border'];
        // 새창 띄우기인지
        $bn_new_win = ($row['bn_new_win']) ? 'target="_blank"' : '';

        $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
        if(file_exists($bimg)) {
            $size = @getimagesize($bimg);
            if($size[0] && $size[0] > 800)
                $width = 800;
            else
                $width = $size[0];

            $bn_img = $bn_img_ori_url = "";
           
            
			//$bn_img .= '<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']).'" width="'.$width.'" alt="'.get_text($row['bn_alt']).'">';
			$banner_thumb = thumbnail($row['bn_id'], G5_DATA_PATH.'/banner/', G5_DATA_PATH.'/banner/', 160, '', 1, 1, 'center');
			$bn_img .= '<img src="'.G5_DATA_URL.'/banner/'.$banner_thumb.'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']).'"'.($row['bn_alt']?' title="'.$row['bn_alt'].'"':'').' class="thumb">';
			$bn_img_ori_url .= G5_DATA_URL.'/banner/'.$row['bn_id'].'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']);
        }

        switch($row['bn_device']) {
            case 'pc':
                $bn_device = 'PC';
                break;
            case 'mobile':
                $bn_device = '모바일';
                break;
            default:
                $bn_device = 'PC와 모바일';
                break;
        }

        $bn_begin_time = substr($row['bn_begin_time'], 2, 14);
        $bn_end_time   = substr($row['bn_end_time'], 2, 14);

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="th_id" class="td_num"><?php echo $row['bn_id']; ?></td>		
		<td headers="th_img" class="td_img_view sbn_img"><a href="<?=$bn_img_ori_url?>" target="_blank"><?php echo $bn_img; ?></a></td>
		<td class="td_num" style="width:120px"><span class="color-gray fs11"><?php echo $row['bn_log']; ?></span></td>
        <td headers="th_dvc"><?php echo $bn_device; ?></td>
        <td headers="th_loc"><?=$row['bn_position']?$row['bn_position']:'블럭용'?><?=$row['bn_cate']?' - '.$row['bn_cate']:''?></td>
        <td headers="th_st" class="td_datetime"><?php echo $bn_begin_time; ?></td>
        <td headers="th_end" class="td_datetime"><?php echo $bn_end_time; ?></td>
        <td headers="th_odr" class="td_num"><?php echo $row['bn_order']; ?></td>
        <td headers="th_hit" class="td_num"><?php echo $row['bn_hit']; ?></td>
        <td headers="th_mng" class="td_mng td_mns_m" style="width:146px">
            <a href="./bannerform.php?w=u&amp;bn_id=<?php echo $row['bn_id']; ?>" class="btn btn_03" rel="noreferrer noopener">수정</a>
            <a href="./my/bannerformupdate.php?w=d&amp;bn_id=<?php echo $row['bn_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_01">삭제</a>
			<a href="./my/bannerformupdate.php?w=c&amp;bn_id=<?php echo $row['bn_id']; ?>" onclick="return copy_confirm(this);" class="btn btn_02">복사</a>
        </td>
    </tr>

    <?php
    }
    if ($i == 0) {
    echo '<tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>

</div>

<script>
function copy_confirm(el) {
	var token = get_ajax_token();
	var href = el.href.replace(/&token=.+$/g, "");
	if(!token) {
		alert("토큰 정보가 올바르지 않습니다.");
		return false;
	}
	el.href = href+"&token="+token;
	return true;
}
</script>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');