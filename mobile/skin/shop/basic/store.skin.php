<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
function sortable() {
    $(".sortable").sortable({
        start: function(event, ui) {
			$(this).children('li.ui-sortable-helper').css({'z-index':'99'});
        },
        stop: function(event, ui) {
			$(this).children('li').css({'z-index':''});
			reorder();
        }
    });
    $( ".sortable" ).disableSelection();
}
function reorder() {
    $(".frm_store_ul > li").each(function(i) {
		$(this).find(".store_order").val(i + 1);
    });
}
</script>

<div id="_shopStore">
	
	<div class="scroll-fixed" style="top:var(--header-height);">
		<div class="storeSearchContaner">
			<form name="frmdetailsearch">
			<div class="ssch_scharea">
				<label for="ssch_q" class="sound_only" >검색어</label>
				<input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="ssch_input" size="40" maxlength="30" placeholder="<?=$store_label?>명을 검색하세요">
				<button type="submit" class="btn_submit">검색</button>
				<?php if($q) echo '<a href="'.shop_short_url_my('shopStore').'" class="reset">검색초기화</a>'; ?>
			</div>
			</form>
		</div>
		<div class="locationContainer">
			<button type="button" class="btn_current_location"><span>현재위치로</span> 설정하기</button>
		</div>
	</div>
	
	<div class="_topCon">
		<?php if($is_shop_manager) echo '<a href="'.G5_ADMIN_URL.'/shop_admin/my/storelist.php" target="_blank" class="btnSetting light" style="top:5px;left:-25px;right:auto;transform:scale(0.7);">'.$store_label.' 관리페이지</a>';?>
		<div class="title"><?=$store_label?> 목록</div>
		<div class="btnSet">
			<button type="button" class="list-toggle active"></button>
			<button type="button" class="map-toggle"></button>
		</div>
	</div>
	
	<div id="_store_list">
		<form name="_adm_shop_bl_bundle" id="_adm_shop_bl_bundle" action="<?=G5_SHOP_URL?>/shopStore_list_bundle_update.php" onsubmit="return _adm_shop_bl_bundle_submit(this);" method="post">
		<input type='hidden' name='chk' value='<?=$total_count?>'>
		<div class="store_list">
			
			<ul class="frm_store_ul">
				<?php
				for ($i=0; $row=sql_fetch_array($shop_result); $i++) {
					$store_address[$i] = explode('|', $row['store_address']);
					echo '<li class="'.($row['store_use']?'':' nouse').'">';

						echo '<input type="hidden" name="store_id_up['.$i.']" value="'.$row['store_id'].'">';
						echo '<input type="hidden" name="store_order['.$i.']" value="'.$row['store_order'].'" class="store_order tcenter">';

						echo '<i class="location_icon"></i>';
						echo '<a href="'.shop_short_url_my('shopStore','','store_id='.$row['store_id']).'" class="storeCon">';
							echo '<div class="storeSubject">'.$row['store_subject'].'</div>';
							echo '<div class="addr">';
								echo '<span class="addr1">'.$store_address[$i][0].'</span>';
								echo '<span class="addr2">'.$store_address[$i][1].'</span>';
							echo '</div>';
						echo '</a>';
		
						if(($row['store_lat'] && $row['store_lng']) || $is_admin) {
							echo '<div class="list-right">';
							if($row['store_lat'] && $row['store_lng']) {
								echo '<span class="distance" data-lat="'.$row['store_lat'].'" data-lng="'.$row['store_lng'].'"></span>';
							}
							//echo '<a href="#" class="btn_view">자세히 보기</a>';
							if($is_admin) echo '<a href="'.shop_short_url_my('shopStore_write','','w=u&amp;store_id='.$row['store_id']).'" class="btnEdit">수정</a>';
							echo '</div>';
						}
					echo '</li>';
				}
				if($i==0) echo '<li class="empty_li">등록된 '.$store_label.'이 없습니다.</li>';
				?>
			</ul>
			<?php if($is_admin) {
				echo '<div class="btnSet">';
					echo '<span class="btnOrderChange">순서편집</span>';
				echo '</div>';
			} ?>
		</div>

		<?=$write_pages?>
		
		<?php if($is_admin) {
			echo '<div class="shop_btnSet">';
				echo '<a href="'.shop_short_url_my('shopStore_write').'" class="_btn/lg/black w-full">'.$store_label.' 등록</a>';
			echo '</div>';
		} ?>
		</form>
	</div>
	
	<div id="_store_map" class="hide"></div>
</div>

<style>
#mapOverlay{position:relative;z-index:999;font-size:13px;background:#fff;padding:10px;border:1px solid rgba(0,0,0,0.5);border-radius:5px;display:flex;flex-direction:column;gap:5px;font-family:var(--Pretendard);}
#mapOverlay:before{content:'';display:inline-flex;width:7px;height:7px;background:#fff;border-bottom:1px solid rgba(0,0,0,0.5);border-right:1px solid rgba(0,0,0,0.5);position:absolute;bottom:-4px;left:50%;margin-left:-4px;transform:rotate(45deg);}
#mapOverlay .store_subject{font-weight:bold;font-size:14px;margin-right:25px;}
#mapOverlay .store_addr{font-size:12px;color:rgba(71,78,103,1);}
#mapOverlay button{position:absolute;top:6px;right:6px;font-size:0;}
#mapOverlay button:before{content:'\e92d';font-family:'shop';font-size:17px;}
</style>



<?php if($config['cf_kakao_app_key']) { ?>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$config['cf_kakao_app_key']?>&libraries=services"></script>
<?php } ?>

