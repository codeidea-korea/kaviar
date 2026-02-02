<?php 
include_once('./_common.php'); 

// 게시판 관리자 이상 복사, 이동 가능 
if ($is_admin != 'board' && $is_admin != 'group' && $is_admin != 'super') 
    alert_close('게시판 관리자 이상 접근이 가능합니다.'); 

if ($sw != 'cate') 
    alert('sw 값이 제대로 넘어오지 않았습니다.'); 

if(!count($_POST['chk_bo_table'])) 
    alert('게시물 '.$act.'할 게시판을 한개 이상 선택해 주십시오.', $url); 

//새로기록된 분류명 
$newcate = $_POST['chk_bo_table'][0]; 

$sql = "update $write_table set ca_name='{$newcate}' where wr_id in ({$wr_id_list}) "; 
$result = sql_query($sql); 

echo "<script>
opener.document.location.reload();
window.close();
</script>";
