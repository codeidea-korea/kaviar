<?php
	include_once(dirname(__DIR__)."/common.php");

	//인기검색어 삭제 , 단위로 잘라서
	$result = sql_fetch("select de_popular_word from `g5_shop_default` ");
	$word = $result['de_popular_word'] ? $result['de_popular_word'] : '';

	if($word != ''){
		$words = explode("," , $word);
		
		for ($y=0; $y<count($words); $y++) {
			
			if($words[$y] != ''){
				
				$sql = " delete from `g5_popular` where pp_word like  '%".$words[$y]."%' ";
				sql_query($sql);	
			}
		}
		
		$sql = " update `g5_shop_default`
					set de_popular_word = '' ";
		sql_query($sql);	
	}

?>