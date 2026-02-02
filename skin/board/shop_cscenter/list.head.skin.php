<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//$footer_skip = true;


if(!$board['bo_comment_level']) sql_query(" update {$g5['board_table']} set bo_comment_level = 10 where bo_table = '{$bo_table}' ");