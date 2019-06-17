<?php 

	// 删除业务的逻辑，防止sql注入


	require_once("../functions.php");


	if (empty($_GET['id'])) {
		exit('请传入指定参数');
	}
	
	var_dump(!is_array(explode(',',$_GET['id'])));

	if (!is_numeric($_GET['id'])&&!is_array(explode(',',$_GET['id']))) {
		exit('not a num');
	}

	$id = $_GET['id'];

	$aff = xiu_update_data("DELETE FROM categories where id IN ( ".$id.")");

	if (!$aff>0) {
		exit('ss');
	}


	header('location:/admin/categories.php');



 ?>