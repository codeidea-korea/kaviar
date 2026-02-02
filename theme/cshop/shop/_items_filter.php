<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div id="_items_filter">
	<div class="_head">
		<span class="title">필터</span>
		<a href="<?=$filter_reset_url?>" class="reset">초기화</a>
	</div>
	<div class="_filter01">
		<div class="title">컬렉션</div>
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

			//$row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where (ca_id like '{$row['ca_id']}%' or ca_id2 like '{$row['ca_id']}%' or ca_id3 like '{$row['ca_id']}%') and it_use = '1'  ");
			if($ca_id == 'all'){
				$sub_query1 = " (ca_id2 = '".$row['ca_id']."' or ca_id3 = '".$row['ca_id']."') ";
			}else{
				$sub_query1 = " ca_id = '".$ca_id."' and (ca_id2 = '".$row['ca_id']."' or ca_id3 = '".$row['ca_id']."') ";
			}

			$row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where {$sub_query1} and it_use = '1'  ");
			//echo " select count(*) as cnt from {$g5['g5_shop_item_table']} where {$sub_query1} and it_use = '1'  ";
			//$str .= '<li class="checkbox-wrap circle"><a href="'.shop_category_url($ca_id).'&ca_id2='.$row['ca_id'].'" class="'.($ca_id2==$row['ca_id']?'active':'').'">'.$row['ca_name'].'<span class="count">'.$row2['cnt'].'</span></a></li>';
			$ca_arrs = explode("_",$ca_id2);

			$chk_ca = "";
			for($u=0; $u<count($ca_arrs); $u++){

				if($ca_arrs[$u] == $row['ca_id']){
					
					$chk_ca = $ca_arrs[$u];
				}
			}

			$str .= '<li><a href="#" onclick="asdf(\''.$ca_id.'\','.$row['ca_id'].',\''.$ca_id2.'\',\''.$price.'\',\''.$tags.'\')"><label class="custom"><input type="checkbox" name="" value="'.$row['ca_name'].'" '.($chk_ca==$row['ca_id']?"checked":"").'><span>'.$row['ca_name'].'<i class="count">'.$row2['cnt'].'</i></span></label></a></li>';
			//$str .= '<li><a href="#" onclick="asdf(\''.$ca_id.'\','.$row['ca_id'].',\''.$ca_id2.'\',\''.$price.'\',\''.$tags.'\')"><label class="checkbox-wrap circle"><input type="checkbox" name="" value="'.$row['ca_name'].'" '.($chk_ca==$row['ca_id']?"checked":"").'>'.$row['ca_name'].'<i class="count">'.$row2['cnt'].'</i></label></a></li>';

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
	<div class="_filter02">
	
		<div class="title">태그</div>
		<?php
		$str = '';
		$exists = false;
		$cf_search_keyword = explode(",",$config['cf_search_keyword']);
		for($k=0; $k<count($cf_search_keyword); $k++) {
			//$str .= '<li><a href="'.shop_short_url_my('search','','q='.$cf_search_keyword[$k]).'" class="keyword">#'.$cf_search_keyword[$k].'</a></li>';
			$str .= '<li><a href="#" onclick="tags(\''.$cf_search_keyword[$k].'\')"><label class="radio-wrap"><input type="radio" name="filter02" value="'.$cf_search_keyword[$k].'" '.($tags==$cf_search_keyword[$k]?"checked":"").'><span></span>#'.$cf_search_keyword[$k].'</label></a></li>';
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
	<div class="_filter03">
		
		<div class="title">가격</div>
		<ul>
			<li onclick="prices(1)"><label class="custom"><input type="radio" name="filter03" value="1" <?php ECHO ($_GET['price']=='1'?"checked":"") ?>><span>6,000원 미만</span></label></li>
			<li onclick="prices(2)"><label class="custom"><input type="radio" name="filter03" value="2" <?php ECHO ($_GET['price']=='2'?"checked":"") ?>><span>6,000원 ~ 10,000원</span></label></li>
			<li onclick="prices(3)"><label class="custom"><input type="radio" name="filter03" value="3" <?php ECHO ($_GET['price']=='3'?"checked":"") ?> ><span>10,000원 ~ 20,000원</span></label></li>
			<li onclick="prices(4)"><label class="custom"><input type="radio" name="filter03" value="4" <?php ECHO ($_GET['price']=='4'?"checked":"") ?>><span>20,000원 이상</span></label></li>
			<!--<li><a href="#" onclick="prices(1)"><label class="radio-wrap"><input type="radio" name="filter03" value="1" <?php ECHO ($_GET['price']=='1'?"checked":"") ?>><span></span>6,000원 미만</label></a></li>
			<li><a href="#" onclick="prices(2)"><label class="radio-wrap"><input type="radio" name="filter03" value="2" <?php ECHO ($_GET['price']=='2'?"checked":"") ?>><span></span>6,000원 ~ 10,000원</label></a></li>
			<li><a href="#" onclick="prices(3)"><label class="radio-wrap"><input type="radio" name="filter03" value="3" <?php ECHO ($_GET['price']=='3'?"checked":"") ?> ><span></span>10,000원 ~ 20,000원</label></a></li>
			<li><a href="#" onclick="prices(4)"><label class="radio-wrap"><input type="radio" name="filter03" value="4" <?php ECHO ($_GET['price']=='4'?"checked":"") ?>><span></span>20,000원 이상</label></a></li>-->
		</ul>		
		
	</div>
</div>


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

function tags(names){
	
	const urlParams = new URLSearchParams(window.location.search);
	
	const entries = urlParams.entries();

	for(entry of entries)  {
		if(entry[0] == 'tags' && entry[1] == names){
		  names = '';
		}
	}

	if(urlParams.has('tags')) {

		urlParams.delete('tags');
		urlParams.set('tags', names);

		location.href="./list.php?"+urlParams;
	}else{

		location.href="./list.php?"+urlParams+"&tags="+names;
	}

}
/*
function price(number){
	const urlParams = new URLSearchParams(window.location.search);


	if(urlParams.has('price')) {

		urlParams.delete('price');
		urlParams.set('price', number);

		location.href="./list.php?"+urlParams;
	}else{

		location.href="./list.php?"+urlParams+"&price="+number;
	}

//	location.href="./list.php?ca_id="+ca1+"&ca_id2="+cat;
}*/

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