<script>
$('.list-toggle').click(function() {
	$(this).addClass('active');
	$('.map-toggle').removeClass('active');
	$('#_store_map').addClass('hide');
	$('#map').remove();
	$('#_store_list').removeClass('hide');
});
$('.map-toggle').click(function() {
	$(this).addClass('active');
	$('.list-toggle').removeClass('active');
	$('#_store_list').addClass('hide');
	$('#_store_map').removeClass('hide');
	$('#_store_map').html('<div id="map"><?php if(!$config["cf_kakao_app_key"]) echo "<p class=\"tcenter p20 py50 color-slate-500\">카카오 API를 등록해 주세요</p>";?></div>');
	<?php if($config['cf_kakao_app_key']) { ?>
	map_show();
	<?php } ?>
});

function map_show() {
	var mapContainer = document.getElementById('map'), // 지도를 표시할 div  
		mapOption = { 
			center: new kakao.maps.LatLng(36.4965569936987, 127.242297055683), // 지도의 중심좌표
			level: 13 // 지도의 확대 레벨
		};

	var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
	 
	// 마커를 표시할 위치와 내용을 가지고 있는 객체 배열입니다 
	var positions = [
		<?php
		$shop_result2 = sql_query($shop_sql);
		for ($i=0; $row2=sql_fetch_array($shop_result2); $i++) {
			$store_link[$i] = shop_short_url_my('shopStore','','store_id='.$row2['store_id']);
			if($row2['store_lat'] && $row2['store_lng']) {
			?>
		{
			title: '<div class="store_subject"><?=$row2["store_subject"]?></div><div class="store_addr"><?=$store_address[$i][0]?></div><div class="mt5"><a href="<?=$store_link[$i]?>" class="store_link _btn/mini/line"><?=$store_label?> 바로가기</a><div>', 
			latlng: new kakao.maps.LatLng(<?=$row2['store_lat']?>, <?=$row2['store_lng']?>)
		},
		<?php
			}
		} ?>
	];

	for(let i=0; i < positions.length; i++){
		var data = positions[i];
		displayMarker(data);
	}

	// 지도에 마커를 표시하는 함수입니다    
	function displayMarker(data) { 
		var marker = new kakao.maps.Marker({
			map: map,
			position: data.latlng
		});
		var overlay = new kakao.maps.CustomOverlay({
			yAnchor: 1.7,
			position: marker.getPosition()
		});
		
		var content = document.createElement('div');
		content.id = 'mapOverlay';
		content.innerHTML =  data.title;
		//content.style.cssText = 'padding:10px;border-radius:5px;background:#fff;border:1px solid rgba(0,0,0,0.7);';
		
		var closeBtn = document.createElement('button');
		closeBtn.innerHTML = '닫기';
		closeBtn.onclick = function () {
			overlay.setMap(null);
		};
		content.appendChild(closeBtn);
		overlay.setContent(content);

		kakao.maps.event.addListener(marker, 'click', function() {
			overlay.setMap(map);
		});
	}
}

function mylocation() {
	navigator.geolocation.getCurrentPosition((position) => {
		let latitude = position.coords.latitude;
		let longitude = position.coords.longitude;
		
		//toAddress(longitude, latitude);

		$('.frm_store_ul li .distance').each(function() {
			var lat = $(this).attr('data-lat'),
				lng = $(this).attr('data-lng');
			var distance = getDistance(latitude, longitude, lat, lng, 'K'),
				distance_round = Math.round(distance).toFixed(1);
			
			$(this).html('<span>'+distance_round+'</span> km');	
		});

	}, (err) => {

	});
}

function toAddress(lon,lat) {
	$.ajax({
		url : 'https://dapi.kakao.com/v2/local/geo/coord2address.json?x=' + lon +'&y=' + lat,
		type : 'GET',
		headers : {
			'Authorization' : 'KakaoAK {86657719a85918aa2297626ec7e75151}'
		},
		success : function(data) {
			console.log(data);
			alert(data);
		},
		error : function(e) {
			console.log(e);
			//alert('sdfgdfg');
		}
	});
}

function getDistance(lat1, lon1, lat2, lon2, unit) {
        var radlat1 = Math.PI * lat1/180
        var radlat2 = Math.PI * lat2/180
        var radlon1 = Math.PI * lon1/180
        var radlon2 = Math.PI * lon2/180
        var theta = lon1-lon2
        var radtheta = Math.PI * theta/180
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist)
        dist = dist * 180/Math.PI
        dist = dist * 60 * 1.1515
        if (unit=="K") { dist = dist * 1.609344 }
        if (unit=="N") { dist = dist * 0.8684 }
        return dist
}


$('.btn_current_location').click(function() {
	alert('현재위치로 설정되었습니다.');
	mylocation();
});

$('.btnOrderChange').click(function() {
	$(this).toggleClass('active');
	$('.frm_store_ul').toggleClass('sortable ui-sortable');
	var html = '<span class="help-block">드래그해서 순서를 변경할 수 있습니다.</span>';	
	html += '<input type="submit" name="btn_submit" value="순서저장" class="btn_submit btnOrderOk" onclick="document.pressed=\'순서저장\'" accesskey="s">';
	html += '<span class="btnCancel" onclick="document.location.reload()">취소</span>';
	html += '<input type="submit" name="btn_submit" value="초기화" class="btnReset" onclick="document.pressed=\'초기화\'" accesskey="s">';
	if($(this).hasClass('active')) {
		$('.frm_store_ul').addClass('sortable');
		$('.store_list .btnSet').empty();
		$('.store_list .btnSet').html(html);
		sortable();
	} else {
		document.location.reload();
	}
	
});

$(document).ready(function(){
	mylocation();
});
</script>