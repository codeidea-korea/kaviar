<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="_shop_header_searchContainer">			
	<fieldset>
		<form name="" method="get" action="<?=shop_short_url_my('search')?>">
		<input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
		<input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
		<input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
		<div class="inputContainer">
			<input type="text" name="q" value="<?=$q?$q:''?>" id="dddas" maxlength="30" placeholder="검색어를 입력해주세요" autocomplete='off'>
			<button type="submit" class="btnSubmit" value="검색">검색</button>
		</div>
		</form>		
	</fieldset>
	<div class="hide_searchContainer">
		<div class="sec01">
			<div class="title">최근 검색어<!--<button type="button" class="btnClear">전체 삭제</button>--></div>
			<ul class="new">
				<?php
				//$sql = " select * from {$g5['popular_table']} a order by pp_id desc limit 0, 10 ";
				$sql = "
					SELECT pp_word, MAX(pp_date) as pp_date, pp_ip, MAX(pp_id) as pp_id
					FROM `g5_popular`
					WHERE pp_ip = '".$_SERVER['REMOTE_ADDR']."'
					GROUP BY pp_word, pp_ip
					ORDER BY pp_id DESC
					LIMIT 0, 10;
				";
				$result = sql_query($sql);
				
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$word = get_text($row['pp_word']);
					echo '<li><a href="'.shop_short_url_my('search','','q='.$word).'" class="word">'.$word.'</a><button type="button" class="del" data-pp-id="'.$row['pp_id'].'">삭제</button></li>';
				} ?>
			</ul>
		</div>
		<div class="sec02">
			<div class="title"><?=$config['cf_title']?> 인기검색어&nbsp;<span class="color-mainColor">TOP10</span></div>
			<ul class="hot">
				<?php
				//인기검색어 (기준은 30일전부터 오늘까지 검색어중 랭킹을 얻는다..)
				$to_date = date("Y-m-d");
				$fr_date = date('Y-m-d',strtotime($to_date."-30 day"));
				if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
				if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;
			/*
				$popular_hot_sql_common = " from {$g5['popular_table']} a ";
				$popular_hot_sql_search = " where trim(pp_word) <> '' and pp_date between '{$fr_date}' and '{$to_date}' ";
				$popular_hot_sql_group = " group by pp_word ";
				$popular_hot_sql_order = " order by cnt desc ";
				$popular_hot_sql = " select pp_word, count(*) as cnt {$popular_hot_sql_common} {$popular_hot_sql_search} {$popular_hot_sql_group} {$popular_hot_sql_order} limit 0, 10 ";
				$popular_hot_result = sql_query($popular_hot_sql);

				for ($i=0; $row=sql_fetch_array($popular_hot_result); $i++) {
					$word = get_text($row['pp_word']);
					$rank = $i + 1;
					echo '<li><a href="'.shop_short_url_my('search','','q='.$word).'"><span class="rank">'.$rank.'</span>'.$word.'</a></li>';
				} 
			*/
				for ($g=1; $g <= 10; $g++) {
					if($default['de_popular_'.$g]){
						echo '<li><a href="'.shop_short_url_my('search','','q='.$default['de_popular_'.$g]).'"><span class="rank" style="width:10px">'.$g.'</span>'.$default['de_popular_'.$g].'</a></li>';
					}
				}
			?>
			</ul>			
		</div>
		<div class="sec03">
			<div class="title">추천검색어</div>
			<ul class="reco">
				<?php
				$cf_search_keyword = explode(",",$config['cf_search_keyword']);
				for($k=0; $k<count($cf_search_keyword); $k++) {
					echo '<li><a href="'.shop_short_url_my('search','','q='.$cf_search_keyword[$k]).'" class="keyword">#'.$cf_search_keyword[$k].'</a></li>';
				} ?>
			</ul>			
		</div>
		<?php if($is_admin) echo '<a href="'.$_adm_url.'/?pn=_shop_search_keyword&title=추천검색어" class="btnSetting popWin" data-width="1100" data-height="600" data-top="60" data-left="0" data-area=".hide_searchContainer .sec03">추천검색어</a>';?>
	</div>
	<script>
	window.addEventListener("scroll", (event) => {
		let scrollY = this.scrollY;
		let scrollX = this.scrollX;

		if(scrollY < 1101){
			var id = $(':focus').attr('id');

			if(id == "dddas"){
				$('._shop_header_searchContainer .hide_searchContainer').show();
			}
		}
	});
	

	/*
	if(_scrollTop < 1100){
		
			var id = $(':focus').attr('class');
			alert(id);
	}*/

	$('._shop_header_searchContainer input').click(function() {
		var _scrollTop = window.scrollY || document.documentElement.scrollTop;
		if(_scrollTop < 1100){

			$('._shop_header_searchContainer .hide_searchContainer').hide();
			var hide_searchContainer = $(this).parent().parent().parent().parent().find('.hide_searchContainer');
			hide_searchContainer.show();
		}
	});
	$(document).ready(function(){
		$('html').click(function(e){
			if($(e.target).parents('._shop_header_searchContainer').length < 1){
				$('._shop_header_searchContainer .hide_searchContainer').hide();
			}
		});

		$('.hide_searchContainer .sec01 .del').click(function(e){
			var pp_id = $(this).attr('data-pp-id');
			$.post("<?=G5_THEME_SHOP_URL?>/_popular_list_del.php",{pp_id:pp_id}, function (response) {
				document.location.reload();
				opener.document.location.reload();
			});
		});
	});
	</script>
</div>