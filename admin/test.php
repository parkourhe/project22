<?php 

$GLOBALS['status_data'] = array('published' => '已发布',
		'drafted' => '草稿',
		'trashed'=>'回收站' );
function xiu_get_status($status){
	

	return isset($GLOBALS['status_data'][$status])?$GLOBALS['status_data'][$status]:"未定义";
} 


$xx = xiu_get_status('drafted');


var_dump($xx);


 ?>