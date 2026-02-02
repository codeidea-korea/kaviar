<?php
include_once('./_common.php');
$board_skin_path = $_POST['board_skin_path'];
include_once(G5_LIB_PATH.'/my/get_my.lib.php');
include_once($board_skin_path.'/lib/pagemake.write.lib.php');

$layout = $_POST['layout'];
$write['latest_skin'] = $_POST['latest_skin'];

if($layout == 'layout-bg') $write['latest_skin'] = 'basic';
if($layout == 'layout-bigBanner') $write['latest_skin'] = 'bigBanner';

echo '<label class="labelInput mySelect left-label" id="latestSkin"><span class="label">블럭스킨</span>';
echo get_latestSkin_select('latest', 'latest_skin', 'latest_skin', $write['latest_skin'], 'class="selectpicker select-img '.$layout.' span260 mr15" data-id="latestSkin" data-size="5"', true, $layout);
echo '</label>';
