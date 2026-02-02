<?php
include_once('./_common.php');

$it_id = isset($_POST['it_id']) ? $_POST['it_id'] : '';

@mkdir(G5_DATA_PATH."/item", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/item", G5_DIR_PERMISSION);

$it_img1 = $it_img2 = $it_img3 = $it_img4 = $it_img5 = $it_img6 = $it_img7 = $it_img8 = $it_img9 = $it_img10 = '';
$sql = " select it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
                from {$g5['g5_shop_item_table']}
                where it_id = '$it_id' ";
$file = sql_fetch($sql);

$it_img1    = $file['it_img1'];
$it_img2    = $file['it_img2'];
$it_img3    = $file['it_img3'];
$it_img4    = $file['it_img4'];
$it_img5    = $file['it_img5'];
$it_img6    = $file['it_img6'];
$it_img7    = $file['it_img7'];
$it_img8    = $file['it_img8'];
$it_img9    = $file['it_img9'];
$it_img10   = $file['it_img10'];

$it_img_dir = G5_DATA_PATH.'/item';


for($i=0;$i<=10;$i++){
    ${'it_img'.$i.'_del'} = ! empty($_POST['it_img'.$i.'_del']) ? 1 : 0;
}

// 파일삭제 ────────────────────────────────────────────────────────
if ($it_img1_del) {
    $file_img1 = $it_img_dir.'/'.clean_relative_paths($it_img1);
    @unlink($file_img1);
    delete_item_thumbnail(dirname($file_img1), basename($file_img1));
    $it_img1 = '';
}
if ($it_img2_del) {
    $file_img2 = $it_img_dir.'/'.clean_relative_paths($it_img2);
    @unlink($file_img2);
    delete_item_thumbnail(dirname($file_img2), basename($file_img2));
    $it_img2 = '';
}
if ($it_img3_del) {
    $file_img3 = $it_img_dir.'/'.clean_relative_paths($it_img3);
    @unlink($file_img3);
    delete_item_thumbnail(dirname($file_img3), basename($file_img3));
    $it_img3 = '';
}
if ($it_img4_del) {
    $file_img4 = $it_img_dir.'/'.clean_relative_paths($it_img4);
    @unlink($file_img4);
    delete_item_thumbnail(dirname($file_img4), basename($file_img4));
    $it_img4 = '';
}
if ($it_img5_del) {
    $file_img5 = $it_img_dir.'/'.clean_relative_paths($it_img5);
    @unlink($file_img5);
    delete_item_thumbnail(dirname($file_img5), basename($file_img5));
    $it_img5 = '';
}
if ($it_img6_del) {
    $file_img6 = $it_img_dir.'/'.clean_relative_paths($it_img6);
    @unlink($file_img6);
    delete_item_thumbnail(dirname($file_img6), basename($file_img6));
    $it_img6 = '';
}
if ($it_img7_del) {
    $file_img7 = $it_img_dir.'/'.clean_relative_paths($it_img7);
    @unlink($file_img7);
    delete_item_thumbnail(dirname($file_img7), basename($file_img7));
    $it_img7 = '';
}
if ($it_img8_del) {
    $file_img8 = $it_img_dir.'/'.clean_relative_paths($it_img8);
    @unlink($file_img8);
    delete_item_thumbnail(dirname($file_img8), basename($file_img8));
    $it_img8 = '';
}
if ($it_img9_del) {
    $file_img9 = $it_img_dir.'/'.clean_relative_paths($it_img9);
    @unlink($file_img9);
    delete_item_thumbnail(dirname($file_img9), basename($file_img9));
    $it_img9 = '';
}
if ($it_img10_del) {
    $file_img10 = $it_img_dir.'/'.clean_relative_paths($it_img10);
    @unlink($file_img10);
    delete_item_thumbnail(dirname($file_img10), basename($file_img10));
    $it_img10 = '';
}


// 이미지업로드 ────────────────────────────────────────────────────────
if ($_FILES['it_img1']['name']) {
    if($it_img1) {
        $file_img1 = $it_img_dir.'/'.clean_relative_paths($it_img1);
        @unlink($file_img1);
        delete_item_thumbnail(dirname($file_img1), basename($file_img1));
    }
    $it_img1 = it_img_upload($_FILES['it_img1']['tmp_name'], $_FILES['it_img1']['name'], $it_img_dir.'/'.$it_id);	
}
if ($_FILES['it_img2']['name']) {
    if($it_img2) {
        $file_img2 = $it_img_dir.'/'.clean_relative_paths($it_img2);
        @unlink($file_img2);
        delete_item_thumbnail(dirname($file_img2), basename($file_img2));
    }
    $it_img2 = it_img_upload($_FILES['it_img2']['tmp_name'], $_FILES['it_img2']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img3']['name']) {
    if($it_img3) {
        $file_img3 = $it_img_dir.'/'.clean_relative_paths($it_img3);
        @unlink($file_img3);
        delete_item_thumbnail(dirname($file_img3), basename($file_img3));
    }
    $it_img3 = it_img_upload($_FILES['it_img3']['tmp_name'], $_FILES['it_img3']['name'], $it_img_dir.'/'.$it_id);
	
}
if ($_FILES['it_img4']['name']) {
    if($it_img4) {
        $file_img4 = $it_img_dir.'/'.clean_relative_paths($it_img4);
        @unlink($file_img4);
        delete_item_thumbnail(dirname($file_img4), basename($file_img4));
    }
    $it_img4 = it_img_upload($_FILES['it_img4']['tmp_name'], $_FILES['it_img4']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img5']['name']) {
    if($it_img5) {
        $file_img5 = $it_img_dir.'/'.clean_relative_paths($it_img5);
        @unlink($file_img5);
        delete_item_thumbnail(dirname($file_img5), basename($file_img5));
    }
    $it_img5 = it_img_upload($_FILES['it_img5']['tmp_name'], $_FILES['it_img5']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img6']['name']) {
    if($it_img6) {
        $file_img6 = $it_img_dir.'/'.clean_relative_paths($it_img6);
        @unlink($file_img6);
        delete_item_thumbnail(dirname($file_img6), basename($file_img6));
    }
    $it_img6 = it_img_upload($_FILES['it_img6']['tmp_name'], $_FILES['it_img6']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img7']['name']) {
    if($it_img7) {
        $file_img7 = $it_img_dir.'/'.clean_relative_paths($it_img7);
        @unlink($file_img7);
        delete_item_thumbnail(dirname($file_img7), basename($file_img7));
    }
    $it_img7 = it_img_upload($_FILES['it_img7']['tmp_name'], $_FILES['it_img7']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img8']['name']) {
    if($it_img8) {
        $file_img8 = $it_img_dir.'/'.clean_relative_paths($it_img8);
        @unlink($file_img8);
        delete_item_thumbnail(dirname($file_img8), basename($file_img8));
    }
    $it_img8 = it_img_upload($_FILES['it_img8']['tmp_name'], $_FILES['it_img8']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img9']['name']) {
    if($it_img9) {
        $file_img9 = $it_img_dir.'/'.clean_relative_paths($it_img9);
        @unlink($file_img9);
        delete_item_thumbnail(dirname($file_img9), basename($file_img9));
    }
    $it_img9 = it_img_upload($_FILES['it_img9']['tmp_name'], $_FILES['it_img9']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img10']['name']) {
    if($it_img10) {
        $file_img10 = $it_img_dir.'/'.clean_relative_paths($it_img10);
        @unlink($file_img10);
        delete_item_thumbnail(dirname($file_img10), basename($file_img10));
    }
    $it_img10 = it_img_upload($_FILES['it_img10']['tmp_name'], $_FILES['it_img10']['name'], $it_img_dir.'/'.$it_id);
}

$sql_common = " it_img1             = '$it_img1',
                it_img2             = '$it_img2',
                it_img3             = '$it_img3',
                it_img4             = '$it_img4',
                it_img5             = '$it_img5',
                it_img6             = '$it_img6',
                it_img7             = '$it_img7',
                it_img8             = '$it_img8',
                it_img9             = '$it_img9',
                it_img10            = '$it_img10' ";

$sql_common .= " , it_update_time = '".G5_TIME_YMDHIS."' ";
$sql = " update {$g5['g5_shop_item_table']}
			set $sql_common
		  where it_id = '$it_id' ";
sql_query($sql);



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