
<script>
$(document).ready(function(){
	$(".fileMake:not(.active)").click(function() {
		var file_path = $(this).attr("data-filepath"),
			data =  {type:"<?=$_filemake_type?>", dir:"<?=$_filemake_dir?>", file_path:file_path, skin:"<?=$_skin?>", file_id:"<?=$_filemake_id?>"};

		$.post("<?=G5_BBS_URL?>/my/file.make.php", data, function (response) {
			alert("파일을 생성했습니다.");
			document.location.reload();
		});
	});
	$(".fileDelete").click(function() {
		if(confirm("정말 삭제하시겠습니까??") == true) {
			var file_path = $(this).attr("data-filepath"),
				data =  {file_path: file_path};
			$.post("<?=G5_BBS_URL?>/my/file.delete.php", data, function (response) {
				document.location.reload();
			});
		} else {
			return false;
		}
	});
});
</script>