<?php
include_once('./_common.php');
//$includers = false;
//if($member['mb_id']=='magma405') $includers = true;

$includers = true;
if($includers) {
    $head_list = array(
        "head.php", "head.sub.php", "tail.php"
    );
	 $lib_list = array(
        ".lib"
    );
	$notlist = array(
         "/data/", "/_common.php", "/common.php", "admminSet.php", "_head.php", "_tail.php", "tail.php", "version.php", "/bbs/visit_insert.inc.php", "/bbs/db_table.optimize.php"
		,"head.php", "head.sub.php"
		,"/lib/", "/popular.skin.php", "/outlogin.skin.2.php", "/_adminSet.php"
        , "config.php", "/extend/", "/plugin/"
        ,"includers_mobile.php"
		,"admin.menu"
    );
    $included_files = get_included_files();
	$included_files = str_replace("\\", "/", $included_files); //역슬래시 치환
    $cnt = count($notlist);
    echo '<ul class="includers" style="display:flex;flex-direction:column;gap:8px;font-family:\'Noto Sans KR\', sans-serif;font-size:12px;line-height:1em;padding:30px;background:rgba(0,0,0,0.02);max-height:calc(100% - 60px);overflow-y:auto;">';
	
	foreach ($included_files as $filename) {
		$tmpname = $filename;
        for($i = 0; $i < count($head_list); $i++) {
			if(strpos($filename,$head_list[$i]) !== false) {
				$tmpname = str_replace(G5_PATH,'',$tmpname);
				echo '<li style="color:rgba(71,78,103,0.6);">'.$tmpname."</li>";
			}
        }
    }

	echo '<li></li>';
	
	echo '<li><span class="ul-toggle" style="font-size:11px;height:18px;padding:0 8px;background:#fff;border:1px solid rgba(0,0,0,0.1);border-radius:10px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;">lib<span style="font-size:10px;transform:scale(0.7);margin-left:3px;color:rgba(71,78,103,0.7);">▼</span></span>';
	echo '<ul class="mt5 none">';
	foreach ($included_files as $filename) {
		$tmpname = $filename;
        for($i = 0; $i < count($lib_list); $i++) {
			if(strpos($filename,$lib_list[$i]) !== false) {
				$tmpname = str_replace(G5_PATH,'',$tmpname);
				echo '<li style="color:#3c85ff;line-height:1.5em;">'.$tmpname."</li>";
			}
        }       
    }
	echo '</ul>';
	echo '</li>';

	echo '<li></li>';

	
	foreach ($included_files as $filename) {
        $pfname = $filename;
        for($i = 0; $i < $cnt; $i++) {
            if(strrpos($filename,$notlist[$i]) !== false){
                $pfname = "";
            }
        }
        if($pfname) {
			$pfname = str_replace(G5_PATH,'',$pfname);
			$point = $now_page = false;
			if(strpos($pfname, '.skin') !== false) $point = true;
			if(
				strpos($pfname, '/bong/mobile/shop/index') !== false
				|| strpos($pfname, '/mobile/shop/cart') !== false
				|| strpos($pfname, '/mobile/shop/list') !== false
				|| strpos($pfname, '/_inc_list') !== false
				|| strpos($pfname, '/mobile/shop/bongCate') !== false
				|| strpos($pfname, '/search.skin.php') !== false
				|| strpos($pfname, '/bong/mobile/shop/mypage') !== false
				|| strpos($pfname, '/point.skin.php') !== false
				|| strpos($pfname, '/bong/mobile/shop/coupon') !== false
				|| strpos($pfname, '/mobile/shop/wishlist') !== false
				|| strpos($pfname, '/mobile/shop/myreply') !== false
				|| strpos($pfname, '/item.form.skin') !== false
				|| strpos($pfname, '/shop/orderform.sub.php') !== false
				|| strpos($pfname, '/mobile/shop/orderinquiryview.php') !== false
				|| strpos($pfname, '/login_main.skin') !== false
				|| strpos($pfname, '/login.skin.php') !== false
				|| strpos($pfname, '/register_main.skin') !== false
				|| strpos($pfname, '/register.skin') !== false
				|| strpos($pfname, '/register_form.skin') !== false
				|| strpos($pfname, '/register_result.skin') !== false
				|| strpos($pfname, '/member_confirm.skin') !== false
				|| strpos($pfname, '/mobile/shop/orderinquiry.sub') !== false
				|| strpos($pfname, '/mobile/shop/customer') !== false
				|| strpos($pfname, '/couponzone.10.skin') !== false
				|| strpos($pfname, '/bongStory') !== false
			) {
				$now_page = $point = true;
			}
			echo '<li '.($point?"style=\"color:#f65454;\"":"").' class="'.($now_page?'now_page':'').'">'.$pfname."</li>";
        }
    }
    echo "</ul>";
}
?>

<script>
$('.ul-toggle').click(function() {
	$(this).next().toggleClass('none');
});

</script>