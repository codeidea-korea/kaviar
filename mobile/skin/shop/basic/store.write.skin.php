<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$store_address = explode('|', $store['store_address']);

$lat = $store['store_lat'] ? $store['store_lat'] : 36.4965569936987; // 초기 및 리셋 중심좌표
$lng = $store['store_lng'] ? $store['store_lng'] : 127.242297055683; // 초기 및 리셋 중심좌표
?>



<div id="_shopStore">
<form name="_store_form" id="_store_form" action="<?=G5_SHOP_URL?>/shopStore_write_update.php" onsubmit="return _store_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="store_id" value="<?=$store_id?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="store_lat" value="<?=$store['store_lat']?>" id="store_lat">
<input type="hidden" name="store_lng" value="<?=$store['store_lng']?>" id="store_lng">

	<div class="store-form-wrap">
		
		<div class="form-list">
			<div class="form-list-label"><label><?=$default['store_label_name']?$default['store_label_name']:'지점'?>명</label></div>
			<div class="form-list-con flex flex-middle">
				<input type="text" name="store_subject" value="<?=$store['store_subject']?>" id="store_subject" class="flex1" required placeholder="<?=$default['store_label_name']?$default['store_label_name']:'지점'?>명을 입력해 주세요.">
			</div>
		</div>
		<div class="form-list">
			<div class="form-list-label"><label><?=$store_label?> 주소</label></div>
			<div class="form-list-con flex flex-middle">
				<input type="text" name="store_address[0]" value="<?=$store_address[0]?>" id="store_address" class="flex1" required placeholder="주소를 검색해 주세요.">
				<button type="button" class="_btn" id="postcode" style="background:#125f5c">주소검색</button>
			</div>
		</div>
		<div class="form-list">
			<div class="form-list-label"><label>상세 주소</label></div>
			<div class="form-list-con">
				<input type="text" name="store_address[1]" value="<?=$store_address[1]?>" class="w-full" placeholder="<?=$store_label?> 상세 주소를 입력해주세요.">
			</div>
		</div>
		<div class="form-list row">
			<div class="form-list-label"><label>사용여부</label></div>
			<div class="form-list-con ml-auto" style="--toggle-light-width:52px;--toggle-light-height:28px;">
				<input type="checkbox" name="store_use" value="1" class="toggle-light"<?=$store['store_use']||!$w?' checked':''?>>
			</div>
		</div>
		
		<?php if($config['cf_kakao_app_key']) {
			echo '<div id="map" class="map" style="height:250px;"></div>';
		} else {
			echo '<div class="tcenter"><a href="'.G5_ADMIN_URL.'/shop_admin/my/storelist.php" target="_blank" class="_btn/md/line/blue w-full">카카오 API 키 등록</a><p class=" mt10 fs12">좌표를 사용하기 위해 카카오API 키를 등록해주세요.</p></div>';
		} ?>
		
		<div class="form-list">
			<div class="form-list-label"><label>가로 수</label></div>
			<div class="form-list-con">
				<input type="text" name="store_wr1" value="<?=$store['store_wr1']?>" class="w-full" placeholder="3" data-label-inline="개">
			</div>
		</div>
		<div class="form-list">
			<div class="form-list-label"><label>줄 수</label></div>
			<div class="form-list-con">
				<input type="text" name="store_wr2" value="<?=$store['store_wr2']?>" class="w-full" placeholder="5" data-label-inline="개">
			</div>
		</div>

	</div>

	<div class="shop_btnSet">		
		<input type="submit" value="확인" class="btn_submit _btn/lg/black w-full" accesskey="s">
		<a href="<?=shop_short_url_my('shopStore')?>" class="_btn/lg/black/line w-full">취소</a>
		<a href="<?=G5_SHOP_URL?>/shopStore_write_update.php?w=d&store_id=<?=$store['store_id']?>" class="_btn/lg/red/line w-full mt30">삭제</a>
	</div>

</form>
</div>


<?php if($config['cf_kakao_app_key']) { ?>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$config['cf_kakao_app_key']?>&libraries=services"></script>
<?php } ?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
var mapContainer = document.getElementById('map'),
	mapOption = {
		center: new daum.maps.LatLng(<?=$lat?>, <?=$lng?>),
		level: <?=$store['store_lat'] && $store['store_lng']?'2':'13'?>,
		scrollwheel: false
	};
var map = new daum.maps.Map(mapContainer, mapOption);
var geocoder = new daum.maps.services.Geocoder();

// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
var zoomControl = new kakao.maps.ZoomControl();
map.addControl(zoomControl, kakao.maps.ControlPosition.RIGHT);

var marker = new daum.maps.Marker({
	<?php if($store['store_lat'] && $store['store_lng']) { ?>
	map: map,
	<?php } ?>
	position: map.getCenter()	
});
// 주소검색 API
$(function() {
	$("#postcode").on("click", function() {
		new daum.Postcode({
			oncomplete: function(data) {
				$("#store_address").val(data.address);
				
				geocoder.addressSearch(data.address, function(results, status) {
					if (status === daum.maps.services.Status.OK) {
						var result = results[0];
						var coords = new daum.maps.LatLng(result.y, result.x);
						map.relayout();
						map.setLevel(3);
						map.setCenter(coords);						
						document.getElementById('store_lat').value = coords.getLat();
						document.getElementById('store_lng').value = coords.getLng();
						marker.setMap(map);
						marker.setPosition(coords);
					}
				});
			}
		}).open();
	});
});

function _store_form_submit(f){
    return true;
}
</script>