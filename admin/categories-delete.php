<?php 

	// 删除业务的逻辑，防止sql注入


	require_once("../functions.php");


	if (empty($_GET['id'])) {
		exit('请传入指定参数');
	}

	if (!is_numeric($_GET['id'])) {
		exit('not a num');
	}

	$id = $_GET['id'];

	$aff = xiu_update_data("DELETE FROM categories where id =".$id);

	if (!$aff>0) {
		exit('ss');
	}


	header('location:/admin/categories.php');



 ?>