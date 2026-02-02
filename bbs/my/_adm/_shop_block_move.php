<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
//include_once(G5_LIB_PATH.'/my/get_my.lib.php'); //인태
//include_once(G5_LIB_PATH.'/my/_my.lib.php'); //인태


$wr_id_list = '';
if ($wr_id)
    $wr_id_list = $wr_id;
else {
    $comma = '';

    $count_chk_wr_id = (isset($_POST['chk_wr_id']) && is_array($_POST['chk_wr_id'])) ? count($_POST['chk_wr_id']) : 0;

    for ($i=0; $i<$count_chk_wr_id; $i++) {
        $wr_id_val = isset($_POST['chk_wr_id'][$i]) ? preg_replace('/[^0-9]/', '', $_POST['chk_wr_id'][$i]) : 0;
        $wr_id_list .= $comma . $wr_id_val;
        $comma = ',';
    }
}

//$sql = " select * from {$g5['board_table']} a, {$g5['group_table']} b where a.gr_id = b.gr_id and bo_table <> '$bo_table' ";
// 원본 게시판을 선택 할 수 있도록 함.
$sql = " select * from {$g5['board_table']} a, {$g5['group_table']} b where a.gr_id = b.gr_id ";
if ($is_admin == 'group')
    $sql .= " and b.gr_admin = '{$member['mb_id']}' ";
else if ($is_admin == 'board')
    $sql .= " and a.bo_admin = '{$member['mb_id']}' ";
$sql .= " order by a.gr_id, a.bo_order, a.bo_table ";
$result = sql_query($sql);

$list = array();

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $list[$i] = $row;
}

$skin_pagemake = strpos($boSkin, 'pageMake') !== false ? true : false;
$skin_gallery = $boSkin == 'GALLERY' || strpos($boSkin, 'gallery') !== false ? true : false;
?>

<div id="copymove" class="new_win">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>
    <form name="fboardmoveall" method="post" action="./move_update.php" onsubmit="return fboardmoveall_submit(this);">
    <input type="hidden" name="sw" value="<?php echo $sw ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id_list" value="<?php echo $wr_id_list ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="act" value="<?php echo $act ?>">
    <input type="hidden" name="url" value="<?php echo get_text(clean_xss_tags($_SERVER['HTTP_REFERER'])); ?>">
	<input type="hidden" name="board_skin_path" value="<?=$board_skin_path?>">

    <article class="tableContainer">
		<div class="table">
			<div class="caption"><?php echo $act ?>할 게시판을 한개 이상 선택하여 주십시오.</div>
			<div class="thead">
				<div class="tr">
					<div class="cell_chk">
						<label for="chkall" class="sound_only">현재 페이지 게시판 전체</label>
						<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
					</div>
					<div>게시판</div>
				</div>
			</div>
			<ul class="tbody">
				 <?php for ($i=0; $i<count($list); $i++) {
					$atc_mark = '';
					$atc_bg = '';
					if ($list[$i]['bo_table'] == $bo_table) { // 게시물이 현재 속해 있는 게시판이라면
						$atc_mark = '<span class="copymove_current">현재<span class="sound_only">게시판</span></span>';
						$atc_bg = 'copymove_currentbg';
					}
					
					$list_bo_skin[$i] = $list[$i]['bo_skin'];
					if(preg_match('#^theme/(.+)$#', $list[$i]['bo_skin'], $match) || preg_match('#^seperate/(.+)$#', $list[$i]['bo_skin'], $match)) $list_bo_skin[$i] = $match[1];
					if($boSkin == 'basic' || $boSkin == 'FAQ' || $skin_gallery) {
						if( $list_bo_skin[$i] == 'basic' || $list_bo_skin[$i] == 'FAQ' || strpos($list_bo_skin[$i], 'gallery') !== false ) $is_move_table[$i] = true;
					} else if($skin_pagemake) {
						if(strpos($list_bo_skin[$i], 'pageMake') !== false) $is_move_table[$i] = true;
					} else {
						if($list_bo_skin[$i] == $boSkin) $is_move_table[$i] = true;
					}			

					if($is_move_table[$i]) {
						echo '<li class="tr">';
							echo '<div class="cell_chk">';
								echo '<label for="chk<?php echo $i ?>" class="sound_only">'.$list[$i]['bo_table'].'</label>';
								echo '<input type="checkbox" value="'.$list[$i]['bo_table'].'" id="chk'.$i.'" name="chk_bo_table[]">';
							echo '</div>';
							echo '<div>';
								echo '<label for="chk'.$i.'">';
									echo '<span class="fs12" style="padding:0 5px;border-radius:2px;background:rgba(71,78,103,0.35);color:#fff;margin-right:10px;display:inline-flex;align-items:center;">'.$list[$i]['gr_subject'].'</span>';
									$save_gr_subject = $list[$i]['gr_subject'].'</span>';
									echo '<span class="fw500">'.$list[$i]['bo_subject'].'<span>&nbsp;<span class="mont fs11">('.$list[$i]['bo_table'].')</span>';
									echo $atc_mark;
								echo '</label>';
							echo '</div>';
						echo '</li>';
					}
				} ?>
			</ul>
        </div>
	</article>

    <div class="win_btn">
        <input type="submit" value="<?php echo $act ?>" id="btn_submit" class="btn_submit">
    </div>
    </form>

</div>

<script>
$(function() {
    $(".win_btn").append("<button type=\"button\" class=\"btn_cancel btn_close\">창닫기</button>");

    $(".win_btn button").click(function() {
        window.close();
    });
});

function all_checked(sw) {
    var f = document.fboardmoveall;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bo_table[]")
            f.elements[i].checked = sw;
    }
}

function fboardmoveall_submit(f)
{
    var check = false;

    if (typeof(f.elements['chk_bo_table[]']) == 'undefined')
        ;
    else {
        if (typeof(f.elements['chk_bo_table[]'].length) == 'undefined') {
            if (f.elements['chk_bo_table[]'].checked)
                check = true;
        } else {
            for (i=0; i<f.elements['chk_bo_table[]'].length; i++) {
                if (f.elements['chk_bo_table[]'][i].checked) {
                    check = true;
                    break;
                }
            }
        }
    }

    if (!check) {
        alert('게시물을 '+f.act.value+'할 게시판을 한개 이상 선택해 주십시오.');
        return false;
    }

    document.getElementById('btn_submit').disabled = true;

    f.action = './move_update.php';
    return true;
}
</script>

<?php
run_event('move_html_footer');
include_once(G5_PATH.'/tail.sub.php');