<?php
include_once("./_common.php");

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

@mkdir(G5_DATA_PATH."/shop_block", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/shop_block", G5_DIR_PERMISSION);


$bl_id = isset($_REQUEST['bl_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['bl_id']) : 0;
$bl_order = isset($_POST['bl_order']) ? (int) $_POST['bl_order'] : 0;
$bl_use = isset($_POST['bl_use']) ? clean_xss_tags($_POST['bl_use'], 1, 1) : '';
$bl_cate = isset($_POST['bl_cate']) ? $_POST['bl_cate'] : '';
$bl_name = isset($_POST['bl_name']) ? strip_tags(clean_xss_attributes($_POST['bl_name'])) : '';
$bl_type = isset($_POST['bl_type']) ? $_POST['bl_type'] : '';
$bl_title = isset($_POST['bl_title']) ? strip_tags(clean_xss_attributes($bl_title)) : '';
$bl_title_mobile = isset($_POST['bl_title_mobile']) ? strip_tags(clean_xss_attributes($bl_title_mobile)) : '';
$bl_title_color = isset($_POST['bl_title_color']) ? $_POST['bl_title_color'] : '';
$bl_link = $_POST['bl_link'][1] ? implode("|", $_POST['bl_link']) : '';
$bl_link_color = isset($_POST['bl_link_color']) ? $_POST['bl_link_color'] : '';
$bl_content = isset($_POST['bl_content']) ? $_POST['bl_content'] : '';
$bl_width = isset($_POST['bl_width']) ? (int) $_POST['bl_width'] : 0;
$bl_padding = implode("|", $_POST['bl_padding']);
$bl_padding_mobile = implode("|", $_POST['bl_padding_mobile']);
$bl_background = implode("|", $_POST['bl_background']);
$items_skin = implode("|", $_POST['items_skin']);
$items_order_option = implode("|", $_POST['items_order_option']);
$items_count = isset($_POST['items_count']) ? (int) $_POST['items_count'] : 0;
$items_count_mobile = isset($_POST['items_count_mobile']) ? (int) $_POST['items_count_mobile'] : 0;
$items_sel_li_id = isset($_POST['items_sel_li_id']) && strpos($items_order_option, 'list_of_select') !== false ? $_POST['items_sel_li_id'] : ''; //불러오기 옵션이 직접선택이 아니면 '직접선택값' 초기화.
$items_cols = isset($_POST['items_cols']) ? (float) $_POST['items_cols'] : 0;
$items_cols_mobile = isset($_POST['items_cols_mobile']) ? (float) $_POST['items_cols_mobile'] : 0;
$items_gap = isset($_POST['items_gap']) ? (int) $_POST['items_gap'] : '';
$items_gap_mobile = isset($_POST['items_gap_mobile']) ? (int) $_POST['items_gap_mobile'] : '';
$items_radius = isset($_POST['items_radius']) ? (int) $_POST['items_radius'] : '';
$items_radius_mobile = isset($_POST['items_radius_mobile']) ? (int) $_POST['items_radius_mobile'] : '';
//$tabs_items_cate = isset($_POST['tabs_items_cate']) ? $_POST['tabs_items_cate'] : '';
$tabs_items_cate = implode(",", $_POST['tabs_items_cate']);
if(!$bl_type || $bl_type == 'mix') $items_skin = $items_order_option = $items_count = $items_count_mobile = $items_sel_li_id = $items_cols = $items_cols_mobile = $items_gap = $items_gap_mobile = $items_radius = $items_radius_mobile = '';
if($bl_type == 'shopCate') $items_skin = $items_count = $items_count_mobile = $items_sel_li_id = '';
$bl_video = isset($_POST['bl_video']) ? $_POST['bl_video'] : '';
$bl_video_src = isset($_POST['bl_video_src']) ? $_POST['bl_video_src'] : '';
for ($i=1; $i<=10; $i++) {
	$var = "bl_link$i";
	$$var = $bl_type == 'link' && ($_POST['bl_link'.$i][0] || $_POST['bl_link'.$i][1] || $_POST['bl_link'.$i][2]) ?  implode("|", $_POST['bl_link'.$i]) : '';
}
$mix_type = isset($_POST['mix_type']) ? $_POST['mix_type'] : '';

for ($i=1; $i<=4; $i++) {
	$var = "bl_btn$i";
	$$var = $_POST['bl_btn'.$i] ? implode("|", $_POST['bl_btn'.$i]) : '';
	$var2 = "bl_btn".$i."_color";
	$$var2 = $_POST['bl_btn'.$i.'_color'] ? implode("|", $_POST['bl_btn'.$i.'_color']) : '';
}
$bl_btn_radius = $_POST['bl_btn_radius'];


$sql_common = " bl_order						= '$bl_order',
						  bl_use							= '$bl_use',
						  bl_cate						= '$bl_cate',
						  bl_name						= '$bl_name',
						  bl_type						= '$bl_type',
						  bl_title							= '$bl_title',
						  bl_title_align				= '{$_POST['bl_title_align']}',
						  bl_title_mobile				= '$bl_title_mobile',
						  bl_title_mobile_align		= '{$_POST['bl_title_mobile_align']}',
						  bl_title_color				= '$bl_title_color',
						  bl_link							= '$bl_link',
						  bl_link_color				= '$bl_link_color',
						  bl_content					= '$bl_content',
						  bl_width						= '$bl_width',
						  bl_padding					= '$bl_padding',
						  bl_padding_mobile		= '$bl_padding_mobile',
						  bl_background				= '$bl_background',
						  items_skin					= '$items_skin',
						  tabs_items_cate			= '$tabs_items_cate',
						  items_order_option		= '$items_order_option',
						  items_count					= '$items_count',
						  items_count_mobile		= '$items_count_mobile',
						  items_sel_li_id				= '$items_sel_li_id',
						  items_cols					= '$items_cols',
						  items_cols_mobile		= '$items_cols_mobile',
						  items_gap					= '$items_gap',
						  items_gap_mobile		= '$items_gap_mobile',
						  items_radius				= '$items_radius',
						  items_radius_mobile		= '$items_radius_mobile',						  
						  bl_video						= '$bl_video',
						  bl_video_src				= '$bl_video_src',
						  bl_link1						= '$bl_link1',
						  bl_link2						= '$bl_link2',
						  bl_link3						= '$bl_link3',
						  bl_link4						= '$bl_link4',
						  bl_link5						= '$bl_link5',
						  bl_link6						= '$bl_link6',
						  bl_link7						= '$bl_link7',
						  bl_link8						= '$bl_link8',
						  bl_link9						= '$bl_link9',
						  bl_link10						= '$bl_link10',
						  mix_type						= '$mix_type',
						  bl_btn1						= '$bl_btn1',
						  bl_btn1_color				= '$bl_btn1_color',
						  bl_btn2						= '$bl_btn2',
						  bl_btn2_color				= '$bl_btn2_color',
						  bl_btn3						= '$bl_btn3',
						  bl_btn3_color				= '$bl_btn3_color',
						  bl_btn4						= '$bl_btn4',
						  bl_btn4_color				= '$bl_btn4_color',
						  bl_btn_radius				= '$bl_btn_radius'
						  ";

if($bl_type != 'mix') {
	$sql_common .= ", mix_li_1				= '',
							   mix_li_2				= '',
							   mix_li_3				= '',
							   mix_li_4				= '',
							   mix_li_5				= '',
							   mix_li_6				= '',
							   mix_li_7				= '',
							   mix_li_8				= '',
							   mix_li_9				= '',
							   mix_li_10			= '',
							   mix_li_11			= '',
							   mix_li_12			= '',
							   mix_li_13			= '',
							   mix_li_14			= '',
							   mix_li_15			= '',
							   mix_li_16			= '',
							   mix_li_17			= '',
							   mix_li_18			= '',
							   mix_li_19			= '',
							   mix_li_20			= ''
							   ";
}

if($w == "") {

    $sql = " insert into {$g5['g5_shop_block_table']} set
                    $sql_common ";
    sql_query($sql);

	$bl_id = sql_insert_id();

} else if ($w == "u") {
    $sql = " update {$g5['g5_shop_block_table']}
                set $sql_common
              where bl_id = '$bl_id' ";
    sql_query($sql);

} else if ($w == "d") {
    @unlink(G5_DATA_PATH."/shop_block/{$bl_id}_1");
    @unlink(G5_DATA_PATH."/shop_block/{$bl_id}_2");

    $sql = " delete from {$g5['g5_shop_block_table']} where bl_id = '$bl_id' ";
    sql_query($sql);
}



//동영상 소스 저장 ──────────────────────────────────────────────────────────────────
if(strpos($bl_video_src, 'youtu') !== false) {
	preg_match('@https?://(?:www\.)?youtube\.com/(?:watch\?|\?)?v[/=]([a-zA-Z0-9-_]+)@', $bl_video_src, $matches);
	$bl_video = $matches[1];
    if(!$bl_video) {
        preg_match('@https?://(?:www\.)?youtu\.be/([a-zA-Z0-9-_]+)@', $bl_video_src, $matches);
        $bl_video = $matches[1];
    }
	if($bl_video) sql_query(" update {$g5['g5_shop_block_table']} set bl_video = '$bl_video' where bl_id = '$bl_id' ");
} else if(strpos($bl_video_src, 'vimeo') !== false) {
	preg_match('@https?://(?:www\.)?vimeo\.com/(?:watch\?|\?)?v[/=]([a-zA-Z0-9-_]+)@', $bl_video_src, $matches);
	$bl_video = $matches[1];
    if(!$bl_video) {
        preg_match('@https?://(?:www\.)?vimeo\.com/([a-zA-Z0-9-_]+)@', $bl_video_src, $matches);
        $bl_video = $matches[1];
    }
	if($bl_video) sql_query(" update {$g5['g5_shop_block_table']} set bl_video = '$bl_video' where bl_id = '$bl_id' ");
} else if($bl_video_src) {
	sql_query(" update {$g5['g5_shop_block_table']} set bl_video = '$bl_video_src' where bl_id = '$bl_id' ");
}
// ────────────────────────────────────────────────────────────────────────────────







if($del_bl_img1)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_1");
if($del_bl_img2)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_2");

if($del_bl_icon1)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon1");
if($del_bl_icon2)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon2");
if($del_bl_icon3)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon3");
if($del_bl_icon4)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon4");
if($del_bl_icon5)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon5");
if($del_bl_icon6)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon6");
if($del_bl_icon7)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon7");
if($del_bl_icon8)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon8");
if($del_bl_icon9)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon9");
if($del_bl_icon10)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_icon10");

if($w == "" || $w == "u") {
    if($_FILES['bl_img1']['name']) {
        $dest_path = G5_DATA_PATH."/shop_block/bl".$bl_id."_1";
        @move_uploaded_file($_FILES['bl_img1']['tmp_name'], $dest_path);
        @chmod($dest_path, G5_FILE_PERMISSION);
    }
    if($_FILES['bl_img2']['name']) {
        $dest_path = G5_DATA_PATH."/shop_block/bl".$bl_id."_2";
        @move_uploaded_file($_FILES['bl_img2']['tmp_name'], $dest_path);
        @chmod($dest_path, G5_FILE_PERMISSION);
    }
	
	for($i=1; $i<=10; $i++) {
		if($_FILES['bl_icon'.$i]['name']) {
			$dest_icon_path[$i] = G5_DATA_PATH."/shop_block/bl".$bl_id."_icon".$i;
			@move_uploaded_file($_FILES['bl_icon'.$i]['tmp_name'], $dest_icon_path[$i]);
			@chmod($dest_icon_path[$i], G5_FILE_PERMISSION);
		}
    }

} else {
    $callback_url = G5_BBS_URL.'/my/_adm/?pn=_shop_block&bl_cate='.$_GET['bl_cate'].'&title='.$_GET['title'].($_GET['bl_use']?'&bl_use='.$_GET['bl_use']:'');
}


if($_POST['callback']) $callback_url = $_SERVER['HTTP_REFERER'];

if($_POST['close']) {
	echo "<script>
	opener.document.location.reload();
	window.close();
	</script>";
} else {
	echo "<script>
	opener.document.location.reload();
	location.href='".$callback_url."';
	</script>";
}