<?php
$sub_menu = "400900";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '쇼핑몰 추가설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$item_ratio = explode("|", $default['item_ratio']);
?>

<form name="adm_form" id="adm_form" method="post" onsubmit="return adm_form_submit(this);" autocomplete="off" action="./config_form_update.php" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
	<h2 class="mybox-title">쇼핑몰 추가설정</h2>
    <div class="formContainer label170">
		
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 타입</label></div>
			<div class="formCon column">
				<select id="shop_type" name="shop_type" class="w-150">
                    <option value="0" <?php echo get_selected($default['shop_type'], 0); ?>>배송주문제</option>
                    <option value="1" <?php echo get_selected($default['shop_type'], 1); ?>>예약제</option>
                </select>
			</div>
		</div>

		<div class="form-list">
			<div class="form-label"><label>폐쇄몰 사용</label></div>
			<div class="formCon column">
				<div style="--toggle-light-width:56px;--toggle-light-height:26px;--toggle-light-color:red;">
					<input type="checkbox" name="shop_use_closure" value="1" class="toggle-light"<?=$default['shop_use_closure']?' checked':''?>>
				</div>
				<p class="help-block mt10">
					<b>폐쇄몰 사용이고, 비회원일때</b><br>
					상품명, 상품 가격의 노출 제한.<br>
					상품상세페이지 접근제한,<br>
					비회원 주문, 주문조회 불가.
				</p>
			</div>
		</div>

		<div class="form-list">
			<div class="form-label"><label>리뷰 정책</label></div>
			<div class="formCon column">
				<textarea name="de_review_guide" id="de_review_guide"><?php echo $default['de_review_guide']; ?></textarea>
			</div>
		</div>	

    </div>
</section>

<section class="mybox">
    <div class="formContainer label170">		

		<div class="form-list">
			<div class="form-label"><label>상품사진 비율</label></div>
			<div class="formCon">				
				<input type="text" name="item_ratio[]" value="<?=$item_ratio[0]?>" class="w-70" data-label="가로" placeholder="100"> :
				<input type="text" name="item_ratio[]" value="<?=$item_ratio[1]?>" class="w-70" data-label="세로" placeholder="100">
				<p class="help-block">*비율 고정없이 업로드된 이미지 그대로 출력하고자 한다면 세로값에 0을 입력하세요.</p>
			</div>
		</div>

		<div class="form-list">
			<div class="form-label"><label>상품 별점 사용</label></div>
			<div class="formCon column">
				<div style="--toggle-light-width:56px;--toggle-light-height:26px;--toggle-light-color:var(--mainColor);">
					<input type="checkbox" name="shop_use_it_avg" value="1" class="toggle-light"<?=$default['shop_use_it_avg']?' checked':''?>>
				</div>
			</div>
		</div>

		<div class="form-list">
			<div class="form-label"><label>상품 할인률 소수점</label></div>
			<div class="formCon column">
				<div><input type="checkbox" name="use_item_discount_rate_decimal" value="1" class=""<?=$default['use_item_discount_rate_decimal']?' checked':''?> data-label="(할인률) 소수점 표기 사용"></div>
			</div>
		</div>

		<div class="form-list">
			<div class="form-label"><label>상품 가격 ~</label></div>
			<div class="formCon column">
				<div><input type="checkbox" name="use_item_price_deco" value="1" class=""<?=$default['use_item_price_deco']?' checked':''?> data-label="가격표 뒤에 (~) 붙이기"></div>
			</div>
		</div>		

    </div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f) {
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>