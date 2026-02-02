<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 쿠폰
$cp_count = 0;
$sql_head = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res_head = sql_query($sql_head);

for($k=0; $cp=sql_fetch_array($res_head); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}

$href_point = G5_BBS_URL.'/point.php';
$href_coupon = G5_SHOP_URL.'/coupon.php';
$href_wishlist = G5_SHOP_URL.'/wishlist.php';
$href_myitemuselist = G5_SHOP_URL.'/myitemuselist.php';

$href_orderinquiry = G5_SHOP_URL.'/orderinquiry.php';
$href_customer = G5_SHOP_URL.'/customer.php';
$href_couponzone = G5_SHOP_URL.'/couponzone.php';

$grade = sql_fetch(" select g_name from `g5_member_grade` where idx = '".$member['mb_grade']."' ");

$review_url = G5_SHOP_URL."/item.php?it_id=";
?>

<div id="my_head">
	<div class="inner max-width">
		<div class="box_user_info">
			<div class="top">
				<p class="name">
					<span class="fs20 fw700"><?php echo $member['mb_id'] ? $member['mb_name'] : '비회원'; ?>님</span><br>
					현재 <span class="bold"><?php echo $grade['g_name']?></span> 등급입니다
				</p>
		<?php	/*if (!G5_IS_MOBILE) {
				<a href="#" class="btn01 popupVideo">멤버십 혜택 보기</a>
		}*/?>
		<?php	if (G5_IS_MOBILE) {?>
				<a href="<?php echo G5_URL?>/bbs/logout.php" class="btn01" >로그아웃</a>
		<?}?>
			</div>
			<div class="bottom">
				<a href="./myitemuseinsertlist.php" class="btn02 review_move">상품 후기 쓰고 적립금 받기</a>
			</div>
		</div>

<script type="text/javascript">
    $('.popupVideo').click(function(e) {
     var divTop = e.clientY - 120; //상단 좌표
     var divLeft = e.clientX - 0; //좌측 좌표
     $('#divLangSelect').css({
       "top": divTop
       ,"left": divLeft
       , "position": "absolute"
     }).show();
    });
	
// 외부영역 클릭 시 팝업 닫기
$(document).mouseup(function (e){
  var LayerPopup = $("#divLangSelect");
 
  if(LayerPopup.has(e.target).length === 0){
    document.getElementById('divLangSelect').style.display='none'
  }
});


$('.review_move').click(function(e) {

	$.ajax({
		url:'ajax.review.php',
		type:'POST',
		cache: false,
		async: false,
		dataType : 'json',
		success: function(res) {
			//$('#Context').html(data);
			
			if(res.count > 0){	
				location.href= "<?=$review_url?>" + res.review_id + "#sit_use";
			}else{
				alert(res.msg);
			}
			
			
			//console.log(res.count);
			//console.log(res.is_id);
		}
	});
});

</script>

<style type="text/css">
    #divLangSelect {
        z-index:99999;
        position:absolute;
        display:none;
        background-color:#ffffff;
        border:solid 2px #333333;
        width:90%;
        max-width:550px; 
        left:50% !important; 
        transform:translateX(-50%);
        padding:50px 15px 20px 15px;
    }
	#divLangSelect td{
		text-align:center;
		height:30px;
		padding:8px;
		border:1px solid #00000026;
    }
	#divLangSelect th{
		background:#E5E0DB;
		height:40px;
		padding:5px;
		border:1px solid #00000026;
    }
    #divLangSelect table {width:100%; max-width:500px; }
</style>

<?php
$result_gg = sql_query(" select * from `g5_member_grade` where idx != 1 ");
?>
<div id="divLangSelect">
	<div style="position:absolute;top:13px;right:18px">
		<span onClick="javascript:document.getElementById('divLangSelect').style.display='none'" style="cursor:pointer;font-size:1.5em" title="닫기"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></span>
	</div>
	<table width="" align="center" border="0">
		<tr>
			<th>등급명</th>
			<th>할인율</th>
			<th>적립율</th>
			<th style="width:350px">등급상승조건</th>
		</tr>
<?	for ($i=0; $row=sql_fetch_array($result_gg); $i++) {	?>
		<tr>
			<td width="150"><?php echo $row['g_name']?></td>
			<td width="150"><?php echo $row['g_discount']?> %</td>
			<td width="150"><?php echo $row['g_reward']?> %</td>
			<td><?php if($row['g_reward_start']) echo number_format($row['g_reward_start'])."원 ~ ".number_format($row['g_reward_end']."원")?></td>
		</tr>
<?}?>
    </table>
</div>


	
		<div class="my_cou_wr">
		
			<ul class="box_user_dashboard">
			
				<li>
					<a href="<?=$href_myitemuselist?>" class="my_reply">상품후기<span class="val"><?=$my_itemuse_count?>개</span></a></li>
				</li>
			
				<li>
					<a href="<?=$href_wishlist?>" class="my_wishlist">찜한상품<span class="val"><?=number_format($my_wish_count)?>개</span></a>
				</li>
			
				<li>
					<?php if(!G5_IS_MOBILE) { ?>
					<a href="<?=$href_point?>" target="_blank" class="win_pop my_point">포인트<span class="val"><?=number_format($member['mb_point'])?>P</span></a>
					<?php } else { ?>
					<a href="<?=$href_point?>" class="my_point">포인트<span class="val"><?=number_format($member['mb_point'])?>P</span></a>
					<?php } ?>
					
				</li>
				<li>
				<?php if(!G5_IS_MOBILE) { ?>
					<a href="<?=$href_coupon?>" target="_blank"  class="win_pop my_coupon">쿠폰<span class="val"><?=get_my_coupon_count()?>개</span></a>
					<?php } else { ?>
					<a href="<?=$href_coupon?>" class="my_coupon">쿠폰<span class="val"><?=get_my_coupon_count()?>개</span></a>
					<?php } ?>
					
				</li>
			
			</ul>
		
			<div id="mypage_banner" class="bottom relative">
				<?php echo shop_banner('마이페이지', '_block_banner.skin.php'); ?>
				<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=마이페이지&title=쇼핑몰 배너관리" class="btnSetting light popWin" style="top:5px;right:-25px;" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#mypage_banner">쇼핑몰 배너관리</a>';?>
			</div>
		</div>
	
	</div>
</div>

<script>
$(function() {
    $(".win_pop").click(function() {
        var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=520, height=600, scrollbars=1");
        new_win.focus();
        return false;
    });
});
</script>