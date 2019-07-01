<?php 
	// 评论数据返回的接口
	
	require_once '../../functions.php';

	if (empty($_GET['page'])) {
		exit('传入指定参数');
	}

	$page = intval($_GET['page'])>0?intval($_GET['page']):1;

	$length = 30;

	$offset = ($page-1);



	// 数据库操作
	$sql = sprintf('SELECT 
		comments.*,
		posts.title
		from comments
		INNER JOIN posts on comments.post_id=posts.id
		order by comments.created desc
		limit %d,%d',$offset,$length);


	$data = xiu_get_data($sql);

	//查询数据总量


	$total = xiu_get_data("SELECT COUNT(1) as num from comments

INNER JOIN posts on comments.post_id=posts.id")[0]['num'];



	$total_page = (int)ceil($total/$length);


	//转换成JSON

	$json_data= json_encode(array('total_page'=> $total_page,
		'comment' => $data));


	header('content-type:application/json');


	
	

	echo $json_data;




 ?>