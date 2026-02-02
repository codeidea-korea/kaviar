<?php
$sub_menu = '400902';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");

$g5['title'] = $w ? $store_label.'수정' : $store_label.'등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;
if($store_id) {
	$sql = " select * from {$g5['g5_shop_store_table']} where store_id = '$store_id' ";
	$store = sql_fetch($sql);
}

$store_address = explode('|', $store['store_address']);

$lat = $store['store_lat'] ? $store['store_lat'] : 36.4965569936987; // 초기 및 리셋 중심좌표
$lng = $store['store_lng'] ? $store['store_lng'] : 127.242297055683; // 초기 및 리셋 중심좌표

// 등록된 지점 상품
$sql = " select b.it_id, b.it_name
			from {$g5['g5_shop_store_item_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
			where a.store_id = '$store_id' ";
$res_item = sql_query($sql);
?>

<form name="storeform" action="./storeformupdate.php" onsubmit="return storeform_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="store_id" value="<?=$store_id?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="store_lat" value="<?=$store['store_lat']?>" id="store_lat">
<input type="hidden" name="store_lng" value="<?=$store['store_lng']?>" id="store_lng">
<input type="hidden" name="store_item" value="">

<section class="mybox">
    <h2 class="h2_frm"><?=$g5['title']?></h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label>사용여부</label></th>
					<td>
						<div style="--toggle-light-width:56px;--toggle-light-height:26px;">
							<input type="checkbox" name="store_use" value="1" class="toggle-light"<?=$store['store_use']||!$w?' checked':''?>>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label><?=$store_label?> 이미지</label></th>
					<td>
						<?php
						$store_img_path = G5_DATA_PATH.'/store/store_'.$store['store_id'].'.png';
						$store_img_url = G5_DATA_URL.'/store/store_'.$store['store_id'].'.png';
						$upImg_store_img = file_exists($store_img_path) ? '<img src="'.$store_img_url.'?'.preg_replace('/[^0-9]/i', '', $store['store_time']).'"><label><input type="checkbox" name="del_store_img" value="1">삭제</label>' : '';
						echo '<input type="file" name="store_img" class="myfile">';
						echo '<div class="upImg">'.$upImg_store_img.'</div>';
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>링크</label></th>
					<td>
						<p class="help-block">상품상세 페이지내 브랜드 이미지의 링크</p>
						<input type="text" name="store_url" value="<?=$store['store_url']?>" id="store_url" class="w-full" size="255" data-label="브랜드 링크">
					</td>
				</tr>
				<tr>
					<th scope="row"><label><?=$store_label?>명</label></th>
					<td>
						<input type="text" name="store_subject" value="<?=$store['store_subject']?>" id="store_subject" class="w-300" required placeholder="<?=$store_label?>명을 입력해 주세요.">
						<?php if($store['store_id']) echo '<a href="'.shop_short_url_my('shopStore','','store_id='.$store['store_id']).'" target="_blank" class="btn_frmline ml10">'.$store_label.' 바로가기</a>'; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>기본설명</label></th>
					<td>
						<input type="text" name="store_basic" value="<?=$store['store_basic']?>" id="store_basic" class="w-full" placeholder="">
					</td>
				</tr>
				<tr>
					<th scope="row"><label><?=$store_label?>주소</label></th>
					<td>
						<ul class="flex column">
							<li>
								<!--<input type="text" name="store_address[0]" value="<?=$store_address[0]?>" id="store_address" class="w-500" required placeholder="주소를 검색해 주세요.">-->
								<input type="text" name="store_address[0]" value="<?=$store_address[0]?>" id="store_address" class="w-500" placeholder="주소를 검색해 주세요.">
								<button type="button" class="_btn" id="postcode" style="background:#125f5c">주소검색</button>
							</li>
							<li>
								<input type="text" name="store_address[1]" value="<?=$store_address[1]?>" class="w-500" placeholder="<?=$store_label?> 상세 주소를 입력해주세요.">
							</li>
						</ul>
						<?php if($config['cf_kakao_app_key']) echo '<div id="map" class="map mt10" style="width:620px;height:350px;"></div>'; ?>
					</td>
				</tr>
			</tbody>
        </table>
    </div>
</section>

<section class="mybox">
    <h2 class="h2_frm"><?=$store_label?> 상품</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label>상품 출력 가로수</label></th>
					<td>
						<input type="text" name="store_wr1" value="<?=$store['store_wr1']?>" class="w-100" placeholder="3" data-label-inline="개">
					</td>
				</tr>
				<tr>
					<th scope="row"><label>상품 출력 줄 수</label></th>
					<td>
						<input type="text" name="store_wr2" value="<?=$store['store_wr2']?>" class="w-100" placeholder="5" data-label-inline="개">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="store_compare_wrap mt15">
							<section class="compare_left mybox gray">
								<h3 class="mybox-label">상품 검색</h3>
								<label for="sch_relation" class="sound_only">상품분류</label>
								<span class="srel_pad">
									<select id="sch_relation">
										<option value=''>분류별 상품</option>
										<option value='all'>- 모든상품 -</option>
										<?php
											$sql = " select * from {$g5['g5_shop_category_table']} ";
											if ($is_admin != 'super')
												$sql .= " where ca_mb_id = '{$member['mb_id']}' ";
											$sql .= " order by ca_order, ca_id ";
											$result = sql_query($sql);
											for ($i=0; $row=sql_fetch_array($result); $i++) {
												$len = strlen($row['ca_id']) / 2 - 1;

												$nbsp = "";
												for ($i=0; $i<$len; $i++)
													$nbsp .= "&nbsp;&nbsp;&nbsp;";

												echo "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";
											}
										?>
									</select>
									<label for="sch_name" class="sound_only">상품명</label>
									<input type="text" name="sch_name" id="sch_name" class="frm_input" size="15">
									<button type="button" id="btn_search_item" class="btn_frmline">검색</button>
								</span>
								<div id="sch_item_list" class="srel_list _item_list">
									<p class="msg">상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>
								</div>
								<script>
								$(function() {
									$("#btn_search_item").click(function() {
										var ca_id = $("#sch_relation").val();
										var it_name = $.trim($("#sch_name").val());
										var $relation = $("#relation");

										if(ca_id == "" && it_name == "") {
											$("#sch_item_list").html("<p class='msg'>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>");
											return false;
										}

										$("#sch_item_list").load(
											"<?=G5_ADMIN_URL?>/shop_admin/itemstoresearch.php",
											{store_id: "<?=$store_id?>", ca_id: ca_id, it_name: it_name }
										);
									});

									$(document).on("click", "#sch_item_list .add_item", function() {
										// 이미 등록된 상품인지 체크
										var $li = $(this).closest("li");
										var it_id = $li.find("input:hidden").val();
										var it_id2;
										var dup = false;
										$("#reg_item_list input[name='it_id[]']").each(function() {
											it_id2 = $(this).val();
											if(it_id == it_id2) {
												dup = true;
												return false;
											}
										});

										if(dup) {
											alert("이미 선택된 상품입니다.");
											return false;
										}

										var cont = "<li>"+$li.html().replace("add_item", "del_item").replace("추가", "삭제")+"</li>";
										var count = $("#reg_item_list li").length;

										if(count > 0) {
											$("#reg_item_list li:last").after(cont);
										} else {
											$("#reg_item_list").html("<ul>"+cont+"</ul>");
										}

										$li.remove();
									});

									$(document).on("click", "#reg_item_list .del_item", function() {
										if(!confirm("상품을 삭제하시겠습니까?"))
											return false;

										$(this).closest("li").remove();

										var count = $("#reg_item_list li").length;
										if(count < 1)
											$("#reg_item_list").html("<p class='msg'>선택된 상품이 없습니다.</p>");
									});
								});
								</script>
							</section>

							<section class="compare_right mybox blue">
								<h3 class="mybox-label">선택된 지점상품</h3>
								<span class="srel_pad"></span>
								<div id="reg_item_list" class="srel_sel _item_list">
									<?php
									if( $res_item ) {
									for($i=0; $row=sql_fetch_array($res_item); $i++) {
										$it_name = get_it_image($row['it_id'], 50, 50).' '.$row['it_name'];

										if($i==0)
											echo '<ul>';
									?>
										<li>
											<input type="hidden" name="it_id[]" value="<?php echo $row['it_id']; ?>">
											<div class="list_item"><?php echo $it_name; ?></div>
											<div class="list_item_btn"><button type="button" class="del_item btn_frmline">삭제</button></div>
										</li>
									<?php
									}   // end for
									}   // end if
									if($i > 0)
										echo '</ul>';
									else
										echo '<p class="msg">등록된 상품이 없습니다.</p>';
									?>
								</div>
							</section>
						</div>
					</td>
				</tr>
			</tbody>
        </table>
    </div>
</section>


<div class="btn_fixed_top">
    <a href="./storelist.php" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>




<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
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


function storeform_submit(f){

	// 지점상품처리
    var item = new Array();
    var re_item = it_id = "";

    $("#reg_item_list input[name='it_id[]']").each(function() {
        it_id = $(this).val();
        if(it_id == "")
            return true;

        item.push(it_id);
    });

    if(item.length > 0)
        re_item = item.join();

    $("input[name=store_item]").val(re_item);


    return true;
}
</script>

<?php if($config['cf_kakao_app_key']) { ?>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$config['cf_kakao_app_key']?>&libraries=services"></script>
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
</script>
<?php } ?>

<?php

include_once (G5_ADMIN_PATH.'/admin.tail.php');