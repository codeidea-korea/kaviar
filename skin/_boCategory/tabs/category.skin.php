<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($bo_cate_skin_url.'/'.$css).'">', 3);

if(count($bo_category_list) > 10) {
	$cateStyle .= '.boCateContainer .cate_ul{justify-content:flex-start;}';
	if(!G5_IS_MOBILE) $cateStyle .= '.boCateContainer li{flex:0;min-width:188px;}';
}
?>

<div class="boCateContainer <?=$skin_dir?>" style="<?php if(!G5_IS_MOBILE) echo 'max-width:'.$width?>">
	<?=$boCateSettting?>
	<div class="boCateCon-inner">
		<ul class="cate_ul swiper-wrapper">
			<?php if($all) echo '<li class="'.$totalOn.' swiper-slide"><a href="'.$bo_category_href.'">전체</a>'.$totalCount.'</li>'; ?>
			<?php for ($i=0; $i<count($bo_category_list); $i++) {?>
			<li class="<?=$cateOn[$i]?> swiper-slide" style="z-index:<?=$cateOn[$i]?'20':$i?>">
				<a href="<?=$ca_link[$i]?>"><?=$ca_name[$i]?></a>
				<?=$cateCount[$i]?>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>

<?php if(G5_IS_MOBILE) { ?>
<script>
$('.boCateCon-inner').each(function() {
	var swiperCate = $(this);
	var mySwiper = new Swiper(this, {
		  slidesPerView: 'auto',
		  freeMode: true
	});	
	if(swiperCate.find('.active')) {
		var i = $('.swiper-slide.active').index();
		mySwiper.slideTo(i,0,true);
	}
});
</script>
<?php } ?>