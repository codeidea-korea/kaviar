<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div id="_items_filter">
	<div class="title">필터</div>
	<span class="closer"></span>
	<div class="_items_filter_tabs">
		<span class="tab active" data-target="#_filter_tabContainer01">카테고리 선택</span>
		<span class="tab" data-target="#_filter_tabContainer02">컬렉션</span>
		<!--<span class="tab" data-target="#_filter_tabContainer03">태그</span>-->
		<span class="tab" data-target="#_filter_tabContainer04">가격</span>
	</div>
	
	<div class="_filter_tabContainer">

		<div id="_filter_tabContainer01" class="tabContainer">
			<div class="sound_only">카테고리 선택</div>
			<?php
			$str = '';
			$exists = false;

			$ca_id_len = strlen(20);
			$len2 = $ca_id_len + 2;
			$len4 = $ca_id_len + 4;

			$sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '10%' and length(ca_id) = $len2 and ca_use = '1' order by ca_order, ca_id ";
			$result = sql_query($sql);
			while ($row=sql_fetch_array($result)) {

				$row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where (ca_id like '{$row['ca_id']}%' or ca_id2 like '{$row['ca_id']}%' or ca_id3 like '{$row['ca_id']}%') and it_use = '1'  ");
				$str .= '<li><a href="#" onclick="cate(\''.$row['ca_id'].'\')"><label class="radio-wrap"><input type="radio" name="filter01" value="" '.($ca_id==$row['ca_id']?"checked":"").'><span></span>'.$row['ca_name'].'</label></a></li>';
				$exists = true;
			}
			if ($exists) {
				echo '<ul>';
					echo '<li><label class="radio-wrap"><input type="radio" name="filter01" value=""><span></span>전체보기</label></li>';
					echo $str;
				echo '</ul>';
			}
			?>
		</div>

		<div id="_filter_tabContainer02" class="tabContainer">
			<div class="sound_only">컬렉션</div>
			<?php
			$str = '';
			$exists = false;

			$ca_id_len = strlen(20);
			$len2 = $ca_id_len + 2;
			$len4 = $ca_id_len + 4;

			$sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '20%' and length(ca_id) = $len2 and ca_use = '1' order by ca_order, ca_id ";
			$result = sql_query($sql);
			$sub_query1 = "";
			while ($row=sql_fetch_array($result)) {

				if($ca_id == 'all'){
					$sub_query1 = " ca_id2 = '".$row['ca_id']."' ";
				}else{
					$sub_query1 = " ca_id = '".$ca_id."' and ca_id2 = '".$row['ca_id']."' ";
				}

				$row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where {$sub_query1} and it_use = '1'  ");

				//$row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where (ca_id like '{$row['ca_id']}%' or ca_id2 like '{$row['ca_id']}%' or ca_id3 like '{$row['ca_id']}%') and it_use = '1'  ");

				$ca_arrs = explode("_",$ca_id2);
				$chk_ca = "";
				for($u=0; $u<count($ca_arrs); $u++){

					if($ca_arrs[$u] == $row['ca_id']){
						
						$chk_ca = $ca_arrs[$u];
					}
				}

				$str .= '<li><a href="#" onclick="asdf(\''.$ca_id.'\','.$row['ca_id'].',\''.$ca_id2.'\',\''.$price.'\',\''.$tags.'\')"><label class="checkbox-wrap circle"><input type="checkbox" name="" value="'.$row['ca_name'].'"  '.($chk_ca==$row['ca_id']?"checked":"").'><span></span>'.$row['ca_name'].'<i class="count">'.$row2['cnt'].'</i></label></a></li>';
				$exists = true;
			}

			if ($exists) {
				echo '<ul>';
					echo $str;
				echo '</ul>';
			}
			?>
			
		</div>
