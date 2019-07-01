<?php 

	// ajax删除业务逻辑


	require_once("../../functions.php");


	if (empty($_GET['id'])) {
		exit('请传入指定参数');
	}
	

	$id = $_GET['id'];

	$aff = xiu_update_data("DELETE FROM comments where id IN ( ".$id.")");

	


	header('content-type:application/json');

	echo json_encode($aff>0);



 ?>