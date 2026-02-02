<?php
include_once('../../../../../common.php');
include_once($board_skin_path.'/mix-type/_mix_form.lib.php');

if($write['wr_sub3'] == null){$write['wr_sub3'] =  37.566400714093284;}
if($write['wr_sub4'] == null){$write['wr_sub4'] = 126.9785391897507;}
?>


<div class="mix-kakao-map mixContainer">
	
	<div id="map">
		<?php if(!$board['bo_app_key']) echo '<span class="e-msg">게시판 관리자에서 App Key를 등록하세요.</span>'; ?>
		<?=$write['wr_sub1']&&$write['wr_sub3']&&$write['wr_sub4']?'':'<span class="mapCover"></span>'?>
	</div>
	<div class="mix-con">
		<input type="text" name="wr_1[0]" id="wr_1" value="<?=$write['wr_1']?>" placeholder="타이틀" class="span220"><br>
		<input type="tel" name="wr_2[0]" id="wr_2" value="<?=$write['wr_2']?>" placeholder="전화번호" class="span220"><br>
		<!--<input type="text" name="wr_3[0]" id="wr_3" value="<?=$write['wr_3']?>" placeholder="" class="span"><br>-->

		<input type="text" name="wr_sub1[0]" id="wr_sub1" value="<?=$write['wr_sub1']?>" placeholder="주소검색" class="span340 mt20"><br>
		<input type="text" name="wr_sub2[0]" id="wr_sub2" value="<?=$write['wr_sub2']?>" placeholder="나머지 주소" class="span340"><br>
		<input type="hidden" name="wr_sub3[0]" value="<?=$write['wr_sub3']?>" id="wr_sub3" readonly>
		<input type="hidden" name="wr_sub4[0]" value="<?=$write['wr_sub4']?>" id="wr_sub4" readonly>

		<label class="input-label mt20"><span class="label">맵높이</span><input type="text" name="wr_sub5[0]" value="<?=$write['wr_sub5']?>" placeholder="400" class="span60" data-label="맵높이"><span class="label">PX</span></label>

		<div class="flex">
			<div class="mix-map-file">						
				<label><input type="file" name="bf_file[]" accept="image/*" class="bgImg"><span class="btn-file">마커이미지 <sub>최대 가로세로 (60px)</sub></span></label>
				<div class="holder">
					<?php if($thumb[0]) {
						echo '<img src="'.$thumb[0]['ori'].'">';
						echo '<label class="checkbox-wrap"><input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="1"><span></span>파일삭제</label>';
					} ?>
				</div>
			</div>
			<div class="mix-map-file thumbnail ml30">						
				<label><input type="file" name="bf_file[]" accept="image/*" class="bgImg"><span class="btn-file">썸네일 이미지</span></label>
				<div class="holder">
					<?php if($thumb[1]) {
						echo '<img src="'.$thumb[1]['ori'].'">';
						echo '<label class="checkbox-wrap"><input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"><span></span>파일삭제</label>';
					} ?>
				</div>
			</div>
		</div>

	</div>

	<input type="hidden" name="bf_file_del[3]" value="1">
	<input type="hidden" name="bf_file_del[4]" value="1">
	<input type="hidden" name="bf_file_del[5]" value="1">
	<input type="hidden" name="bf_file_del[6]" value="1">
	<input type="hidden" name="bf_file_del[7]" value="1">
	<input type="hidden" name="bf_file_del[8]" value="1">
	<input type="hidden" name="bf_file_del[9]" value="1">
</div>

<script>
var mapContainer = document.getElementById('map'),
	mapOption = {
		center: new daum.maps.LatLng(<?=$write['wr_sub3']?>, <?=$write['wr_sub4']?>),
		level: 3
	};
var map = new daum.maps.Map(mapContainer, mapOption);
var geocoder = new daum.maps.services.Geocoder();

<?php if($thumb[0]) { ?>
var imageSrc = '<?=$thumb[0][src]?>',
	 imageSize = new kakao.maps.Size(60, 60),
        imageOption = {
            offset: new kakao.maps.Point(30, 38)
        };
var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption)
<?php } ?>

var marker = new daum.maps.Marker({
	map: map,
	<?php if($thumb[0]) { ?>image: markerImage,<?php } ?>
	position: map.getCenter()	
});

// 주소검색 API (주소 > 좌표변환처리)
$(function() {
	$("#wr_sub1, #map .mapCover").on("click", function() {
		new daum.Postcode({
			oncomplete: function(data) {
				$("#wr_sub1").val(data.address);
				$('.mapCover').remove();
				geocoder.addressSearch(data.address, function(results, status) {
					if (status === daum.maps.services.Status.OK) {
						var result = results[0];
						var coords = new daum.maps.LatLng(result.y, result.x);
						map.relayout();
						map.setCenter(coords);
						document.getElementById('wr_sub3').value = coords.getLat();
						document.getElementById('wr_sub4').value = coords.getLng();
						marker.setPosition(coords);
					}
				});
			}
		}).open();
	});
	
});
//마커를 기준으로 가운데 정렬이 될 수 있도록 추가
var markerPosition = marker.getPosition(); 
map.relayout();
map.setCenter(markerPosition);

// 커스텀 오버레이 컨텐츠
var content = '<div class="mapConOveray">' +
	'	<div class="inner">' +
	'		<span class="close" onclick="closeOverlay()" title="닫기"></span>' +
	'		<?php if($thumb[1][src]) { ?><img src="<?=$thumb[1][src]?>"><?php } ?>' +
	'		<div class="desc">' +	
	'			<?php if($write[wr_1]) { ?><div class="title"><?=$write[wr_1]?></div><?php } ?>' +
	'			<?php if($write[wr_2]) { ?><div class="tel"><?=$write[wr_2]?></div><?php } ?>' +
	'			<?php if($write[wr_sub2]) { ?><div class="address"><?=$write[wr_sub2]?></div><?php } ?>' +
	'		</div>' +
	'	</div>' +
	'</div>';

// 마커 위에 커스텀오버레이를 표시
var position = new kakao.maps.LatLng(<?=$write['wr_sub3']?>, <?=$write['wr_sub4']?>);

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


$('input[type="file"].img').each(function(index) {
	var upload = $(this)[0];
	$(this).parent().parent().find('.holder').attr('id', 'holder_' + index);
	var holder = document.getElementById('holder_' + index);
	upload.onchange = function (e) {
		e.preventDefault();
		var file = upload.files[0],
		reader = new FileReader();
		reader.onload = function (event) {
			var img = new Image();
			img.src = event.target.result;
			holder.innerHTML = '';
			holder.appendChild(img);
			//holder.style.backgroundImage = "url("+event.target.result+")";  
		};
		reader.readAsDataURL(file);
		return false;
	};
});

$('.fillCheck').each( function() {
	var val = $(this).val();
	if(val == '') {
		$(this).removeClass('fill');
	} else {
		$(this).addClass('fill');
	}
});
$(".fillCheck").bind("keyup", function(event) {
	var val = $(this).val();
	if(val == '') {
		$(this).removeClass('fill');
	} else {
		$(this).addClass('fill');
	}
});
//textarea 자동조절
function textareaResize(obj) {
	obj.style.height = "1px";
	obj.style.height = (2+obj.scrollHeight)+"px";
}
$("textarea.autosize").bind("keypress", function(event) {
	textareaResize(this);
});
$("textarea.autosize").bind("keyup", function(event) {
	textareaResize(this);
});
</script>