<?/*
		<div id="_filter_tabContainer03" class="tabContainer">
			<div class="sound_only">태그</div>
			<?php
			$str = '';
			$exists = false;
			$cf_search_keyword = explode(",",$config['cf_search_keyword']);
			for($k=0; $k<count($cf_search_keyword); $k++) {
				$str .= '<li><label class="radio-wrap"><input type="radio" name="filter03" value="'.$cf_search_keyword[$k].'"><span></span>#'.$cf_search_keyword[$k].'</label></li>';
				$exists = true;
			}
			if ($exists) {
				echo '<ul>';
					echo $str;
				echo '</ul>';
			}
			?>				
		</div>
*/?>
		<div id="_filter_tabContainer04" class="tabContainer">
			<div class="sound_only">가격</div>
			<ul>
				<li><a href="#" onclick="prices(1)"><label class="radio-wrap"><input type="radio" value="1" <?php ECHO ($_GET['price']=='1'?"checked":"") ?> name="filter04" value=""><span></span>6,000원 미만</label></a></li>
				<li><a href="#" onclick="prices(2)"><label class="radio-wrap"><input type="radio" value="2" <?php ECHO ($_GET['price']=='2'?"checked":"") ?> name="filter04" value=""><span></span>6,000원 ~ 10,000원</label></a></li>
				<li><a href="#" onclick="prices(3)"><label class="radio-wrap"><input type="radio" value="3" <?php ECHO ($_GET['price']=='3'?"checked":"") ?> name="filter04" value=""><span></span>10,000원 ~ 20,000원</label></a></li>
				<li><a href="#" onclick="prices(4)"><label class="radio-wrap"><input type="radio" value="4" <?php ECHO ($_GET['price']=='4'?"checked":"") ?> name="filter04" value=""><span></span>20,000원 이상</label></a></li>
			</ul>		
		</div>
	</div>
	
	<div class="btnSet mt20 flex flex-middle gap15">
		<a href="<?=$filter_reset_url?>" class="reset">초기화</a>
		<button type="button" class="_btn/lg/mainColor flex1">상품보기</button>
	</div>
</div>
<div id="_items_filter_bodyCover"></div>


<script>

function prices(names){
	
	const urlParams = new URLSearchParams(window.location.search);
	
	const entries = urlParams.entries();

	for(entry of entries)  {
		if(entry[0] == 'price' && entry[1] == names){
		  names = '';
		}
	}

	if(urlParams.has('price')) {

		urlParams.delete('price');
		urlParams.set('price', names);

		location.href="./list.php?"+urlParams;
	}else{

		location.href="./list.php?"+urlParams+"&price="+names;
	}

}


function cate(names){
	
	const urlParams = new URLSearchParams(window.location.search);
	
	const entries = urlParams.entries();

	for(entry of entries)  {
		if(entry[0] == 'ca_id' && entry[1] == names){
		  names = '';
		}
	}

	if(urlParams.has('ca_id')) {

		urlParams.delete('ca_id');
		urlParams.set('ca_id', names);

		location.href="./list.php?"+urlParams;
	}else{

		location.href="./list.php?"+urlParams+"&ca_id="+names;
	}

}


function asdf(ca1,ca2,ca2_ori,number,tags){
	var cat;
	var arrValues = new Array();
	var set1;
	
	if(number === undefined ) {
		number = "";
	}

	if(tags === undefined ) {
		tags = "";
	}

	if (ca2_ori.match(ca2)) {

		var arr = ca2_ori.split("_");
		//arr.push(''+ca2+'');

		//자른걸 배열에 담는다.
		let filtered = arr.filter((element) => element !== ''+ca2+'');

		if(filtered.length > 1){
			
			for(var i=0; i<filtered.length; i++) {
				if(i==0){
					cat = filtered[i];
				}else{
					cat = cat + "_" + filtered[i];
				}
			}

		}else{
			cat = filtered[0];
		}

	}else{
		
		if(ca2_ori){
		
			cat = ca2_ori+"_"+ca2;
		}else{
			
			cat = ca2;
		}

	}

	if(cat === undefined ) {
		cat = "";
	}


	
	const urlParams = new URLSearchParams(window.location.search);

	if(urlParams.has('price')) {

		urlParams.delete('price');
		urlParams.set('ca_id2', cat);	
		/*	
		$.ajax({
		  url:"./list.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number+"&tags="+tags+"&test2",
		  type:'get',
		  
		  cache: false,
		  async: false,
		  dataType : 'html',
		  success: function(res) {

				$("#root").html(res);
			}
		});*/

		location.href="./list.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number;
	}else{
		/*
		$.ajax({
		  url:"./list.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number+"&tags="+tags+"&test1",
		  type:'get',
		  
		  cache: false,
		  async: false,
		  dataType : 'html',
		  success: function(res) {

				$("#root").html(res);
			}
		});*/

		location.href="./list.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number;
	}


	//location.href="./list.php?ca_id="+ca1+"&ca_id2="+cat;
}
</script>

<script>
_tabsContainer("._items_filter_tabs .tab", "._filter_tabContainer .tabContainer");
</script>