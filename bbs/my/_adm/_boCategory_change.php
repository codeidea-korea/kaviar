<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$wr_id_list = ''; 
if ($wr_id) 
    $wr_id_list = $wr_id; 
else { 
    $comma = ''; 
    for ($i=0; $i<count($_POST['chk_wr_id']); $i++) { 
        $wr_id_list .= $comma . $_POST['chk_wr_id'][$i]; 
        $comma = ','; 
    } 
} 

$catelist = $board['bo_category_list']; 
$list = explode('|',$catelist); 
?> 

<style>
li{width:100%;border-bottom:1px solid rgba(0,0,0,0.1);padding:10px 3px;}
li .radio-wrap{display:flex;width:100%;}
li:last-child{border-bottom:0}
</style>

<form name="fboardmoveall" method="post" action="<?=$_adm_update_url?>/_boCategory_change_update.php" onsubmit="return fboardmoveall_submit(this);"> 
<input type="hidden" name="sw" value="<?php echo $sw ?>"> 
<input type="hidden" name="bo_table" value="<?=$bo_table?>"> 
<input type="hidden" name="wr_id_list" value="<?=$wr_id_list?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<ul class="flex flex-column gap0">		
		 <li><input type="radio" value="" name="chk_bo_table[]" data-label="분류없음"></li>
		 <?php for ($i=0; $i<count($list); $i++) { 
			$atc_mark = ''; 
			$atc_bg = '';
			echo '<li><input type="radio" value="'.$list[$i].'" name="chk_bo_table[]" data-label="'.$list[$i].'"></li>';
		 } ?>
	</ul>
</section>


<div class="_adm_btnSet"> 
	<input type="submit" value="적용하기" id="btn_submit" class="btn_submit btn"> 
</div> 
</form> 


<script>
function fboardmoveall_submit(f) { 
    var check = false;
    if (typeof(f.elements['chk_bo_table[]']) == 'undefined') 
        ;
	} else { 
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
        alert('게시물의 분류를 선택하세요.');
        return false; 
    } 

    document.getElementById('btn_submit').disabled = true; 
    return true; 
} 
</script> 

<?php 
include_once(G5_PATH.'/tail.sub.php'); 
?> 
