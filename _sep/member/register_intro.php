<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$is_back = true; //뒤로가기
$head_title = '회원가입';
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<div id="register_intro" class="flex column" style="min-height:<?=$_style_min_height?>">
	<div class="flex1 relative">
	
		<div class="px25 pb50 w-full flex column flex-middle flex-center gap20" style="position:absolute;left:0;top:0;width:100%;height:100%;z-index:4;overflow:hidden;">			
			<i class="deco_shape1"></i>
			<i class="deco_shape2"></i>
			<i class="deco_shape3"></i>
			<i class="deco_shape4"></i>
			<i class="deco_shape5"></i>

			<div class="color-mainColor tcenter">
				<p class="fs25 bold">
					안녕하세요.<br>
					<?=$config['cf_title']?> 입니다.
				</p>			
				<p class="fs15 mt15">
					캠핑 문화의 대중화를 위해 최고의 품질을<br>
					부담스럽지 않은 가격대로 서비스를 제공하고자<br>
					남녀노소 누구나 쉽게 캠핑을 즐길 수 있도록<br>
					불철주야로 노력하겠습니다.
				</p>
			</div>

			<a href="./register.php" class="_btn/lg/mainColor/rd/h-55 w-275 mt40">아이디로 시작하기</a>
			
			<?php
			// 소셜로그인 사용시 소셜로그인 버튼
			@include_once(get_social_skin_path().'/social_register.skin.php');
			?>
		</div>
	</div>
	

	<div class="mt-auto">
		<?php echo shop_banner('마이페이지', '_block_banner.skin.php'); ?>
	</div>
</div>

<?php
$footer_skip = true;
include_once(G5_SHOP_PATH.'/shop.tail.php');