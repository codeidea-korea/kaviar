<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if(G5_IS_MOBILE) {
	$thumb[$i][0] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 100, 100, false, true, 'center', false, '80/0.5/3', 0, false);
	$thumb[$i][1] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 140, 140, false, true, 'center', false, '80/0.5/3', 1, false);
} else {
	$thumb[$i][0] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 60, 60, false, true, 'center', false, '80/0.5/3', 0, false);
	$thumb[$i][1] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 80, 80, false, true, 'center', false, '80/0.5/3', 1, false);
}
$lat = 36.4965569936987; // 초기 및 리셋 중심좌표
$lng = 127.242297055683; // 초기 및 리셋 중심좌표
?>

<section class="mixWrap">
	<div class="mix-kakao-map mixContainer">	
		<?php if($list[$i]['wr_sub1']&&$list[$i]['wr_sub3']&&$list[$i]['wr_sub4']) {
			$map_default_height[$i] = $list[$i]['wr_sub5'] ? 'height:'.$list[$i]['wr_sub5'].'px;' : '400px;';
			if(G5_IS_MOBILE) $map_default_height[$i] = '360px';
			echo '<div id="map" style="'.$map_default_height[$i].'"></div>';
		} ?>
	</div>
	<?php if($list[$i]['bl_title'] || $isContent[$i]) {
		echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
		if($list[$i]['bl_title']) echo '<div class="block-title'.($bl_font?' '.$bl_font:'').'">'.nl2br($list[$i]['bl_title']).'</div>'.PHP_EOL;
		if($isContent[$i]) echo '<div class="contents">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
		echo $list_btn_set[$i];
		echo '</div>';
	} ?>
</section>


<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$board['bo_app_key']?>&libraries=services"></script>
<script>
var mapContainer = document.getElementById('map'),
	mapOption = {
		center: new daum.maps.LatLng(<?=$list[$i]['wr_sub3']?>, <?=$list[$i]['wr_sub4']?>),
		level: 3
	};
var map = new daum.maps.Map(mapContainer, mapOption);
var geocoder = new daum.maps.services.Geocoder();

<?php if($thumb[$i][0]) { ?>
var imageSrc = '<?=$thumb[$i][0][src]?>',
	imageSize = new kakao.maps.Size(60, 60),
	imageOption = {
		offset: new kakao.maps.Point(30, 38)
	};
var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption)
<?php } ?>

var marker = new daum.maps.Marker({
	map: map,
	<?php if($thumb[$i][0]) { ?>image: markerImage,<?php } ?>
	position: map.getCenter()	
});

//마커를 기준으로 가운데 정렬
var markerPosition = marker.getPosition(); 
map.relayout();
map.setCenter(markerPosition);

// 커스텀 오버레이 컨텐츠
var content = '<div class="mapConOveray">' +
	'	<div class="inner">' +
	'		<span class="close" onclick="closeOverlay()" title="닫기"></span>' +
	'		<?php if($thumb[$i][1][src]) { ?><img src="<?=$thumb[$i][1][src]?>"><?php } ?>' +
	'		<div class="desc">' +	
	'			<?php if($list[$i][wr_1]) { ?><div class="title"><?=$list[$i][wr_1]?></div><?php } ?>' +
	'			<?php if($list[$i][wr_2]) { ?><div class="tel"><?=$list[$i][wr_2]?></div><?php } ?>' +
	'			<?php if($list[$i][wr_sub2]) { ?><div class="address"><?=$list[$i][wr_sub2]?></div><?php } ?>' +
	'		</div>' +
	'	</div>' +
	'</div>';

// 마커 위에 커스텀오버레이를 표시
var position = new kakao.maps.LatLng(<?=$list[$i]['wr_sub3']?>, <?=$list[$i]['wr_sub4']?>);

// 마커를 중심으로 커스텀 오버레이를 표시하기위해 CSS를 이용해 위치를 설정했습니다
var overlay = new kakao.maps.CustomOverlay({
	content: content,
	map: map,
	position: position,
	yAnchor: 1
});

// 마커를 클릭했을 때 커스텀 오버레이를 표시
kakao.maps.event.addListener(marker, 'click', function() {
	overlay.setMap(map);
});
// 커스텀 오버레이를 닫기
function closeOverlay() {
	overlay.setMap(null);
}
//기본 오버레이 열기
overlay.setMap(map);

//브라우저가 리사이즈될때 지도 리로드
$(window).on('resize', function () {
	var markerPosition = marker.getPosition(); 
	map.relayout();
	map.setCenter(markerPosition)
});
</script>