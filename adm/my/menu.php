<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_ADMIN_PATH.'/my/menu.lib.php');
?>

<div id="commonCategory_form" class="tbl_head01">
	<table class="" style="width:100%;">
	<colgroup>
		<col width="90">
		<col width="280">
		<col>
		<col width="120">		
		<col width="70">	
		<col width="114">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">사용여부</th>
		<th scope="col">순서 / 메뉴명</th>
		<th scope="col">링크 (또는 엘럿 메시지) , 팝업일때 -> (url|가로사이즈|세로사이즈|상단위치|좌측위치)</th>
		<th scope="col">링크 옵션</th>
		<th scope="col">노출설정<br/>(권한)</th>
		<th scope="col"><button type="button" onclick="return add_menu();" class="btn btn_02">메뉴추가</button></th>
	</tr>
	</thead>
	<tbody>
	<?php
	echo $list = get_navi_menu();
	?>
	</tbody>
	</table>
</div>



<script>
$(function() {
    $(document).on("click", ".btn_add_submenu", function() {
        var code = $(this).closest("tr").find("input[name='code[]']").val();
        var code2 = $(this).closest("tr").find("input[name='code2[]']").val();
        var chaMenu = $(this).closest("tr").find("input[name='chaMenu[]']").val();
        add_sub_menu(code, code2, chaMenu);
    });

    $(document).on("click", ".btn_del_menu", function() {
        var $tr = $(this).closest("tr");
        if($tr.find("td.sub_menu_class").size() > 0) {
            $tr.remove();
        } else {
			var code2 = $(this).closest("tr").find("input[name='code2[]']").val();
            var chaMenu = $(this).closest("tr").find("input[name='chaMenu[]']").val();
            $("tr.menu_group_"+(chaMenu)+"_"+code2).remove();
        }

        if($("#commonCategory_form tr.menu_list").size() < 1) {
            var list = "<tr id=\"empty_menu_list\"><td colspan=\"<?=$colspan; ?>\" class=\"empty_table\">자료가 없습니다.</td></tr>\n";
            $("#commonCategory_form table tbody").append(list);
        }
    });
});

function add_menu() {	
    var max_code = base_convert(0, 10, 36);
    $("#commonCategory_form tr.menu_list").each(function() {
        var me_code = $(this).find("input[name='code[]']").val().substr(0, 2);
        if(max_code < me_code)
            max_code = me_code;
    });
	/*var max_code2 = base_convert(0, 10, 36);
    $("#commonCategory_form tr.menu_list").each(function() {
        var me_code2 = $(this).find("input[name='code2[]']").val();
        if(max_code2 < me_code2)
            max_code2 = me_code2;
    });*/
	$.post("<?=G5_ADMIN_URL?>/my/menu_list_form.php",{newitem:'new', code:max_code}, function(data) {
		var $menulist = $("#commonCategory_form");
		var $menu_last = null;
		$menu_last = $menulist.find("tr.menu_list:last");
		if($menu_last.size() > 0) {
			$menu_last.after(data);
		} else {
			if($menulist.find("#empty_menu_list").size() > 0)
				$menulist.find("#empty_menu_list").remove();
			$menulist.find("table tbody").append(data);
		}
		$('select').selectpicker('refresh');
	});
}

function add_sub_menu(code, code2, chaMenu) {
	var nextChaMenu = Number(chaMenu) + 1;
	$.post("<?=G5_ADMIN_URL?>/my/menu_list_form.php",{code:code, code2:code2, chaMenu:chaMenu}, function(data) {
		var $menulist = $("#commonCategory_form");
		var $menu_last = null;		
          
		$last_group = $menulist.find("tr[class*='menu_group_"+(nextChaMenu)+"_"+code2+"']:last");
		if($last_group.length) {
			$menu_last = $last_group;
		} else {
			$menu_last = $menulist.find("tr.menu_group_"+(nextChaMenu-1)+"_"+code2+":last");
		}
		$menu_last.after(data);
		$('.selectpicker').selectpicker('refresh');
	});
}

function base_convert(number, frombase, tobase) {
  return parseInt(number + '', frombase | 0)
    .toString(tobase | 0);
}
</script>