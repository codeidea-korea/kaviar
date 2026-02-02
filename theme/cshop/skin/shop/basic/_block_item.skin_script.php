<script>
// 상품보관
$('.sit_btn_wish').click(function() {
	var it_id = $(this).attr('data-id');
	location.href = "<?=G5_SHOP_URL?>/wishupdate.php?it_id="+it_id;
});
</script>