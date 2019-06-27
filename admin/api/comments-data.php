<?php 
	// 评论数据返回的接口
	
	require_once '../../functions.php';

	
	// 数据库操作
	$data = xiu_get_data('SELECT 
	comments.*,
	posts.title

 from comments
INNER JOIN posts on comments.post_id=posts.id');

	//转换成JSON

	$json_data=json_encode($data);


	header('content-type:application/json');


	echo $json_data;






 ?>